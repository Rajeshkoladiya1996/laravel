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

// Route::get('/', function () {
// 	return view('welcome');
// });
// Front route
Route::group(['namespace' => 'Front'], function () {
	Route::get('/', 'HomeController@index')->name('home');
	Route::get('/privacy', 'HomeController@privacy')->name('privacy');
	Route::get('/about-our-company', 'HomeController@aboutOurCompany')->name('aboutOurCompany');
	Route::get('/about', 'HomeController@about')->name('about');
	Route::get('/agreement', 'HomeController@agreement')->name('agreement');
	Route::get('/broadcaster-agreement', 'HomeController@broadcasterAgreement')->name('broadcasterAgreement');
	Route::get('/community-convention', 'HomeController@communityConvention')->name('communityConvention');
	Route::get('/condition', 'HomeController@condition')->name('condition');
	Route::get('/contact', 'HomeController@contact')->name('contact');
	Route::get('/legel-inquiry', 'HomeController@legelInquiry')->name('legelInquiry');
	Route::get('/new-notice', 'HomeController@newNotice')->name('newNotice');
	Route::get('/user-agreement', 'HomeController@userAgreement')->name('userAgreement');
	Route::get('/privacy-coexistence', 'HomeController@privacyCoexistence')->name('privacyCoexistence');
});
// Auth::routes();

