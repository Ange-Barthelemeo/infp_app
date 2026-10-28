<!-- SIDEBAR GESTIONNAIRE DE CENTRE -->
<aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between shrink-0">
    <div>
        <!-- En-tête / Logo (Drapeau officiel) -->
        <div class="p-6 border-b border-gray-100 flex items-center space-x-3">
            <div class="w-9 h-6 rounded overflow-hidden shadow-sm flex border border-gray-200 shrink-0">
                <div class="w-1/3 h-full bg-white"></div>
                <div class="w-2/3 h-full flex flex-col">
                    <div class="h-1/2 w-full bg-red-600"></div>
                    <div class="h-1/2 w-full bg-emerald-600"></div>
                </div>
            </div>
            <div>
                <h1 class="text-sm font-bold text-gray-800"><?= esc(get_setting('app_name', 'INFP Madagascar')) ?></h1>
                <p class="text-[11px] text-gray-500">Gestion de Centre</p>
            </div>
        </div>

        <!-- Profil Connecté -->
        <div class="p-4 m-4 bg-gray-50 rounded-xl border border-gray-100 flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-emerald-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                <?= strtoupper(substr($user['PRENOMS'] ?? 'G', 0, 1)) ?>
            </div>
            <div class="overflow-hidden">
                <p class="text-xs font-bold text-gray-900 truncate"><?= esc(($user['PRENOMS'] ?? '') . ' ' . ($user['NOM'] ?? '')) ?></p>
                <p class="text-[10px] font-mono text-gray-500"><?= esc($immutilisateur ?? '') ?></p>
            </div>
        </div>

        <!-- Navigation du Gestionnaire de Centre avec détection dynamique de la page active -->
        <nav class="px-4 space-y-1">
            
            <!-- Tableau de bord -->
            <a href="/gestionnaire/dashboard" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-sm font-medium transition <?= (uri_string() == 'gestionnaire/dashboard') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                <i class="fa-solid fa-chart-pie w-5"></i>
                <span>Tableau de bord</span>
            </a>

            <!-- Responsables de centre -->
            <a href="/gestionnaire/responsables" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-sm font-medium transition <?= (uri_string() == 'gestionnaire/responsables') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                <i class="fa-solid fa-user-tie w-5"></i>
                <span>Responsables de centre</span>
            </a>

            <!-- Gestion des Formateurs -->
            <a href="/gestionnaire/formateurs" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-sm font-medium transition <?= (uri_string() == 'gestionnaire/formateurs') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                <i class="fa-solid fa-chalkboard-user w-5"></i>
                <span>Gestion des Formateurs</span>
            </a>

            <!-- Gestion des Classes -->
            <a href="/gestionnaire/classes" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-sm font-medium transition <?= (uri_string() == 'gestionnaire/classes') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                <i class="fa-solid fa-school w-5"></i>
                <span>Gestion des Classes</span>
            </a>

            <!-- Gestion des Élèves -->
            <a href="/gestionnaire/eleves" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-sm font-medium transition <?= (uri_string() == 'gestionnaire/eleves') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                <i class="fa-solid fa-user-graduate w-5"></i>
                <span>Gestion des Élèves</span>
            </a>

            <!-- Séances & Emplois du temps -->
            <a href="/gestionnaire/seances" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-sm font-medium transition <?= (uri_string() == 'gestionnaire/seances') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                <i class="fa-solid fa-calendar-days w-5"></i>
                <span>Séances / Emploi du temps</span>
            </a>

            <!-- Notes & Admis -->
            <a href="/gestionnaire/notes" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-sm font-medium transition <?= (uri_string() == 'gestionnaire/notes') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                <i class="fa-solid fa-clipboard-user w-5"></i>
                <span>Notes & Admis</span>
            </a>

            <!-- Mon Profil -->
            <a href="/gestionnaire/profile" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-sm font-medium transition <?= (uri_string() == 'gestionnaire/profile') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                <i class="fa-solid fa-user-gear w-5"></i>
                <span>Mon Profil</span>
            </a>

        </nav>
    </div>

    <!-- Déconnexion -->
    <div class="p-4 border-t border-gray-100">
        <a href="/logout" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-red-600 hover:bg-red-50 text-sm font-medium transition">
            <i class="fa-solid fa-right-from-bracket w-5"></i>
            <span>Déconnexion</span>
        </a>
    </div>
</aside>