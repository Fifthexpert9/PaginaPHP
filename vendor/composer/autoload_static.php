<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit976516f2cec743c3dc320c6644e0a135
{
    public static $prefixLengthsPsr4 = array (
        'u' => 
        array (
            'utils\\' => 6,
        ),
        's' => 
        array (
            'services\\' => 9,
        ),
        'm' => 
        array (
            'models\\' => 7,
        ),
        'f' => 
        array (
            'facades\\' => 8,
        ),
        'd' => 
        array (
            'dtos\\' => 5,
        ),
        'c' => 
        array (
            'converters\\' => 11,
            'controllers\\' => 12,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'utils\\' => 
        array (
            0 => __DIR__ . '/../..' . '/utils',
        ),
        'services\\' => 
        array (
            0 => __DIR__ . '/../..' . '/services',
        ),
        'models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/models',
        ),
        'facades\\' => 
        array (
            0 => __DIR__ . '/../..' . '/facades',
        ),
        'dtos\\' => 
        array (
            0 => __DIR__ . '/../..' . '/dtos',
        ),
        'converters\\' => 
        array (
            0 => __DIR__ . '/../..' . '/converters',
        ),
        'controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/controllers',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit976516f2cec743c3dc320c6644e0a135::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit976516f2cec743c3dc320c6644e0a135::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit976516f2cec743c3dc320c6644e0a135::$classMap;

        }, null, ClassLoader::class);
    }
}
