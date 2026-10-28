<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Séance - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
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
                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">ESPACE GESTIONNAIRE DE CENTRE</span>
                </div>
            </header>

            <div class="p-8 max-w-3xl mx-auto w-full space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Modifier la séance planifiée</h2>
                    <p class="text-sm text-gray-500 mt-1">Séance N° <span class="font-mono font-bold text-emerald-700"><?= esc($seance['NUMSEANCE']) ?></span></p>
                </div>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="p-3.5 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl flex items-center gap-2 shadow-sm">
                        <i class="fa-solid fa-circle-exclamation text-red-600 text-base"></i>
                        <span><?= session()->getFlashdata('error') ?></span>
                    </div>
                <?php endif; ?>

                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                    <div class="bg-emerald-700 px-6 py-4 text-white flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-white text-lg font-bold border border-white/20">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-bold leading-tight">Mise à jour de la Séance</h3>
                                <p class="text-xs text-emerald-100 font-mono">Modification des détails du cours</p>
                            </div>
                        </div>
                    </div>

                    <form action="/gestionnaire/seances/update/<?= esc($seance['NUMSEANCE']) ?>" method="POST" class="p-6 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Classe</label>
                                <select name="codeclasse" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white font-medium text-gray-800">
                                    <?php foreach ($classes as $classe): ?>
                                        <option value="<?= esc($classe['CODECLASSE']) ?>" <?= ($seance['CODECLASSE'] == $classe['CODECLASSE']) ? 'selected' : '' ?>>
                                            <?= esc($classe['NOMCLASSE'] ?? $classe['CODECLASSE']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Matière / Élément Constitutif (EC)</label>
                                <select name="codeec" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white font-medium text-gray-800">
                                    <?php foreach ($elemconsts as $ec): ?>
                                        <option value="<?= esc($ec['CODEEC']) ?>" <?= ($seance['CODEEC'] == $ec['CODEEC']) ? 'selected' : '' ?>>
                                            <?= esc($ec['NOMEC'] ?? $ec['CODEEC']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Formateur</label>
                            <select name="numcinform" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white font-medium text-gray-800">
                                <?php foreach ($formateurs as $formateur): ?>
                                    <option value="<?= esc($formateur['NUMCINFORM']) ?>" <?= ($seance['NUMCINFORM'] == $formateur['NUMCINFORM']) ? 'selected' : '' ?>>
                                        <?= esc(($formateur['NOMFORMATEUR'] ?? '') . ' ' . ($formateur['PRENOMFORMATEUR'] ?? '')) ?> (CIN: <?= esc($formateur['NUMCINFORM']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Date de la séance</label>
                                <input type="date" name="dateseance" value="<?= esc($seance['DATESEANCE']) ?>" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Heure de début</label>
                                <input type="time" name="heuredebut" value="<?= esc($seance['HEUREDEBUT']) ?>" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Heure de fin</label>
                                <input type="time" name="heurefin" value="<?= esc($seance['HEUREFIN']) ?>" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                            <a href="/gestionnaire/seances" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs rounded-xl transition flex items-center gap-2">
                                <i class="fa-solid fa-xmark"></i> Annuler
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm transition flex items-center gap-2">
                                <i class="fa-solid fa-floppy-disk"></i> Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>