<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans antialiased flex flex-col h-screen overflow-hidden">

    <!-- BANDE TRICOLORE INSTITUTIONNELLE (Rappel de la page de connexion) -->
    <div class="h-1.5 w-full flex">
        <div class="w-1/3 bg-red-600"></div>
        <div class="w-1/3 bg-white"></div>
        <div class="w-1/3 bg-emerald-600"></div>
    </div>

    <div class="flex flex-1 overflow-hidden">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between">
            <div>
                <!-- En-tête / Logo (Drapeau officiel de Madagascar) -->
                <div class="p-6 border-b border-gray-100 flex items-center space-x-3">
                    <div class="w-9 h-6 rounded overflow-hidden shadow-sm flex border border-gray-200 shrink-0">
                        <!-- Bande verticale blanche à gauche -->
                        <div class="w-1/3 h-full bg-white"></div>
                        <!-- Blocs horizontaux rouge (haut) et vert (bas) à droite -->
                        <div class="w-2/3 h-full flex flex-col">
                            <div class="h-1/2 w-full bg-red-600"></div>
                            <div class="h-1/2 w-full bg-emerald-600"></div>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-sm font-bold text-gray-800"><?= esc(get_setting('app_name', 'INFP Madagascar')) ?></h1>
                        <p class="text-[11px] text-gray-500"><?= esc(get_setting('app_subtitle', 'Administration Technique')) ?></p>
                    </div>
                </div>

                <!-- Profil Admin Convivial (Nom, Prénom et Matricule) -->
                <div class="p-4 m-4 bg-gray-50 rounded-xl border border-gray-100 flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                        <?= strtoupper(substr($prenoms ?? 'A', 0, 1)) ?>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-gray-900 truncate"><?= esc(($prenoms ?? '') . ' ' . ($nom ?? 'Administrateur')) ?></p>
                        <p class="text-[10px] font-mono text-gray-500"><?= esc($immutilisateur) ?></p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="px-4 space-y-1">
                    <a href="/dashboard" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg bg-emerald-600 text-white text-sm font-medium transition shadow-sm">
                        <i class="fa-solid fa-chart-pie w-5"></i>
                        <span>Tableau de bord</span>
                    </a>
                    <a href="/utilisateurs" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 text-sm font-medium transition">
                        <i class="fa-solid fa-users-gear w-5"></i>
                        <span>Gestion des comptes</span>
                    </a>
                    <a href="/audit-logs" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 text-sm font-medium transition">
                        <i class="fa-solid fa-shield-halved w-5"></i>
                        <span>Journaux d'audit (Logs)</span>
                    </a>
                    <a href="/admin/profile" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 text-sm font-medium transition">
                        <i class="fa-solid fa-user-gear w-5"></i>
                        <span>Mon Profil Admin</span>
                    </a>
                    <a href="/parametres" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 text-sm font-medium transition">
                        <i class="fa-solid fa-sliders w-5"></i>
                        <span>Paramètres système</span>
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
        <main class="flex-1 flex flex-col overflow-y-auto bg-gray-50/50">
            
            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8">
                <div class="flex items-center space-x-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Système Opérationnel — Environnement Sécurisé</span>
                </div>
                <div class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                    <i class="fa-regular fa-calendar-days mr-1.5 text-gray-400"></i> <?= date('d / m / Y') ?>
                </div>
            </header>

            <!-- Contenu de la page -->
            <div class="p-8 max-w-7xl mx-auto w-full space-y-8">
                
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Tableau de bord technique</h2>
                    <p class="text-sm text-gray-500 mt-1">Supervision globale des accès, des comptes utilisateurs et de la sécurité de l'infrastructure.</p>
                </div>

                <!-- Cartes Statistiques Techniques -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Comptes Gérés</p>
                            <h3 class="text-3xl font-extrabold text-gray-900 mt-2"><?= $totalUsers ?? 0 ?></h3>
                            <p class="text-xs text-emerald-600 mt-1 font-medium flex items-center gap-1">
                                <i class="fa-solid fa-check"></i> Actifs dans la base
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shadow-inner">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Comptes Actifs</p>
                            <h3 class="text-3xl font-extrabold text-gray-900 mt-2"><?= $activeUsers ?? 0 ?></h3>
                            <p class="text-xs text-blue-600 mt-1 font-medium">Accès autorisés</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-inner">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Sécurité & Chiffrement</p>
                            <h3 class="text-3xl font-extrabold text-emerald-600 mt-2">100%</h3>
                            <p class="text-xs text-gray-500 mt-1">Algorithme BCRYPT actif</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl shadow-inner">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                    </div>
                </div>

                <!-- Tableau : Derniers utilisateurs -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900">Derniers comptes utilisateurs créés</h3>
                        <a href="/utilisateurs" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">Voir tout &rarr;</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 text-[11px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                    <th class="py-3 px-6">Matricule (IMMUTILISATEUR)</th>
                                    <th class="py-3 px-6">Utilisateur (Nom & Prénoms)</th>
                                    <th class="py-3 px-6">Email</th>
                                    <th class="py-3 px-6">Profil</th>
                                    <th class="py-3 px-6">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                <?php if (!empty($recentUsers)): ?>
                                    <?php foreach ($recentUsers as $u): ?>
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="py-4 px-6 font-mono text-xs text-gray-600"><?= esc($u['IMMUTILISATEUR']) ?></td>
                                            <td class="py-4 px-6 font-bold text-gray-900">
                                                <?= esc(($u['NOM'] ?? '') . ' ' . ($u['PRENOMS'] ?? '')) ?>
                                            </td>
                                            <td class="py-4 px-6 text-gray-600"><?= esc($u['EMAIL']) ?></td>
                                            <td class="py-4 px-6">
                                                <span class="inline-block px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-md">
                                                    <?= esc($u['PROFIL']) ?>
                                                </span>
                                            </td>
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
                                        <td colspan="5" class="py-6 text-center text-gray-400 text-sm">Aucun utilisateur enregistré.</td>
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