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
$routes->get('/', 'Login::index');
$routes->get('/hello', 'Hello::index');

$routes->get('/registration', 'Registration::index');
$routes->post('/registration/register', 'Registration::register');

$routes->get('/login', 'Login::index');
$routes->post('/login/check_login', 'Login::check_login');
$routes->get('/login/logout', 'Login::logout');

$routes->get('/home', 'Home::index');

// Post details and feed
$routes->get('home/course_posts/(:num)', 'Home::course_posts/$1');
$routes->get('home/post_details/(:num)', 'Home::post_details/$1');
$routes->post('home/add_comment', 'Home::add_comment');
$routes->get('search', 'Search::index');
$routes->get('home/bookmarks', 'Home::bookmarks');

$routes->get('search/suggestions', 'Search::suggestions');
$routes->post('favourites/toggle', 'Favourites::toggle');

// Create Post
$routes->get('home/create_post', 'Home::create_post');
$routes->post('home/check_post', 'Home::check_post');

// Edit Profile
$routes->get('profile/edit', 'Profile::edit');
$routes->post('profile/update', 'Profile::update');



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
