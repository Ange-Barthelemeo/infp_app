<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un centre - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
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

                <!-- Profil Convivial -->
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
                    <a href="/gestionnaire/dashboard" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 text-sm font-medium transition">
                        <i class="fa-solid fa-chart-pie w-5"></i>
                        <span>Tableau de bord</span>
                    </a>
                    <a href="/centres" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg bg-emerald-600 text-white text-sm font-medium transition shadow-sm">
                        <i class="fa-solid fa-building-columns w-5"></i>
                        <span>Centres régionaux</span>
                    </a>
                    <a href="/formateurs" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 text-sm font-medium transition">
                        <i class="fa-solid fa-chalkboard-user w-5"></i>
                        <span>Formateurs</span>
                    </a>
                    <a href="/unites-enseignement" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 text-sm font-medium transition">
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
                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">SYSTÈME OPÉRATIONNEL — ENVIRONNEMENT SÉCURISÉ</span>
                </div>
                <div class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                    <i class="fa-regular fa-calendar-days mr-1.5 text-gray-400"></i> <?= date('d / m / Y') ?>
                </div>
            </header>

            <!-- Contenu du formulaire -->
            <div class="p-8 max-w-4xl mx-auto w-full space-y-6">
                
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Modifier le centre régional</h2>
                    <p class="text-sm text-gray-500 mt-1">Mise à jour des informations et des sections pédagogiques du centre <strong><?= esc($centre['CODECENTRE']) ?></strong>.</p>
                </div>

                <!-- Messages d'erreur -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="p-3.5 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl flex items-center gap-2 shadow-sm">
                        <i class="fa-solid fa-circle-exclamation text-red-600 text-base"></i>
                        <span><?= session()->getFlashdata('error') ?></span>
                    </div>
                <?php endif; ?>

                <!-- CARTE FORMULAIRE -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                    
                    <div class="bg-emerald-700 px-6 py-4 text-white flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-white text-lg font-bold border border-white/20">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-bold leading-tight">Centre : <?= esc($centre['CODECENTRE']) ?></h3>
                                <p class="text-xs text-emerald-100 font-mono">Modification des paramètres structurels</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-800/80 text-emerald-100 border border-emerald-600/50">
                            Édition
                        </span>
                    </div>

                    <form action="/centres/update/<?= esc($centre['CODECENTRE']) ?>" method="POST" class="p-6 space-y-5">
                        <?= csrf_field() ?>

                        <!-- Nom du Centre & Capacité d'accueil -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nom du Centre</label>
                                <input type="text" name="NOMCENTRE" value="<?= esc($centre['NOMCENTRE']) ?>" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Capacité d'accueil</label>
                                <input type="number" name="CAPACITEDACCUEIL" value="<?= esc($centre['CAPACITEDACCUEIL']) ?>" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                            </div>
                        </div>

                        <!-- Localisation -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Localisation / Ville</label>
                            <select name="LOCALISATION" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white font-medium text-gray-800">
                                <option value="">-- Sélectionnez une ville --</option>
                                <?php foreach (['Antananarivo','Fianarantsoa','Toamasina','Mahajanga','Toliara','Antsiranana','Ambatondrazaka','Antsirabe','Fénérive Est','Ihosy','Maintirano','Manakara','Maroantsetra','Morondava','Sambava'] as $loc): ?>
                                    <option value="<?= esc($loc) ?>" <?= ($centre['LOCALISATION'] == $loc) ? 'selected' : '' ?>><?= esc($loc) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Sections de formation dispensées -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Sections de formation proposées</label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <?php foreach ($sectionsDisponibles as $sec): ?>
                                    <label class="flex items-center space-x-3 p-3 rounded-xl bg-gray-50 border border-gray-200 cursor-pointer hover:bg-emerald-50 transition">
                                        <input type="checkbox" name="SECTIONS[]" value="<?= esc($sec['CODESECTION']) ?>" <?= in_array($sec['CODESECTION'], $codesSectionsAssociees) ? 'checked' : '' ?> class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                                        <span class="text-xs font-semibold text-gray-800"><?= esc($sec['CODESECTION']) ?> - <?= esc($sec['NOMSECTION']) ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                            <a href="/centres" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs rounded-xl transition flex items-center gap-2">
                                <i class="fa-solid fa-xmark"></i> Annuler
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm transition flex items-center gap-2">
                                <i class="fa-solid fa-floppy-disk"></i> Enregistrer les modifications
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </main>

    </div>

</body>
</html>