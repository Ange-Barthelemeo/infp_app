<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des centres - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
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

        <!-- SIDEBAR UNIFIÉE -->
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
                        <p class="text-[11px] text-gray-500">Administration Technique</p>
                    </div>
                </div>

                <!-- Profil Admin Convivial -->
                <div class="p-4 m-4 bg-gray-50 rounded-xl border border-gray-100 flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                        <?= strtoupper(substr($prenoms ?? 'A', 0, 1)) ?>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-gray-900 truncate"><?= esc(($prenoms ?? '') . ' ' . ($nom ?? 'Administrateur')) ?></p>
                        <p class="text-[10px] font-mono text-gray-500">
                            <?php 
                                $adminImBrut = preg_replace('/\D/', '', $immutilisateur ?? '');
                                echo (strlen($adminImBrut) === 6) ? substr($adminImBrut, 0, 3) . ' ' . substr($adminImBrut, 3, 3) : esc($immutilisateur);
                            ?>
                        </p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="px-4 space-y-1 overflow-y-auto max-h-[calc(100vh-280px)] pb-4">
                    <?php $uri = service('uri'); ?>
                    
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

                    <a href="/admin/referentiel" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg bg-emerald-600 text-white text-sm font-medium transition shadow-sm">
                        <i class="fa-solid fa-database w-5 text-white"></i>
                        <span>Référentiel & Métadonnées</span>
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
            <div class="p-4 border-t border-gray-100 shrink-0">
                <a href="/logout" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-red-600 hover:bg-red-50 text-red-600 text-sm font-medium transition">
                    <i class="fa-solid fa-right-from-bracket w-5"></i>
                    <span>Déconnexion</span>
                </a>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col h-full overflow-y-auto bg-gray-50/50">
            
            <!-- Topbar harmonisée -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
                <div class="flex items-center space-x-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">RÉFÉRENTIEL — GESTION DES CENTRES RÉGIONAUX</span>
                </div>
                <div class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                    <i class="fa-regular fa-calendar-days mr-1.5 text-gray-400"></i> <?= date('d / m / Y') ?>
                </div>
            </header>

            <!-- Contenu de la page -->
            <div class="p-8 max-w-7xl mx-auto w-full space-y-6">
                
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Paramétrage des centres & sections</h2>
                        <p class="text-sm text-gray-500 mt-1">Gestion des implantations territoriales de l'INFP, de leurs capacités et des sections habilitées.</p>
                    </div>
                    <a href="/admin/referentiel" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs rounded-xl transition flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i> Retour au hub
                    </a>
                </div>

                <!-- Messages Flash Temporaires -->
                <?php if (session()->has('success')): ?>
                    <div id="flash-message" class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl flex items-center justify-between shadow-sm transition-opacity duration-500">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                            <span><?= session('success') ?></span>
                        </div>
                        <button onclick="dismissFlash()" class="text-emerald-500 hover:text-emerald-700"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('error')): ?>
                    <div id="flash-error" class="p-3.5 bg-rose-50 border border-rose-200 text-rose-700 text-sm rounded-xl flex items-center justify-between shadow-sm transition-opacity duration-500">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-circle-exclamation text-rose-600 text-base"></i>
                            <span><?= session('error') ?></span>
                        </div>
                        <button onclick="document.getElementById('flash-error').remove()" class="text-rose-500 hover:text-rose-700"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                <?php endif; ?>

                <!-- Tableau des centres -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900">Implantations territoriales enregistrées</h3>
                        <span class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            Total : <?= count($centres) ?> centre(s)
                        </span>
                    </div>
                    
                    <div class="w-full overflow-x-auto">
                        <table class="w-full text-left border-collapse table-auto">
                            <thead>
                                <tr class="bg-gray-50/50 text-[11px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                    <th class="py-3.5 px-4 whitespace-nowrap align-middle">Code</th>
                                    <th class="py-3.5 px-4 align-middle">Nom du Centre</th>
                                    <th class="py-3.5 px-4 align-middle">Localisation</th>
                                    <th class="py-3.5 px-4 text-center align-middle">Capacité</th>
                                    <th class="py-3.5 px-4 align-middle">Sections Habilitées</th>
                                    <th class="py-3.5 px-4 align-middle">Statut</th>
                                    <th class="py-3.5 px-4 text-center align-middle">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-xs">
                                <?php if (!empty($centres)): ?>
                                    <?php foreach ($centres as $index => $centre): ?>
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <!-- Code Centre -->
                                            <td class="py-4 px-4 font-mono font-semibold text-emerald-700 whitespace-nowrap align-middle">
                                                <?= esc($centre['CODECENTRE']) ?>
                                            </td>
                                            
                                            <!-- Nom du Centre -->
                                            <td class="py-4 px-4 font-bold text-gray-900 align-middle">
                                                <?= esc($centre['NOMCENTRE']) ?>
                                            </td>
                                            
                                            <!-- Localisation -->
                                            <td class="py-4 px-4 text-gray-600 align-middle">
                                                <?= esc($centre['LOCALISATION']) ?>
                                            </td>
                                            
                                            <!-- Capacité -->
                                            <td class="py-4 px-4 text-center font-semibold text-gray-700 align-middle">
                                                <?= esc($centre['CAPACITEDACCUEIL']) ?> places
                                            </td>
                                            
                                            <!-- Sections Habilitées & Bouton d'édition compact -->
                                            <td class="py-4 px-4 align-middle">
                                                <div class="flex items-center justify-between gap-2">
                                                    <div class="flex flex-wrap gap-1 max-w-xs">
                                                        <?php if (!empty($centre['sections'])): ?>
                                                            <?php foreach ($centre['sections'] as $sec): ?>
                                                                <span class="px-2 py-0.5 text-[10px] bg-emerald-50 text-emerald-700 border border-emerald-200 rounded font-medium">
                                                                    <?= esc($sec['NOMSECTION']) ?>
                                                                </span>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <span class="text-xs text-gray-400 italic">Aucune section</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    
                                                    <!-- Bouton d'édition compact -->
                                                    <button onclick="toggleSectionModal('modal-sections-<?= $index ?>')" class="w-8 h-8 flex items-center justify-center text-xs text-emerald-600 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition shrink-0 shadow-2xs" title="Modifier les sections">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                </div>

                                                <!-- Modale de configuration des sections -->
                                                <div id="modal-sections-<?= $index ?>" class="hidden fixed inset-0 bg-black/30 backdrop-blur-xs z-50 flex items-center justify-center p-4">
                                                    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6 space-y-4 border border-gray-100">
                                                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                                                            <h4 class="text-sm font-bold text-gray-900">Configurer les sections - <?= esc($centre['NOMCENTRE']) ?></h4>
                                                            <button onclick="toggleSectionModal('modal-sections-<?= $index ?>')" class="text-gray-400 hover:text-gray-600 text-sm">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </div>
                                                        <form action="/admin/centres/update-sections/<?= esc($centre['CODECENTRE']) ?>" method="POST" class="space-y-4">
                                                            <div class="grid grid-cols-1 gap-2 max-h-60 overflow-y-auto p-1">
                                                                <?php foreach ($toutesSections as $sec): ?>
                                                                    <label class="flex items-center space-x-3 p-2.5 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer text-xs font-medium text-gray-700">
                                                                        <input type="checkbox" name="sections[]" value="<?= esc($sec['CODESECTION']) ?>" <?= in_array($sec['CODESECTION'], $centre['section_codes']) ? 'checked' : '' ?> class="w-4 h-4 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500">
                                                                        <span><?= esc($sec['NOMSECTION']) ?></span>
                                                                    </label>
                                                                <?php endforeach; ?>
                                                            </div>
                                                            <div class="flex justify-end gap-2 pt-2 border-t border-gray-100">
                                                                <button type="button" onclick="toggleSectionModal('modal-sections-<?= $index ?>')" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-lg transition">
                                                                    Annuler
                                                                </button>
                                                                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg shadow-sm transition">
                                                                    Enregistrer
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Statut -->
                                            <td class="py-4 px-4 align-middle">
                                                <?php if ($centre['STATUT'] == 1): ?>
                                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 text-[11px] font-medium bg-emerald-50 text-emerald-700 rounded-full">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Actif
                                                    </span>
                                                <?php else: ?>
                                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 text-[11px] font-medium bg-rose-50 text-rose-700 rounded-full">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Inactif
                                                    </span>
                                                <?php endif; ?>
                                            </td>

                                            <!-- Actions (Bouton d'activation harmonisé) -->
                                            <td class="py-3 px-4 text-center align-middle whitespace-nowrap">
                                                <div class="inline-flex items-center justify-center gap-1.5">
                                                    <a href="<?= site_url('admin/centres/toggle/' . $centre['CODECENTRE']) ?>" class="w-24 h-7 text-[11px] font-semibold rounded-lg border <?= ($centre['STATUT'] == 1) ? 'border-rose-200 bg-rose-50/50 hover:bg-rose-100 text-rose-700' : 'border-emerald-200 bg-emerald-50/50 hover:bg-emerald-100 text-emerald-700' ?> transition inline-flex items-center justify-center shadow-2xs">
                                                        <?= ($centre['STATUT'] == 1) ? 'Désactiver' : 'Activer' ?>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="py-12 text-center text-gray-400 text-sm italic">
                                            Aucun centre enregistré dans la base de données.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>

    </div>

    <!-- Script pour la modale et la disparition automatique des messages flash -->
    <script>
        function toggleSectionModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.toggle('hidden');
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
                setTimeout(() => dismissFlash(), 4000);
            }
        });
    </script>

</body>
</html>