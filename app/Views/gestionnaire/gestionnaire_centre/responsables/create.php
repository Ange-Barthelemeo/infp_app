<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un responsable - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
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
                <div class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                    <i class="fa-regular fa-calendar-days mr-1.5 text-gray-400"></i> <?= date('d / m / Y') ?>
                </div>
            </header>

            <!-- Contenu du formulaire -->
            <div class="p-8 max-w-4xl mx-auto w-full space-y-6">
                
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Créer un compte Responsable de Centre</h2>
                    <p class="text-sm text-gray-500 mt-1">Enregistrement d'un nouveau responsable pour le centre : <strong><?= esc($centre['NOMCENTRE'] ?? '') ?></strong></p>
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
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-bold leading-tight">Nouveau Responsable</h3>
                                <p class="text-xs text-emerald-100 font-mono">Mot de passe par défaut : 1234</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-800/80 text-emerald-100 border border-emerald-600/50">
                            Suffixe IM : -R
                        </span>
                    </div>

                    <form action="/gestionnaire/responsables/store" method="POST" class="p-6 space-y-5">
                        
                        <!-- Matricule (IM) Généré avec suffixe -R fixe -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Matricule (IM)</label>
                            <div class="flex items-center w-full h-11 rounded-xl border border-gray-300 overflow-hidden focus-within:ring-2 focus-within:ring-emerald-500 focus-within:border-emerald-500">
                                <input type="text" id="im_input" name="immutilisateur" value="<?= old('immutilisateur') ?>" placeholder="ex : 123456" maxlength="7" required oninput="formatIMInput(this)" class="w-full h-full px-4 border-none focus:outline-none focus:ring-0 text-sm font-mono tracking-wider text-gray-800">
                                <span class="h-full px-4 bg-gray-100 border-l border-gray-300 text-sm font-mono font-bold text-emerald-700 flex items-center justify-center shrink-0 min-w-[45px] select-none">-R</span>
                            </div>
                            <p class="text-[11px] text-gray-400 mt-1">Tapez 6 chiffres (l'espace et le suffixe -R sont gérés automatiquement).</p>
                        </div>

                        <!-- Nom et Prénoms -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nom</label>
                                <input type="text" name="nom" placeholder="Nom du responsable" value="<?= old('nom') ?>" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Prénoms</label>
                                <input type="text" name="prenoms" placeholder="Prénoms du responsable" value="<?= old('prenoms') ?>" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Adresse Email</label>
                            <input type="email" name="email" placeholder="email@exemple.mg" value="<?= old('email') ?>" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>

                        <!-- Centre d'affectation (Fixe et affiché) -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Centre d'affectation</label>
                            <input type="text" value="<?= esc($centre['NOMCENTRE'] ?? '') ?>" disabled class="w-full h-11 px-4 rounded-xl border border-gray-200 bg-gray-100 text-gray-600 text-sm font-semibold cursor-not-allowed">
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                            <a href="/gestionnaire/responsables" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs rounded-xl transition flex items-center gap-2">
                                <i class="fa-solid fa-xmark"></i> Annuler
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm transition flex items-center gap-2">
                                <i class="fa-solid fa-floppy-disk"></i> Enregistrer le responsable
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </main>
    </div>

    <!-- Script de formatage automatique du Matricule (IM) -->
    <script>
        function formatIMInput(input) {
            let val = input.value.replace(/\D/g, ''); // Garder uniquement les chiffres
            if (val.length > 6) {
                val = val.slice(0, 6);
            }
            // Format automatique 3 chiffres + espace + 3 chiffres
            if (val.length > 3) {
                input.value = val.slice(0, 3) + ' ' + val.slice(3);
            } else {
                input.value = val;
            }
        }
    </script>
</body>
</html>