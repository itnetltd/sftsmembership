<?php

use Illuminate\Support\Facades\Route;

/* -----------------------------
|  Controllers (user area)
|------------------------------*/
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PaymentController; // member billing

/* -----------------------------
|  Controllers (admin area)
|------------------------------*/
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\ApplicationReviewController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;

/* -----------------------------
|  Payment callbacks / webhooks
|------------------------------*/
use App\Http\Controllers\Webhook\FlutterwaveWebhookController;
use App\Http\Controllers\Webhook\MtnMomoWebhookController;

/* -----------------------------
|  Landing / Dashboard
|------------------------------*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/* -----------------------------
|  Authenticated user routes
|------------------------------*/
Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Applications (create/submit/view)
    Route::get('/application', [ApplicationController::class, 'create'])->name('application.create');
    Route::post('/application', [ApplicationController::class, 'store'])->name('application.store');
    Route::get('/application/{app}', [ApplicationController::class, 'show'])->name('application.show');

    // Documents (upload + delete)
    Route::post('/application/{app}/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::delete('/documents/{doc}', [DocumentController::class, 'destroy'])->name('documents.destroy');

    // Billing (member)
    Route::get('/billing', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/billing/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/billing', [PaymentController::class, 'store'])->name('payments.store');

    // Refresh a single payment status (MoMo poll)
    Route::post('/billing/{payment}/refresh', [PaymentController::class, 'refresh'])
        ->name('payments.refresh');

    // Optional return url (used by card/other providers)
    Route::get('/billing/callback', [PaymentController::class, 'callback'])
        ->name('payments.callback');
});

/* -----------------------------
|  Admin area
|------------------------------*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Applications
        Route::get('/applications', [AdminApplicationController::class, 'index'])->name('apps.index');
        Route::get('/applications/{app}', [AdminApplicationController::class, 'show'])->name('apps.show');
        Route::post('/applications/{app}/approve', [AdminApplicationController::class, 'approve'])->name('apps.approve');
        Route::post('/applications/{app}/reject', [AdminApplicationController::class, 'reject'])->name('apps.reject');

        // Review controller
        Route::get('/review', [ApplicationReviewController::class, 'index'])->name('applications.index');
        Route::get('/review/{application}', [ApplicationReviewController::class, 'show'])->name('applications.show');
        Route::post('/review/{application}/status', [ApplicationReviewController::class, 'updateStatus'])->name('applications.updateStatus');

        // Payments (admin)
        Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/export', [AdminPaymentController::class, 'export'])->name('payments.export');
        Route::get('/payments/{payment}', [AdminPaymentController::class, 'show'])->name('payments.show');
        Route::post('/payments/{payment}/status', [AdminPaymentController::class, 'updateStatus'])->name('payments.updateStatus');
    });

/* -----------------------------
|  Payment Webhooks (public)
|  — CSRF-exempt via VerifyCsrfToken
|------------------------------*/
Route::post('/webhooks/flutterwave', [FlutterwaveWebhookController::class, 'handle'])
    ->name('webhooks.flutterwave');

Route::post('/webhooks/momo', [MtnMomoWebhookController::class, 'handle'])
    ->name('webhooks.momo');

/* Breeze auth scaffolding */
require __DIR__.'/auth.php';
