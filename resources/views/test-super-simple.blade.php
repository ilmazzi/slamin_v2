<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Test SCSS</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body style="padding: 40px; font-family: Inter, sans-serif;">
    <h1 style="font-size: 32px; margin-bottom: 20px;">Test SCSS Funzionamento</h1>
    
    <div style="margin-bottom: 40px;">
        <h2 style="font-size: 24px; margin-bottom: 10px;">Box con classe .bg-accent:</h2>
        <div class="bg-accent" style="width: 200px; height: 200px; border: 2px solid black;"></div>
        <p style="margin-top: 10px;">Dovrebbe essere ROSSO/TERRACOTTA (#e06155)</p>
    </div>

    <div style="margin-bottom: 40px;">
        <h2 style="font-size: 24px; margin-bottom: 10px;">Box con classe .bg-primary:</h2>
        <div class="bg-primary" style="width: 200px; height: 200px; border: 2px solid black;"></div>
        <p style="margin-top: 10px;">Dovrebbe essere BLU/SLATE (#64748b)</p>
    </div>

    <div style="margin-bottom: 40px;">
        <h2 style="font-size: 24px; margin-bottom: 10px;">Box con classe .bg-secondary:</h2>
        <div class="bg-secondary" style="width: 200px; height: 200px; border: 2px solid black;"></div>
        <p style="margin-top: 10px;">Dovrebbe essere VERDE SAGE (#637063)</p>
    </div>

    <div style="margin-bottom: 40px;">
        <h2 style="font-size: 24px; margin-bottom: 10px;">Text Gradient:</h2>
        <div class="text-gradient" style="font-size: 48px; font-weight: bold;">TESTO GRADIENTE</div>
        <p style="margin-top: 10px;">Dovrebbe essere gradiente rosso/arancione</p>
    </div>

    <div style="margin-top: 60px; padding: 20px; background: #f0f0f0; border: 2px solid #333;">
        <h3 style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">✅ Se vedi i colori = SCSS FUNZIONA!</h3>
        <p>Variabili SCSS disponibili nel file resources/css/_variables.scss</p>
    </div>
</body>
</html>

