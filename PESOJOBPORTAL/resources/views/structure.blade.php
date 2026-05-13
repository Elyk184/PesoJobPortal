<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>PESO Organizational Structure</title>
    @if (file_exists(public_path('images/PESO.png')))
        <link rel="icon" href="{{ asset('images/PESO.png') }}" type="image/png">
        <link rel="apple-touch-icon" href="{{ asset('images/PESO.png') }}">
    @else
        <link rel="icon" href="https://bangaaklan.gov.ph/wp-content/uploads/2025/07/logo-peso.png" type="image/png">
        <link rel="apple-touch-icon" href="https://bangaaklan.gov.ph/wp-content/uploads/2025/07/logo-peso.png">
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css'])
    @else   
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif
    <style>
        body { background: none !important; color: inherit !important; }
        .site-header { background-color: #001a4d; border-bottom: 3px solid #ffd700; }
        .btn-primary { background-color: #ff4444; border-color: #ff4444; }
        .btn-primary:hover { background-color: #cc0000; }
        .site-footer { background: linear-gradient(to right, #FF0000 0%, #FF0000 10%, #000000 20%, #030112 30%, #03010f 40%, #09012a 50%, #010135 60%, #02256a 100%) !important; border-top: 3px solid #ffd700; color: #ffffff; }
        h1, h2, h3 { color: #001a4d; }
        .page-header { background: #ffffff; padding: 60px 0; position: relative; border-left: 5px solid #ff4444; border-right: 5px solid #ff4446; }
        .page-header::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: #ff4444; }
        .page-header::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: #ff4444; }
        .page-title { color: #001a4d; font-size: 3rem; font-weight: 700; text-align: center; text-transform: uppercase; letter-spacing: 3px; margin-bottom: 10px; }
        .page-subtitle { color: #666666; text-align: center; font-size: 1.2rem; }
        .team-section { padding: 4rem 0; background: linear-gradient(rgba(255, 255, 255, 0.85), rgba(255, 255, 255, 0.85)), url('{{ asset("images/LogoPNG.png") }}'); background-size: 600px; background-position: center; background-repeat: no-repeat; }
        .section-header { text-align: center; margin-bottom: 3rem; }
        .section-header h2 { color: #001a4d; font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; }
        .section-header .title-line { width: 80px; height: 3px; background: linear-gradient(90deg, #ff4444, #ffd700); margin: 0 auto; }
        .team-card { background: #ffffff; border: 2px solid #001a4d; border-radius: 15px; padding: 2rem; text-align: center; height: 100%; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); }
        .team-card:hover { transform: translateY(-10px); border-color: #ff4444; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2); }
        .team-card .avatar { width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, #001a4d 0%, #02205c 100%); margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; border: 3px solid #ffd700; }
        .team-card .avatar svg { width: 50px; height: 50px; color: #ffd700; }
        .team-card h3 { color: #001a4d; font-size: 1.1rem; margin-bottom: 0.5rem; font-weight: 700; }
        .team-card .position { color: #ff4444; font-size: 0.9rem; font-weight: 600; }
        .team-card.manager-card { background: linear-gradient(135deg, #001a4d 0%, #02205c 100%); border: 3px solid #ffd700; }
        .team-card.manager-card .avatar { width: 130px; height: 130px; border-width: 4px; }
        .team-card.manager-card h3 { color: #ffd700; font-size: 1.3rem; }
        .team-card.manager-card .position { color: #ffffff; }
        .org-chart { --connector-color: #274f86; --connector-width: 3px; --connector-gap: 34px; --bridge-gap: 26px; max-width: 1180px; margin: 0 auto; position: relative; }
        .org-level { position: relative; }
        .org-level--root, .org-level--single { display: flex; justify-content: center; }
        .org-level--three, .org-level--two { display: grid; position: relative; justify-items: center; gap: 18px; }
        .org-level--three { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .org-level--two { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .org-item { position: relative; display: flex; flex-direction: column; align-items: center; width: 100%; }
        .org-item--root::before { display: none; }
        .org-drop { width: var(--connector-width); height: var(--connector-gap); background: var(--connector-color); margin: 0 auto; border-radius: 999px; }
        .org-drop--short { height: calc(var(--connector-gap) - 8px); }
        .org-bridge-row { display: flex; align-items: stretch; width: 100%; margin: 0 auto; position: relative; }
        .org-bridge-row::before,
        .org-bridge-row::after {
            content: '';
            position: absolute;
            top: 0;
            width: var(--connector-width);
            height: var(--bridge-gap);
            background: var(--connector-color);
            border-radius: 999px;
        }
        .org-bridge-row::before { left: 50%; transform: translateX(-50%); }
        .org-bridge-row::after { display: none; }
        .org-bridge { position: absolute; top: 0; left: 0; right: 0; height: var(--connector-width); background: var(--connector-color); border-radius: 999px; }
        .org-bridge--three { left: 14%; right: 14%; }
        .org-bridge--two { left: 24%; right: 24%; }
        .org-branch { position: relative; display: flex; justify-content: center; align-items: flex-start; flex: 1 1 0; }
        .org-branch::before { content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: var(--connector-width); height: var(--connector-gap); background: var(--connector-color); border-radius: 999px; }
        .org-branch--wide::before { height: calc(var(--connector-gap) + 4px); }
        @media (max-width: 768px) { .page-title { font-size: 2.5rem; } .section-header h2 { font-size: 2rem; } }
        @media (max-width: 576px) { .page-title { font-size: 2rem; } .team-card { padding: 1.5rem; } .team-card .avatar { width: 80px; height: 80px; } .team-card .avatar svg { width: 40px; height: 40px; } .team-card.manager-card .avatar { width: 100px; height: 100px; } .org-chart { --connector-gap: 28px; --bridge-gap: 18px; } .org-level--three { gap: 12px; } .org-level--two { gap: 12px; } .org-bridge--three { left: 8%; right: 8%; } .org-bridge--two { left: 16%; right: 16%; } }
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>PESO Organizational Structure</title>
        @if (file_exists(public_path('images/PESO.png')))
            <link rel="icon" href="{{ asset('images/PESO.png') }}" type="image/png">
            <link rel="apple-touch-icon" href="{{ asset('images/PESO.png') }}">
        @else
            <link rel="icon" href="https://bangaaklan.gov.ph/wp-content/uploads/2025/07/logo-peso.png" type="image/png">
            <link rel="apple-touch-icon" href="https://bangaaklan.gov.ph/wp-content/uploads/2025/07/logo-peso.png">
        @endif
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        @if (file_exists(public_path('build/manifest.json')))
            @vite(['resources/css/app.css'])
        @else
            <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @endif
        <style>
            /* ── Base ── */
            body { background: none !important; color: inherit !important; }
            .site-header { background-color: #001a4d; border-bottom: 3px solid #ffd700; }
            .btn-primary { background-color: #ff4444; border-color: #ff4444; }
            .btn-primary:hover { background-color: #cc0000; }
            .site-footer {
                background: linear-gradient(to right,
                    #FF0000 0%, #FF0000 10%,
                    #000000 20%, #030112 30%, #03010f 40%,
                    #09012a 50%, #010135 60%, #02256a 100%) !important;
                border-top: 3px solid #ffd700;
                color: #ffffff;
            }
            h1, h2, h3 { color: #001a4d; }

            /* ── Section ── */
            .team-section {
                padding: 4rem 0;
                background:
                    linear-gradient(rgba(255,255,255,0.85), rgba(255,255,255,0.85)),
                    url('{{ asset("images/LogoPNG.png") }}');
                background-size: 600px;
                background-position: center;
                background-repeat: no-repeat;
            }
            .section-header { text-align: center; margin-bottom: 3rem; }
            .section-header h2 { color: #001a4d; font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; }
            .section-header .title-line {
                width: 80px; height: 3px;
                background: linear-gradient(90deg, #ff4444, #ffd700);
                margin: 0 auto;
            }

            /* ── Cards ── */
            .team-card {
                background: #ffffff;
                border: 2px solid #001a4d;
                border-radius: 15px;
                padding: 2rem;
                text-align: center;
                width: 100%;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                box-sizing: border-box;
            }
            .team-card:hover {
                transform: translateY(-6px);
                border-color: #ff4444;
                box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            }
            .team-card .avatar {
                width: 100px; height: 100px;
                border-radius: 50%;
                background: linear-gradient(135deg, #001a4d 0%, #02205c 100%);
                margin: 0 auto 1rem;
                display: flex; align-items: center; justify-content: center;
                border: 3px solid #ffd700;
            }
            .team-card .avatar svg { width: 50px; height: 50px; color: #ffd700; }
            .team-card h3 { color: #001a4d; font-size: 1.05rem; margin-bottom: 0.4rem; font-weight: 700; }
            .team-card .position { color: #ff4444; font-size: 0.88rem; font-weight: 600; margin: 0; }

            /* Manager card */
            .team-card.manager-card {
                background: linear-gradient(135deg, #001a4d 0%, #02205c 100%);
                border: 3px solid #ffd700;
            }
            .team-card.manager-card .avatar { width: 130px; height: 130px; border-width: 4px; }
            .team-card.manager-card h3 { color: #ffd700; font-size: 1.25rem; }
            .team-card.manager-card .position { color: #ffffff; }

            /* ── Org chart layout ── */
            .org-chart {
                --line-color: #274f86;
                --line-w: 3px;
                max-width: 1100px;
                margin: 0 auto;
            }

            /* Each level is a flex/grid row */
            .org-row {
                display: flex;
                justify-content: center;
                gap: 20px;
            }
            .org-row--three { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
            .org-row--two   { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }

            /* A node = the card itself, full width of its grid cell */
            .org-node { width: 100%; }

            /*
             * ── Connector system ──
             * We build connectors using a wrapper <div class="org-connectors">
             * that sits BETWEEN two levels. It contains:
             *   - .org-drop-in  : vertical line dropping OUT of the parent
             *   - .org-hbar     : horizontal bridge
             *   - .org-drop-out : container for the per-child vertical drops
             *
             * Key principle: every vertical segment is sized to exactly bridge the
             * gap between elements, so no line can bleed into a card.
             */
            .org-connectors {
                display: flex;
                flex-direction: column;
                align-items: center;
                width: 100%;
            }

            /* Vertical drop from parent card bottom to the horizontal bridge */
            .org-drop-in {
                width: var(--line-w);
                height: 28px;
                background: var(--line-color);
                border-radius: 999px;
                flex-shrink: 0;
            }

            /* Horizontal bridge row — holds the bar + per-child drop lines */
            .org-hbar-row {
                position: relative;
                width: 100%;
                height: var(--line-w);
            }
            .org-hbar {
                position: absolute;
                top: 0;
                height: var(--line-w);
                background: var(--line-color);
                border-radius: 999px;
            }
            /* Bridge spans between the centre of first and last child */
            .org-hbar--three { left: calc(100% / 6 + 1.5px); right: calc(100% / 6 + 1.5px); }
            .org-hbar--two   { left: calc(18% + 1.5px);        right: calc(18% + 1.5px); }

            /* The three/two drop lines hang down from the bridge */
            .org-drops-row {
                display: grid;
                width: 100%;
                margin-top: 0;       /* touching the bridge */
            }
            .org-drops-row--three { grid-template-columns: repeat(3, 1fr); }
            .org-drops-row--two   { grid-template-columns: repeat(2, 1fr); }

            .org-drop-out {
                display: flex;
                justify-content: center;
            }
            .org-drop-out::before {
                content: '';
                display: block;
                width: var(--line-w);
                height: 28px;
                background: var(--line-color);
                border-radius: 999px;
            }

            /* ── Responsive ── */
            @media (max-width: 768px) {
                .section-header h2 { font-size: 2rem; }
                .org-row--three { grid-template-columns: 1fr; }
                .org-row--two   { grid-template-columns: 1fr; }
                .org-hbar--three { left: 1px; right: 1px; }
                .org-hbar--two { left: 18%; right: 18%; }
                .org-drops-row--three { grid-template-columns: 1fr; }
                .org-drops-row--two   { grid-template-columns: 1fr; }
            }
            @media (max-width: 576px) {
                .team-card { padding: 1.4rem; }
                .team-card .avatar { width: 80px; height: 80px; }
                .team-card .avatar svg { width: 40px; height: 40px; }
                .team-card.manager-card .avatar { width: 100px; height: 100px; }
            }
        </style>
    </head>
    <body class="peso-body">
        <x-navbar />
        <main>
            <section class="team-section">
                <div class="container">
                    <div class="section-header">
                        <h2>PESO Organizational Structure</h2>
                        <div class="title-line"></div>
                    </div>

                    <div class="org-chart">

                        <!-- ══ LEVEL 1 : Manager ══ -->
                        <div class="org-row">
                            <div class="org-node" style="max-width:320px;">
                                <div class="team-card manager-card">
                                    <div class="avatar">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                            <circle cx="12" cy="7" r="4"/>
                                        </svg>
                                    </div>
                                    <h3>LORRAINE A. REQUINTON</h3>
                                    <p class="position">MGDH 1 PESO MANAGER</p>
                                </div>
                            </div>
                        </div>

                        <!-- Connector: Manager → Abella (single drop, no bridge needed) -->
                        <div class="org-connectors">
                            <div class="org-drop-in"></div>
                        </div>

                        <!-- ══ LEVEL 2 : Abella ══ -->
                        <div class="org-row">
                            <div class="org-node" style="max-width:340px;">
                                <div class="team-card">
                                    <div class="avatar">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                            <circle cx="12" cy="7" r="4"/>
                                        </svg>
                                    </div>
                                    <h3>JOANNE B. ABELLA</h3>
                                    <p class="position">Administrative Aide IV (Clerk II), Casual</p>
                                </div>
                            </div>
                        </div>

                        <!-- Connector: Abella → 3 children -->
                        <div class="org-connectors">
                            <!-- drop from Abella card bottom to bridge -->
                            <div class="org-drop-in"></div>
                            <!-- horizontal bridge -->
                            <div class="org-hbar-row" style="width:100%;">
                                <div class="org-hbar org-hbar--three"></div>
                            </div>
                            <!-- three drop lines down to each child card top -->
                            <div class="org-drops-row org-drops-row--three" style="width:100%;">
                                <div class="org-drop-out"></div>
                                <div class="org-drop-out"></div>
                                <div class="org-drop-out"></div>
                            </div>
                        </div>

                        <!-- ══ LEVEL 3 : Three staff ══ -->
                        <div class="org-row org-row--three">
                            <div class="org-node">
                                <div class="team-card">
                                    <div class="avatar">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                            <circle cx="12" cy="7" r="4"/>
                                        </svg>
                                    </div>
                                    <h3>JALOU L. CABUNOC</h3>
                                    <p class="position">Administrative Aide IV (Clerk II), Casual</p>
                                </div>
                            </div>
                            <div class="org-node">
                                <div class="team-card">
                                    <div class="avatar">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                            <circle cx="12" cy="7" r="4"/>
                                        </svg>
                                    </div>
                                    <h3>RUTCHELLE ROSAL</h3>
                                    <p class="position">Administrative Aide IV (Clerk II), JO</p>
                                </div>
                            </div>
                            <div class="org-node">
                                <div class="team-card">
                                    <div class="avatar">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                            <circle cx="12" cy="7" r="4"/>
                                        </svg>
                                    </div>
                                    <h3>JEROME B. SIGONGAN</h3>
                                    <p class="position">Administrative Assistant II (Clerk IV), JO</p>
                                </div>
                            </div>
                        </div>

                        <!-- Connector: Level 3 center → 2 children -->
                        <div class="org-connectors">
                            <!-- drop from center (Rosal) card bottom to bridge -->
                            <div class="org-drop-in"></div>
                            <!-- horizontal bridge -->
                            <div class="org-hbar-row" style="width:66.666%;">
                                <div class="org-hbar" style="left:0;right:0;"></div>
                            </div>
                            <!-- two drop lines down to each child card top -->
                            <div class="org-drops-row org-drops-row--two" style="width:66.666%;">
                                <div class="org-drop-out"></div>
                                <div class="org-drop-out"></div>
                            </div>
                        </div>

                        <!-- ══ LEVEL 4 : Lagat & Ubagan ══ -->
                        <div class="org-row" style="justify-content:center; width:66.666%; margin:0 auto;">
                            <div class="org-node" style="flex:1;">
                                <div class="team-card">
                                    <div class="avatar">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                            <circle cx="12" cy="7" r="4"/>
                                        </svg>
                                    </div>
                                    <h3>YOLANDA LAGAT</h3>
                                    <p class="position">Administrative Aide I (Utility), JO</p>
                                </div>
                            </div>
                            <div class="org-node" style="flex:1;">
                                <div class="team-card">
                                    <div class="avatar">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                            <circle cx="12" cy="7" r="4"/>
                                        </svg>
                                    </div>
                                    <h3>RENELITO A. UBAGAN</h3>
                                    <p class="position">Watchman 1, JO</p>
                                </div>
                            </div>
                        </div>

                    </div><!-- /.org-chart -->
                </div><!-- /.container -->
            </section>
        </main>
        <x-footer />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
