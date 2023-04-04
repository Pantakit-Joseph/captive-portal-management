<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->group('portal', ['namespace' => 'App\Controllers\Portal'], static function ($routes) {
    $routes->get('edit-password', 'EditPassword::index');
    $routes->post('edit-password', 'EditPassword::action');
    $routes->get('edit-password/success', 'EditPassword::success');
    $routes->get('issues/new', 'IssuesNew::index');
    $routes->post('issues/new', 'IssuesNew::action');
});

$routes->group('auth', static function ($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::loginAction');
    $routes->get('logout', 'Auth::logout');
});

$routes->group(
    'admin',
    [
        'namespace' => 'App\Controllers\Admin',
        'filter'    => 'login:admin',
    ],
    static function ($routes) {
        $routes->addRedirect('/', site_url('admin/home'));
        $routes->get('home', 'Home::index');

        $routes->get('issues', 'Issues\Issues::index');
        $routes->post('issues/api/(:num)/close', 'Issues\Issues::apiClose/$1');
        $routes->post('issues/api/(:num)/open', 'Issues\Issues::apiOpen/$1');

        $routes->get('issues/types', 'Issues\Types::index');
        $routes->post('issues/types/api', 'Issues\Types::apiAdd');
        $routes->put('issues/types/api/(:num)', 'Issues\Types::apiEdit/$1');
        $routes->delete('issues/types/api/(:num)', 'Issues\Types::apiDelete/$1');
        $routes->delete('issues/types/api/(:num)/purge', 'Issues\Types::apiPurgeDelete/$1');
        $routes->post('issues/types/api/(:num)/restore', 'Issues\Types::apiPurgeRestore/$1');
    }
);

$routes->get('/test/app', 'Test::app');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
