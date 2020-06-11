<?php

use App\Section;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::phase('/', 'DocsController@LandingPage');
Route::redirect('/docs', '/docs/master/getting-started');
Route::phase(
    '/docs/{version}/{section?}',
    'DocsController@DocumentationHandler'
);

Route::get('/search', 'DocsController@SearchHandler');
