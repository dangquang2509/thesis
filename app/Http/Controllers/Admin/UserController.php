<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use Redirect;
use Carbon\Carbon;
use App\Models\Ot_Tours;
use App\Models\Ot_Images;

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
				->where('role_id', 2)
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
		} else {
			$user = DB::table('users')
				->where('name', '=', Auth::user()->name)
				->where('id', $request->id)->get();
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
		} else {
			$user = DB::table('users')
				->where('name', '=', Auth::user()->name)
				->where('id', $request->id)->get();
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
		DB::table('users')
			->where('id', $request->id)
			->update(['password' => bcrypt($request->password),
				'updated_at' => $now]);
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

		return redirect()->intended('/');
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
}
