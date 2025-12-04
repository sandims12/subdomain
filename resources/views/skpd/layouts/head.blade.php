<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEGALENGKO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* cegah geser kiri–kanan */
        body {
            overflow-x: hidden;
        }

        .skpd-footer {
            position: relative;
            z-index: 1;         
            color: #ffffff;     
            text-shadow: 0 1px 3px rgba(0,0,0,.5);
            background: transparent;
        }

        /* ====== SIDEBAR – glass transparan (ASLI) ====== */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background-color: rgba(255, 255, 255, 0.06);
            border-right: 1px solid rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .sidebar a {
            color: #333;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #0d6efd;
            color: white;
            border-radius: 6px;
        }
        .sidebar .active {
            background-color: #0d6efd;
            color: white;
        }

        .main-content {
            padding: 20px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        /* ====== SIDEBAR DENGAN ID (#sidebar) ====== */
        #sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;                                   /* posisi awal */
            background-color: rgba(255, 255, 255, 0.06);
            border-right: 1px solid rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            transition: left 0.6s ease;               /* animasi geser pakai LEFT */
        }

        /* ==== tombol toggle (titik tiga) ==== */
        #sidebar-toggle {
            position: fixed;
            top: 16px;
            left: 16px;              
            width: 32px;
            height: 32px;
            padding: 0;
            border-radius: 999px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            background: rgba(0, 0, 0, 0.35);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 20;
            transition: all 0.2s ease-in-out;
        }

        #sidebar-toggle i {
            font-size: 18px;
            color: #0d6efd;
        }

        #sidebar-toggle:hover {
            transform: translateY(-1px);
            background: rgba(0,0,0,0.55);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.22);
        }

        /* ====== KONTEN YANG IKUT GESER ====== */
        .skpd-page-inner {
            margin-left: 250px;                       /* saat sidebar terbuka */
            transition: margin-left 0.3s ease;
        }

        body.sidebar-collapsed .skpd-page-inner {
            margin-left: 0;                           /* saat sidebar ditutup */
        }

        /* Dropdown Profil */
        .dropdown-menu {
            border-radius: 12px;
            animation: fadeIn 0.2s ease-in-out;
        }
        .dropdown-item:hover {
            background-color: #f1f1f1;
            border-radius: 8px;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ====== ANIMASI PERPINDAHAN HALAMAN (tanpa transform) ====== */
        .skpd-main-content {
            opacity: 0;
            margin-top: 8px;                                    /* ganti dari transform */
            animation: skpdPageEnter 0.4s ease-out 0.05s forwards;
        }

        .skpd-main-content.skpd-page-leave {
            animation: skpdPageLeave 0.25s ease-in forwards;
        }

        @keyframes skpdPageEnter {
            from {
                opacity: 0;
                margin-top: 14px;
            }
            to {
                opacity: 1;
                margin-top: 0;
            }
        }

        @keyframes skpdPageLeave {
            from {
                opacity: 1;
                margin-top: 0;
            }
            to {
                opacity: 0;
                margin-top: 14px;
            }
        }
    </style>
</head>
