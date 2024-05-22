<?php
define('WORK_DIRECTORY', 'fileView');
define('ALLOWED_EXTENSIONS', [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF]);

$workingDirectory = realpath(__DIR__ . DIRECTORY_SEPARATOR . WORK_DIRECTORY);

function safeJoin($base, $path)
{
    $newPath = realpath($base . DIRECTORY_SEPARATOR . $path);
    return $newPath !== false && strpos($newPath, $base) === 0 ? $newPath : $base;
}

function isImage($filePath)
{
    $fileExtension = @exif_imagetype($filePath);
    return $fileExtension && in_array($fileExtension, ALLOWED_EXTENSIONS);
}

function webPath($relativePathForUrl)
{
    $pathTheFile = str_replace(DIRECTORY_SEPARATOR, '/', $relativePathForUrl);
    $selfPath = substr($_SERVER["PHP_SELF"], 0, strrpos($_SERVER["PHP_SELF"], '/')) . '/' . WORK_DIRECTORY;
    return ($_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["SERVER_NAME"] . $selfPath . '/' . $pathTheFile);
}

$currentDir = isset($_GET['dir']) ? $_GET['dir'] : '';
$currentPath = safeJoin($workingDirectory, $currentDir);

if ($currentPath && is_dir($currentPath)) {
    $files = array_diff(scandir($currentPath), ['.', '..']);
} else {
    $files = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>File Manager</title>
</head>

<body>
    <div class="file-manager">
        <h1>Файловый менеджер</h1>
        <p>Текущая директория: <?php echo $currentPath ?></p>
        <ul>
            <?php if ($currentDir && $currentDir !== '.') : ?>
                <li><a href="?dir=<?php echo urlencode(dirname($currentDir)); ?>">←</a></li>
            <?php endif; ?>
            <?php foreach ($files as $file) : ?>
                <?php
                $filePath = $currentPath . DIRECTORY_SEPARATOR . $file;
                $relativePath = ($currentDir ? $currentDir . DIRECTORY_SEPARATOR : '') . $file;

                $relativePathForUrl = ((!empty($currentDir) && $currentDir[0] === '.')
                    ? substr($currentDir, 1) : $currentDir) . '/' . $file;

                if (is_dir($filePath)) : ?>
                    <li><a href="?dir=<?php echo urlencode($relativePath); ?>"><?php echo $file; ?></a></li>
                <?php elseif (isImage($filePath)) :
                    $actionWebPath = webPath($relativePathForUrl); ?>
                    <li> <a href="<?php echo $actionWebPath ?>" target="_blank"><?php echo $file; ?></a></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</body>

</html>