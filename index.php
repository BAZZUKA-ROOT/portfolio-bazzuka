<?php $year = date('Y'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bazzuka · Full-stack Developer</title>
<meta name="description" content="Bazzuka — Desenvolvedor Full-stack especialista em PHP, Python, Node.js, IoT e automação. Construo ferramentas que resolvem problemas reais.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
<style>
:root{
  --bg:#05050f;
  --bg2:#09091a;
  --card:#0f0f20;
  --card2:#13132a;
  --border:rgba(124,58,237,.2);
  --border-h:rgba(168,85,247,.5);
  --purple:#7C3AED;
  --purple2:#A855F7;
  --pink:#EC4899;
  --cyan:#06B6D4;
  --green:#10B981;
  --text:#e2e8f0;
  --muted:#8892a4;
  --glow:0 0 60px rgba(124,58,237,.35);
  --glow2:0 0 30px rgba(168,85,247,.25);
}
*{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{font-family:'Space Grotesk',sans-serif;background:var(--bg);color:var(--text);overflow-x:hidden;cursor:none}

/* ── CUSTOM CURSOR ── */
#cursor{position:fixed;width:12px;height:12px;background:var(--purple2);border-radius:50%;pointer-events:none;z-index:9999;mix-blend-mode:screen;transition:transform .15s,opacity .15s;transform:translate(-50%,-50%)}
#cursor-ring{position:fixed;width:40px;height:40px;border:1.5px solid rgba(168,85,247,.6);border-radius:50%;pointer-events:none;z-index:9998;transform:translate(-50%,-50%);transition:width .3s,height .3s,border-color .3s}
body:not(.cursor-active) #cursor,body:not(.cursor-active) #cursor-ring{display:none}
.cursor-hover #cursor{transform:translate(-50%,-50%) scale(2.5);opacity:.6}
.cursor-hover #cursor-ring{width:60px;height:60px;border-color:rgba(168,85,247,.3)}

/* ── LOADING SCREEN ── */
#loader{position:fixed;inset:0;z-index:9000;background:var(--bg);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:24px;transition:opacity .6s,visibility .6s}
#loader.done{opacity:0;visibility:hidden}
.loader-logo{font-family:'JetBrains Mono',monospace;font-size:2.5rem;font-weight:700;color:var(--purple2);letter-spacing:.05em;animation:loaderPulse 1s ease-in-out infinite}
.loader-bar{width:200px;height:3px;background:rgba(124,58,237,.2);border-radius:2px;overflow:hidden}
.loader-fill{height:100%;background:linear-gradient(90deg,var(--purple),var(--purple2),var(--pink));border-radius:2px;animation:loaderFill 1.8s ease-out forwards}
@keyframes loaderPulse{0%,100%{opacity:.6}50%{opacity:1}}
@keyframes loaderFill{0%{width:0}100%{width:100%}}

/* ── SCROLLBAR ── */
::-webkit-scrollbar{width:4px}
::-webkit-scrollbar-track{background:var(--bg)}
::-webkit-scrollbar-thumb{background:linear-gradient(var(--purple),var(--purple2));border-radius:2px}

/* ── NAV ── */
nav{position:fixed;top:0;left:0;right:0;z-index:1000;padding:18px 48px;display:flex;align-items:center;justify-content:space-between;backdrop-filter:blur(24px) saturate(180%);background:rgba(5,5,15,.6);border-bottom:1px solid var(--border);transition:.3s}
.nav-logo{font-family:'JetBrains Mono',monospace;font-weight:700;font-size:1.1rem;color:var(--purple2);letter-spacing:.05em;text-decoration:none}
.nav-logo span{color:var(--text)}
.nav-links{display:flex;gap:36px;list-style:none}
.nav-links a{color:var(--muted);text-decoration:none;font-size:.875rem;font-weight:500;transition:.25s;position:relative;padding:4px 0}
.nav-links a::after{content:'';position:absolute;bottom:-2px;left:0;width:0;height:1px;background:linear-gradient(90deg,var(--purple2),var(--pink));transition:.3s}
.nav-links a:hover{color:var(--text)}
.nav-links a:hover::after{width:100%}
.nav-cta{background:linear-gradient(135deg,var(--purple),var(--purple2));color:#fff;padding:10px 24px;border-radius:50px;font-size:.85rem;font-weight:600;text-decoration:none;transition:.3s;position:relative;overflow:hidden}
.nav-cta::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,var(--purple2),var(--pink));opacity:0;transition:.3s}
.nav-cta:hover::before{opacity:1}
.nav-cta span{position:relative;z-index:1}
.nav-cta:hover{transform:translateY(-2px);box-shadow:0 10px 30px rgba(124,58,237,.6)}
.hamburger{display:none;flex-direction:column;gap:5px;cursor:pointer;padding:4px;background:none;border:none}
.hamburger span{width:24px;height:2px;background:var(--text);border-radius:2px;transition:.35s;display:block}
.hamburger.open span:nth-child(1){transform:rotate(45deg) translate(5px,5px)}
.hamburger.open span:nth-child(2){opacity:0;transform:scaleX(0)}
.hamburger.open span:nth-child(3){transform:rotate(-45deg) translate(5px,-5px)}

/* ── HERO ── */
#hero{position:relative;min-height:100vh;display:flex;align-items:center;justify-content:center;overflow:hidden}
#three-canvas{position:absolute;inset:0;z-index:0}
.aurora{position:absolute;inset:0;z-index:0;overflow:hidden;pointer-events:none}
.aurora::before{content:'';position:absolute;width:800px;height:800px;top:-200px;left:-200px;background:radial-gradient(ellipse,rgba(124,58,237,.15) 0%,transparent 70%);animation:auroraMove1 15s ease-in-out infinite alternate;border-radius:50%}
.aurora::after{content:'';position:absolute;width:600px;height:600px;bottom:-100px;right:-100px;background:radial-gradient(ellipse,rgba(236,72,153,.1) 0%,transparent 70%);animation:auroraMove2 12s ease-in-out infinite alternate;border-radius:50%}
@keyframes auroraMove1{0%{transform:translate(0,0) scale(1)}100%{transform:translate(150px,80px) scale(1.3)}}
@keyframes auroraMove2{0%{transform:translate(0,0) scale(1)}100%{transform:translate(-100px,-60px) scale(1.2)}}
.hero-content{position:relative;z-index:1;text-align:center;padding:0 20px;max-width:900px;display:flex;flex-direction:column;align-items:center}
.hero-tag{display:inline-flex;align-items:center;gap:10px;background:rgba(124,58,237,.12);border:1px solid rgba(124,58,237,.3);border-radius:50px;padding:8px 22px;font-size:.78rem;color:var(--purple2);margin:0 auto 32px;font-family:'JetBrains Mono',monospace;backdrop-filter:blur(8px);width:fit-content}
.hero-tag .dot{width:8px;height:8px;border-radius:50%;background:var(--green);box-shadow:0 0 10px var(--green);animation:ping 2s cubic-bezier(0,0,.2,1) infinite}
@keyframes ping{0%{box-shadow:0 0 0 0 rgba(16,185,129,.8)}100%{box-shadow:0 0 0 10px rgba(16,185,129,0)}}
.hero-name{font-size:clamp(4.5rem,11vw,9rem);font-weight:700;line-height:.95;letter-spacing:-.04em;margin-bottom:16px;position:relative;display:block;text-align:center;width:100%}
.hero-name-inner{background:linear-gradient(135deg,#fff 20%,var(--purple2) 55%,var(--pink) 85%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.glitch{position:relative;display:inline-block}
.glitch::before,.glitch::after{content:attr(data-text);position:absolute;top:0;left:0;background:linear-gradient(135deg,#fff 20%,var(--purple2) 55%,var(--pink) 85%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.glitch::before{animation:glitch1 4s infinite;clip-path:polygon(0 35%,100% 35%,100% 55%,0 55%)}
.glitch::after{animation:glitch2 4s infinite;clip-path:polygon(0 65%,100% 65%,100% 80%,0 80%)}
@keyframes glitch1{0%,88%,100%{transform:none;opacity:0}89%{transform:translateX(-4px) skewX(-2deg);opacity:.9}91%{transform:translateX(4px);opacity:.5}93%{transform:none;opacity:0}}
@keyframes glitch2{0%,82%,100%{transform:none;opacity:0}83%{transform:translateX(4px) skewX(2deg);opacity:.9}85%{transform:translateX(-3px);opacity:.4}87%{transform:none;opacity:0}}
.hero-subtitle{font-family:'JetBrains Mono',monospace;font-size:clamp(.95rem,2.2vw,1.3rem);color:var(--purple2);margin-bottom:24px;min-height:2.2em;display:flex;align-items:center;justify-content:center;gap:8px}
.cursor-blink{width:2px;height:1.2em;background:var(--purple2);animation:blink .9s step-end infinite;display:inline-block}
@keyframes blink{0%,100%{opacity:1}50%{opacity:0}}
.hero-desc{font-size:1.05rem;color:var(--muted);max-width:540px;margin:0 auto 44px;line-height:1.75}
.hero-btns{display:flex;gap:16px;justify-content:center;flex-wrap:wrap}
.btn-primary{background:linear-gradient(135deg,var(--purple),var(--purple2));color:#fff;padding:15px 36px;border-radius:50px;font-size:.95rem;font-weight:600;text-decoration:none;transition:.3s;display:inline-flex;align-items:center;gap:10px;position:relative;overflow:hidden}
.btn-primary::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,var(--purple2),var(--pink));opacity:0;transition:.4s}
.btn-primary:hover::before{opacity:1}
.btn-primary span,.btn-primary svg{position:relative;z-index:1}
.btn-primary:hover{transform:translateY(-3px);box-shadow:0 16px 40px rgba(124,58,237,.65)}
.btn-outline{background:rgba(255,255,255,.03);color:var(--text);padding:15px 36px;border-radius:50px;font-size:.95rem;font-weight:600;text-decoration:none;transition:.3s;border:1px solid rgba(255,255,255,.12);display:inline-flex;align-items:center;gap:10px;backdrop-filter:blur(8px)}
.btn-outline:hover{border-color:var(--purple2);color:var(--purple2);transform:translateY(-3px);background:rgba(124,58,237,.08)}
.hero-scroll{position:absolute;bottom:36px;left:50%;transform:translateX(-50%);display:flex;flex-direction:column;align-items:center;gap:10px;color:var(--muted);font-size:.75rem;font-family:'JetBrains Mono',monospace;letter-spacing:.1em;animation:scrollBob 2.5s ease-in-out infinite}
@keyframes scrollBob{0%,100%{transform:translateX(-50%) translateY(0);opacity:.6}50%{transform:translateX(-50%) translateY(-6px);opacity:1}}
.scroll-line{width:1px;height:40px;background:linear-gradient(var(--purple2),transparent);animation:scrollLine 2.5s ease-in-out infinite}
@keyframes scrollLine{0%{height:0;opacity:0}50%{height:40px;opacity:1}100%{height:40px;opacity:0}}

/* ── ABOUT ── */
#about{display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center;max-width:1200px;margin:0 auto;padding:140px 48px}
.about-text .section-desc{max-width:100%}
.about-stats{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:40px}
.stat-card{background:var(--card);border:1px solid var(--border);border-radius:16px;padding:24px;text-align:center;transition:.35s;position:relative;overflow:hidden}
.stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--purple2),transparent);transform:scaleX(0);transition:.4s}
.stat-card:hover::before{transform:scaleX(1)}
.stat-card:hover{border-color:rgba(168,85,247,.4);transform:translateY(-4px);box-shadow:var(--glow2)}
.stat-num{font-size:2.4rem;font-weight:700;background:linear-gradient(135deg,var(--purple2),var(--pink));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.stat-label{color:var(--muted);font-size:.82rem;margin-top:4px;font-family:'JetBrains Mono',monospace}
.about-visual{position:relative;display:flex;justify-content:center;align-items:center}
.hex-container{position:relative;width:320px;height:320px}
.hex-avatar{width:100%;height:100%;background:linear-gradient(135deg,var(--purple),var(--purple2),var(--pink));clip-path:polygon(50% 0%,93% 25%,93% 75%,50% 100%,7% 75%,7% 25%);display:flex;align-items:center;justify-content:center;position:relative}
.hex-avatar::before{content:'';position:absolute;inset:3px;background:var(--card2);clip-path:polygon(50% 0%,93% 25%,93% 75%,50% 100%,7% 75%,7% 25%);z-index:1}
.hex-avatar-emoji{position:relative;z-index:2;font-size:7rem;filter:drop-shadow(0 0 20px rgba(168,85,247,.5))}
.hex-ring{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);border:1px solid rgba(124,58,237,.2);border-radius:50%;animation:hexOrbit linear infinite}
.hex-ring:nth-child(2){width:380px;height:380px;animation-duration:14s}
.hex-ring:nth-child(3){width:460px;height:460px;animation-duration:20s;animation-direction:reverse}
.hex-ring:nth-child(4){width:540px;height:540px;animation-duration:28s}
.orbit-pip{width:10px;height:10px;border-radius:50%;position:absolute;top:-5px;left:50%;transform:translateX(-50%)}
.orbit-pip.p{background:var(--purple2);box-shadow:0 0 12px var(--purple2)}
.orbit-pip.pk{background:var(--pink);box-shadow:0 0 12px var(--pink)}
.orbit-pip.c{background:var(--cyan);box-shadow:0 0 12px var(--cyan)}
@keyframes hexOrbit{from{transform:translate(-50%,-50%) rotate(0deg)}to{transform:translate(-50%,-50%) rotate(360deg)}}

/* ── SECTIONS COMMON ── */
.section-wrap{max-width:1200px;margin:0 auto;padding:120px 48px}
.section-label{font-family:'JetBrains Mono',monospace;font-size:.75rem;color:var(--purple2);letter-spacing:.25em;text-transform:uppercase;margin-bottom:14px;display:flex;align-items:center;gap:10px}
.section-label::before{content:'';width:24px;height:1px;background:var(--purple2)}
.section-title{font-size:clamp(2.2rem,4.5vw,3.2rem);font-weight:700;line-height:1.15;margin-bottom:18px}
.section-title span{background:linear-gradient(135deg,var(--purple2),var(--pink));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.section-desc{color:var(--muted);font-size:1rem;max-width:540px;line-height:1.8}

/* ── SKILLS ── */
.skills-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:16px;margin-top:56px}
.skill-card{background:var(--card);border:1px solid var(--border);border-radius:16px;padding:26px 18px;text-align:center;transition:.4s;cursor:default;position:relative;overflow:hidden;transform-style:preserve-3d}
.skill-card::after{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(124,58,237,.08),rgba(168,85,247,.04));opacity:0;transition:.4s;border-radius:16px}
.skill-card:hover::after{opacity:1}
.skill-card:hover{border-color:rgba(168,85,247,.45);box-shadow:0 16px 40px rgba(124,58,237,.2),inset 0 1px 0 rgba(168,85,247,.1)}
.skill-icon{font-size:2.4rem;margin-bottom:12px;display:block;transition:.4s}
.skill-card:hover .skill-icon{transform:translateY(-4px) scale(1.1);filter:drop-shadow(0 4px 12px rgba(168,85,247,.5))}
.skill-name{font-weight:600;font-size:.9rem;margin-bottom:6px}
.skill-bar{height:3px;background:rgba(124,58,237,.15);border-radius:2px;overflow:hidden;margin-top:8px}
.skill-fill{height:100%;background:linear-gradient(90deg,var(--purple),var(--purple2));border-radius:2px;transform:scaleX(0);transform-origin:left;transition:transform 1.2s cubic-bezier(.16,1,.3,1)}
.skill-card.in-view .skill-fill{transform:scaleX(1)}

