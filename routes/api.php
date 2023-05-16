<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group.
|
*/

// Auth Endpoints
Route::group([
    'prefix' => 'v1/auth'
], function ($router) {
    
	Route::post('login', 'Auth\LoginController@login');
	Route::get('param', 'Auth\LoginController@loginWithUserId'); //from mobile login to a screen redirect to home
	// Route::get('user/{id}', 'Auth\LoginController@loginWithUserIdToMw');//from mobile login to a screen redirect to mw page
    Route::post('register', 'Auth\RegisterController@register');
	Route::post('password-reset', 'Auth\ResetPasswordController@reset');
	Route::post('password-reset-confirm', 'Auth\ResetPasswordController@passwordResetconfirm');
	Route::post('changePassword', 'Auth\ResetPasswordController@changePassword');
	Route::post('resetPassword', 'Auth\ResetPasswordController@resetPassword');
	Route::post('forgotPassword', 'Auth\ResetPasswordController@forgotPassword');
  
});

Route::group([ 'prefix' => 'v1'], function ($router) {

	
	Route::get('home', 'HomeController@home');
	Route::get('home/search/post/{chat_msg}', 'HomeController@home');
	Route::get('home/{chat_room_id}', 'HomeController@home')->middleware('auth');
	Route::get('sticky', 'HomeController@sticky');
	Route::post('userlist', 'HomeController@userlist');
	Route::post('thankyou', 'HomeController@thankyou');
	Route::get('postdetail/{id}', 'HomeController@postdetail');
	Route::get('mystore', 'HomeController@mystore');
	Route::get('notification', 'HomeController@notification');
	Route::get('notificationNew', 'HomeController@notificationNew');
	Route::get('notificationcheck', 'HomeController@notificationcheck');
	Route::get('notificationConversionFriend', 'HomeController@notificationConversionFriend');
	Route::get('getcategory', 'HomeController@getcategory');
	Route::get('getemoji', 'HomeController@getemoji');
	Route::post('postLounge', 'HomeController@postLounge');
	Route::post('postComment', 'HomeController@postComment');
	Route::post('commentReply', 'HomeController@commentReply');
	Route::get('myfavourites', 'HomeController@myfavourites');
	Route::get('bestoftheday', 'HomeController@bestoftheday');
	Route::post('bookmark', 'HomeController@bookMark');
	Route::get('user/{user_id}/myposts', 'HomeController@myposts');
	Route::post('flag', 'HomeController@flag');
	Route::get('flagAction', 'HomeController@flagAction');
	Route::get('tag', 'HomeController@tag');
	Route::get('hash', 'HomeController@hash');
	Route::post('removeChat', 'HomeController@removeChat');
	Route::get('getProfile', 'HomeController@getProfile');
	Route::post('updateProfile', 'HomeController@updateProfile');
	Route::get('getPlatinumDashboardV9', 'HomeController@getPlatinumDashboardV9');
	Route::post('getWhatNext', 'HomeController@getWhatNext');
	Route::get('getRechargeCredit', 'HomeController@getRechargeCredit');
	Route::get('radioJson', 'HomeController@radioJson');
	Route::get('userSongsJson', 'HomeController@userSongsJson');
	Route::get('getMyTradeRequest', 'HomeController@getMyTradeRequest');
	Route::get('getMyCollection', 'HomeController@getMyCollection');
	Route::get('getMyHistory', 'HomeController@getMyHistory');
	Route::get('getUserDataViaToken', 'HomeController@getUserDataViaToken');
	Route::post('giftThisProduct', 'HomeController@giftThisProduct');
	Route::post('tradeRequestAccept', 'HomeController@tradeRequestAccept');
	Route::post('tradeRequestReject', 'HomeController@tradeRequestReject');
	Route::get('getUser', 'HomeController@getUser');
	Route::post('editChat', 'HomeController@editChat');
	Route::post('mWStoreBuy', 'HomeController@mWStoreBuy');
	Route::post('likeCommentAndReply', 'HomeController@likeCommentAndReply');
	Route::post('getLike', 'HomeController@getLike');
	Route::post('deleteAccount', 'HomeController@deleteAccount');
	Route::get('userData', 'HomeController@userData');
	Route::get('tagList', 'HomeController@tagList');
	Route::post('assignTagToPost', 'HomeController@assignTagToPost');
	Route::post('chatMessage', 'HomeController@chatMessage');
	Route::get('myConversation/{friend_user_id}', 'HomeController@myConversation');
	Route::post('myConversationPost', 'HomeController@myConversationPost');
	Route::post('conversationReply', 'HomeController@conversationReply');
	Route::post('conversationRemove', 'HomeController@conversationRemove');
	Route::get('advanceEditorGet', 'HomeController@advanceEditorGet');
	Route::post('advanceEditorPost', 'HomeController@advanceEditorPost');
	Route::get('getAllUserList', 'HomeController@getAllUserList');
	Route::post('postBump', 'HomeController@postBump');
	Route::post('postLock', 'HomeController@postLock');
	Route::post('removePostImage', 'HomeController@removePostImage');
	Route::post('movePost', 'HomeController@movePost');
	Route::post('postStickOrUnstick', 'HomeController@postStickOrUnstick');
	Route::get('rightBar', 'HomeController@rightBar');
	Route::get('getAssignMenuByAdmin', 'HomeController@getAssignMenuByAdmin');
	Route::get('topMwByQualityPost', 'HomeController@topMwByQualityPost');
	Route::get('topMousewaiter', 'HomeController@topMousewaiter');
	Route::get('topNewsFeatured', 'HomeController@topNewsFeatured');
	
	Route::post('verifyMail', 'HomeController@verifyMail'); //verifyMail
	Route::get('confirmationMail', 'HomeController@confirmationMail');// hit when user press link from mailbox
	Route::get('resetConfirmationMail', 'HomeController@resetConfirmationMail');// hit when user press link from mailbox
	
	Route::post('suscribeOrUnsuscribePost', 'HomeController@suscribeOrUnsuscribePost'); //get update via email(my posts) mw page
	
	
	Route::post('postSuscribeUnsuscribe', 'HomeController@postSuscribeUnsuscribe');// from toggle menu
	
	Route::get('updateCreditByUserId', 'MobileController@updateCreditByUserId');
	
	
	Route::post('PostLiveApi', 'HomeController@PostLiveApi');
	
	
	
	Route::get('disneyworldHome', 'DisneyworldController@disneyworldHome');
	Route::get('disneyworldHome/{chat_room_id}', 'DisneyworldController@disneyworldHome');
	Route::get('disneyworldHome/search/post/{chat_msg}', 'DisneyworldController@disneyworldHome');
	Route::get('disneyworldPostDetail/{id}', 'DisneyworldController@disneyworldPostDetail');
	Route::get('stickyWdw', 'DisneyworldController@sticky');
	Route::get('user/{user_id}/wdwmyposts', 'DisneyworldController@myposts');
	Route::post('postWdwLounge', 'DisneyworldController@postWdwLounge');
	Route::post('bookmarkWdw', 'DisneyworldController@bookMark');
	Route::post('postCommentWdw', 'DisneyworldController@postComment');
	Route::post('commentReplyWdw', 'DisneyworldController@commentReply');
	Route::post('removeChatWdw', 'DisneyworldController@removeChat');
	Route::post('thankyouWdw', 'DisneyworldController@thankyou');
	Route::post('editChatWdw', 'DisneyworldController@editChat');
	Route::post('postBumpWdw', 'DisneyworldController@postBump');
	Route::post('postLockWdw', 'DisneyworldController@postLock');
	Route::get('advanceEditorGetWdw', 'DisneyworldController@advanceEditorGet');
	Route::post('advanceEditorPostWdw', 'DisneyworldController@advanceEditorPost');
	Route::post('postStickOrUnstickWdw', 'DisneyworldController@postStickOrUnstick');
	Route::post('movePostWdw', 'DisneyworldController@movePost');
	Route::post('flagWdw', 'DisneyworldController@flag');
	Route::get('flagActionWdw', 'DisneyworldController@flagAction');
	Route::post('removePostImageWdw', 'DisneyworldController@removePostImage');
	Route::get('most_viwed_chat_json', 'DisneyworldController@mostViewedChatjson');
	Route::get('rightBarWdw', 'DisneyworldController@rightBar');
	Route::get('topMwByQualityPostWdw', 'DisneyworldController@topMwByQualityPost');
	Route::get('topMousewaiterWdw', 'DisneyworldController@topMousewaiter');
	Route::get('hashWdw', 'DisneyworldController@hash');
	Route::post('likeCommentAndReplyWdw', 'DisneyworldController@likeCommentAndReply');

/* 	Route::get('tagWdw', 'DisneyworldController@tag');
	Route::get('assignTagToPostWdw', 'DisneyworldController@assignTagToPost'); */

});

Route::group(['middleware' => ['jwt.verify'], 'prefix' => 'v1'], function() {
	// Route::get('user', 'UserController@getAuthenticatedUser')->middleware('admin', 'write');
});





  

// Not Found
Route::fallback(function(){
 return response()->json(['message' => 'Resource not found.'], 404);
});
