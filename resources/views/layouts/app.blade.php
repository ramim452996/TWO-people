<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('office.app_name', 'Office Task Tracker') }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            background-color: #0f172a;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 24px 0 40px;
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
        body.dark.mobile-view-active .mobile-frame {
            background: #111827;
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
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: 1.5px solid;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .view-toggle-btn.desktop-mode {
            border-color: #e0e7ff;
            background: #f5f3ff;
            color: #4f46e5;
        }
        .dark .view-toggle-btn.desktop-mode {
            border-color: #3730a3;
            background: #1e1b4b;
            color: #a5b4fc;
        }
        .view-toggle-btn.mobile-mode {
            border-color: #bfdbfe;
            background: #eff6ff;
            color: #1d4ed8;
        }
        .dark .view-toggle-btn.mobile-mode {
            border-color: #1e40af;
            background: #1e3a5f;
            color: #93c5fd;
        }
        .view-toggle-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99,102,241,0.2);
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-200" id="app-body">

    {{-- Mobile frame wrapper (only active when class is toggled) --}}
    <div class="mobile-frame" id="mobile-frame">
      <div class="mobile-frame-inner" id="mobile-frame-inner">

    {{-- ===== NAVBAR ===== --}}
    <nav class="bg-white dark:bg-gray-800 shadow transition-colors duration-200" id="app-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-14">
                {{-- Logo --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('tasks.index') }}" class="flex items-center gap-2 text-lg font-bold text-indigo-600 dark:text-indigo-400">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 dark:bg-indigo-500 flex items-center justify-center shadow-sm">
                            <i class="fas fa-check-double text-white text-sm"></i>
                        </div>
                        <span class="hidden sm:inline">{{ config('office.app_name', 'Office Task Tracker') }}</span>
                    </a>

                    {{-- Home Button --}}
                    <a href="{{ route('home') }}"
                       title="Back to Homepage"
                       class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200
                              text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-600
                              hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 dark:hover:text-indigo-400
                              hover:border-indigo-300 dark:hover:border-indigo-700">
                        <i class="fas fa-home text-xs"></i>
                        <span class="hidden md:inline">Home</span>
                    </a>

                    {{-- Task List Button --}}
                    <a href="{{ route('tasks.list') }}"
                       title="View All Tasks"
                       class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200
                              {{ request()->routeIs('tasks.list')
                                    ? 'bg-indigo-600 text-white border border-indigo-600'
                                    : 'text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-indigo-300 dark:hover:border-indigo-700' }}">
                        <i class="fas fa-list text-xs"></i>
                        <span class="hidden md:inline">Task List</span>
                    </a>
                </div>

                {{-- Right Controls --}}
                <div class="flex items-center gap-2">

                    {{-- View Toggle Button --}}
                    <button id="view-toggle-btn" type="button"
                            class="view-toggle-btn desktop-mode"
                            title="Switch between mobile and desktop view">
                        <i id="view-toggle-icon" class="fas fa-mobile-alt"></i>
                        <span id="view-toggle-label">Mobile View</span>
                    </button>

                    {{-- Dark/Light Mode Toggle --}}
                    <button id="theme-toggle" type="button"
                            class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-500 dark:text-gray-400
                                   hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200"
                            title="Toggle dark/light mode">
                        <i id="theme-toggle-dark-icon" class="hidden fas fa-moon text-base"></i>
                        <i id="theme-toggle-light-icon" class="hidden fas fa-sun text-base"></i>
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
