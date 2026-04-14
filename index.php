<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Tell the browser this file is UTF-8 encoded (handles emoji, accents, etc.) -->
  <meta charset="UTF-8">

  <!-- Make the page scale correctly on phones — without this mobile looks zoomed out -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tab title and browser bookmark label -->
  <title>BudgetPro — Personalized Financial Guidance</title>

  <!-- Pre-connect hint: opens a TCP connection to Google Fonts early so fonts load faster -->
  <link rel="preconnect" href="https://fonts.googleapis.com">

  <!--
    Import two Google Fonts:
      • Playfair Display — elegant serif, used for headings
      • DM Sans         — clean sans-serif, used for body text
    The ?family= query string selects weights: 300 (light), 400 (regular), 500 (medium),
    600 (semi-bold), 700 (bold). The "ital" prefix requests italic variants too.
  -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

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
      text-decoration: none;
      color: inherit;
display: block;
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

  <!-- ============================================================
       NAV BAR
       Fixed header. Logo on the left, links on the right.
       "Pricing" has been removed from the link list.
  ============================================================ -->
  <nav>
    <!-- Logo: "Budget" in dark ink, "Pro" in sage green via <span> -->
    <div class="logo">Budget<span>Pro</span></div>

    <ul>
      <li><a href="how.php">How It Works</a></li>
      <li><a href="advisor.php">Find an Advisor</a></li>
      <li><a href="resources.php">Resources</a></li>
      <!-- nav-cta class turns this link into a filled pill button -->
      <li><a href="login.php" class="nav-cta">Get Started</a></li>
      <li><a href="register.php">Register</a><li>
    </ul>
  </nav>


  <!-- ============================================================
       HERO SECTION
       Two-column layout: headline + stats on the left,
       a fake "live session" card on the right.
  ============================================================ -->
  <section class="hero">

    <!-- Pure decorative background layer — gradient + two blurred circles via CSS pseudo-elements -->
    <div class="hero-bg"></div>

    <!-- LEFT COLUMN -->
    <div class="hero-left">

      <!-- Small pill label at the top -->
      <div class="badge">Verified Financial Experts</div>

      <!-- Main headline — <em> makes "guided" italic and green -->
      <h1 class="hero-h1">Your finances,<br><em>guided</em> by a<br>real expert.</h1>

      <!-- One-line value proposition -->
      <p class="hero-sub">
        Connect one-on-one with a vetted CFP, CPA, or AFC advisor — via live video —
        and walk away with a personalized, actionable budget plan built for your life.
      </p>

      <!-- Two CTA buttons side by side -->
      <div class="hero-actions">
        <a href="#" class="btn-primary btn-large">Match Me with an Advisor →</a>
        <a href="#" class="btn-ghost">Watch how it works ▶</a>
      </div>

      <!-- Three headline stats below the buttons -->
      <div class="hero-stats">
        <div>
          <div class="stat-num">1,200+</div>
          <div class="stat-label">Verified Advisors</div>
        </div>
        <div>
          <div class="stat-num">4.9★</div>
          <div class="stat-label">Average Rating</div>
        </div>
        <div>
          <div class="stat-num">94%</div>
          <div class="stat-label">Goal Achievement</div>
        </div>
      </div>
    </div><!-- /hero-left -->


    <!-- RIGHT COLUMN — Fake session card mockup -->
    <div class="hero-right">
      <div class="hero-card">

        <!-- Dark green "video" area at the top of the card -->
        <div class="card-video-stub">

          <!-- Red LIVE badge — top left corner -->
          <div class="card-live-tag">
            <span class="live-dot"></span>LIVE SESSION
          </div>

          <!-- SVG play button in the centre -->
          <div class="play-btn">
            <!-- Inline SVG triangle — no image file needed -->
            <svg width="16" height="16" viewBox="0 0 16 16">
              <path d="M4 2l10 6-10 6z"/>
            </svg>
          </div>

          <!-- Advisor chip at the bottom left -->
          <div class="advisor-thumb">
            <div class="thumb-avatar">SR</div>
            <div>
              <div class="thumb-name">Sarah R.</div>
              <div class="thumb-cred">CFP · Debt Strategy</div>
            </div>
          </div>
        </div><!-- /card-video-stub -->

        <!-- Card body: progress bars + action items -->
        <div class="card-body">
          <div class="session-title">Emergency Fund Goal</div>

          <!-- Progress bar 1 — width animated by JS after page loads -->
          <div class="progress-row">
            <span class="progress-label">Fund Progress</span>
            <span class="progress-val">45% Complete</span>
          </div>
          <div class="progress-bar">
            <div class="progress-fill" id="pb1" style="width:0%"></div>
          </div>

          <!-- Progress bar 2 — gold gradient, set in inline style below -->
          <div class="progress-row">
            <span class="progress-label">Monthly Savings Rate</span>
            <span class="progress-val">$640 / mo</span>
          </div>
          <div class="progress-bar">
            <div class="progress-fill" id="pb2"
                 style="width:0%; background: linear-gradient(90deg, var(--gold), var(--gold-light));"></div>
          </div>

          <!-- Checklist of action items from the advisor -->
          <div class="action-items">
            <div class="action-item">
              <div class="action-check done">✓</div>
              <span>Negotiate Chase card interest rate</span>
            </div>
            <div class="action-item">
              <div class="action-check done">✓</div>
              <span>Maximize 401k employer match</span>
            </div>
            <div class="action-item">
              <!-- "pending" class = grey circle with number, not a checkmark -->
              <div class="action-check pending">3</div>
              <span>Set up automatic transfers</span>
            </div>
          </div>
        </div><!-- /card-body -->

      </div><!-- /hero-card -->
    </div><!-- /hero-right -->

  </section><!-- /hero -->


  <!-- ============================================================
       TRUSTED BY BAR
       Dark strip of publication names for social proof.
  ============================================================ -->
  <div class="trusted-bar">
    <span class="trusted-label">As featured in</span>
    <div class="trusted-logos">
      <span class="trust-logo">Forbes</span>
      <span class="trust-logo">The Wall Street Journal</span>
      <span class="trust-logo">NerdWallet</span>
      <span class="trust-logo">Investopedia</span>
      <span class="trust-logo">CNBC</span>
    </div>
  </div>


  <!-- ============================================================
       HOW IT WORKS — 6-step process cards
       The .reveal class makes this section fade+slide up when
       it enters the viewport (handled by IntersectionObserver in JS).
  ============================================================ -->
  <div style="background: var(--white);">
    <div class="section reveal">

      <div class="section-eyebrow">The Process</div>
      <h2 class="section-title">From intake to action plan — in one session.</h2>
      <div class="divider"></div>
      <p class="section-sub">
        No generic advice. Every session ends with a written, prioritized plan
        tailored specifically to your financial situation.
      </p>

      <!-- 3-column grid of steps (CSS handles the 3-col layout) -->
      <div class="steps-grid">

        <a href="profile.php" class="step-card">
          <div class="step-num">01</div>
          <div class="step-icon">📋</div>
          <h3 class="step-h">Complete Your Profile</h3>
          <p class="step-p">Answer a short questionnaire about your income, debt, goals, and challenges. Our algorithm uses this to shortlist your ideal advisors instantly.</p>
