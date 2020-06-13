<?php
namespace App\Controllers;

use Leaf\Http\Request;

class Controller extends \Leaf\ApiController {
	public $request;
	public $auth;
	public $form;

	public function __construct() {
		parent::__construct();
		$this->request = new Request;
		$this->form = new \Leaf\Form;
		$this->auth = new \Leaf\Auth;
		$this->auth->connect(getenv("DB_HOST"), getenv("DB_USERNAME"), getenv("DB_PASSWORD"), getenv("DB_DATABASE"));
    }
}