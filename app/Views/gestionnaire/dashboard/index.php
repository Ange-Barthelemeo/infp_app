<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Gestionnaire Central - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
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

        <!-- SIDEBAR -->
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

                <!-- Profil Gestionnaire Central -->
                <div class="p-4 m-4 bg-gray-50 rounded-xl border border-gray-100 flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                        <?= strtoupper(substr($prenoms ?? 'G', 0, 1)) ?>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-gray-900 truncate"><?= esc(($prenoms ?? '') . ' ' . ($nom ?? 'Gestionnaire')) ?></p>
                        <p class="text-[10px] font-mono text-gray-500"><?= esc($immutilisateur) ?></p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="px-4 space-y-1">
                    <a href="/gestionnaire/dashboard" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg bg-emerald-600 text-white text-sm font-medium transition shadow-sm">
                        <i class="fa-solid fa-chart-pie w-5"></i>
                        <span>Tableau de bord</span>
                    </a>
                    <a href="/centres" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 text-sm font-medium transition">
                        <i class="fa-solid fa-building-columns w-5"></i>
                        <span>Centres régionaux</span>
                    </a>
                    <a href="/formateurs" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 text-sm font-medium transition">
                        <i class="fa-solid fa-chalkboard-user w-5"></i>
                        <span>Formateurs</span>
                    </a>
                    <!-- Gestion unifiée des UE et de leurs EC associés -->
                    <a href="/unites-enseignement" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 text-sm font-medium transition">
                        <i class="fa-solid fa-book-open w-5"></i>
                        <span>Gestion des UE & EC</span>
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

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col h-full overflow-y-auto bg-gray-50/50">
            
            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
                <div class="flex items-center space-x-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">SUPERVISION NATIONALE — ESPACE GESTIONNAIRE CENTRAL</span>
                </div>
                <div class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                    <i class="fa-regular fa-calendar-days mr-1.5 text-gray-400"></i> <?= date('d / m / Y') ?>
                </div>
            </header>

            <!-- Contenu de la page -->
            <div class="p-8 max-w-7xl mx-auto w-full space-y-8">
                
                <!-- En-tête de bienvenue -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Tableau de bord national</h2>
                    <p class="text-sm text-gray-500 mt-1">Vue d'ensemble et pilotage de l'ensemble des structures et formateurs de l'INFP.</p>
                </div>

                <!-- BLOCS DE CHIFFRES CLÉS (KPIs) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <!-- Centres Régionaux -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg font-bold">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Centres Régionaux</p>
                            <p class="text-2xl font-extrabold text-gray-900 mt-0.5"><?= $totalCentres ?></p>
                        </div>
                    </div>

                    <!-- Total Élèves-Maîtres -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg font-bold">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Élèves-Maîtres</p>
                            <p class="text-2xl font-extrabold text-gray-900 mt-0.5"><?= $totalEleves ?? 0 ?></p>
                        </div>
                    </div>

                    <!-- Total Formateurs -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg font-bold">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Formateurs Actifs</p>
                            <p class="text-2xl font-extrabold text-gray-900 mt-0.5"><?= $totalFormateurs ?></p>
                        </div>
                    </div>

                    <!-- Ventilation RH (Permanents / Vacataires) -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm flex flex-col justify-center">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Corps Enseignant</p>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="px-2 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-xs font-bold border border-emerald-100">
                                <?= $totalPermanents ?> Perm.
                            </span>
                            <span class="px-2 py-1 bg-amber-50 text-amber-700 rounded-lg text-xs font-bold border border-amber-100">
                                <?= $totalVacataires ?> Vac.
                            </span>
                        </div>
                    </div>

                </div>

                <!-- SECTION SECONDAIRE : ACTIONS RAPIDES & RÉPARTITION GÉOGRAPHIQUE -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Actions Rapides -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm space-y-4">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-bolt text-amber-500"></i> Actions rapides
                        </h3>
                        <div class="space-y-2">
                            <a href="/centres" class="w-full flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-emerald-50 hover:text-emerald-700 text-gray-700 text-xs font-bold transition border border-gray-100">
                                <span class="flex items-center gap-2.5">
                                    <i class="fa-solid fa-building-columns text-emerald-600"></i> Gérer les centres régionaux
                                </span>
                                <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
                            </a>
                            <a href="/formateurs" class="w-full flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-emerald-50 hover:text-emerald-700 text-gray-700 text-xs font-bold transition border border-gray-100">
                                <span class="flex items-center gap-2.5">
                                    <i class="fa-solid fa-chalkboard-user text-emerald-600"></i> Gérer les formateurs
                                </span>
                                <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Répartition Géographique Simplifiée -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm lg:col-span-2 space-y-4">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-map-location-dot text-emerald-600"></i> Couverture géographique des centres
                        </h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 max-h-48 overflow-y-auto pr-2">
                            <?php if (!empty($repartitionGeo)): ?>
                                <?php foreach ($repartitionGeo as $geo): ?>
                                    <div class="p-3 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-between">
                                        <span class="text-xs font-semibold text-gray-700 truncate"><?= esc($geo['LOCALISATION']) ?></span>
                                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded-md text-xs font-bold"><?= $geo['total'] ?></span>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-xs text-gray-400 col-span-full italic">Aucune localisation enregistrée pour le moment.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

            </div>
        </main>

    </div>

</body>
</html>