/* ── PROJECTS ── */
.filter-bar{display:flex;gap:8px;flex-wrap:wrap;margin:44px 0 52px}
.filter-btn{background:rgba(255,255,255,.03);border:1px solid var(--border);color:var(--muted);padding:9px 22px;border-radius:50px;font-size:.82rem;cursor:pointer;transition:.3s;font-family:'Space Grotesk',sans-serif;font-weight:500;backdrop-filter:blur(4px)}
.filter-btn:hover{border-color:rgba(168,85,247,.4);color:var(--text);background:rgba(124,58,237,.08)}
.filter-btn.active{background:linear-gradient(135deg,var(--purple),var(--purple2));border-color:transparent;color:#fff;box-shadow:0 4px 20px rgba(124,58,237,.4)}
.projects-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:22px}
.proj-card{background:var(--card);border:1px solid var(--border);border-radius:20px;overflow:hidden;transition:.4s;position:relative;cursor:pointer;display:flex;flex-direction:column;transform-style:preserve-3d}
.proj-card::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(124,58,237,.06),rgba(168,85,247,.03));opacity:0;transition:.4s;z-index:0}
.proj-card:hover::before{opacity:1}
.proj-card:hover{border-color:rgba(168,85,247,.4);box-shadow:0 24px 60px rgba(124,58,237,.2),0 0 0 1px rgba(168,85,247,.1)}
.proj-card-header{padding:26px 26px 0;display:flex;align-items:flex-start;justify-content:space-between;gap:12px;position:relative;z-index:1}
.proj-icon{font-size:2.6rem;line-height:1;transition:.3s}
.proj-card:hover .proj-icon{transform:scale(1.15) rotate(-5deg);filter:drop-shadow(0 4px 14px rgba(168,85,247,.5))}
.proj-badges{display:flex;gap:6px;flex-wrap:wrap}
.badge{padding:3px 10px;border-radius:6px;font-size:.68rem;font-weight:700;font-family:'JetBrains Mono',monospace;letter-spacing:.05em}
.badge-new{background:rgba(16,185,129,.12);color:var(--green);border:1px solid rgba(16,185,129,.25)}
.badge-demo{background:rgba(124,58,237,.12);color:var(--purple2);border:1px solid rgba(124,58,237,.25)}
.proj-card-body{padding:18px 26px;flex:1;position:relative;z-index:1}
.proj-title{font-size:1.15rem;font-weight:700;margin-bottom:10px}
.proj-desc{color:var(--muted);font-size:.875rem;line-height:1.65}
.proj-tags{display:flex;flex-wrap:wrap;gap:6px;margin-top:16px}
.proj-tag{background:rgba(124,58,237,.08);color:rgba(168,85,247,.85);padding:3px 10px;border-radius:5px;font-size:.7rem;font-family:'JetBrains Mono',monospace;border:1px solid rgba(124,58,237,.18)}
.proj-card-footer{padding:18px 26px;border-top:1px solid rgba(124,58,237,.1);display:flex;gap:10px;position:relative;z-index:1}
.proj-link{flex:1;text-align:center;padding:10px;border-radius:10px;font-size:.8rem;font-weight:600;text-decoration:none;transition:.3s;display:flex;align-items:center;justify-content:center;gap:6px}
.proj-link-github{background:rgba(255,255,255,.04);color:var(--text);border:1px solid rgba(255,255,255,.08)}
.proj-link-github:hover{background:rgba(255,255,255,.09);border-color:rgba(255,255,255,.25)}
.proj-link-demo{background:linear-gradient(135deg,var(--purple),var(--purple2));color:#fff}
.proj-link-demo:hover{box-shadow:0 8px 24px rgba(124,58,237,.55);transform:translateY(-1px)}
.proj-card.hidden{display:none}

/* ── CONTACT ── */
.contact-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:18px;margin-top:56px}
.contact-card{background:var(--card);border:1px solid var(--border);border-radius:20px;padding:36px 20px;text-decoration:none;color:var(--text);transition:.4s;display:flex;flex-direction:column;align-items:center;gap:14px;position:relative;overflow:hidden}
.contact-card::before{content:'';position:absolute;bottom:-60px;left:50%;transform:translateX(-50%);width:120px;height:120px;border-radius:50%;filter:blur(30px);opacity:0;transition:.5s}
.contact-card:hover::before{opacity:.4;bottom:-20px}
.contact-card.wpp::before{background:#25D366}
.contact-card.ig::before{background:#E1306C}
.contact-card.gh::before{background:#a0a0a0}
.contact-card.mail::before{background:#EA4335}
.contact-card:hover{transform:translateY(-8px)}
.contact-card.wpp:hover{border-color:rgba(37,211,102,.4);box-shadow:0 20px 50px rgba(37,211,102,.15)}
.contact-card.ig:hover{border-color:rgba(225,48,108,.4);box-shadow:0 20px 50px rgba(225,48,108,.15)}
.contact-card.gh:hover{border-color:rgba(200,200,200,.3);box-shadow:0 20px 50px rgba(200,200,200,.08)}
.contact-card.mail:hover{border-color:rgba(234,67,53,.4);box-shadow:0 20px 50px rgba(234,67,53,.15)}
.contact-icon{width:60px;height:60px;border-radius:18px;display:flex;align-items:center;justify-content:center;font-size:1.7rem;transition:.4s}
.contact-card:hover .contact-icon{transform:scale(1.1) rotate(-5deg)}
.contact-icon.wpp{background:rgba(37,211,102,.12);border:1px solid rgba(37,211,102,.2)}
.contact-icon.ig{background:rgba(225,48,108,.12);border:1px solid rgba(225,48,108,.2)}
.contact-icon.gh{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1)}
.contact-icon.mail{background:rgba(234,67,53,.12);border:1px solid rgba(234,67,53,.2)}
.contact-name{font-weight:700;font-size:1rem}
.contact-val{color:var(--muted);font-size:.82rem;font-family:'JetBrains Mono',monospace}

/* ── FOOTER ── */
footer{border-top:1px solid var(--border);padding:48px;text-align:center;color:var(--muted);font-size:.85rem}
footer strong{color:var(--purple2)}
footer a{color:var(--purple2);text-decoration:none;transition:.2s}
footer a:hover{color:var(--pink)}

/* ── DIVIDERS ── */
.section-divider{max-width:1200px;margin:0 auto;padding:0 48px}
.section-divider hr{border:none;height:1px;background:linear-gradient(90deg,transparent,var(--border),transparent)}

/* ── REVEAL ── */
.reveal{opacity:0;transform:translateY(35px);transition:.9s cubic-bezier(.16,1,.3,1)}
.reveal.visible{opacity:1;transform:none}
.reveal-left{opacity:0;transform:translateX(-40px);transition:.9s cubic-bezier(.16,1,.3,1)}
.reveal-left.visible{opacity:1;transform:none}
.reveal-right{opacity:0;transform:translateX(40px);transition:.9s cubic-bezier(.16,1,.3,1)}
.reveal-right.visible{opacity:1;transform:none}

/* ── RIPPLE ── */
.ripple{position:absolute;border-radius:50%;background:rgba(168,85,247,.3);pointer-events:none;animation:rippleAnim .6s ease-out forwards}
@keyframes rippleAnim{0%{transform:scale(0);opacity:1}100%{transform:scale(4);opacity:0}}

/* ── MOBILE ── */
@media(max-width:1024px){
  #about{grid-template-columns:1fr;gap:56px;padding:100px 32px}
  .about-visual{display:none}
}
@media(max-width:768px){
  nav{padding:16px 20px}
  .nav-links,.nav-cta{display:none}
  .nav-links.open{display:flex;flex-direction:column;position:fixed;top:60px;left:0;right:0;background:rgba(5,5,15,.98);backdrop-filter:blur(24px);padding:28px 24px;gap:22px;border-bottom:1px solid var(--border)}
  .hamburger{display:flex}
  .section-wrap{padding:90px 20px}
  #about{padding:90px 20px}
  .projects-grid{grid-template-columns:1fr}
  .hero-btns{flex-direction:column;align-items:center;gap:12px}
  .btn-primary,.btn-outline{width:100%;max-width:280px;justify-content:center}
  #cursor,#cursor-ring{display:none!important}
  body{cursor:auto}
  .contact-grid{grid-template-columns:1fr 1fr}
}
@media(max-width:480px){
  .about-stats{grid-template-columns:1fr 1fr}
  .skills-grid{grid-template-columns:repeat(3,1fr);gap:10px}
  .skill-card{padding:18px 10px}
  .skill-icon{font-size:1.8rem}
  .contact-grid{grid-template-columns:1fr}
}
</style>
</head>
<body class="cursor-active">

<!-- CURSOR -->
<div id="cursor"></div>
<div id="cursor-ring"></div>

<!-- LOADER -->
<div id="loader">
  <div class="loader-logo">&lt;BZK/&gt;</div>
  <div class="loader-bar"><div class="loader-fill"></div></div>
</div>

<!-- NAV -->
<nav id="navbar">
  <a href="#" class="nav-logo">&lt; <span>Bazzuka</span> /&gt;</a>
  <ul class="nav-links" id="navLinks">
    <li><a href="#about">Sobre</a></li>
    <li><a href="#skills">Skills</a></li>
    <li><a href="#projects">Projetos</a></li>
    <li><a href="#contact">Contato</a></li>
  </ul>
  <a href="https://wa.me/5544998458841" target="_blank" class="nav-cta"><span>💬 WhatsApp</span></a>
  <button class="hamburger" id="hamburger" onclick="toggleMenu()" aria-label="Menu">
    <span></span><span></span><span></span>
  </button>
</nav>

<!-- HERO -->
<section id="hero">
  <div class="aurora"></div>
  <canvas id="three-canvas"></canvas>
  <div class="hero-content">
    <div class="hero-tag"><div class="dot"></div>Disponível para projetos</div>
    <h1 class="hero-name">
      <span class="hero-name-inner glitch" data-text="Bazzuka">Bazzuka</span>
    </h1>
    <p class="hero-subtitle" id="typewriter"><span class="cursor-blink"></span></p>
    <p class="hero-desc">Construo ferramentas que resolvem problemas reais — do ESP32 ao SaaS, do PDV ao bot com IA. Código que funciona na prática.</p>
    <div class="hero-btns">
      <a href="#projects" class="btn-primary">
        <span>🚀 Ver Projetos</span>
      </a>
      <a href="https://github.com/BAZZUKA-ROOT" target="_blank" class="btn-outline">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>
        GitHub
      </a>
    </div>
  </div>
  <div class="hero-scroll">
    <div class="scroll-line"></div>
    <span>scroll</span>
  </div>
</section>

<!-- ABOUT -->
<div id="about">
  <div class="about-text">
    <p class="section-label reveal-left">// sobre mim</p>
    <h2 class="section-title reveal-left">Desenvolvimento que <span>resolve de verdade</span></h2>
    <p class="section-desc reveal-left" style="margin-bottom:16px">Sou desenvolvedor full-stack focado em soluções práticas — sistemas para pequenas empresas, automações, IoT e aplicações web que realmente funcionam.</p>
    <p class="section-desc reveal-left">Trabalho com PHP, Python, Node.js, JavaScript, Electron, React e C++ para ESP32. Cada projeto nasce de um problema real.</p>
    <div class="about-stats">
      <div class="stat-card reveal"><div class="stat-num" data-count="17">0</div><div class="stat-label">Projetos no GitHub</div></div>
      <div class="stat-card reveal"><div class="stat-num" data-count="5">0</div><div class="stat-label">Linguagens ativas</div></div>
      <div class="stat-card reveal"><div class="stat-num">IoT</div><div class="stat-label">ESP32 & Arduino</div></div>
      <div class="stat-card reveal"><div class="stat-num">SaaS</div><div class="stat-label">Web & Desktop</div></div>
    </div>
  </div>
  <div class="about-visual reveal-right">
    <div class="hex-container">
      <div class="hex-ring"><div class="orbit-pip p"></div></div>
      <div class="hex-ring"><div class="orbit-pip pk"></div></div>
      <div class="hex-ring"><div class="orbit-pip c"></div></div>
      <div class="hex-avatar"><div class="hex-avatar-emoji">🧑‍💻</div></div>
    </div>
  </div>
</div>

<div class="section-divider"><hr></div>

<!-- SKILLS -->
<div class="section-wrap" id="skills">
  <p class="section-label reveal">// habilidades</p>
  <h2 class="section-title reveal">Minha <span>Stack</span></h2>
  <div class="skills-grid">
    <div class="skill-card reveal"><span class="skill-icon">🐘</span><div class="skill-name">PHP</div><div class="skill-bar"><div class="skill-fill" style="--w:.92"></div></div></div>
    <div class="skill-card reveal"><span class="skill-icon">🐍</span><div class="skill-name">Python</div><div class="skill-bar"><div class="skill-fill" style="--w:.88"></div></div></div>
    <div class="skill-card reveal"><span class="skill-icon">🟨</span><div class="skill-name">JavaScript</div><div class="skill-bar"><div class="skill-fill" style="--w:.90"></div></div></div>
    <div class="skill-card reveal"><span class="skill-icon">🟢</span><div class="skill-name">Node.js</div><div class="skill-bar"><div class="skill-fill" style="--w:.87"></div></div></div>
    <div class="skill-card reveal"><span class="skill-icon">⚛️</span><div class="skill-name">React</div><div class="skill-bar"><div class="skill-fill" style="--w:.70"></div></div></div>
    <div class="skill-card reveal"><span class="skill-icon">▲</span><div class="skill-name">Next.js</div><div class="skill-bar"><div class="skill-fill" style="--w:.65"></div></div></div>
    <div class="skill-card reveal"><span class="skill-icon">🔵</span><div class="skill-name">Electron</div><div class="skill-bar"><div class="skill-fill" style="--w:.85"></div></div></div>
    <div class="skill-card reveal"><span class="skill-icon">🔩</span><div class="skill-name">C++ / ESP32</div><div class="skill-bar"><div class="skill-fill" style="--w:.72"></div></div></div>
    <div class="skill-card reveal"><span class="skill-icon">🐬</span><div class="skill-name">MySQL</div><div class="skill-bar"><div class="skill-fill" style="--w:.88"></div></div></div>
    <div class="skill-card reveal"><span class="skill-icon">🗃️</span><div class="skill-name">SQLite</div><div class="skill-bar"><div class="skill-fill" style="--w:.90"></div></div></div>
    <div class="skill-card reveal"><span class="skill-icon">🤖</span><div class="skill-name">Bots & IA</div><div class="skill-bar"><div class="skill-fill" style="--w:.85"></div></div></div>
    <div class="skill-card reveal"><span class="skill-icon">⚙️</span><div class="skill-name">Automação</div><div class="skill-bar"><div class="skill-fill" style="--w:.93"></div></div></div>
  </div>
</div>

<div class="section-divider"><hr></div>

<!-- PROJECTS -->
<div class="section-wrap" id="projects">
  <p class="section-label reveal">// projetos</p>
  <h2 class="section-title reveal">O que <span>eu construí</span></h2>
  <p class="section-desc reveal">Todos os projetos estão no GitHub. Alguns têm demo ao vivo.</p>
  <div class="filter-bar reveal">
    <button class="filter-btn active" data-filter="all">Todos</button>
    <button class="filter-btn" data-filter="web">Web & SaaS</button>
    <button class="filter-btn" data-filter="bot">Bots & IA</button>
    <button class="filter-btn" data-filter="desktop">Desktop</button>
    <button class="filter-btn" data-filter="iot">IoT</button>
    <button class="filter-btn" data-filter="template">Templates</button>
  </div>
  <div class="projects-grid">

    <div class="proj-card reveal" data-cat="web">
      <div class="proj-card-header">
        <span class="proj-icon">🛡️</span>
        <div class="proj-badges"><span class="badge badge-new">open source</span></div>
      </div>
      <div class="proj-card-body">
        <h3 class="proj-title">secscan2026</h3>
        <p class="proj-desc">Scanner de segurança para as falhas que marcaram 2026: secrets vazados, Supabase/RLS, CORS aberto, SQLi, deserialização e runtimes com CVE. Dois modos: análise de código e checagem passiva de domínio. Read-only, sem exploits.</p>
        <div class="proj-tags"><span class="proj-tag">Python</span><span class="proj-tag">AppSec</span><span class="proj-tag">SAST</span><span class="proj-tag">CLI</span></div>
      </div>
      <div class="proj-card-footer">
        <a href="https://github.com/BAZZUKA-ROOT/secscan" target="_blank" class="proj-link proj-link-github">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>GitHub
        </a>
      </div>
    </div>

    <div class="proj-card reveal" data-cat="web">
      <div class="proj-card-header">
        <span class="proj-icon">📣</span>
        <div class="proj-badges"><span class="badge badge-new">IA</span></div>
      </div>
      <div class="proj-card-body">
        <h3 class="proj-title">Impulso</h3>
        <p class="proj-desc">Plataforma de marketing que gera o post com IA (imagem + legenda) usando as cores da sua marca, agenda e publica no Instagram e Facebook. Modo fácil e pro, grátis e premium.</p>
        <div class="proj-tags"><span class="proj-tag">Next.js</span><span class="proj-tag">IA</span><span class="proj-tag">TypeScript</span></div>
      </div>
      <div class="proj-card-footer">
        <a href="https://github.com/BAZZUKA-ROOT/impulso" target="_blank" class="proj-link proj-link-github">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>GitHub
        </a>
      </div>
    </div>

    <div class="proj-card reveal" data-cat="web">
      <div class="proj-card-header">
        <span class="proj-icon">🏷️</span>
        <div class="proj-badges"><span class="badge badge-new">SaaS</span></div>
      </div>
      <div class="proj-card-body">
        <h3 class="proj-title">Comparou</h3>
        <p class="proj-desc">Comparador de preços multi-loja. Uma busca traz o mesmo produto em várias lojas (via Google Shopping), com radar diário que acompanha o histórico e avisa quando o preço cai. Versão grátis e premium.</p>
        <div class="proj-tags"><span class="proj-tag">Next.js</span><span class="proj-tag">TypeScript</span><span class="proj-tag">Node.js</span></div>
      </div>
      <div class="proj-card-footer">
        <a href="https://github.com/BAZZUKA-ROOT/comparou" target="_blank" class="proj-link proj-link-github">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>GitHub
        </a>
      </div>
    </div>

    <div class="proj-card reveal" data-cat="web">
      <div class="proj-card-header">
        <span class="proj-icon">⚡</span>
        <div class="proj-badges"><span class="badge badge-new">flagship</span></div>
      </div>
      <div class="proj-card-body">
        <h3 class="proj-title">Veltora</h3>
        <p class="proj-desc">Gerador de sites profissionais + CRM para prospecção via WhatsApp. Bot com IA Groq e acesso por hash SHA-256.</p>
        <div class="proj-tags"><span class="proj-tag">HTML</span><span class="proj-tag">Node.js</span><span class="proj-tag">Python</span><span class="proj-tag">Groq AI</span></div>
      </div>
      <div class="proj-card-footer">
        <a href="https://github.com/BAZZUKA-ROOT/veltora" target="_blank" class="proj-link proj-link-github">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>GitHub
        </a>
      </div>
    </div>

    <div class="proj-card reveal" data-cat="desktop">
      <div class="proj-card-header">
        <span class="proj-icon">🖥️</span>
        <div class="proj-badges"><span class="badge badge-new">100% offline</span></div>
      </div>
      <div class="proj-card-body">
        <h3 class="proj-title">PDV Local</h3>
        <p class="proj-desc">Ponto de venda desktop completo com Electron + SQLite. Caixa, estoque, vendas e relatórios — sem servidor, sem internet.</p>
        <div class="proj-tags"><span class="proj-tag">Electron</span><span class="proj-tag">SQLite</span><span class="proj-tag">JavaScript</span></div>
      </div>
      <div class="proj-card-footer">
        <a href="https://github.com/BAZZUKA-ROOT/pdv-local" target="_blank" class="proj-link proj-link-github">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>GitHub
        </a>
      </div>
    </div>

    <div class="proj-card reveal" data-cat="iot">
      <div class="proj-card-header">
        <span class="proj-icon">📡</span>
        <div class="proj-badges"><span class="badge badge-new">IoT</span></div>
      </div>
      <div class="proj-card-body">
        <h3 class="proj-title">Monitor ESP32</h3>
        <p class="proj-desc">Monitora latência e qualidade da internet com ESP32. Alertas Telegram, portal web responsivo e atualização OTA.</p>
        <div class="proj-tags"><span class="proj-tag">C++</span><span class="proj-tag">ESP32</span><span class="proj-tag">Arduino</span><span class="proj-tag">Telegram</span></div>
      </div>
      <div class="proj-card-footer">
        <a href="https://github.com/BAZZUKA-ROOT/monitor-internet-esp32" target="_blank" class="proj-link proj-link-github">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>GitHub
        </a>
      </div>
    </div>

    <div class="proj-card reveal" data-cat="web">
      <div class="proj-card-header">
        <span class="proj-icon">💳</span>
        <div class="proj-badges"><span class="badge badge-new">pagamentos</span></div>
      </div>
      <div class="proj-card-body">
        <h3 class="proj-title">Maquininha Web</h3>
        <p class="proj-desc">Terminal POS no navegador com Mercado Pago — cartão e PIX. Webhook HMAC, painel admin e API REST.</p>
        <div class="proj-tags"><span class="proj-tag">PHP</span><span class="proj-tag">MySQL</span><span class="proj-tag">Mercado Pago</span><span class="proj-tag">PIX</span></div>
      </div>
      <div class="proj-card-footer">
        <a href="https://github.com/BAZZUKA-ROOT/maquininha-web-php" target="_blank" class="proj-link proj-link-github">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>GitHub
        </a>
      </div>
    </div>

    <div class="proj-card reveal" data-cat="web">
      <div class="proj-card-header"><span class="proj-icon">📍</span></div>
      <div class="proj-card-body">
        <h3 class="proj-title">Ponto WiFi</h3>
        <p class="proj-desc">Registro de ponto eletrônico que só funciona na rede interna do estabelecimento — segurança por localização WiFi, sem app.</p>
        <div class="proj-tags"><span class="proj-tag">PHP</span><span class="proj-tag">MySQL</span></div>
      </div>
      <div class="proj-card-footer">
        <a href="https://github.com/BAZZUKA-ROOT/ponto-wifi-php" target="_blank" class="proj-link proj-link-github">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>GitHub
        </a>
      </div>
    </div>

    <div class="proj-card reveal" data-cat="bot">
      <div class="proj-card-header">
        <span class="proj-icon">📥</span>
        <div class="proj-badges"><span class="badge badge-new">automação</span></div>
      </div>
      <div class="proj-card-body">
        <h3 class="proj-title">Telegram Collector</h3>
        <p class="proj-desc">Bot Python que monitora grupos Telegram, baixa arquivos automaticamente e os categoriza por tipo com palavras-chave.</p>
        <div class="proj-tags"><span class="proj-tag">Python</span><span class="proj-tag">Telethon</span><span class="proj-tag">Telegram</span></div>
      </div>
      <div class="proj-card-footer">
        <a href="https://github.com/BAZZUKA-ROOT/telegram-collector" target="_blank" class="proj-link proj-link-github">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>GitHub
        </a>
      </div>
    </div>

    <div class="proj-card reveal" data-cat="web">
      <div class="proj-card-header"><span class="proj-icon">🔐</span></div>
      <div class="proj-card-body">
        <h3 class="proj-title">CheckSafe PHP</h3>
        <p class="proj-desc">Detecta padrões suspeitos em checkouts — CPF inválido, email descartável — alertas Telegram em tempo real. Sem banco.</p>
        <div class="proj-tags"><span class="proj-tag">PHP</span><span class="proj-tag">Telegram</span><span class="proj-tag">Segurança</span></div>
      </div>
      <div class="proj-card-footer">
        <a href="https://github.com/BAZZUKA-ROOT/checksafe-php" target="_blank" class="proj-link proj-link-github">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>GitHub
        </a>
      </div>
    </div>

    <div class="proj-card reveal" data-cat="template">
      <div class="proj-card-header">
        <span class="proj-icon">🍱</span>
        <div class="proj-badges"><span class="badge badge-demo">demo ao vivo</span></div>
      </div>
      <div class="proj-card-body">
        <h3 class="proj-title">Cantina da Bea</h3>
        <p class="proj-desc">Site completo para cantina/restaurante — cardápio, galeria, WhatsApp. Mobile-first, zero dependências.</p>
        <div class="proj-tags"><span class="proj-tag">HTML</span><span class="proj-tag">CSS</span><span class="proj-tag">JavaScript</span></div>
      </div>
      <div class="proj-card-footer">
        <a href="https://github.com/BAZZUKA-ROOT/cantina-bea" target="_blank" class="proj-link proj-link-github">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>GitHub
        </a>
        <a href="https://bazzuka-root.github.io/cantina-bea/" target="_blank" class="proj-link proj-link-demo">🌐 Demo</a>
      </div>
    </div>

    <div class="proj-card reveal" data-cat="template">
      <div class="proj-card-header">
        <span class="proj-icon">🍽️</span>
        <div class="proj-badges"><span class="badge badge-demo">demo ao vivo</span></div>
      </div>
      <div class="proj-card-body">
        <h3 class="proj-title">Template Restaurante</h3>
        <p class="proj-desc">Template HTML para restaurante com dark mode automático, animações CSS e integração WhatsApp. Hospedagem estática.</p>
        <div class="proj-tags"><span class="proj-tag">HTML</span><span class="proj-tag">CSS</span><span class="proj-tag">Dark Mode</span></div>
      </div>
      <div class="proj-card-footer">
        <a href="https://github.com/BAZZUKA-ROOT/site-restaurante-template" target="_blank" class="proj-link proj-link-github">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>GitHub
        </a>
        <a href="https://bazzuka-root.github.io/site-restaurante-template/" target="_blank" class="proj-link proj-link-demo">🌐 Demo</a>
      </div>
    </div>

    <div class="proj-card reveal" data-cat="template">
      <div class="proj-card-header">
        <span class="proj-icon">💳</span>
        <div class="proj-badges"><span class="badge badge-demo">demo ao vivo</span></div>
      </div>
      <div class="proj-card-body">
        <h3 class="proj-title">Simulador Maquininha</h3>
        <p class="proj-desc">Simulador web do terminal PagSeguro — interface mobile-first fiel ao original. Para demos e estudos de UX de pagamento.</p>
        <div class="proj-tags"><span class="proj-tag">HTML</span><span class="proj-tag">CSS</span><span class="proj-tag">UX</span></div>
      </div>
      <div class="proj-card-footer">
        <a href="https://github.com/BAZZUKA-ROOT/simulador-maquininha" target="_blank" class="proj-link proj-link-github">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>GitHub
        </a>
        <a href="https://bazzuka-root.github.io/simulador-maquininha/" target="_blank" class="proj-link proj-link-demo">🌐 Demo</a>
      </div>
    </div>

    <div class="proj-card reveal" data-cat="desktop">
      <div class="proj-card-header"><span class="proj-icon">🧹</span></div>
      <div class="proj-card-body">
        <h3 class="proj-title">Limpador Windows</h3>
        <p class="proj-desc">Organiza Downloads, limpa Temp e detecta programas não usados no Windows 11. Agendável via PowerShell.</p>
        <div class="proj-tags"><span class="proj-tag">Python</span><span class="proj-tag">PowerShell</span><span class="proj-tag">Windows</span></div>
      </div>
      <div class="proj-card-footer">
        <a href="https://github.com/BAZZUKA-ROOT/limpador-automatico-windows" target="_blank" class="proj-link proj-link-github">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>GitHub
        </a>
      </div>
    </div>

    <div class="proj-card reveal" data-cat="bot">
      <div class="proj-card-header"><span class="proj-icon">🎮</span></div>
      <div class="proj-card-body">
        <h3 class="proj-title">Epic Automation</h3>
        <p class="proj-desc">Scripts Python para automatizar o resgate de jogos gratuitos da Epic Games Store via PyAutoGUI.</p>
        <div class="proj-tags"><span class="proj-tag">Python</span><span class="proj-tag">PyAutoGUI</span><span class="proj-tag">Automação</span></div>
      </div>
      <div class="proj-card-footer">
        <a href="https://github.com/BAZZUKA-ROOT/epic-automation" target="_blank" class="proj-link proj-link-github">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>GitHub
        </a>
      </div>
    </div>

    <div class="proj-card reveal" data-cat="bot">
      <div class="proj-card-header">
        <span class="proj-icon">🤖</span>
        <div class="proj-badges"><span class="badge badge-new">novo</span></div>
      </div>
      <div class="proj-card-body">
        <h3 class="proj-title">Claude Monitor</h3>
        <p class="proj-desc">Dashboard Flask que monitora tokens e custo da API Anthropic por período de cobrança. Alertas automáticos via Telegram + histórico SQLite.</p>
        <div class="proj-tags"><span class="proj-tag">Python</span><span class="proj-tag">Flask</span><span class="proj-tag">Telegram</span><span class="proj-tag">Docker</span></div>
      </div>
      <div class="proj-card-footer">
        <a href="https://github.com/BAZZUKA-ROOT/claude-monitor" target="_blank" class="proj-link proj-link-github">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>GitHub
        </a>
      </div>
    </div>

    <div class="proj-card reveal" data-cat="web">
      <div class="proj-card-header"><span class="proj-icon">🧾</span></div>
      <div class="proj-card-body">
        <h3 class="proj-title">Verificador de NF</h3>
        <p class="proj-desc">Ferramenta web que verifica autenticidade de notas fiscais e detecta documentos falsos comparando padrões e campos obrigatórios.</p>
        <div class="proj-tags"><span class="proj-tag">HTML</span><span class="proj-tag">JavaScript</span><span class="proj-tag">Offline</span></div>
      </div>
      <div class="proj-card-footer">
        <a href="https://github.com/BAZZUKA-ROOT/verificador-nota-fiscal" target="_blank" class="proj-link proj-link-github">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>GitHub
        </a>
      </div>
    </div>

    <div class="proj-card reveal" data-cat="web">
      <div class="proj-card-header"><span class="proj-icon">🚀</span></div>
      <div class="proj-card-body">
        <h3 class="proj-title">TurboSaaS</h3>
        <p class="proj-desc">Boilerplate React + Vite para SaaS — autenticação, dashboard, catálogo e páginas de vendas prontas para customizar e lançar rápido.</p>
        <div class="proj-tags"><span class="proj-tag">React</span><span class="proj-tag">Vite</span><span class="proj-tag">SaaS</span></div>
      </div>
      <div class="proj-card-footer">
        <a href="https://github.com/BAZZUKA-ROOT/turbosaas-rebuild" target="_blank" class="proj-link proj-link-github">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>GitHub
        </a>
      </div>
    </div>

    <div class="proj-card reveal" data-cat="web">
      <div class="proj-card-header"><span class="proj-icon">🎰</span></div>
      <div class="proj-card-body">
        <h3 class="proj-title">CasinoPearls Clone</h3>
        <p class="proj-desc">Recriação em Next.js de uma plataforma de cassino — foco em design, animações e fluxo de navegação para estudo de UI/UX.</p>
        <div class="proj-tags"><span class="proj-tag">Next.js</span><span class="proj-tag">React</span><span class="proj-tag">TypeScript</span></div>
      </div>
      <div class="proj-card-footer">
        <a href="https://github.com/BAZZUKA-ROOT/casinopearls-clone" target="_blank" class="proj-link proj-link-github">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>GitHub
        </a>
      </div>
    </div>

  </div>
</div>

<div class="section-divider"><hr></div>

<!-- CONTACT -->
<div class="section-wrap" id="contact" style="text-align:center">
  <p class="section-label reveal" style="justify-content:center">// contato</p>
  <h2 class="section-title reveal">Vamos <span>conversar</span></h2>
  <p class="section-desc reveal" style="margin:0 auto 0">Tem um projeto, uma ideia ou quer contratar? Me manda mensagem — respondo rápido.</p>
  <div class="contact-grid reveal">
    <a href="https://wa.me/5544998458841" target="_blank" class="contact-card wpp">
      <div class="contact-icon wpp">💬</div>
      <div class="contact-name">WhatsApp</div>
      <div class="contact-val">(44) 99845-8841</div>
    </a>
    <a href="https://instagram.com/maicon.lbj" target="_blank" class="contact-card ig">
      <div class="contact-icon ig">📷</div>
      <div class="contact-name">Instagram</div>
      <div class="contact-val">@maicon.lbj</div>
    </a>
    <a href="https://github.com/BAZZUKA-ROOT" target="_blank" class="contact-card gh">
      <div class="contact-icon gh">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>
      </div>
      <div class="contact-name">GitHub</div>
      <div class="contact-val">BAZZUKA-ROOT</div>
    </a>
    <a href="mailto:maiconluisbraga98@gmail.com" class="contact-card mail">
      <div class="contact-icon mail">✉️</div>
      <div class="contact-name">E-mail</div>
      <div class="contact-val">maiconluisbraga98</div>
    </a>
  </div>
</div>

<!-- FOOTER -->
<footer>
  <p>© <?= $year ?> <strong>Bazzuka</strong> · Feito com ☕ e muito código · <a href="https://github.com/BAZZUKA-ROOT" target="_blank">BAZZUKA-ROOT</a></p>
</footer>

<script>
// ─────────────────────────────────────────
// LOADER
// ─────────────────────────────────────────
window.addEventListener('load', () => {
  setTimeout(() => document.getElementById('loader').classList.add('done'), 1900);
});

// ─────────────────────────────────────────
// CUSTOM CURSOR (desktop only)
// ─────────────────────────────────────────
(function(){
  const isMobile = /Mobi|Android/i.test(navigator.userAgent) || window.innerWidth < 768;
  if(isMobile){ document.body.classList.remove('cursor-active'); return; }
  const cur = document.getElementById('cursor');
  const ring = document.getElementById('cursor-ring');
  let rx = 0, ry = 0;
  document.addEventListener('mousemove', e => {
    cur.style.left = e.clientX + 'px';
    cur.style.top = e.clientY + 'px';
    rx += (e.clientX - rx) * .12;
    ry += (e.clientY - ry) * .12;
    ring.style.left = rx + 'px';
    ring.style.top = ry + 'px';
  });
  function loopRing(){
    ring.style.left = rx + 'px';
    ring.style.top = ry + 'px';
    requestAnimationFrame(loopRing);
  }
  loopRing();
  document.querySelectorAll('a,button,.proj-card,.skill-card,.contact-card,.filter-btn').forEach(el => {
    el.addEventListener('mouseenter', () => document.body.classList.add('cursor-hover'));
    el.addEventListener('mouseleave', () => document.body.classList.remove('cursor-hover'));
  });
})();

// ─────────────────────────────────────────
// THREE.JS — HERO BACKGROUND (adaptive quality)
// ─────────────────────────────────────────
(function(){
  const isMobile = window.innerWidth < 768;
  const isLowEnd = navigator.hardwareConcurrency <= 2;
  const canvas = document.getElementById('three-canvas');
  const renderer = new THREE.WebGLRenderer({canvas, antialias: !isMobile, alpha: true});
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, isMobile ? 1.5 : 2));
  renderer.setSize(window.innerWidth, window.innerHeight);
  renderer.setClearColor(0x000000, 0);

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(70, window.innerWidth / window.innerHeight, 0.1, 1000);
  camera.position.z = 28;

  // ── PARTICLES ──
  const COUNT = isMobile ? 700 : (isLowEnd ? 1000 : 1600);
  const positions = new Float32Array(COUNT * 3);
  const colors = new Float32Array(COUNT * 3);
  const sizes = new Float32Array(COUNT);
  const spread = 90;

  for(let i = 0; i < COUNT; i++){
    positions[i*3]   = (Math.random() - .5) * spread;
    positions[i*3+1] = (Math.random() - .5) * spread * .7;
    positions[i*3+2] = (Math.random() - .5) * 40 - 5;
    // colors: mix purple to pink
    const t = Math.random();
    colors[i*3]   = .48 + t * .44;  // R
    colors[i*3+1] = .22 + t * .11;  // G
    colors[i*3+2] = .93 - t * .35;  // B
    sizes[i] = Math.random() * 1.8 + .4;
  }

  const geo = new THREE.BufferGeometry();
  geo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
  geo.setAttribute('color', new THREE.BufferAttribute(colors, 3));
  geo.setAttribute('size', new THREE.BufferAttribute(sizes, 1));

  const mat = new THREE.PointsMaterial({
    size: .45,
    vertexColors: true,
    transparent: true,
    opacity: .75,
    sizeAttenuation: true
  });
  const particles = new THREE.Points(geo, mat);
  scene.add(particles);

  // ── CONSTELLATION LINES (connect nearby particles) ──
  if(!isMobile && !isLowEnd){
    const linePositions = [];
    const lineColors = [];
    const threshold = 14;
    const sample = 400; // check first N particles for performance
    for(let i = 0; i < sample; i++){
      for(let j = i+1; j < sample; j++){
        const dx = positions[i*3] - positions[j*3];
        const dy = positions[i*3+1] - positions[j*3+1];
        const dz = positions[i*3+2] - positions[j*3+2];
        const dist = Math.sqrt(dx*dx + dy*dy + dz*dz);
        if(dist < threshold){
          const alpha = 1 - dist/threshold;
          linePositions.push(positions[i*3], positions[i*3+1], positions[i*3+2]);
          linePositions.push(positions[j*3], positions[j*3+1], positions[j*3+2]);
          lineColors.push(.49, .23, .93, .49, .23, .93);
        }
      }
    }
    if(linePositions.length){
      const lineGeo = new THREE.BufferGeometry();
      lineGeo.setAttribute('position', new THREE.BufferAttribute(new Float32Array(linePositions), 3));
      lineGeo.setAttribute('color', new THREE.BufferAttribute(new Float32Array(lineColors), 3));
      const lineMat = new THREE.LineBasicMaterial({vertexColors: true, transparent: true, opacity: .12});
      scene.add(new THREE.LineSegments(lineGeo, lineMat));
    }
  }

  // ── WIREFRAME SHAPES ──
  const shapeData = [
    {geo: new THREE.OctahedronGeometry(1.8), color: 0xA855F7},
    {geo: new THREE.TetrahedronGeometry(1.5), color: 0xEC4899},
    {geo: new THREE.IcosahedronGeometry(1.2), color: 0x7C3AED},
    {geo: new THREE.OctahedronGeometry(1.2), color: 0x06B6D4},
    {geo: new THREE.TetrahedronGeometry(1.0), color: 0xA855F7},
    {geo: new THREE.IcosahedronGeometry(.9), color: 0xEC4899},
  ];
  const shapeCount = isMobile ? 4 : 10;
  const shapes = [];
  for(let i = 0; i < shapeCount; i++){
    const sd = shapeData[i % shapeData.length];
    const edges = new THREE.EdgesGeometry(sd.geo);
    const mesh = new THREE.LineSegments(edges, new THREE.LineBasicMaterial({
      color: sd.color,
      transparent: true,
      opacity: isMobile ? .25 : .35
    }));
    mesh.position.set(
      (Math.random()-.5) * 55,
      (Math.random()-.5) * 35,
      (Math.random()-.5) * 20 - 8
    );
    const s = .6 + Math.random() * 1.4;
    mesh.scale.set(s,s,s);
    mesh.userData = {
      rx: (Math.random()-.5) * .012,
      ry: (Math.random()-.5) * .016,
      rz: (Math.random()-.5) * .008,
      floatSpeed: Math.random() * .4 + .15,
      floatAmp: Math.random() * .06 + .02,
      phase: Math.random() * Math.PI * 2,
      pulseSpeed: Math.random() * .8 + .5
    };
    shapes.push(mesh);
    scene.add(mesh);
  }

  // ── GRID ──
  if(!isMobile){
    const grid = new THREE.GridHelper(160, 32, 0x7C3AED, 0x150030);
    grid.position.y = -22;
    grid.material.opacity = .1;
    grid.material.transparent = true;
    scene.add(grid);
  }

  // ── INPUT: mouse + touch + gyroscope ──
  let inputX = 0, inputY = 0;
  const hasGyro = typeof DeviceOrientationEvent !== 'undefined';

  document.addEventListener('mousemove', e => {
    inputX = (e.clientX / window.innerWidth - .5) * 2;
    inputY = -(e.clientY / window.innerHeight - .5) * 2;
  });

  document.addEventListener('touchmove', e => {
    if(e.touches.length > 0){
      inputX = (e.touches[0].clientX / window.innerWidth - .5) * 2;
      inputY = -(e.touches[0].clientY / window.innerHeight - .5) * 2;
    }
  }, {passive: true});

  if(isMobile && hasGyro){
    window.addEventListener('deviceorientation', e => {
      if(e.gamma !== null) inputX = Math.max(-1, Math.min(1, e.gamma / 30));
      if(e.beta !== null)  inputY = Math.max(-1, Math.min(1, (e.beta - 45) / 30));
    });
  }

  window.addEventListener('resize', () => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
  });

  let t = 0;
  let camX = 0, camY = 0;
  function animate(){
    requestAnimationFrame(animate);
    t += .004;

    // smooth camera parallax
    camX += (inputX * 5 - camX) * .03;
    camY += (inputY * 3 - camY) * .03;
    camera.position.x = camX;
    camera.position.y = camY;
    camera.lookAt(scene.position);

    // particles drift
    particles.rotation.y = t * .04;
    particles.rotation.x = t * .015;

    // shapes animate
    shapes.forEach(s => {
      s.rotation.x += s.userData.rx;
      s.rotation.y += s.userData.ry;
      s.rotation.z += s.userData.rz;
      s.position.y += Math.sin(t * s.userData.floatSpeed + s.userData.phase) * s.userData.floatAmp;
      const pulse = (.3 + Math.abs(Math.sin(t * s.userData.pulseSpeed))) * (isMobile ? .25 : .38);
      s.material.opacity = pulse;
    });

    renderer.render(scene, camera);
  }
  animate();
})();

