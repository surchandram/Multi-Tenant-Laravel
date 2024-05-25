<?php

namespace SAAS\Http\Developers\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;

class DeveloperController extends Controller
{
	/**
	 * DeveloperController Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware(['auth', 'verified']);
	}

    /**
     * Display the developer panel view.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('developers.index');
    }
}
