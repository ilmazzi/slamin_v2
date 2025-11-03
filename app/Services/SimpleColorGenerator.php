<?php

namespace App\Services;

use Spatie\Color\Hex;
use Spatie\Color\Rgb;
use Spatie\Color\Hsl;

/**
 * Generatore semplice stile UIColors.app
 * 1 colore → 1 palette (50-950) + semantici fissi predefiniti
 */
class SimpleColorGenerator
{
    /**
     * Genera palette completa da 1 colore + semantici fissi
     * 
     * @param string $baseColor Colore base in hex
     * @param string $preset Nome preset per semantici (sky, emerald, orange, rose, slate)
     * @return array
     */
    public function generate(string $baseColor, string $preset = 'sky'): array
    {
        // Genera la palette principale (50-950) con CIELab
        $mainPalette = $this->generateScale($baseColor);
        
        // Semantici FISSI predefiniti in base al preset
        $semantics = $this->getSemanticColors($preset);
        
        return [
            'main' => $mainPalette,
            'semantic' => $semantics,
            'preset' => $preset,
        ];
    }
    
    /**
     * Genera scala 50-950 con algoritmo CIELab (Tailwind-like)
     */
    private function generateScale(string $baseHex): array
    {
        $hex = Hex::fromString($baseHex);
        $rgb = $hex->toRgb();
        $lab = $rgb->toCIELab();
        
        $L = $lab->l();
        $a = $lab->a();
        $b = $lab->b();
        
        $L = $this->clamp($L, 18.0, 85.0);
        
        $targets = [
            50  => $this->mixL($L, 100.0, 0.92),
            100 => $this->mixL($L, 100.0, 0.78),
            200 => $this->mixL($L, 100.0, 0.62),
            300 => $this->mixL($L, 100.0, 0.47),
            400 => $this->mixL($L, 100.0, 0.32),
            500 => $L,
            600 => $this->scaleL($L, 0.86),
            700 => $this->scaleL($L, 0.70),
            800 => $this->scaleL($L, 0.55),
            900 => $this->scaleL($L, 0.40),
            950 => $this->scaleL($L, 0.28),
        ];
        
        $desat = [
            50  => 0.78,
            100 => 0.82,
            200 => 0.86,
            300 => 0.90,
            400 => 0.95,
            500 => 1.00,
            600 => 0.95,
            700 => 0.90,
            800 => 0.84,
            900 => 0.78,
            950 => 0.70,
        ];
        
        $palette = [];
        $steps = [50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 950];
        
        foreach ($steps as $s) {
            $Lt = $this->clamp($targets[$s], 3.0, 99.0);
            $k = $desat[$s];
            $at = $a * $k;
            $bt = $b * $k;
            $hexOut = $this->labToHex($Lt, $at, $bt);
            $palette[(string)$s] = $hexOut;
        }
        
        return $palette;
    }
    
    /**
     * Ritorna colori semantici FISSI in base al preset scelto
     */
    private function getSemanticColors(string $preset): array
    {
        // Colori semantici FISSI tipo Tailwind
        // Sempre gli stessi, indipendentemente dalla palette principale!
        
        $presets = [
            // Sky: usa toni freddi per semantici
            'sky' => [
                'success' => '#10b981',  // Emerald-500
                'success-light' => '#d1fae5',
                'success-dark' => '#065f46',
                
                'warning' => '#f59e0b',  // Amber-500
                'warning-light' => '#fef3c7',
                'warning-dark' => '#b45309',
                
                'error' => '#ef4444',    // Red-500
                'error-light' => '#fee2e2',
                'error-dark' => '#991b1b',
                
                'info' => '#06b6d4',     // Cyan-500
                'info-light' => '#cffafe',
                'info-dark' => '#155e75',
            ],
            
            // Emerald: success usa il principale, altri standard
            'emerald' => [
                'success' => '#10b981',  // Stesso del main!
                'success-light' => '#d1fae5',
                'success-dark' => '#065f46',
                
                'warning' => '#f59e0b',
                'warning-light' => '#fef3c7',
                'warning-dark' => '#b45309',
                
                'error' => '#ef4444',
                'error-light' => '#fee2e2',
                'error-dark' => '#991b1b',
                
                'info' => '#3b82f6',     // Blue
                'info-light' => '#dbeafe',
                'info-dark' => '#1e40af',
            ],
            
            // Orange: warning usa il principale
            'orange' => [
                'success' => '#10b981',
                'success-light' => '#d1fae5',
                'success-dark' => '#065f46',
                
                'warning' => '#f97316',  // Stesso del main!
                'warning-light' => '#ffedd5',
                'warning-dark' => '#c2410c',
                
                'error' => '#ef4444',
                'error-light' => '#fee2e2',
                'error-dark' => '#991b1b',
                
                'info' => '#3b82f6',
                'info-light' => '#dbeafe',
                'info-dark' => '#1e40af',
            ],
            
            // Rose: error usa il principale
            'rose' => [
                'success' => '#10b981',
                'success-light' => '#d1fae5',
                'success-dark' => '#065f46',
                
                'warning' => '#f59e0b',
                'warning-light' => '#fef3c7',
                'warning-dark' => '#b45309',
                
                'error' => '#f43f5e',    // Stesso del main!
                'error-light' => '#fce7f3',
                'error-dark' => '#9f1239',
                
                'info' => '#3b82f6',
                'info-light' => '#dbeafe',
                'info-dark' => '#1e40af',
            ],
            
            // Slate: solo neutri, semantici tutti standard
            'slate' => [
                'success' => '#10b981',
                'success-light' => '#d1fae5',
                'success-dark' => '#065f46',
                
                'warning' => '#f59e0b',
                'warning-light' => '#fef3c7',
                'warning-dark' => '#b45309',
                
                'error' => '#ef4444',
                'error-light' => '#fee2e2',
                'error-dark' => '#991b1b',
                
                'info' => '#3b82f6',
                'info-light' => '#dbeafe',
                'info-dark' => '#1e40af',
            ],
        ];
        
        return $presets[$preset] ?? $presets['sky'];
    }
    
