<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des UE & EC - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
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

        <!-- SIDEBAR UNIFIÉE -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between shrink-0">
            <div>
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
                        <p class="text-[11px] text-gray-500">Administration Technique</p>
                    </div>
                </div>

                <div class="p-4 m-4 bg-gray-50 rounded-xl border border-gray-100 flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                        <?= strtoupper(substr($prenoms ?? 'A', 0, 1)) ?>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-gray-900 truncate"><?= esc(($prenoms ?? '') . ' ' . ($nom ?? 'Administrateur')) ?></p>
                        <p class="text-[10px] font-mono text-gray-500"><?= esc($immutilisateur ?? '') ?></p>
                    </div>
                </div>

                <nav class="px-4 space-y-1 overflow-y-auto max-h-[calc(100vh-280px)] pb-4">
                    <a href="/dashboard" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 text-sm font-medium transition">
                        <i class="fa-solid fa-chart-pie w-5"></i>
                        <span>Tableau de bord</span>
                    </a>
                    <a href="/utilisateurs" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 text-sm font-medium transition">
                        <i class="fa-solid fa-users-gear w-5"></i>
                        <span>Gestion des comptes</span>
                    </a>
                    <a href="/audit-logs" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 text-sm font-medium transition">
                        <i class="fa-solid fa-shield-halved w-5"></i>
                        <span>Journaux d'audit (Logs)</span>
                    </a>
                    <a href="/admin/referentiel" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg bg-emerald-600 text-white text-sm font-medium transition shadow-sm">
                        <i class="fa-solid fa-database w-5 text-white"></i>
                        <span>Référentiel & Métadonnées</span>
                    </a>
                    <a href="/admin/profile" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 text-sm font-medium transition">
                        <i class="fa-solid fa-user-gear w-5"></i>
                        <span>Mon Profil Admin</span>
                    </a>
                    <a href="/parametres" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 text-sm font-medium transition">
                        <i class="fa-solid fa-sliders w-5"></i>
                        <span>Paramètres système</span>
                    </a>
                </nav>
            </div>

            <div class="p-4 border-t border-gray-100 shrink-0">
                <a href="/logout" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-red-600 hover:bg-red-50 text-red-600 text-sm font-medium transition">
                    <i class="fa-solid fa-right-from-bracket w-5"></i>
                    <span>Déconnexion</span>
                </a>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col h-full overflow-y-auto bg-gray-50/50">
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
                <div class="flex items-center space-x-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">RÉFÉRENTIEL — UNITÉS D'ENSEIGNEMENT & EC</span>
                </div>
                <div class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                    <i class="fa-regular fa-calendar-days mr-1.5 text-gray-400"></i> <?= date('d / m / Y') ?>
                </div>
            </header>

            <div class="p-8 max-w-7xl mx-auto w-full space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Unités d'Enseignement & Éléments Constitutifs</h2>
                        <p class="text-sm text-gray-500 mt-1">Supervision unifiée de l'offre de formation, des UE et de leurs EC rattachés.</p>
                    </div>
                    <a href="/admin/referentiel" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs rounded-xl transition flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i> Retour au hub
                    </a>
                </div>

                <!-- Messages Flash -->
                <?php if (session()->has('success')): ?>
                    <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl flex items-center justify-between shadow-sm">
                        <span><?= session('success') ?></span>
                    </div>
                <?php endif; ?>

                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900">Arborescence des Unités d'Enseignement</h3>
                        <span class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            Total : <?= count($ues) ?> UE(s)
                        </span>
                    </div>
                    
                    <div class="w-full overflow-x-auto">
                        <table class="w-full text-left border-collapse table-auto">
                            <thead>
                                <tr class="bg-gray-50/50 text-[11px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                    <th class="py-3.5 px-4 w-12 text-center"></th>
                                    <th class="py-3.5 px-4 whitespace-nowrap align-middle">Code UE</th>
                                    <th class="py-3.5 px-4 align-middle">Libellé de l'UE</th>
                                    <th class="py-3.5 px-4 text-center align-middle">Coefficient Total</th>
                                    <th class="py-3.5 px-4 text-center align-middle">Éléments Constitutifs (EC)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-xs">
                                <?php if (!empty($ues)): ?>
                                    <?php foreach ($ues as $index => $ue): ?>
                                        <tr class="hover:bg-gray-50/50 transition cursor-pointer" onclick="toggleEcRow('ec-row-<?= $index ?>', this)">
                                            <td class="py-4 px-4 text-center text-gray-400">
                                                <i id="icon-<?= $index ?>" class="fa-solid fa-chevron-right transition-transform"></i>
                                            </td>
                                            <td class="py-4 px-4 font-mono font-semibold text-emerald-700 whitespace-nowrap align-middle">
                                                <?= esc($ue['CODEUE']) ?>
                                            </td>
                                            <td class="py-4 px-4 font-bold text-gray-900 align-middle">
                                                <?= esc($ue['LIBELLEUE']) ?>
                                            </td>
                                            <td class="py-4 px-4 text-center font-semibold text-gray-700 align-middle">
                                                <?= esc($ue['COEFFTOTAL']) ?>
                                            </td>
                                            <td class="py-4 px-4 text-center align-middle">
                                                <span class="px-2.5 py-1 text-[11px] font-semibold bg-emerald-50 text-emerald-700 rounded-full border border-emerald-200">
                                                    <?= count($ue['ecs']) ?> EC(s) rattaché(s)
                                                </span>
                                            </td>
                                        </tr>

                                        <!-- Ligne dépliable pour les EC de cette UE -->
                                        <tr id="ec-row-<?= $index ?>" class="hidden bg-gray-50/80">
                                            <td colspan="5" class="p-4 px-8">
                                                <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-2xs space-y-3">
                                                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                                                        <i class="fa-solid fa-list-ul text-emerald-600"></i> Éléments Constitutifs (EC) associés à l'UE : <?= esc($ue['CODEUE']) ?>
                                                    </h4>
                                                    <?php if (!empty($ue['ecs'])): ?>
                                                        <table class="w-full text-left border-collapse text-xs bg-gray-50/50 rounded-lg overflow-hidden">
                                                            <thead>
                                                                <tr class="text-[10px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-200 bg-gray-100/60">
                                                                    <th class="py-2.5 px-3">Code EC</th>
                                                                    <th class="py-2.5 px-3">Nom de l'EC</th>
                                                                    <th class="py-2.5 px-3 text-center">Volume Horaire</th>
                                                                    <th class="py-2.5 px-3 text-center">Coefficient</th>
                                                                    <th class="py-2.5 px-3">Sections concernées (Table Suivre)</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-gray-200">
                                                                <?php foreach ($ue['ecs'] as $ec): ?>
                                                                    <tr class="hover:bg-white">
                                                                        <td class="py-2.5 px-3 font-mono font-bold text-emerald-700"><?= esc($ec['CODEEC']) ?></td>
                                                                        <td class="py-2.5 px-3 font-semibold text-gray-900"><?= esc($ec['NOMEC']) ?></td>
                                                                        <td class="py-2.5 px-3 text-center text-gray-700"><?= esc($ec['VOLUMEHORAIRE']) ?> h</td>
                                                                        <td class="py-2.5 px-3 text-center font-semibold text-gray-700"><?= esc($ec['COEFF']) ?></td>
                                                                        <td class="py-2.5 px-3">
                                                                            <div class="flex flex-wrap gap-1">
                                                                                <?php if (!empty($ec['sections'])): ?>
                                                                                    <?php foreach ($ec['sections'] as $sec): ?>
                                                                                        <span class="px-2 py-0.5 text-[10px] font-bold bg-gray-200 text-gray-700 rounded border border-gray-300">
                                                                                            <?= esc($sec) ?>
                                                                                        </span>
                                                                                    <?php endforeach; ?>
                                                                                <?php else: ?>
                                                                                    <span class="text-gray-400 italic">Aucune section</span>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    <?php else: ?>
                                                        <p class="text-xs text-gray-400 italic py-2">Aucun Élément Constitutif (EC) n'est actuellement rattaché à cette UE.</p>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-gray-400 text-sm italic">
                                            Aucune Unité d'Enseignement enregistrée pour le moment.
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

    <!-- Script pour l'accordéon des EC -->
    <script>
        function toggleEcRow(rowId, trElement) {
            const row = document.getElementById(rowId);
            const index = rowId.split('-')[2];
            const icon = document.getElementById('icon-' + index);
            
            if (row.classList.contains('hidden')) {
                row.classList.remove('hidden');
                icon.classList.add('rotate-90');
                trElement.classList.add('bg-emerald-50/40');
            } else {
                row.classList.add('hidden');
                icon.classList.remove('rotate-90');
                trElement.classList.remove('bg-emerald-50/40');
            }
        }
    </script>
</body>
</html>