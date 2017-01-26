<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/** @var ClassLoader $loader */
$loader = require __DIR__.'/../vendor/autoload.php';

/** MPDF tmp folders */
define("_MPDF_TEMP_PATH", __DIR__.'/../web/uploads/documents/pdf/');
define("_MPDF_TTFONTDATAPATH", __DIR__.'/../web/uploads/documents/pdf/fonts/');

AnnotationRegistry::registerLoader([$loader, 'loadClass']);

return $loader;
