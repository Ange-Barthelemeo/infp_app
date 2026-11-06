<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Formateur - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
    <script src="<?= base_url('assets/js/tailwind.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/all.min.css') ?>">
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
        
        <!-- SIDEBAR GESTIONNAIRE CENTRAL -->
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
                        <p class="text-[11px] text-gray-500">Gestion Centrale</p>
                    </div>
                </div>

                <div class="p-4 m-4 bg-gray-50 rounded-xl border border-gray-100 flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                        <?= strtoupper(substr($prenoms ?? 'G', 0, 1)) ?>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-gray-900 truncate"><?= esc(($prenoms ?? '') . ' ' . ($nom ?? 'Gestionnaire')) ?></p>
                        <p class="text-[10px] font-mono text-gray-500"><?= esc($immutilisateur) ?></p>
                    </div>
                </div>

                <!-- Navigation unifiée et synchronisée pour le Gestionnaire Central -->
                <nav class="px-4 space-y-1 overflow-y-auto max-h-[calc(100vh-280px)] pb-4">
                    <?php $uri = service('uri'); ?>
                    
                    <!-- Tableau de bord -->
                    <a href="/central/dashboard" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg <?= ($uri->getSegment(2) == 'dashboard' || !$uri->getSegment(2)) ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> text-sm font-medium transition">
                        <i class="fa-solid fa-chart-pie w-5 <?= ($uri->getSegment(2) == 'dashboard' || !$uri->getSegment(2)) ? 'text-white' : 'text-emerald-600' ?>"></i>
                        <span>Tableau de bord</span>
                    </a>

                    <!-- Centres régionaux -->
                    <a href="/central/centres" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg <?= ($uri->getSegment(2) == 'centres') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> text-sm font-medium transition">
                        <i class="fa-solid fa-building-columns w-5 <?= ($uri->getSegment(2) == 'centres') ? 'text-white' : 'text-emerald-600' ?>"></i>
                        <span>Centres régionaux</span>
                    </a>

                    <!-- Formateurs -->
                    <a href="/central/formateurs" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg <?= ($uri->getSegment(2) == 'formateurs') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> text-sm font-medium transition">
                        <i class="fa-solid fa-chalkboard-user w-5 <?= ($uri->getSegment(2) == 'formateurs') ? 'text-white' : 'text-emerald-600' ?>"></i>
                        <span>Formateurs</span>
                    </a>

                    <!-- Comptes Gestionnaires de Centre -->
                    <a href="/central/utilisateurs" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg <?= ($uri->getSegment(2) == 'utilisateurs') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> text-sm font-medium transition">
                        <i class="fa-solid fa-users-gear w-5 <?= ($uri->getSegment(2) == 'utilisateurs') ? 'text-white' : 'text-emerald-600' ?>"></i>
                        <span>Comptes Centres</span>
                    </a>

                    <!-- Mon Profil -->
                    <a href="/central/profile" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg <?= ($uri->getSegment(2) == 'profile') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> text-sm font-medium transition">
                        <i class="fa-solid fa-user-gear w-5 <?= ($uri->getSegment(2) == 'profile') ? 'text-white' : 'text-emerald-600' ?>"></i>
                        <span>Mon Profil</span>
                    </a>
                </nav>
            <div class="p-4 border-t border-gray-100">
                <a href="/logout" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-red-600 hover:bg-red-50 text-sm font-medium transition">
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
                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">SYSTÈME OPÉRATIONNEL — ESPACE GESTIONNAIRE CENTRAL</span>
                </div>
                <div class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                    <i class="fa-regular fa-calendar-days mr-1.5 text-gray-400"></i> <?= date('d / m / Y') ?>
                </div>
            </header>

            <div class="p-8 max-w-5xl mx-auto w-full space-y-6">
                
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Enregistrement d'un Nouveau Formateur</h2>
                    <p class="text-sm text-gray-500 mt-1">Affectation à un centre régional actif et définition du statut contractuel.</p>
                </div>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="p-4 bg-red-50 border border-red-200 text-red-800 text-xs font-semibold rounded-xl flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation"></i> <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                    
                    <div class="bg-emerald-700 px-6 py-4 flex items-center justify-between text-white">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center text-white">
                                <i class="fa-solid fa-user-plus text-base"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold">Nouveau Formateur INFP</h3>
                                <p class="text-[11px] text-emerald-100">Contrôle d'unicité et formatage strict des champs</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-white/20 text-white rounded-lg text-xs font-semibold">
                            Affectation RH
                        </span>
                    </div>

                    <form action="/central/formateurs/store" method="POST" class="p-8 space-y-6">
                        <?= csrf_field() ?>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Numéro CIN (Strictement 12 chiffres max) -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Numéro CIN (12 chiffres) *</label>
                                <input type="text" name="NUMCINFORM" id="numCin" value="<?= old('NUMCINFORM') ?>" required maxlength="12" pattern="\d{12}" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 12);" placeholder="Ex: 101234567890" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none font-mono">
                                <p class="text-[10px] text-gray-400">Exactement 12 chiffres (le clavier se bloque automatiquement).</p>
                            </div>

                            <!-- Centre de rattachement -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Centre Régional d'Affectation *</label>
                                <select name="CODECENTRE" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none bg-white font-medium">
                                    <option value="">-- Sélectionnez un centre actif --</option>
                                    <?php foreach ($centres as $c): ?>
                                        <option value="<?= esc($c['CODECENTRE']) ?>" <?= old('CODECENTRE') == $c['CODECENTRE'] ? 'selected' : '' ?>>
                                            <?= esc($c['NOMCENTRE']) ?> (<?= esc($c['LOCALISATION']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="text-[10px] text-gray-400">Filtré sur les centres opérationnels (Statut Actif).</p>
                            </div>

                            <!-- Nom -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Nom *</label>
                                <input type="text" name="NOMFORMATEUR" value="<?= old('NOMFORMATEUR') ?>" required placeholder="Nom de famille" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            </div>

                            <!-- Prénoms -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Prénoms</label>
                                <input type="text" name="PRENOMFORMATEUR" value="<?= old('PRENOMFORMATEUR') ?>" placeholder="Prénoms du formateur" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            </div>

                            <!-- Numéro de téléphone formaté style Admin -->
                            <div class="space-y-1.5 md:col-span-2">
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Numéro de Téléphone (+261) *</label>
                                <div class="flex items-center rounded-xl border border-gray-200 overflow-hidden bg-white focus-within:ring-2 focus-within:ring-emerald-500">
                                    <!-- Sélecteur opérateur -->
                                    <select id="operatorSelect" onchange="updatePrefix()" class="bg-gray-50 border-r border-gray-200 px-3 py-2.5 text-xs font-semibold text-gray-700 focus:outline-none">
                                        <option value="34">034 (Telma)</option>
                                        <option value="33">033 (Airtel)</option>
                                        <option value="38">038 (Telma)</option>
                                        <option value="32">032 (Orange)</option>
                                        <option value="37">037 (Orange)</option>
                                    </select>
                                    <!-- Indicatif fixe -->
                                    <span id="prefixDisplay" class="px-3 text-xs font-mono font-bold text-gray-500 bg-gray-50/50 border-r border-gray-200 py-2.5">+261 34</span>
                                    <!-- Champ masqué pour la base de données -->
                                    <input type="hidden" name="CONTACTFORMATEUR" id="fullContact" value="<?= old('CONTACTFORMATEUR') ?>">
                                    <!-- Partie variable saisie par l'utilisateur : XX XXX XX -->
                                    <input type="text" id="phoneInput" maxlength="9" placeholder="XX XXX XX" oninput="formatPhone(this)" class="flex-1 px-4 py-2.5 text-xs font-mono focus:outline-none">
                                </div>
                                <p class="text-[10px] text-gray-400">Format international malgache (+261 XX XX XXX XX).</p>
                            </div>

                            <!-- Statut du formateur -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Statut Contractuel *</label>
                                <select name="TYPE_FORMATEUR" id="typeFormateur" required onchange="toggleImField()" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none bg-white font-medium">
                                    <option value="vacataire" <?= old('TYPE_FORMATEUR') == 'vacataire' ? 'selected' : '' ?>>Vacataire (Code auto-généré)</option>
                                    <option value="permanent" <?= old('TYPE_FORMATEUR') == 'permanent' ? 'selected' : '' ?>>Permanent (IM requis)</option>
                                </select>
                                <p class="text-[10px] text-gray-400">Détermine la gestion administrative et salariale.</p>
                            </div>

                            <!-- Champ IM formaté dynamiquement : XXX XXX -->
                            <div id="imContainer" class="hidden space-y-1.5">
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Numéro d'Immatriculation (IM - 6 chiffres) *</label>
                                <input type="text" name="IMMFORMATEUR" id="imInput" maxlength="7" value="<?= old('IMMFORMATEUR') ?>" oninput="formatIm(this)" placeholder="XXX XXX" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none font-mono tracking-widest">
                                <p class="text-[10px] text-emerald-600 font-medium">Exactement 6 chiffres (Format XXX XXX, s'arrête automatiquement).</p>
                            </div>

                        </div>

                        <!-- Adresse -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Adresse Résidentielle</label>
                            <input type="text" name="ADRESSEFORMATEUR" value="<?= old('ADRESSEFORMATEUR') ?>" placeholder="Adresse physique actuelle" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                            <a href="/gestionnaire/formateurs" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition">
                                <i class="fa-solid fa-xmark mr-1.5"></i> Annuler
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl transition shadow-sm flex items-center gap-2">
                                <i class="fa-solid fa-check"></i> Enregistrer le formateur
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </main>
    </div>

    <script>
        // Gestion de l'affichage du champ IM
        function toggleImField() {
            const typeSelect = document.getElementById('typeFormateur').value;
            const imContainer = document.getElementById('imContainer');
            const imInput = document.getElementById('imInput');
            if (typeSelect === 'permanent') {
                imContainer.classList.remove('hidden');
                imInput.setAttribute('required', 'required');
            } else {
                imContainer.classList.add('hidden');
                imInput.removeAttribute('required');
                imInput.value = '';
            }
        }

        // Formatage automatique IM : XXX XXX (S'arrête à 6 chiffres)
        function formatIm(input) {
            let value = input.value.replace(/\D/g, '').substring(0, 6);
            if (value.length > 3) {
                value = value.substring(0, 3) + ' ' + value.substring(3);
            }
            input.value = value;
        }

        // Mise à jour du préfixe opérateur téléphone
        function updatePrefix() {
            const op = document.getElementById('operatorSelect').value;
            document.getElementById('prefixDisplay').innerText = '+261 ' + op;
            updateFullContact();
        }

        // Formatage du téléphone et assemblage pour le champ caché
        function formatPhone(input) {
            let cleaned = input.value.replace(/\D/g, '').substring(0, 7); // Max 7 chiffres après l'indicatif (ex: 12 345 67 ou format 22 333 44)
            let formatted = '';
            if (cleaned.length > 0) {
                formatted = cleaned.substring(0, 2);
            }
            if (cleaned.length > 2) {
                formatted += ' ' + cleaned.substring(2, 5);
            }
            if (cleaned.length > 5) {
                formatted += ' ' + cleaned.substring(5, 7);
            }
            input.value = formatted;
            updateFullContact();
        }

        function updateFullContact() {
            const op = document.getElementById('operatorSelect').value;
            const phoneVal = document.getElementById('phoneInput').value;
            document.getElementById('fullContact').value = '+261 ' + op + ' ' + phoneVal;
        }

        window.onload = function() {
            toggleImField();
            updatePrefix();
        };
    </script>
</body>
</html>