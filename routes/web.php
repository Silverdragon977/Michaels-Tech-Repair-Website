<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::view('/', 'home')->name('home');

Route::view('/about', 'about')->name('about');

Route::view('/contact', 'contact')->name('contact');

// ==========================================
// SERVICE ROUTES
// ==========================================

Route::view(
    '/services/computer-repair',
    'services.computerRepair'
)->name('services.computer-repair');


Route::view(
    '/services/virus-removal',
    'services.virusRemoval'
)->name('services.virus-removal');


Route::view(
    '/services/home-tech-setup',
    'services.homeTechSetup'
)->name('services.home-tech-setup');


Route::view(
    '/services/device-troubleshooting',
    'services.troubleshootingDevices'
)->name('services.device-troubleshooting');


Route::view(
    '/services/website-creation',
    'services.websiteCreationAndMaintenance'
)->name('services.website-creation');


Route::view(
    '/services/pc-builds',
    'services.pcBuildsAndUpgrades'
)->name('services.pc-builds');


Route::view(
    '/services/media-servers',
    'services.mediaServerSetup'
)->name('services.media-servers');


Route::view(
    '/services/network-setup',
    'services.networkSetup'
)->name('services.network-setup');


Route::view(
    '/services/cloud-server-administration',
    'services.cloudAndServerAdministration'
)->name('services.cloud-server-administration');

// END SERVICE ROUTES
// ==========================================
// CONTACT ME ROUTES

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,10')
    ->name('contact.store');

// END OF CONTACT ME ROUTES