<?php
define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'fileView');
define('ALLOWED_EXTENSIONS', [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF]);

function listFilesAndDirectories($currentPath) {
    if (strpos($currentPath, ROOT_PATH) !== 0) {
        echo "Доступ запрещен!\n";
        return;
    }

    $files = scandir($currentPath);
    foreach ($files as $file) {
        if ($file === '.') {
            continue;
        }

        if ($file === '..') {
            echo "                \e[92m$file\e[0m\n";
            continue;
        }

        $filePath = realpath($currentPath . DIRECTORY_SEPARATOR . $file);
        if (is_dir($filePath)) {
            echo "   \e[7m[Папка]\e[0m      \e[92m$file\e[0m\n";
            continue;
        } 

        $fileExtension = @exif_imagetype($filePath);
        if ($fileExtension && in_array($fileExtension, ALLOWED_EXTENSIONS)) {
            echo "\e[7m[Изображение]\e[0m   \e[92m$file\e[0m\n";
        }
    }
}

function changeDirectory($currentPath, $newDir) {
    $newPath = realpath($currentPath . DIRECTORY_SEPARATOR . $newDir) ?: realpath($newDir);

    if (strpos($newPath, ROOT_PATH) === 0 && is_dir($newPath)) {
        return $newPath;
    } 

    echo "\n\e[91mНедействительный каталог!\e[0m\n";
    return $currentPath;
}

$currentPath = ROOT_PATH;

while (true) {
    echo "\n\e[1mТекущая директория:\e[0m \e[92m$currentPath\e[0m\n";
    listFilesAndDirectories($currentPath);

    echo "\e[93m\nВведите имя каталога для перехода, '..' для перехода на уровень выше или 'exit', чтобы выйти: \e[0m";
    $input = trim(readline());

    if ($input === 'exit') {
        break;
    }

    if ($input === '..') {
        $parentPath = dirname($currentPath);
        
        if (strpos($parentPath, ROOT_PATH) === 0) {
            $currentPath = $parentPath;
            continue;
        }

        echo "\n\e[91mДоступ запрещен!\e[0m\n";
        continue;
    } 
    
    $currentPath = changeDirectory($currentPath, $input);
}
?>
