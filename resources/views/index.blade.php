<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CANTINE PRO - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');
        body { background-color: #050509; font-family: 'Inter', sans-serif; color: #e2e8f0; overflow-x: hidden; }
        .dashboard-card { background: linear-gradient(145deg, #11121d, #080912); border: 1px solid #1e1f2e; border-radius: 20px; padding: 25px; }
        .table-container { background-color: #11121d; border: 1px solid #1e1f2e; border-radius: 20px; overflow: hidden; }
        .tr-style { border-bottom: 1px solid #1f212d; transition: 0.2s; }
        .tr-style:hover { background-color: #1c1e29; }
        .custom-input { background: #050509 !important; border: 1px solid #1e1f2e !important; color: white !important; padding: 12px !important; border-radius: 12px !important; outline: none; width: 100%; font-weight: bold; }
        .tab-btn { padding: 12px 24px; font-weight: 900; text-transform: uppercase; font-size: 11px; border-radius: 12px; transition: 0.3s; }
        .tab-active { background: #eab308; color: black; }
        .tab-inactive { background: #1e1f2e; color: #64748b; }
        #login-overlay { position: fixed; inset: 0; background: #050509; z-index: 9999; display: flex; align-items: center; justify-content: center; }
        #admin-content { display: none; }
        .modal { display: none; position: fixed; inset: 0; z-index: 10000; background: rgba(0, 0, 0, 0.85); backdrop-filter: blur(8px); align-items: center; justify-content: center; }
    </style>
</head>
<body class="p-4 md:p-8">

    <div id="login-overlay">
        <div class="dashboard-card w-full max-w-md text-center shadow-2xl">
            <h2 class="text-white text-xl font-black mb-6 uppercase italic">CANTINE <span class="text-yellow-500">ADMIN</span></h2>
            <input type="password" id="admin-pass" class="custom-input mb-4 text-center text-2xl tracking-[10px]" placeholder="••••">
            <button type="button" id="login-btn" class="w-full bg-yellow-500 text-black p-4 rounded-xl font-black uppercase shadow-lg">ENTRER</button>
        </div>
    </div>

    <div id="admin-content">
        <div class="max-w-6xl mx-auto flex justify-between items-center mb-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center text-white font-black">CEB</div>
                <h1 class="text-white text-xl font-black italic uppercase">CANTINE <span class="text-yellow-500">DASHBOARD</span></h1>
            </div>
            <div class="flex gap-4 items-center">
                <a href="{{ route('home') }}" class="text-gray-400 text-[10px] font-bold uppercase hover:text-white"><i class="fas fa-home"></i> Accueil</a>
                <button onclick="logout()" class="text-red-500 text-[10px] font-black uppercase tracking-widest border border-red-500/20 px-3 py-1 rounded-lg">Quitter</button>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/50 text-green-500 p-4 rounded-2xl mb-6 text-[10px] font-bold uppercase">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
            <div class="flex gap-2 bg-[#11121d] p-2 rounded-2xl border border-white/5">
                <button id="btn-students" onclick="switchTab('students')" class="tab-btn tab-active">Étudiants ({{ $students->count() }})</button>
                <button id="btn-staff" onclick="switchTab('staff')" class="tab-btn tab-inactive">Employeurs ({{ $staff->count() }})</button>
            </div>
            <button onclick="openModalForAdd()" class="bg-yellow-500 text-black px-6 py-3 rounded-2xl font-black text-xs uppercase shadow-lg hover:scale-105 transition-all">
                + Ajouter Nouveau
            </button>
        </div>

        <div id="view-students" class="table-container shadow-2xl">
            <table class="w-full text-left">
                <thead class="bg-[#1c1e29] text-gray-500 text-[10px] uppercase font-black border-b border-[#2d2e3d]">
                    <tr>
                        <th class="p-5">Nom Complet</th>
                        <th class="p-5">ID Badge</th>
                        <th class="p-5">Classe</th>
                        <th class="p-5 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $user)
                    <tr class="tr-style text-white text-sm">
                        <td class="p-5 font-bold italic">{{ $user->name }}</td>
                        <td class="p-5 font-mono text-xs text-yellow-500/30">#{{ $user->student_id }}</td>
                        <td class="p-5 text-blue-400">{{ $user->class_name }}</td>
                        <td class="p-5 flex justify-center gap-4">
                            <button onclick="openModalForEdit({{ json_encode($user) }})" class="text-gray-500 hover:text-blue-400"><i class="fas fa-edit"></i></button>
                            <form action="{{ route('students.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-500 hover:text-red-500"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="view-staff" class="table-container shadow-2xl" style="display:none;">
            <table class="w-full text-left">
                <thead class="bg-[#1c1e29] text-gray-500 text-[10px] uppercase font-black border-b border-[#2d2e3d]">
                    <tr>
                        <th class="p-5">Nom Complet</th>
                        <th class="p-5">ID Badge</th>
                        <th class="p-5">Solde (DA)</th>
                        <th class="p-5 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($staff as $user)
                    <tr class="tr-style text-white text-sm">
                        <td class="p-5 font-bold italic">{{ $user->name }}</td>
                        <td class="p-5 font-mono text-xs text-yellow-500/30">#{{ $user->student_id }}</td>
                        <td class="p-5 {{ $user->balance < 20 ? 'text-red-500 font-black' : 'text-green-400' }}">
                            {{ $user->balance }} DA
                        </td>
                        <td class="p-5 flex justify-center gap-4">
                            <button onclick="openModalForEdit({{ json_encode($user) }})" class="text-gray-500 hover:text-blue-400"><i class="fas fa-edit"></i></button>
                            <form action="{{ route('students.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-500 hover:text-red-500"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="memberModal" class="modal">
        <div class="dashboard-card w-full max-w-md">
            <h3 id="modalTitle" class="text-white text-xl font-black uppercase italic mb-6">Profil</h3>
            <form id="memberForm" method="POST">
                @csrf
                <div id="methodField"></div>
                <div class="space-y-4">
                    <select name="type" id="typeSelector" class="custom-input" onchange="toggleFields()">
                        <option value="student">🎓 ÉTUDIANT</option>
                        <option value="employeur">💼 EMPLOYEUR</option> </select>
                    <input type="text" name="name" id="nameInput" class="custom-input" placeholder="Nom..." required>
                    <input type="text" name="student_id" id="idInput" class="custom-input" placeholder="ID Badge..." required>
                    
                    <div id="studentField"><input type="text" name="class_name" id="classInput" class="custom-input" placeholder="Classe..."></div>
                    <div id="staffField" class="hidden"><input type="number" name="balance" id="balanceInput" class="custom-input" placeholder="Solde Initial (DA)..."></div>
                    
                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <button type="submit" class="bg-yellow-500 text-black py-4 rounded-xl font-black text-[10px] uppercase shadow-lg">Enregistrer</button>
                        <button type="button" onclick="closeModal()" class="bg-gray-700 text-white py-4 rounded-xl font-black text-[10px] uppercase">Annuler</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('login-btn').addEventListener('click', function() {
            const pass = document.getElementById('admin-pass').value;
            if (pass === "1234") {
                localStorage.setItem('admin_logged_in', 'true');
                unlockDashboard();
            } else { alert("Mot de passe incorrect !"); }
        });

        function unlockDashboard() {
            document.getElementById('login-overlay').style.display = 'none';
            document.getElementById('admin-content').style.display = 'block';
        }

        window.onload = function() {
            if (localStorage.getItem('admin_logged_in') === 'true') { unlockDashboard(); }
        };

        function logout() {
            localStorage.removeItem('admin_logged_in');
            location.reload();
        }

        function switchTab(tab) {
            const isStudent = (tab === 'students');
            document.getElementById('view-students').style.display = isStudent ? 'block' : 'none';
            document.getElementById('view-staff').style.display = isStudent ? 'none' : 'block';
            document.getElementById('btn-students').className = isStudent ? 'tab-btn tab-active' : 'tab-btn tab-inactive';
            document.getElementById('btn-staff').className = isStudent ? 'tab-btn tab-inactive' : 'tab-btn tab-active';
        }

        function toggleFields() {
            const type = document.getElementById('typeSelector').value;
            document.getElementById('studentField').classList.toggle('hidden', type !== 'student');
            document.getElementById('staffField').classList.toggle('hidden', type !== 'employeur'); // التغيير هنا
        }

        function openModalForAdd() {
            document.getElementById('memberForm').action = "{{ route('students.store') }}";
            document.getElementById('methodField').innerHTML = '';
            document.getElementById('modalTitle').innerText = "Nouveau Profil";
            document.getElementById('memberForm').reset();
            document.getElementById('memberModal').style.display = 'flex';
            toggleFields();
        }

        function openModalForEdit(m) {
            document.getElementById('memberForm').action = "/admin/update/" + m.id;
            document.getElementById('methodField').innerHTML = '@method("PUT")';
            document.getElementById('modalTitle').innerText = "Modifier Profil";
            document.getElementById('nameInput').value = m.name;
            document.getElementById('idInput').value = m.student_id;
            document.getElementById('typeSelector').value = m.type;
            document.getElementById('classInput').value = m.class_name || '';
            document.getElementById('balanceInput').value = m.balance || 0;
            toggleFields();
            document.getElementById('memberModal').style.display = 'flex';
        }

        function closeModal() { document.getElementById('memberModal').style.display = 'none'; }
    </script>
</body>
</html>