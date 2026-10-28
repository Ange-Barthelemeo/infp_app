<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un utilisateur - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
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

                <!-- Profil Admin Convivial -->
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
                    <a href="/utilisateurs" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg bg-emerald-600 text-white text-sm font-medium transition shadow-sm">
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
                    <h2 class="text-2xl font-bold text-gray-900">Modifier l'utilisateur</h2>
                    <p class="text-sm text-gray-500 mt-1">Mise à jour de l'identité et du rattachement administratif de l'agent.</p>
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
                    
                    <!-- Bandeau Vert de Carte -->
                    <div class="bg-emerald-700 px-6 py-4 text-white flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-white text-lg font-bold border border-white/20">
                                <i class="fa-solid fa-user-pen"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-bold leading-tight"><?= esc(($userToEdit['PRENOMS'] ?? '') . ' ' . ($userToEdit['NOM'] ?? '')) ?></h3>
                                <p class="text-xs text-emerald-100 font-mono">IM : <?= esc($userToEdit['IMMUTILISATEUR']) ?></p>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-800/60 text-emerald-100 border border-emerald-600/50">
                            Fiche Agent
                        </span>
                    </div>

                    <form action="/utilisateurs/update/<?= urlencode($userToEdit['IMMUTILISATEUR']) ?>" method="POST" class="p-6 space-y-5">
                        
                        <!-- Profil et IM Verrouillés -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-start">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Profil / Rôle (Fixe)</label>
                                <input type="text" value="<?= esc($userToEdit['PROFIL']) ?>" disabled class="w-full h-11 px-4 rounded-xl border border-gray-200 bg-gray-100 text-gray-600 font-medium text-sm cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Matricule IM (Fixe)</label>
                                <input type="text" value="<?= esc($userToEdit['IMMUTILISATEUR']) ?>" disabled class="w-full h-11 px-4 rounded-xl border border-gray-200 bg-gray-100 text-gray-600 font-mono text-sm cursor-not-allowed">
                            </div>
                        </div>

                        <!-- Nom et Prénoms (Modifiables) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nom</label>
                                <input type="text" name="nom" value="<?= esc($userToEdit['NOM'] ?? '') ?>" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Prénoms</label>
                                <input type="text" name="prenoms" value="<?= esc($userToEdit['PRENOMS'] ?? '') ?>" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                            </div>
                        </div>

                        <!-- Rattachement Modifiable selon le Profil de l'agent -->
                        <?php if ($userToEdit['PROFIL'] === 'GESTIONNAIRE_CENTRAL'): ?>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Direction de rattachement</label>
                                <select name="codedirection" class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white">
                                    <option value="">-- Sélectionnez une direction --</option>
                                    <?php foreach ($directions as $dir): ?>
                                        <option value="<?= esc($dir['CODEDIRECTION']) ?>" <?= ($userToEdit['CODEDIRECTION'] == $dir['CODEDIRECTION']) ? 'selected' : '' ?>><?= esc($dir['NOMDIRECTION']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php else: ?>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Centre de rattachement</label>
                                <select name="codecentre" class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white">
                                    <option value="">-- Sélectionnez un centre --</option>
                                    <?php foreach ($centres as $centre): ?>
                                        <option value="<?= esc($centre['CODECENTRE']) ?>" <?= ($userToEdit['CODECENTRE'] == $centre['CODECENTRE']) ? 'selected' : '' ?>><?= esc($centre['NOMCENTRE']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>

                        <!-- Email (Modifiable avec vérification d'unicité) -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Adresse Email</label>
                            <input type="email" name="email" value="<?= esc($userToEdit['EMAIL'] ?? '') ?>" required class="w-full h-11 px-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>

                        <!-- Note de sécurité harmonisée -->
                        <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl flex items-center gap-2.5">
                            <i class="fa-solid fa-shield-halved text-emerald-600 text-base shrink-0"></i>
                            <span><strong>Intégrité :</strong> L'adresse e-mail doit rester unique pour chaque agent afin de garantir la sécurité des accès.</span>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                            <a href="/utilisateurs" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs rounded-xl transition flex items-center gap-2">
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