<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit26d82a6c4e376172becbaab254866fe4
{
    public static $files = array (
        'e40631d46120a9c38ea139981f8dab26' => __DIR__ . '/..' . '/ircmaxell/password-compat/lib/password.php',
        'edc6464955a37aa4d5fbf39d40fb6ee7' => __DIR__ . '/..' . '/symfony/polyfill-php55/bootstrap.php',
        '3a37ebac017bc098e9a86b35401e7a68' => __DIR__ . '/..' . '/mongodb/mongodb/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tools\\' => 6,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Php55\\' => 23,
            'Symfony\\Component\\EventDispatcher\\' => 34,
            'Sokil\\Mongo\\' => 12,
        ),
        'P' => 
        array (
            'Psr\\SimpleCache\\' => 16,
            'Psr\\Log\\' => 8,
        ),
        'M' => 
        array (
            'MongoDB\\' => 8,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tools\\' => 
        array (
            0 => __DIR__ . '/../..' . '/tools',
        ),
        'Symfony\\Polyfill\\Php55\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php55',
        ),
        'Symfony\\Component\\EventDispatcher\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/event-dispatcher',
        ),
        'Sokil\\Mongo\\' => 
        array (
            0 => __DIR__ . '/..' . '/sokil/php-mongo/src',
            1 => __DIR__ . '/..' . '/sokil/php-mongo/tests',
        ),
        'Psr\\SimpleCache\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/simple-cache/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'MongoDB\\' => 
        array (
            0 => __DIR__ . '/..' . '/mongodb/mongodb/src',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $prefixesPsr0 = array (
        'G' => 
        array (
            'GeoJson\\' => 
            array (
                0 => __DIR__ . '/..' . '/jmikola/geojson/src',
            ),
        ),
    );

    public static $classMap = array (
        'JsonSerializable' => __DIR__ . '/..' . '/sokil/php-mongo/stubs/JsonSerializable.php',
        'Twitter' => __DIR__ . '/..' . '/dg/twitter-php/src/Twitter.php',
        'TwitterException' => __DIR__ . '/..' . '/dg/twitter-php/src/Twitter.php',
        'Twitter_OAuthConsumer' => __DIR__ . '/..' . '/dg/twitter-php/src/OAuth.php',
        'Twitter_OAuthDataStore' => __DIR__ . '/..' . '/dg/twitter-php/src/OAuth.php',
        'Twitter_OAuthException' => __DIR__ . '/..' . '/dg/twitter-php/src/OAuth.php',
        'Twitter_OAuthRequest' => __DIR__ . '/..' . '/dg/twitter-php/src/OAuth.php',
        'Twitter_OAuthServer' => __DIR__ . '/..' . '/dg/twitter-php/src/OAuth.php',
        'Twitter_OAuthSignatureMethod' => __DIR__ . '/..' . '/dg/twitter-php/src/OAuth.php',
        'Twitter_OAuthSignatureMethod_HMAC_SHA1' => __DIR__ . '/..' . '/dg/twitter-php/src/OAuth.php',
        'Twitter_OAuthSignatureMethod_PLAINTEXT' => __DIR__ . '/..' . '/dg/twitter-php/src/OAuth.php',
        'Twitter_OAuthSignatureMethod_RSA_SHA1' => __DIR__ . '/..' . '/dg/twitter-php/src/OAuth.php',
        'Twitter_OAuthToken' => __DIR__ . '/..' . '/dg/twitter-php/src/OAuth.php',
        'Twitter_OAuthUtil' => __DIR__ . '/..' . '/dg/twitter-php/src/OAuth.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit26d82a6c4e376172becbaab254866fe4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit26d82a6c4e376172becbaab254866fe4::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit26d82a6c4e376172becbaab254866fe4::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit26d82a6c4e376172becbaab254866fe4::$classMap;

        }, null, ClassLoader::class);
    }
}
