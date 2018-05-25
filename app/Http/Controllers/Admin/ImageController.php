<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Image;
use Input;
use DB;
use File;

use App\Models\Ot_Images;

class ImageController extends Controller
{
	/**
	 * Show view list image VR
	 * If user is admin, show all image
	 * If user is different admin, show list image created by user
	 */
	public function showList()
	{
		$images = array();
		if (Auth::user()->name == "admin") {
			$images = DB::table('images')->get();
		} else {
			$images = DB::table('images')
				->where('created_by', '=', Auth::user()->name)
				->get();
		}

		return view('admincp.listImage', ['images' => $images]);
	}

	/**
	 * Show view detail image VR
	 * If user is admin, can show detail of all images
	 * If user is different admin, only show detail image created by user
	 */
	public function getImageDetail(Request $request)
	{
		$image = array();
		if (Auth::user()->name == "admin") {
			$image = DB::table('images')
				->where('id', $request->id)
				->get();
		} else {
			$image = DB::table('images')
				->where('id', $request->id)
				->where('created_by', '=', Auth::user()->name)
				->get();
		}

		if (count($image) > 0) {
			return view('admincp.detailImage', ['image' => $image]);
		} else {
			return redirect()->intended('/admincp');
		}
	}

	/**
	 * Show view edit image VR
	 * If user is admin, can show edit of all images
	 * If user is different admin, only show edit image created by user
	 */
	public function editImage(Request $request)
	{
		$image = array();
		if (Auth::user()->name == "admin") {
			$image = DB::table('images')
				->where('id', $request->id)
				->get();
		} else {
			$image = DB::table('images')
				->where('id', $request->id)
				->where('created_by', '=', Auth::user()->name)
				->get();
		}

		if (count($image) > 0) {
			return view('admincp.editImage', ['image' => $image]);
		} else {
			return redirect()->intended('/admincp');
		}
	}

	/**
	 * Show view create image
	 */
	public function newImage()
	{
		return view('admincp.newImage');
	}

	/**
	 * Save new image VR
	 */
	public function createImage()
	{
		$now = Carbon::now()->timestamp;

		$image = new Ot_Images();
		$image->spherical_id = $now;
		$image->title = Input::get('title');
		$pathUpload = 'uploads/images';
		if (Input::hasFile('image_url')) {
			$img = Input::file('image_url');
			$name = $now . '-' . $img->getClientOriginalName();
			Image::make($img->getRealPath())->resize(180, 90)->save($pathUpload . '/thumb/' . $name);
			$img->move($pathUpload, $name);

			$image->image_url = $name;
		}
		$image->description = Input::get('description');
		if (Input::get('is_public') == true) {
			$image->is_public = 1;
		} else {
			$image->is_public = 0;
		}
		$image->created_by = Auth::user()->name;
		$image->updated_by = Auth::user()->name;
		$image->view_url = "/image/" . $now;
		$image->save();

		return Redirect::to('admincp/image/new');
	}

	/**
	 * Save edit image VR
	 */
	public function updateImage(Request $request)
	{
		$now = Carbon::now()->toDateTimeString();
		DB::table('images')
			->where('id', $request->id)
			->update([
				'title' => $request->title,
				'description' => $request->description,
				'updated_by' => Auth::user()->name,
				'updated_at' => $now]);

		return Redirect::to('admincp/image/detail/' . $request->id);
	}

	/**
	 * Ajax
	 * Delete a image VR
	 */
	public function destroy(Request $request)
	{
		$id = $request->id;

		$image = Ot_Images::where('id', $id)->first();
		$image_url = $image->image_url;
		$image_path = 'uploads/images/' . $image_url;
		$image_thumb_path = 'uploads/images/thumb/' . $image_url;

		$row = DB::table("images")
			->where('id', $id)
			->where('created_by', '=', Auth::user()->name)
			->whereNull('tour_id')->delete();

		if ($row > 0) {
			if (File::exists($image_path)) {
				File::delete($image_path);
			}
			if (File::exists($image_thumb_path)) {
				File::delete($image_thumb_path);
			}
		}

		return response()->json(['success' => "360画像を削除しました。", 'row' => $row]);
	}

	/**
	 * Ajax
	 * Delete multi select images VR
	 */
	public function deleteAllImage(Request $request)
	{
		$ids = $request->ids;
		$row = DB::table("images")
			->where('created_by', '=', Auth::user()->name)
			->whereIn('id', explode(",", $ids))->whereNull('tour_id')->delete();
		$imageCount = DB::table('images')->count();

		return response()->json(['success' => "360画像を削除しました。", 'imageCount' => $imageCount, 'row' => $row]);
	}
}
