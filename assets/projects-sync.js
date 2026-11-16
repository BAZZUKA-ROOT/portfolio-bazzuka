/* Extensão não destrutiva do portfólio Bazzuka; mantém cards existentes. */
(async function () {
  "use strict";
  const container = document.querySelector(".projects-grid");
  if (!container) return;
  let repos;
  try {
    const response = await fetch("assets/projects.json", { cache: "no-store" });
    if (!response.ok) return;
    repos = await response.json();
    if (!Array.isArray(repos)) return;
  } catch (_) { return; }
  const githubPrefix = "https://github.com/bazzuka-root/";
  const existing = new Map();
  for (const card of container.querySelectorAll(".proj-card")) {
    const a = Array.from(card.querySelectorAll("a[href]")).find(a =>
      a.href.toLowerCase().startsWith(githubPrefix));
    if (a) existing.set(a.href.split("/").filter(Boolean).pop().toLowerCase(), card);
  }
  // A vitrine pública só exibe repositórios que constam no catálogo público.
  const publicRepos = new Set(repos.filter(p => p && typeof p.name === "string")
    .map(p => p.name.toLowerCase()));
  for (const [slug, card] of existing) {
    if (!publicRepos.has(slug)) {
      card.remove();
      existing.delete(slug);
    }
  }
  function element(tag, className, text) {
    const e = document.createElement(tag);
    if (className) e.className = className;
    if (text !== undefined) e.textContent = text;
    return e;
  }
  for (const project of repos) {
    if (!project || typeof project.name !== "string" ||
        !/^[a-z0-9_.-]+$/i.test(project.name)) continue;
    const repo = project.name.toLowerCase();
    const url = githubPrefix + encodeURIComponent(project.name);
    let card = existing.get(repo);
    if (card) {
      if (project.title) {
        const h = card.querySelector(".proj-title");
        if (h) h.textContent = project.title;
      }
      if (project.description) {
        const description = card.querySelector(".proj-desc");
        if (description) description.textContent = project.description;
      }
      const categories = new Set(["web", "desktop", "iot", "bot", "template"]);
      if (categories.has(project.category)) card.dataset.cat = project.category;
      continue;
    }
    card = element("div", "proj-card reveal visible");
    const categories = new Set(["web", "desktop", "iot", "bot", "template"]);
    card.dataset.cat = categories.has(project.category) ? project.category : "web";
    const header = element("div", "proj-card-header");
    header.appendChild(element("span", "proj-icon", "◈"));
    const badges = element("div", "proj-badges");
    badges.appendChild(element("span", "badge badge-new", "GitHub"));
    header.appendChild(badges);
    card.appendChild(header);
    const body = element("div", "proj-card-body");
    const name = project.title || project.name.replace(/[-_]/g, " ");
    body.appendChild(element("h3", "proj-title", name));
    body.appendChild(element("p", "proj-desc",
      project.description || "Projeto publicado no GitHub."));
    card.appendChild(body);
    const footer = element("div", "proj-card-footer");
    const github = element("a", "proj-link proj-link-github", "GitHub");
    github.href = url; github.target = "_blank"; github.rel = "noopener noreferrer";
    footer.appendChild(github);
    if (typeof project.homepage === "string" && /^https:\/\//i.test(project.homepage)) {
      const demo = element("a", "proj-link proj-link-demo", "Abrir projeto");
      demo.href = project.homepage; demo.target = "_blank"; demo.rel = "noopener noreferrer";
      footer.appendChild(demo);
    }
    card.appendChild(footer);
    container.appendChild(card);
    existing.set(repo, card);
  }
  const total = document.querySelector("[data-count-proj]");
  if (total) {
    total.dataset.count = String(container.querySelectorAll(".proj-card").length);
    total.textContent = total.dataset.count + "+";
  }
  function applyCurrentFilter() {
    const filter = document.querySelector(".filter-btn.active")?.dataset.filter || "all";
    container.querySelectorAll(".proj-card").forEach(card =>
      card.classList.toggle("hidden", filter !== "all" && card.dataset.cat !== filter));
  }
  document.querySelectorAll(".filter-btn").forEach(button => {
    button.addEventListener("click", () => queueMicrotask(applyCurrentFilter));
  });
  applyCurrentFilter();
})();
