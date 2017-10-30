<?php

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
$host = Request::getHost();
$hostparts = explode('.', $host);
$subdomain = $hostparts[0];

if($subdomain == 'sms'){
// run some logic here to figure out sub domain etc
// do a db call to check valid host based on $hostparts
// if valid host set some config options...

    Route::get('/njjxhutspvzmqrm', [
        'uses' => 'SmsPayController@getCheckSms',
        'as' => 'pay.sms.check'
    ]);

}else{

    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::post('/', function () {
        return redirect()->route('home');
    });
dsfsdf
    Auth::routes();

    Route::post('/upload/file', [
        'uses' => 'UploadController@upload',
        'as' => 'video.upload'
    ]);
    Route::get('/podminky_uziti', [
        'uses' => 'HomeController@getPodmienky',
        'as' => 'home.podmienky.uziti'
    ]);
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/premium', [
            'uses' => 'PremiumController@index',
            'as' => 'premium'
        ]);
        Route::get('/moje-videa', [
            'uses' => 'VideoController@index',
            'as' => 'videa'
        ]);
        Route::get('/video-watch/{id}', [
            'uses' => 'VideoController@getVideo',
            'as' => 'video.watch'
        ]);
        Route::post('/platba/{price}', [
            'uses' => 'PremiumController@getPayments',
            'as' => 'platba.get'
        ]);

        Route::post('/platba/sms/generate/{price}', [
            'uses' => 'SmsPayController@GetSmsGenerate',
            'as' => 'pay.sms.generate'
        ]);
        Route::get('/platba/smscheck', [
            'uses' => 'SmsPayController@getCheckSms',
            'as' => 'pay.sms.check'
        ]);
    });
    Route::get('/platba/sms/{price}', [
        'uses' => 'SmsPayController@GetPaySms',
        'as' => 'pay.sms'
    ]);
    Route::post('/platba/sms/{price}', [
        'uses' => 'SmsPayController@GetPaySms',
        'as' => 'pay.sms'
    ]);
    Route::get('/platba/vmrcfgbmpfppmdk/check', [
        'uses' => 'PremiumController@paymentsCheck',
        'as' => 'platba.get'
    ]);
    Route::put('/platba/vmrcfgbmpfppmdk/check', [
        'uses' => 'PremiumController@paymentsCheck',
        'as' => 'platba.get'
    ]);
    Route::post('/platba/vmrcfgbmpfppmdk/check', [
        'uses' => 'PremiumController@paymentsCheck',
        'as' => 'platba.get'
    ]);
    Route::post('/platba/sms/generate/{price}', [
        'uses' => 'SmsPayController@GetSmsGenerate',
        'as' => 'pay.sms.generate'
    ]);
    Route::get('/platba/sms/generate/{price}', [
        'uses' => 'SmsPayController@GetSmsGenerate',
        'as' => 'pay.sms.generate'
    ]);
}