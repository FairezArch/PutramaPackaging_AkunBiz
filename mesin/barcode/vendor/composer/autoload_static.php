<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit90f84d7b30589b279245d5d6dfbce9e0
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Picqer\\Barcode\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Picqer\\Barcode\\' => 
        array (
            0 => __DIR__ . '/..' . '/picqer/php-barcode-generator/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit90f84d7b30589b279245d5d6dfbce9e0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit90f84d7b30589b279245d5d6dfbce9e0::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}