<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where the routes are registered for our application.
|
*/




Route::get('/adminLogin', 'Admin\Auth\LoginController@adminLoginPage')->name('adminLogin');
Route::post('/admin', 'Admin\Auth\LoginController@adminLogin')->name('backend.admin');
Route::get('/logout', 'Admin\Auth\LoginController@logout');

Route::group(['middleware' => ['admin']], function () { 
// dashboard controller

Route::get('/dashboard', 'Admin\DashboardController@dashboard')->name('dashboard')->middleware('admin');
// Route::middleware(['auth'])->get('/add-creditor', 'AddCreditor@index');


//user controller
Route::get('/users', 'Admin\UserController@user');
Route::post('/users', 'Admin\UserController@user')->name('backend.users');
Route::get('/changeUserDetail', 'Admin\UserController@changeUserDetail');
Route::post('/changeUserDetail', 'Admin\UserController@changeUserDetail')->name('backend.changeUserDetail');
Route::get('/activeUser', 'Admin\UserController@activeUser');
Route::get('/approvedUser', 'Admin\UserController@approvedUser');
Route::get('/changeUserPassword', 'Admin\UserController@changeUserPassword');
Route::post('/changeUserPassword', 'Admin\UserController@changeUserPassword')->name('backend.changeUserPassword');
Route::get('/sendUserMail', 'Admin\UserController@sendUserMail');
Route::post('/sendUserMail', 'Admin\UserController@sendUserMail')->name('backend.sendUserMail');
Route::get('/userMrHistory', 'Admin\UserController@userMrHistory');
Route::get('/userIpHistory', 'Admin\UserController@userIpHistory');
//Route::post('/userMrHistory', 'Admin\UserController@userMrHistory')->name('backend.userMrHistory');

//credit sale control
Route::get('/userCreditSetting', 'Admin\UserController@getuserCreditSetting');
Route::get('/userCreditSettingAdd', function () { return view('layouts.creditSaleControl.add_user_credit_setting'); });
Route::post('/userCreditSetting', 'Admin\UserController@userCreditSetting')->name('backend.add_user_credit_setting');
Route::get(	'/userCreditSettingEdit', 'Admin\UserController@userCreditSettingEdit');
Route::post('/userCreditSettingEdit', 'Admin\UserController@userCreditSetting')->name('backend.edit_user_credit_setting');


//product category(sticker) controller
Route::get('/productCategory', 'Admin\ProductController@getProductCategory');
Route::get('/productCategoryAdd', function () { return view('layouts.productCategory.add_product_category'); });
Route::post('/productCategory', 'Admin\ProductController@addProductCategory')->name('backend.add_product_category');
Route::get('/productCategoryEdit', 'Admin\ProductController@editproductCategory');
Route::post('/productCategoryEdit', 'Admin\ProductController@addProductCategory')->name('backend.edit_product_category');

//product(sticker) controller
Route::get('/products', 'Admin\ProductController@getProduct');
Route::get('/productAdd', function () { return view('layouts/add_product'); });
Route::get('/productAdd', 'Admin\ProductController@getEmoji');
Route::post('/products', 'Admin\ProductController@addProduct')->name('backend.add_product');
Route::get('/productEdit', 'Admin\ProductController@editProduct');
Route::post('/productEdit', 'Admin\ProductController@addProduct')->name('backend.edit_product');

//assign logo to user controller
Route::get('/userLogo', 'Admin\ProductController@getUserLogo');
Route::get('/userLogoAdd', function () { return view('layouts.userLogo.add_userlogo'); });
Route::post('/userLogo', 'Admin\ProductController@addUserLogo')->name('backend.add_userlogo');
Route::get(	'/userLogoEdit', 'Admin\ProductController@editUserLogo');
Route::post('/userLogoEdit', 'Admin\ProductController@addUserLogo')->name('backend.edit_userlogo');

//user logo detail page controller
Route::get('/userLogoDetail', 'Admin\ProductController@getUserLogoDetail');
Route::get('/userLogoDetailAdd', function () { return view('layouts.userLogoDetail.add_userlogo_detail'); });
Route::post('/userLogoDetail', 'Admin\ProductController@addUserLogoDetail')->name('backend.add_userlogo_detail');


//Leaderboard page controller
Route::get('/leaderboard', 'Admin\ProductController@getLeaderboard');
Route::get('/leaderboardDetail', 'Admin\ProductController@leaderboardDetail');
Route::get('/wdwLeaderboard', 'Admin\ProductController@wdwLeaderboard');


//User permission  controller
Route::get('/getUserPermissionMenu', 'Admin\ProductController@getUserPermissionMenu');
Route::post('/getUserPermissionMenu', 'Admin\ProductController@getUserPermissionMenu')->name('backend.user_permission_menu');
Route::get(	'/getUserPermissionMenuEdit', 'Admin\ProductController@editUserPermissionMenu');
Route::post('/getUserPermissionMenuEdit', 'Admin\ProductController@addUserPermissionMenu')->name('backend.edit_user_permission_menu');


//Tags
Route::get('/tag', 'Admin\ProductController@getTag');
Route::get('/tagAdd', function () { return view('layouts.tag.add_tag'); });
Route::post('/tag', 'Admin\ProductController@addTag')->name('backend.add_tag');
Route::get(	'/tagEdit', 'Admin\ProductController@editTag');
Route::post('/tagEdit', 'Admin\ProductController@addTag')->name('backend.edit_tag');


//add advertise post
Route::get('/advertisePost', 'Admin\ProductController@getAdvertisePost');
Route::get('/advertisePostAdd', function () { return view('layouts.advertisePost.add_advertisepost'); });
Route::post('/advertisePost', 'Admin\ProductController@addAdvertisePost')->name('backend.add_advertisepost');
Route::get(	'/advertisePostEdit', 'Admin\ProductController@editAdvertisePost');
Route::post('/advertisePostEdit', 'Admin\ProductController@addAdvertisePost')->name('backend.edit_advertisepost');

//Email template
Route::get('/emailTemplate', 'Admin\ProductController@getEmailTemplate');
Route::get('/emailTemplateAdd', function () { return view('layouts.emailTemplate.add_emailtemplate'); });
Route::post('/emailTemplate', 'Admin\ProductController@addEmailTemplate')->name('backend.add_emailtemplate');
Route::get(	'/emailTemplateEdit', 'Admin\ProductController@editEmailTemplate');
Route::post('/emailTemplateEdit', 'Admin\ProductController@addEmailTemplate')->name('backend.edit_emailtemplate');



//Admin songs
Route::get('/song', 'Admin\ProductController@getSong');
Route::post('/song', 'Admin\ProductController@getSong')->name('backend.adminSong.song');
Route::get('/songAdd', function () { return view('layouts.adminSong.add_song'); });
Route::post('/songAdd', 'Admin\ProductController@addSong')->name('backend.add_song');
Route::get(	'/songEdit', 'Admin\ProductController@editSong');
Route::post('/songEdit', 'Admin\ProductController@addSong')->name('backend.edit_song');

//add advertise post
Route::get('/news', 'Admin\ProductController@getNews');
Route::get('/newsAdd', function () { return view('layouts.adminNews.add_news'); });
Route::post('/news', 'Admin\ProductController@addNews')->name('backend.add_news');
Route::get(	'/newsEdit', 'Admin\ProductController@editNews');
Route::post('/newsEdit', 'Admin\ProductController@addNews')->name('backend.edit_news');



//Manage Rights
Route::get('/right', 'Admin\ProductController@getRight');
Route::get('/rightAdd', function () { return view('layouts.right.add_rights'); });
Route::post('/right', 'Admin\ProductController@addRight')->name('backend.add_rights');
// Route::get(	'/rightEdit', 'Admin\ProductController@editNews');
// Route::post('/rightEdit', 'Admin\ProductController@addNews')->name('backend.edit_news');


//user daily best of day email
Route::get('/bestofthedayemail', 'Admin\ProductController@userDailyBestOfTheDayEmail');

//chat controller
Route::get('/reportedChat', 'Admin\ChatController@reportedChat');

//comment controller
Route::get('/reportedComment', 'Admin\CommentController@reportedComment');


});




// Named route required for SendsPasswordResetEmails.
Route::get('reset-password', function() {
    return view('index');
})->name('password.reset');

// Catches all other web routes.
Route::get('{slug}', function () {
    return view('index');
})->where('slug', '^(?!api).*$');



