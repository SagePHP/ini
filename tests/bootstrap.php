<?php

require_once __DIR__ . '/../vendor/symfony/class-loader/Symfony/Component/ClassLoader/UniversalClassLoader.php';
require_once __DIR__ . '/../vendor/autoload.php';
use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();

// You can search the include_path as a last resort.
$loader->useIncludePath(true);

// ... register namespaces and prefixes here - see below
$loader->registerNamespaces(
    array(
        'SagePHP' => __DIR__.'/../src/',
    )
);

$loader->register();

