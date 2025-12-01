<?php

namespace App\Helpers;

use App\Models\PlaceholderSetting;

class PlaceholderHelper
{
    /**
     * Pulisce il contenuto HTML rimuovendo tag, entità HTML e spazi multipli
     * Preserva gli a capo convertendo <br> e </p><p> in newline
     */
    public static function cleanHtmlContent($content, $limit = null)
    {
        if (empty($content)) {
            return '';
        }
        
        // Converti <br> e <br/> in newline prima di rimuovere i tag
        $content = preg_replace('/<br\s*\/?>/i', "\n", $content);
        
        // Converti </p><p> e </p>\s*<p> in doppio newline (paragrafo)
        $content = preg_replace('/<\/p>\s*<p[^>]*>/i', "\n\n", $content);
        
        // Converti </p> e <p> in newline
        $content = preg_replace('/<\/?p[^>]*>/i', "\n", $content);
        
        // Rimuovi altri tag HTML (dopo aver convertito br e p)
        $content = strip_tags($content);
        
        // Decodifica entità HTML (come &nbsp;, &amp;, etc.)
        $content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        // Sostituisci &nbsp; con spazi normali (per sicurezza, anche se già decodificato)
        $content = str_replace(['&nbsp;', "\xC2\xA0"], ' ', $content);
        
        // Normalizza newline multipli (max 2 consecutivi)
        $content = preg_replace('/\n{3,}/', "\n\n", $content);
        
        // Rimuovi spazi multipli su ogni riga (ma preserva i newline)
        $lines = explode("\n", $content);
        $lines = array_map(function($line) {
            // Rimuovi spazi multipli sulla riga
            $line = preg_replace('/\s+/', ' ', $line);
            return trim($line);
        }, $lines);
        $content = implode("\n", $lines);
        
        // Rimuovi righe vuote all'inizio e alla fine
        $content = trim($content);
        
        // Limita se richiesto (preservando i newline)
        if ($limit !== null) {
            // Se il contenuto è più lungo del limite, taglia ma preserva i newline
            if (mb_strlen($content) > $limit) {
                $content = mb_substr($content, 0, $limit);
                // Assicurati di non tagliare a metà una parola se possibile
                $lastSpace = mb_strrpos($content, ' ');
                $lastNewline = mb_strrpos($content, "\n");
                $lastBreak = max($lastSpace, $lastNewline);
                if ($lastBreak !== false && $lastBreak > $limit * 0.7) {
                    $content = mb_substr($content, 0, $lastBreak);
                }
                $content .= '...';
            }
        }
        
        return $content;
    }

