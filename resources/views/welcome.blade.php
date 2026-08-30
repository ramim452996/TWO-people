<!DOCTYPE html>
<html lang="en" id="html-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('office.app_name', 'Office Task Tracker') }} | Welcome</title>
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
    <!-- Apply theme BEFORE render to prevent flash -->
    <script>
        if (localStorage.getItem('color-theme') === 'dark' ||
            (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
            box-shadow: 0 0 0 2px #334155, 0 30px 80px -10px rgba(0,0,0,0.7), inset 0 0 0 2px #0f172a;
            position: relative;
            background: #0f172a;
        }
        body.mobile-view-active .mobile-frame::before {
            content: '';
            position: absolute;
            top: 0; left: 50%; transform: translateX(-50%);
            width: 120px; height: 28px;
            background: #1e293b;
            border-radius: 0 0 20px 20px;
            z-index: 100;
        }
        body.mobile-view-active .mobile-frame::after {
            content: '';
            position: absolute; top: 100px; right: -10px;
            width: 4px; height: 40px;
            background: #334155; border-radius: 4px;
            box-shadow: 0 55px 0 #334155;
        }
        body.mobile-view-active .mobile-frame-inner {
            height: 100%; overflow-y: auto; overflow-x: hidden;
            padding-top: 28px;
            scrollbar-width: thin; scrollbar-color: #6366f1 transparent;
        }
        body.mobile-view-active .mobile-frame-inner::-webkit-scrollbar { width: 3px; }
        body.mobile-view-active .mobile-frame-inner::-webkit-scrollbar-thumb { background: #6366f1; border-radius: 99px; }
        .device-label { display: none; }
        body.mobile-view-active .device-label { display: flex; }

        /* View toggle button */
        .view-toggle-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 14px; border-radius: 12px;
            font-size: 13px; font-weight: 700; cursor: pointer;
            border: 1.5px solid; transition: all 0.2s ease; white-space: nowrap;
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

        /* Dark mode glassmorphism */
        .glass-dark {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        /* Light mode glassmorphism */
        .glass-light {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 8px 32px rgba(79, 70, 229, 0.08);
        }
        .gradient-text {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(to right, #4f46e5, #7c3aed);
        }
        .dark .gradient-text {
            background-image: linear-gradient(to right, #60a5fa, #c084fc);
        }
        .float-anim {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%   { transform: translateY(0px); }
            50%  { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .blob {
            position: absolute;
            filter: blur(80px);
            z-index: 0;
            pointer-events: none;
        }
        /* Smooth transition for theme switching */
        html { transition: background-color 0.3s ease, color 0.3s ease; }
        body { transition: background-color 0.3s ease, color 0.3s ease; }
    </style>
</head>
<body class="font-sans antialiased overflow-x-hidden min-h-screen relative
             bg-slate-50 text-gray-900
             dark:bg-gray-950 dark:text-white
             transition-colors duration-300">

    <!-- ===== LIGHT MODE BACKGROUND ===== -->
    <div class="dark:hidden">
        <div class="blob bg-indigo-200 opacity-60 w-[500px] h-[500px] rounded-full top-0 right-0 translate-x-1/3 -translate-y-1/3"></div>
        <div class="blob bg-purple-200 opacity-50 w-96 h-96 rounded-full bottom-0 left-0 -translate-x-1/4 translate-y-1/4"></div>
        <div class="blob bg-blue-100 opacity-70 w-80 h-80 rounded-full top-1/2 left-1/3 -translate-y-1/2"></div>
    </div>

    <!-- ===== DARK MODE BACKGROUND ===== -->
    <div class="hidden dark:block pointer-events-none">
        <div class="blob bg-blue-600 opacity-60 w-96 h-96 rounded-full top-0 left-0 -translate-x-1/2 -translate-y-1/2 mix-blend-screen"></div>
        <div class="blob bg-purple-600 opacity-60 w-96 h-96 rounded-full bottom-0 right-0 translate-x-1/3 translate-y-1/3 mix-blend-screen"></div>
        <div class="blob bg-indigo-500 opacity-30 w-80 h-80 rounded-full top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 mix-blend-screen"></div>
    </div>

    {{-- Mobile frame wrapper --}}
    <div class="mobile-frame" id="mobile-frame">
      <div class="mobile-frame-inner" id="mobile-frame-inner">

        <!-- Content wrapper -->
        <div class="relative z-10 flex flex-col min-h-screen">

        <!-- ===== NAVBAR ===== -->
        <nav class="w-full px-6 py-4 md:px-12 flex flex-wrap justify-between items-center gap-4">
            <!-- Left: Logo + 3 Navigation Menus -->
            <div class="flex items-center flex-wrap gap-2 sm:gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group mr-2">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-md shadow-indigo-500/25 group-hover:scale-105 transition-transform duration-200">
                        <i class="fas fa-check-double text-white text-sm"></i>
                    </div>
                    <span class="font-bold text-base tracking-tight text-gray-800 dark:text-white hidden md:inline">
                        {{ config('office.app_name', 'Office Task Tracker') }}
                    </span>
                </a>

                <!-- Menu 1: Homepage -->
                <a href="{{ route('home') }}"
                   class="flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-200
                          bg-indigo-600 text-white shadow-sm shadow-indigo-500/30">
                    <i class="fas fa-home text-xs"></i>
                    <span>Homepage</span>
                </a>

                <!-- Menu 2: Dashboard -->
                <a href="{{ route('tasks.index') }}"
                   class="flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-200
                          text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/50">
                    <i class="fas fa-tachometer-alt text-xs"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Menu 3: Tasks -->
                <a href="{{ route('tasks.list') }}"
                   class="flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-200
                          text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/50">
                    <i class="fas fa-list-check text-xs"></i>
                    <span>Tasks</span>
                </a>

                <!-- Menu 4: Adminer (DB) -->
                <a href="{{ route('adminer') }}"
                   target="_blank"
                   title="Open SQLite Database in Adminer"
                   class="flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-200
                          text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/50">
                    <i class="fas fa-database text-xs text-indigo-500"></i>
                    <span>Adminer</span>
                </a>
            </div>

            <!-- Right Controls: View Toggle + Theme Toggle -->
            <div class="flex items-center gap-2.5 ml-auto">
                <!-- View Toggle (Mobile/Desktop) -->
                <button id="view-toggle-btn" type="button"
                        class="view-toggle-btn desktop-mode"
                        title="Switch between mobile and desktop view">
                    <i id="view-toggle-icon" class="fas fa-mobile-alt"></i>
                    <span id="view-toggle-label">Mobile View</span>
                </button>

                <!-- Dark/Light Mode Toggle -->
                <button id="theme-toggle" type="button"
                    class="w-10 h-10 flex items-center justify-center rounded-xl transition-all duration-200
                           bg-gray-100 dark:bg-gray-700/60 border border-gray-200 dark:border-gray-600
                           text-gray-600 dark:text-amber-400 hover:bg-gray-200 dark:hover:bg-gray-600 cursor-pointer shadow-sm"
                    title="Toggle dark/light mode">
                    <i id="theme-toggle-dark-icon" class="fas fa-moon text-indigo-600 text-sm"></i>
                    <i id="theme-toggle-light-icon" class="fas fa-sun text-amber-400 text-sm hidden"></i>
                </button>
            </div>
        </nav>

        <!-- ===== HERO SECTION ===== -->
        <main class="flex-grow flex items-center justify-center px-4 sm:px-6 lg:px-8 pb-24">
            <div class="max-w-5xl w-full mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                <!-- Left Text -->
                <div class="text-center lg:text-left space-y-8 mt-8 lg:mt-0 z-20">
                    <!-- Badge -->
                    <div class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-full text-sm font-medium
                                bg-indigo-50 dark:bg-white/5 dark:backdrop-blur-md
                                text-indigo-600 dark:text-blue-300
                                border border-indigo-200 dark:border-blue-400/20
                                shadow-sm dark:shadow-[0_0_15px_rgba(59,130,246,0.15)]
                                transition-all duration-300">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 dark:bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500 dark:bg-blue-500"></span>
                        </span>
                        <span>Productivity redefined</span>
                    </div>

                    <!-- Heading -->
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-tight
                               text-gray-900 dark:text-white transition-colors duration-300">
                        Manage your work <br />
                        <span class="gradient-text">effortlessly.</span>
                    </h1>

                    <!-- Subtext -->
                    <p class="text-lg max-w-xl mx-auto lg:mx-0 font-light leading-relaxed
                              text-gray-500 dark:text-gray-400 transition-colors duration-300">
                        {{ config('office.company_name', 'ASTGD') }}'s official internal task tracker. Organize projects, meet deadlines, and monitor performance — all in one beautiful ecosystem.
                    </p>

                    <!-- CTA -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start space-y-4 sm:space-y-0 sm:space-x-4 pt-2">
                        <a href="{{ route('tasks.index') }}"
                           class="w-full sm:w-auto px-8 py-4 rounded-full font-semibold text-lg text-white
                                  bg-gradient-to-r from-indigo-600 to-purple-600
                                  hover:from-indigo-500 hover:to-purple-500
                                  shadow-[0_0_20px_rgba(99,102,241,0.35)] hover:shadow-[0_0_32px_rgba(99,102,241,0.55)]
                                  transform hover:-translate-y-1 transition-all duration-300
                                  flex items-center justify-center group">
                            Go to Dashboard
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>

                <!-- Right Visual -->
                <div class="relative w-full h-[400px] md:h-[500px] hidden lg:block z-10">
                    <div class="absolute inset-0 flex items-center justify-center float-anim">
                        <!-- Glassmorphic UI Card -->
                        <div class="w-full max-w-md h-auto rounded-2xl p-6 shadow-2xl relative
                                    glass-light dark:glass-dark
                                    border-t border-l border-white/80 dark:border-white/20
                                    transition-all duration-500">

                            <!-- Header pseudo -->
                            <div class="flex justify-between items-center border-b border-gray-200 dark:border-white/10 pb-4 mb-6">
                                <div class="w-28 h-4 bg-gray-200 dark:bg-white/20 rounded-md"></div>
                                <div class="flex space-x-2">
                                    <div class="w-8 h-8 rounded-full bg-blue-400/40 dark:bg-blue-500/50"></div>
                                    <div class="w-8 h-8 rounded-full bg-purple-400/40 dark:bg-purple-500/50"></div>
                                </div>
                            </div>

                            <!-- Stats pseudo -->
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="h-20 rounded-xl border p-4
                                            bg-indigo-50/80 border-indigo-100 dark:bg-white/5 dark:border-white/10
                                            transition-colors duration-300">
                                    <div class="w-12 h-3 bg-indigo-200 dark:bg-white/20 rounded mb-3"></div>
                                    <div class="w-16 h-6 bg-indigo-400/70 dark:bg-blue-400/80 rounded"></div>
                                </div>
                                <div class="h-20 rounded-xl border p-4
                                            bg-purple-50/80 border-purple-100 dark:bg-white/5 dark:border-white/10
                                            transition-colors duration-300">
                                    <div class="w-12 h-3 bg-purple-200 dark:bg-white/20 rounded mb-3"></div>
                                    <div class="w-16 h-6 bg-purple-400/70 dark:bg-purple-400/80 rounded"></div>
                                </div>
                            </div>

                            <!-- Task list pseudo -->
                            <div class="space-y-3">
                                <div class="h-12 rounded-lg flex items-center px-4
                                            bg-green-50 dark:bg-white/10 border border-green-100 dark:border-transparent
                                            transition-colors duration-300">
                                    <div class="w-4 h-4 rounded-full bg-green-400 mr-4 flex-shrink-0"></div>
                                    <div class="w-1/2 h-3 bg-gray-200 dark:bg-white/30 rounded"></div>
                                </div>
                                <div class="h-12 rounded-lg flex items-center px-4
                                            bg-yellow-50 dark:bg-white/5 border border-yellow-100 dark:border-white/5
                                            transition-colors duration-300">
                                    <div class="w-4 h-4 rounded-full bg-yellow-400 mr-4 flex-shrink-0"></div>
                                    <div class="w-2/3 h-3 bg-gray-200 dark:bg-white/20 rounded"></div>
                                </div>
                                <div class="h-12 rounded-lg flex items-center px-4
                                            bg-red-50 dark:bg-white/5 border border-red-100 dark:border-white/5
                                            transition-colors duration-300">
                                    <div class="w-4 h-4 rounded-full bg-red-400 mr-4 flex-shrink-0"></div>
                                    <div class="w-1/3 h-3 bg-gray-200 dark:bg-white/20 rounded"></div>
                                </div>
                            </div>

                            <!-- Floating rocket badge -->
                            <div class="absolute -right-12 -bottom-10 w-32 h-32 rounded-full flex items-center justify-center
                                        glass-light dark:glass-dark
                                        shadow-lg border border-white/80 dark:border-white/20
                                        transition-all duration-500"
                                 style="animation: float 4s ease-in-out infinite reverse;">
                                <i class="fas fa-rocket text-4xl text-purple-400 dark:text-purple-300"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>

        <!-- ===== FOOTER ===== -->
        <footer class="w-full text-center py-6 text-sm mt-auto transition-colors duration-300
                       text-gray-400 dark:text-gray-500">
            <p>&copy; {{ date('Y') }} {{ config('office.company_name', 'ASTGD') }}. Crafted with precision.</p>
            @if(app()->environment('local'))
                <span class="inline-block mt-2 px-3 py-1 text-xs rounded-md
                             bg-gray-100 dark:bg-white/10 text-gray-500 dark:text-gray-400
                             transition-colors duration-300">
                    Environment: Development
                </span>
            @endif
        </footer>
    </div>

      </div>{{-- /mobile-frame-inner --}}
    </div>{{-- /mobile-frame --}}

    {{-- Device label shown below phone frame --}}
    <div class="device-label flex-col items-center mt-4 gap-1" id="device-label">
        <div class="w-24 h-1.5 bg-slate-700 rounded-full"></div>
        <p class="text-slate-500 text-xs mt-1">Mobile Preview — 390 × 844</p>
    </div>

    <!-- ===== SCRIPTS ===== -->
    <script>
    (function() {
        // ─── DARK MODE ───────────────────────────
        var themeBtn = document.getElementById('theme-toggle');
        var darkIcon = document.getElementById('theme-toggle-dark-icon');
        var lightIcon = document.getElementById('theme-toggle-light-icon');

        function updateThemeIcons() {
            var isDark = document.documentElement.classList.contains('dark');
            if (darkIcon && lightIcon) {
                darkIcon.classList.toggle('hidden', isDark);
                lightIcon.classList.toggle('hidden', !isDark);
            }
        }
        updateThemeIcons();

        if (themeBtn) {
            themeBtn.addEventListener('click', function () {
                var isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('color-theme', isDark ? 'dark' : 'light');
                updateThemeIcons();
            });
        }

        // ─── VIEW TOGGLE ─────────────────────────
        var body      = document.body;
        var frame     = document.getElementById('mobile-frame');
        var viewBtn   = document.getElementById('view-toggle-btn');
        var viewIcon  = document.getElementById('view-toggle-icon');
        var viewLabel = document.getElementById('view-toggle-label');
        var deviceLbl = document.getElementById('device-label');

        var isMobile = localStorage.getItem('view-mode') === 'mobile';

        function applyViewMode(mobile) {
            if (mobile) {
                body.classList.add('mobile-view-active');
                if (deviceLbl) deviceLbl.style.display = 'flex';
                viewIcon.className  = 'fas fa-desktop';
                viewLabel.textContent = 'Desktop';
                viewBtn.classList.remove('desktop-mode');
                viewBtn.classList.add('mobile-mode');
            } else {
                body.classList.remove('mobile-view-active');
                if (deviceLbl) deviceLbl.style.display = 'none';
                viewIcon.className  = 'fas fa-mobile-alt';
                viewLabel.textContent = 'Mobile';
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
