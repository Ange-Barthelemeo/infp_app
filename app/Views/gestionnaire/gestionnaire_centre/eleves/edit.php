<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Élève - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
    <script src="<?= base_url('assets/js/tailwind.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/all.min.css') ?>">
</head>
<body class="bg-gray-50 font-sans antialiased flex flex-col h-screen overflow-hidden">

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
                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">ESPACE GESTIONNAIRE DE CENTRE</span>
                </div>
            </header>

            <div class="p-8 max-w-4xl mx-auto w-full space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Modifier le dossier de l'élève</h2>
                    <p class="text-sm text-gray-500 mt-1">Matricule : <span class="font-mono font-bold text-emerald-700"><?= esc($eleve['MATRICULEELEVE']) ?></span></p>
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
                                <i class="fa-solid fa-user-pen"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-bold leading-tight">Mise à jour Dossier Élève</h3>
                                <p class="text-xs text-emerald-100 font-mono">Édition des informations et statuts</p>
                            </div>
                        </div>
                    </div>

                    <form action="/gestionnaire/eleves/update/<?= urlencode($eleve['MATRICULEELEVE']) ?>" method="POST" class="p-6 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Classe d'affectation</label>
                                <select name="codeclasse" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white font-medium text-gray-800">
                                    <?php foreach ($classes as $classe): ?>
                                        <option value="<?= esc($classe['CODECLASSE']) ?>" <?= ($eleve['CODECLASSE'] == $classe['CODECLASSE']) ? 'selected' : '' ?>>
                                            <?= esc($classe['NOMCLASSE'] ?? $classe['CODECLASSE']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">N° CIN / Pièce</label>
                                <input type="text" name="numcineleve" value="<?= esc($eleve['NUMCINELEVE']) ?>" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm font-mono">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nom</label>
                                <input type="text" name="nomeleve" value="<?= esc($eleve['NOMELEVE']) ?>" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Prénoms</label>
                                <input type="text" name="prenomeleve" value="<?= esc($eleve['PRENOMELEVE']) ?>" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Date de naissance</label>
                                <input type="date" name="datenaissance" max="<?= date('Y-m-d', strtotime('-18 years')) ?>" value="<?= old('datenaissance', $eleve['DATENAISSANCE'] ?? '') ?>" class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                                <p class="text-[11px] text-gray-400 mt-1">L'élève doit être âgé d'au moins 18 ans.</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Lieu de naissance</label>
                                <input type="text" name="lieunaissance" value="<?= esc($eleve['LIEUNAISSANCE']) ?>" class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Sexe</label>
                                <select name="sexe" class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white">
                                    <option value="M" <?= ($eleve['SEXE'] == 'M') ? 'selected' : '' ?>>Masculin</option>
                                    <option value="F" <?= ($eleve['SEXE'] == 'F') ? 'selected' : '' ?>>Féminin</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Statut Examen</label>
                                <select name="statutexamen" class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white">
                                    <option value="Autorisé" <?= ($eleve['STATUTEXAMEN'] == 'Autorisé') ? 'selected' : '' ?>>Autorisé</option>
                                    <option value="Disqualifié" <?= ($eleve['STATUTEXAMEN'] == 'Disqualifié') ? 'selected' : '' ?>>Disqualifié</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Statut Final</label>
                                <select name="statutfinal" class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white">
                                    <option value="En cours" <?= ($eleve['STATUTFINAL'] == 'En cours') ? 'selected' : '' ?>>En cours</option>
                                    <option value="Admis" <?= ($eleve['STATUTFINAL'] == 'Admis') ? 'selected' : '' ?>>Admis</option>
                                    <option value="Non Admis" <?= ($eleve['STATUTFINAL'] == 'Non Admis') ? 'selected' : '' ?>>Non Admis</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Statut Bachelier</label>
                                <div class="flex items-center h-11 gap-3">
                                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 cursor-pointer">
                                        <input type="checkbox" name="est_bachelier" value="1" <?= $eleve['EST_BACHELIER'] ? 'checked' : '' ?> class="w-4 h-4 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500"> Oui
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Adresse</label>
                                <input type="text" name="adresseeleve" value="<?= esc($eleve['ADRESSEELEVE']) ?>" class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Téléphone</label>
                                <input type="text" name="telephoneeleve" value="<?= esc($eleve['TELEPHONEELEVE']) ?>" class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                            <a href="/gestionnaire/eleves" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs rounded-xl transition flex items-center gap-2">
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