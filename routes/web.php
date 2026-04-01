<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AdminChatController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\AdminGalleryController;
use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\BandInfoController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MerchController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// ═══════════════════════════════════════════════════════════════════════════════
// PUBLIC ROUTES
// ═══════════════════════════════════════════════════════════════════════════════

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Music
Route::prefix('music')->name('music.')->group(function () {
    Route::get('/', [MusicController::class, 'index'])->name('index');
    Route::get('/{slug}', [MusicController::class, 'show'])->name('show');
});

// Events
Route::get('/events', [EventController::class, 'index'])->name('events.index');

// Merch + Cart + Checkout
Route::prefix('merch')->name('merch.')->group(function () {
    Route::get('/', [MerchController::class, 'index'])->name('index');
    Route::get('/{slug}', [MerchController::class, 'show'])->name('show');
});

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::patch('/{key}', [CartController::class, 'update'])->name('update');
    Route::delete('/{key}', [CartController::class, 'remove'])->name('remove');
});

Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/', [CheckoutController::class, 'store'])->name('store');
});

Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Chat (customer side - accessed by room key from URL)
Route::prefix('chat')->name('chat.')->group(function () {
    Route::get('/{roomKey}', [ChatController::class, 'room'])->name('room');
    Route::post('/{roomKey}/send', [ChatController::class, 'send'])->name('send');
    Route::get('/{roomId}/messages', [ChatController::class, 'messages'])->name('messages');
});

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

// ═══════════════════════════════════════════════════════════════════════════════
// AUTH ROUTES (Laravel Breeze auto-generates login/register)
// ═══════════════════════════════════════════════════════════════════════════════

require __DIR__ . '/auth.php';

// ═══════════════════════════════════════════════════════════════════════════════
// ADMIN ROUTES (protected by auth middleware)
// ═══════════════════════════════════════════════════════════════════════════════

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Band info
    Route::get('/band-info', [BandInfoController::class, 'edit'])->name('band-info.edit');
    Route::put('/band-info', [BandInfoController::class, 'update'])->name('band-info.update');

    // Gallery
    Route::prefix('gallery')->name('gallery.')->group(function () {
        Route::get('/',                          [AdminGalleryController::class, 'index'])->name('index');
        Route::post('/',                         [AdminGalleryController::class, 'store'])->name('store');
        Route::patch('/{galleryItem}',           [AdminGalleryController::class, 'update'])->name('update');
        Route::delete('/{galleryItem}',          [AdminGalleryController::class, 'destroy'])->name('destroy');
        Route::post('/reorder',                  [AdminGalleryController::class, 'reorder'])->name('reorder');
    });

    // Members
    Route::resource('members', MemberController::class)->except(['show']);

    // Music / Albums
    Route::prefix('music')->name('music.')->group(function () {
        Route::get('/', [AlbumController::class, 'index'])->name('index');
        Route::get('/create', [AlbumController::class, 'create'])->name('create');
        Route::post('/', [AlbumController::class, 'store'])->name('store');
        Route::get('/{album}/edit', [AlbumController::class, 'edit'])->name('edit');
        Route::put('/{album}', [AlbumController::class, 'update'])->name('update');
        Route::delete('/{album}', [AlbumController::class, 'destroy'])->name('destroy');
        Route::post('/{album}/tracks', [AlbumController::class, 'storeTrack'])->name('tracks.store');
        Route::delete('/tracks/{track}', [AlbumController::class, 'destroyTrack'])->name('tracks.destroy');
        Route::get('/spotify/search', [AlbumController::class, 'spotifySearch'])->name('spotify.search');
    });

    // Events
    Route::resource('events', AdminEventController::class)->except(['show']);

    // Products & Variants
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
        Route::post('/{product}/variants', [ProductController::class, 'storeVariant'])->name('variants.store');
        Route::delete('/variants/{variant}', [ProductController::class, 'destroyVariant'])->name('variants.destroy');
        Route::post('/variants/{variant}/stock', [ProductController::class, 'adjustStock'])->name('variants.stock');
        Route::delete('/images/{image}', [ProductController::class, 'deleteImage'])->name('images.destroy');
        Route::post('/images/{image}/primary', [ProductController::class, 'setPrimaryImage'])->name('images.primary');
    });

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');

    // Contact messages
    Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
    Route::get('/contact-messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('contact-messages.show');
    Route::delete('/contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

    // Admin Chat
    Route::get('/chats', [AdminChatController::class, 'index'])->name('chats.index');
    Route::get('/chats/{chatRoom}', [AdminChatController::class, 'show'])->name('chats.show');
    Route::post('/chats/{chatRoom}/reply', [ChatController::class, 'adminReply'])->name('chats.reply');
    Route::patch('/chats/{chatRoom}/close', [AdminChatController::class, 'close'])->name('chats.close');
    Route::get('/chats/{chatRoom}/messages', [ChatController::class, 'messages'])->name('chats.messages');
});
