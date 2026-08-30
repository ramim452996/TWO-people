<!DOCTYPE html>
<html lang="en" id="html-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('office.app_name', 'Office Task Tracker') }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <!-- Chart.js for Pie Charts and Visualizations -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        // Apply dark mode before render to avoid flash
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <style>
        /* ===== MOBILE VIEW SIMULATION ===== */
        body.mobile-view-active {
            background-color: #0f172a !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            padding: 24px 0 40px !important;
        }
        body.mobile-view-active .mobile-frame {
            width: 390px;
            min-height: 844px;
            border-radius: 40px;
            overflow: hidden;
            border: 8px solid #1e293b;
            box-shadow:
                0 0 0 2px #334155,
                0 30px 80px -10px rgba(0,0,0,0.6),
                inset 0 0 0 2px #0f172a;
            position: relative;
            background: white;
            transition: all 0.4s ease;
        }
        body.dark.mobile-view-active .mobile-frame,
        .dark body.mobile-view-active .mobile-frame {
            background: #0f172a;
        }
        /* Notch */
        body.mobile-view-active .mobile-frame::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 28px;
            background: #1e293b;
            border-radius: 0 0 20px 20px;
            z-index: 100;
        }
        /* Side buttons */
        body.mobile-view-active .mobile-frame::after {
            content: '';
            position: absolute;
            top: 100px;
            right: -10px;
            width: 4px;
            height: 40px;
            background: #334155;
            border-radius: 4px;
            box-shadow: 0 55px 0 #334155;
        }
        body.mobile-view-active .mobile-frame-inner {
            height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
            padding-top: 28px;
            scrollbar-width: thin;
            scrollbar-color: #6366f1 transparent;
        }
        body.mobile-view-active .mobile-frame-inner::-webkit-scrollbar {
            width: 3px;
        }
        body.mobile-view-active .mobile-frame-inner::-webkit-scrollbar-thumb {
            background: #6366f1;
            border-radius: 99px;
        }
        /* Label under phone */
        body.mobile-view-active .device-label {
            display: flex;
        }
        .device-label {
            display: none;
        }

        /* View toggle button styles */
        .view-toggle-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            border: 1.5px solid;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .view-toggle-btn.desktop-mode {
            border-color: #c7d2fe;
            background-color: #e0e7ff;
            color: #3730a3;
        }
        .dark .view-toggle-btn.desktop-mode {
            border-color: #4338ca;
            background-color: #1e1b4b;
            color: #c7d2fe;
        }
        .view-toggle-btn.mobile-mode {
            border-color: #93c5fd;
            background-color: #dbeafe;
            color: #1e40af;
        }
        .dark .view-toggle-btn.mobile-mode {
            border-color: #1d4ed8;
            background-color: #1e3a8a;
            color: #bfdbfe;
        }
        .view-toggle-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99,102,241,0.25);
        }
    </style>
