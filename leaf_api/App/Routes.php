<?php

/*
|--------------------------------------------------------------------------
| Set up 404 handler
|--------------------------------------------------------------------------
|
| Create a handler for 404 errors
|
*/
$app->set404(function () use ($app) {
	$app->response->respondWithCode([
		"data" => "Resource not found",
	], 404);
});

/*
|--------------------------------------------------------------------------
| Set up Controller namespace
|--------------------------------------------------------------------------
|
| This allows you to directly use controller names instead of typing
| the controller namespace first.
|
*/
$app->setNamespace("\App\Controllers");

$app->get("/", function() use($app) {
	$app->response->respondWithCode("Congrats!! You're on Leaf API", 200);
});

// create a route group
$app->mount("/auth", function() use($app) {
	// post routes for login & signup
	$app->post("/login", "UsersController@login");
	$app->post("/register", "UsersController@register");
});

$app->resource("/todos", "TodosController");
