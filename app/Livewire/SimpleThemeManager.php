<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\File;
use App\Services\SimpleColorGenerator;

class SimpleThemeManager extends Component
{
    public $selectedPreset = 'sky';
    public $baseColor = '#9bdbe8';
    public $preview = null;
    public $message = '';
    public $messageType = '';
    
    public $presets = [
        'sky' => ['name' => 'Sky', 'icon' => '🔵', 'color' => '#9bdbe8', 'desc' => 'Fresco e professionale'],
        'emerald' => ['name' => 'Emerald', 'icon' => '🟢', 'color' => '#10b981', 'desc' => 'Naturale e positivo'],
        'orange' => ['name' => 'Orange', 'icon' => '🟠', 'color' => '#f97316', 'desc' => 'Caldo ed energetico'],
        'rose' => ['name' => 'Rose', 'icon' => '🌸', 'color' => '#f43f5e', 'desc' => 'Moderno e vibrante'],
        'slate' => ['name' => 'Slate', 'icon' => '⚫', 'color' => '#64748b', 'desc' => 'Neutro ed elegante'],
    ];
    
    public function mount()
    {
        $this->baseColor = $this->presets[$this->selectedPreset]['color'];
    }
    
    public function selectPreset($preset)
    {
        $this->selectedPreset = $preset;
        $this->baseColor = $this->presets[$preset]['color'];
        $this->preview = null;
        $this->message = '';
    }
    
    public function generatePreview()
    {
        try {
            $generator = new SimpleColorGenerator();
            
            $baseColor = $generator->normalizeHex($this->baseColor);
            
            if (!$generator->isValidHex($baseColor)) {
                $this->message = "Colore non valido. Usa formato hex (es. #9bdbe8)";
                $this->messageType = 'error';
                return;
            }
            
            // Genera 1 palette + semantici fissi
            $this->preview = $generator->generate($baseColor, $this->selectedPreset);
            
            $this->message = "Preview generata! La palette usa il tuo colore, i semantici sono fissi tipo Tailwind.";
            $this->messageType = 'info';
            
        } catch (\Exception $e) {
            $this->message = "Errore: " . $e->getMessage();
            $this->messageType = 'error';
        }
    }
    
    public function applyPalette()
    {
        try {
            if (!$this->preview) {
                $this->message = "Genera prima una preview!";
                $this->messageType = 'error';
                return;
            }
            
            $presetName = $this->presets[$this->selectedPreset]['name'];
            
            // Usa la palette principale per primary, accent, secondary
            $palette = [
                'name' => $presetName,
                'description' => "Basato su {$this->baseColor}",
                'colors' => [
                    'primary' => $this->preview['main'],
                    'accent' => $this->preview['main'],      // Stesso per semplicità
                    'secondary' => $this->preview['main'],   // Stesso per semplicità
                ],
            ];
            
            // Update files
            $this->updateScssFile($palette);
            $this->updateCssFile($palette);
            $this->updateSemanticColors($this->preview['semantic']);
            
            session(['current_palette' => $this->selectedPreset]);
            
            $this->preview = null;
            $this->message = "Palette '{$presetName}' applicata! Ricompila con 'npm run dev'";
            $this->messageType = 'success';
            
        } catch (\Exception $e) {
            $this->message = "Errore: " . $e->getMessage();
            $this->messageType = 'error';
        }
    }
    
    private function updateScssFile($palette)
    {
        $scssPath = resource_path('css/_variables.scss');
        $content = File::get($scssPath);
        
        // Update Primary, Accent, Secondary (tutti usano la stessa palette)
        foreach (['primary', 'accent', 'secondary'] as $type) {
            $section = "// " . ucfirst($type) . " Colors\n";
            foreach ($palette['colors'][$type] as $shade => $color) {
                $section .= "\${$type}-{$shade}: {$color};\n";
            }
            $section .= "\n";
            
            $content = preg_replace(
                "/\/\/ " . ucfirst($type) . " Colors.*?\n(.*?\n){12}/s",
                $section,
                $content
            );
        }
        
        File::put($scssPath, $content);
    }
    
    private function updateCssFile($palette)
    {
        $cssPath = resource_path('css/app.css');
        $content = File::get($cssPath);
        
        // Update @theme block
        $themeBlock = "@theme {\n    --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;\n    \n";
        
        foreach (['primary', 'accent', 'secondary'] as $type) {
            foreach ($palette['colors'][$type] as $shade => $color) {
                $themeBlock .= "    --color-{$type}-{$shade}: {$color};\n";
            }
            $themeBlock .= "    \n";
        }
        
        $themeBlock .= "}";
        
        $content = preg_replace('/@theme\s*\{.*?\}/s', $themeBlock, $content);
        
        // Update utility classes
        foreach (['primary', 'accent', 'secondary'] as $type) {
            foreach ($palette['colors'][$type] as $shade => $color) {
                $content = preg_replace(
                    "/\.bg-{$type}-{$shade}\s*\{\s*background-color:\s*#[0-9a-f]{6}\s*!important;\s*\}/i",
                    ".bg-{$type}-{$shade} { background-color: {$color} !important; }",
                    $content
                );
            }
        }
        
        File::put($cssPath, $content);
    }
    
    private function updateSemanticColors($semanticColors)
    {
        // Update SCSS
        $scssPath = resource_path('css/_variables.scss');
        $content = File::get($scssPath);
        
        $semanticSection = "// Semantic Colors\n";
        foreach (['success', 'warning', 'error', 'info'] as $type) {
            $semanticSection .= "\${$type}: {$semanticColors[$type]};\n";
            $semanticSection .= "\${$type}-light: {$semanticColors[$type.'-light']};\n";
            $semanticSection .= "\${$type}-dark: {$semanticColors[$type.'-dark']};\n\n";
        }
        
        $content = preg_replace(
            '/\/\/ Semantic Colors.*?\n(\$info-dark:.*?;)/s',
            $semanticSection,
            $content
        );
        
        File::put($scssPath, $content);
        
        // Update CSS
        $this->updateSemanticCssClasses($semanticColors);
    }
    
    private function updateSemanticCssClasses($semanticColors)
    {
        $cssPath = resource_path('css/app.css');
        $content = File::get($cssPath);
        
        foreach (['success', 'warning', 'error', 'info'] as $type) {
            $content = preg_replace(
                "/\.bg-{$type}\s*\{\s*background-color:\s*#[0-9a-f]{6}\s*!important;\s*\}/i",
                ".bg-{$type} { background-color: {$semanticColors[$type]} !important; }",
                $content
            );
            
            $content = preg_replace(
                "/\.text-{$type}\s*\{\s*color:\s*#[0-9a-f]{6}\s*!important;\s*\}/i",
                ".text-{$type} { color: {$semanticColors[$type]} !important; }",
                $content
            );
            
            $content = preg_replace(
                "/\.bg-{$type}-light\s*\{\s*background-color:\s*#[0-9a-f]{6}\s*!important;\s*\}/i",
                ".bg-{$type}-light { background-color: {$semanticColors[$type.'-light']} !important; }",
                $content
            );
            
            $content = preg_replace(
                "/\.bg-{$type}-dark\s*\{\s*background-color:\s*#[0-9a-f]{6}\s*!important;\s*\}/i",
                ".bg-{$type}-dark { background-color: {$semanticColors[$type.'-dark']} !important; }",
                $content
            );
        }
        
        File::put($cssPath, $content);
    }
    
    public function render()
    {
        return view('livewire.simple-theme-manager');
    }
}

