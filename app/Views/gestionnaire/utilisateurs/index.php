<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des comptes - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans antialiased flex flex-col h-screen overflow-hidden">

    <!-- BANDE TRICOLORE INSTITUTIONNELLE -->
    <div class="h-1.5 w-full flex shrink-0">
        <div class="w-1/3 bg-red-600"></div>
        <div class="w-1/3 bg-white"></div>
        <div class="w-1/3 bg-emerald-600"></div>
    </div>

    <div class="flex flex-1 overflow-hidden">

        <!-- SIDEBAR GESTIONNAIRE CENTRAL -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between shrink-0">
            <div>
                <!-- En-tête / Logo -->
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
                        <p class="text-[11px] text-gray-500">Gestion Centrale</p>
                    </div>
                </div>

                <!-- Profil Gestionnaire Convivial -->
                <div class="p-4 m-4 bg-gray-50 rounded-xl border border-gray-100 flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                        <?= strtoupper(substr($prenoms ?? 'G', 0, 1)) ?>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-gray-900 truncate"><?= esc(($prenoms ?? '') . ' ' . ($nom ?? 'Gestionnaire')) ?></p>
                        <p class="text-[10px] font-mono text-gray-500">
                            <?php 
                                $gesImBrut = preg_replace('/\D/', '', $immutilisateur ?? '');
                                echo (strlen($gesImBrut) === 6) ? substr($gesImBrut, 0, 3) . ' ' . substr($gesImBrut, 3, 3) : esc($immutilisateur);
                            ?>
                        </p>
                    </div>
                </div>

                <!-- Navigation synchronisée -->
                <nav class="px-4 space-y-1 overflow-y-auto max-h-[calc(100vh-280px)] pb-4">
                    <?php $uri = service('uri'); ?>
                    
                    <a href="/gestionnaire/dashboard" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg <?= ($uri->getSegment(2) == 'dashboard' || !$uri->getSegment(2)) ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> text-sm font-medium transition">
                        <i class="fa-solid fa-chart-pie w-5 <?= ($uri->getSegment(2) == 'dashboard' || !$uri->getSegment(2)) ? 'text-white' : 'text-emerald-600' ?>"></i>
                        <span>Tableau de bord</span>
                    </a>

                    <a href="/gestionnaire/centres" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg <?= ($uri->getSegment(2) == 'centres') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> text-sm font-medium transition">
                        <i class="fa-solid fa-building-columns w-5 <?= ($uri->getSegment(2) == 'centres') ? 'text-white' : 'text-emerald-600' ?>"></i>
                        <span>Centres régionaux</span>
                    </a>

                    <a href="/gestionnaire/formateurs" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg <?= ($uri->getSegment(2) == 'formateurs') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> text-sm font-medium transition">
                        <i class="fa-solid fa-chalkboard-user w-5 <?= ($uri->getSegment(2) == 'formateurs') ? 'text-white' : 'text-emerald-600' ?>"></i>
                        <span>Formateurs</span>
                    </a>

                    <a href="/gestionnaire/utilisateurs" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg <?= ($uri->getSegment(2) == 'utilisateurs') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> text-sm font-medium transition">
                        <i class="fa-solid fa-users-gear w-5 <?= ($uri->getSegment(2) == 'utilisateurs') ? 'text-white' : 'text-emerald-600' ?>"></i>
                        <span>Comptes Centres</span>
                    </a>

                    <a href="/gestionnaire/profile" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg <?= ($uri->getSegment(2) == 'profile') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> text-sm font-medium transition">
                        <i class="fa-solid fa-user-gear w-5 <?= ($uri->getSegment(2) == 'profile') ? 'text-white' : 'text-emerald-600' ?>"></i>
                        <span>Mon Profil</span>
                    </a>
                </nav>
            </div>

            <!-- Déconnexion -->
            <div class="p-4 border-t border-gray-100 shrink-0">
                <a href="/logout" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-red-600 hover:bg-red-50 text-sm font-medium transition">
                    <i class="fa-solid fa-right-from-bracket w-5"></i>
                    <span>Déconnexion</span>
                </a>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col h-full overflow-y-auto bg-gray-50/50">
            
            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
                <div class="flex items-center space-x-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">SUPERVISION — COMPTES DES GESTIONNAIRES DE CENTRE</span>
                </div>
                <div class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                    <i class="fa-regular fa-calendar-days mr-1.5 text-gray-400"></i> <?= date('d / m / Y') ?>
                </div>
            </header>

            <!-- Contenu de la page -->
            <div class="p-8 max-w-7xl mx-auto w-full space-y-6">
                
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Gestion des comptes Gestionnaires de Centre</h2>
                        <p class="text-sm text-gray-500 mt-1">Supervision centralisée et attribution des accès locaux pour les centres régionaux.</p>
                    </div>
                    <a href="/gestionnaire/utilisateurs/create" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm transition flex items-center gap-2">
                        <i class="fa-solid fa-user-plus"></i> Nouveau compte
                    </a>
                </div>

                <!-- Messages Flash -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div id="flash-message" class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl flex items-center justify-between shadow-sm transition-opacity duration-500">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                            <span><?= session()->getFlashdata('success') ?></span>
                        </div>
                        <button onclick="dismissFlash()" class="text-emerald-500 hover:text-emerald-700"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div id="flash-error" class="p-3.5 bg-rose-50 border border-rose-200 text-rose-700 text-sm rounded-xl flex items-center justify-between shadow-sm transition-opacity duration-500">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-circle-exclamation text-rose-600 text-base"></i>
                            <span><?= session()->getFlashdata('error') ?></span>
                        </div>
                        <button onclick="document.getElementById('flash-error').remove()" class="text-rose-500 hover:text-rose-700"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                <?php endif; ?>

                <!-- BARRE DE FILTRES -->
                <div class="bg-white p-3.5 rounded-2xl border border-gray-200/80 shadow-sm">
                    <form id="filterForm" action="/gestionnaire/utilisateurs" method="GET" class="flex flex-wrap md:flex-nowrap gap-3 items-center">
                        
                        <!-- Recherche Textuelle -->
                        <div class="relative flex-1 min-w-[220px]">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-gray-400 text-xs pointer-events-none"></i>
                            <input type="text" id="searchInput" name="search" value="<?= esc($search ?? '') ?>" placeholder="Rechercher par IM, nom, prénom, téléphone..." autocomplete="off" class="w-full pl-9 pr-3 py-2 rounded-xl border border-gray-200 text-xs bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 font-medium text-gray-700 placeholder-gray-400 transition">
                        </div>

                        <!-- Filtre Centre -->
                        <div class="relative min-w-[220px]">
                            <select name="centre" onchange="this.form.submit()" class="w-full pl-3 pr-8 py-2 rounded-xl border border-gray-200 text-xs bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 font-medium text-gray-700 appearance-none cursor-pointer">
                                <option value="">Tous les centres rattachés</option>
                                <?php foreach ($centres as $c): ?>
                                    <option value="<?= esc($c['CODECENTRE']) ?>" <?= (isset($filtreCentre) && $filtreCentre == $c['CODECENTRE']) ? 'selected' : '' ?>><?= esc($c['NOMCENTRE']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <i class="fa-solid fa-filter absolute right-3 top-3 text-gray-400 text-[10px] pointer-events-none"></i>
                        </div>

                        <!-- Reset Filter -->
                        <a href="/gestionnaire/utilisateurs" class="p-2 h-9 w-9 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl transition flex items-center justify-center shrink-0" title="Réinitialiser la recherche et les filtres">
                            <i class="fa-solid fa-rotate-right text-xs"></i>
                        </a>

                    </form>
                </div>

                <!-- Tableau des gestionnaires de centre -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900">Liste des comptes Gestionnaires de Centre</h3>
                        <span class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            Total : <?= count($users) ?> compte(s)
                        </span>
                    </div>
                    
                    <div class="w-full overflow-x-auto">
                        <table class="w-full text-left border-collapse table-auto">
                            <thead>
                                <tr class="bg-gray-50/50 text-[11px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                    <th class="py-3.5 px-4 whitespace-nowrap">Matricule (IM)</th>
                                    <th class="py-3.5 px-4">Utilisateur</th>
                                    <th class="py-3.5 px-4">Contact</th>
                                    <th class="py-3.5 px-4">Centre Rattaché</th>
                                    <th class="py-3.5 px-4">Statut</th>
                                    <th class="py-3.5 px-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-xs">
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $u): ?>
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="py-4 px-4 font-mono font-semibold text-emerald-700 whitespace-nowrap">
                                                <?php 
                                                    $imBrut = preg_replace('/\D/', '', $u['IMMUTILISATEUR']);
                                                    echo (strlen($imBrut) === 6) ? substr($imBrut, 0, 3) . ' ' . substr($imBrut, 3, 3) : esc($u['IMMUTILISATEUR']);
                                                ?>
                                            </td>
                                            <td class="py-4 px-4 font-bold text-gray-900">
                                                <?= esc(($u['NOM'] ?? '') . ' ' . ($u['PRENOMS'] ?? '')) ?>
                                            </td>
                                            <td class="py-4 px-4 text-gray-600">
                                                <div class="truncate max-w-[180px]" title="<?= esc($u['EMAIL']) ?>"><i class="fa-regular fa-envelope mr-1 text-gray-400"></i><?= esc($u['EMAIL']) ?></div>
                                                <div class="text-gray-500 font-mono mt-0.5"><i class="fa-solid fa-phone mr-1 text-gray-400"></i><?= !empty($u['TELEPHONE']) ? esc($u['TELEPHONE']) : '<span class="italic text-gray-400">Non renseigné</span>' ?></div>
                                            </td>
                                            <td class="py-4 px-4 font-semibold text-gray-800">
                                                <?= !empty($u['NOMCENTRE']) ? esc($u['NOMCENTRE']) : '<span class="italic text-gray-400">Non rattaché</span>' ?>
                                            </td>
                                            <td class="py-4 px-4">
                                                <?php if ($u['ACTIF']): ?>
                                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 text-[11px] font-medium bg-emerald-50 text-emerald-700 rounded-full">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Actif
                                                    </span>
                                                <?php else: ?>
                                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 text-[11px] font-medium bg-rose-50 text-rose-700 rounded-full">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Inactif
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-3 px-4 text-center align-middle whitespace-nowrap">
                                                <div class="inline-flex items-center justify-center gap-1.5">
                                                    <?php if ($u['ACTIF']): ?>
                                                        <a href="/gestionnaire/utilisateurs/toggle/<?= urlencode($u['IMMUTILISATEUR']) ?>" class="w-24 h-7 text-[11px] font-semibold rounded-lg border border-rose-200 bg-rose-50/50 hover:bg-rose-100 text-rose-700 transition inline-flex items-center justify-center shadow-2xs">
                                                            Désactiver
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="/gestionnaire/utilisateurs/toggle/<?= urlencode($u['IMMUTILISATEUR']) ?>" class="w-24 h-7 text-[11px] font-semibold rounded-lg border border-emerald-200 bg-emerald-50/50 hover:bg-emerald-100 text-emerald-700 transition inline-flex items-center justify-center shadow-2xs">
                                                            Activer
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="py-12 text-center text-gray-400 text-sm italic">
                                            Aucun gestionnaire de centre trouvé avec ces critères de recherche.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>

    </div>

    <!-- Script de Recherche Dynamique (Debounce 350ms) -->
    <script>
        let debounceTimer;
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    document.getElementById('filterForm').submit();
                }, 350);
            });

            const val = searchInput.value;
            searchInput.value = '';
            searchInput.value = val;
            if (val.length > 0) {
                searchInput.focus();
            }
        }

        function dismissFlash() {
            const msg = document.getElementById('flash-message');
            if (msg) {
                msg.style.opacity = '0';
                setTimeout(() => msg.remove(), 500);
            }
        }
        document.addEventListener('DOMContentLoaded', () => {
            const msg = document.getElementById('flash-message');
            if (msg) {
                setTimeout(() => dismissFlash(), 5000);
            }
        });
    </script>

</body>
</html>