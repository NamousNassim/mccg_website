<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarrakechController;
use App\Http\Controllers\CasablancaController;
use App\Http\Controllers\DubaiController;


Route::get('/', [HomeController::class, 'index'])->name('accueil');
Route::get('/a-propos', [HomeController::class, 'about'])->name('a-propos');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');
Route::get('/confidentialite', [HomeController::class, 'privacy'])->name('confidentialite');
Route::get('/conditions', [HomeController::class, 'terms'])->name('conditions');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

Route::get("/marrakech", [MarrakechController::class,"index"])->name("marrakech");
Route::get("/dubai", [DubaiController::class,"index"])->name("dubai");
Route::get("/casablanca", [CasablancaController::class,"index"])->name("casablanca");

