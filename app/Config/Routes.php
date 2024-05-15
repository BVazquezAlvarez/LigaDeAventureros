<?php
// LigaDeAventureros
// Copyright (C) 2023-2024 Santiago González Lago

// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.

// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <https://www.gnu.org/licenses/>.

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
$routes->setTranslateURIDashes(true);
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
$routes->get('/privacy', 'Home::privacy');
$routes->get('/contact', 'Home::contact');
$routes->post('/contact', 'Home::contact_post');

$routes->post('login', 'Login::login');
$routes->post('login/onetap', 'Login::onetap');
$routes->get('login/google', 'Login::google');
$routes->get('logout', 'Login::logout');

$routes->get('settings','Profile::settings');
$routes->post('settings','Profile::settings_post');
$routes->post('settings/email','Profile::settings_email');
$routes->post('settings/delete-account','Profile::delete_account');
$routes->get('profile/(:segment)','Profile::index/$1');
$routes->get('profile','Profile::index');

$routes->get('character/(:segment)','Character::index/$1');
$routes->get('all-characters', 'Character::all_characters');
$routes->post('new-character', 'Character::new_character');
$routes->post('update-character', 'Character::update_character');
$routes->get('character/(:segment)/enable', 'Character::enable/$1');
$routes->get('character/(:segment)/disable', 'Character::disable/$1');
$routes->post('character/delete', 'Character::delete');
$routes->get('new-player-help', 'Character::new_player_help');

$routes->post('adventure/data-ajax', 'Adventure::data_ajax');

$routes->get('calendar', 'Session::calendar');
$routes->get('calendar/(:segment)/(:segment)', 'Session::calendar/$1/$2');
$routes->get('session/view/(:segment)', 'Session::view/$1');

$routes->post('session/join', 'Session::join');
$routes->post('session/swap', 'Session::swap');
$routes->post('session/cancel', 'Session::cancel');

$routes->get('master', 'Master::index');
$routes->post('master/kick', 'Master::kick');
$routes->get('master/sheets', 'Master::sheets');
$routes->post('master/validate-sheet', 'Master::validate_sheet');
$routes->post('master/reject-sheet', 'Master::reject_sheet');
$routes->post('master/define-logsheet', 'Master::define_logsheet');
$routes->get('master/adventures', 'Master::adventures');
$routes->post('master/adventures', 'Master::adventures_post');
$routes->get('master/adventure/(:segment)', 'Master::adventure/$1');
$routes->get('master/edit-adventure/(:segment)', 'Master::edit_adventure/$1');
$routes->post('master/edit-adventure/(:segment)', 'Master::edit_adventure_post/$1');
$routes->get('master/new-session', 'Master::new_session');
$routes->post('master/new-session', 'Master::new_session_post');
$routes->get('master/publish', 'Master::publish');
$routes->post('master/publish', 'Master::publish_post');
$routes->post('master/delete-session', 'Master::delete_session');
$routes->get('master/edit-session/(:segment)', 'Master::edit_session/$1');
$routes->post('master/edit-session/(:segment)', 'Master::edit_session_post/$1');
$routes->get('master/logsheets', 'Master::logsheets');
$routes->post('master/logsheet_create', 'Master::logsheet_create');
$routes->post('master/logsheet_create_standalone', 'Master::logsheet_create_standalone');

$routes->get('admin', 'Admin::index');
$routes->get('admin/logs', 'Admin::logs');
$routes->get('admin/logs/(:segment)', 'Admin::logs/$1');
$routes->post('admin/logs', 'Admin::logs_post');
$routes->get('admin/settings', 'Admin::settings');
$routes->post('admin/settings', 'Admin::settings_post');
$routes->get('admin/users', 'Admin::users');
$routes->get('admin/users/(:segment)', 'Admin::users/$1');
$routes->get('admin/user_login/(:segment)', 'Admin::user_login/$1');
$routes->get('admin/logout', 'Login::return_to_real_user');
$routes->post('admin/user-toggle-master', 'Admin::user_toggle_master');
$routes->post('admin/user-toggle-admin', 'Admin::user_toggle_admin');
$routes->post('admin/user-ban', 'Admin::user_ban');
$routes->post('admin/user-unban', 'Admin::user_unban');

$routes->get('admin/merchants', 'Admin::merchants');
$routes->get('admin/merchants/(:segment)', 'Admin::merchants/$1');
$routes->post('admin/new-merchant', 'Admin::new_merchant');
$routes->post('admin/delete-merchant', 'Admin::delete_merchant');
$routes->get('admin/edit-merchant/(:segment)', 'Admin::edit_merchant/$1');
$routes->post('admin/edit-merchant/(:segment)', 'Admin::edit_merchant_post/$1');
$routes->get('admin/merchants-auto', 'Admin::merchants_auto');
$routes->get('admin/merchants-auto/(:segment)', 'Admin::merchants_auto/$1');
$routes->post('admin/new-automatic-merchant', 'Admin::new_automatic_merchant');
$routes->post('admin/edit-automatic-merchant', 'Admin::edit_automatic_merchant');
$routes->post('admin/toggle-automatic-merchant', 'Admin::toggle_automatic_merchant');
$routes->post('admin/delete-automatic-merchant', 'Admin::delete_automatic_merchant');

$routes->get('marketplace', 'Marketplace::index');
$routes->post('marketplace/change-active-character', 'Marketplace::change_active_character');
$routes->post('marketplace/buy', 'Marketplace::buy');

$routes->get('cron/delete-sheets', 'Cron::delete_sheets');
$routes->get('cron/delete-adventure-thumbnails', 'Cron::delete_adventure_thumbnails');
$routes->get('cron/delete-accounts-requested', 'Cron::delete_accounts_requested');
$routes->get('cron/delete-accounts-inactive', 'Cron::delete_accounts_inactive');
$routes->get('cron/delete-character-images', 'Cron::delete_character_images');
$routes->get('cron/automatic-merchants', 'Cron::automatic_merchants');

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
