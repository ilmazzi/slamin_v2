<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test SCSS Semplice</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <style>
        /* Inline test per vedere se il problema è specificity */
        .test-inline { background-color: #e06155 !important; width: 100px; height: 100px; }
    </style>
</head>
<body class="p-8">
    <h1 class="text-4xl font-bold mb-8">Test SCSS Diretto</h1>

    <!-- Test 1: Inline style -->
    <h2 class="text-2xl font-bold mb-4">1. Test Inline Style (dovrebbe essere rosso)</h2>
    <div class="test-inline mb-8"></div>

    <!-- Test 2: Classe SCSS custom -->
    <h2 class="text-2xl font-bold mb-4">2. Test Classe SCSS .bg-accent-500 (dovrebbe essere rosso/terracotta)</h2>
    <div class="bg-accent-500 mb-8" style="width: 100px; height: 100px;"></div>

    <!-- Test 3: Tailwind standard -->
    <h2 class="text-2xl font-bold mb-4">3. Test Tailwind Standard .bg-red-500 (dovrebbe essere rosso)</h2>
    <div class="bg-red-500 mb-8" style="width: 100px; height: 100px;"></div>

    <!-- Test 4: Text gradient custom -->
    <h2 class="text-2xl font-bold mb-4">4. Test Text Gradient Custom</h2>
    <div class="text-gradient text-6xl font-bold mb-8">GRADIENT TEXT</div>

    <!-- Test 5: Typography custom -->
    <h2 class="text-2xl font-bold mb-4">5. Test Typography Custom</h2>
    <div class="h1 mb-4">Heading 1 Custom</div>
    <div class="body mb-8">Body text custom</div>

    <!-- Test 6: Debug info -->
    <div class="mt-12 p-4 bg-gray-100 rounded">
        <h3 class="font-bold mb-2">Debug Info:</h3>
        <p>Se vedi:</p>
        <ul class="list-disc ml-6">
            <li>Box 1 ROSSO = inline style funziona</li>
            <li>Box 2 ROSSO/TERRACOTTA = SCSS custom funziona</li>
            <li>Box 3 ROSSO = Tailwind standard funziona</li>
            <li>GRADIENT TEXT colorato = custom classes funzionano</li>
        </ul>
    </div>

    <script>
        // Log CSS delle classi custom
        const accentBox = document.querySelector('.bg-accent-500');
        if (accentBox) {
            const styles = window.getComputedStyle(accentBox);
            console.log('bg-accent-500 background-color:', styles.backgroundColor);
        }
    </script>
</body>
</html>

