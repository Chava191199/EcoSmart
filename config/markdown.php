<?php

/**
 * Parseador simple de Markdown a HTML
 * Soporta: headings, bold, italic, listas, links, blockquotes, código
 */

function parseMarkdown($texto) {
    // Escapar HTML primero
    $texto = htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
    
    // Salvar bloques de código para procesarlos al final
    $codeBlocks = array();
    preg_match_all('/```([^`]*?)```/s', $texto, $matches);
    foreach ($matches[0] as $i => $block) {
        $placeholder = "CODEBLOCK_" . $i . "_PLACEHOLDER";
        $codigo = $matches[1][$i];
        $codeBlocks[$placeholder] = "<pre><code>" . $codigo . "</code></pre>";
        $texto = str_replace($block, $placeholder, $texto);
    }
    
    // Salvar inline code
    $inlineCode = array();
    preg_match_all('/`([^`]*?)`/', $texto, $matches);
    foreach ($matches[0] as $i => $block) {
        $placeholder = "INLINECODE_" . $i . "_PLACEHOLDER";
        $codigo = htmlspecialchars($matches[1][$i], ENT_QUOTES, 'UTF-8');
        $inlineCode[$placeholder] = "<code>" . $codigo . "</code>";
        $texto = str_replace($block, $placeholder, $texto);
    }
    
    // Títulos (headings)
    $texto = preg_replace('/^### (.*?)$/m', '<h3>$1</h3>', $texto);
    $texto = preg_replace('/^## (.*?)$/m', '<h2>$1</h2>', $texto);
    $texto = preg_replace('/^# (.*?)$/m', '<h1>$1</h1>', $texto);
    
    // Links [texto](url)
    $texto = preg_replace('/\[([^\]]+?)\]\(([^)]+?)\)/', '<a href="$2" target="_blank">$1</a>', $texto);
    
    // Bold **texto**
    $texto = preg_replace('/\*\*([^\*]+?)\*\*/', '<strong>$1</strong>', $texto);
    
    // Italic *texto*
    $texto = preg_replace('/(?<!\*)\*([^\*]+?)\*(?!\*)/', '<em>$1</em>', $texto);
    
    // Blockquotes > texto
    $texto = preg_replace('/^> (.*?)$/m', '<blockquote>$1</blockquote>', $texto);
    
    // Listas no ordenadas - texto
    $lineas = explode("\n", $texto);
    $enLista = false;
    $textoSalida = array();
    
    foreach ($lineas as $linea) {
        if (preg_match('/^- (.+)$/', $linea, $matches)) {
            if (!$enLista) {
                $textoSalida[] = '<ul>';
                $enLista = true;
            }
            $textoSalida[] = '<li>' . $matches[1] . '</li>';
        } else {
            if ($enLista && !empty($linea)) {
                $textoSalida[] = '</ul>';
                $enLista = false;
            }
            if (!empty($linea)) {
                $textoSalida[] = $linea;
            }
        }
    }
    
    if ($enLista) {
        $textoSalida[] = '</ul>';
    }
    
    $texto = implode("\n", $textoSalida);
    
    // Párrafos (envolver líneas no vacías que no sean HTML)
    $lineas = explode("\n", $texto);
    $textoSalida = array();
    
    foreach ($lineas as $linea) {
        $linea = trim($linea);
        if (!empty($linea) && !preg_match('/^<[h|u|b|a|p|d|l|c]/', $linea)) {
            $textoSalida[] = '<p>' . $linea . '</p>';
        } else {
            if (!empty($linea)) {
                $textoSalida[] = $linea;
            }
        }
    }
    
    $texto = implode("\n", $textoSalida);
    
    // Restaurar bloques de código
    foreach ($codeBlocks as $placeholder => $html) {
        $texto = str_replace($placeholder, $html, $texto);
    }
    
    // Restaurar inline code
    foreach ($inlineCode as $placeholder => $html) {
        $texto = str_replace($placeholder, $html, $texto);
    }
    
    return $texto;
}

?>
