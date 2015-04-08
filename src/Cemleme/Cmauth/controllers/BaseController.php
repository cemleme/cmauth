<?php namespace Cemleme\Cmauth\controllers;

use Illuminate\Routing\Controller;

class BaseController extends Controller {

	protected $layout = "cmauth::partials.cmauth_sub_template";	

	public function returnLayout($viewName, $data = []){

		return view($this->layout, ['content' => view($viewName, $data)]);
	}

}