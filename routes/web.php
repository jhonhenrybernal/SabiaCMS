<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SitemapController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminMessageController;
use App\Http\Controllers\Admin\AdminSeoController;
use App\Http\Controllers\Admin\AdminRobotsController;
use App\Http\Controllers\Admin\AdminSitemapController;
use App\Http\Controllers\Admin\AdminMenuController;
use App\Http\Controllers\Admin\AdminAdSenseController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('/dashboard', function () {
    return redirect('/admin');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/robots.txt', [RobotsController::class, 'show'])->name('robots.public');
Route::get('/sitemap.xml', [SitemapController::class, 'show'])->name('sitemap.public');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');

    Route::resource('messages', AdminMessageController::class);

    Route::get('seo', [AdminSeoController::class, 'edit'])->name('seo.edit');
    Route::post('seo', [AdminSeoController::class, 'update'])->name('seo.update');

    Route::get('robots', [AdminRobotsController::class, 'edit'])->name('robots.edit');
    Route::post('robots', [AdminRobotsController::class, 'update'])->name('robots.update');
    Route::post('robots/reset', [AdminRobotsController::class, 'reset'])->name('robots.reset');
    
    Route::get('sitemap', [AdminSitemapController::class, 'edit'])->name('sitemap.edit');
    Route::post('sitemap', [AdminSitemapController::class, 'update'])->name('sitemap.update');

    Route::resource('menu', AdminMenuController::class)->except(['show']);

    Route::get('telescope', fn () => redirect('/telescope'))->name('telescope');
    Route::get('telescope-panel', [AdminTelescopeController::class, 'index'])->name('telescope.panel');
    
    Route::get('adsense', [AdminAdSenseController::class, 'edit'])->name('adsense.edit');
    Route::post('adsense', [AdminAdSenseController::class, 'update'])->name('adsense.update');

});

require __DIR__.'/settings.php';
