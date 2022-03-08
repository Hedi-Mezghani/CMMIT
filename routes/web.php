<?php

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

/*Route::get('/home', function () {
    return view('welcome');
});*/

Route::get('/home/{y}','HomeController@index')->name('abc');


Route::get('/page1', function () {
    return "<h1>ceci est la page 1</h1>";
});

Route::get('/page2', function () {
    return "<h1>ceci est la page 2</h1>";
});

Route::get('/page3/{x}/test/{z?}', function ($a,$b=0) {
    return "<h1>Votre nom est ".$a."<br>Votre age est ".$b."</h1>";
});
//route exercice1
//Route::get('/{date}/{num}','OrderController@show')->name('show.order');

//route du site web exercice2
 Route::get('/','SiteController@accueil')->name('site.accueil');
 Route::get('/about','SiteController@about')->name('site.about');
 Route::get('/produitsfront/{category_id}','SiteController@produits')->name('site.produits');
 Route::get('/contact','SiteController@contact')->name('site.contact');
 Route::post('/contact/save','SiteController@save')->name('site.save');

 //route panier
 Route::post('/addpanier','SiteController@addpanier')->name('site.addpanier');
 Route::get('/panier','SiteController@panier')->name('site.panier');
 Route::get('/viderpanier','SiteController@viderpanier')->name('site.viderpanier');
 Route::get('/supplignepanier/{indice}','SiteController@supplignepanier')->name('site.supplignepanier');
 Route::get('/checkout','SiteController@checkout')->name('site.checkout');

 //backoffice
 //Route::middleware(['auth'])->group(function(){
Route::resource('categories','CategoriesController');
Route::resource('produits','ProduitsController');
 //});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
