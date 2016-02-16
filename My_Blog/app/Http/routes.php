<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

//Execute 'index' function inside 'PagesController' class
Route::get('/', 'PagesController@index');

Route::get('/about', 'PagesController@about');

Route::get('/contact','PagesController@contact');

Route::get('/post',[
					'as'=>'sample_post',
					'uses'=>'PostController@search'
													]);

Route::post('/post/show_detail',[
									'as'=>'action_show_detail',
									'uses'=>'PostController@show_detail'
																		]);

Route::post('/post/remove_post',[
									'as'=>'action_remove',
									'uses'=>'PostController@remove_post'
																			]);

Route::post('/post/edit',[
							'as'=>'action_edit',
							'uses'=>'PostController@edit']);

Route::get('/post/search/',[
							'as'=>'action_search',
							'uses'=>'PostController@search'
															]);


Route::post('/post/action_write',[
								'as' => 'action_write', 
								'uses'=>'PostController@write'
														]);

Route::get('/post/to_write',[
								'as' => 'to_write',
								function() {
									return view('pages.write');
								}
																	]);