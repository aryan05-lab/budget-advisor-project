<!DOCTYPE html>
<html>
<head>
    <title>Resources</title>

    <style>
      /* ============================================================
       SECTION 1 — DESIGN TOKENS (CSS Custom Properties)
       ============================================================
       Think of these like constants in a program.
       Defined once on :root (= the <html> element), referenced
       everywhere as var(--name). Change a value here and the whole
       page updates — great for theming or dark mode later.
    */
    :root {
      --ink:        #0d0f0e;  /* Near-black — primary text colour */
      --cream:      #f5f0e8;  /* Warm off-white — used for section backgrounds */
      --sage:       #4a6741;  /* Deep green — primary brand colour */
      --sage-light: #7a9e71;  /* Lighter green — accents, gradients */
      --gold:       #c8a84b;  /* Muted gold — decorative accents */
      --gold-light: #e8d08a;  /* Pale gold — lighter version of the above */
      --mist:       #e8ede6;  /* Very light green-grey — card backgrounds, progress tracks */
      --stone:      #8a8a7a;  /* Medium grey — secondary/muted text */
      --white:      #fdfcf9;  /* Warm white — main page background */
    }

    /* ============================================================
       SECTION 2 — RESET & BASE STYLES
       ============================================================
       Browsers have built-in default styles (margins, padding, etc.)
       that differ from each other. This resets them to a predictable
       baseline so our design looks the same everywhere.
    */

    /* Apply border-box sizing to ALL elements.
       This means width/height includes padding & border — much easier
       to reason about than the default "content-box" model. */
    *, *::before, *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    /* Smooth scrolling when clicking anchor links (e.g. #how-it-works) */
    html { scroll-behavior: smooth; }

    body {
      font-family: 'DM Sans', sans-serif; /* Our chosen body font */
      background: var(--white);
      color: var(--ink);
      overflow-x: hidden; /* Hide any accidental horizontal scroll caused by animations */
    }

    /*
      SUBTLE NOISE TEXTURE OVERLAY
      --------------------------------
      body::before is a "pseudo-element" — a virtual <div> we inject
      with pure CSS, no extra HTML needed. We pin it fixed over the
      entire viewport so it scrolls with the user, adding a fine paper
      texture that prevents the design from looking too flat/digital.

      The texture is an inline SVG encoded as a data: URI so we don't
      need a separate image file. SVG <feTurbulence> generates procedural
      noise — the same technique used in Photoshop grain filters.
    */
    body::before {
      content: ''; /* Required for pseudo-elements to render */
      position: fixed;
      inset: 0; /* Shorthand for top:0; right:0; bottom:0; left:0 */
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
      pointer-events: none; /* Don't block clicks on real content below */
      z-index: 9999;        /* Sit above everything */
      opacity: 0.4;
    }

    /* ============================================================
       SECTION 3 — NAVIGATION BAR
       ============================================================
       Fixed navbar that stays at the top while the user scrolls.
       backdrop-filter: blur() creates the "frosted glass" effect —
       content behind it blurs rather than being fully transparent.
    */
    nav {
      position: fixed;          /* Removed from normal flow, stays at top */
      top: 0; left: 0; right: 0;
      z-index: 100;             /* High z-index so it sits above page content */
      display: flex;
      align-items: center;
      justify-content: space-between; /* Logo left, links right */
      padding: 1.5rem 4rem;
      background: rgba(253, 252, 249, 0.88); /* Semi-transparent white */
      backdrop-filter: blur(14px);           /* Frosted glass blur */
      border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    }

    /* The "BudgetPro" wordmark */
    .logo {
      font-family: 'Playfair Display', serif;
      font-size: 1.5rem;
      font-weight: 700;
      letter-spacing: -0.02em; /* Tighten character spacing slightly for headings */
      color: var(--ink);
    }
    .logo span { color: var(--sage); } /* The "Pro" part in green */

    /* Nav link list — horizontal row, no bullet points */
    nav ul {
      display: flex;
      gap: 2.5rem;
      list-style: none;
    }
    nav ul a {
      font-size: 0.875rem;
      color: var(--stone);
      text-decoration: none;
      letter-spacing: 0.02em;
      transition: color 0.2s; /* Animate colour change on hover */
    }
    nav ul a:hover { color: var(--ink); }

    /* The "Get Started" pill button in the nav */
    .nav-cta {
      background: var(--ink) !important;
      color: var(--white) !important;
      padding: 0.6rem 1.4rem;
      border-radius: 2rem; /* Large radius = pill shape */
      font-weight: 500 !important;
      transition: background 0.2s !important;
    }
    .nav-cta:hover { background: var(--sage) !important; }

    /* ============================================================
       SECTION 4 — HERO (full-screen opening section)
       ============================================================
       CSS Grid splits the hero into two columns: text left, card right.
       The decorative background circles are pseudo-elements of .hero-bg.
    */
    .hero {
      min-height: 100vh; /* Fill at least the full viewport height */
      display: grid;
      grid-template-columns: 1fr 1fr; /* Two equal columns */
      padding-top: 5rem; /* Clear space for the fixed navbar */
      position: relative;
      overflow: hidden;
    }

    /* Gradient background layer */
    .hero-bg {
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, var(--mist) 0%, var(--white) 50%, var(--cream) 100%);
      z-index: 0;
    }

    /* Large blurred circle — top right */
    .hero-bg::before {
      content: '';
      position: absolute;
      width: 600px; height: 600px;
      border-radius: 50%;
      /* radial-gradient fades from a semi-transparent green outward to nothing */
      background: radial-gradient(circle, rgba(74, 103, 65, 0.08) 0%, transparent 70%);
      top: -100px; right: -100px;
    }

    /* Smaller blurred circle — bottom left */
    .hero-bg::after {
      content: '';
      position: absolute;
      width: 400px; height: 400px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(200, 168, 75, 0.1) 0%, transparent 70%);
      bottom: 100px; left: 10%;
    }

    /* Left column — headline, subtitle, buttons, stats */
    .hero-left {
      position: relative;
      z-index: 1; /* Sit above the .hero-bg layer */
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 6rem 3rem 4rem 4rem;
    }

    /*
      The green "Verified Financial Experts" pill badge.
      The little dot before it is a ::before pseudo-element again —
      zero HTML, just a CSS circle injected via content:''.
    */
    .badge {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background: var(--sage);
      color: var(--white);
      padding: 0.4rem 1rem;
      border-radius: 2rem;
      font-size: 0.75rem;
      font-weight: 500;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      width: fit-content; /* Shrink to content width, not full row */
      margin-bottom: 2rem;
      animation: fadeUp 0.8s ease both; /* Defined in ANIMATIONS section */
    }
    .badge::before {
      content: '';
      width: 6px; height: 6px;
      background: var(--gold-light);
      border-radius: 50%; /* Perfect circle */
    }

    /* Main headline */
    .hero-h1 {
      font-family: 'Playfair Display', serif;
      /*
        clamp(min, preferred, max) — responsive font size:
          • min 2.8rem at very small screens
          • scales with viewport width (5vw)
          • caps at 4.2rem on large screens
      */
      font-size: clamp(2.8rem, 5vw, 4.2rem);
      font-weight: 700;
      line-height: 1.1;
      letter-spacing: -0.03em;
      margin-bottom: 1.5rem;
      animation: fadeUp 0.8s 0.1s ease both; /* 0.1s delay — staggers after badge */
    }
    .hero-h1 em { font-style: italic; color: var(--sage); } /* The word "guided" in green italic */

    /* Subtitle paragraph */
    .hero-sub {
      font-size: 1.05rem;
      line-height: 1.7;
      color: var(--stone);
      font-weight: 300;
      max-width: 460px;
      margin-bottom: 2.5rem;
      animation: fadeUp 0.8s 0.2s ease both; /* Another 0.1s stagger */
    }

    /* Row of buttons */
    .hero-actions {
      display: flex;
      gap: 1rem;
      align-items: center;
      animation: fadeUp 0.8s 0.3s ease both;
      flex-wrap: wrap; /* Stack on small screens */
    }

    /* ============================================================
       REUSABLE BUTTON STYLES
       Defined here because they're used throughout the whole page.
    */
    .btn-primary {
      background: var(--ink);
      color: var(--white);
      padding: 0.85rem 2rem;
      border-radius: 3rem;
      font-size: 0.9rem;
      font-weight: 500;
      text-decoration: none;
      cursor: pointer;
      border: none;
      transition: all 0.25s; /* Smoothly animate all changing properties */
      letter-spacing: 0.01em;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }
    .btn-primary:hover {
      background: var(--sage);
      transform: translateY(-1px);                     /* Float up 1px */
      box-shadow: 0 8px 24px rgba(74, 103, 65, 0.25); /* Green glow shadow */
    }

    /* Ghost = transparent text-only button, arrow slides right on hover */
    .btn-ghost {
      color: var(--ink);
      padding: 0.85rem 1.5rem;
      font-size: 0.9rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      transition: gap 0.2s; /* Animate the gap to push the arrow right */
    }
    .btn-ghost:hover { gap: 0.7rem; }

    /* Larger version of btn-primary used in CTA sections */
    .btn-large { padding: 1rem 2.5rem; font-size: 1rem; }

    /* Stats row below the hero buttons */
    .hero-stats {
      display: flex;
      gap: 2.5rem;
      margin-top: 3.5rem;
      padding-top: 2.5rem;
      border-top: 1px solid rgba(0, 0, 0, 0.08); /* Subtle divider line */
      animation: fadeUp 0.8s 0.4s ease both;
      flex-wrap: wrap;
    }
    .stat-num {
      font-family: 'Playfair Display', serif;
      font-size: 2rem;
      font-weight: 600;
      color: var(--sage);
      line-height: 1;
    }
    .stat-label {
      font-size: 0.8rem;
      color: var(--stone);
      margin-top: 0.3rem;
    }

    /* ============================================================
       HERO RIGHT COLUMN — Session card mockup
       This is the fake UI card showing a "live session" with
       progress bars and action items.
    */
    .hero-right {
      position: relative;
      z-index: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 4rem 3rem;
      animation: fadeIn 1s 0.3s ease both;
    }

    /* The white card wrapper */
    .hero-card {
      background: var(--white);
      border-radius: 1.5rem;
      /* Layered box-shadow: large diffuse shadow + small tight shadow for depth */
      box-shadow: 0 32px 80px rgba(0, 0, 0, 0.12), 0 2px 8px rgba(0, 0, 0, 0.04);
      width: 100%;
      max-width: 400px;
      overflow: hidden; /* Clip child elements to the rounded corners */
    }

    /* The dark green "video call" area at the top of the card */
    .card-video-stub {
      background: linear-gradient(135deg, #1a2e1a 0%, #2d4a2d 40%, #3d6040 100%);
      height: 220px;
      position: relative; /* Needed so absolutely-positioned children (tags, thumb) work */
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* The circle play button in the centre of the fake video */
    .play-btn {
      width: 56px; height: 56px;
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(8px);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 1.5px solid rgba(255, 255, 255, 0.3);
      cursor: pointer;
      transition: all 0.2s;
      position: relative; /* Needed to stack above .card-video-stub background */
      z-index: 1;
    }
    .play-btn:hover {
      background: rgba(255, 255, 255, 0.25);
      transform: scale(1.05); /* Grow slightly on hover */
    }
    .play-btn svg { fill: white; margin-left: 3px; } /* Nudge right for visual centering */

    /* Red "● LIVE SESSION" label — top left of video */
    .card-live-tag {
      position: absolute; /* Positioned relative to .card-video-stub */
      top: 1rem; left: 1rem;
      background: rgba(200, 30, 30, 0.85);
      color: white;
      font-size: 0.7rem;
      font-weight: 600;
      letter-spacing: 0.06em;
      padding: 0.25rem 0.6rem;
      border-radius: 0.25rem;
      display: flex;
      align-items: center;
      gap: 0.35rem;
    }

    /* The blinking white dot inside the LIVE tag */
    .live-dot {
      width: 6px; height: 6px;
      background: white;
      border-radius: 50%;
      animation: pulse 1.5s infinite; /* Defined in ANIMATIONS section */
    }

    /* Advisor name chip — bottom left of video, frosted glass style */
    .advisor-thumb {
      position: absolute;
      bottom: 1rem; left: 1rem;
      display: flex;
      align-items: center;
      gap: 0.6rem;
      background: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(8px);
      padding: 0.4rem 0.8rem;
      border-radius: 2rem;
    }
    .thumb-avatar {
      width: 28px; height: 28px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--sage-light), var(--gold));
      display: flex; align-items: center; justify-content: center;
      font-size: 0.7rem; color: white; font-weight: 600;
    }
    .thumb-name  { font-size: 0.75rem; color: white;           font-weight: 500; }
    .thumb-cred  { font-size: 0.65rem; color: var(--gold-light); }

    /* Card body below the video area */
    .card-body { padding: 1.4rem; }
    .session-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.05rem; font-weight: 600;
      margin-bottom: 1rem;
    }

    /* Progress bar rows */
    .progress-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 0.4rem;
    }
    .progress-label { font-size: 0.75rem; color: var(--stone); }
    .progress-val   { font-size: 0.75rem; font-weight: 600; color: var(--sage); }

    /* The track (grey background) of a progress bar */
    .progress-bar {
      height: 6px;
      background: var(--mist);
      border-radius: 3px;
      margin-bottom: 0.8rem;
      overflow: hidden; /* Keep the fill clipped inside the rounded track */
    }

    /* The coloured fill inside the track — width is set by JS on load */
    .progress-fill {
      height: 100%;
      background: linear-gradient(90deg, var(--sage), var(--sage-light));
      border-radius: 3px;
      /* CSS transition animates the width change smoothly.
         cubic-bezier(0.4,0,0.2,1) is Material Design's "standard" easing curve */
      transition: width 1.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* The three to-do items */
    .action-items { margin-top: 1rem; display: flex; flex-direction: column; gap: 0.5rem; }
    .action-item  { display: flex; align-items: center; gap: 0.6rem; font-size: 0.78rem; color: var(--ink); }
    .action-check {
      width: 18px; height: 18px;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0; /* Don't squish if text wraps */
      font-size: 0.6rem;
    }
    .action-check.done    { background: var(--sage); color: white; }
    .action-check.pending { background: var(--mist); color: var(--stone); border: 1.5px solid var(--stone); }

    /* ============================================================
       SECTION 5 — TRUSTED BY BAR
       Dark strip with publication names. Gives social proof.
    */
    .trusted-bar {
      background: var(--ink);
      padding: 1.2rem 4rem;
      display: flex;
      align-items: center;
      gap: 3rem;
      flex-wrap: wrap;
    }
    .trusted-label {
      font-size: 0.72rem;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--stone);
      white-space: nowrap;
      font-weight: 500;
    }
    .trusted-logos { display: flex; gap: 2.5rem; align-items: center; flex-wrap: wrap; }
    .trust-logo {
      font-family: 'Playfair Display', serif;
      font-size: 0.9rem;
      color: rgba(255, 255, 255, 0.3);
      letter-spacing: 0.05em;
      white-space: nowrap;
    }

    /* ============================================================
       SECTION 6 — SHARED SECTION UTILITIES
       Classes reused across multiple sections.
    */
    .section {
      padding: 6rem 4rem;
      max-width: 1200px;
      margin: 0 auto; /* Centre the content block horizontally */
    }

    /* Small ALL-CAPS label above a heading — the "eyebrow" */
    .section-eyebrow {
      font-size: 0.72rem;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--sage);
      font-weight: 600;
      margin-bottom: 0.8rem;
    }

    .section-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2rem, 3.5vw, 2.8rem);
      font-weight: 700;
      line-height: 1.15;
      letter-spacing: -0.025em;
      max-width: 520px;
      margin-bottom: 1rem;
    }

    .section-sub {
      font-size: 1rem;
      color: var(--stone);
      font-weight: 300;
      max-width: 480px;
      line-height: 1.7;
      margin-bottom: 3.5rem;
    }

    /* Gold horizontal rule used as a visual accent under headings */
    .divider {
      width: 48px;
      height: 2px;
      background: var(--gold);
      margin: 1.5rem 0;
    }

    /* ============================================================
       SECTION 7 — HOW IT WORKS (step cards)
    */
    /* 3-column grid. gap adds gutters between cards. */
    .steps-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 2rem;
    }

    .step-card {
      padding: 2rem;
      border: 1px solid rgba(0, 0, 0, 0.07);
      border-radius: 1rem;
      background: var(--white);
      transition: all 0.3s;
      position: relative;
      overflow: hidden;
    }

    /*
      The green top-border that slides in on hover.
      It's a ::before pseudo-element, initially scaled to 0 width.
      On hover we scale it to 1 (full width) from the left.
    */
    .step-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 3px;
      background: linear-gradient(90deg, var(--sage), var(--sage-light));
      transform: scaleX(0);
      transform-origin: left; /* Grow from left to right */
      transition: transform 0.3s;
    }
    .step-card:hover::before { transform: scaleX(1); } /* Full width on hover */
    .step-card:hover {
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
      transform: translateY(-3px); /* Float up */
    }

    /* Large faded step number (01, 02…) */
    .step-num {
      font-family: 'Playfair Display', serif;
      font-size: 3rem;
      font-weight: 700;
      color: var(--mist); /* Very light so it doesn't compete with content */
      line-height: 1;
      margin-bottom: 1rem;
    }

    /* Square emoji icon container */
    .step-icon {
      width: 44px; height: 44px;
      background: var(--mist);
      border-radius: 0.75rem;
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 1rem;
      font-size: 1.2rem;
    }

    .step-h { font-family: 'Playfair Display', serif; font-size: 1.15rem; font-weight: 600; margin-bottom: 0.6rem; }
    .step-p { font-size: 0.875rem; color: var(--stone); line-height: 1.65; font-weight: 300; }

    /* ============================================================
       SECTION 8 — ADVISOR CARDS
    */
    .advisors-section { background: var(--cream); padding: 5rem 4rem; }
    .advisors-inner   { max-width: 1200px; margin: 0 auto; }
    .advisors-header  {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-bottom: 2.5rem;
      flex-wrap: wrap;
      gap: 1rem;
    }

    /* 4-column grid for advisor cards */
    .advisors-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.25rem;
    }

    .advisor-card {
      background: var(--white);
      border-radius: 1rem;
      padding: 1.5rem;
      border: 1px solid rgba(0, 0, 0, 0.05);
      transition: all 0.25s;
      cursor: pointer;
    }
    .advisor-card:hover {
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      transform: translateY(-2px);
    }

    /* Circle avatar with initials */
    .advisor-avatar {
      width: 52px; height: 52px;
      border-radius: 50%;
      margin-bottom: 1rem;
      display: flex; align-items: center; justify-content: center;
      font-family: 'Playfair Display', serif;
      font-size: 1.2rem; font-weight: 600; color: white;
    }

    .advisor-name { font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 600; margin-bottom: 0.2rem; }
    .advisor-cred { font-size: 0.72rem; color: var(--sage); font-weight: 600; letter-spacing: 0.04em; margin-bottom: 0.5rem; }
    .advisor-spec { font-size: 0.78rem; color: var(--stone); margin-bottom: 1rem; line-height: 1.5; }

    /* Footer row at the bottom of each advisor card */
    .advisor-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 0.8rem;
      border-top: 1px solid var(--mist);
    }
    .advisor-stars { font-size: 0.7rem; color: var(--gold); }

    /* Green "Verified" chip with a checkmark circle */
    .verified-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      font-size: 0.65rem;
      color: var(--sage);
      font-weight: 600;
      letter-spacing: 0.04em;
      text-transform: uppercase;
      margin-bottom: 0.8rem;
    }
    /* The green circle with ✓ inside — pure CSS, no image or extra HTML */
    .verified-badge::before {
      content: '✓';
      width: 14px; height: 14px;
      background: var(--sage);
      color: white;
      border-radius: 50%;
      display: inline-flex; align-items: center; justify-content: center;
      font-size: 0.55rem;
    }

    /* ============================================================
       SECTION 9 — PLATFORM FEATURES
    */
    .features-section { padding: 6rem 4rem; max-width: 1200px; margin: 0 auto; }

    /* 2-column grid; some cards span both columns using .wide */
    .features-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }

    .feature-card { padding: 2rem; border-radius: 1rem; transition: transform 0.25s; }

    /* Colour variants for visual variety */
    .feature-card.dark    { background: var(--ink); color: var(--white); }
    .feature-card.light   { background: var(--mist); }
    .feature-card.gold    { background: linear-gradient(135deg, rgba(200,168,75,0.1), rgba(232,208,138,0.15)); border: 1px solid rgba(200,168,75,0.2); }
    .feature-card.outline { border: 1px solid rgba(0,0,0,0.1); }

    .feature-card:hover { transform: scale(1.01); } /* Subtle grow on hover */

    .feature-icon { font-size: 1.8rem; margin-bottom: 1.2rem; }
    .feature-h    { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 600; margin-bottom: 0.6rem; }
    .feature-card.dark .feature-h   { color: var(--white); }
    .feature-p    { font-size: 0.85rem; line-height: 1.65; font-weight: 300; }
    .feature-card.dark .feature-p        { color: rgba(255,255,255,0.6); }
    .feature-card:not(.dark) .feature-p  { color: var(--stone); }

    /*
      .wide makes a card span both grid columns.
      grid-column: span 2 means "this cell takes 2 columns".
      Inside we use another 2-column grid for text + mini dashboard side by side.
    */
    .feature-card.wide {
      grid-column: span 2;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2rem;
      align-items: center;
    }

    /* Dark mini-dashboard inside the wide feature card */
    .dashboard-preview { background: var(--ink); border-radius: 0.75rem; padding: 1.2rem; }
    .dash-row   { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; }
    .dash-label { font-size: 0.7rem; color: rgba(255,255,255,0.5); }

    /* Bar chart container — flex with items aligned to the bottom */
    .dash-bars {
      display: flex;
      gap: 0.4rem;
      align-items: flex-end; /* Bars grow upward from the bottom */
      height: 60px;
      margin: 0.5rem 0 1rem;
    }

    /* Each bar in the mini chart */
    .dash-bar {
      flex: 1;
      background: rgba(255,255,255,0.1);
      border-radius: 3px 3px 0 0; /* Round only the top corners */
      transition: all 0.3s;
      cursor: pointer;
    }
    .dash-bar.active { background: var(--sage-light); } /* Highlighted bar */
    .dash-bar:hover  { background: var(--sage); }

    /* ============================================================
       SECTION 10 — TESTIMONIALS
    */
    .testimonials-section { background: var(--ink); padding: 5rem 4rem; }
    .testimonials-inner   { max-width: 1200px; margin: 0 auto; }

    .testimonials-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.5rem;
      margin-top: 3rem;
    }

    .testimonial-card {
      background: rgba(255,255,255,0.04); /* Very subtle white tint on dark bg */
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 1rem;
      padding: 2rem;
      transition: all 0.25s;
    }
    .testimonial-card:hover {
      background: rgba(255,255,255,0.07);
      transform: translateY(-2px);
    }

    .t-quote  { font-family: 'Playfair Display', serif; font-size: 2rem; color: var(--sage-light); line-height: 1; margin-bottom: 0.8rem; }
    .t-text   { font-size: 0.9rem; color: rgba(255,255,255,0.75); line-height: 1.7; font-weight: 300; margin-bottom: 1.5rem; font-style: italic; }
    .t-author { display: flex; align-items: center; gap: 0.75rem; }
    .t-avatar {
      width: 38px; height: 38px;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 0.85rem; font-weight: 600; color: white;
      flex-shrink: 0;
    }
    .t-name   { font-size: 0.85rem; font-weight: 500; color: var(--white); }
    .t-detail { font-size: 0.72rem; color: rgba(255,255,255,0.4); margin-top: 0.15rem; }

    /* ============================================================
       SECTION 11 — CALL TO ACTION (bottom CTA strip)
    */
    .cta-section {
      padding: 7rem 4rem;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    /* Large radial glow behind the text — atmospheric, not structural */
    .cta-section::before {
      content: '';
      position: absolute;
      top: 50%; left: 50%;
      transform: translate(-50%, -50%);
      width: 800px; height: 800px;
      background: radial-gradient(circle, rgba(74,103,65,0.07) 0%, transparent 70%);
      pointer-events: none;
    }
    .cta-inner { position: relative; z-index: 1; }

    .cta-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2.5rem, 5vw, 4rem);
      font-weight: 700;
      letter-spacing: -0.03em;
      line-height: 1.1;
      margin-bottom: 1.2rem;
      max-width: 700px;
      margin-left: auto; margin-right: auto; /* Centre-align the block */
    }
    .cta-title em { font-style: italic; color: var(--sage); }

    .cta-sub {
      font-size: 1rem;
      color: var(--stone);
      font-weight: 300;
      margin-bottom: 2.5rem;
      max-width: 440px;
      margin-left: auto; margin-right: auto;
      line-height: 1.7;
    }
    .cta-actions { display: flex; gap: 1rem; justify-content: center; align-items: center; flex-wrap: wrap; }
    .cta-note    { margin-top: 1.5rem; font-size: 0.78rem; color: var(--stone); }

    /* ============================================================
       SECTION 12 — FOOTER
    */
    footer { background: var(--ink); padding: 3rem 4rem 2rem; }

    /* 4-column layout: brand description + 3 link columns */
    .footer-grid {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1fr;
      gap: 3rem;
      max-width: 1200px;
      margin: 0 auto;
      padding-bottom: 2.5rem;
      border-bottom: 1px solid rgba(255,255,255,0.07);
    }

    .footer-brand-name { font-family: 'Playfair Display', serif; font-size: 1.4rem; color: var(--white); font-weight: 700; margin-bottom: 0.8rem; }
    .footer-brand-name span { color: var(--sage-light); }
    .footer-tagline    { font-size: 0.82rem; color: rgba(255,255,255,0.4); line-height: 1.6; font-weight: 300; max-width: 240px; }

    .footer-col h4 { font-size: 0.72rem; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(255,255,255,0.4); font-weight: 600; margin-bottom: 1.2rem; }
    .footer-col ul { list-style: none; }
    .footer-col ul li { margin-bottom: 0.6rem; }
    .footer-col ul a { font-size: 0.85rem; color: rgba(255,255,255,0.6); text-decoration: none; transition: color 0.2s; }
    .footer-col ul a:hover { color: var(--white); }

    /* Bottom bar: copyright + legal links */
    .footer-bottom {
      max-width: 1200px;
      margin: 0 auto;
      padding-top: 1.5rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 1rem;
    }
    .footer-copy   { font-size: 0.75rem; color: rgba(255,255,255,0.25); }
    .footer-legal  { display: flex; gap: 1.5rem; }
    .footer-legal a { font-size: 0.75rem; color: rgba(255,255,255,0.25); text-decoration: none; transition: color 0.2s; }
    .footer-legal a:hover { color: rgba(255,255,255,0.5); }

    /* ============================================================
       SECTION 13 — ANIMATIONS
       @keyframes define the start and end states of an animation.
       Elements opt in via animation: <name> <duration> <delay> <fill-mode>
    */

    /* Fade + slide up — used on hero text, staggered with delay */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* Simple fade — used on hero card */
    @keyframes fadeIn {
      from { opacity: 0; }
      to   { opacity: 1; }
    }

    /* Pulsing opacity — used on the live red dot */
    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50%       { opacity: 0.3; }
    }

    /*
      SCROLL REVEAL
      Elements with class .reveal start invisible and translated down.
      JavaScript's IntersectionObserver adds .visible when they enter
      the viewport, triggering the CSS transition to animate them in.
    */
    .reveal {
      opacity: 0;
      transform: translateY(24px);
      transition: opacity 0.7s ease, transform 0.7s ease;
    }
    .reveal.visible {
      opacity: 1;
      transform: translateY(0);
    }

    </style>
</head>

<body>

<?php include 'navbar.php'; ?>

<div <div style="padding:120px 60px; max-width:900px; margin:auto;">

    <h1 style="font-family:'Playfair Display';">Resources</h1>

    <p style="margin-top:15px; color:#666;">
        Learn practical financial strategies to improve your money management.
    </p>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(250px,1fr)); gap:20px; margin-top:30px;">

        <div style="background:white; padding:20px; border-radius:12px; box-shadow:0 5px 15px rgba(0,0,0,0.08);">
            <h3>💵 Budgeting Tips</h3>
            <p style="color:#555;">Simple ways to manage monthly expenses.</p>
        </div>

        <div style="background:white; padding:20px; border-radius:12px; box-shadow:0 5px 15px rgba(0,0,0,0.08);">
            <h3>📈 Saving Strategies</h3>
            <p style="color:#555;">Plan for future goals effectively.</p>
        </div>

        <div style="background:white; padding:20px; border-radius:12px; box-shadow:0 5px 15px rgba(0,0,0,0.08);">
            <h3>📚 Financial Knowledge</h3>
            <p style="color:#555;">Understand money management basics.</p>
        </div>

    </div>

</div>
</div>

</body>
</html>