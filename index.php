<?php

use Silex\Application;
use Silex\Provider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//
// Application setup
//

require_once __DIR__ . '/vendor/autoload.php';

$app = new Application();
$app['debug'] = true;

// allow for translation
$app->register(new Provider\DoctrineServiceProvider());
$app->register(new Provider\UrlGeneratorServiceProvider());
$app->register(new Provider\FormServiceProvider());
$app->register(new Provider\SecurityServiceProvider());

$app['security.firewalls'] = array(
    'admin' => array(
        'pattern' => '^/admin',
        'http' => true,
        'users' => array(
            // raw password is foo
            'admin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
        ),
    ),
);


$app->register(new Provider\TwigServiceProvider());
$app['twig.path'] = array(__DIR__.'/views');
$app['twig']->addExtension(new Acme\Twig\Extensions\PriceExtension());
$app->register(new Provider\RememberMeServiceProvider());
$app->register(new Provider\SessionServiceProvider());
$app->register(new Provider\ServiceControllerServiceProvider());
$app->register(new Provider\ValidatorServiceProvider());

$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'host' => 'localhost',
    'dbname' => 'somedb',
    'user' => 'root',
    'password' => '',
);

$app->get('/', function () {
    return 'Hello world';
});

$app->run();
