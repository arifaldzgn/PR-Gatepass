<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\Process\Process;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\GatePassController;
use App\Http\Controllers\PartListController;

use App\Http\Controllers\AssetCodeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PrRequestController;
use Symfony\Component\Process\Exception\ProcessFailedException;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('testget/{id}', [PrRequestController::class, 'test']);

// Route::get('/send-test-email', [MailController::class, 'sendTestEmail'])->name('send.test.email');

// Route::get('/generate-pdf', [PdfController::class, 'generatePdf'])->name('pdf.generate');

Route::get('/generate-pdf', function () {
    dd($serverIpAddress = getHostByName(gethostname()) . ":8000" );
});



Route::get('/', function () {
    return redirect('/login');
});

// Auth
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

// Printed Ticket
Route::get('/printTicket/{ticketCode}', [PrRequestController::class, 'print'])->name('printTicket');
Route::get('/print_gatepass/{ticket}', [GatePassController::class, 'gatepassPrinted'])->name('gatepassPrinted');
Route::get('/search_gatepass', [GatePassController::class, 'searchGatepass'])->name('searchGatepass');

Route::group(['middleware' => 'auth'], function () {

    // Main menu
    Route::get('/menu', [DashboardController::class, 'menu']);

    // GatePass ~
        Route::get('/gatepass', [GatePassController::class, 'index'])->name('gatepass');
        Route::post('/gatepass', [GatePassController::class, 'create_gatepass'])->name('create_gatepass');
        Route::get('/gatepass_pending', [GatePassController::class, 'gatepassPending'])->name('gatepassPending');
        Route::get('/gatepass_approved', [GatePassController::class, 'gatepassApproved'])->name('gatepassApproved');
        Route::get('/gatepass_rejected', [GatePassController::class, 'gatepassRejected'])->name('gatepassRejected');
        Route::get('/edit_gatepass/{ticket}', [GatePassController::class, 'gatepassEdit'])->name('gatepassEdit');
        Route::get('/verif_gatepass/{ticket}', [GatePassController::class, 'gatepassVerif'])->name('gatepassVerif');
        Route::post('/edit_gatepass', [GatePassController::class, 'gatepassUpdate'])->name('gatepassUpdate');
        Route::post('/verif_gatepass', [GatePassController::class, 'gatepassUpdate2'])->name('gatepassUpdate2');
        Route::delete('/delete_gatepass/{ticket}', [GatePassController::class, 'gatepassDelete'])->name('gatepassDelete');
    // End Of GatePass ~

    // PR Request
        // Auth
        Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');

        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('account', [DashboardController::class, 'account'])->name('account');
        Route::post('account', [DashboardController::class, 'create_account'])->name('create_account');
        Route::get('get-user-details/{id}', [DashboardController::class, 'user_details'])->name('user_details');
        Route::post('/update-user-details', [DashboardController::class, 'update_account'])->name('update_account');
        Route::delete('/account/{id}', [DashboardController::class, 'delete_account']);

        // Partlist Controller
        Route::get('partlist', [PartListController::class, 'index'])->name('partlist');
        Route::post('partlist', [PartListController::class, 'create'])->name('create_partlist');
        Route::post('refund_stock', [PartListController::class, 'refundStock'])->name('refund_stock');
        Route::delete('/partlist/{id}', [PartListController::class, 'delete_part']);
        Route::get('/get-part-details/{id}', [PartListController::class, 'getPartDetails']);
        Route::post('/update-part-details', [PartListController::class, 'updatePartList']);

        // Asset Code Controller
        Route::get('assetcode', [AssetCodeController::class, 'index'])->name('assetcode');
        Route::post('assetcode', [AssetCodeController::class, 'create'])->name('create_assetcode');
        Route::delete('/assetcode/{id}', [AssetCodeController::class, 'delete_asset']);

        // PR Handler
        Route::get('pr_request', [PrRequestController::class, 'index'])->name('pr_request');
        Route::post('ticket', [PrRequestController::class, 'create'])->name('pr_request_create');
        Route::get('/retrieve-part-details', [PrRequestController::class, 'retrievePartDetails'])->name('retrieve.part.details');
        Route::get('/retrieve-part-name/{id}', [PrRequestController::class, 'retrievePartName'])->name('retrieve.part.name');
        // Pending Ticket
        Route::get('/pending', [PrRequestController::class, 'pending'])->name('pending');
        // Approved Ticket
        Route::get('/approved', [PrRequestController::class, 'approved'])->name('approved');
        // Rejected Ticket
        Route::get('/rejected', [PrRequestController::class, 'rejected'])->name('rejected');
        Route::get('/ticketDetails/{id}', [PrRequestController::class, 'show'])->name('ticketDetails');
        Route::post('/updateTicket', [PrRequestController::class, 'update']);
        Route::post('/updateTicketR', [PrRequestController::class, 'updateR']);
        Route::delete('/ticket/{id}', [PrRequestController::class, 'destroy']);
        Route::PUT('/ticket/{id}/reject', [PrRequestController::class, 'rejectTicket']);
        Route::PUT('/ticket/{id}/approve', [PrRequestController::class, 'approveTicket'])->name('approveTicket');
        Route::get('/printPdf/{ticketCode}', [PrRequestController::class, 'printPdf'])->name('printPdf');
        // Delete individual part from request
        Route::delete('/delete-part/{id}', [PrRequestController::class, 'destroyPart']);

        // Log
        Route::get('/log', [LogController::class, 'index'])->name('log');
    // End Of PR Request ~

});


// Route::get('/test', [PrRequestController::class, 'test']);