// ─────────────────────────────────────────
// TYPEWRITER
// ─────────────────────────────────────────
(function(){
  const phrases = [
    'Full-stack Developer',
    'Automação & Bots',
    'IoT · ESP32 · Telegram',
    'PHP · Python · Node.js',
    'Soluções que funcionam 🚀'
  ];
  let pi = 0, ci = 0, del = false;
  const el = document.getElementById('typewriter');
  const cursorEl = el.querySelector('.cursor-blink');
  function type(){
    const curr = phrases[pi];
    const txt = del ? curr.slice(0, ci--) : curr.slice(0, ci++);
    el.textContent = txt;
    el.appendChild(cursorEl);
    if(!del && ci > curr.length){ del = true; setTimeout(type, 2000); return; }
    if(del && ci < 0){ del = false; pi = (pi+1) % phrases.length; setTimeout(type, 450); return; }
    setTimeout(type, del ? 45 : 85);
  }
  setTimeout(type, 2400);
})();

// ─────────────────────────────────────────
// INTERSECTION OBSERVER — reveal + skill bars + counters
// ─────────────────────────────────────────
(function(){
  const revealObs = new IntersectionObserver(entries => {
    entries.forEach(e => { if(e.isIntersecting){ e.target.classList.add('visible'); revealObs.unobserve(e.target); } });
  }, {threshold: .1, rootMargin: '0px 0px -40px 0px'});
  document.querySelectorAll('.reveal,.reveal-left,.reveal-right').forEach(el => revealObs.observe(el));

  // staggered reveal for grid children
  document.querySelectorAll('.skills-grid,.projects-grid,.contact-grid,.about-stats').forEach(grid => {
    const children = grid.querySelectorAll('.skill-card,.proj-card,.contact-card,.stat-card');
    children.forEach((child, i) => { child.style.transitionDelay = (i * .07) + 's'; });
  });

  // skill bars animate on entry
  const skillObs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if(e.isIntersecting){
        e.target.classList.add('in-view');
        skillObs.unobserve(e.target);
      }
    });
  }, {threshold: .3});
  document.querySelectorAll('.skill-card').forEach(el => skillObs.observe(el));

  // counter animation
  const counterObs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if(!e.isIntersecting) return;
      const el = e.target;
      const target = parseInt(el.dataset.count);
      if(isNaN(target)) return;
      let start = 0;
      const dur = 1200;
      const step = timestamp => {
        if(!start) start = timestamp;
        const progress = Math.min((timestamp - start) / dur, 1);
        el.textContent = Math.floor(progress * target) + '+';
        if(progress < 1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
      counterObs.unobserve(el);
    });
  }, {threshold: .5});
  document.querySelectorAll('[data-count]').forEach(el => counterObs.observe(el));
})();