</head>
<body class="font-sans bg-slate-50 text-gray-800 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-200" id="app-body">

    {{-- Mobile frame wrapper (only active when class is toggled) --}}
    <div class="mobile-frame" id="mobile-frame">
      <div class="mobile-frame-inner" id="mobile-frame-inner">

    {{-- ===== NAVBAR ===== --}}
    <nav class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 dark:border-gray-700/60 transition-colors duration-200" id="app-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-between items-center min-h-[4rem] py-2 gap-3">
                {{-- Left: Logo + 3 Navigation Menus --}}
                <div class="flex items-center flex-wrap gap-2 sm:gap-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group mr-2">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-md shadow-indigo-500/25 group-hover:scale-105 transition-transform duration-200">
                            <i class="fas fa-check-double text-white text-sm"></i>
                        </div>
                        <span class="font-bold text-base tracking-tight text-gray-800 dark:text-white hidden md:inline">
                            {{ config('office.app_name', 'Office Task Tracker') }}
                        </span>
                    </a>

                    {{-- Menu 1: Homepage --}}
                    <a href="{{ route('home') }}"
                       class="flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-200
                              {{ request()->routeIs('home')
                                    ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-500/30'
                                    : 'text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                        <i class="fas fa-home text-xs"></i>
                        <span>Homepage</span>
                    </a>

                    {{-- Menu 2: Dashboard --}}
                    <a href="{{ route('tasks.index') }}"
                       class="flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-200
                              {{ request()->routeIs('tasks.index') && !request()->routeIs('tasks.list')
                                    ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-500/30'
                                    : 'text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                        <i class="fas fa-tachometer-alt text-xs"></i>
                        <span>Dashboard</span>
                    </a>

                    {{-- Menu 3: Tasks --}}
                    <a href="{{ route('tasks.list') }}"
                       class="flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-200
                              {{ request()->routeIs('tasks.list')
                                    ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-500/30'
                                    : 'text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                        <i class="fas fa-list-check text-xs"></i>
                        <span>Tasks</span>
                    </a>
                </div>

                {{-- Right Controls --}}
                <div class="flex items-center gap-2.5 ml-auto">

                    {{-- View Toggle Button (Mobile/Desktop) --}}
                    <button id="view-toggle-btn" type="button"
                            class="view-toggle-btn desktop-mode"
                            title="Switch between mobile and desktop view">
                        <i id="view-toggle-icon" class="fas fa-mobile-alt"></i>
                        <span id="view-toggle-label">Mobile</span>
                    </button>

                    {{-- Dark/Light Mode Toggle --}}
                    <button id="theme-toggle" type="button"
                            class="w-10 h-10 flex items-center justify-center rounded-xl transition-all duration-200
                                   bg-gray-100 dark:bg-gray-700/60 border border-gray-200 dark:border-gray-600
                                   text-gray-600 dark:text-amber-400 hover:bg-gray-200 dark:hover:bg-gray-600 cursor-pointer shadow-sm"
                            title="Toggle dark/light mode">
                        <i id="theme-toggle-dark-icon" class="fas fa-moon text-indigo-600 text-sm"></i>
                        <i id="theme-toggle-light-icon" class="fas fa-sun text-amber-400 text-sm hidden"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 pt-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6 flex items-center gap-2" role="alert">
                <i class="fas fa-check-circle text-green-500"></i>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @yield('content')

        @if(isset($slot))
            {{ $slot }}
        @endif
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-white dark:bg-gray-800 border-t dark:border-gray-700 mt-12 py-6 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center text-gray-400 dark:text-gray-500 text-xs gap-3">
            <div>
                &copy; {{ date('Y') }} {{ config('office.company_name', 'Company') }}. All rights reserved.
                &nbsp;|&nbsp;
                <a href="mailto:{{ config('office.company_email') }}" class="hover:text-indigo-500 dark:hover:text-indigo-400 transition-colors">
                    {{ config('office.company_email') }}
                </a>
            </div>

            @if(app()->environment('local'))
                <div class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-500 rounded-full font-semibold text-xs">
                    <i class="fas fa-code mr-1"></i> Environment: Development
                </div>
            @endif
        </div>
    </footer>

      </div>{{-- /mobile-frame-inner --}}
    </div>{{-- /mobile-frame --}}

    {{-- Device label shown below phone frame --}}
    <div class="device-label flex-col items-center mt-4 gap-1" id="device-label">
        <div class="w-24 h-1.5 bg-slate-700 rounded-full"></div>
        <p class="text-slate-500 text-xs mt-1">Mobile Preview — 390 × 844</p>
    </div>

    {{-- ====================== SCRIPTS ====================== --}}
    <script>
    (function() {

        // ─── DARK MODE ───────────────────────────────────────────
        var darkIcon  = document.getElementById('theme-toggle-dark-icon');
        var lightIcon = document.getElementById('theme-toggle-light-icon');
        var themeBtn  = document.getElementById('theme-toggle');

        function applyThemeIcons() {
            var isDark = document.documentElement.classList.contains('dark');
            darkIcon.classList.toggle('hidden', isDark);
            lightIcon.classList.toggle('hidden', !isDark);
        }
        applyThemeIcons();

        themeBtn.addEventListener('click', function () {
            var isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('color-theme', isDark ? 'dark' : 'light');
            applyThemeIcons();
        });

        // ─── VIEW TOGGLE ─────────────────────────────────────────
        var body       = document.getElementById('app-body');
        var frame      = document.getElementById('mobile-frame');
        var viewBtn    = document.getElementById('view-toggle-btn');
        var viewIcon   = document.getElementById('view-toggle-icon');
        var viewLabel  = document.getElementById('view-toggle-label');
        var deviceLbl  = document.getElementById('device-label');

        var isMobile = localStorage.getItem('view-mode') === 'mobile';

        function applyViewMode(mobile) {
            if (mobile) {
                body.classList.add('mobile-view-active');
                frame.style.display = '';
                deviceLbl.style.display = 'flex';
                viewIcon.className  = 'fas fa-desktop';
                viewLabel.textContent = 'Desktop View';
                viewBtn.classList.remove('desktop-mode');
                viewBtn.classList.add('mobile-mode');
            } else {
                body.classList.remove('mobile-view-active');
                frame.style.display = '';
                deviceLbl.style.display = 'none';
                viewIcon.className  = 'fas fa-mobile-alt';
                viewLabel.textContent = 'Mobile View';
                viewBtn.classList.remove('mobile-mode');
                viewBtn.classList.add('desktop-mode');
            }
        }

        applyViewMode(isMobile);

        viewBtn.addEventListener('click', function () {
            isMobile = !isMobile;
            localStorage.setItem('view-mode', isMobile ? 'mobile' : 'desktop');
            applyViewMode(isMobile);
        });

    })();
    </script>
</body>
</html>
