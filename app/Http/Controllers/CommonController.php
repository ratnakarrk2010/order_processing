<?php

namespace App\Http\Controllers;


class CommonController extends Controller
{
	//
	protected $data;
	public function __construct()
	{
		$this->data['success_message'] = '';
		$this->data['error_message'] = '';
		$this->data['exception_message'] = '';
		$this->data['message'] = '';
		$this->data['isEdit'] = false;
		$this->data['isSearch'] = false;
	}
}
