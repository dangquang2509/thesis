<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use Redirect;
use Image;
use Carbon\Carbon;
use App\Models\Ot_Tours;
use App\Models\Ot_Images;
use App\Models\User;
use App\Models\View_Stat;
use App\Models\Request_Stat;


class UserController extends Controller
{
	/**
	 * Show view create user
	 */
	public function newUser()
	{
		return view('admincp.newUser');
	}

	/**
	 * Show view list user
	 * If user is admin, show all user
	 * If user is different admin, show list user created by user
	 */
	public function showList()
	{
		$users = array();
		if (Auth::user()->name == "admin") {
			$users = DB::table('users')
				// ->where('role_id', 2)
				->where('is_active', 1)
				->get();
		} else {
			return Redirect('/admincp/top');
		}

		return view('admincp.listUser', ['users' => $users]);
	}
	public function showListRequest() {
		$users = array();
		if (Auth::user()->name == "admin") {
			$users = DB::table('users')
				->where('role_id', 2)
				->where('is_active', 0)
				->get();
		} else {
			return redirect('/admincp/top');
		}

		return view('admincp.listUserRequest', ['users' => $users]);
	}

	/**
	 * Show view detail user
	 * If user is admin, can show detail of all users
	 * If user is different admin, only show detail user created by user
	 */
	public function getUserDetail(Request $request)
	{
		$user = array();
		if (Auth::user()->name == "admin") {
			$user = DB::table('users')->where('id', $request->id)->get();
		}
		if (!$user) {
			return redirect('/admincp/user/myaccount');
		}
		$user_name = DB::table('users')->where('id', $request->id)->pluck('name')->first();

		$houses = Ot_Tours::where('is_public', true)
							->where('created_by', $user_name)
							->get();
        foreach ($houses as $house) {
            $id = $house->id;
            $image_thumb = Ot_Images::where('tour_id', $id)->pluck('image_url')->first();
            $house->image_thumbnail = $image_thumb;
        }

		return view('admincp.detailUser', ['user' => $user, 'houses' => $houses]);
	}

	public function getUserRequestDetail(Request $request)
	{
		$user = array();
		if (Auth::user()->name == "admin") {
			$user = DB::table('users')->where('id', $request->id)->get();
		}

		if (!$user) {
			return redirect('/admincp/user/myaccount');
		}

		return view('admincp.detailUserRequest', ['user' => $user]);
	}


	/**
	 * Save new user
	 */
	public function createUser(Request $request)
	{
		$now = Carbon::now()->toDateTimeString();
		DB::table('users')->insert([
			'name' => $request->username,
			'email' => $request->email,
			'password' => bcrypt($request->password),
			'remember_token' => $request->_token,
			'created_at' => $now,
			'updated_at' => $now,
			'role_id' => 2,
			'is_active' => 1
		]);

		return Redirect::to('admincp/user/list');
	}

	/**
	 * Ajax
	 * Delete a user
	 */
	public function destroy(Request $request)
	{
		$id = $request->id;
		$row = DB::table("users")->where('id', $id)->update(array('is_active' => 0));

		return response()->json(['success' => "User deleted", 'row' => $row]);
	}

	/**
	 * Ajax
	 * Delete multi select users VR
	 */
	public function deleteAllUser(Request $request)
	{
		$ids = $request->ids;
		DB::table("users")->whereIn('id', explode(",", $ids))->update(array('is_active' => 0));
		$userCount = DB::table('users')->sum('is_active');

		return response()->json(['success' => "User deleted", 'userCount' => $userCount]);
	}

	/**
	 * Save edit user
	 */
	public function updateUser(Request $request)
	{
		$now = Carbon::now()->toDateTimeString();
		$user = User::find($request->id);

		if($request->hasFile('avatar')) {
			$avatar = $request->file('avatar');
			$filename = time() . '.' . $avatar->getClientOriginalExtension();
			$avatar_path = 'uploads/user/avatar/' . $filename;
			Image::make($avatar)->save($avatar_path);
			$user->avatar = $avatar_path;
		}

		$user->updated_at 	= $now;
		$user->password 	= bcrypt($request->password);
		$user->phone 		= $request->phone;
		$user->save();
		
		if (Auth::user()->name === 'admin') {
			return Redirect::to('admincp/user/detail/' . $request->id);
		} else {
			return Redirect::to('admincp/user/myaccount');
		}
	}

