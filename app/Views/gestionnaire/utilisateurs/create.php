<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
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

        <!-- SIDEBAR GESTIONNAIRE CENTRAL HARMONISÉE -->
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

                <!-- Profil Gestionnaire Convivial -->
                <div class="p-4 m-4 bg-gray-50 rounded-xl border border-gray-100 flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                        <?= strtoupper(substr($prenoms ?? 'G', 0, 1)) ?>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-gray-900 truncate"><?= esc(($prenoms ?? '') . ' ' . ($nom ?? 'Gestionnaire')) ?></p>
                        <p class="text-[10px] font-mono text-gray-500">
                            <?php 
                                $gesImBrut = preg_replace('/\D/', '', $immutilisateur ?? '');
                                echo (strlen($gesImBrut) === 6) ? substr($gesImBrut, 0, 3) . ' ' . substr($gesImBrut, 3, 3) : esc($immutilisateur);
                            ?>
                        </p>
                    </div>
                </div>

                <!-- Navigation synchronisée -->
                <nav class="px-4 space-y-1 overflow-y-auto max-h-[calc(100vh-280px)] pb-4">
                    <?php $uri = service('uri'); ?>
                    
                    <a href="/gestionnaire/dashboard" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg <?= ($uri->getSegment(2) == 'dashboard' || !$uri->getSegment(2)) ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> text-sm font-medium transition">
                        <i class="fa-solid fa-chart-pie w-5 <?= ($uri->getSegment(2) == 'dashboard' || !$uri->getSegment(2)) ? 'text-white' : 'text-emerald-600' ?>"></i>
                        <span>Tableau de bord</span>
                    </a>

                    <a href="/gestionnaire/centres" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg <?= ($uri->getSegment(2) == 'centres') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> text-sm font-medium transition">
                        <i class="fa-solid fa-building-columns w-5 <?= ($uri->getSegment(2) == 'centres') ? 'text-white' : 'text-emerald-600' ?>"></i>
                        <span>Centres régionaux</span>
                    </a>

                    <a href="/gestionnaire/formateurs" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg <?= ($uri->getSegment(2) == 'formateurs') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> text-sm font-medium transition">
                        <i class="fa-solid fa-chalkboard-user w-5 <?= ($uri->getSegment(2) == 'formateurs') ? 'text-white' : 'text-emerald-600' ?>"></i>
                        <span>Formateurs</span>
                    </a>

                    <a href="/gestionnaire/utilisateurs" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg <?= ($uri->getSegment(2) == 'utilisateurs') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> text-sm font-medium transition">
                        <i class="fa-solid fa-users-gear w-5 <?= ($uri->getSegment(2) == 'utilisateurs') ? 'text-white' : 'text-emerald-600' ?>"></i>
                        <span>Comptes Centres</span>
                    </a>

                    <a href="/gestionnaire/profile" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg <?= ($uri->getSegment(2) == 'profile') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> text-sm font-medium transition">
                        <i class="fa-solid fa-user-gear w-5 <?= ($uri->getSegment(2) == 'profile') ? 'text-white' : 'text-emerald-600' ?>"></i>
                        <span>Mon Profil</span>
                    </a>
                </nav>
            </div>

            <!-- Déconnexion -->
            <div class="p-4 border-t border-gray-100 shrink-0">
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
                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">CRÉATION DE COMPTE — GESTIONNAIRE DE CENTRE</span>
                </div>
                <div class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                    <i class="fa-regular fa-calendar-days mr-1.5 text-gray-400"></i> <?= date('d / m / Y') ?>
                </div>
            </header>

            <!-- Contenu du formulaire -->
            <div class="p-8 max-w-4xl mx-auto w-full space-y-6">
                
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Créer un nouveau compte utilisateur</h2>
                    <p class="text-sm text-gray-500 mt-1">Attribution d'un accès de gestionnaire pour un centre régional.</p>
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
                                <i class="fa-solid fa-user-plus"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-bold leading-tight">Gestionnaire de Centre Régional</h3>
                                <p class="text-xs text-emerald-100 font-mono">Matricule à 6 chiffres & Téléphone international</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-800/80 text-emerald-100 border border-emerald-600/50">
                            Création d'accès
                        </span>
                    </div>

                    <form action="/gestionnaire/utilisateurs/store" method="POST" class="p-6 space-y-5">
                        <?= csrf_field() ?>
                        
                        <!-- Profil et IM à 6 chiffres alignés -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-start">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Profil / Rôle</label>
                                <input type="text" value="Gestionnaire de Centre" disabled class="w-full h-11 px-4 rounded-xl border border-gray-200 bg-gray-100 text-sm font-semibold text-gray-700 cursor-not-allowed">
                                <input type="hidden" name="profil" value="GESTIONNAIRE_CENTRE">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Matricule (IM) — 6 chiffres</label>
                                <input type="text" id="im_input" name="IMMUTILISATEUR" value="<?= old('IMMUTILISATEUR') ?>" placeholder="ex : 123 456" maxlength="7" required oninput="formatIMInput(this)" class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm font-mono tracking-widest text-gray-800">
                                <p class="text-[11px] text-gray-400 mt-1">Exactement 6 chiffres (espace automatique).</p>
                            </div>
                        </div>

                        <!-- Nom et Prénoms -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nom *</label>
                                <input type="text" name="NOM" placeholder="Nom d'utilisateur" value="<?= old('NOM') ?>" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm font-medium">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Prénoms *</label>
                                <input type="text" name="PRENOMS" placeholder="Prénom(s) d'utilisateur" value="<?= old('PRENOMS') ?>" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm font-medium">
                            </div>
                        </div>

                        <!-- Centre de Rattachement (Obligatoire) -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Centre de rattachement *</label>
                            <select name="CODECENTRE" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white font-medium">
                                <option value="">-- Sélectionnez un centre régional --</option>
                                <?php foreach ($centres as $centre): ?>
                                    <option value="<?= esc($centre['CODECENTRE']) ?>"><?= esc($centre['NOMCENTRE']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Email et Téléphone International (+261) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Adresse Email *</label>
                                <input type="email" name="EMAIL" value="<?= old('EMAIL') ?>" placeholder="utilisateur@education.gov.mg" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm font-medium">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Numéro de Téléphone (+261)</label>
                                <div class="flex items-center w-full h-11 rounded-xl border border-gray-300 overflow-hidden focus-within:ring-2 focus-within:ring-emerald-500 focus-within:border-emerald-500 bg-white">
                                    <select id="operator_select" onchange="updatePhonePrefix()" class="h-full px-2 bg-gray-100 border-r border-gray-300 text-xs font-bold text-gray-700 focus:outline-none cursor-pointer">
                                        <option value="34">034 (Telma)</option>
                                        <option value="38">038 (Telma)</option>
                                        <option value="32">032 (Orange)</option>
                                        <option value="37">037 (Orange)</option>
                                        <option value="33">033 (Airtel)</option>
                                    </select>
                                    <input type="hidden" id="telephone_normalise" name="TELEPHONE" value="<?= old('TELEPHONE') ?>">
                                    <span id="phone_prefix_display" class="px-2.5 text-xs font-mono font-bold text-gray-600 bg-gray-50 h-full flex items-center border-r border-gray-300 select-none whitespace-nowrap">+261 34</span>
                                    <input type="text" id="phone_input" placeholder="XX XXX XX" maxlength="9" oninput="formatPhoneInput(this)" class="w-full h-full px-3 border-none focus:outline-none focus:ring-0 text-sm font-mono tracking-wider text-gray-800">
                                </div>
                                <p class="text-[11px] text-gray-400 mt-1">Format international malgache (+261 XX XX XXX XX).</p>
                            </div>
                        </div>

                        <!-- Note de sécurité -->
                        <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl flex items-center gap-2.5">
                            <i class="fa-solid fa-shield-halved text-emerald-600 text-base shrink-0"></i>
                            <span><strong>Sécurité :</strong> Un mot de passe provisoire (<code class="font-bold">12345678</code>) est attribué automatiquement à la création du compte.</span>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                            <a href="/gestionnaire/utilisateurs" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs rounded-xl transition flex items-center gap-2">
                                <i class="fa-solid fa-xmark"></i> Annuler
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm transition flex items-center gap-2">
                                <i class="fa-solid fa-user-check"></i> Créer le compte
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </main>

    </div>

    <!-- Scripts de formatage dynamique -->
    <script>
        function formatIMInput(input) {
            let chiffres = input.value.replace(/\D/g, '').substring(0, 6);
            if (chiffres.length > 3) {
                input.value = chiffres.substring(0, 3) + ' ' + chiffres.substring(3, 6);
            } else {
                input.value = chiffres;
            }
        }

        function updatePhonePrefix() {
            const op = document.getElementById('operator_select').value;
            document.getElementById('phone_prefix_display').textContent = '+261 ' + op;
            updateHiddenPhoneValue();
        }

        function formatPhoneInput(input) {
            let chiffres = input.value.replace(/\D/g, '').substring(0, 7);
            
            let formatted = '';
            if (chiffres.length > 0) {
                formatted += chiffres.substring(0, 2);
            }
            if (chiffres.length >= 3) {
                formatted += ' ' + chiffres.substring(2, 5);
            }
            if (chiffres.length >= 6) {
                formatted += ' ' + chiffres.substring(5, 7);
            }
            
            input.value = formatted;
            updateHiddenPhoneValue();
        }

        function updateHiddenPhoneValue() {
            const op = document.getElementById('operator_select').value;
            const phoneInputDigits = document.getElementById('phone_input').value.replace(/\D/g, '');
            const hiddenField = document.getElementById('telephone_normalise');
            
            if (phoneInputDigits.length === 7) {
                hiddenField.value = '+261' + op + phoneInputDigits;
            } else {
                hiddenField.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            updatePhonePrefix();
        });
    </script>

</body>
</html>