    /**
     * Ottieni lista preset disponibili
     */
    public function getAvailablePresets(): array
    {
        return [
            'sky' => [
                'name' => 'Sky',
                'description' => 'Palette fredda con cyan/blu - semantici standard',
                'icon' => '🔵',
                'example' => '#9bdbe8',
            ],
            'emerald' => [
                'name' => 'Emerald',
                'description' => 'Palette verde - success usa il principale',
                'icon' => '🟢',
                'example' => '#10b981',
            ],
            'orange' => [
                'name' => 'Orange',
                'description' => 'Palette calda - warning usa il principale',
                'icon' => '🟠',
                'example' => '#f97316',
            ],
            'rose' => [
                'name' => 'Rose',
                'description' => 'Palette rosa/rosso - error usa il principale',
                'icon' => '🌸',
                'example' => '#f43f5e',
            ],
            'slate' => [
                'name' => 'Slate',
                'description' => 'Palette neutra grigio - semantici tutti standard',
                'icon' => '⚫',
                'example' => '#64748b',
            ],
        ];
    }
    
    // === Helper Methods CIELab (come prima) ===
    
    private function labToHex(float $L, float $a, float $b): string
    {
        $y = ($L + 16.0) / 116.0;
        $x = $a / 500.0 + $y;
        $z = $y - $b / 200.0;
        
        $x3 = $x ** 3;
        $y3 = $y ** 3;
        $z3 = $z ** 3;
        
        $epsilon = 0.008856;
        $kappa = 903.3;
        
        $xr = ($x3 > $epsilon) ? $x3 : (116.0 * $x - 16.0) / $kappa;
        $yr = ($y3 > $epsilon) ? $y3 : (116.0 * $y - 16.0) / $kappa;
        $zr = ($z3 > $epsilon) ? $z3 : (116.0 * $z - 16.0) / $kappa;
        
        $Xn = 95.047;
        $Yn = 100.000;
        $Zn = 108.883;
        
        $X = $xr * $Xn;
        $Y = $yr * $Yn;
        $Z = $zr * $Zn;
        
        $xN = $X / 100.0;
        $yN = $Y / 100.0;
        $zN = $Z / 100.0;
        
        $rLin =  3.2406 * $xN + (-1.5372) * $yN + (-0.4986) * $zN;
        $gLin = (-0.9689) * $xN +  1.8758  * $yN +  0.0415  * $zN;
        $bLin =  0.0557 * $xN + (-0.2040) * $yN +  1.0570  * $zN;
        
        $r = $this->gammaEncodeSRgb($rLin);
        $g = $this->gammaEncodeSRgb($gLin);
        $b = $this->gammaEncodeSRgb($bLin);
        
        $R = (int) round($this->clamp($r * 255.0, 0, 255));
        $G = (int) round($this->clamp($g * 255.0, 0, 255));
        $B = (int) round($this->clamp($b * 255.0, 0, 255));
        
        $hex = (new Rgb($R, $G, $B))->toHex();
        return (string) $hex;
    }
    
    private function gammaEncodeSRgb(float $c): float
    {
        if ($c <= 0.0031308) {
            return max(0.0, $c * 12.92);
        }
        return 1.055 * pow(max(0.0, $c), 1.0 / 2.4) - 0.055;
    }
    
    private function mixL(float $L, float $target, float $w): float
    {
        return $L + ($target - $L) * $this->clamp($w, 0.0, 1.0);
    }
    
    private function scaleL(float $L, float $k): float
    {
        return $L * $this->clamp($k, 0.0, 1.0);
    }
    
    private function clamp(float $v, float $min, float $max): float
    {
        return max($min, min($max, $v));
    }
    
    /**
     * Valida hex
     */
    public function isValidHex(string $hex): bool
    {
        try {
            Hex::fromString($hex);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     * Normalizza hex
     */
    public function normalizeHex(string $hex): string
    {
        $hex = trim($hex);
        if (!str_starts_with($hex, '#')) {
            $hex = '#' . $hex;
        }
        return strtolower($hex);
    }
}

