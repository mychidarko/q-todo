<?php
namespace App\Controllers;

use App\Models\Todo;

class TodosController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        // check and validate bearer token (proof of authentication)
        $payload = $this->auth->validateToken();
        // throw an error if there's a problem with token
        if (!$payload) $this->throwErr($this->auth->errors());

        // get user id from token
        $user_id = $payload->user_id;

        // retrieve user's todos
        $this->respondWithCode(Todo::where("user_id", $user_id));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store() {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        //
    }
}