// ─────────────────────────────────────────
// PROJECT FILTER
// ─────────────────────────────────────────
(function(){
  const btns = document.querySelectorAll('.filter-btn');
  const cards = document.querySelectorAll('.proj-card');
  btns.forEach(btn => {
    btn.addEventListener('click', () => {
      btns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const f = btn.dataset.filter;
      cards.forEach((c, i) => {
        const show = f === 'all' || c.dataset.cat === f;
        c.classList.toggle('hidden', !show);
        if(show){ c.style.transitionDelay = (i * .04) + 's'; c.classList.add('visible'); }
      });
    });
  });
})();

// ─────────────────────────────────────────
// 3D CARD TILT — desktop mouse + mobile touch
// ─────────────────────────────────────────
(function(){
  const isMobile = window.innerWidth < 768;
  document.querySelectorAll('.proj-card,.contact-card,.skill-card,.stat-card').forEach(card => {
    function applyTilt(cx, cy){
      const r = card.getBoundingClientRect();
      const x = (cx - r.left) / r.width - .5;
      const y = (cy - r.top) / r.height - .5;
      const maxTilt = isMobile ? 6 : 12;
      card.style.transform = `translateY(-6px) rotateX(${y * -maxTilt}deg) rotateY(${x * maxTilt}deg) scale(1.02)`;
      card.style.transition = 'transform .05s';
    }
    function resetTilt(){
      card.style.transform = '';
      card.style.transition = 'transform .5s cubic-bezier(.16,1,.3,1)';
    }
    card.addEventListener('mousemove', e => applyTilt(e.clientX, e.clientY));
    card.addEventListener('mouseleave', resetTilt);
    if(isMobile){
      card.addEventListener('touchmove', e => {
        if(e.touches.length) applyTilt(e.touches[0].clientX, e.touches[0].clientY);
      }, {passive: true});
      card.addEventListener('touchend', resetTilt);
    }
  });
})();

