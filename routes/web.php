<?php

use App\Http\Livewire\Gig\GigList;

use App\Http\Livewire\Gig\GigOrders;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Gig\GigCreation;
use App\Http\Livewire\Earnings\Invoices;
use App\Http\Livewire\Packages\Packages;
use App\Http\Livewire\Components\Checkout;
use App\Http\Livewire\Project\DisputeList;
use App\Http\Livewire\Project\DisputeDetail;
use App\Http\Livewire\Project\ProjectDetail;
use App\Http\Controllers\Site\SiteController;
use App\Http\Livewire\Earnings\InvoiceDetail;
use App\Http\Livewire\Project\ProjectListing;
use App\Http\Livewire\Project\ProjectActivity;
use App\Http\Livewire\Project\ProjectCreation;
use App\Http\Livewire\Proposal\ProposalDetail;
use App\Http\Controllers\Gig\GigCartController;
use App\Http\Livewire\Project\ProjectProposals;
use App\Http\Controllers\Gig\GigDetailController;
use App\Http\Controllers\Seller\ProfileController;
use App\Http\Livewire\Proposal\ProposalSubmission;
use App\Http\Controllers\Webhook\WebhookController;
use App\Http\Livewire\FavouriteItems\FavouriteItems;
use App\Http\Livewire\ProfileSettings\ProfileSettings;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\SearchItem\SearchItemController;
use App\Http\Controllers\Pagebuilder\PageBuilderController;
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

// set language
Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});

// clear cache
Route::get('/clear-cache', function() {
    clearCache();
    return redirect()->back();
});

// Admin related routes
require __DIR__.'/admin.php';

// Buyer related routes
Route::middleware(['auth','role:buyer', 'verified'])->group(function () {
    Route::get('create-project',            ProjectCreation::class)->name('create-project');
    Route::get('project/{slug}/proposals',  ProjectProposals::class)->name('project-proposals');
    Route::get('gig-cart/{slug}',           [GigCartController::class, 'index'])->name('gig-cart');
});

// Seller related routes
Route::middleware(['auth','role:seller', 'verified'])->group(function () {
    Route::get('{slug}/submit-proposal',    ProposalSubmission::class)->name('submit-proposal');
    Route::get('create-gig',                GigCreation::class)->name('create-gig');
    Route::get('gigs-listing',              GigList::class)->name('gig-list');
    
});

// Seller/Buyer routes
Route::middleware(['auth','role:buyer|seller', 'verified'])->group(function () {
    Route::get('dashboard',                             [DashboardController::class,'index'] )->name('dashboard');
    Route::get('project-activity/{slug}',               ProjectActivity::class )->name('project-activity');
    Route::get('settings',                              ProfileSettings::class )->name('settings');
    Route::get('projects',                              ProjectListing::class )->name('project-listing');
    Route::get('dispute-detail',                        DisputeDetail::class )->name('dispute-detail');
    Route::get('dispute-list',                          DisputeList::class )->name('dispute-list');
    Route::get('invoice-detail',                        InvoiceDetail::class )->name('invoice-detail');
    Route::get('invoices',                              Invoices::class )->name('invoices');
    Route::get('packages',                              Packages::class )->name('packages');
    Route::get('checkout',                              Checkout::class)->name('checkout');
    Route::get('favourite-items',                       FavouriteItems::class)->name('favourite-items');
    Route::post('switch-role',                          [SiteController::class, 'switchRole'])->name('switch-role');
    Route::get('gig-activity/{slug}',                   [ App\Http\Controllers\Gig\GigActivityController::class, 'index' ])->name('gig-activity');
    Route::post('gig-order-complete',                   [ App\Http\Controllers\Gig\GigActivityController::class, 'GigOrderCompletion' ]);
    Route::post('gig-order-dispute',                    [ App\Http\Controllers\Gig\GigActivityController::class, 'GigOrderDispute' ]);
    Route::get('raise-admin-dispute/{id}',              [ App\Http\Controllers\Gig\GigActivityController::class, 'RaiseDisputeToAdmin' ]);
    Route::get('gig-orders',                            GigOrders::class)->name('gig-orders');
});

Route::get('project/{slug}/proposal-detail/{id}',   ProposalDetail::class )->middleware(['auth', 'verified'])->name('proposal-detail');
Route::post('favourite-item',                       [ GigDetailController::class, 'favouriteItem' ])->name('favourite-item');

// Escrow webhook
Route::post('escrow-transaction-updates',   [WebhookController::class, 'EscrowTransactionUpdates']);

// General routes
Route::get('search-projects',           [SearchItemController::class, 'searchProjects'])->name('search-projects');
Route::get('search-sellers',            [SearchItemController::class, 'searchSellers'])->name('search-sellers');
Route::get('search-gigs',               [SearchItemController::class,'index'])->name('search-gigs');
Route::get('project/{slug}',            ProjectDetail::class)->name('project-detail');

Route::get('seller/{slug}',             [ProfileController::class,'index'] )->name('seller-profile');


Route::get('gig-detail/{slug}',         [GigDetailController::class, 'index'])->name('gig-detail');
Route::post('upload-image',             [PageBuilderController::class, 'uploadImage' ])->middleware(['auth', 'verified'])->name('upload-image');
require __DIR__.'/auth.php';
require __DIR__.'/optionbuilder.php';


Route::any('{uri}',   [SiteController::class, 'index'])->where('uri', '.*')->name('page');


