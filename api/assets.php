<?php

/**
 * Built assets aren't currently routeable via vercel-php
 */
$type = $_GET['type'] ?? null;
$file = $_GET['file'] ?? null;

switch($_GET['type']) {
    case 'css':
        header("Content-type: text/css;");
        return readfile(__DIR__ . '/../public/css/' . basename($_GET['file']));
        break;
    case 'js':
        header('Content-Type: application/javascript;');
        return readfile(__DIR__ . '/../public/js/' . basename($_GET['file']));
        break;
    case 'fonts':
        header('Content-Type: font/woff2;');
        return readfile(__DIR__ . '/../public/fonts/' . basename($_GET['file']));
        break;
}
