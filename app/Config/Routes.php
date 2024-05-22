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
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/shop', 'Home::store');
$routes->get('/search-products', 'Home::searchProducts');
$routes->get('/AboutUs', 'Home::about');
$routes->get('/register', 'Home::register');
$routes->get('/forgot-password','Home::forgotPassword');
$routes->post('create-account','Home::createAccount');
$routes->post('/login','Home::Login');
$routes->post('/validate','Home::validateUser');
$routes->get('activate/(:any)','Home::activate/$1');
$routes->get('sign-out','Home::signOut');
$routes->get('log-out','Home::logOut');
$routes->get('cart/details/(:any)','Cart::productDetails/$1');
$routes->post('buy/(:any)','Cart::buy/$1');
$routes->get('remove/(:any)','Cart::remove/$1');
$routes->get('remove-item/(:any)','Cart::removeItem/$1');
$routes->post('confirmation','Cart::orderConfirmation');
$routes->get('fetch-primary-address','Cart::primaryAddress');

$routes->group('',['filter'=>'AuthCheck'],function($routes)
{
    $routes->get('dashboard','Home::dashboard');
    $routes->get('customer-orders','Home::orders');
    $routes->get('products','Home::products');
});

$routes->group('',['filter'=>'AlreadyLoggedIn'],function($routes)
{
    $routes->get('/auth','Home::Auth');
});

$routes->group('',['filter'=>'customerAuthCheck'],function($routes)
{
    $routes->get('check-out','Cart::checkOut');
    $routes->get('orders','Cart::orders');
    $routes->get('history','Cart::orderHistory');
    $routes->get('account','Cart::account');
});

$routes->group('',['filter'=>'customerAlreadyLoggedIn'],function($routes)
{
    $routes->get('/sign-in', 'Home::signIn');
});
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
