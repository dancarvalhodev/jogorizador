<?php

use App\Http\Api\v1\Consult\ConsultPlatform;
use App\Http\Api\v1\Consult\ConsultRom;
use App\Http\Site\Index;
use App\Http\Site\Logged\Platform;
use App\Http\Site\Logged\Rom;
use App\Http\Site\Logged\Base;
use App\Middleware\AuthBasic;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
//    $app->any(
//        '/api/v{version:[1]{1}}/{resource:[a-z-]+}[/{child:[a-z-]+}[/{id:[0-9]+}]]',
//        ApiRouteResolver::class
//    )->add(ApiAuthentication::class);

    // SITE
    // INDEX
    $app->get(
        '/',
        Index::class
    )->setArgument('action', 'index');

    $app->get(
        '/login',
        Index::class
    )->setArgument('action', 'indexLogin');

    $app->get(
        '/register',
        Index::class
    )->setArgument('action', 'indexRegister');

    // BASE ACTIONS
    $app->post(
        '/login',
        Base::class
    )->setArgument('action', 'login');

    $app->post(
        '/register',
        Base::class
    )->setArgument('action', 'register');

    $app->get(
        '/logout',
        Base::class
    )->setArgument('action', 'logout')->add(AuthBasic::class);


    // ---------------------------------------------------------------------------
    // CRUD ROMS
    // GET
    $app->get(
        '/insert/rom',
        Rom::class
    )->setArgument('action', 'insertForm')->add(AuthBasic::class);

    $app->get(
        '/update/rom[/{id:[0-9]+}]',
        Rom::class
    )->setArgument('action', 'updateForm')->add(AuthBasic::class);

    $app->get(
        '/show/rom[/{id:[0-9]+}]',
        Rom::class
    )->setArgument('action', 'showRom')->add(AuthBasic::class);

    $app->get(
        '/show/rom/all',
        Rom::class
    )->setArgument('action', 'showRoms')->add(AuthBasic::class);

    $app->get(
        '/delete/rom[/{id:[0-9]+}]',
        Rom::class
    )->setArgument('action', 'deleteForm')->add(AuthBasic::class);

    // POST
    $app->group('/crud', function (RouteCollectorProxy $group) {
        $group->post(
            '/insert/rom',
            Rom::class
        )->setArgument('action', 'insert');

        $group->post(
            '/update/rom',
            Rom::class
        )->setArgument('action', 'update');

        $group->post(
            '/delete/rom',
            Rom::class
        )->setArgument('action', 'delete');
    })->add(AuthBasic::class);

    // ---------------------------------------------------------------------------
    // CRUD PLATFORMS
    // GET
    $app->get(
        '/insert/platform',
        Platform::class
    )->setArgument('action', 'insertForm')->add(AuthBasic::class);

    $app->get(
        '/update/platform[/{id:[0-9]+}]',
        Platform::class
    )->setArgument('action', 'updateForm')->add(AuthBasic::class);

    $app->get(
        '/show/platform[/{id:[0-9]+}]',
        Platform::class
    )->setArgument('action', 'showPlatform')->add(AuthBasic::class);

    $app->get(
        '/show/platform/all',
        Platform::class
    )->setArgument('action', 'showPlatforms')->add(AuthBasic::class);

    $app->get(
        '/delete/platform[/{id:[0-9]+}]',
        Platform::class
    )->setArgument('action', 'deleteForm')->add(AuthBasic::class);

    // POST
    $app->group('/crud', function (RouteCollectorProxy $group) {
        $group->post(
            '/crud/insert/platform',
            Platform::class
        )->setArgument('action', 'insert');

        $group->post(
            '/crud/update/platform',
            Platform::class
        )->setArgument('action', 'update');

        $group->post(
            '/crud/delete/platform',
            Platform::class
        )->setArgument('action', 'delete');
    })->add(AuthBasic::class);

    // API
    $app->any(
        '/api/v{version:[1]{1}}/platform',
        ConsultPlatform::class
    )->setArgument('action', 'get')->add(AuthBasic::class);

    $app->any(
        '/api/v{version:[1]{1}}/rom',
        ConsultRom::class
    )->setArgument('action', 'get')->add(AuthBasic::class);
};
