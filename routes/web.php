<?php

use Illuminate\Pipeline\Pipeline;

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

Route::get('/', function () {
    $pipeline = app(Pipeline::class);

    $pipeline->send('hello cruel world')
        ->through([
            function ($string, $next) {
                $string = ucwords($string);

                return $next($string);
            },
            function ($string, $next) {
                $string = str_ireplace('cruel', '', $string);

                return $next($string);
            }
        ])
        ->then(function ($string) {
            dump($string);
        });

    return 'Done';
});
