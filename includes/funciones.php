<?php
// Escapa texto para mostrarlo de forma segura en HTML
function e($texto): string
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}
