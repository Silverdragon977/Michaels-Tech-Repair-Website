<?php

use Illuminate\Support\Facades\Route;


Route::view('/', 'home');

Route::view('/services/computer-repair', 'services.computerRepair');