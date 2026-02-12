<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner - INSFP CANTINE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: radial-gradient(circle at center, #0f0c29, #000000);
            height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: sans-serif;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 30px;
        }
        .scanner-glow {
            box-shadow: 0 0 30px rgba(250, 204, 21, 0.2);
            animation: pulse-glow 2s infinite;
        }
        @keyframes pulse-glow {
            0% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.05); opacity: 1; box-shadow: 0 0 50px rgba(250, 204, 21, 0.4); }
            100% { transform: scale(1); opacity: 0.8; }
        }
        .laser-line {
            position: absolute;
            width: 100%;
            height: 2px;
            background: #facc15;
            box-shadow: 0 0 15px #facc15;
            z-index: 10;
            animation: moveLaser 3s linear infinite;
        }
        @keyframes moveLaser {
            0% { top: 0%; opacity: 0; }
            50% { opacity: 1; }
            100% { top: 100%; opacity: 0; }
        }
    </style>
</head>
<body class="text-white overflow-hidden">

    <nav class="p-4 flex justify-between items-center glass-card m-6 animate__animated animate__fadeInDown">
        <div class="flex items-center space-x-3">
            <img src="https://insfpbouismail.dz/wp-content/uploads/2023/03/cropped-logo-final-ceb-2.png" class="h-10 brightness-110" alt="Logo">
            <span class="font-black tracking-tighter text-lg uppercase">Cantine <span class="text-yellow-500">Pro</span></span>
        </div>
        <div>
            <a href="{{ route('home') }}" class="text-[10px] font-black uppercase tracking-widest bg-red-500/10 hover:bg-red-500/20 text-red-500 px-5 py-3 rounded-xl transition border border-red-500/20">
                <i class="fas fa-sign-out-alt mr-2"></i> Quitter
            </a>
        </div>
    </nav>

    <main class="flex-grow flex flex-col items-center justify-center p-4 relative">
        <div class="glass-card p-12 max-w-md w-full text-center animate__animated animate__zoomIn relative overflow-hidden">
            <div class="laser-line"></div>

            <div class="mb-8">
                <div class="w-28 h-28 bg-yellow-500/10 rounded-full mx-auto flex items-center justify-center scanner-glow border border-yellow-500/30">
                    <i class="fas fa-qrcode text-5xl text-yellow-500"></i>
                </div>
            </div>

            <h2 class="text-2xl font-black uppercase tracking-tighter mb-2">Prêt pour le Scan</h2>
            <p class="text-[10px] text-gray-500 uppercase tracking-[0.3em] font-bold mb-10">Veuillez scanner le badge</p>

            <form action="{{ route('scan.process') }}" method="POST" id="scanForm">
                @csrf
                <input type="text" name="student_id" id="student_input" autofocus 
                       class="w-full bg-black/40 border-2 border-white/10 rounded-2xl p-5 text-center text-2xl tracking-[0.5em] font-black text-yellow-500 outline-none focus:border-yellow-500 transition-all"
                       placeholder="••••••••" autocomplete="off">
                
                <button type="submit" class="mt-6 w-full bg-yellow-500 hover:bg-yellow-600 text-black font-black py-4 rounded-2xl transition duration-300 uppercase text-xs tracking-widest shadow-lg">
                    Vérifier Manuellement
                </button>
            </form>

            <div class="mt-8 h-12">
                @if(session('success'))
                    <div class="p-3 bg-green-500/10 border border-green-500/20 text-green-500 rounded-xl animate__animated animate__fadeInUp text-xs font-bold uppercase tracking-tighter">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-3 bg-red-500/10 border border-red-500/20 text-red-500 rounded-xl animate__animated animate__shakeX text-xs font-bold uppercase tracking-tighter">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    </main>

    <script>
        // إبقاء التركيز دائماً على حقل الإدخال
        document.addEventListener('click', () => document.getElementById('student_input').focus());
        
        // إخفاء التنبيهات تلقائياً
        setTimeout(() => {
            const alerts = document.querySelectorAll('.animate__fadeInUp, .animate__shakeX');
            alerts.forEach(el => el.remove());
        }, 4000);
    </script>

</body>
</html>