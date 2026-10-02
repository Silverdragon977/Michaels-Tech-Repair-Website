<?php

use Illuminate\Support\Facades\Route;

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
    'services.deviceTroubleshooting'
)->name('services.device-troubleshooting');


Route::view(
    '/services/website-creation',
    'services.websiteCreation'
)->name('services.website-creation');


Route::view(
    '/services/pc-builds',
    'services.pcBuilds'
)->name('services.pc-builds');


Route::view(
    '/services/media-servers',
    'services.mediaServers'
)->name('services.media-servers');


Route::view(
    '/services/network-setup',
    'services.networkSetup'
)->name('services.network-setup');


Route::view(
    '/services/cloud-server-administration',
    'services.cloudServerAdministration'
)->name('services.cloud-server-administration');

// END SERVICE ROUTES