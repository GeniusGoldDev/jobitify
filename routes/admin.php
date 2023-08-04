<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// Admin related routes
Route::prefix('admin')->middleware(['auth','role:admin'])->group(function () {
    
    Route::get('project-categories',    App\Http\Livewire\Admin\Taxonomies\ProjectCategories\ProjectCategories::class)->name('project-categories');
    Route::get('gig-categories',        App\Http\Livewire\Admin\Taxonomies\GigCategories\GigCategories::class)->name('gig-categories');
    Route::get('skills',                App\Http\Livewire\Admin\Taxonomies\Skills\Skills::class)->name('skills');
    Route::get('project-duration',      App\Http\Livewire\Admin\Taxonomies\ProjectDuration\ProjectDurations::class)->name('project-duration');
    Route::get('tags',                  App\Http\Livewire\Admin\Taxonomies\Tags\Tags::class)->name('tags');
    Route::get('gig-delivery-time',     App\Http\Livewire\Admin\Taxonomies\GigDeliveryTime\DeliveryTime::class)->name('gig-delivery-time');
    Route::get('languages',             App\Http\Livewire\Admin\Taxonomies\Languages\Languages::class)->name('languages');
    Route::get('project-location',      App\Http\Livewire\Admin\Taxonomies\ProjectLocations\ProjectLocations::class)->name('project-location');
    Route::get('expert-levels',         App\Http\Livewire\Admin\Taxonomies\ExpertLevels\ExpertLevels::class)->name('expert-levels');
    Route::get('packages-setting',      App\Http\Livewire\Admin\Packages\Packages::class)->name('packages-setting');
    Route::get('commission-settings',   App\Http\Livewire\Admin\Settings\CommissionSettigns::class)->name('commission-settings');
    Route::get('payment-methods',       App\Http\Livewire\Admin\Settings\PaymentMethods::class)->name('payment-methods');
    Route::get('projects',              App\Http\Livewire\Admin\Projects\Projects::class)->name('projects');
    Route::get('proposals',             App\Http\Livewire\Admin\Proposals\Proposals::class)->name('proposals');
    Route::get('gigs',                  App\Http\Livewire\Admin\Gigs\Gigs::class)->name('gigs');
    Route::get('gig-orders',            App\Http\Livewire\Admin\Gigs\GigOrders::class)->name('admin-gig-orders');
    Route::get('users',                 App\Http\Livewire\Admin\Users\Users::class)->name('users');
    Route::get('earnings',              App\Http\Livewire\Admin\Earnings\Earnings::class)->name('admin-earnings');
    Route::get('email-settings',        App\Http\Livewire\Admin\EmailTemplates\EmailTemplates::class)->name('EmailTemplates');
    Route::get('dispute-view',          App\Http\Livewire\Admin\Disputes\DisputeDetail::class)->name('dispute-view');
    Route::get('manage-menu',           App\Http\Livewire\Admin\Menu\ManageMenu::class)->name('manage-menu');
    Route::get('withdraw-requests',     App\Http\Livewire\Admin\WithdrawRequests\WithdrawRequest::class)->name('withdraw-requests');
    Route::get('disputes',              App\Http\Livewire\Admin\Disputes\Disputes::class)->name('disputes');
    Route::get('site-pages',            App\Http\Livewire\Admin\SitePages\SitePages::class)->name('SitePages');
    Route::get('pages/{id}/build',      [App\Http\Controllers\Pagebuilder\PageBuilderController::class, 'build'])->name('pagebuilder.build');
    Route::any('profile',               App\Http\Livewire\Admin\AdminProfile\AdminProfile::class)->name('profile');
    Route::post('update-sass-style',    [App\Http\Controllers\Admin\GeneralController::class, 'updateSaas']);
});




