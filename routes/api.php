<?php

if (env('APP_ENV') === 'production') {
    URL::forceScheme('https'); 
}

Route::get('/details','ApiController@showAuthorizationDetails');

Route::post('/authorize','ApiController@requestAuthorization');

Route::fallback(function(){
    return response()->json([
        'data' => [],
        'state'=>'failed',
        'message'=>'Invalid Request',
        'code'=>'404'
    ],404);

});
