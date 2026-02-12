<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administration - INSFP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: radial-gradient(circle at center, #1a1a2e, #0f0c29, #000000);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: sans-serif;
            overflow: hidden;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .input-dark {
            background: rgba(0, 0, 0, 0.4) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            transition: all 0.3s ease;
        }
        .input-dark:focus {
            border-color: #facc15 !important;
            box-shadow: 0 0 15px rgba(250, 204, 21, 0.1);
            outline: none;
        }
        .logo-glow {
            position: relative;
        }
        .logo-glow::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100px;
            height: 100px;
            background: rgba(250, 204, 21, 0.1);
            filter: blur(30px);
            border-radius: 50%;
            z-index: -1;
        }
    </style>
</head>
<body class="text-white">

    <div class="glass-card p-10 w-full max-w-md animate__animated animate__zoomIn">
        <div class="text-center mb-10">
            <div class="logo-glow">
                <img src="https://insfpbouismail.dz/wp-content/uploads/2023/03/cropped-logo-final-ceb-2.png" 
                     class="h-24 mx-auto mb-6 brightness-110 drop-shadow-[0_0_15px_rgba(255,255,255,0.2)]" alt="Logo">
            </div>
            <h1 class="text-2xl font-black uppercase tracking-[0.2em]">Authentification</h1>
            <p class="text-[10px] text-yellow-500 font-bold uppercase tracking-[0.4em] opacity-60 mt-2">Accès Sécurisé - Admin</p>
        </div>

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/20 text-red-500 p-4 rounded-2xl mb-6 text-xs font-bold uppercase text-center animate__animated animate__shakeX">
                <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block mb-3 text-[10px] font-black uppercase tracking-widest text-gray-500 ml-1">Clé d'accès</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-4 flex items-center text-gray-600">
                        <i class="fas fa-lock text-sm"></i>
                    </span>
                    <input type="password" name="password" required 
                           class="input-dark w-full pl-12 p-4 rounded-2xl text-center text-xl tracking-[0.3em] font-black"
                           placeholder="••••">
                </div>
            </div>

            <button type="submit" 
                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-black py-5 rounded-2xl transition duration-300 transform active:scale-95 shadow-[0_10px_20px_rgba(250,204,21,0.2)] uppercase text-xs tracking-[0.2em]">
                Se Connecter
            </button>
        </form>

        <div class="mt-8 text-center border-t border-white/5 pt-6">
            <a href="{{ route('home') }}" class="text-[10px] font-bold text-gray-500 hover:text-white uppercase tracking-widest transition flex items-center justify-center gap-2">
                <i class="fas fa-chevron-left text-[8px]"></i> Retour au portail
            </a>
        </div>
    </div>

    <div class="fixed bottom-6 text-[9px] text-gray-700 font-black uppercase tracking-[0.5em]">
        Secure Session v2.0
    </div>

</body>
</html>