    /**
     * Genera l'URL del placeholder per una poesia (ora usa data URI)
     */
    public static function getPoemPlaceholderUrl($width = 300, $height = 200)
    {
        $settings = PlaceholderSetting::getSettings();
        $color = $settings->poem_placeholder_color;
        
        // Crea un SVG inline con il colore personalizzato (usa simbolo Unicode)
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="' . $width . '" height="' . $height . '" viewBox="0 0 ' . $width . ' ' . $height . '">
            <rect width="100%" height="100%" fill="' . $color . '"/>
            <text x="50%" y="50%" font-family="Arial, sans-serif" font-size="48" fill="white" text-anchor="middle" dy=".3em">📖</text>
        </svg>';
        
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    /**
     * Genera l'URL del placeholder per un articolo (ora usa data URI)
     */
    public static function getArticlePlaceholderUrl($width = 300, $height = 200)
    {
        $settings = PlaceholderSetting::getSettings();
        $color = $settings->article_placeholder_color;
        
        // Crea un SVG inline con il colore personalizzato (usa simbolo Unicode)
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="' . $width . '" height="' . $height . '" viewBox="0 0 ' . $width . ' ' . $height . '">
            <rect width="100%" height="100%" fill="' . $color . '"/>
            <text x="50%" y="50%" font-family="Arial, sans-serif" font-size="48" fill="white" text-anchor="middle" dy=".3em">📰</text>
        </svg>';
        
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    /**
     * Genera il CSS inline per un placeholder
     */
    public static function getPoemPlaceholderStyle($width = 300, $height = 200)
    {
        $settings = PlaceholderSetting::getSettings();
        $color = $settings->poem_placeholder_color;
        
        return "width: {$width}px; height: {$height}px; background-color: {$color}; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; border-radius: 8px;";
    }

    /**
     * Genera il CSS inline per un placeholder articolo
     */
    public static function getArticlePlaceholderStyle($width = 300, $height = 200)
    {
        $settings = PlaceholderSetting::getSettings();
        $color = $settings->article_placeholder_color;
        
        return "width: {$width}px; height: {$height}px; background-color: {$color}; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; border-radius: 8px;";
    }

    /**
     * Genera un div placeholder per una poesia
     */
    public static function getPoemPlaceholderDiv($width = 300, $height = 200, $class = '')
    {
        $style = self::getPoemPlaceholderStyle($width, $height);
        return "<div class='placeholder-container {$class}' style='{$style}'><i class='ph-duotone ph-book-open'></i></div>";
    }

    /**
     * Genera un div placeholder per un articolo
     */
    public static function getArticlePlaceholderDiv($width = 300, $height = 200, $class = '')
    {
        $style = self::getArticlePlaceholderStyle($width, $height);
        return "<div class='placeholder-container {$class}' style='{$style}'><i class='ph-duotone ph-newspaper'></i></div>";
    }

    /**
     * Genera un placeholder HTML completo per una poesia
     */
    public static function getPoemPlaceholderHtml($width = 300, $height = 200, $class = '', $url = null)
    {
        $settings = PlaceholderSetting::getSettings();
        $color = $settings->poem_placeholder_color;
        
        // Se le dimensioni sono 0 o negative, usa dimensioni responsive
        if ($width <= 0 || $height <= 0) {
            $style = "width: 100%; height: {$height}px; background-color: {$color}; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px; border-radius: 8px;";
        } else {
            // Calcola la dimensione dell'emoji in base alle dimensioni del placeholder
            $emojiSize = min($width, $height) * 0.3; // 30% della dimensione più piccola
            $style = "width: {$width}px; height: {$height}px; background-color: {$color}; display: flex; align-items: center; justify-content: center; color: white; font-size: {$emojiSize}px; border-radius: 8px;";
        }
        
        $placeholder = "<div class='poem-placeholder {$class}' style='{$style}'>📖</div>";
        
        if ($url) {
            return "<a href='{$url}' class='text-decoration-none'>{$placeholder}</a>";
        }
        
        return $placeholder;
    }

    /**
     * Genera un placeholder HTML completo per un articolo
     */
    public static function getArticlePlaceholderHtml($width = 300, $height = 200, $class = '', $url = null)
    {
        $settings = PlaceholderSetting::getSettings();
        $color = $settings->article_placeholder_color;
        
        // Se le dimensioni sono 0 o negative, usa dimensioni responsive
        if ($width <= 0 || $height <= 0) {
            $style = "width: 100%; height: 250px; background-color: {$color}; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px; border-radius: 8px;";
        } else {
            // Calcola la dimensione dell'emoji in base alle dimensioni del placeholder
            $emojiSize = min($width, $height) * 0.3; // 30% della dimensione più piccola
            $style = "width: {$width}px; height: {$height}px; background-color: {$color}; display: flex; align-items: center; justify-content: center; color: white; font-size: {$emojiSize}px; border-radius: 8px;";
        }
        
        $placeholder = "<div class='article-placeholder {$class}' style='{$style}'>📰</div>";
        
        if ($url) {
            return "<a href='{$url}' class='text-decoration-none'>{$placeholder}</a>";
        }
        
        return $placeholder;
    }

    /**
     * Genera l'URL del placeholder per un evento (ora usa data URI)
     */
    public static function getEventPlaceholderUrl($width = 300, $height = 200)
    {
        $settings = PlaceholderSetting::getSettings();
        $color = $settings->event_placeholder_color ?? '#17a2b8';
        
        // Crea un SVG inline con il colore personalizzato
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="' . $width . '" height="' . $height . '" viewBox="0 0 ' . $width . ' ' . $height . '">
            <rect width="100%" height="100%" fill="' . $color . '"/>
            <text x="50%" y="50%" font-family="Arial, sans-serif" font-size="48" fill="white" text-anchor="middle" dy=".3em">📅</text>
        </svg>';
        
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}
