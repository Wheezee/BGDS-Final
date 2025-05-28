<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'BGDS')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        /* Mobile blur effect */
        .content-wrapper {
            filter: none;
        }

        @media (max-width: 768px) {
            #sidebar.active + #content .content-wrapper {
                filter: blur(5px) !important;
            }
        }
        
        /* Dark mode styles */
        :root {
            --primary-purple: #6f42c1;
            --light-purple: #e9ecef;
            --dark-purple: #563d7c;
        }

        [data-theme="dark"] {
            --primary-purple: #9d7ad1;
            --light-purple: #2d2d2d;
            --dark-purple: #7b4cbf;
        }

        [data-theme="dark"] body {
            background-color: #1a1a1a;
            color: #ffffff;
        }

        [data-theme="dark"] .card {
            background-color: #2d2d2d;
            color: #ffffff;
            border-color: #3d3d3d;
        }

        [data-theme="dark"] .card-header {
            background-color: #3d2966 !important;
            border-color: #3d2966 !important;
            color: #fff !important;
        }

        [data-theme="dark"] .stat-card {
            background-color: #2d2d2d;
            color: #ffffff;
        }

        [data-theme="dark"] .sidebar-link {
            color: #ffffff;
        }

        [data-theme="dark"] .submenu {
            background: #3d3d3d;
        }

        [data-theme="dark"] #sidebar {
            background: #2d2d2d;
        }

        [data-theme="dark"] .sidebar-header {
            background: #3d3d3d;
        }

        /* Form elements in dark mode */
        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background-color: #2d2d2d;
            border-color: #3d3d3d;
            color: #ffffff;
        }

        [data-theme="dark"] .form-control:focus,
        [data-theme="dark"] .form-select:focus {
            background-color: #2d2d2d;
            border-color: var(--primary-purple);
            color: #ffffff;
            box-shadow: 0 0 0 0.25rem rgba(157, 122, 209, 0.25);
        }

        [data-theme="dark"] .form-control::placeholder {
            color: #6c757d;
        }

        [data-theme="dark"] .form-label {
            color: #ffffff;
        }

        /* Enhanced Button Styles */
        [data-theme="dark"] .btn {
            transition: all 0.2s ease-in-out;
        }

        [data-theme="dark"] .btn-primary {
            background-color: var(--primary-purple) !important;
            border-color: var(--primary-purple) !important;
            color: #fff !important;
        }

        [data-theme="dark"] .btn-primary:hover {
            background-color: var(--dark-purple) !important;
            border-color: var(--dark-purple) !important;
            color: #fff !important;
        }

        [data-theme="dark"] .btn-primary:active {
            transform: translateY(0);
            box-shadow: none;
        }

        [data-theme="dark"] .btn-outline-primary {
            color: var(--primary-purple);
            border-color: var(--primary-purple);
            background-color: transparent;
        }

        [data-theme="dark"] .btn-outline-primary:hover {
            background-color: var(--primary-purple);
            border-color: var(--primary-purple);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        [data-theme="dark"] .btn-outline-primary:active {
            transform: translateY(0);
            box-shadow: none;
        }

        [data-theme="dark"] .btn-secondary {
            background-color: #3d3d3d;
            border-color: #3d3d3d;
            color: #ffffff;
        }

        [data-theme="dark"] .btn-secondary:hover {
            background-color: #4d4d4d;
            border-color: #4d4d4d;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Enhanced Table Styles */
        [data-theme="dark"] .table,
        [data-theme="dark"] .table thead,
        [data-theme="dark"] .table tbody,
        [data-theme="dark"] .table tr,
        [data-theme="dark"] .table th,
        [data-theme="dark"] .table td {
            background-color: #181818 !important;
            color: #fff !important;
            border-color: #3d3d3d !important;
        }
        [data-theme="dark"] .table-striped tbody tr:nth-of-type(even) {
            background-color: #232323 !important;
        }
        [data-theme="dark"] .table-striped tbody tr:nth-of-type(odd) {
            background-color: #1a1a1a !important;
        }
        [data-theme="dark"] .table-hover tbody tr:hover {
            background-color: #333 !important;
        }
        [data-theme="dark"] .table td,
        [data-theme="dark"] .table th {
            color: #fff !important;
            border-color: #3d3d3d !important;
        }

        [data-theme="dark"] .table-bordered {
            border-color: #3d3d3d;
        }

        [data-theme="dark"] .table-bordered th,
        [data-theme="dark"] .table-bordered td {
            border-color: #3d3d3d;
        }

        [data-theme="dark"] .modal-content,
        [data-theme="dark"] .modal-content * {
            background-color: #23202b !important;
            color: #fff !important;
            border-color: #3d3d3d !important;
        }
        [data-theme="dark"] .modal-header,
        [data-theme="dark"] .modal-header.bg-light,
        [data-theme="dark"] .modal-header.bg-white,
        [data-theme="dark"] .modal-footer,
        [data-theme="dark"] .modal-footer.bg-light,
        [data-theme="dark"] .modal-footer.bg-white {
            background-color: #2a2540 !important;
            color: #fff !important;
            border-color: #3d3d3d !important;
        }
        
        body {
            min-height: 100vh;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }
        
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
            background: var(--primary-purple);
            color: #fff;
            transition: all 0.3s;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
        }
        
        #sidebar.active {
            margin-left: -250px;
        }
        
        #content {
            width: calc(100% - 250px);
            padding: 15px;
            min-height: 100vh;
            transition: all 0.3s;
            position: absolute;
            right: 0;
        }
        
        #content.active {
            width: 100%;
        }
        
        .container-fluid {
            padding: 1rem;
            margin: 0;
        }
        
        .sidebar-header {
            padding: 20px;
            background: var(--dark-purple);
        }
        
        .sidebar-link {
            color: #fff;
            padding: 10px 20px;
            display: block;
            text-decoration: none;
            transition: 0.3s;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .sidebar-link:hover {
            background: var(--dark-purple);
            color: #fff;
        }
        
        .sidebar-link i {
            margin-right: 10px;
        }
        
        #sidebarCollapse {
            background: var(--primary-purple);
            border-color: var(--primary-purple);
            display: none;
        }
        
        .card {
            position: relative;
            overflow: hidden;
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            transition: box-shadow 0.3s, transform 0.2s cubic-bezier(.03,.98,.52,.99);
            will-change: transform, box-shadow;
        }
        .card::before {
            content: '';
            position: absolute;
            left: 0; top: 0; right: 0; bottom: 0;
            pointer-events: none;
            border-radius: 10px;
            transition: opacity 0.3s;
            opacity: 0;
            z-index: 2;
            background: var(--border-light, none);
        }
        .card.border-light-active::before {
            opacity: 1;
        }
        .card.interactive-hover {
            cursor: pointer;
        }
        
        .card-header {
            background-color: var(--primary-purple);
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }

        .card-header {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .card-header > div {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        @media (min-width: 768px) {
            .card-header {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        .stat-card i {
            font-size: 2.5rem;
            color: var(--primary-purple);
            margin-bottom: 10px;
        }

        .stat-card h3 {
            font-size: 2rem;
            margin: 10px 0;
            color: var(--dark-purple);
        }

        .stat-card p {
            color: #6c757d;
            margin: 0;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .user-profile {
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .user-profile span {
            line-height: 1;
        }
        
        .submenu {
            padding-left: 40px;
            background: var(--dark-purple);
            margin-left: 10px;
            border-left: 2px solid rgba(255, 255, 255, 0.1);
        }
        
        .submenu .sidebar-link {
            padding: 8px 20px;
            font-size: 0.9rem;
            position: relative;
        }
        
        .submenu .sidebar-link::before {
            content: '';
            position: absolute;
            left: -10px;
            top: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            transform: translateY(-50%);
        }
        
        .submenu .sidebar-link:hover::before {
            background: white;
        }
        
        .submenu .sidebar-link i {
            font-size: 0.8rem;
            margin-right: 8px;
        }
        
        .sidebar-link[data-bs-toggle="collapse"] {
            position: relative;
        }
        
        .sidebar-link[data-bs-toggle="collapse"] i:last-child {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            transition: transform 0.3s;
        }
        
        .sidebar-link[data-bs-toggle="collapse"][aria-expanded="true"] i:last-child {
            transform: translateY(-50%) rotate(180deg);
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .form-section-title {
            color: var(--dark-purple);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--light-purple);
        }

        .info-section {
            margin-bottom: 2rem;
        }

        .info-section-title {
            color: var(--dark-purple);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--light-purple);
        }

        .info-label {
            font-weight: 600;
            color: var(--dark-purple);
            margin-bottom: 0.5rem;
        }

        .info-value {
            background: rgba(255,255,255,0.05) !important;
            color: #fff !important;
            border: 1px solid #444 !important;
            box-shadow: 0 1px 4px 0 #0002;
            backdrop-filter: blur(2px);
        }

        .required-field::after {
            content: '*';
            color: red;
            margin-left: 4px;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }
            
            #sidebar.active {
                margin-left: 0;
            }
            
            #content {
                width: 100%;
                padding: 10px;
            }
            
            #content.active {
                width: calc(100% - 250px);
            }
            
            .container-fluid {
                padding: 0;
                margin: 0;
            }
            
            #sidebarCollapse {
                display: block;
            }
            
            .table-responsive {
                margin-bottom: 1rem;
            }
            
            .card {
                margin-bottom: 15px;
            }
            
            .stat-card {
                padding: 15px;
            }
            
            .stat-card h3 {
                font-size: 1.5rem;
            }
            
            .stat-card i {
                font-size: 2rem;
            }
            
            .chart-container {
                height: 250px;
            }
            
            .form-section {
                margin-bottom: 1.5rem;
            }
            
            .info-section {
                margin-bottom: 1.5rem;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
            
            .btn-group {
                width: 100%;
            }
            
            .btn-group .btn {
                margin-bottom: 0;
            }
            
            .modal-dialog {
                margin: 0.5rem;
            }
            
            .modal-content {
                border-radius: 0.5rem;
            }
            
            .table th, .table td {
                padding: 0.5rem;
            }
            
            .user-profile {
                flex-direction: column;
                text-align: center;
            }
            
            .user-profile img {
                margin-bottom: 0.5rem;
            }
            /* --- ADDED: Sticky navbar and content padding for mobile --- */
            .navbar {
                position: sticky;
                top: 0;
                z-index: 1050;
            }
            #content .content-wrapper {
                padding-top: 56px; /* Height of navbar */
            }
            .container-fluid {
                padding: 1rem;
            }
        }

        /* Small Mobile Devices */
        @media (max-width: 576px) {
            .container-fluid {
                padding: 10px;
            }
            
            .card-header {
                padding: 0.75rem;
            }
            
            .card-body {
                padding: 1rem;
            }
            
            .stat-card {
                padding: 10px;
            }
            
            .stat-card h3 {
                font-size: 1.25rem;
            }
            
            .stat-card i {
                font-size: 1.75rem;
            }
            
            .chart-container {
                height: 200px;
            }
            
            .form-label {
                margin-bottom: 0.25rem;
            }
            
            .form-control {
                padding: 0.375rem 0.75rem;
            }
            
            .btn {
                padding: 0.375rem 0.75rem;
            }
        }

        /* Action buttons in dark mode */
        [data-theme="dark"] .btn-info {
            background-color: #6ec1e4 !important;
            border-color: #6ec1e4 !important;
            color: #222 !important;
        }
        [data-theme="dark"] .btn-info:hover {
            background-color: #4fa3c7 !important;
            border-color: #4fa3c7 !important;
            color: #fff !important;
        }
        [data-theme="dark"] .btn-warning {
            background-color: #c299fc;
            border-color: #c299fc;
            color: #222;
        }
        [data-theme="dark"] .btn-warning:hover {
            background-color: #a678e6;
            border-color: #a678e6;
            color: #fff;
        }
        [data-theme="dark"] .btn-danger {
            background-color: #ff6b6b !important;
            border-color: #ff6b6b !important;
            color: #fff !important;
        }
        [data-theme="dark"] .btn-danger:hover {
            background-color: #d9534f !important;
            border-color: #d9534f !important;
            color: #fff !important;
        }

        [data-theme="dark"] .table thead th,
        [data-theme="dark"] .table thead th a {
            color: #fff !important;
        }

        .sidebar-link.w-100.text-start.border-0.bg-transparent:hover,
        [data-theme="dark"] .sidebar-link:hover {
            background: #2a2150 !important;
            color: #fff !important;
            border-radius: 8px;
            box-shadow: 0 0 8px 0 #7e6bb7cc;
            transition: background 0.2s, box-shadow 0.2s;
        }
        [data-theme="dark"] .btn:hover {
            box-shadow: 0 0 8px 0 #7e6bb7cc;
            filter: brightness(1.1);
            transition: box-shadow 0.2s, filter 0.2s;
        }

        /* 1. Sidebar icon color in dark mode */
        [data-theme="dark"] .sidebar-link i {
            color: #b39ddb !important;
            transition: color 0.2s;
        }

        /* 2. Card header purple less saturated in dark mode */
        [data-theme="dark"] .card-header {
            background-color: #7e6bb7 !important;
            border-color: #7e6bb7 !important;
        }

        .sidebar-bottom-box {
            background: #f3f3f3;
            border-radius: 10px;
            margin-bottom: 10px;
            padding: 10px 0;
            box-shadow: 0 1px 4px 0 rgba(0,0,0,0.04);
        }
        [data-theme="dark"] .sidebar-bottom-box {
            background: #1a1530;
            box-shadow: 0 1px 8px 0 #0002;
        }
        .sidebar-bottom-box .sidebar-link {
            color: #222;
        }
        [data-theme="dark"] .sidebar-bottom-box .sidebar-link {
            color: #fff;
        }

        a.sidebar-link,
        button.sidebar-link {
            transition: background 0.2s, box-shadow 0.2s, color 0.2s;
        }
        a.sidebar-link:hover, a.sidebar-link:focus,
        button.sidebar-link:hover, button.sidebar-link:focus {
            background: #2a2150 !important;
            color: #fff !important;
            border-radius: 8px;
            box-shadow: 0 0 8px 0 #7e6bb7cc;
            outline: none;
        }

        .sidebar-spacer {
            height: 2rem;
            border: none;
            background: none;
            pointer-events: none;
        }

        [data-theme="dark"] .modal-body,
        [data-theme="dark"] .modal-content > div,
        [data-theme="dark"] .modal-content > form,
        [data-theme="dark"] .modal-content > *:not(.modal-header):not(.modal-footer) {
            background-color: #23202b !important;
            color: #fff !important;
        }

        [data-theme="dark"] .message-bubble.message-assistant {
            background-color: #2a2540 !important;
            color: #fff !important;
            border: 1px solid #3d3d3d;
            box-shadow: 0 1px 4px 0 #0002;
        }
        [data-theme="dark"] .message-bubble.message-user {
            background-color: var(--primary-purple) !important;
            color: #fff !important;
            border: 1px solid #3d3d3d;
            box-shadow: 0 1px 4px 0 #0002;
        }

        [data-theme="dark"] #chat-container,
        [data-theme="dark"] .bg-white,
        [data-theme="dark"] .bg-light {
            background-color: #23202b !important;
        }

        [data-theme="dark"] #chat-container.bg-white,
        [data-theme="dark"] #chat-container.bg-white * {
            background-color: #23202b !important;
        }

        [data-theme="dark"] .btn-close {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath stroke='white' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M2 2l12 12M14 2L2 14'/%3e%3c/svg%3e") !important;
            filter: none !important;
            opacity: 0.9;
        }
        [data-theme="dark"] .btn-close:hover {
            opacity: 1;
            box-shadow: 0 0 4px #fff8;
        }

        [data-theme="dark"] .meeting-details {
            background: rgba(255,255,255,0.05) !important;
            color: #fff !important;
            border: 1px solid #444 !important;
            box-shadow: 0 1px 4px 0 #0002;
            backdrop-filter: blur(2px);
        }
        [data-theme="dark"] .meeting-details .label,
        [data-theme="dark"] .meeting-details h4 {
            color: #b39ddb !important;
        }

        [data-theme="dark"] .transcription {
            background: rgba(255,255,255,0.08) !important;
            color: #fff !important;
            border: 1px solid #444 !important;
            box-shadow: 0 1px 4px 0 #0002;
            backdrop-filter: blur(2px);
        }
    </style>
    @stack('styles')
    <script>
      try {
        var theme = localStorage.getItem('theme');
        if (theme) document.documentElement.setAttribute('data-theme', theme);
      } catch(e){}
    </script>
