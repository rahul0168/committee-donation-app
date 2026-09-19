<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#0f172a">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="ComDonation">
    <meta name="description" content="Committee Donation & Member Pledge Management Mobile App">

    <title>@yield('title', 'Committee Donation App')</title>

    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icon-192.png">

    <!-- Fonts & Tailwind CSS CDN -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome & Chart.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }
        .glass-card {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .glass-nav {
            background: rgba(15, 23, 42, 0.90);
            backdrop-filter: blur(16px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 9999px;
        }
    </style>
</head>
<body class="h-full flex flex-col md:flex-row bg-slate-950 text-slate-100 overflow-x-hidden pb-20 md:pb-0">

    <!-- Desktop Sidebar Navigation -->
    <aside class="hidden md:flex md:w-64 flex-col bg-slate-900 border-r border-slate-800 p-5 space-y-6">
        <div class="flex items-center space-x-3 px-2">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-white text-xl font-bold shadow-lg shadow-emerald-500/20">
                <i class="fa-solid fa-hand-holding-heart"></i>
            </div>
            <div>
                <h1 class="font-extrabold text-lg text-white tracking-wide">ComDonation</h1>
                <p class="text-xs text-slate-400">Committee Manager</p>
            </div>
        </div>

        <nav class="flex-1 space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-chart-pie text-lg w-6"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('donations.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('donations.*') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-receipt text-lg w-6"></i>
                <span>Donations</span>
            </a>
            <a href="{{ route('committees.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('committees.*') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-users-rectangle text-lg w-6"></i>
                <span>Committees</span>
            </a>
            <a href="{{ route('members.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('members.*') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-user-group text-lg w-6"></i>
                <span>Members</span>
            </a>
            <a href="{{ route('expenses.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('expenses.*') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-money-bill-transfer text-lg w-6"></i>
                <span>Expenses</span>
            </a>
            <a href="{{ route('reports.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('reports.*') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-file-invoice-dollar text-lg w-6"></i>
                <span>Financial Reports</span>
            </a>
        </nav>

        <div class="pt-4 border-t border-slate-800 space-y-3">
            <a href="{{ route('donations.create') }}" class="w-full flex items-center justify-center space-x-2 py-3 px-4 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-semibold text-sm shadow-lg shadow-emerald-500/25 hover:from-emerald-600 hover:to-teal-600 transition">
                <i class="fa-solid fa-plus"></i>
                <span>New Donation</span>
            </a>

            @auth
            <div class="flex items-center justify-between pt-2 px-2 text-xs">
                <div class="flex items-center space-x-2">
                    <div class="w-7 h-7 rounded-full bg-slate-800 flex items-center justify-center text-emerald-400 font-bold">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <span class="text-slate-300 font-semibold truncate max-w-[100px]">{{ Auth::user()->name }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-slate-400 hover:text-rose-400 transition title='Logout'">
                        <i class="fa-solid fa-right-from-bracket text-sm"></i>
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </aside>

    <!-- Mobile Header -->
    <header class="md:hidden flex items-center justify-between px-4 py-3 bg-slate-900 border-b border-slate-800 sticky top-0 z-30">
        <div class="flex items-center space-x-2">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-white text-lg font-bold shadow-md">
                <i class="fa-solid fa-hand-holding-heart"></i>
            </div>
            <span class="font-extrabold text-base text-white">ComDonation</span>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('donations.create') }}" class="px-3 py-1.5 rounded-lg bg-emerald-500 text-white text-xs font-semibold flex items-center space-x-1 shadow-md shadow-emerald-500/20">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Donate</span>
            </a>
            <button id="pwaInstallBtn" class="hidden px-2.5 py-1.5 rounded-lg bg-indigo-600 text-white text-xs font-medium flex items-center space-x-1">
                <i class="fa-solid fa-download"></i>
                <span>Install</span>
            </button>
            @auth
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-400">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
            @endauth
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 p-4 md:p-8 max-w-7xl mx-auto w-full min-h-screen">
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-between text-sm animate-fade-in">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-400 flex items-center justify-between text-sm">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Mobile Bottom Navigation Bar (PWA Touch Friendly) -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 glass-nav z-40 px-2 py-2 flex justify-around items-center">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center py-1 px-3 rounded-lg text-xs font-medium transition {{ request()->routeIs('dashboard') ? 'text-emerald-400 font-bold' : 'text-slate-400' }}">
            <i class="fa-solid fa-chart-pie text-lg mb-1"></i>
            <span>Home</span>
        </a>
        <a href="{{ route('donations.index') }}" class="flex flex-col items-center py-1 px-3 rounded-lg text-xs font-medium transition {{ request()->routeIs('donations.*') ? 'text-emerald-400 font-bold' : 'text-slate-400' }}">
            <i class="fa-solid fa-receipt text-lg mb-1"></i>
            <span>Donations</span>
        </a>
        <a href="{{ route('donations.create') }}" class="flex flex-col items-center -mt-5">
            <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-white text-xl shadow-lg shadow-emerald-500/40 border-4 border-slate-950">
                <i class="fa-solid fa-plus"></i>
            </div>
        </a>
        <a href="{{ route('committees.index') }}" class="flex flex-col items-center py-1 px-3 rounded-lg text-xs font-medium transition {{ request()->routeIs('committees.*') ? 'text-emerald-400 font-bold' : 'text-slate-400' }}">
            <i class="fa-solid fa-users-rectangle text-lg mb-1"></i>
            <span>Committees</span>
        </a>
        <a href="{{ route('reports.index') }}" class="flex flex-col items-center py-1 px-3 rounded-lg text-xs font-medium transition {{ request()->routeIs('reports.*') ? 'text-emerald-400 font-bold' : 'text-slate-400' }}">
            <i class="fa-solid fa-file-invoice-dollar text-lg mb-1"></i>
            <span>Reports</span>
        </a>
    </nav>

    <!-- PWA Service Worker & Install Script -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('SW Registered:', reg.scope))
                    .catch(err => console.log('SW Fail:', err));
            });
        }

        let deferredPrompt;
        const installBtn = document.getElementById('pwaInstallBtn');

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            if (installBtn) {
                installBtn.classList.remove('hidden');
                installBtn.addEventListener('click', () => {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('User accepted PWA install');
                        }
                        deferredPrompt = null;
                        installBtn.classList.add('hidden');
                    });
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