// ─────────────────────────────────────────
// RIPPLE ON BUTTONS
// ─────────────────────────────────────────
document.querySelectorAll('.btn-primary,.btn-outline,.filter-btn,.nav-cta').forEach(btn => {
  btn.style.position = 'relative';
  btn.style.overflow = 'hidden';
  btn.addEventListener('click', e => {
    const r = btn.getBoundingClientRect();
    const rip = document.createElement('span');
    rip.className = 'ripple';
    const size = Math.max(r.width, r.height);
    rip.style.cssText = `width:${size}px;height:${size}px;left:${e.clientX - r.left - size/2}px;top:${e.clientY - r.top - size/2}px`;
    btn.appendChild(rip);
    setTimeout(() => rip.remove(), 600);
  });
});

// ─────────────────────────────────────────
// NAVBAR
// ─────────────────────────────────────────
window.addEventListener('scroll', () => {
  const nb = document.getElementById('navbar');
  nb.style.background = window.scrollY > 60
    ? 'rgba(5,5,15,.96)'
    : 'rgba(5,5,15,.6)';
});

function toggleMenu(){
  const links = document.getElementById('navLinks');
  const btn = document.getElementById('hamburger');
  links.classList.toggle('open');
  btn.classList.toggle('open');
}

// close nav on link click (mobile)
document.querySelectorAll('#navLinks a').forEach(a => {
  a.addEventListener('click', () => {
    document.getElementById('navLinks').classList.remove('open');
    document.getElementById('hamburger').classList.remove('open');
  });
});

// ─────────────────────────────────────────
// GSAP HERO ENTRANCE
// ─────────────────────────────────────────
if(window.gsap){
  gsap.registerPlugin(ScrollTrigger);
  const tl = gsap.timeline({delay: 2});
  tl.from('.hero-tag',   {opacity:0, y:30, duration:.7, ease:'power3.out'})
    .from('.hero-name',  {opacity:0, y:50, duration:.9, ease:'power3.out'}, '-=.3')
    .from('#typewriter', {opacity:0, duration:.5}, '-=.2')
    .from('.hero-desc',  {opacity:0, y:20, duration:.7, ease:'power3.out'}, '-=.3')
    .from('.hero-btns a',{opacity:0, y:20, stagger:.12, duration:.6, ease:'power3.out'}, '-=.3')
    .from('.hero-scroll',{opacity:0, duration:.6}, '-=.2');

  // parallax on scroll
  gsap.to('.aurora', {
    yPercent: 30,
    ease: 'none',
    scrollTrigger: {trigger: '#hero', start: 'top top', end: 'bottom top', scrub: true}
  });
}
</script>
</body>
</html>
