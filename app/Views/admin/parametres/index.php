<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres Système - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
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
                        <p class="text-[11px] text-gray-500"><?= esc(get_setting('app_subtitle', 'Administration Technique')) ?></p>
                    </div>
                </div>

                <!-- Profil Admin -->
                <div class="p-4 m-4 bg-gray-50 rounded-xl border border-gray-100 flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                        <?= strtoupper(substr($prenoms ?? 'A', 0, 1)) ?>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-gray-900 truncate"><?= esc(($prenoms ?? '') . ' ' . ($nom ?? 'Administrateur')) ?></p>
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
                    <a href="/admin/profile" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 text-sm font-medium transition">
                        <i class="fa-solid fa-user-gear w-5"></i>
                        <span>Mon Profil Admin</span>
                    </a>
                    <a href="/parametres" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg bg-emerald-600 text-white text-sm font-medium transition shadow-sm">
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

            <!-- Contenu de la page -->
            <div class="p-8 max-w-5xl mx-auto w-full space-y-6">
                
                <!-- Titre & Description -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Paramètres système</h2>
                    <p class="text-sm text-gray-500 mt-1">Configuration générale, règles de sécurité et services de messagerie de la plateforme.</p>
                </div>

                <!-- Message de succès -->
                <?php if (session()->has('success')): ?>
                    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                        <?= session()->get('success') ?>
                    </div>
                <?php endif; ?>

                <!-- FORMULAIRE DES PARAMÈTRES -->
                <form action="/parametres/update" method="POST" class="space-y-6">
                    <?= csrf_field() ?>

                    <!-- BLOC 1 : INFORMATIONS GÉNÉRALES -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                                <i class="fa-solid fa-globe"></i>
                            </div>
                            <h3 class="text-base font-bold text-gray-900">Informations générales de la plateforme</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nom de la plateforme</label>
                                    <input type="text" name="app_name" value="<?= esc($settings['app_name'] ?? '') ?>" class="w-full h-10 px-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs bg-gray-50 font-medium text-gray-800" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Sous-titre / Description</label>
                                    <input type="text" name="app_subtitle" value="<?= esc($settings['app_subtitle'] ?? '') ?>" class="w-full h-10 px-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs bg-gray-50 font-medium text-gray-800" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BLOC 2 : SÉCURITÉ ET CONTRÔLE D'ACCÈS -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-sm">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <h3 class="text-base font-bold text-gray-900">Sécurité et contrôle d'accès</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Longueur minimale du mot de passe</label>
                                    <input type="number" name="pwd_min_length" min="8" max="20" value="<?= esc($settings['pwd_min_length'] ?? '8') ?>" class="w-full h-10 px-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs bg-gray-50 font-medium text-gray-800" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tentatives de connexion max avant blocage</label>
                                    <input type="number" name="max_login_attempts" min="3" max="10" value="<?= esc($settings['max_login_attempts'] ?? '5') ?>" class="w-full h-10 px-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs bg-gray-50 font-medium text-gray-800" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BLOC 3 : CONFIGURATION DES E-MAILS (SMTP) -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-sm">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <h3 class="text-base font-bold text-gray-900">Configuration de l'envoi des e-mails (SMTP)</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Serveur Hôte SMTP</label>
                                    <input type="text" name="smtp_host" value="<?= esc($settings['smtp_host'] ?? '') ?>" class="w-full h-10 px-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs bg-gray-50 font-medium text-gray-800" placeholder="ex: smtp.gmail.com">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Port SMTP</label>
                                    <input type="text" name="smtp_port" value="<?= esc($settings['smtp_port'] ?? '') ?>" class="w-full h-10 px-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs bg-gray-50 font-medium text-gray-800" placeholder="ex: 587">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Adresse e-mail expéditrice</label>
                                    <input type="email" name="smtp_user" value="<?= esc($settings['smtp_user'] ?? '') ?>" class="w-full h-10 px-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs bg-gray-50 font-medium text-gray-800" placeholder="ex: noreply@infp.mg">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Mot de passe / Clé d'application</label>
                                    <input type="password" name="smtp_pass" value="<?= esc($settings['smtp_pass'] ?? '') ?>" class="w-full h-10 px-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs bg-gray-50 font-medium text-gray-800" placeholder="Laisser vide pour ne pas modifier">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BLOC 4 : MAINTENANCE DU SYSTÈME -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center text-sm">
                                <i class="fa-solid fa-power-off"></i>
                            </div>
                            <h3 class="text-base font-bold text-gray-900">Mode Maintenance</h3>
                        </div>
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-gray-900">Activer le mode maintenance</p>
                                <p class="text-[11px] text-gray-500 mt-0.5">Bloque l'accès à la plateforme pour les utilisateurs non-administrateurs.</p>
                            </div>
                            <div>
                                <select name="maintenance_mode" class="h-10 px-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-xs bg-gray-50 font-bold text-gray-800">
                                    <option value="0" <?= (($settings['maintenance_mode'] ?? '0') == '0') ? 'selected' : '' ?>>Inactif (Normal)</option>
                                    <option value="1" <?= (($settings['maintenance_mode'] ?? '0') == '1') ? 'selected' : '' ?>>Actif (En maintenance)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- BOUTON DE SAUVEGARDE -->
                    <div class="flex justify-end pt-2 pb-12">
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-sm transition flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Enregistrer les modifications
                        </button>
                    </div>

                </form>

            </div>
        </main>

    </div>

</body>
</html>