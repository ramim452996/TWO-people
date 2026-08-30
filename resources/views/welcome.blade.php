<!DOCTYPE html>
<html lang="en" id="html-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('office.app_name', 'ASTGD Office Task Tracker') }} | Enterprise Workspace</title>
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
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            900: '#312e81',
                        }
                    }
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
            width: 410px;
            min-height: 860px;
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
            width: 120px; height: 26px;
            background: #1e293b;
            border-radius: 0 0 20px 20px;
            z-index: 100;
        }
        body.mobile-view-active .mobile-frame-inner {
            height: 100%; overflow-y: auto; overflow-x: hidden;
            padding-top: 24px;
            scrollbar-width: thin; scrollbar-color: #6366f1 transparent;
        }
        body.mobile-view-active .mobile-frame-inner::-webkit-scrollbar { width: 3px; }
        body.mobile-view-active .mobile-frame-inner::-webkit-scrollbar-thumb { background: #6366f1; border-radius: 99px; }
        .device-label { display: none; }
        body.mobile-view-active .device-label { display: flex; }

        /* View toggle button */
        .view-toggle-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 12px; border-radius: 12px;
            font-size: 12px; font-weight: 700; cursor: pointer;
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
            background-color: #172554;
            color: #93c5fd;
        }

        /* Glassmorphism & Micro-animations */
        .glass-panel {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }
        .dark .glass-panel {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .gradient-text {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .dark .gradient-text {
            background: linear-gradient(135deg, #818cf8 0%, #c084fc 50%, #f472b6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        .float-anim {
            animation: floatSlow 6s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 font-sans antialiased min-h-screen transition-colors duration-300 selection:bg-indigo-500 selection:text-white">

    <!-- Mobile view wrapper -->
    <div class="mobile-frame w-full min-h-screen flex flex-col justify-between" id="mobile-frame">
      <div class="mobile-frame-inner w-full min-h-screen flex flex-col justify-between">

        <div class="relative w-full flex-grow flex flex-col overflow-hidden">
            <!-- Background Glow Orbs -->
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-500/15 dark:bg-indigo-600/15 rounded-full blur-3xl pointer-events-none -z-10"></div>
            <div class="absolute top-1/3 right-10 w-96 h-96 bg-purple-500/15 dark:bg-purple-600/15 rounded-full blur-3xl pointer-events-none -z-10"></div>

            <!-- ===== 1. TOP NAVIGATION HEADER ===== -->
            <header class="sticky top-0 z-50 w-full px-4 sm:px-8 py-3.5 glass-panel border-b border-slate-200/80 dark:border-slate-800/80 transition-colors">
                <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
                    
                    <!-- Brand Logo -->
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group shrink-0">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-indigo-600 via-indigo-700 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/25 group-hover:scale-105 transition-transform duration-300">
                            <i class="fas fa-layer-group text-lg"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-extrabold text-base sm:text-lg tracking-tight text-slate-900 dark:text-white">
                                    {{ config('office.company_name', 'ASTGD') }}
                                </span>
                                <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-900/60 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-700">Enterprise</span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">Task Management System</p>
                        </div>
                    </a>

                    <!-- Desktop Center Links -->
                    <nav class="hidden md:flex items-center gap-1 bg-slate-100/80 dark:bg-slate-900/80 p-1.5 rounded-2xl border border-slate-200 dark:border-slate-800 text-xs font-semibold text-slate-600 dark:text-slate-300">
                        <a href="#overview" class="px-3.5 py-1.5 rounded-xl hover:text-indigo-600 dark:hover:text-white hover:bg-white dark:hover:bg-slate-800 transition-all">Overview</a>
                        <a href="#features" class="px-3.5 py-1.5 rounded-xl hover:text-indigo-600 dark:hover:text-white hover:bg-white dark:hover:bg-slate-800 transition-all">Features</a>
                        <a href="{{ route('tasks.index') }}" class="px-3.5 py-1.5 rounded-xl hover:text-indigo-600 dark:hover:text-white hover:bg-white dark:hover:bg-slate-800 transition-all flex items-center gap-1.5">
                            <i class="fas fa-columns text-indigo-500"></i>
                            <span>Kanban Board</span>
                        </a>
                        <a href="{{ route('tasks.list') }}" class="px-3.5 py-1.5 rounded-xl hover:text-indigo-600 dark:hover:text-white hover:bg-white dark:hover:bg-slate-800 transition-all flex items-center gap-1.5">
                            <i class="fas fa-list-check text-purple-500"></i>
                            <span>Task List</span>
                        </a>
                    </nav>

                    <!-- Right Controls (Theme + View + CTA) -->
                    <div class="flex items-center gap-2 sm:gap-3">
                        <!-- View Toggle (Desktop / Mobile) -->
                        <button id="view-toggle-btn" type="button" class="view-toggle-btn desktop-mode shadow-2xs" title="Switch View">
                            <i id="view-toggle-icon" class="fas fa-mobile-alt"></i>
                            <span id="view-toggle-label" class="hidden sm:inline">Mobile</span>
                        </button>

                        <!-- Theme Toggle (Light / Dark) -->
                        <button id="theme-toggle" type="button" class="p-2 sm:px-3 sm:py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all border border-slate-200 dark:border-slate-700 flex items-center gap-1.5" title="Toggle theme">
                            <i id="theme-toggle-dark-icon" class="fas fa-moon text-indigo-500 hidden"></i>
                            <i id="theme-toggle-light-icon" class="fas fa-sun text-amber-500 hidden"></i>
                            <span class="hidden sm:inline">Theme</span>
                        </button>

                        <div class="h-5 w-px bg-slate-200 dark:bg-slate-800 hidden sm:block"></div>

                        @auth
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-600 hover:from-indigo-700 hover:to-purple-700 shadow-md shadow-indigo-500/20 transition-all flex items-center gap-1.5">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        @else
                            @if(Route::has('login'))
                                <a href="{{ route('login') }}" class="hidden sm:inline-block px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-white transition-colors">
                                    Sign In
                                </a>
                            @endif
                            <a href="{{ route('tasks.index') }}" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-600 hover:from-indigo-700 hover:to-purple-700 shadow-md shadow-indigo-500/20 transition-all flex items-center gap-1.5">
                                <i class="fas fa-bolt"></i>
                                <span>Get Started</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </header>

            <!-- ===== 2. HERO SECTION ===== -->
            <section id="overview" class="relative pt-12 md:pt-16 pb-20 px-4 sm:px-8">
                <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                    
                    <!-- Left Hero Text (7 Cols) -->
                    <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                        <!-- Live Pulse Badge -->
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 shadow-xs">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                            </span>
                            <span>Productivity Redefined · Enterprise Workspace</span>
                        </div>

                        <!-- Main Headline -->
                        <h1 class="text-4xl sm:text-5xl md:text-6xl font-black tracking-tight text-slate-900 dark:text-white leading-[1.15]">
                            Manage your corporate work <br class="hidden sm:inline" />
                            <span class="gradient-text">effortlessly & smart.</span>
                        </h1>

                        <!-- Subtitle -->
                        <p class="text-base sm:text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto lg:mx-0 font-normal leading-relaxed">
                            {{ config('office.company_name', 'ASTGD') }}'s next-generation task tracker. Organize team workflows, track real-time delivery timelines, monitor sprints, and eliminate bottlenecks—all in one unified platform.
                        </p>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3.5 pt-2">
                            <a href="{{ route('tasks.index') }}" class="px-7 py-3.5 rounded-2xl font-bold text-sm sm:text-base text-white bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-600 hover:from-indigo-500 hover:to-purple-500 shadow-xl shadow-indigo-500/25 transform hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                                <span>Open Kanban Board</span>
                                <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                            <a href="{{ route('tasks.list') }}" class="px-6 py-3.5 rounded-2xl font-bold text-sm sm:text-base text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-300 dark:border-slate-800 shadow-sm transition-all flex items-center gap-2">
                                <i class="fas fa-table-list text-indigo-500"></i>
                                <span>Browse Task Table</span>
                            </a>
                        </div>

                        <!-- Trust Guarantee Bar -->
                        <div class="pt-4 flex flex-wrap items-center justify-center lg:justify-start gap-4 text-xs font-semibold text-slate-500 dark:text-slate-400">
                            <span class="flex items-center gap-1.5"><i class="fas fa-check-circle text-emerald-500"></i> 100% Free & Open Source</span>
                            <span class="flex items-center gap-1.5"><i class="fas fa-shield-halved text-indigo-500"></i> Enterprise Encrypted</span>
                            <span class="flex items-center gap-1.5"><i class="fas fa-bolt text-amber-500"></i> Real-time Synced</span>
                        </div>
                    </div>

                    <!-- Right Visual: Corporate Office Image Showcase (5 Cols) -->
                    <div class="lg:col-span-5 relative flex items-center justify-center">
                        <div class="absolute -inset-4 bg-gradient-to-tr from-indigo-500/25 via-purple-500/20 to-pink-500/20 rounded-3xl blur-2xl opacity-80 animate-pulse"></div>

                        <div class="relative w-full max-w-lg rounded-3xl p-3 bg-white/60 dark:bg-slate-900/70 backdrop-blur-xl border border-white/80 dark:border-slate-800 shadow-2xl transition-all duration-500 hover:shadow-indigo-500/20 float-anim group">
                            <!-- High-Res Corporate Image Container -->
                            <div class="relative rounded-2xl overflow-hidden aspect-[4/3] shadow-inner bg-slate-900">
                                <img src="{{ asset('images/corporate-office.jpg') }}"
                                     alt="ASTGD Corporate Office"
                                     class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out" />
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent pointer-events-none"></div>

                                <!-- Image Card Overlays -->
                                <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between pointer-events-none">
                                    <div class="bg-black/70 backdrop-blur-md px-3 py-1.5 rounded-xl border border-white/15 flex items-center gap-2 text-[11px] font-bold text-white">
                                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                        <span>ASTGD Headquarters</span>
                                    </div>
                                    <div class="bg-indigo-600/90 backdrop-blur-md px-3 py-1.5 rounded-xl text-[11px] font-bold text-white flex items-center gap-1.5 shadow-md">
                                        <i class="fas fa-chart-pie"></i>
                                        <span>Live Metrics</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Floating Stat Badge 1 (Top Right) -->
                            <div class="absolute -top-3.5 -right-3.5 px-3.5 py-2 rounded-2xl bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl border border-indigo-200 dark:border-indigo-500/30 shadow-xl flex items-center gap-2.5 text-xs font-bold text-slate-800 dark:text-white"
                                 style="animation: floatSlow 5s ease-in-out infinite;">
                                <div class="w-7 h-7 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs shadow-xs">
                                    <i class="fas fa-check-double"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 uppercase font-semibold">Sprint Status</p>
                                    <p class="text-indigo-600 dark:text-indigo-400 font-bold">100% On Track</p>
                                </div>
                            </div>

                            <!-- Floating Stat Badge 2 (Bottom Left) -->
                            <div class="absolute -bottom-3.5 -left-3.5 px-3.5 py-2 rounded-2xl bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl border border-purple-200 dark:border-purple-500/30 shadow-xl flex items-center gap-2.5 text-xs font-bold text-slate-800 dark:text-white"
                                 style="animation: floatSlow 4.5s ease-in-out infinite reverse;">
                                <div class="w-7 h-7 rounded-xl bg-gradient-to-tr from-purple-500 to-pink-500 flex items-center justify-center text-white text-xs shadow-xs">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 uppercase font-semibold">Collaboration</p>
                                    <p class="text-purple-600 dark:text-purple-400 font-bold">Active Synced</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <!-- ===== 3. IMPACT STATISTICS BAR ===== -->
            <section class="py-8 px-4 sm:px-8 border-y border-slate-200/80 dark:border-slate-800/80 bg-white/40 dark:bg-slate-900/40 backdrop-blur-md">
                <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                    <div class="p-4 rounded-2xl bg-white/60 dark:bg-slate-800/40 border border-slate-200/60 dark:border-slate-700/60 shadow-xs">
                        <div class="text-2xl sm:text-3xl md:text-4xl font-black text-indigo-600 dark:text-indigo-400 tracking-tight">10,000+</div>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">Tasks Completed</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/60 dark:bg-slate-800/40 border border-slate-200/60 dark:border-slate-700/60 shadow-xs">
                        <div class="text-2xl sm:text-3xl md:text-4xl font-black text-purple-600 dark:text-purple-400 tracking-tight">99.8%</div>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">On-Time Delivery</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/60 dark:bg-slate-800/40 border border-slate-200/60 dark:border-slate-700/60 shadow-xs">
                        <div class="text-2xl sm:text-3xl md:text-4xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight">4.9 / 5.0</div>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">Team Satisfaction</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/60 dark:bg-slate-800/40 border border-slate-200/60 dark:border-slate-700/60 shadow-xs">
                        <div class="text-2xl sm:text-3xl md:text-4xl font-black text-pink-600 dark:text-pink-400 tracking-tight">&lt; 15 min</div>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">Resolution Velocity</p>
                    </div>
                </div>
            </section>

            <!-- ===== 4. ENTERPRISE FEATURES SECTION ===== -->
            <section id="features" class="py-20 px-4 sm:px-8">
                <div class="max-w-7xl mx-auto space-y-12">
                    <div class="text-center max-w-2xl mx-auto space-y-3">
                        <span class="text-xs uppercase font-bold tracking-wider px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">Everything You Need</span>
                        <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900 dark:text-white">
                            Engineered for high-performing modern teams
                        </h2>
                        <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400">
                            Discover powerful features designed to boost productivity, eliminate chaos, and deliver results on schedule.
                        </p>
                    </div>

                    <!-- 6-Feature Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Card 1: Kanban Board -->
                        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl hover:border-indigo-500/40 transition-all duration-300 group">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl mb-5 group-hover:scale-110 transition-transform">
                                <i class="fas fa-columns"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Interactive Kanban Board</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                Visual column layout for Pending, In Progress, and Completed tasks with quick status updates and priority markers.
                            </p>
                        </div>

                        <!-- Card 2: Urgency Engine -->
                        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl hover:border-purple-500/40 transition-all duration-300 group">
                            <div class="w-12 h-12 rounded-2xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xl mb-5 group-hover:scale-110 transition-transform">
                                <i class="fas fa-fire-flame-curved"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Smart Urgency Engine</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                Automated overdue detection with smart color coding (Due Today, Overdue, Urgent) to keep deliverables on track.
                            </p>
                        </div>

                        <!-- Card 3: Team Collaboration -->
                        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl hover:border-emerald-500/40 transition-all duration-300 group">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl mb-5 group-hover:scale-110 transition-transform">
                                <i class="fas fa-users-gear"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Team Assignment & Roles</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                Assign tasks to specific team members, track accountability, and collaborate seamlessly across departments.
                            </p>
                        </div>

                        <!-- Card 4: CSV Export -->
                        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl hover:border-blue-500/40 transition-all duration-300 group">
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xl mb-5 group-hover:scale-110 transition-transform">
                                <i class="fas fa-file-excel"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">1-Click Excel / CSV Export</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                Instant Excel-compatible UTF-8 CSV exports for executive meetings, board reporting, and team audit logs.
                            </p>
                        </div>

                        <!-- Card 5: Dual Appearance -->
                        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl hover:border-amber-500/40 transition-all duration-300 group">
                            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl mb-5 group-hover:scale-110 transition-transform">
                                <i class="fas fa-circle-half-stroke"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Light & Dark Theme Modes</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                Crisp, clean daylight bright view and deep obsidian dark mode with 1-click persistent local storage switching.
                            </p>
                        </div>

                        <!-- Card 6: Enterprise Security -->
                        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl hover:border-pink-500/40 transition-all duration-300 group">
                            <div class="w-12 h-12 rounded-2xl bg-pink-50 dark:bg-pink-950/60 text-pink-600 dark:text-pink-400 flex items-center justify-center text-xl mb-5 group-hover:scale-110 transition-transform">
                                <i class="fas fa-shield-check"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Fortified Security & 2FA</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                Built with Laravel Fortify, WebAuthn passkeys, two-factor authentication, and encrypted session handlers.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ===== 5. OFFICIAL ACCREDITATIONS & TRUST BAR ===== -->
            <section class="py-12 px-4 sm:px-8 bg-slate-100/60 dark:bg-slate-900/60 border-y border-slate-200/80 dark:border-slate-800/80">
                <div class="max-w-7xl mx-auto text-center space-y-6">
                    <p class="text-xs uppercase font-bold tracking-widest text-slate-400">Trusted Accreditations & Certifications</p>
                    <div class="flex flex-wrap items-center justify-center gap-6 sm:gap-10">
                        <div class="px-4 py-2.5 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center gap-2.5 shadow-2xs">
                            <i class="fas fa-award text-indigo-500 text-base"></i>
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-200">BASIS Member #GE-18-11-670</span>
                        </div>
                        <div class="px-4 py-2.5 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center gap-2.5 shadow-2xs">
                            <i class="fas fa-globe text-blue-500 text-base"></i>
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-200">D-U-N-S #55-965-0301</span>
                        </div>
                        <div class="px-4 py-2.5 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center gap-2.5 shadow-2xs">
                            <i class="fas fa-star text-emerald-500 text-base"></i>
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-200">Trustpilot 4.8 / 5.0</span>
                        </div>
                        <div class="px-4 py-2.5 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center gap-2.5 shadow-2xs">
                            <i class="fas fa-shield text-purple-500 text-base"></i>
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-200">SCAMADVISER 100% Safe</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ===== 6. CALL TO ACTION BANNER ===== -->
            <section class="py-20 px-4 sm:px-8">
                <div class="max-w-5xl mx-auto rounded-3xl p-8 sm:p-12 bg-gradient-to-r from-indigo-900 via-indigo-800 to-purple-900 text-white text-center space-y-6 shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-60 h-60 bg-indigo-500/20 rounded-full blur-2xl pointer-events-none"></div>
                    
                    <span class="inline-block text-xs uppercase font-bold tracking-wider px-3.5 py-1 rounded-full bg-white/10 border border-white/20 backdrop-blur-md">
                        Get Started Today
                    </span>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight max-w-2xl mx-auto">
                        Ready to supercharge your team's workflow?
                    </h2>
                    <p class="text-sm sm:text-base text-indigo-200 max-w-xl mx-auto">
                        Join ASTGD Task Tracker and take full control of your office deliverables with real-time Kanban pipelines.
                    </p>
                    <div class="pt-2 flex flex-wrap items-center justify-center gap-4">
                        <a href="{{ route('tasks.index') }}" class="px-8 py-4 rounded-2xl font-bold text-base bg-white text-indigo-900 hover:bg-indigo-50 shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                            Launch Task Tracker
                        </a>
                    </div>
                </div>
            </section>

            <!-- ===== 7. MULTI-COLUMN ENTERPRISE FOOTER ===== -->
            <footer class="w-full bg-white dark:bg-slate-900/90 border-t border-slate-200 dark:border-slate-800 py-12 px-4 sm:px-8 mt-auto">
                <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 pb-10 border-b border-slate-200 dark:border-slate-800 text-sm">
                    <div class="space-y-3">
                        <div class="flex items-center gap-2 font-bold text-slate-900 dark:text-white text-base">
                            <div class="w-8 h-8 rounded-xl bg-indigo-600 flex items-center justify-center text-white">
                                <i class="fas fa-layer-group text-sm"></i>
                            </div>
                            <span>{{ config('office.company_name', 'ASTGD') }}</span>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                            Enterprise-grade office task tracking platform engineered for streamlined execution and maximum team productivity.
                        </p>
                    </div>

                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-white text-xs uppercase tracking-wider mb-3">Quick Navigation</h4>
                        <ul class="space-y-2 text-xs text-slate-600 dark:text-slate-400">
                            <li><a href="{{ route('tasks.index') }}" class="hover:text-indigo-600 dark:hover:text-white transition-colors">Kanban Board</a></li>
                            <li><a href="{{ route('tasks.list') }}" class="hover:text-indigo-600 dark:hover:text-white transition-colors">Task Data Table</a></li>
                            <li><a href="{{ route('tasks.create') }}" class="hover:text-indigo-600 dark:hover:text-white transition-colors">Create New Task</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-white text-xs uppercase tracking-wider mb-3">Resources & Export</h4>
                        <ul class="space-y-2 text-xs text-slate-600 dark:text-slate-400">
                            <li><a href="{{ route('tasks.export') }}" class="hover:text-indigo-600 dark:hover:text-white transition-colors">Export CSV Data</a></li>
                            <li><a href="{{ route('dashboard') }}" class="hover:text-indigo-600 dark:hover:text-white transition-colors">Executive Dashboard</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-white text-xs uppercase tracking-wider mb-3">System Health</h4>
                        <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 space-y-2">
                            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span>All Systems Operational</span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                MySQL Database: Connected · Status: Active
                            </p>
                        </div>
                    </div>
                </div>

                <div class="max-w-7xl mx-auto pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 dark:text-slate-400 gap-4">
                    <p>&copy; {{ date('Y') }} {{ config('office.company_name', 'ASTGD') }}. All rights reserved.</p>
                    <div class="flex items-center gap-4">
                        <span>Version 2.4 Enterprise</span>
                        <span>·</span>
                        <span>Built with Laravel & Livewire</span>
                    </div>
                </div>
            </footer>
        </div>

      </div>{{-- /mobile-frame-inner --}}
    </div>{{-- /mobile-frame --}}

    {{-- Device label shown below phone frame --}}
    <div class="device-label flex-col items-center mt-4 gap-1" id="device-label">
        <div class="w-24 h-1.5 bg-slate-700 rounded-full"></div>
        <p class="text-slate-500 text-xs mt-1">Mobile Preview — 410 × 860</p>
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

        // ─── VIEW TOGGLE (Desktop / Mobile) ──────
        var body      = document.body;
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

        if (viewBtn) {
            viewBtn.addEventListener('click', function () {
                isMobile = !isMobile;
                localStorage.setItem('view-mode', isMobile ? 'mobile' : 'desktop');
                applyViewMode(isMobile);
            });
        }
    })();
    </script>
</body>
</html>