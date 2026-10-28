<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Admis & Non Admis - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
    <script src="<?= base_url('assets/js/tailwind.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/all.min.css') ?>">
</head>
<body class="bg-gray-50 font-sans antialiased flex flex-col h-screen overflow-hidden">

    <!-- BANDE TRICOLORE -->
    <div class="h-1.5 w-full flex shrink-0">
        <div class="w-1/3 bg-red-600"></div>
        <div class="w-1/3 bg-white"></div>
        <div class="w-1/3 bg-emerald-600"></div>
    </div>

    <div class="flex flex-1 overflow-hidden">
        <?= view('gestionnaire/sidebar', ['user' => ['NOM' => $nom ?? '', 'PRENOMS' => $prenoms ?? ''], 'immutilisateur' => $immutilisateur]) ?>

        <main class="flex-1 flex flex-col h-full overflow-y-auto bg-gray-50/50">
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
                <div class="flex items-center space-x-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">ESPACE GESTIONNAIRE DE CENTRE — CENTRE : <?= esc($centre['NOMCENTRE'] ?? 'Mon Centre') ?></span>
                </div>
            </header>

            <div class="p-8 max-w-7xl mx-auto w-full space-y-6">
                
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Notes & Délibérations</h2>
                        <p class="text-sm text-gray-500 mt-1">Consultez la liste des étudiants filtrée par statut final d'examen.</p>
                    </div>
                </div>

                <!-- ONGLETS DE NAVIGATION (Retour vers l'index des notes inclus) -->
                <div class="flex border-b border-gray-200 gap-4 text-xs font-semibold">
                    <a href="/gestionnaire/notes" class="pb-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700 flex items-center gap-2 transition">
                        <i class="fa-solid fa-pen-to-square"></i> Saisie des Notes
                    </a>
                    <a href="/gestionnaire/notes/admis" class="pb-3 border-b-2 border-emerald-600 text-emerald-700 flex items-center gap-2">
                        <i class="fa-solid fa-user-check"></i> Liste des Admis & Non Admis
                    </a>
                </div>

                <!-- Barre de Recherche et Filtres -->
                <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-sm">
                    <form id="filterForm" action="/gestionnaire/notes/admis" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
                        
                        <!-- Recherche -->
                        <div class="relative md:col-span-5">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-gray-400 text-xs"></i>
                            <input type="text" id="searchInput" name="search" value="<?= esc($search ?? '') ?>" placeholder="Rechercher par nom ou matricule..." class="w-full pl-9 pr-3 py-2 rounded-xl border border-gray-200 text-xs bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30">
                        </div>

                        <!-- Filtre par Statut Final -->
                        <div class="md:col-span-3">
                            <select name="statut" onchange="this.form.submit()" class="w-full py-2 px-3 rounded-xl border border-gray-200 text-xs bg-gray-50/50 focus:bg-white focus:outline-none font-medium text-gray-700">
                                <option value="">Tous les statuts</option>
                                <option value="Admis" <?= ($filtreStatut === 'Admis') ? 'selected' : '' ?>>Admis</option>
                                <option value="Non Admis" <?= ($filtreStatut === 'Non Admis') ? 'selected' : '' ?>>Non Admis</option>
                                <option value="En cours" <?= ($filtreStatut === 'En cours') ? 'selected' : '' ?>>En cours</option>
                            </select>
                        </div>

                        <!-- Filtre par Classe -->
                        <div class="md:col-span-3">
                            <select name="classe" onchange="this.form.submit()" class="w-full py-2 px-3 rounded-xl border border-gray-200 text-xs bg-gray-50/50 focus:bg-white focus:outline-none font-medium text-gray-700">
                                <option value="">Toutes les classes</option>
                                <?php foreach ($classes as $c): ?>
                                    <option value="<?= esc($c['CODECLASSE']) ?>" <?= ($filtreClasse == $c['CODECLASSE']) ? 'selected' : '' ?>>
                                        <?= esc($c['NOMCLASSE']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Réinitialiser -->
                        <div class="md:col-span-1 flex justify-end">
                            <a href="/gestionnaire/notes/admis" class="w-full h-9 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl transition flex items-center justify-center" title="Réinitialiser"><i class="fa-solid fa-rotate-right text-xs"></i></a>
                        </div>
                    </form>
                </div>

                <!-- Tableau des résultats -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900">Liste des étudiants</h3>
                        <span class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            Total : <?= count($eleves) ?> étudiant(s)
                        </span>
                    </div>

                    <div class="w-full overflow-x-auto">
                        <table class="w-full text-left border-collapse table-auto">
                            <thead>
                                <tr class="bg-gray-50/50 text-[11px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                    <th class="py-3.5 px-4">Matricule</th>
                                    <th class="py-3.5 px-4">Nom & Prénoms</th>
                                    <th class="py-3.5 px-4">Classe</th>
                                    <th class="py-3.5 px-4">Sexe</th>
                                    <th class="py-3.5 px-4">Statut Examen</th>
                                    <th class="py-3.5 px-4">Statut Final</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-xs">
                                <?php if (!empty($eleves)): ?>
                                    <?php foreach ($eleves as $e): ?>
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="py-4 px-4 font-mono font-semibold text-emerald-700"><?= esc($e['MATRICULEELEVE']) ?></td>
                                            <td class="py-4 px-4 font-bold text-gray-900"><?= esc($e['NOMELEVE'] . ' ' . $e['PRENOMELEVE']) ?></td>
                                            <td class="py-4 px-4 text-gray-700 font-medium"><?= esc($e['NOMCLASSE']) ?></td>
                                            <td class="py-4 px-4 text-gray-600"><?= esc($e['SEXE']) ?></td>
                                            <td class="py-4 px-4 text-gray-600"><?= esc($e['STATUTEXAMEN']) ?></td>
                                            <td class="py-4 px-4">
                                                <?php if ($e['STATUTFINAL'] === 'Admis'): ?>
                                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                        <i class="fa-solid fa-check mr-1"></i> Admis
                                                    </span>
                                                <?php elseif ($e['STATUTFINAL'] === 'Non Admis'): ?>
                                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-rose-50 text-rose-700 border border-rose-200">
                                                        <i class="fa-solid fa-xmark mr-1"></i> Non Admis
                                                    </span>
                                                <?php else: ?>
                                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                                        <i class="fa-solid fa-clock mr-1"></i> En cours
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="py-12 text-center text-gray-400 text-sm italic">
                                            Aucun étudiant trouvé pour ces critères.
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
</body>
</html>