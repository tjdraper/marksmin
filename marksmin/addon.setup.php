<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2018 BuzzingPixel, LLC
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

// Get addon json path
$addOnPath = realpath(__DIR__);

// Get vendor autoload
$vendorAutoloadFile = "{$addOnPath}/vendor/autoload.php";

// Require the autoload file if path exists
if (file_exists($vendorAutoloadFile)) {
    require $vendorAutoloadFile;
}

defined('MARKSMIN_DESCRIPTION') || define('MARKSMIN_DESCRIPTION', 'Minify HTML output');
defined('MARKSMIN_DOCS_URL') || define('MARKSMIN_DOCS_URL', 'https://buzzingpixel.com/software/marksmin/documentation');
defined('MARKSMIN_NAME') || define('MARKSMIN_NAME', 'Marksmin');
defined('MARKSMIN_VER') || define('MARKSMIN_VER', '1.3.1');

return array(
    'author' => 'TJ Draper',
    'author_url' => 'https://buzzingpixel.com',
    'description' => MARKSMIN_DESCRIPTION,
    'docs_url' => MARKSMIN_DOCS_URL,
    'name' => MARKSMIN_NAME,
    'namespace' => 'BuzzingPixel\Marksmin',
    'settings_exist' => false,
    'version' => MARKSMIN_VER
);
