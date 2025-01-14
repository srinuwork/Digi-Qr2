<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrCodeController;


Route::get('/', function () {
    return view ('qrcode');
});

Route::post('/generate-qr-code', [QrCodeController::class, 'generateQrCode']);
