<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plateforme en Maintenance - <?= esc(get_setting('app_name', 'INFP Madagascar')) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans antialiased h-screen flex flex-col justify-center items-center p-4">

    <!-- BANDE TRICOLORE -->
    <div class="fixed top-0 left-0 w-full h-1.5 flex">
        <div class="w-1/3 bg-red-600"></div>
        <div class="w-1/3 bg-white"></div>
        <div class="w-1/3 bg-emerald-600"></div>
    </div>

    <div class="max-w-md w-full bg-white rounded-2xl border border-gray-200/80 shadow-xl p-8 text-center space-y-6">
        <div class="w-16 h-16 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-2xl mx-auto shadow-inner border border-amber-100">
            <i class="fa-solid fa-screwdriver-wrench"></i>
        </div>

        <div>
            <h1 class="text-xl font-bold text-gray-900"><?= esc(get_setting('app_name', 'INFP Madagascar')) ?></h1>
            <p class="text-xs text-amber-600 font-semibold uppercase tracking-wider mt-1">Maintenance Technique en cours</p>
        </div>

        <p class="text-xs text-gray-600 leading-relaxed">
            La plateforme est temporairement indisponible en raison de travaux de maintenance ou de mise à jour du système. Veuillez réessayer ultérieurement.
        </p>

        <div class="pt-4 border-t border-gray-100 flex items-center justify-center gap-2 text-[11px] text-gray-400">
            <i class="fa-regular fa-clock"></i>
            <span>Merci pour votre patience — Support Technique INFP</span>
        </div>
    </div>

</body>
</html>