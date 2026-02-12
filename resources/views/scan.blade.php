<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CANTINE PRO - SCANNER</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');
        
        body { 
            background-color: #050509; 
            font-family: 'Inter', sans-serif; 
            color: #e2e8f0; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            min-height: 100vh; 
        }

        /* تصميم الهيدر العلوي */
        .top-nav {
            width: 100%;
            max-width: 800px;
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        /* زر العودة المماثل للصورة */
        .btn-accueil {
            background-color: #241212;
            color: #f87171;
            padding: 10px 24px;
            border-radius: 15px;
            font-weight: 900;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid rgba(153, 27, 27, 0.3);
            transition: all 0.3s;
            text-transform: uppercase;
        }
        .btn-accueil:hover {
            background-color: #450a0a;
            color: white;
            transform: translateY(-2px);
        }

        .main-container { 
            background: linear-gradient(145deg, #11121d, #080912); 
            border: 1px solid #1e1f2e; 
            border-radius: 50px; 
            width: 100%; 
            max-width: 550px; 
            padding: 60px 40px; 
            margin-top: 40px; 
            text-align: center; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); 
            position: relative; 
        }

        .icon-circle { width: 160px; height: 160px; border: 2px solid #eab308; border-radius: 50%; margin: 0 auto 40px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; background: rgba(234, 179, 8, 0.05); box-shadow: 0 0 40px rgba(234, 179, 8, 0.1); }

        .scan-line { position: absolute; width: 100%; height: 3px; background: linear-gradient(to right, transparent, #eab308, transparent); box-shadow: 0 0 15px #eab308; top: 0; z-index: 10; animation: moveScanLine 2.5s ease-in-out infinite; }

        @keyframes moveScanLine { 0% { top: 0%; opacity: 0; } 10% { opacity: 1; } 90% { opacity: 1; } 100% { top: 100%; opacity: 0; } }

        /* حقل الإدخال المرئي والكبير */
        .manual-input {
            background: rgba(15, 16, 26, 0.9);
            border: 2px solid #eab308;
            border-radius: 20px;
            padding: 20px;
            width: 100%;
            color: #eab308;
            text-align: center;
            font-size: 2rem;
            font-weight: 900;
            margin-bottom: 25px;
            outline: none;
            transition: 0.3s;
            box-shadow: inset 0 2px 10px rgba(0,0,0,0.5);
        }
        .manual-input:focus { border-color: #fff; box-shadow: 0 0 20px rgba(234, 179, 8, 0.4); }

        .btn-verify { background-color: #eab308; color: #000; width: 100%; padding: 22px; border-radius: 20px; font-weight: 900; text-transform: uppercase; font-size: 14px; transition: 0.3s; border: none; cursor: pointer; box-shadow: 0 10px 25px rgba(234, 179, 8, 0.3); }
        .btn-verify:hover { transform: translateY(-3px); background-color: #facc15; box-shadow: 0 15px 30px rgba(234, 179, 8, 0.5); }
    </style>
</head>
<body>

    <div class="top-nav">
        <div class="flex items-center gap-3">
             <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-black italic shadow-lg">CEB</div>
             <h1 class="text-white text-xl font-black italic">CANTINE <span class="text-yellow-500">PRO</span></h1>
        </div>
        
        <a href="{{ url('/') }}" class="btn-accueil">
            <i class="fas fa-home"></i>
            ACCUEIL
        </a>
    </div>

    <div class="main-container">
        <div class="icon-circle">
            <div class="scan-line"></div>
            <div class="text-yellow-500 text-6xl z-10 opacity-80">
                <i class="fas fa-qrcode"></i>
            </div>
        </div>

        <h2 class="text-white text-4xl font-black uppercase tracking-tight mb-2 italic">PRÊT POUR LE SCAN</h2>
        <p class="text-gray-500 text-[11px] font-bold uppercase tracking-[0.4em] mb-8">Veuillez scanner ou saisir l'ID</p>

        <form action="{{ route('scan.process') }}" method="POST">
            @csrf
            <input type="text" name="student_id" id="badge_input" 
                   class="manual-input" 
                   placeholder="000000" 
                   autofocus 
                   autocomplete="off">
            
            <button type="submit" class="btn-verify italic">Vérifier Manuellement</button>
        </form>

        <div class="mt-8">
            @if(session('success'))
                <div class="text-emerald-500 font-black uppercase text-xs italic bg-emerald-500/10 p-4 rounded-2xl border border-emerald-500/20 animate-bounce">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="text-red-500 font-black uppercase text-xs italic bg-red-500/10 p-4 rounded-2xl border border-red-500/20">
                    <i class="fas fa-times-circle mr-2"></i> {{ session('error') }}
                </div>
            @endif
        </div>
    </div>

    <script>
        const input = document.getElementById('badge_input');
        // التركيز التلقائي عند التحميل
        window.onload = () => input.focus();
        // إعادة التركيز إذا نقر المستخدم في أي مكان خارج الحقل
        document.addEventListener('click', () => input.focus());
    </script>
</body>
</html>