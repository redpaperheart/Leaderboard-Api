<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// $app->get('/', function () use ($app) {
//     return $app->version();
// });

// Route::get('/get', 'PlayerController@get');
// Route::post('/store', 'PlayerController@store');

$app->get('/', function() use ($app) {
    return "RPH-Leaderboard - Lumen RESTful API - " . $app->version();
});
 
$app->group(['prefix' => 'api/v1'], function($app)
{
    
    //$app->get('/','PlayerController@getPlayers'); // 
    //$app->get('lb','PlayerController@getPlayers'); // 

	// recalculate all ranks of a specififc leaderboard
	$app->get('lb/{lb}/calc', 'PlayerController@calculateAllLeaderboardPostions');

	// get a leaderboard
    $app->get('lb/{id}','PlayerController@getPlayers'); 
    $app->get('lb/{id}/{amt}','PlayerController@getPlayers');
    //->where('amt', '[0-9]+');; 
     


    // // create player
    $app->post('lb','PlayerController@createPlayer');
    //$app->get('lb/create','PlayerController@createPlayer');
      
    // $app->put('lb/{id}','BookController@updatePlayer');
    // app->delete('lb/{id}','PlayerController@deletePlayer');
});