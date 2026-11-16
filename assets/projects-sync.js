/* Catálogo automático — mesmo componente visual dos cards originais do portfólio.
 * Nunca substitui texto, ícone ou tags de cards criados manualmente.
 * Somente renderiza repositórios presentes no catálogo público.
 */
(async function () {
  "use strict";

  const container = document.querySelector(".projects-grid");
  if (!container) return;

  let projects;
  try {
    const response = await fetch("assets/projects.json", { cache: "no-store" });
    if (!response.ok) return;
    projects = await response.json();
    if (!Array.isArray(projects)) return;
  } catch (error) {
    console.warn("Catálogo de projetos indisponível:", error);
    return;
  }

  const prefix = "https://github.com/bazzuka-root/";
  const validName = /^[a-z0-9_.-]{1,100}$/i;
  const categories = new Set(["web", "desktop", "iot", "bot", "template"]);
  const byName = new Map();
  for (const p of projects) {
    if (p && typeof p.name === "string" && validName.test(p.name))
      byName.set(p.name.toLowerCase(), p);
  }

  const existing = new Map();
  for (const card of container.querySelectorAll(".proj-card")) {
    const anchor = Array.from(card.querySelectorAll("a[href]")).find(a =>
      a.href.toLowerCase().startsWith(prefix));
    if (!anchor) continue;
    const name = decodeURIComponent(new URL(anchor.href).pathname.split("/").filter(Boolean).pop()).toLowerCase();
    if (existing.has(name)) {
      // Se houver duas entradas por engano, manter a primeira curadoria e não duplicar cards.
      card.remove();
      continue;
    }
    existing.set(name, card);
    if (!byName.has(name)) {
      // Não expor card legado de repositório que deixou de ser público.
      card.remove();
      existing.delete(name);
    }
  }

  const knownIcons = {
    "bazzuka-root": "👨‍💻",
    "portfolio-bazzuka": "🌐",
    "super-central-public": "🧩",
    "votemais-leads": "📊",
    "produ-o-de-v-deos": "🎬",
    "caren-bragagnollo": "🌷",
    "comparou": "⚖️",
    "impulso": "🚀",
    "pdv-local": "🧾",
    "secscan": "🛡️",
    "qa-gestor-projetos-20261116": "🧪"
  };

  const aliases = {
    "javascript": "JavaScript", "typescript": "TypeScript", "python": "Python",
    "php": "PHP", "html": "HTML", "css": "CSS", "c++": "C++",
    "react": "React", "nextjs": "Next.js", "threejs": "Three.js",
    "gsap": "GSAP", "tailwindcss": "Tailwind CSS", "sqlite": "SQLite",
    "mysql": "MySQL", "postgresql": "PostgreSQL", "docker": "Docker",
    "mcp": "MCP", "full-stack": "Full Stack", "ai": "IA",
    "responsive": "Responsivo", "automation": "Automação",
    "portfolio": "Portfólio", "developer-portfolio": "Portfólio",
    "3d-animations": "3D",
    "open-source": "Open Source", "saas": "SaaS", "api": "API",
    "nodejs": "Node.js", "ios": "iOS", "android": "Android",
    "web": "Web", "ocr": "OCR", "esp32": "ESP32", "iot": "IoT",
    "bot": "Bot", "telegram": "Telegram", "whatsapp": "WhatsApp"
  };

  function element(tag, classes, value) {
    const e = document.createElement(tag);
    if (classes) e.className = classes;
    if (value !== undefined) e.textContent = String(value);
    return e;
  }

  function categoryFor(p) {
    const raw = String(p.category || "").toLowerCase();
    const name = p.name.toLowerCase();
    const description = String(p.description || "").toLowerCase();
    if (/esp32|iot|sensor|arduino/.test(name + " " + description)) return "iot";
    if (/template|modelo-de-site/.test(name)) return "template";
    if (/bot|automation|automacao|automação|script|mcp/.test(name)) return "bot";
    if (/limpador.*windows|desktop|windows|launcher/.test(name)) return "desktop";
    return categories.has(raw) ? raw : "web";
  }

  function iconFor(p, category) {
    const slug = p.name.toLowerCase();
    if (knownIcons[slug]) return knownIcons[slug];
    const text = (slug + " " + String(p.description || "")).toLowerCase();
    if (/seguran|scan|security|fraude|golpe/.test(text)) return "🛡️";
    if (/video|vídeo|filme|cinema|clipe/.test(text)) return "🎬";
    if (/finance|pagamento|pdv|pix|caixa|maquininha/.test(text)) return "💳";
    if (/chat|mensage|telegram|whatsapp/.test(text)) return "💬";
    if (/monitor|métrica|analytics|status/.test(text)) return "📡";
    if (/not[a-z]* fiscal|nota fiscal/.test(text)) return "🧾";
    if (/jogo|game|epic/.test(text)) return "🎮";
    if (/site|web|portfolio|portfólio/.test(text)) return "🌐";
    if (/ia|inteligência artificial|saas/.test(text)) return "🤖";
    return { web: "💻", desktop: "🖥️", bot: "⚙️", iot: "📡", template: "🎨" }[category] || "💻";
  }

  function meaningfulDescription(p) {
    const value = String(p.description || "").trim();
    if (value && !/^projeto (?:de código aberto|publicado no github)\.?$/i.test(value))
      return value;
    return "Repositório público no GitHub. Consulte o código-fonte e o README para conhecer os detalhes.";
  }

  function displayName(p) {
    if (p.title && String(p.title).trim()) return p.title.trim();
    const predefined = {
      "bazzuka-root": "BAZZUKA ROOT",
      "portfolio-bazzuka": "Portfólio Bazzuka",
      "produ-o-de-v-deos": "Produção de Vídeos",
      "super-central-public": "Super Central",
      "votemais-leads": "VoteMais Leads",
      "pdv-local": "PDV Local",
      "secscan": "SecScan",
      "qa-gestor-projetos-20261116": "Gestor Bazzuka · Validação"
    };
    return predefined[p.name.toLowerCase()] ||
      p.name.replace(/[-_]+/g, " ").replace(/\b\p{L}/gu, c => c.toLocaleUpperCase("pt-BR"));
  }

  function techTags(p, category) {
    const results = [];
    const add = tag => {
      const key = String(tag || "").trim().toLowerCase();
      if (!key || results.some(t => t.toLowerCase() === key)) return;
      if (results.length < 4 && tag.length < 26) results.push(tag);
    };

    if (typeof p.language === "string") add(p.language);
    if (Array.isArray(p.topics)) {
      // Exibir tecnologias concretas antes de etiquetas genéricas de contexto.
      const priority = ["threejs","gsap","nextjs","react","typescript","javascript",
        "python","php","nodejs","mcp","api","docker","sqlite","mysql","postgresql",
        "tailwindcss","saas","3d-animations","iot","automation","responsive"];
      const ordered = [...p.topics].sort((a,b) => {
        const one=typeof a === "string" ? a : a?.name || "";
        const two=typeof b === "string" ? b : b?.name || "";
        const x=priority.indexOf(one.toLowerCase()), y=priority.indexOf(two.toLowerCase());
        return (x < 0 ? 99 : x) - (y < 0 ? 99 : y);
      });
      for (const item of ordered) {
        const original = typeof item === "string" ? item : item?.name;
        if (typeof original !== "string" || !/^[a-z0-9_.+-]{1,35}$/i.test(original)) continue;
        add(aliases[original.toLowerCase()] ||
          original.replace(/-/g, " ").replace(/\b[a-z]/g, c => c.toUpperCase()));
      }
    }

    // Tecnologia só entra quando consta explicitamente da descrição pública.
    const description = String(p.description || "");
    const clues = [
      [/three\.?js/i, "Three.js"], [/\bgsap\b/i, "GSAP"],
      [/\bnext\.?js\b/i, "Next.js"], [/\breact\b/i, "React"],
      [/\btypescript\b/i, "TypeScript"], [/\bjavascript\b/i, "JavaScript"],
      [/\bpython\b/i, "Python"], [/\bphp\b/i, "PHP"],
      [/\bhtml\b/i, "HTML"], [/\bmcp\b/i, "MCP"],
      [/\bsqlite\b/i, "SQLite"], [/\besp32\b/i, "ESP32"],
      [/\bapi\b/i, "API"], [/\bsaas\b/i, "SaaS"],
      [/\btelegram\b/i, "Telegram"], [/\bwhatsapp\b/i, "WhatsApp"],
      [/\b3d\b/i, "3D"], [/\bia\b/i, "IA"]
    ];
    for (const [expression, tag] of clues) if (expression.test(description)) add(tag);

    // Caso o GitHub não forneça tecnologias, usar etiquetas verdadeiras de contexto.
    if (!results.length) add({
      web: "Projeto web", desktop: "Desktop", bot: "Automação",
      iot: "IoT", template: "Template"
    }[category]);
    if (results.length < 2) add("Código aberto");
    return results;
  }

  function labelFor(p, category) {
    const name = p.name.toLowerCase();
    if (name === "bazzuka-root") return "perfil GitHub";
    if (name === "portfolio-bazzuka") return "portfólio";
    if (name.startsWith("qa-")) return "projeto de teste";
    return { web: "web & SaaS", desktop: "aplicativo",
      bot: "automação", iot: "hardware & IoT", template: "template" }[category];
  }

  const githubSvg = '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18 0 0 1.005-.315 3.3 1.23.765.84 1.23 1.92 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>';
  const externalSvg = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M7 17 17 7M7 7h10v10"/></svg>';

  for (const p of byName.values()) {
    const name = p.name.toLowerCase();
    if (existing.has(name)) {
      // Card original é curadoria manual: manter texto, tags, ícone, categoria e links.
      continue;
    }

    const category = categoryFor(p);
    const card = element("div", "proj-card reveal visible");
    card.dataset.cat = category;
    card.dataset.source = "github-sync";
    card.dataset.repo = name;

    const header = element("div", "proj-card-header");
    header.appendChild(element("span", "proj-icon", iconFor(p, category)));
    const badges = element("div", "proj-badges");
    badges.appendChild(element("span", "badge badge-new", labelFor(p, category)));
    if (p.homepage && /^https:\/\//i.test(p.homepage))
      badges.appendChild(element("span", "badge badge-demo", "demo"));
    header.appendChild(badges);
    card.appendChild(header);

    const body = element("div", "proj-card-body");
    body.appendChild(element("h3", "proj-title", displayName(p)));
    body.appendChild(element("p", "proj-desc", meaningfulDescription(p)));
    const tags = element("div", "proj-tags");
    for (const tag of techTags(p, category))
      tags.appendChild(element("span", "proj-tag", tag));
    body.appendChild(tags);
    card.appendChild(body);

    const footer = element("div", "proj-card-footer");
    const github = element("a", "proj-link proj-link-github");
    github.href = prefix + encodeURIComponent(p.name);
    github.target = "_blank";
    github.rel = "noopener noreferrer";
    github.innerHTML = githubSvg;
    github.appendChild(document.createTextNode("GitHub"));
    footer.appendChild(github);

    if (typeof p.homepage === "string" && /^https:\/\//i.test(p.homepage)) {
      try {
        const destination = new URL(p.homepage);
        if (!destination.username && !destination.password) {
          const demo = element("a", "proj-link proj-link-demo");
          demo.href = destination.href;
          demo.target = "_blank";
          demo.rel = "noopener noreferrer";
          demo.innerHTML = externalSvg;
          demo.appendChild(document.createTextNode("Ver projeto"));
          footer.appendChild(demo);
        }
      } catch (_) {}
    }

    card.appendChild(footer);
    container.appendChild(card);
    existing.set(name, card);
  }

  const counter = document.querySelector("[data-count-proj]");
  if (counter) {
    const count = container.querySelectorAll(".proj-card").length;
    counter.dataset.count = String(count);
    counter.textContent = count + "+";
  }

  function applyCurrentFilter() {
    const current = document.querySelector(".filter-btn.active")?.dataset.filter || "all";
    for (const card of container.querySelectorAll(".proj-card"))
      card.classList.toggle("hidden", current !== "all" && card.dataset.cat !== current);
  }

  for (const button of document.querySelectorAll(".filter-btn"))
    button.addEventListener("click", () => queueMicrotask(applyCurrentFilter));
  applyCurrentFilter();
})();