// admin route
Route::group(['prefix' => 'godmode', 'namespace' => 'Admin'], function () {
	Route::get('login', 'AuthController@login')->name('admin.login');
	Route::post('login', 'AuthController@doLogin')->name('admin.login');
	Route::get('read-file', 'GiftController@readFile')->name('admin.readFile');

	Route::group(['middleware' => ['admin']], function () {
		Route::get('/logout', 'AuthController@logout')->name('admin.logout');
		Route::get('/profile', 'AuthController@profile')->name('admin.profile');
		Route::post('/profile', 'AuthController@update')->name('admin.profile.update');
		Route::post('/changepassowrd', 'AuthController@changePassowrd')->name('admin.profile.changepassowrd');

		Route::get('/', 'UserController@index')->name('admin');

		//user route
		Route::group(['prefix' => 'user'], function () {
			Route::get('/', 'UserController@index')->name('admin.user');
			Route::get('/streamList', 'UserController@streamList')->name('admin.user.streamList');
			Route::get('/viewerList', 'UserController@viewerList')->name('admin.user.viewerList');
			Route::get('/create', 'UserController@create')->name('admin.user.create');
			Route::post('/store', 'UserController@store')->name('admin.user.store');
			Route::get('/edit/{id}', 'UserController@edit')->name('admin.user.edit');
			Route::post('/update', 'UserController@update')->name('admin.user.update');
			Route::post('/changePassword', 'UserController@changePassword')->name('admin.user.changePassword');
			Route::post('/assignDiamond', 'UserController@assignDiamond')->name('admin.user.assignDiamond');
			Route::post('/checkrate', 'UserController@checkRate')->name('admin.user.checkRate');
			Route::post('/blockUser', 'UserController@blockUserByAdmin')->name('admin.user.blockUserByAdmin');
			Route::post('/blockUserList', 'UserController@blockedUserList')->name('admin.user.blockUserList');
			Route::post('/recommended', 'UserController@changeRecommended')->name('admin.user.recommended');
			Route::post('/profileList', 'UserController@profileList')->name('admin.users.img.list');
            Route::post('/spendCoinUser', 'UserController@spendCoinUser')->name('admin.user.spendCoinUser');
			Route::post('/spendCoinUserList', 'UserController@spendCoinUserList')->name('admin.user.spendCoinUserList');
			Route::post('/followersUserReport', 'UserController@followersUserReport')->name('admin.user.followersUserReport');
            Route::post('/followersUserList', 'UserController@followersUserReportList')->name('admin.user.followersUserReportList');
            Route::post('/followersUserList', 'UserController@followersUserReportList')->name('admin.user.followersUserList');
			Route::post('/liveStreamReport','UserController@liveStreamReport')->name('admin.user.liveStreamReport');
            Route::post('/liveStreamReportList','UserController@liveStreamReportList')->name('admin.user.liveStreamReportList');
			Route::post('/goldCoinUserList','UserController@goldCoinReport')->name('admin.user.goldCoinUserList');
            Route::post('/goldCoinUser','UserController@goldCoinReportList')->name('admin.user.goldCoinUser');
            Route::post('/transferGoldCoin','UserController@transferGoldCoin')->name('admin.user.transferGoldCoin');
		});

		// gift route
		Route::group(['prefix' => 'gift'], function () {

			Route::group(['prefix' => 'category'], function () {
				Route::get('/', 'GiftCategotyController@index')->name('admin.gift.category.list');
				Route::post('/store', 'GiftCategotyController@store')->name('admin.gift.category.store');
				Route::get('/edit/{id}', 'GiftCategotyController@edit')->name('admin.gift.category.edit');
				Route::post('/update', 'GiftCategotyController@update')->name('admin.gift.category.update');
				Route::post('/delete', 'GiftCategotyController@destroy')->name('admin.gift.category.delete');
			});

			Route::get('/', 'GiftController@index')->name('admin.gift');
			Route::get('/list', 'GiftController@list')->name('admin.gift.list');
			Route::post('/store', 'GiftController@store')->name('admin.gift.store');
			Route::get('/edit/{id}', 'GiftController@edit')->name('admin.gift.edit');
			Route::post('/update', 'GiftController@update')->name('admin.gift.update');
			Route::post('/delete', 'GiftController@destroy')->name('admin.gift.delete');
			Route::post('/checkName', 'GiftController@checkGiftName')->name('admin.gift.giftCheckName');
			// Route::post('/checkGiftImage','GiftController@checkGiftImage')->name('admin.gift.giftCheckImage');
		});

		//live stream route
		Route::group(['prefix' => 'live-stream'], function () {
			Route::get('/', 'LiveStreamController@index')->name('admin.liveStream');
			Route::get('/list', 'LiveStreamController@liveStreamList')->name('admin.liveStream.list');
			Route::get('/pklist', 'LiveStreamController@pkliveStreamList')->name('admin.liveStream.pklist');
			Route::post('/view', 'LiveStreamController@liveStreamView')->name('admin.liveStream.view');
			Route::post('/battlesview', 'LiveStreamController@livebattlesStreamView')->name('admin.liveStream.battlesview');
		});

		//live stream route 2
		Route::group(['prefix' => 'live-stream2'], function () {
			Route::get('/', 'LiveStreamController2@index')->name('admin.liveStream2');
			Route::get('/list', 'LiveStreamController2@liveStreamList')->name('admin.liveStream2.list');
			Route::get('/pklist', 'LiveStreamController2@pkliveStreamList')->name('admin.liveStream2.pklist');
			Route::post('/view', 'LiveStreamController2@liveStreamView')->name('admin.liveStream2.view');
			Route::post('/battlesview', 'LiveStreamController2@livebattlesStreamView')->name('admin.liveStream2.battlesview');
		});


		//SubAdmin route
		Route::group(['prefix' => 'subadmin'], function () {
			Route::get('/', 'SubAdminController@index')->name('admin.subadmin');
			Route::get('/list', 'SubAdminController@list')->name('admin.subadmin.list');
			Route::post('/store', 'SubAdminController@store')->name('admin.subadmin.store');
			Route::get('/edit/{id}', 'SubAdminController@edit')->name('admin.subadmin.edit');
			Route::post('/update', 'SubAdminController@update')->name('admin.subadmin.update');
			Route::post('/delete', 'SubAdminController@destroy')->name('admin.subadmin.delete');
			Route::post('/changePassword', 'SubAdminController@changePassword')->name('admin.subadmin.changePassword');
		});

		//auditLogs route
		Route::group(['prefix' => 'audit-logs'], function () {
			Route::get('/', 'AuditlogController@index')->name('admin.auditLogs');
			Route::get('/list', 'AuditlogController@list')->name('admin.auditLogs.list');
			Route::get('/listLog', 'AuditlogController@listLogPaginate')->name('admin.auditLogs.listLogPaginate');
			Route::get('/listGems', 'AuditlogController@listGemsPaginate')->name('admin.auditLogs.listGemsPaginate');
			Route::post('/delete', 'AuditlogController@destroy')->name('admin.auditLogs.delete');
		});

		//apiLogs route
		Route::group(['prefix' => 'miscellaneous'], function () {
			Route::get('/', 'ApiLogController@index')->name('admin.apiLogs');
			Route::post('/request-body', 'ApiLogController@getRequestBody')->name('admin.apiLogs.requestBody');
			Route::post('/response', 'ApiLogController@getResponse')->name('admin.apiLogs.response');
			Route::get('/listLog', 'ApiLogController@apiLogList')->name('admin.apiLogs.apiLogList');
			Route::post('/delete', 'ApiLogController@delete')->name('admin.apiLogs.delete');
			Route::post('/delete-all', 'ApiLogController@deleteAll')->name('admin.apiLogs.delete.all');

			//WebLogs route
			Route::group(['prefix' => 'web'], function () {
				Route::post('/request-body', 'WebLogController@getRequestBody')->name('admin.webLogs.requestBody');
				Route::post('/response', 'WebLogController@getResponse')->name('admin.webLogs.response');
				Route::get('/listLog', 'WebLogController@webLogList')->name('admin.webLogs.webLogList');
				Route::post('/delete', 'WebLogController@delete')->name('admin.webLogs.delete');
				Route::post('/delete-all', 'WebLogController@deleteAll')->name('admin.webLogs.delete.all');
			});
		});



		// UserRequest route
		Route::group(['prefix' => 'user-request'], function () {
			Route::get('/', 'UserRequestController@index')->name('admin.userRequest');
			Route::get('/stream-list', 'UserRequestController@streamRequestList')->name('admin.userRequest.streamRequestList');
			Route::get('/wallet-list', 'UserRequestController@walletRequestList')->name('admin.userRequest.walletRequestList');
			Route::get('/cash-withdrawal-list', 'UserRequestController@cashWithdrawalRequestList')->name('admin.userRequest.cashWithdrawalRequestList');
			Route::get('/salmonCoins-withdrawal-list', 'UserRequestController@salmonCoinsWithdrawalRequestList')->name('admin.userRequest.salmonCoinsWithdrawalRequestList');
			Route::post('/status', 'UserRequestController@changeStatus')->name('admin.userRequest.status');
			Route::post('/wallet-status', 'UserRequestController@changeWalletStatus')->name('admin.userRequest.walletStatus');
			Route::post('/delete', 'UserRequestController@destroy')->name('admin.userRequest.delete');
		});

		// Finanical route
		Route::group(['prefix' => 'financial'], function () {
			Route::get('/', 'FinancialController@index')->name('admin.finanical');
			Route::get('/listGems', 'FinancialController@listGemsPaginate')->name('admin.finanical.listGemsPaginate');
			Route::get('/list', 'FinancialController@list')->name('admin.finanical.list');
			Route::post('/store','FinancialController@store')->name('admin.salmoncoin.store');
			Route::get('/edit/{id}', 'FinancialController@edit')->name('admin.salmoncoin.edit');
			Route::post('/update', 'FinancialController@update')->name('admin.salmoncoin.update');
			Route::post('/delete', 'FinancialController@destroy')->name('admin.salmoncoin.delete');
			Route::get('/last','FinancialController@lastData')->name('admin.salmoncoin.last');
			Route::post('/update-topups', 'FinancialController@updateTopUp')->name('admin.topups.update');
		});

		// Event route
		Route::group(['prefix' => 'event'], function () {
			Route::get('/', 'EventController@index')->name('admin.event');
			Route::post('/', 'EventController@store')->name('admin.event.store');
			Route::get('/listevent', 'EventController@listevent')->name('admin.event.listeventPaginate');
			Route::get('/list', 'EventController@list')->name('admin.event.list');
			Route::post('/status', 'EventController@changeStatus')->name('admin.event.status');
			Route::post('/delete', 'EventController@destroy')->name('admin.event.delete');
			Route::get('/edit/{id}', 'EventController@edit')->name('admin.event.edit');
			Route::post('/update', 'EventController@update')->name('admin.event.update');
			Route::get('/data/{id}','EventController@eventData')->name('admin.event.data');
			Route::get('/giftData/{id}', 'EventController@giftData')->name('admin.event.gift.data');
			Route::post('/event-user','EventController@eventUserReport')->name('admin.event.user');
            Route::post('/event-user-list','EventController@eventUserList')->name('admin.event.user.list');
		});

		// Config route
		Route::group(['prefix' => 'config'], function () {
			Route::post('/store', 'ConfigController@store')->name('admin.config.store');
		});
		// Level route
		Route::group(['prefix' => 'level'], function () {
			Route::get('/', 'LevelController@index')->name('admin.level');
			Route::get('/list', 'LevelController@list')->name('admin.level.list');
			Route::get('/create', 'LevelController@create')->name('admin.level.create');
			Route::post('/store', 'LevelController@store')->name('admin.level.store');
			Route::get('/edit/{slug}', 'LevelController@edit')->name('admin.level.edit');
			Route::post('/update', 'LevelController@update')->name('admin.level.update');
			Route::post('/delete', 'LevelController@destroy')->name('admin.level.delete');
			// Route::post('/detail/delete','LevelController@destroyDetail')->name('admin.level.detail.delete');
			Route::post('/checkName', 'LevelController@levelName')->name('admin.level.checkName');
			Route::post('/checkpoint', 'LevelController@checkPoint')->name('admin.level.checkPoint');
			// point route
			Route::group(['prefix' => 'point'], function () {
				Route::get('/create', 'LevelPointController@create')->name('admin.level.point.create');
				Route::post('/store', 'LevelPointController@store')->name('admin.level.point.store');
				Route::get('/edit/{id}', 'LevelPointController@edit')->name('admin.level.point.edit');
				Route::post('/update', 'LevelPointController@update')->name('admin.level.point.update');
				Route::post('/delete', 'LevelPointController@destroy')->name('admin.level.point.delete');
				Route::get('/list', 'LevelPointController@list')->name('admin.level.point.list');
			});
			Route::post('/change-status','LevelController@changeStatus')->name('admin.level.changeStatus');
			Route::post('/change-status-point','LevelPointController@changeStatus')->name('admin.level.point.changeStatus');
		});

		// reward  route
		Route::group(['prefix' => 'reward'], function () {
			Route::get('/', 'RewardController@index')->name('admin.reward');
			Route::post('/', 'RewardController@store')->name('admin.reward.store');
			Route::get('/getList', 'RewardController@getList')->name('admin.reward.getlist');
			Route::post('/delete', 'RewardController@destroy')->name('admin.reward.delete');
			Route::get('/edit/{id}', 'RewardController@edit')->name('admin.reward.edit');
			Route::post('/update', 'RewardController@update')->name('admin.reward.update');
			Route::post('/status', 'RewardController@changeStatus')->name('admin.reward.status');
			// point route
			Route::group(['prefix' => 'point'], function () {
				Route::post('/delete', 'ProgessPointsController@destroy')->name('admin.reward.point.delete');
				Route::get('/edit/{id}', 'ProgessPointsController@edit')->name('admin.reward.point.edit');
				Route::post('/update', 'ProgessPointsController@update')->name('admin.reward.point.update');
				Route::get('/getList', 'ProgessPointsController@getList')->name('admin.reward.point.getlist');
			});
		});

		// tags route
		Route::group(['prefix' => 'tags'], function () {
			Route::get('/', 'TagController@index')->name('admin.tags');
			Route::post('/', 'TagController@store')->name('admin.tags.store');
			Route::get('/list', 'TagController@list')->name('admin.tags.list');
			Route::get('/edit/{id}', 'TagController@edit')->name('admin.tags.edit');
			Route::post('/update', 'TagController@update')->name('admin.tags.update');
			Route::post('/delete', 'TagController@destroy')->name('admin.tags.delete');
			Route::post('/change-status','TagController@changeStatus')->name('admin.tags.changeStatus');
		});

		// user-reports route
		Route::group(['prefix' => 'user-reports'], function () {
			Route::get('/', 'UserReportController@index')->name('admin.user.reports');
			Route::get('/list', 'UserReportController@userReportList')->name('admin.user.reports.list');
			Route::get('/detail', 'UserReportController@userReportDetails')->name('admin.user.reports.detail');
		});

		// live-stream-report route
		Route::group(['prefix' => 'live-stream-report'], function () {
			Route::get('/', 'LivestreamReportController@index')->name('admin.liveStream.reports');
			Route::get('/list', 'LivestreamReportController@liveStreamReportList')->name('admin.liveStream.reports.list');
			Route::post('/delete','LivestreamReportController@destroy')->name('admin.liveStream.reports.delete');
			Route::post('/change-status','LivestreamReportController@changeStatus')->name('admin.liveStream.reports.changeStatus');
		});

		// app-settings route
		Route::group(['prefix' => 'app-settings'], function () {
			Route::get('/', 'AppSettingsController@index')->name('admin.app.settings');
			Route::get('/list', 'AppSettingsController@list')->name('admin.app.settings.list');
			Route::post('/store', 'AppSettingsController@store')->name('admin.app.settings.store');
			Route::get('/edit/{id}', 'AppSettingsController@edit')->name('admin.app.settings.edit');
			Route::post('/update', 'AppSettingsController@update')->name('admin.app.settings.update');
			Route::post('/change-app-updateStatus', 'AppSettingsController@changeAppUpdateStatus')->name('admin.app.settings.update-Status');
			Route::post('/change-app-production-status', 'AppSettingsController@changeAppProductionStatus')->name('admin.app.settings.production-status');
			Route::post('/change-app-festive-status', 'AppSettingsController@changeAppFestiveStatus')->name('admin.app.settings.festive-status');
			Route::post('/change-app-develop-status', 'AppSettingsController@changeAppDevelopStatus')->name('admin.app.settings.develop-status');
			Route::get('/hotTag', 'AppSettingsController@getHotTagSetting')->name('admin.hottag.settings');
			Route::get('/socialMedia', 'AppSettingsController@getSocialMedia')->name('admin.socialmedia');
			Route::get('/editHotTag/{id}', 'AppSettingsController@editHotTag')->name('admin.hottag.edit');
			Route::post('/updateHotTag','AppSettingsController@updateHotTag')->name('admin.hottag.update');
			Route::post('/updateSocialMedia', 'AppSettingsController@updateSocialMedia')->name('admin.socialmedia.update');
		});

		//package management
		Route::group(['prefix'=>'package'],function(){
			Route::get('/','PackageController@index')->name('admin.package');
			Route::get('/list','PackageController@list')->name('admin.package.list');
			Route::post('/', 'PackageController@store')->name('admin.package.store');
			Route::get('/edit/{id}', 'PackageController@edit')->name('admin.package.edit');
			Route::post('/update', 'PackageController@update')->name('admin.package.update');
			Route::post('/delete', 'PackageController@destroy')->name('admin.package.delete');
			Route::post('/iosStatus', 'PackageController@changeIOSStatus')->name('admin.package.ios.status');
			Route::post('/androidStatus', 'PackageController@changeAndroidStatus')->name('admin.package.android.status');
		});


	});

		Route::group(['prefix'=>'avtar'],function(){
			Route::get('/view/{slug}','AvtarController@index')->name('admin.avtar.view');
			// Avtar list (Boy,Gril)
			Route::get('/','AvtarTypeController@index')->name('admin.avtar');
			Route::post('/store','AvtarTypeController@store')->name('admin.avtar.store');
			Route::get('/list','AvtarTypeController@list')->name('admin.avtar.list');
			Route::post('/delete','AvtarTypeController@destroy')->name('admin.avtar.delete'); 
			Route::post('/status', 'AvtarTypeController@changeStatus')->name('admin.avtar.status');
			Route::get('/edit/{id}', 'AvtarTypeController@edit')->name('admin.avtar.edit');
			Route::post('/update', 'AvtarTypeController@update')->name('admin.avtar.update');
			// Avtar Category Component
			Route::get('/category','AvtarTypeController@category')->name('admin.category.avtar');
			Route::post('/category/store','AvtarTypeController@storecategory')->name('admin.category.store');
			Route::get('/category/list','AvtarTypeController@categorylist')->name('admin.avtar.categorylist');  
			Route::post('/category/categorystatus','AvtarTypeController@categorystatus')->name('admin.avtar.categorystatus');
			Route::post('/category/categorydelete','AvtarTypeController@categorydelete')->name('admin.avtar.categorydelete');
			Route::get('/category/edit/{id}', 'AvtarTypeController@editcategory')->name('admin.avtar.categoryedit');
			Route::post('/category/update', 'AvtarTypeController@updatecategory')->name('admin.avtar.updatecategory'); 
			// Assign Component To Avtar
			Route::get('/component','AvtarComponentController@index')->name('admin.avtar.component');
			Route::get('/addcomponent','AvtarComponentController@category')->name('admin.avtar.addcomponent');
			Route::post('/component/store','AvtarComponentController@store')->name('admin.component.store');
			Route::get('/component/list','AvtarComponentController@componentlist')->name('admin.avtar.componentlist');  
			Route::post('/component/componentstatus','AvtarComponentController@componentstatus')->name('admin.avtar.componentstatus');
			Route::post('/component/componentdelete','AvtarComponentController@componentdelete')->name('admin.avtar.componentdelete');
			Route::get('/component/edit/{id}', 'AvtarComponentController@editcomponent')->name('admin.avtar.editcomponent');
			Route::post('/component/update', 'AvtarComponentController@update')->name('admin.avtar.updatecomponent');
			
		});


	
});
