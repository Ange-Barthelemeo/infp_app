<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Centre - <?= esc($centre['NOMCENTRE']) ?> - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
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

        <!-- SIDEBAR -->
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
            </div>

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
                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">SUPERVISION — DOSSIER DU CENTRE RÉGIONAL</span>
                </div>
                <div class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                    <i class="fa-regular fa-calendar-days mr-1.5 text-gray-400"></i> <?= date('d / m / Y') ?>
                </div>
            </header>

            <div class="p-8 max-w-7xl mx-auto w-full space-y-8">
                
                <!-- En-tête et retour -->
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900"><?= esc($centre['NOMCENTRE']) ?></h2>
                        <p class="text-sm text-gray-500 mt-1">
                            <i class="fa-solid fa-location-dot text-gray-400 mr-1"></i> Localisation : <?= esc($centre['LOCALISATION'] ?? 'Non spécifiée') ?>
                            <span class="mx-2">•</span> 
                            <span class="font-mono text-xs bg-gray-100 px-2 py-0.5 rounded text-gray-600">Code Centre : <?= esc($centre['CODECENTRE']) ?></span>
                        </p>
                    </div>
                    <a href="/central/centres" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs rounded-xl transition flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i> Retour aux centres
                    </a>
                </div>

                <!-- SECTION 1 : CORPS ENSEIGNANT RATTACHÉ AU CENTRE -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-chalkboard-user text-emerald-600"></i> Corps Enseignant (Formateurs du Centre)
                        </h3>
                        <span class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            Total : <?= count($formateurs) ?> formateur(s)
                        </span>
                    </div>

                    <div class="w-full overflow-x-auto">
                        <table class="w-full text-left border-collapse table-auto">
                            <thead>
                                <tr class="bg-gray-50/50 text-[11px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 whitespace-nowrap">
                                    <th class="py-3.5 px-6">IM / Identifiant</th>
                                    <th class="py-3.5 px-6">Nom et Prénoms</th>
                                    <th class="py-3.5 px-6">N° CIN</th>
                                    <th class="py-3.5 px-6 text-center">Statut RH</th>
                                    <th class="py-3.5 px-6 text-center">État Accès</th>
                                    <th class="py-3.5 px-6">Contact & Adresse</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-xs">
                                <?php if (!empty($formateurs)): ?>
                                    <?php foreach ($formateurs as $f): ?>
                                        <tr class="hover:bg-gray-50/50 transition whitespace-nowrap">
                                            <td class="py-4 px-6 font-mono font-semibold text-emerald-700 align-middle">
                                                <?php if (!empty($f['IMMFORMATEUR'])): ?>
                                                    <?php 
                                                        $imBrut = preg_replace('/\D/', '', $f['IMMFORMATEUR']);
                                                        echo (strlen($imBrut) === 6) ? 'IM : ' . substr($imBrut, 0, 3) . ' ' . substr($imBrut, 3, 3) : 'IM : ' . esc($f['IMMFORMATEUR']);
                                                    ?>
                                                <?php elseif (!empty($f['CODEVAC'])): ?>
                                                    <span class="text-amber-600">Vac : <?= esc($f['CODEVAC']) ?></span>
                                                <?php else: ?>
                                                    <span class="text-gray-400">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-4 px-6 font-bold text-gray-900 align-middle">
                                                <?= esc(($f['NOMFORMATEUR'] ?? '') . ' ' . ($f['PRENOMFORMATEUR'] ?? '')) ?>
                                            </td>
                                            <td class="py-4 px-6 font-mono text-gray-600 align-middle">
                                                <?= esc($f['NUMCINFORM']) ?>
                                            </td>
                                            <td class="py-4 px-6 text-center align-middle">
                                                <?php if (!empty($f['IMMFORMATEUR'])): ?>
                                                    <span class="px-2.5 py-1 text-[11px] font-semibold bg-emerald-50 text-emerald-700 rounded-full border border-emerald-200">Permanent</span>
                                                <?php else: ?>
                                                    <span class="px-2.5 py-1 text-[11px] font-semibold bg-amber-50 text-amber-700 rounded-full border border-amber-200">Vacataire</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-4 px-6 text-center align-middle">
                                                <?php if (($f['EST_ACTIF'] ?? 1) == 1): ?>
                                                    <span class="px-2.5 py-1 text-[11px] font-semibold bg-emerald-50 text-emerald-700 rounded-full border border-emerald-200">Actif</span>
                                                <?php else: ?>
                                                    <span class="px-2.5 py-1 text-[11px] font-semibold bg-red-50 text-red-700 rounded-full border border-red-200">Suspendu</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-4 px-6 align-middle">
                                                <div class="text-gray-800 font-mono"><i class="fa-solid fa-phone mr-1 text-gray-400"></i><?= esc($f['CONTACTFORMATEUR'] ?? 'N/A') ?></div>
                                                <div class="text-[10px] text-gray-500"><?= esc($f['ADRESSEFORMATEUR'] ?? 'Adresse non spécifiée') ?></div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="py-8 text-center text-gray-400 text-sm italic">
                                            Aucun formateur n'est actuellement rattaché à ce centre régional.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SECTION 2 : LISTE DES ÉLÈVES-MAÎTRES DU CENTRE -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-user-graduate text-emerald-600"></i> Registre des Élèves-Maîtres
                        </h3>
                        <span class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            Total : <?= count($eleves) ?> élève(s)
                        </span>
                    </div>

                    <div class="w-full overflow-x-auto">
                        <table class="w-full text-left border-collapse table-auto">
                            <thead>
                                <tr class="bg-gray-50/50 text-[11px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 whitespace-nowrap">
                                    <th class="py-3.5 px-4">Matricule</th>
                                    <th class="py-3.5 px-4">Nom et Prénoms</th>
                                    <th class="py-3.5 px-4 text-center">Sexe</th>
                                    <th class="py-3.5 px-4">Date & Lieu de Naissance</th>
                                    <th class="py-3.5 px-4">N° CIN</th>
                                    <th class="py-3.5 px-4">Classe</th>
                                    <th class="py-3.5 px-4">Adresse & Contact</th>
                                    <th class="py-3.5 px-4 text-center">Absences</th>
                                    <th class="py-3.5 px-4 text-center">Statut Final</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-xs">
                                <?php if (!empty($eleves)): ?>
                                    <?php foreach ($eleves as $eleve): ?>
                                        <tr class="hover:bg-gray-50/50 transition whitespace-nowrap">
                                            <td class="py-4 px-4 font-mono font-semibold text-emerald-700 align-middle">
                                                <?= esc($eleve['MATRICULEELEVE']) ?>
                                            </td>
                                            <td class="py-4 px-4 font-bold text-gray-900 align-middle">
                                                <?= esc(($eleve['NOMELEVE'] ?? '') . ' ' . ($eleve['PRENOMELEVE'] ?? '')) ?>
                                            </td>
                                            <td class="py-4 px-4 text-center text-gray-600 align-middle">
                                                <span class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded text-[11px] font-bold">
                                                    <?= esc($eleve['SEXE'] ?? 'N/A') ?>
                                                </span>
                                            </td>
                                            <td class="py-4 px-4 text-gray-700 align-middle">
                                                <div class="font-medium"><?= !empty($eleve['DATENAISSANCE']) ? date('d/m/Y', strtotime($eleve['DATENAISSANCE'])) : 'N/A' ?></div>
                                                <div class="text-[10px] text-gray-400">à <?= esc($eleve['LIEUNAISSANCE'] ?? 'N/A') ?></div>
                                            </td>
                                            <td class="py-4 px-4 font-mono text-gray-700 align-middle">
                                                <?= esc($eleve['NUMCINELEVE'] ?? 'Non renseigné') ?>
                                            </td>
                                            <td class="py-4 px-4 font-semibold text-gray-800 align-middle">
                                                <?= esc($eleve['NOMCLASSE'] ?? 'N/A') ?>
                                            </td>
                                            <td class="py-4 px-4 align-middle">
                                                <div class="text-gray-800"><?= esc($eleve['ADRESSEELEVE'] ?? 'Adresse non spécifiée') ?></div>
                                                <div class="text-[10px] text-gray-400 font-mono"><i class="fa-solid fa-phone mr-1"></i><?= esc($eleve['TELEPHONEELEVE'] ?? 'Aucun contact') ?></div>
                                            </td>
                                            <td class="py-4 px-4 text-center align-middle">
                                                <span class="px-2.5 py-1 text-xs font-bold <?= ($eleve['CUMULABSENCE'] ?? 0) > 0 ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-gray-50 text-gray-600' ?> rounded-full">
                                                    <?= esc($eleve['CUMULABSENCE'] ?? '0.00') ?> h
                                                </span>
                                            </td>
                                            <td class="py-4 px-4 text-center align-middle">
                                                <span class="px-2.5 py-1 text-[11px] font-semibold bg-emerald-50 text-emerald-700 rounded-full border border-emerald-200">
                                                    <?= esc($eleve['STATUTFINAL'] ?? 'En cours') ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="py-12 text-center text-gray-400 text-sm italic">
                                            Aucun élève-maître n'est actuellement inscrit dans ce centre régional.
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

</body>
</html>