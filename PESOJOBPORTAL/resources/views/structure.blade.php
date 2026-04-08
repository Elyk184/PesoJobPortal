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
        @media (max-width: 768px) { .page-title { font-size: 2.5rem; } .section-header h2 { font-size: 2rem; } }
        @media (max-width: 576px) { .page-title { font-size: 2rem; } .team-card { padding: 1.5rem; } .team-card .avatar { width: 80px; height: 80px; } .team-card .avatar svg { width: 40px; height: 40px; } .team-card.manager-card .avatar { width: 100px; height: 100px; } }
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
                <div class="row justify-content-center mb-4">
                    <div class="col-md-6 col-lg-4">
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
                <div class="row justify-content-center mb-4">
                    <div class="col-md-6 col-lg-4 mb-3">
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
                <div class="row justify-content-center mb-4">
                    <div class="col-md-6 col-lg-4 mb-3">
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
                    <div class="col-md-6 col-lg-4 mb-3">
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
                    <div class="col-md-6 col-lg-4 mb-3">
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
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-4 mb-3">
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
                    <div class="col-md-6 col-lg-4 mb-3">
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
            </div>
        </section>
    </main>
    <x-footer />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
