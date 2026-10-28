<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journaux d'activité - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
    <script src="<?= base_url('assets/js/tailwind.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/all.min.css') ?>">
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
                        <p class="text-[11px] text-gray-500"><?= esc(get_setting('app_subtitle', 'Administration Technique')) ?></p>
                    </div>
                </div>

                <!-- Profil Admin Convivial -->
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
                    <a href="/dashboard" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 text-sm font-medium transition">
                        <i class="fa-solid fa-chart-pie w-5"></i>
                        <span>Tableau de bord</span>
                    </a>
                    <a href="/utilisateurs" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 text-sm font-medium transition">
                        <i class="fa-solid fa-users-gear w-5"></i>
                        <span>Gestion des comptes</span>
                    </a>
                    <a href="/audit-logs" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg bg-emerald-600 text-white text-sm font-medium transition shadow-sm">
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
        <main class="flex-1 flex flex-col h-full overflow-y-auto bg-gray-50/50">
            
            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
                <div class="flex items-center space-x-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">SYSTÈME OPÉRATIONNEL — ENVIRONNEMENT SÉCURISÉ</span>
                </div>
                <div class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                    <i class="fa-regular fa-calendar-days mr-1.5 text-gray-400"></i> <?= date('d / m / Y') ?>
                </div>
            </header>

            <!-- Contenu de la page (Réduit à max-w-5xl pour éviter l'effet trop large) -->
            <div class="p-8 max-w-5xl mx-auto w-full space-y-6">
                
                <!-- Titre & Description -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Journaux d'activité (Logs)</h2>
                    <p class="text-sm text-gray-500 mt-1">Traçabilité et surveillance des actions effectuées sur la plateforme.</p>
                </div>

                <!-- BARRE DE FILTRE COMPACTE -->
                <div class="bg-white p-3.5 rounded-2xl border border-gray-200/80 shadow-sm flex items-center">
                    <form id="filterForm" action="/audit-logs" method="GET" class="flex items-center gap-3">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-gray-500">Du</span>
                            <input type="date" name="date_debut" value="<?= esc($dateDebut ?? '') ?>" onchange="this.form.submit()" class="h-9 px-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs bg-gray-50 text-gray-700 font-medium">
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-gray-500">Au</span>
                            <input type="date" name="date_fin" value="<?= esc($dateFin ?? '') ?>" onchange="this.form.submit()" class="h-9 px-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs bg-gray-50 text-gray-700 font-medium">
                        </div>
                        
                        <!-- Bouton de réinitialisation -->
                        <a href="/audit-logs" class="w-9 h-9 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-xs font-semibold flex items-center justify-center transition border border-gray-200 shrink-0" title="Réinitialiser les filtres">
                            <i class="fa-solid fa-rotate-right"></i>
                        </a>
                    </form>
                </div>

                <!-- CARTE DU TABLEAU COMPACTE -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                    
                    <!-- En-tête de la carte -->
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900">Historique des journaux d'activité</h3>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                            Total : <?= count($logs ?? []) ?> événement(s)
                        </span>
                    </div>

                    <!-- Corps du Tableau (Paddings réduits pour plus de compacité) -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 border-b border-gray-200 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                                    <th class="py-3 px-5 w-24">ID LOG</th>
                                    <th class="py-3 px-5 w-52">DATE & HEURE</th>
                                    <th class="py-3 px-5 w-64">UTILISATEUR (IM)</th>
                                    <th class="py-3 px-5">ACTION RÉALISÉE</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                <?php if (!empty($logs)): ?>
                                    <?php foreach ($logs as $log): ?>
                                        <?php 
                                            $dateTime = $log['DATEACTION'] ?? '';
                                            $datePart = date('d/m/Y', strtotime($dateTime));
                                            $timePart = date('H:i:s', strtotime($dateTime));
                                        ?>
                                        <tr class="hover:bg-gray-50/80 transition">
                                            <!-- ID Log -->
                                            <td class="py-3 px-5 font-mono text-xs font-bold text-emerald-700 whitespace-nowrap">
                                                #<?= esc($log['IDLOG']) ?>
                                            </td>
                                            
                                            <!-- Date & Heure -->
                                            <td class="py-3 px-5 whitespace-nowrap">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-gray-600 text-xs font-medium"><?= $datePart ?></span>
                                                    <span class="px-2 py-0.5 bg-blue-50 text-blue-600 border border-blue-200/60 rounded-md font-mono text-xs font-bold">
                                                        <?= $timePart ?>
                                                    </span>
                                                </div>
                                            </td>
                                            
                                            <!-- Utilisateur & IM -->
                                            <td class="py-3 px-5 whitespace-nowrap">
                                                <div class="font-bold text-gray-900 text-xs"><?= esc(($log['PRENOMS'] ?? '') . ' ' . ($log['NOM'] ?? 'Système')) ?></div>
                                                <div class="text-[11px] font-mono text-gray-400"><?= esc($log['IMMUTILISATEUR']) ?></div>
                                            </td>
                                            
                                            <!-- Action Réalisée -->
                                            <td class="py-3 px-5">
                                                <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-medium bg-emerald-50 text-emerald-800 border border-emerald-200 shadow-sm">
                                                    <?= esc($log['ACTION']) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="py-10 text-center text-gray-400 italic text-sm">
                                            Aucun journal d'activité enregistré pour cette période.
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