<?php
// Test se Apache legge le variabili d'ambiente
echo "APP_ENV from \$_SERVER: " . ($_SERVER['APP_ENV'] ?? 'NOT SET') . "<br>";
echo "APP_KEY from \$_SERVER: " . (isset($_SERVER['APP_KEY']) ? 'SET (length: ' . strlen($_SERVER['APP_KEY']) . ')' : 'NOT SET') . "<br>";
echo "variables_order: " . ini_get('variables_order') . "<br>";
echo "<br>All \$_SERVER keys containing APP:<br>";
foreach ($_SERVER as $key => $value) {
    if (strpos($key, 'APP') !== false) {
        echo "$key = " . (strlen($value) > 50 ? substr($value, 0, 50) . '...' : $value) . "<br>";
    }
}

