<?php

namespace App\Http\Controllers\Fontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class WebController extends Controller
{
	/**
	 * Home page redirect login page
	 */
	public function home() {
		return redirect()->intended('/login');
	}

	/**
	 * Show view full detail tour VR for client
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getFullTourDetail(Request $request) {
		$tour = DB::table('ot_tours')->where('id', $request->id)->get();
		return view('admincp.detailTourFull', ['tour' => $tour]);
	}
}