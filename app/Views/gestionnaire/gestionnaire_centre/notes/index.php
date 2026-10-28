<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Notes & Admis - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
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
                        <p class="text-sm text-gray-500 mt-1">Consultez, attribuez les notes aux élèves ou vérifiez la liste des admis.</p>
                    </div>
                    <a href="/gestionnaire/notes/create" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm transition flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Saisir une note
                    </a>
                </div>

                <!-- ONGLETS DE NAVIGATION -->
                <div class="flex border-b border-gray-200 gap-4 text-xs font-semibold">
                    <a href="/gestionnaire/notes" class="pb-3 border-b-2 border-emerald-600 text-emerald-700 flex items-center gap-2">
                        <i class="fa-solid fa-pen-to-square"></i> Saisie des Notes
                    </a>
                    <a href="/gestionnaire/notes/admis" class="pb-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700 flex items-center gap-2 transition">
                        <i class="fa-solid fa-user-check"></i> Liste des Admis & Non Admis
                    </a>
                </div>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="flash-message p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check"></i><span><?= session()->getFlashdata('success') ?></span></div>
                        <button onclick="this.closest('.flash-message').remove()" class="text-emerald-500"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                <?php endif; ?>

                <!-- Barre de Recherche et Filtres -->
                <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-sm">
                    <form id="filterForm" action="/gestionnaire/notes" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
                        <div class="relative md:col-span-7">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-gray-400 text-xs"></i>
                            <input type="text" id="searchInput" name="search" value="<?= esc($search ?? '') ?>" placeholder="Rechercher par élève ou matière..." class="w-full pl-9 pr-3 py-2 rounded-xl border border-gray-200 text-xs bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30">
                        </div>
                        <div class="md:col-span-4">
                            <select name="classe" onchange="this.form.submit()" class="w-full py-2 px-3 rounded-xl border border-gray-200 text-xs bg-gray-50/50 focus:bg-white focus:outline-none">
                                <option value="">Toutes les classes</option>
                                <?php foreach ($classes as $c): ?>
                                    <option value="<?= esc($c['CODECLASSE']) ?>" <?= ($filtreClasse == $c['CODECLASSE']) ? 'selected' : '' ?>><?= esc($c['NOMCLASSE']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="md:col-span-1 flex justify-end">
                            <a href="/gestionnaire/notes" class="w-full h-9 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl transition flex items-center justify-center" title="Réinitialiser"><i class="fa-solid fa-rotate-right text-xs"></i></a>
                        </div>
                    </form>
                </div>

                <!-- Tableau -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900">Notes enregistrées</h3>
                        <span class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Total : <?= count($notes) ?></span>
                    </div>
                    <div class="w-full overflow-x-auto">
                        <table class="w-full text-left border-collapse table-auto">
                            <thead>
                                <tr class="bg-gray-50/50 text-[11px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                    <th class="py-3.5 px-4">Matricule</th>
                                    <th class="py-3.5 px-4">Élève</th>
                                    <th class="py-3.5 px-4">Classe</th>
                                    <th class="py-3.5 px-4">Matière (EC)</th>
                                    <th class="py-3.5 px-4">Note / 20</th>
                                    <th class="py-3.5 px-4">Statut Final</th>
                                    <th class="py-3.5 px-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-xs">
                                <?php if (!empty($notes)): ?>
                                    <?php foreach ($notes as $u): ?>
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="py-4 px-4 font-mono font-semibold text-emerald-700"><?= esc($u['MATRICULEELEVE']) ?></td>
                                            <td class="py-4 px-4 font-bold text-gray-900"><?= esc($u['NOMELEVE'] . ' ' . $u['PRENOMELEVE']) ?></td>
                                            <td class="py-4 px-4 text-gray-700"><?= esc($u['NOMCLASSE']) ?></td>
                                            <td class="py-4 px-4 text-gray-700 font-medium"><?= esc($u['NOMEC']) ?></td>
                                            <td class="py-4 px-4 font-mono font-bold text-gray-900"><?= esc($u['VALEURNOTE']) ?> / 20</td>
                                            <td class="py-4 px-4">
                                                <span class="px-2 py-0.5 text-[10px] font-medium rounded-full <?= ($u['STATUTFINAL'] === 'Admis') ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-gray-100 text-gray-700' ?>">
                                                    <?= esc($u['STATUTFINAL']) ?>
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-center whitespace-nowrap">
                                                <a href="/gestionnaire/notes/edit/<?= urlencode($u['MATRICULEELEVE']) ?>/<?= urlencode($u['CODEEC']) ?>" class="px-2.5 h-7 text-[11px] font-semibold rounded-lg border border-blue-200 bg-blue-50/50 hover:bg-blue-100 text-blue-700 transition inline-flex items-center justify-center">Modifier</a>
                                                <a href="/gestionnaire/notes/delete/<?= urlencode($u['MATRICULEELEVE']) ?>/<?= urlencode($u['CODEEC']) ?>" onclick="return confirm('Supprimer cette note ?')" class="px-2.5 h-7 text-[11px] font-semibold rounded-lg border border-rose-200 bg-rose-50/50 hover:bg-rose-100 text-rose-700 transition inline-flex items-center justify-center ml-1"><i class="fa-solid fa-trash-can"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="7" class="py-12 text-center text-gray-400 text-sm italic">Aucune note trouvée.</td></tr>
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