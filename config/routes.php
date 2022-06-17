<?php

use App\Http\Api\v1\Auth\Token;
use App\Http\Site\Logged\Platform;
use App\Http\Site\Logged\Rom;
use App\Http\Site\Logged\Home;
use App\Middleware\ApiAuthentication;
use App\Routing\ApiRouteResolver;
use Slim\App;

return function (App $app) {

//    $app->any(
//        '/api/v{version:[1]{1}}/auth/token',
//        Token::class
//    )->setArgument('action', 'post');
//
//    $app->any(
//        '/api/v{version:[1]{1}}/{resource:[a-z-]+}[/{child:[a-z-]+}[/{id:[0-9]+}]]',
//        ApiRouteResolver::class
//    )->add(ApiAuthentication::class);

    // SITE
    $app->get(
        '/',
        Home::class
    )->setArgument('action', 'index');

    // ---------------------------------------------------------------------------
    // CRUD ROMS
    // GET
    $app->get(
        '/insert/rom',
        Rom::class
    )->setArgument('action', 'insertForm');

    $app->get(
        '/update/rom[/{id:[0-9]+}]',
        Rom::class
    )->setArgument('action', 'updateForm');

    $app->get(
        '/show/rom[/{id:[0-9]+}]',
        Rom::class
    )->setArgument('action', 'showRom');

    $app->get(
        '/show/rom/all',
        Rom::class
    )->setArgument('action', 'showRoms');

    $app->get(
        '/delete/rom[/{id:[0-9]+}]',
        Rom::class
    )->setArgument('action', 'deleteRom');

    // POST
    $app->post(
        '/crud/insert/rom',
        Rom::class
    )->setArgument('action', 'insert');

    $app->post(
        '/crud/update/rom',
        Rom::class
    )->setArgument('action', 'update');

    // ---------------------------------------------------------------------------
    // CRUD PLATFORMS
    // GET
    $app->get(
        '/insert/platform',
        Platform::class
    )->setArgument('action', 'insertForm');

    $app->get(
        '/update/platform[/{id:[0-9]+}]',
        Platform::class
    )->setArgument('action', 'updateForm');

    $app->get(
        '/show/platform[/{id:[0-9]+}]',
        Platform::class
    )->setArgument('action', 'showPlatform');

    $app->get(
        '/show/platform/all',
        Platform::class
    )->setArgument('action', 'showPlatforms');

    $app->get(
        '/delete/platform[/{id:[0-9]+}]',
        Platform::class
    )->setArgument('action', 'deletePlatform');

    // POST
    $app->post(
        '/crud/insert/platform',
        Platform::class
    )->setArgument('action', 'insert');

    $app->post(
        '/crud/update/platform',
        Platform::class
    )->setArgument('action', 'update');
};