</a>

        <div class="step-card">
          <div class="step-num">02</div>
          <div class="step-icon">🤝</div>
          <h3 class="step-h">Free 15-Min Fit Call</h3>
          <p class="step-p">Book a complimentary intro session with your top match. Chemistry matters — confirm you're aligned before committing to a full consultation.</p>
        </div>

        <div class="step-card">
          <div class="step-num">03</div>
          <div class="step-icon">📊</div>
          <h3 class="step-h">Live Video Session</h3>
          <p class="step-p">Meet via our secure, built-in video platform. Share screens, review real spending data, and build your cash flow model together in real time.</p>
        </div>

        <div class="step-card">
          <div class="step-num">04</div>
          <div class="step-icon">📄</div>
          <h3 class="step-h">Receive Your Action Plan</h3>
          <p class="step-p">Your advisor delivers a written, prioritized roadmap. Specific steps, deadlines, and targets — not vague suggestions you won't act on.</p>
        </div>

        <div class="step-card">
          <div class="step-num">05</div>
          <div class="step-icon">🎯</div>
          <h3 class="step-h">Track Your Milestones</h3>
          <p class="step-p">The platform tracks progress toward every goal. Visualize your debt payoff, savings rate, and net worth over time, all in one dashboard.</p>
        </div>

        <div class="step-card">
          <div class="step-num">06</div>
          <div class="step-icon">🔄</div>
          <h3 class="step-h">Book Follow-Up Sessions</h3>
          <p class="step-p">As your life evolves, return for check-in sessions. Your advisor already knows your full history — no starting from scratch, ever.</p>
        </div>

      </div><!-- /steps-grid -->
    </div>
  </div>


  <!-- ============================================================
       ADVISOR MARKETPLACE
       4-column grid of advisor profile cards.
       Pricing ($95/hr etc.) has been removed from each card.
  ============================================================ -->
  <div class="advisors-section">
    <div class="advisors-inner reveal">

      <div class="advisors-header">
        <div>
          <div class="section-eyebrow">The Experts</div>
          <h2 class="section-title" style="margin-bottom:0">
            Rigorously vetted.<br>Genuinely experienced.
          </h2>
        </div>
        <a href="#" class="btn-primary">Browse All Advisors →</a>
      </div>

      <div class="advisors-grid">

        <!-- Each advisor card follows the same structure:
             avatar → verified badge → name → credentials → specialty → footer (stars only) -->

        <div class="advisor-card">
          <!-- Gradient avatar circle with initials -->
          <div class="advisor-avatar" style="background:linear-gradient(135deg,#4a6741,#7a9e71)">SR</div>
          <div class="verified-badge">Verified</div>
          <div class="advisor-name">Sarah Reeves</div>
          <div class="advisor-cred">CFP · CPA</div>
          <div class="advisor-spec">Student loan strategy, early retirement planning, tax-efficient investing</div>
          <div class="advisor-footer">
            <!-- Pricing removed — footer now shows only star rating -->
            <span class="advisor-stars">★★★★★ 4.97</span>
          </div>
        </div>

        <div class="advisor-card">
          <div class="advisor-avatar" style="background:linear-gradient(135deg,#2d4a6d,#4a7a9e)">JM</div>
          <div class="verified-badge">Verified</div>
          <div class="advisor-name">James Morales</div>
          <div class="advisor-cred">AFC · FINRA</div>
          <div class="advisor-spec">Debt consolidation, credit repair, household budgeting for families</div>
          <div class="advisor-footer">
            <span class="advisor-stars">★★★★★ 4.94</span>
          </div>
        </div>

        <div class="advisor-card">
          <div class="advisor-avatar" style="background:linear-gradient(135deg,#6d4a2d,#9e7a4a)">PK</div>
          <div class="verified-badge">Verified</div>
          <div class="advisor-name">Priya Kapoor</div>
          <div class="advisor-cred">CFP · MBA</div>
          <div class="advisor-spec">Small business finances, self-employed tax planning, retirement accounts</div>
          <div class="advisor-footer">
            <span class="advisor-stars">★★★★★ 4.98</span>
          </div>
        </div>

        <div class="advisor-card">
          <div class="advisor-avatar" style="background:linear-gradient(135deg,#4a2d6d,#7a4a9e)">DW</div>
          <div class="verified-badge">Verified</div>
          <div class="advisor-name">David Wong</div>
          <div class="advisor-cred">CPA · EA</div>
          <div class="advisor-spec">Immigrant financial planning, cross-border tax, first-generation wealth building</div>
          <div class="advisor-footer">
            <span class="advisor-stars">★★★★★ 4.96</span>
          </div>
        </div>

      </div><!-- /advisors-grid -->
    </div>
  </div>


  <!-- ============================================================
       PLATFORM FEATURES
       Mixed 2-column card grid. The last card spans both columns
       and shows a mini bar chart dashboard alongside the copy.
  ============================================================ -->
  <div class="features-section reveal">

    <div class="section-eyebrow">Platform Features</div>
    <h2 class="section-title">Everything for a secure, productive session.</h2>
    <div class="divider"></div>
    <div style="height:2.5rem"></div>

    <div class="features-grid">

      <!-- Dark card -->
      <div class="feature-card dark">
        <div class="feature-icon">🔒</div>
        <div class="feature-h">Encrypted Document Vault</div>
        <p class="feature-p">Share tax returns, bank statements, and debt letters via our dedicated,
          end-to-end encrypted portal. Your documents never leave our secure servers unprotected.</p>
      </div>

      <!-- Light (mist) card -->
      <div class="feature-card light">
        <div class="feature-icon">📹</div>
        <div class="feature-h">Built-In Video + Screen Share</div>
        <p class="feature-p">No Zoom. No third-party apps. Our native, HIPAA-grade video allows
          advisors to co-browse your budget spreadsheet with you in real time, in one place.</p>
      </div>

      <!-- Gold-tinted card -->
      <div class="feature-card gold">
        <div class="feature-icon">🏦</div>
        <div class="feature-h">Bank Account Integration</div>
        <p class="feature-p">Optionally connect accounts via Plaid. Your advisor sees your real
          spending data — not estimates — enabling more precise, data-driven guidance from minute one.</p>
      </div>

      <!-- Outlined card -->
      <div class="feature-card outline">
        <div class="feature-icon">📈</div>
        <div class="feature-h">Goal &amp; Milestone Dashboard</div>
        <p class="feature-p">Track your emergency fund, debt payoff, and savings goals visually.
          Progress data feeds directly into every follow-up session you book.</p>
      </div>

      <!--
        Wide card: spans both grid columns.
        Inside: two sub-columns — text left, mini dashboard right.
      -->
      <div class="feature-card light wide">

        <!-- Left side: copy + button -->
        <div>
          <div class="feature-icon">💬</div>
          <div class="feature-h">Shared Budget Builder</div>
          <p class="feature-p">
            Advisors and clients co-create cash flow models live within the platform.
            Build scenario models, adjust assumptions in real time, and save every version
            for future reference. Your entire financial plan lives here permanently.
          </p>
          <div style="margin-top:1.5rem">
            <a href="#" class="btn-primary">Explore All Features →</a>
          </div>
        </div>

        <!-- Right side: decorative mini bar chart -->
        <div class="dashboard-preview">

          <div class="dash-row">
            <span class="dash-label">MONTHLY SPENDING</span>
            <span style="font-size:0.7rem; color:var(--sage-light); font-weight:600;">↓ 12% vs last month</span>
          </div>

          <!--
            Six bars. Heights are set inline (55%, 70%…).
            JS adds a hover effect that briefly increases each bar's height.
          -->
          <div class="dash-bars">
            <div class="dash-bar" style="height:55%"></div>
            <div class="dash-bar" style="height:70%"></div>
            <div class="dash-bar" style="height:45%"></div>
            <div class="dash-bar" style="height:80%"></div>
            <div class="dash-bar" style="height:60%"></div>
            <div class="dash-bar active" style="height:50%"></div> <!-- Highlighted (current month) -->
          </div>

          <!-- Two stat boxes below the chart -->
          <div style="display:flex; gap:1rem; margin-top:0.5rem;">
            <div style="flex:1; background:rgba(255,255,255,0.05); border-radius:0.5rem; padding:0.7rem;">
              <div style="font-size:0.65rem; color:rgba(255,255,255,0.4); margin-bottom:0.3rem;">SAVINGS RATE</div>
              <div style="font-family:'Playfair Display',serif; color:var(--sage-light); font-size:1.2rem; font-weight:600;">22.4%</div>
            </div>
            <div style="flex:1; background:rgba(255,255,255,0.05); border-radius:0.5rem; padding:0.7rem;">
              <div style="font-size:0.65rem; color:rgba(255,255,255,0.4); margin-bottom:0.3rem;">DEBT REMAINING</div>
              <div style="font-family:'Playfair Display',serif; color:var(--gold-light); font-size:1.2rem; font-weight:600;">$14,200</div>
            </div>
          </div>

        </div><!-- /dashboard-preview -->
      </div><!-- /wide card -->

    </div><!-- /features-grid -->
  </div><!-- /features-section -->


  <!-- ============================================================
       TESTIMONIALS
       3 quote cards on a dark background.
  ============================================================ -->
  <div class="testimonials-section">
    <div class="testimonials-inner reveal">

      <div class="section-eyebrow" style="color:var(--sage-light)">Client Stories</div>
      <h2 class="section-title" style="color:var(--white)">Real results from real sessions.</h2>

      <div class="testimonials-grid">

        <div class="testimonial-card">
          <div class="t-quote">"</div>
          <p class="t-text">
            In 60 minutes, Sarah showed me exactly how to shave $380/month from my budget without
            sacrificing anything I actually care about. The action plan she sent was specific enough
            that I could start the very next morning.
          </p>
          <div class="t-author">
            <div class="t-avatar" style="background:linear-gradient(135deg,#4a6741,#7a9e71)">AM</div>
            <div>
              <div class="t-name">Alexis M.</div>
              <div class="t-detail">Paid off $18k in 14 months</div>
            </div>
          </div>
        </div>

        <div class="testimonial-card">
          <div class="t-quote">"</div>
          <p class="t-text">
            I'd been putting off dealing with my student loans for three years. One session with James
            and I had a refinancing plan and a 26-month payoff date written down. I only wish I'd done
            this sooner.
          </p>
          <div class="t-author">
            <div class="t-avatar" style="background:linear-gradient(135deg,#2d4a6d,#4a7a9e)">RT</div>
            <div>
              <div class="t-name">Ryan T.</div>
              <div class="t-detail">On track to clear $34k in student loans</div>
            </div>
          </div>
        </div>

        <div class="testimonial-card">
          <div class="t-quote">"</div>
          <p class="t-text">
            As a freelancer, my income swings wildly. Priya built a variable income budgeting system
            with me live on screen. I finally feel in control for the first time in five years of
            self-employment.
          </p>
          <div class="t-author">
            <div class="t-avatar" style="background:linear-gradient(135deg,#6d4a2d,#9e7a4a)">LC</div>
            <div>
              <div class="t-name">Laura C.</div>
              <div class="t-detail">Freelance designer · 3 sessions</div>
            </div>
          </div>
        </div>

      </div><!-- /testimonials-grid -->
    </div>
  </div>


  <!-- ============================================================
       CALL TO ACTION (bottom of page)
  ============================================================ -->
  <section class="cta-section">
    <div class="cta-inner reveal">
      <div class="section-eyebrow" style="text-align:center">Start Today</div>
      <h2 class="cta-title">Your financial clarity is<br>one session <em>away.</em></h2>
      <p class="cta-sub">
        Answer a few questions and we'll match you with the right advisor in minutes.
        Your first intro call is always free.
      </p>
      <div class="cta-actions">
        <a href="#" class="btn-primary btn-large">Find My Advisor — It's Free</a>
      </div>
      <p class="cta-note">No credit card required &nbsp;·&nbsp; Free 15-min intro session &nbsp;·&nbsp; 1,200+ verified experts</p>
    </div>
  </section>


  <!-- ============================================================
       FOOTER
       4-column grid: brand description + 3 link columns.
       "Pricing" link removed from the "For Advisors" column.
  ============================================================ -->
  <footer>
    <div class="footer-grid">

      <!-- Brand column -->
      <div>
        <div class="footer-brand-name">Budget<span>Pro</span></div>
        <p class="footer-tagline">Personalized financial guidance from verified experts. Live. One-on-one. Actionable.</p>
      </div>

      <!-- Platform links -->
      <div class="footer-col">
        <h4>Platform</h4>
        <ul>
          <li><a href="#">Find an Advisor</a></li>
          <li><a href="#">How It Works</a></li>
          <li><a href="#">Budget Builder</a></li>
          <li><a href="#">Goal Tracker</a></li>
        </ul>
      </div>

      <!-- For Advisors links — "Pricing" removed -->
      <div class="footer-col">
        <h4>For Advisors</h4>
        <ul>
          <li><a href="#">Join the Network</a></li>
          <li><a href="#">Vetting Process</a></li>
          <li><a href="#">Advisor Tools</a></li>
        </ul>
      </div>

      <!-- Company links -->
      <div class="footer-col">
        <h4>Company</h4>
        <ul>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Security</a></li>
          <li><a href="#">Blog</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </div>

    </div><!-- /footer-grid -->

    <!-- Bottom bar -->
    <div class="footer-bottom">
      <span class="footer-copy">© 2026 BudgetPro Inc. All rights reserved.</span>
      <div class="footer-legal">
        <a href="#">Privacy Policy</a>
        <a href="#">Terms of Service</a>
        <a href="#">Security</a>
      </div>
    </div>

  </footer>


  <!-- ============================================================
       JAVASCRIPT
       Three small, self-contained behaviours:
         1. Scroll reveal — fade sections in as the user scrolls
         2. Progress bar animation — bars grow from 0 on load
         3. Dashboard bar hover — bars grow taller on mouseenter
  ============================================================ -->
  <script>

    /* ── 1. SCROLL REVEAL ────────────────────────────────────────
       IntersectionObserver is a browser API that fires a callback
       whenever a watched element enters or exits the viewport.
       This lets us trigger animations without listening to the
       scroll event (which is slow because it fires dozens of times
       per second).

       How it works:
         • We collect every element with class="reveal"
         • When one enters the viewport (threshold: 10% visible),
           we add the "visible" class
         • The CSS transition on .reveal handles the actual animation
         • We then unobserve the element so it never fires again
    */
    const scrollObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible'); // Triggers the CSS transition
            scrollObserver.unobserve(entry.target); // Stop watching — animate once only
          }
        });
      },
      { threshold: 0.1 } // Fire when 10% of the element is visible
    );

    // Attach the observer to every .reveal element on the page
    document.querySelectorAll('.reveal').forEach((el) => {
      scrollObserver.observe(el);
    });


    /* ── 2. PROGRESS BAR ANIMATION ───────────────────────────────
       On page load the bars start at width:0% (set in the HTML).
       After 700ms we set them to their target widths.
       Because the CSS has "transition: width 1.2s …", the browser
       smoothly animates from 0% to the target — no JS animation loop needed.
    */
    setTimeout(() => {
      const bar1 = document.getElementById('pb1');
      const bar2 = document.getElementById('pb2');
      if (bar1) bar1.style.width = '45%'; // Emergency fund: 45% complete
      if (bar2) bar2.style.width = '68%'; // Savings rate bar
    }, 700); // 700ms delay lets the page finish rendering first


    /* ── 3. DASHBOARD BAR HOVER ──────────────────────────────────
       Each bar in the mini chart gets a hover effect where it grows
       taller, then shrinks back when the mouse leaves.

       We capture the original height (set inline in the HTML) and
       add 15% on mouseenter, then restore it on mouseleave.
    */
    document.querySelectorAll('.dash-bar').forEach((bar) => {
      const originalHeight = bar.style.height; // e.g. "55%"

      bar.addEventListener('mouseenter', () => {
        // parseFloat("55%") gives 55; we add 15 to get 70, then add "%" back
        bar.style.height = (parseFloat(originalHeight) + 15) + '%';
      });

      bar.addEventListener('mouseleave', () => {
        bar.style.height = originalHeight; // Restore original
      });
    });

  </script>

</body>
</html>
