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
			$users = DB::table('users')
				->where('name', '=', Auth::user()->name)
				->where('is_active', 1)
				->get();
		}

		return view('admincp.listUser', ['users' => $users]);
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

		return view('admincp.detailUser', ['user' => $user]);
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

		return response()->json(['success' => "ユーザーを削除しました", 'row' => $row]);
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

		return response()->json(['success' => "ユーザーを削除しました。", 'userCount' => $userCount]);
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

		return Redirect::to('admincp/user/detail/' . $request->id);
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
			'username.required' => 'ユーザーIDを入力してください。',
			'password.required' => 'パスワードを入力してください。',
			'password.min' => 'パスワードを8文字以上入力してください。',
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
				return redirect()->intended('/admincp');
			} else {
				$errors = new MessageBag(['errorlogin' => 'ユーザーIDまたはパスワードが正しくありません。']);

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
}
