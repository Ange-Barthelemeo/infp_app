<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
    <script src="<?= base_url('assets/js/tailwind.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/all.min.css') ?>">
</head>
<body class="bg-gray-50 font-sans antialiased flex flex-col h-screen overflow-hidden">

    <!-- BANDE TRICOLORE INSTITUTIONNELLE -->
    <div class="h-1.5 w-full flex">
        <div class="w-1/3 bg-red-600"></div>
        <div class="w-1/3 bg-white"></div>
        <div class="w-1/3 bg-emerald-600"></div>
    </div>

    <div class="flex flex-1 overflow-hidden">

        <!-- APPEL DU SIDEBAR DU GESTIONNAIRE -->
        <?= view('gestionnaire/sidebar', ['user' => ['NOM' => $nom ?? '', 'PRENOMS' => $prenoms ?? ''], 'immutilisateur' => $immutilisateur]) ?>

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col overflow-y-auto bg-gray-50/50">
            
            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8">
                <div class="flex items-center space-x-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Espace Gestionnaire de Centre — Centre : <?= esc($nomCentre ?? 'Mon Centre') ?></span>
                </div>
                <div class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                    <i class="fa-regular fa-calendar-days mr-1.5 text-gray-400"></i> <?= date('d / m / Y') ?>
                </div>
            </header>

            <!-- Contenu de la page -->
            <div class="p-8 max-w-7xl mx-auto w-full space-y-8">
                
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Tableau de bord du centre</h2>
                    <p class="text-sm text-gray-500 mt-1">Supervision des responsables, des effectifs d'élèves, des formateurs et des classes de votre centre.</p>
                </div>

                <!-- Cartes Statistiques Métier -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    
                    <!-- 1. Responsables de centre créés -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Responsables</p>
                            <h3 class="text-3xl font-extrabold text-gray-900 mt-2"><?= $totalResponsables ?? 0 ?></h3>
                            <p class="text-xs text-emerald-600 mt-1 font-medium">Comptes créés</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shadow-inner">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                    </div>

                    <!-- 2. Total des élèves du centre -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Élèves</p>
                            <h3 class="text-3xl font-extrabold text-gray-900 mt-2"><?= $totalEleves ?? 0 ?></h3>
                            <p class="text-xs text-blue-600 mt-1 font-medium">Inscrits au centre</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-inner">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                    </div>

                    <!-- 3. Total des formateurs du centre -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Formateurs</p>
                            <h3 class="text-3xl font-extrabold text-gray-900 mt-2"><?= $totalFormateurs ?? 0 ?></h3>
                            <p class="text-xs text-indigo-600 mt-1 font-medium">Affectés au centre</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shadow-inner">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                    </div>

                    <!-- 4. Nombre de classes créées -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Classes</p>
                            <h3 class="text-3xl font-extrabold text-gray-900 mt-2"><?= $totalClasses ?? 0 ?></h3>
                            <p class="text-xs text-purple-600 mt-1 font-medium">Sections organisées</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl shadow-inner">
                            <i class="fa-solid fa-school"></i>
                        </div>
                    </div>

                </div>

                <!-- Tableau : Derniers responsables créés -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900">Derniers comptes responsables créés</h3>
                        <a href="/gestionnaire/responsables" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">Voir tout &rarr;</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 text-[11px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                    <th class="py-3 px-6">Matricule (IMMUTILISATEUR)</th>
                                    <th class="py-3 px-6">Responsable (Nom & Prénoms)</th>
                                    <th class="py-3 px-6">Email</th>
                                    <th class="py-3 px-6">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                <?php if (!empty($recentResponsables)): ?>
                                    <?php foreach ($recentResponsables as $u): ?>
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="py-4 px-6 font-mono text-xs text-gray-600"><?= esc($u['IMMUTILISATEUR']) ?></td>
                                            <td class="py-4 px-6 font-bold text-gray-900">
                                                <?= esc(($u['NOM'] ?? '') . ' ' . ($u['PRENOMS'] ?? '')) ?>
                                            </td>
                                            <td class="py-4 px-6 text-gray-600"><?= esc($u['EMAIL']) ?></td>
                                            <td class="py-4 px-6">
                                                <?php if ($u['ACTIF']): ?>
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium bg-emerald-50 text-emerald-700 rounded-full">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Actif
                                                    </span>
                                                <?php else: ?>
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium bg-red-50 text-red-700 rounded-full">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Inactif
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="py-6 text-center text-gray-400 text-sm">Aucun responsable enregistré pour le moment.</td>
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