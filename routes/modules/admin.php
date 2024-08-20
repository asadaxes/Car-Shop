<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Generals;
use App\Http\Controllers\Admin\User;
use App\Http\Controllers\Admin\Brand;
use App\Http\Controllers\Admin\VehicleCategory;
use App\Http\Controllers\Admin\Vehicle;
use App\Http\Controllers\Admin\Campaign;
use App\Http\Controllers\Admin\PnA;
use App\Http\Controllers\Admin\Blog;

Route::middleware('auth', 'verified', 'active', 'admin')->group(function () {
    Route::get('/admin/dashboard', [Generals::class, 'dashboard'])->name('admin_dashboard');

    Route::get('/admin/users/list', [User::class, 'users_list'])->name('admin_users_list');
    Route::get('/admin/users/add', [User::class, 'users_add'])->name('admin_users_add');
    Route::post('/admin/users/add/handler', [User::class, 'users_add_handler'])->name('admin_users_add_handler');
    Route::get('/admin/users/view', [User::class, 'users_view'])->name('admin_users_view');
    Route::post('/admin/users/view/handler', [User::class, 'users_view_handler'])->name('admin_users_view_handler');
    Route::post('/admin/users/delete/account', [User::class, 'users_delete_account'])->name('admin_users_delete_account');

    Route::get('/admin/brands', [Brand::class, 'brands'])->name('admin_brands');
    Route::post('/admin/brands/add', [Brand::class, 'brands_add'])->name('admin_brands_add');
    Route::post('/admin/brands/remove', [Brand::class, 'brands_remove'])->name('admin_brands_remove');
    
    Route::get('/admin/vehicles/category', [VehicleCategory::class, 'vehicle_category'])->name('admin_vehicle_category');
    Route::post('/admin/vehicles/category/add', [VehicleCategory::class, 'vehicle_category_add'])->name('admin_vehicle_category_add');
    Route::post('/admin/vehicles/category/edit', [VehicleCategory::class, 'vehicle_category_edit'])->name('admin_vehicle_category_edit');
    Route::post('/admin/vehicles/category/delete', [VehicleCategory::class, 'vehicle_category_delete'])->name('admin_vehicle_category_delete');

    Route::get('/admin/vehicles/list', [Vehicle::class, 'vehicles_list'])->name('admin_vehicles_list');
    Route::get('/admin/vehicles/view', [Vehicle::class, 'vehicles_view'])->name('admin_vehicles_view');
    Route::post('/admin/vehicles/view/handler', [Vehicle::class, 'vehicles_view_handler'])->name('admin_vehicles_view_handler');
    Route::post('/admin/vehicles/delete', [Vehicle::class, 'vehicles_delete'])->name('admin_vehicles_delete');
    Route::post('/admin/vehicles/status-updater', [Vehicle::class, 'vehicles_status_updater'])->name('admin_vehicles_status_updater');

    Route::get('/admin/campaigns', [Campaign::class, 'campaigns'])->name('admin_campaigns');
    Route::post('/admin/campaigns/edit', [Campaign::class, 'campaigns_edit'])->name('admin_campaigns_edit');

    Route::get('/admin/pna/orders', [PnA::class, 'orders'])->name('admin_pna_orders');
    Route::post('/admin/pna/orders/status/updater', [PnA::class, 'orders_status_updater'])->name('admin_pna_orders_status_updater');
    Route::get('/admin/pna/brands', [PnA::class, 'brands'])->name('admin_pna_brands');
    Route::post('/admin/pna/brands/add', [PnA::class, 'brands_add'])->name('admin_pna_brands_add');
    Route::post('/admin/pna/brands/remove', [PnA::class, 'brands_remove'])->name('admin_pna_brands_remove');
    Route::get('/admin/pna/categories', [PnA::class, 'categories'])->name('admin_pna_categories');
    Route::post('/admin/pna/categories/add', [PnA::class, 'categories_add'])->name('admin_pna_categories_add');
    Route::post('/admin/pna/categories/remove', [PnA::class, 'categories_remove'])->name('admin_pna_categories_remove');
    Route::get('/admin/pna/inventory', [PnA::class, 'inventory'])->name('admin_pna_inventory');
    Route::get('/admin/pna/inventory/add', [PnA::class, 'inventory_add'])->name('admin_pna_inventory_add');
    Route::post('/admin/pna/inventory/add/handler', [PnA::class, 'inventory_add_handler'])->name('admin_pna_inventory_add_handler');
    Route::get('/admin/pna/inventory/edit', [PnA::class, 'inventory_edit'])->name('admin_pna_inventory_edit');
    Route::post('/admin/pna/inventory/edit/handler', [PnA::class, 'inventory_edit_handler'])->name('admin_pna_inventory_edit_handler');
    Route::post('/admin/pna/inventory/remove', [PnA::class, 'inventory_remove'])->name('admin_pna_inventory_remove');
    Route::get('/admin/pna/reviews', [PnA::class, 'reviews'])->name('admin_pna_reviews');
    Route::post('/admin/pna/reviews/remover', [PnA::class, 'reviews_remover'])->name('admin_pna_reviews_remover');
    Route::get('/admin/pna/config', [PnA::class, 'config'])->name('admin_pna_config');
    Route::post('/admin/pna/config/updater', [PnA::class, 'config_updater'])->name('admin_pna_config_updater');

    Route::get('/admin/blogs/list', [Blog::class, 'blogs_list'])->name('admin_blogs_list');
    Route::get('/admin/blogs/add', [Blog::class, 'blogs_add'])->name('admin_blogs_add');
    Route::post('/admin/blogs/add/handler', [Blog::class, 'blogs_add_handler'])->name('admin_blogs_add_handler');
    Route::get('/admin/blogs/edit', [Blog::class, 'blogs_edit'])->name('admin_blogs_edit');
    Route::post('/admin/blogs/edit/handler', [Blog::class, 'blogs_edit_handler'])->name('admin_blogs_edit_handler');
    Route::post('/admin/blogs/delete', [Blog::class, 'blogs_delete'])->name('admin_blogs_delete');

    Route::get('/admin/pages', [Generals::class, 'pages'])->name('admin_pages');
    Route::post('/admin/pages/add', [Generals::class, 'pages_add'])->name('admin_pages_add');
    Route::post('/admin/pages/edit', [Generals::class, 'pages_edit'])->name('admin_pages_edit');
    Route::post('/admin/pages/delete', [Generals::class, 'pages_delete'])->name('admin_pages_delete');

    Route::get('/admin/settings', [Generals::class, 'settings'])->name('admin_settings');
    Route::post('/admin/settings/updater', [Generals::class, 'settings_updater'])->name('admin_settings_updater');
});