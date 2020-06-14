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
	$app->response->throwErr("Resource not found", 404);
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
	$app->response->respondWithCode("Welcome to Q Todo API", 200);
});

// create a route group
$app->mount("/auth", function() use($app) {
	// post routes for login & signup
	$app->post("/login", "UsersController@login");
	$app->post("/register", "UsersController@register");
	// (\d+) limits the route to only accept integers, anything else would result in a 404 error
	$app->get("/refresh/(\d+)", "UsersController@refreshToken");
});

$app->mount("/user", function() use($app) {
	$app->get("/", "UsersController@user");
	$app->post("/update", "UsersController@update");
});

$app->resource("/todos", "TodosController");
