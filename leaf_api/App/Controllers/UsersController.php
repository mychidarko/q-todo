<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends Controller {
    public function login()
    {
        // in this case, $username can contain either a username or email
        $username = $this->request->get("username");
        $password = $this->request->get("password");

        // quick request data validation with Leaf Forms
        $validation = $this->form->validate([
            "username" => $this->form->isEmail($username) ? "email" : "validUsername",
            "password" => "required"
        ]);

        // throw an error if validation fails
        if (!$validation) $this->throwErr($this->form->errors());

        if ($this->form->isEmail($username)) {
            // check for email, throwErr if not found
            if (count(User::where("email", $username)->get()) == 0) $this->throwErr("Email doesn't exist");
            // login directly with Leaf Auth. This will return the user without the password + a generated JWT
            $user = $this->auth->login("users", [
                "email" => $username,
                "password" => $password
            ], "md5");
        } else {
            // check for username, throwErr if not found
            if (count(User::where("username", $username)->get()) == 0) $this->throwErr("Username doesn't exist");
            // login directly with Leaf Auth. This will return the user without the password + a generated JWT
            $user = $this->auth->login("users", [
                "username" => $username,
                "password" => $password
            ], "md5");
        }
        // at this point, if the user is not found, it can only mean that the password is wrong
        if (!$user) $this->throwErr("Password is incorrect.");

        $this->respondWithCode($user, 200);
    }

    public function register()
    {
        $username = $this->request->get("username");
        $email = $this->request->get("email");
        $password = $this->request->get("password");

        $validation = $this->form->validate([
            "username" => "validUsername",
            "email" => "email",
            "password" => "required"
        ]);

        if (!$validation) $this->throwErr($this->form->errors());

        // direct registration with Leaf Auth. Registers and initiates a login
        // the 3rd parameter makes sure that the same username and email can't be registered multiple times
        $user = $this->auth->register("users", [
            "username" => $username,
            "email" => $email,
            "password" => md5($password)
        ], ["username", "email"]);

        // throw an auth error if there's an issue
        if (!$user) $this->throwErr($this->auth->errors());

        $this->respondWithCode($user, 200);
    }

    // refresh the user if the token is expired (must be called on the frontend)
    // usually, not taking a password would lead to others using this endpoint to get other users' info
    public function refreshToken($id)
    {
        $this->respondWithCode($this->auth->login("users", ["id" => $id]), 200);
    }
}