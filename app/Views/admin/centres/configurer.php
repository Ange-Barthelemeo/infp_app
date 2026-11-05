<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurer Sections - <?= esc($centre['NOMCENTRE']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans antialiased flex flex-col h-screen overflow-hidden">

    <div class="h-1.5 w-full flex shrink-0">
        <div class="w-1/3 bg-red-600"></div>
        <div class="w-1/3 bg-white"></div>
        <div class="w-1/3 bg-emerald-600"></div>
    </div>

    <div class="flex flex-1 overflow-hidden">
        <main class="flex-1 flex flex-col h-full overflow-y-auto bg-gray-50/50 p-8">
            <div class="max-w-3xl mx-auto w-full space-y-6">
                
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Sections ho an'ny: <?= esc($centre['NOMCENTRE']) ?></h2>
                        <p class="text-sm text-gray-500 mt-1">Tsindrio ireo bokotra fisafidianana (checkbox) mba hampidirana na hanesorana section.</p>
                    </div>
                    <a href="/admin/centres" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-bold rounded-xl transition">
                        &larr; Hiverina
                    </a>
                </div>

                <form action="/admin/centres/store-config/<?= esc($centre['CODECENTRE']) ?>" method="POST" class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-6">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php foreach ($toutesSections as $sec): ?>
                            <?php $isAssigned = in_array($sec['CODESECTION'], $codesActuels); ?>
                            <label class="flex items-center space-x-3 p-3 rounded-xl border <?= $isAssigned ? 'border-emerald-500 bg-emerald-50/30' : 'border-gray-200 hover:bg-gray-50' ?> cursor-pointer transition">
                                <input type="checkbox" name="sections[]" value="<?= esc($sec['CODESECTION']) ?>" <?= $isAssigned ? 'checked' : '' ?> class="w-4 h-4 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500">
                                <div>
                                    <p class="text-xs font-mono font-bold text-emerald-700"><?= esc($sec['CODESECTION']) ?></p>
                                    <p class="text-sm font-semibold text-gray-800"><?= esc($sec['NOMSECTION']) ?></p>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm transition">
                            Tehirizina ny fanovana
                        </button>
                    </div>

                </form>

            </div>
        </main>
    </div>
</body>
</html>