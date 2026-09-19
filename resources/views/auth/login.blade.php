<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#0f172a">
    <title>Admin Login | ComDonation</title>
    <link rel="manifest" href="/manifest.json">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-card {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="h-full flex items-center justify-center p-4 bg-slate-950 text-slate-100 relative overflow-hidden">

    <!-- Background Accent Glow -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md space-y-6 z-10">
        <!-- Logo Header -->
        <div class="text-center space-y-3">
            <div class="inline-flex w-16 h-16 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 items-center justify-center text-white text-3xl font-bold shadow-xl shadow-emerald-500/30">
                <i class="fa-solid fa-hand-holding-heart"></i>
            </div>
            <h1 class="text-3xl font-extrabold text-white tracking-tight">ComDonation</h1>
            <p class="text-slate-400 text-sm">Admin Portal & Committee Manager</p>
        </div>

        @if(session('success'))
            <div class="p-3.5 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs flex items-center space-x-2">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="p-3.5 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-400 text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Login Form Card -->
        <form action="{{ route('login') }}" method="POST" class="glass-card p-6 md:p-8 rounded-3xl space-y-5 shadow-2xl">
            @csrf

            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Email Address</label>
                <div class="relative">
                    <i class="fa-solid fa-envelope absolute left-4 top-3.5 text-slate-500 text-sm"></i>
                    <input type="email" id="emailInput" name="email" value="{{ old('email', 'admin@committee.org') }}" required placeholder="admin@committee.org" class="w-full pl-11 pr-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm focus:outline-none focus:border-emerald-500 transition">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Password</label>
                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-4 top-3.5 text-slate-500 text-sm"></i>
                    <input type="password" id="passwordInput" name="password" value="password" required placeholder="••••••••" class="w-full pl-11 pr-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm focus:outline-none focus:border-emerald-500 transition">
                </div>
            </div>

            <div class="flex items-center justify-between text-xs text-slate-400">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="remember" checked class="rounded bg-slate-900 border-slate-700 text-emerald-500 focus:ring-emerald-500">
                    <span>Remember me</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-bold text-sm shadow-lg shadow-emerald-500/30 hover:from-emerald-600 hover:to-teal-600 transition flex items-center justify-center space-x-2">
                <i class="fa-solid fa-right-to-bracket"></i>
                <span>Sign In as Admin</span>
            </button>
        </form>

        <!-- Demo Credentials Hint Box -->
        <div class="bg-slate-900/60 p-4 rounded-2xl border border-slate-800 text-center space-y-2">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Default Admin Credentials</span>
            <div class="text-xs text-emerald-400 font-mono">
                Email: <strong class="text-white">admin@committee.org</strong> | Password: <strong class="text-white">password</strong>
            </div>
        </div>
    </div>
</body>
</html>
