<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Élèves - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
    <script src="<?= base_url('assets/js/tailwind.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/all.min.css') ?>">
</head>
<body class="bg-gray-50 font-sans antialiased flex flex-col h-screen overflow-hidden">

    <!-- BANDE TRICOLORE INSTITUTIONNELLE -->
    <div class="h-1.5 w-full flex shrink-0">
        <div class="w-1/3 bg-red-600"></div>
        <div class="w-1/3 bg-white"></div>
        <div class="w-1/3 bg-emerald-600"></div>
    </div>

    <div class="flex flex-1 overflow-hidden">

        <!-- APPEL DU SIDEBAR -->
        <?= view('gestionnaire/sidebar', ['user' => ['NOM' => $nom ?? '', 'PRENOMS' => $prenoms ?? ''], 'immutilisateur' => $immutilisateur]) ?>

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col h-full overflow-y-auto bg-gray-50/50">
            
            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
                <div class="flex items-center space-x-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">ESPACE GESTIONNAIRE DE CENTRE — CENTRE : <?= esc($centre['NOMCENTRE'] ?? 'Mon Centre') ?></span>
                </div>
                <div class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                    <i class="fa-regular fa-calendar-days mr-1.5 text-gray-400"></i> <?= date('d / m / Y') ?>
                </div>
            </header>

            <!-- Contenu de la page -->
            <div class="p-8 max-w-7xl mx-auto w-full space-y-6">
                
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Gestion des élèves</h2>
                        <p class="text-sm text-gray-500 mt-1">Gérez les dossiers et inscriptions des élèves rattachés à votre centre.</p>
                    </div>
                    <a href="/gestionnaire/eleves/create" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm transition flex items-center gap-2">
                        <i class="fa-solid fa-user-plus"></i> Nouvel élève
                    </a>
                </div>

                <!-- Messages Flash Unifiés -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="flash-message p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl flex items-center justify-between shadow-sm transition-opacity duration-500">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                            <span><?= session()->getFlashdata('success') ?></span>
                        </div>
                        <button onclick="dismissFlash(this)" class="text-emerald-500 hover:text-emerald-700"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="flash-message p-3.5 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl flex items-center justify-between shadow-sm transition-opacity duration-500">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-circle-exclamation text-red-600 text-base"></i>
                            <span><?= session()->getFlashdata('error') ?></span>
                        </div>
                        <button onclick="dismissFlash(this)" class="text-red-500 hover:text-red-700"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                <?php endif; ?>

                <!-- BARRE DE RECHERCHE -->
                <div class="bg-white p-3.5 rounded-2xl border border-gray-200/80 shadow-sm">
                    <form id="filterForm" action="/gestionnaire/eleves" method="GET" class="flex gap-3 items-center">
                        <div class="relative flex-1">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-gray-400 text-xs pointer-events-none"></i>
                            <input type="text" id="searchInput" name="search" value="<?= esc($search ?? '') ?>" placeholder="Rechercher par matricule, nom, prénom, CIN ou téléphone..." autocomplete="off" class="w-full pl-9 pr-3 py-2 rounded-xl border border-gray-200 text-xs bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 font-medium text-gray-700 placeholder-gray-400 transition">
                        </div>
                        <a href="/gestionnaire/eleves" class="p-2 h-9 w-9 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl transition flex items-center justify-center shrink-0" title="Réinitialiser">
                            <i class="fa-solid fa-rotate-right text-xs"></i>
                        </a>
                    </form>
                </div>

                <!-- Tableau des élèves -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900">Liste des élèves inscrits</h3>
                        <span class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            Total : <?= count($eleves) ?> élève(s)
                        </span>
                    </div>
                    
                    <div class="w-full overflow-x-auto">
                        <table class="w-full text-left border-collapse table-auto">
                            <thead>
                                <tr class="bg-gray-50/50 text-[11px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                    <th class="py-3.5 px-4 whitespace-nowrap">Matricule</th>
                                    <th class="py-3.5 px-4">Élève</th>
                                    <th class="py-3.5 px-4">Classe</th>
                                    <th class="py-3.5 px-4">Contact</th>
                                    <th class="py-3.5 px-4">Statut Examen</th>
                                    <th class="py-3.5 px-4">Statut Final</th>
                                    <th class="py-3.5 px-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-xs">
                                <?php if (!empty($eleves)): ?>
                                    <?php foreach ($eleves as $u): ?>
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="py-4 px-4 font-mono font-semibold text-emerald-700 whitespace-nowrap"><?= esc($u['MATRICULEELEVE']) ?></td>
                                            <td class="py-4 px-4 font-bold text-gray-900">
                                                <?= esc(($u['NOMELEVE'] ?? '') . ' ' . ($u['PRENOMELEVE'] ?? '')) ?>
                                                <span class="block text-[10px] font-mono text-gray-400">CIN: <?= esc($u['NUMCINELEVE']) ?></span>
                                            </td>
                                            <td class="py-4 px-4 font-medium text-gray-700"><?= esc($u['NOMCLASSE'] ?? 'N/A') ?></td>
                                            <td class="py-4 px-4 text-gray-600"><?= esc($u['TELEPHONEELEVE'] ?? 'Non renseigné') ?></td>
                                            <td class="py-4 px-4">
                                                <?php if ($u['STATUTEXAMEN'] === 'Autorisé'): ?>
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-medium bg-emerald-50 text-emerald-700 rounded-full">Autorisé</span>
                                                <?php else: ?>
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-medium bg-rose-50 text-rose-700 rounded-full">Disqualifié</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-4 px-4">
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-medium bg-gray-100 text-gray-700 rounded-full"><?= esc($u['STATUTFINAL']) ?></span>
                                            </td>
                                            <td class="py-3 px-4 text-center align-middle whitespace-nowrap">
                                                <div class="inline-flex items-center justify-center gap-2">
                                                    <a href="/gestionnaire/eleves/edit/<?= urlencode($u['MATRICULEELEVE']) ?>" class="px-2.5 h-7 text-[11px] font-semibold rounded-lg border border-blue-200 bg-blue-50/50 hover:bg-blue-100 text-blue-700 transition inline-flex items-center justify-center">
                                                        Modifier
                                                    </a>
                                                    <a href="/gestionnaire/eleves/delete/<?= urlencode($u['MATRICULEELEVE']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élève ?')" class="px-2.5 h-7 text-[11px] font-semibold rounded-lg border border-rose-200 bg-rose-50/50 hover:bg-rose-100 text-rose-700 transition inline-flex items-center justify-center" title="Supprimer">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="py-12 text-center text-gray-400 text-sm italic">
                                            Aucun élève trouvé avec ces critères.
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

    <!-- Scripts -->
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
            if (val.length > 0) searchInput.focus();
        }

        function dismissFlash(btn) {
            const msg = btn.closest('.flash-message');
            if (msg) {
                msg.style.opacity = '0';
                setTimeout(() => msg.remove(), 500);
            }
        }
    </script>
</body>
</html>