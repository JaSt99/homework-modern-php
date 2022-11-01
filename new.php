<?php declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use IW\Workshop\FileReader;

if (isset($argc)) {
    $filePath = $argv[1];

    if (isset($argv[2])) {
        $filters = explode(',', strtolower($argv[2]));
    }
} else {
    echo "'argc' a 'argv' jsou vypnuté\n";
    exit();
}

$fileReader = new FileReader();
$fileReader->readFile($filePath, $filters ?? []);

exit();