	public function acceptUser(Request $request) {
		$now = Carbon::now()->toDateTimeString();
		DB::table('users')
			->where('id', $request->id)
			->update(['is_active' => 1,
				'updated_at' => $now]);

		return Redirect::to('admincp/user/listRequest');
	}
	/**
	 * Show view edit user
	 * If user is admin, can show edit of all users
	 * If user is different admin, only show edit user created by user
	 */
	public function editUser(Request $request)
	{
		$user = array();
		if (Auth::user()->name == "admin") {
			$user = DB::table('users')->where('id', $request->id)->get();
		} else {
			$user = DB::table('users')
				->where('name', '=', Auth::user()->name)
				->where('id', $request->id)->get();
		}

		return view('admincp.editUser', ['user' => $user]);
	}

	/**
	 * Show view login
	 * If user authorize, redirect dashboard
	 * If user not authorize, redirect view login
	 */
	public function getLogin()
	{
		$user = Auth::user();
		if ($user == null) {
			return view('auth.login');
		} else {
			return redirect()->intended('/admincp');
		}
	}

	/**
	 * Handle login authorize
	 */
	public function postLogin(Request $request)
	{
		$rules = [
			'username' => 'required',
			'password' => 'required|min:8'
		];
		$messages = [
			'username.required' => 'Please enter your username',
			'password.required' => 'Please enter your password',
			'password.min' => 'Please enter at least 8 letters.',
		];
		$validator = Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		} else {
			$data = [
				'name' => $request->username,
				'password' => $request->password,
			];
			if (Auth::attempt($data)) {
				return redirect('/admincp/house/list');
			} else {
				$errors = new MessageBag(['errorlogin' => 'The username or password is incorrect.']);

				return redirect()->back()->withInput()->withErrors($errors);
			}
		}
	}

	/**
	 * Handle logout
	 */
	public function getLogout()
	{
		Auth::logout();

		return redirect('/admincp/login');
	}

	/**
	 * Show view register user
	 */
	public function showRegister()
	{
		return view('auth.register');
	}

	public function myAccount() {
		$user_name = Auth::user()->name;
		$user = DB::table('users')->where('name', $user_name)->get();
		$houses = Ot_Tours::where('is_public', true)
							->where('created_by', $user_name)
							->get();
        foreach ($houses as $house) {
            $id = $house->id;
            $image_thumb = Ot_Images::where('tour_id', $id)->pluck('image_url')->first();
            $house->image_thumbnail = $image_thumb;
        }

		return view('admincp.detailUser', ['user' => $user, 'houses' => $houses]);
	}

	public function statistic(Request $request){

		$user_name = Auth::user()->name;

		$house_id = $request->id;
		if ($user_name === "admin") {
			$house = Ot_Tours::where('id', $house_id)
								->get();
		} else {
			$house = Ot_Tours::where('id', $house_id)
								->where('created_by', $user_name)
								->get();
		}
		if (count($house) === 0) {
			return redirect('/admincp/house/list');
		}


		$end = strtotime("now");
		$start = strtotime(" -30 day", $end);
		$date_label = [];
		$view_data = []; 
		$request_data = [];
		$total_view = 0;
		$total_request = 0;

		while ($start <= $end) {
			$start = strtotime("+1 day", $start);
			$tmp_date = date('Y-m-d', $start);
			array_push($date_label, $tmp_date);

			$from 	= date('Y-m-d' . ' 00:00:00', $start);
			$to 	= date('Y-m-d' . ' 23:59:59', $start);

			$view_count = View_Stat::where("house_id", $house_id)
								 	->where('viewed_at', '>', $from)
								 	->where('viewed_at', '<', $to)
									->count();
			array_push($view_data, $view_count);

			$request_count = Request_Stat::where("house_id", $house_id)
								 	->where('requested_at', '>', $from)
								 	->where('requested_at', '<', $to)
									->count();
			array_push($request_data, $request_count);

			$total_view += $view_count;
			$total_request += $request_count;
		}
		
		return view('admincp.stat', ["date_label" 	=> json_encode($date_label),
									"view_data"  	=> json_encode($view_data),
									"request_data"	=> json_encode($request_data),
									"total_view" 	=> $total_view,
									"total_request"	=> $total_request]);
	}
}