</head>
<body>
    <div class="wrapper">
        @include('layouts.partials.sidebar')
        
        <div id="content">
            @include('layouts.partials.navbar')
            
            <div class="content-wrapper">
                <div class="container-fluid mt-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function () {
            // Prevent event propagation for all interactive elements
            $(document).on('click', '.btn, .card, .modal, .dropdown-menu, [data-bs-toggle], [data-bs-target], [onclick], a, button, input, select, textarea', function(e) {
                e.stopPropagation();
            });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');
            });

            // Close sidebar when clicking outside on mobile
            $(document).on('click', function(e) {
                if ($(window).width() <= 768) {
                    if (e.target === document.body) {
                        $('#sidebar').addClass('active');
                        $('#content').addClass('active');
                    }
                }
            });

            // Handle window resize
            $(window).resize(function() {
                if ($(window).width() > 768) {
                    $('#sidebar').removeClass('active');
                    $('#content').removeClass('active');
                }
            });

            // Dark mode toggle
            const darkModeToggle = document.getElementById('darkModeToggle');
            const icon = darkModeToggle.querySelector('i');
            
            // Check for saved theme preference
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                icon.classList.replace('bi-moon-fill', 'bi-sun-fill');
            }

            darkModeToggle.addEventListener('click', () => {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                document.documentElement.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                
                if (newTheme === 'dark') {
                    icon.classList.replace('bi-moon-fill', 'bi-sun-fill');
                } else {
                    icon.classList.replace('bi-sun-fill', 'bi-moon-fill');
                }
                // Remove focus so hover/focus style doesn't stick
                darkModeToggle.blur();
            });

            // Interactive card hover effect
            function handleCardHover(e) {
                const card = e.currentTarget;
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                const shadowX = ((x - centerX) / centerX) * 12; // max 12px
                const shadowY = ((y - centerY) / centerY) * 12;
                card.style.boxShadow = `${-shadowX}px ${shadowY}px 32px 0 rgba(111,66,193,0.15), 0 2px 15px 0 rgba(0,0,0,0.08)`;
                // Border lights effect
                const percentX = (x / rect.width) * 100;
                const percentY = (y / rect.height) * 100;
                card.classList.add('border-light-active');
                card.style.setProperty('--border-light', `radial-gradient(circle at ${percentX}% ${percentY}%, rgba(157,122,209,0.07) 0, rgba(157,122,209,0.03) 8%, transparent 18%)`);
                card.style.setProperty('--border-light-pos', `${percentX}% ${percentY}%`);
                card.style.setProperty('--border-light-x', percentX);
                card.style.setProperty('--border-light-y', percentY);
                card.style.setProperty('--border-light-opacity', 1);
                card.style.setProperty('--border-light-size', '100% 100%');
                card.style.setProperty('--border-light-radius', '10px');
                card.style.setProperty('--border-light-z', 2);
                card.style.setProperty('--border-light-transition', 'opacity 0.3s');
                card.style.setProperty('--border-light-pointer-events', 'none');
                card.style.setProperty('--border-light-border-radius', '10px');
                card.style.setProperty('--border-light-z-index', 2);
                card.style.setProperty('--border-light-content', "''");
                card.style.setProperty('--border-light-display', 'block');
                card.style.setProperty('--border-light-background', `radial-gradient(circle at ${percentX}% ${percentY}%, rgba(157,122,209,0.07) 0, rgba(157,122,209,0.03) 8%, transparent 18%)`);
                card.style.setProperty('--border-light-opacity', 1);
                card.style.setProperty('--border-light-transition', 'opacity 0.3s');
                card.style.setProperty('--border-light-pointer-events', 'none');
                card.style.setProperty('--border-light-border-radius', '10px');
                card.style.setProperty('--border-light-z-index', 2);
            }
            function resetCardHover(e) {
                const card = e.currentTarget;
                card.style.boxShadow = '';
                card.classList.remove('border-light-active');
                card.style.setProperty('--border-light-opacity', 0);
            }
            // Add to all .card elements
            document.querySelectorAll('.card').forEach(card => {
                card.classList.add('interactive-hover');
                card.addEventListener('mousemove', handleCardHover);
                card.addEventListener('mouseleave', resetCardHover);
            });
        });
    </script>
    @stack('scripts')
</body>
</html> 