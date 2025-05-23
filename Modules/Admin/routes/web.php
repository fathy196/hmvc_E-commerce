<?php

use App\Exports\ProductExport;
use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Controllers\CategoryController;
use Modules\Admin\Http\Controllers\ProductController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('admins', AdminController::class)->names('admin');
});
Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('products/export', [ProductController::class, 'export'])->name('products.export');
    Route::post('products/import', [ProductController::class, 'import'])->name('products.import');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);

});
Route::get('/test-export', function() {
    if (class_exists(ProductExport::class)) {
        return "Class exists!";
    }
    return "Class NOT found!";
});