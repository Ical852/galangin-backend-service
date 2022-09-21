<?php

use App\Http\Controllers\CampaignCommentsServiceController;
use App\Http\Controllers\CampaignDonationServiceController;
use App\Http\Controllers\CampaignNewsCommentsServiceController;
use App\Http\Controllers\CampaignNewsServiceController;
use App\Http\Controllers\CampaignServiceController;
use App\Http\Controllers\CategoryServiceController;
use App\Http\Controllers\CollabCampaignServiceController;
use App\Http\Controllers\NotificationServiceController;
use App\Http\Controllers\ReplyServiceController;
use App\Http\Controllers\UserServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function() {
    Route::post('logout', [UserServiceController::class, 'logout']);
    Route::get('user', [UserServiceController::class, 'fetch']);
    Route::post('user', [UserServiceController::class, 'update']);
    Route::post('user/photo', [UserServiceController::class, 'updatePhoto']);
});

Route::post('signin', [UserServiceController::class, 'signin']);
Route::post('signup', [UserServiceController::class, 'signup']);

Route::post('reply', [ReplyServiceController::class, 'create']);
Route::post('reply/{id}', [ReplyServiceController::class, 'update']);
Route::delete('reply/{id}', [ReplyServiceController::class, 'delete']);
Route::get('reply/{id}', [ReplyServiceController::class, 'getById']);

Route::post('notif', [NotificationServiceController::class, 'create']);
Route::post('notif/{id}', [NotificationServiceController::class, 'update']);
Route::get('notif/user/{id}', [NotificationServiceController::class, 'getByUserId']);
Route::get('notif/{id}', [NotificationServiceController::class, 'getById']);

Route::post('collab', [CollabCampaignServiceController::class, 'create']);
Route::delete('collab/{id}', [CollabCampaignServiceController::class, 'delete']);
Route::get('collab/{id}', [CollabCampaignServiceController::class, 'getById']);
Route::get('collab/user/{id}', [CollabCampaignServiceController::class, 'getByUserId']);
Route::get('collab/campaign/{id}', [CollabCampaignServiceController::class, 'getByCampaignId']);

Route::get('category', [CategoryServiceController::class, 'getAll']);

Route::post('campaign', [CampaignServiceController::class, 'create']);
Route::get('campaign', [CampaignServiceController::class, 'getAll']);
Route::post('campaign/{id}', [CampaignServiceController::class, 'update']);
Route::post('campaign/photo/{id}', [CampaignServiceController::class, 'updatePhoto']);
Route::delete('campaign/{id}', [CampaignServiceController::class, 'delete']);
Route::get('campaign/{id}', [CampaignServiceController::class, 'getById']);
Route::get('campaign/cat/{id}', [CampaignServiceController::class, 'getByCategoryId']);
Route::get('campaign/user/{id}', [CampaignServiceController::class, 'getByUserId']);

Route::post('news', [CampaignNewsServiceController::class, 'create']);
Route::post('news/{id}', [CampaignNewsServiceController::class, 'update']);
Route::delete('news/{id}', [CampaignNewsServiceController::class, 'delete']);
Route::get('news/{id}', [CampaignNewsServiceController::class, 'getById']);
Route::get('news/campaign/{id}', [CampaignNewsServiceController::class, 'getByCampaignId']);

Route::post('newscomments', [CampaignNewsCommentsServiceController::class, 'create']);
Route::post('newscomments/{id}', [CampaignNewsCommentsServiceController::class, 'update']);
Route::delete('newscomments/{id}', [CampaignNewsCommentsServiceController::class, 'delete']);
Route::get('newscomments/{id}', [CampaignNewsCommentsServiceController::class, 'getById']);
Route::get('newscomments/campaign/{id}', [CampaignNewsCommentsServiceController::class, 'getByCampaignNewsId']);

Route::post('donation', [CampaignDonationServiceController::class, 'create']);
Route::get('donation/{id}', [CampaignDonationServiceController::class, 'getById']);
Route::get('donation/user/{id}', [CampaignDonationServiceController::class, 'getByUserId']);

Route::post('comment', [CampaignCommentsServiceController::class, 'create']);
Route::post('comment/{id}', [CampaignCommentsServiceController::class, 'update']);
Route::delete('comment/{id}', [CampaignCommentsServiceController::class, 'delete']);
Route::get('comment/{id}', [CampaignCommentsServiceController::class, 'getById']);
Route::get('comment/campaign/{id}', [CampaignCommentsServiceController::class, 'getByCampaignId']);