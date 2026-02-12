<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSFP CANTINE - Accueil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #0f172a; font-family: 'Inter', sans-serif; color: white; }
        .glass-card { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); transition: all 0.3s ease; }
        .glass-card:hover { border-color: #eab308; transform: translateY(-5px); box-shadow: 0 10px 30px -10px rgba(234, 179, 8, 0.3); }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <nav class="p-6 flex justify-between items-center animate__animated animate__fadeIn">
        <div class="flex items-center space-x-4">
            <img src="https://insfpbouismail.dz/wp-content/uploads/2023/03/cropped-logo-final-ceb-2.png" class="h-12" alt="Logo">
            <h1 class="text-xl font-black uppercase tracking-tighter">INSFP <span class="text-yellow-500">CANTINE</span></h1>
        </div>
        @if(session('admin_logged_in'))
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-[10px] bg-red-500/10 text-red-500 border border-red-500/20 px-4 py-2 rounded-xl font-black hover:bg-red-500 hover:text-white transition">DECONNEXION</button>
            </form>
        @endif
    </nav>

    <main class="flex-grow flex items-center justify-center p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl w-full">
            
            <a href="{{ route('scan') }}" class="glass-card p-10 rounded-[2.5rem] flex flex-col items-center group animate__animated animate__fadeInLeft relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-full bg-yellow-500"></div>
                <div class="w-20 h-20 bg-yellow-500/20 rounded-3xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                    <i class="fas fa-qrcode text-4xl text-yellow-500"></i>
                </div>
                <h2 class="text-2xl font-black uppercase mb-2">Scanner Badge</h2>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest text-center">Valider le passage<br><span class="text-yellow-500/50">(Étudiants & Staff)</span></p>
            </a>

            <a href="{{ route('students.index') }}" class="glass-card p-10 rounded-[2.5rem] flex flex-col items-center group animate__animated animate__fadeInRight relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-full bg-blue-500"></div>
                <div class="absolute top-6 right-6 flex items-center space-x-2 bg-red-500/10 px-3 py-1 rounded-full border border-red-500/20">
                    <i class="fas fa-lock text-[10px] text-red-500"></i>
                    <span class="text-[9px] font-black text-red-500 uppercase">ADMIN</span>
                </div>
                <div class="w-20 h-20 bg-blue-500/20 rounded-3xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                    <i class="fas fa-user-shield text-4xl text-blue-400"></i>
                </div>
                <h2 class="text-2xl font-black uppercase mb-2 text-center">Espace Gestion</h2>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest text-center">Inscriptions & Bases de données<br><span class="text-blue-500/50">Zone Sécurisée</span></p>
            </a>

        </div>
    </main>

    <footer class="p-8 text-center text-slate-500 text-[10px] font-bold uppercase tracking-[0.4em] border-t border-white/5">
        © 2026 - Système de Gestion de Cantine - INSFP
    </footer>

</body>
</html>