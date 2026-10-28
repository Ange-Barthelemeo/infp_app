<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisir une Note - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
    <script src="<?= base_url('assets/js/tailwind.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/all.min.css') ?>">
</head>
<body class="bg-gray-50 font-sans antialiased flex flex-col h-screen overflow-hidden">
    <div class="h-1.5 w-full flex shrink-0"><div class="w-1/3 bg-red-600"></div><div class="w-1/3 bg-white"></div><div class="w-1/3 bg-emerald-600"></div></div>
    <div class="flex flex-1 overflow-hidden">
        <?= view('gestionnaire/sidebar', ['user' => ['NOM' => $nom ?? '', 'PRENOMS' => $prenoms ?? ''], 'immutilisateur' => $immutilisateur]) ?>
        <main class="flex-1 flex flex-col h-full overflow-y-auto bg-gray-50/50">
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
                <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">ESPACE GESTIONNAIRE DE CENTRE</span>
            </header>
            <div class="p-8 max-w-3xl mx-auto w-full space-y-6">
                <h2 class="text-2xl font-bold text-gray-900">Attribuer une note</h2>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="p-3.5 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <form action="/gestionnaire/notes/store" method="POST" class="p-6 space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1.5">Élève</label>
                            <select name="matriculeeleve" required class="w-full h-11 px-4 rounded-xl border border-gray-300 text-sm bg-white">
                                <option value="">Sélectionner un élève</option>
                                <?php foreach ($eleves as $e): ?>
                                    <option value="<?= esc($e['MATRICULEELEVE']) ?>"><?= esc($e['NOMELEVE'] . ' ' . $e['PRENOMELEVE'] . ' (' . $e['MATRICULEELEVE'] . ')') ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1.5">Matière / EC</label>
                            <select name="codeec" required class="w-full h-11 px-4 rounded-xl border border-gray-300 text-sm bg-white">
                                <option value="">Sélectionner une matière</option>
                                <?php foreach ($elemconsts as $ec): ?>
                                    <option value="<?= esc($ec['CODEEC']) ?>"><?= esc($ec['NOMEC'] . ' (' . $ec['CODEEC'] . ')') ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1.5">Note (/20)</label>
                            <input type="number" step="0.01" min="0" max="20" name="valeurnote" placeholder="ex : 14.5" required class="w-full h-11 px-4 rounded-xl border border-gray-300 text-sm">
                        </div>
                        <div class="flex justify-end space-x-3 pt-4 border-t">
                            <a href="/gestionnaire/notes" class="px-5 py-2.5 bg-gray-100 text-gray-700 text-xs rounded-xl">Annuler</a>
                            <button type="submit" class="px-6 py-2.5 bg-emerald-600 text-white text-xs rounded-xl shadow-sm">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>