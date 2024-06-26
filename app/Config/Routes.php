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
$routes->get('/frequently-asked-question', 'Home::Faq');
$routes->get('/register', 'Home::register');
$routes->get('/forgot-password','Home::forgotPassword');
$routes->get('/request-new-password','Home::requestNewPassword');
$routes->post('create-account','Home::createAccount');
$routes->post('/login','Home::Login');
$routes->post('/validate','Home::validateUser');
$routes->get('activate/(:any)','Home::activate/$1');
$routes->get('sign-out','Home::signOut');
$routes->get('log-out','Home::logOut');
$routes->get('find-products','Home::findProducts');
$routes->get('fetch-by-category','Home::fetchByCategory');
$routes->get('fetch-by-type','Home::fetchByType');
$routes->post('save-product','Home::saveProduct');
$routes->post('update-product','Home::updateProduct');
$routes->post('upload-image','Home::uploadImage');
$routes->post('add-stocks','Home::addStocks');
$routes->get('search-orders','Home::searchOrders');
$routes->get('search-orders-date','Home::searchOrdersDate');
$routes->post('add-account','Home::addAccount');
$routes->get('search-accounts','Home::searchAccounts');
$routes->post('reset-account','Home::resetAccount');
$routes->post('update-account','Home::updateAccount');
$routes->get('search-by-category','Home::searchByCategory');
$routes->get('search-by-type','Home::searchByType');
$routes->post('save-category','Home::saveCategory');
$routes->get('download','Download::downloadFile');
$routes->post('restore','RestoreDB::RestoreData');
$routes->get('generate-report','Home::generateReport');
$routes->post('update-payment','Home::updatePayment');
$routes->post('request-password','Home::requestPassword');
//cart controller
$routes->get('cart/details/(:any)','Cart::productDetails/$1');
$routes->post('buy/(:any)','Cart::buy/$1');
$routes->get('remove/(:any)','Cart::remove/$1');
$routes->get('remove-item/(:any)','Cart::removeItem/$1');
$routes->post('confirmation','Cart::orderConfirmation');
$routes->get('fetch-primary-address','Cart::primaryAddress');
$routes->get('search-customer-orders','Cart::searchOrders');
$routes->post('cancel-order','Cart::cancelOrder');
$routes->post('save-changes','Cart::updateAccount');
$routes->post('update-password','Cart::updatePassword');
$routes->post('reset-password','Cart::resetPassword');

$routes->group('',['filter'=>'AuthCheck'],function($routes)
{
    $routes->get('dashboard','Home::dashboard');
    $routes->get('customer-orders','Home::orders');
    $routes->get('view/(:any)','Home::viewOrder/$1');
    $routes->get('products','Home::products');
    $routes->get('new','Home::newProduct');
    $routes->get('edit/(:any)','Home::editProduct/$1');
    $routes->get('members','Home::members');
    $routes->get('edit-account/(:any)','Home::editAccount/$1');
    $routes->get('sales-report','Home::salesReport');
    $routes->get('account-settings','Home::account');
    $routes->get('settings','Home::settings');
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
    $routes->get('view-order/(:any)','Cart::viewOrder/$1');
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
