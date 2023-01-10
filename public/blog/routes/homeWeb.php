<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;


Route::get('our-products', [HomeController::class, 'getOurProducts'])->name('our.products');
Route::get('about-us', [HomeController::class, 'getAboutUs'])->name('about.us');
Route::get('contact-us', [HomeController::class, 'getContactUs'])->name('contact.us');

Route::post('contact-us-send', [HomeController::class, 'sendContactUs'])->name('contact.us.form.send');
Route::post('newsletter-send', [HomeController::class, 'sendNewsletter'])->name('newsletter.send');

Route::group(['prefix' => 'product'], function () {
    Route::get('/{?slug}', [HomeController::class, 'getCorrugatedBox'])->name('product_slug');
    Route::get('corrugated-box', [HomeController::class, 'getCorrugatedBox'])->name('corrugated.box');
    Route::get('paper-core', [HomeController::class, 'getPaperCore'])->name('paper.core');
    Route::get('angle-boards', [HomeController::class, 'getAngleBoards'])->name('angle.boards');
    Route::get('paper-courier', [HomeController::class, 'getPaperCourier'])->name('paper.courier');
});

Route::post('save-contact', [HomeController::class, 'saveContact'])->name('save.contact');