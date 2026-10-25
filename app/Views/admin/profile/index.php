<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil Administrateur - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
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
                <!-- En-tête / Logo (Drapeau officiel) -->
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
                        <?= strtoupper(substr($admin['PRENOMS'] ?? 'A', 0, 1)) ?>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-gray-900 truncate"><?= esc(($admin['PRENOMS'] ?? '') . ' ' . ($admin['NOM'] ?? '')) ?></p>
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
                    <a href="/audit-logs" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 text-sm font-medium transition">
                        <i class="fa-solid fa-shield-halved w-5"></i>
                        <span>Journaux d'audit (Logs)</span>
                    </a>
                    <a href="/admin/profile" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg bg-emerald-600 text-white text-sm font-medium transition shadow-sm">
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
            
            <!-- Topbar Identique -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
                <div class="flex items-center space-x-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">SYSTÈME OPÉRATIONNEL — ENVIRONNEMENT SÉCURISÉ</span>
                </div>
                <div class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                    <i class="fa-regular fa-calendar-days mr-1.5 text-gray-400"></i> <?= date('d / m / Y') ?>
                </div>
            </header>

            <!-- Contenu aligné au même emplacement (p-8 et space-y-6 au lieu de flex-1 justify-center) -->
            <div class="p-8 max-w-4xl mx-auto w-full space-y-6">
                
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Mon Compte Administrateur</h2>
                    <p class="text-sm text-gray-500 mt-1">Gérez vos informations personnelles et sécurisez l'accès à votre compte technique.</p>
                </div>

                <!-- Messages Flash -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div id="flash-message" class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl flex items-center justify-between shadow-sm transition-opacity duration-500">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                            <span><?= session()->getFlashdata('success') ?></span>
                        </div>
                        <button onclick="dismissFlash()" class="text-emerald-500 hover:text-emerald-700"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div id="flash-message" class="p-3.5 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl flex items-center justify-between shadow-sm transition-opacity duration-500">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-circle-exclamation text-red-600 text-base"></i>
                            <span><?= session()->getFlashdata('error') ?></span>
                        </div>
                        <button onclick="dismissFlash()" class="text-red-500 hover:text-red-700"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                <?php endif; ?>

                <!-- Carte du Formulaire -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                    
                    <!-- Banner Visuel -->
                    <div class="h-22 bg-gradient-to-r from-emerald-700 via-emerald-600 to-teal-700 px-6 py-3 flex justify-between items-center relative">
                        <div class="flex items-center gap-3.5">
                            <div class="w-12 h-12 rounded-xl bg-white text-emerald-700 font-extrabold text-xl flex items-center justify-center shadow-md border border-white">
                                <?= strtoupper(substr($admin['PRENOMS'] ?? 'A', 0, 1)) ?>
                            </div>
                            <div class="text-white">
                                <h3 class="text-base font-bold leading-tight"><?= esc(($admin['PRENOMS'] ?? '') . ' ' . ($admin['NOM'] ?? '')) ?></h3>
                                <p class="text-xs text-emerald-100 font-mono mt-0.5"><i class="fa-solid fa-key mr-1"></i> <?= esc($immutilisateur) ?></p>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-800/60 text-white backdrop-blur-md border border-emerald-400/30">
                            <i class="fa-solid fa-shield-check mr-1 text-emerald-300"></i> Compte Racine
                        </span>
                    </div>

                    <form action="/admin/profile/update" method="POST" class="p-6 space-y-4">
                        
                        <!-- 1. Matricule -->
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Matricule (IMMUTILISATEUR)</label>
                            <input type="text" value="<?= esc($admin['IMMUTILISATEUR'] ?? '') ?>" disabled class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-100 text-gray-600 font-mono text-sm cursor-not-allowed">
                        </div>

                        <!-- 2. Nom et Prénoms -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nom</label>
                                <input type="text" name="nom" value="<?= esc($admin['NOM'] ?? '') ?>" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm font-medium text-gray-900">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Prénoms</label>
                                <input type="text" name="prenoms" value="<?= esc($admin['PRENOMS'] ?? '') ?>" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm font-medium text-gray-900">
                            </div>
                        </div>

                        <!-- 3. Email -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Adresse Email</label>
                            <input type="email" name="email" value="<?= esc($admin['EMAIL'] ?? '') ?>" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm font-medium text-gray-900">
                        </div>

                        <hr class="border-gray-100 my-2">

                        <!-- Sécurité Mot de passe -->
                        <div>
                            <h4 class="text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-key"></i> Sécurité — Modification du Mot de Passe <span class="text-gray-400 font-normal lowercase text-[11px]">(laisser vide pour ne pas modifier)</span>
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <!-- Ancien Mot de passe -->
                                <div>
                                    <label class="block text-[11px] font-semibold text-gray-600 uppercase tracking-wider mb-1">Ancien mot de passe</label>
                                    <div class="relative">
                                        <input type="password" id="ancien_password" name="ancien_motdepasse" placeholder="Actuel" class="w-full pl-3.5 pr-9 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                                        <button type="button" onclick="togglePassword('ancien_password', 'icon_ancien')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                            <i id="icon_ancien" class="fa-solid fa-eye text-xs"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Nouveau Mot de passe -->
                                <div>
                                    <label class="block text-[11px] font-semibold text-gray-600 uppercase tracking-wider mb-1">Nouveau mot de passe</label>
                                    <div class="relative">
                                        <input type="password" id="nouveau_password" name="nouveau_motdepasse" placeholder="Min. 8 caractères" class="w-full pl-3.5 pr-9 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                                        <button type="button" onclick="togglePassword('nouveau_password', 'icon_nouveau')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                            <i id="icon_nouveau" class="fa-solid fa-eye text-xs"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Confirmation -->
                                <div>
                                    <label class="block text-[11px] font-semibold text-gray-600 uppercase tracking-wider mb-1">Confirmer</label>
                                    <div class="relative">
                                        <input type="password" id="confirm_password" name="confirm_motdepasse" placeholder="Répéter" class="w-full pl-3.5 pr-9 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                                        <button type="button" onclick="togglePassword('confirm_password', 'icon_confirm')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                            <i id="icon_confirm" class="fa-solid fa-eye text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end space-x-3 pt-3 border-t border-gray-100">
                            <a href="/dashboard" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs rounded-xl transition flex items-center gap-2">
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

    <!-- Scripts -->
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        function dismissFlash() {
            const msg = document.getElementById('flash-message');
            if (msg) {
                msg.style.opacity = '0';
                setTimeout(() => msg.remove(), 500);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const msg = document.getElementById('flash-message');
            if (msg) {
                setTimeout(() => { dismissFlash(); }, 5000);
            }
        });
    </script>

</body>
</html>