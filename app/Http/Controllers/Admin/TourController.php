<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Image;
use File;
use DB;
use App\Models\Ot_Images;
use App\Models\Ot_Plan_Images;
use App\Models\Ot_Tours;
use SimpleXMLElement;

class TourController extends Controller
{
	/**
	 * Show view create tour VR
	 */
	public function newTour() {
		$categories = DB::table('ot_categories')->get();
		return view('admincp.newTour', ['categories' => $categories]);
	}

	/**
	 * Save new tour VR
	 */
	public function saveNewTour(Request $request) {
		if($request->has('tour_title') && $request->has('tour_param')) {
			$objTour = new Ot_Tours();
			if($request->tour_key != "") {
				$objTour->tour_key = $request->tour_key;
			}

			$objTour->plan_image_id = $request->tour_map;
			$objTour->title 		= $request->tour_title;
			$objTour->description 	= $request->tour_description;
			$objTour->category_id 	= $request->tour_category;
			$objTour->config 		= $request->tour_param;
			$objTour->amenities 		= $request->house_amenities;
			$objTour->project_facility 	= $request->house_project_facility;
			$objTour->traffic 			= $request->house_traffic;
			$objTour->notice 			= $request->house_notice;

			$objTour->address 			= $request->house_address;
			$objTour->latitude 			= $request->house_latitude;
			$objTour->longitude 		= $request->house_longitude;


			$objTour->price 			= $request->house_price;
			$objTour->area 				= $request->house_area;
			$objTour->num_bedrooms 		= $request->house_num_bedroom;
			$objTour->num_toilets 		= $request->house_num_toilet;

			if ($request->tour_published) {
				$objTour->is_public = 1;
			} else {
				$objTour->is_public = 0;
			}
			$objTour->view_url = "";
			$objTour->xml_url = "";
			$objTour->created_by = Auth::user()->name;
			$objTour->updated_by = Auth::user()->name;
			$objTour->save();

			$jSON 	= json_decode($request->tour_param, true);
			$xml 	= new SimpleXMLElement("<krpano/>");
			$xml 	= $this->array2xml($jSON["krpano"], $xml, $xml);

			$dom = new \DOMDocument('1.0');
			$dom->preserveWhiteSpace = false;
			$dom->formatOutput = true;
			$dom->loadXML($xml);

			$now = Carbon::now()->timestamp;
			$pathUpload = 'uploads/tours';
			if (!file_exists($pathUpload)) {
				File::makeDirectory($pathUpload, $mode = 0777, true, true);
			}

			$dom->save($pathUpload.'/'.$now.'.xml');

			foreach($jSON["spheres"] as $key => $value) {
				$idSphere = $value["id"];
				$imgSphere = Ot_Images::where('spherical_id', $idSphere)->first();
				if($imgSphere != null) {
					$imgSphere->tour_id = $objTour->id;
					$imgSphere->save();
				}
			}

			$objTour->view_url = "/tour/".$objTour->id;
			$objTour->xml_url = $pathUpload.'/'.$now.'.xml';
			$objTour->update();

			return Redirect::to('admincp/house/list');
		}
	}

	/**
	 * Save edit tour VR
	 */
	public function SaveEditTour(Request $request) {
		if($request->has('tour_title') && $request->has('tour_param')) {
			if($request->tour_key != "") {
				$tour_key = $request->tour_key;
			}

			$id 			= $request->id;
			$plan_image_id 	= $request->tour_map;
			$title 			= $request->tour_title;
			$description 	= $request->tour_description;
			$category_id 	= $request->tour_category;
			$config 		= $request->tour_param;
			$xmlUrl 		= $request->xml_url;

			$amenities 			= $request->house_amenities;
			$project_facility 	= $request->house_project_facility;
			$traffic 			= $request->house_traffic;
			$notice 			= $request->house_notice;

			$address 	= $request->house_address;
			$latitude 	= $request->house_latitude;
			$longitude 	= $request->house_longitude; 

			$price 			= $request->house_price;
			$area 			= $request->house_area;
			$num_bedroom 	= $request->house_num_bedroom;
			$num_toilet 	= $request->house_num_toilet;

			$now 	= Carbon::now();
			$jSON 	= json_decode($request->tour_param, true);
			$xml 	= new SimpleXMLElement("<krpano/>");
			$xml 	= $this->array2xml($jSON["krpano"], $xml, $xml);

			$dom = new \DOMDocument('1.0');
			$dom->preserveWhiteSpace = false;
			$dom->formatOutput = true;
			$dom->loadXML($xml);

			$dom->save($xmlUrl);

			$img = Ot_Images::where('tour_id', $request->id)->get();
			foreach ($img as $key => $value) {
				if (is_null($value)) {
					$img->tour_id = null;
					$img->save();
				}
			}

			foreach($jSON["spheres"] as $key => $value) {
				$idSphere = $value["id"];
				$imgSphere = Ot_Images::where('spherical_id', $idSphere)->first();
				if ($imgSphere != null) {
					$imgSphere->tour_id = $id;
					$imgSphere->save();
				}
			}

			DB::table('ot_tours')
			->where('id', $id)
			->update([
					'title' 		=> $title,
					'description'	=> $description,
					'plan_image_id' => $plan_image_id,
					'config' 		=> $config,
					'updated_by'    => Auth::user()->name,
					'updated_at'	=> $now,
					'category_id'	=> $category_id,
					'amenities'				=> $amenities ,
					'project_facility'		=> $project_facility,
					'traffic'				=> $traffic,
					'notice'				=> $notice,
					'address'				=> $address,
					'latitude'				=> $latitude,
					'longitude'				=> $longitude,
					'price'					=> $price,
					'area'					=> $area,
					'num_bedrooms'			=> $num_bedroom,
					'num_toilets'			=> $num_toilet]);

			return Redirect::to('admincp/house/detail/'. $id);
		}
	}

	/**
	 * Function convert array to xml
	 * @param $array
	 * @param $xml
	 * @param $parentNode
	 * @return $xml recursive
	 */
	protected function array2xml($array, $xml, $parentNode) {
		foreach($array as $key => $value) {
			if (!is_numeric($key) && !is_array($value)) {
				try {
					$xml->addAttribute($key, $value);
				} catch (Exception $e) {
				}
			}
			else if (!is_numeric($key) && is_array($value)) {
				$flag = false;
				foreach ($value as $k => $v) {
					if ($k == "0") {
						$flag = true;
						break;
					}
				}
				$xmlChild = $xml;
				if ($flag == true) {
					$this->array2xml($value, $xmlChild->addChild($key), $xml);
				} else {
					$xmlChild = $xmlChild->addChild($key);
					$this->array2xml($value, $xmlChild, $xmlChild);
				}
			}
			else if(is_numeric($key) && is_array($value)) {
				if ($key == "0") {
					$this->array2xml($value, $xml, $parentNode);
				} else {
					$name 		= $xml->getName();
					$xmlChild 	= $parentNode;
					$xmlChild 	= $xmlChild->addChild($name);
					$this->array2xml($value, $xmlChild, $parentNode);
				}
			}
		}
		return $xml->asXML();
	}

	/**
	 * Ajax
	 * Upload image VR in Tour
	 */
	public function uploadSpherical(Request $request) {
		if($request->hasFile('file')) {
			$now = Carbon::now()->timestamp;
			$now = $now.'-'.$request->counter;

			$pathUpload = 'uploads/images';

			if (!file_exists($pathUpload)) {
				File::makeDirectory($pathUpload, $mode = 0777, true, true);
			}
			if (!file_exists($pathUpload.'/thumb/')) {
				File::makeDirectory($pathUpload.'/thumb/', $mode = 0777, true, true);
			}

			$img 	= $request->file('file');
			$name 	= $now.'-'.$img->getClientOriginalName();
			Image::make($img->getRealPath())->resize(180, 90)->save($pathUpload.'/thumb/'.$name);
			$img->move($pathUpload, $name);

			$objImage = new Ot_Images();
			$objImage->spherical_id = $now;
			$objImage->title = '';
			$objImage->image_url = $name;
			$objImage->description = '';
			$objImage->is_public = 1;
			$objImage->view_url = '/image/'.$now;
			$objImage->created_by = Auth::user()->name;
			$objImage->updated_by = Auth::user()->name;
			$objImage->save();

			$file = array();
			$file["sphere_id"] = $now;
			$file["equirectangular_source"] = '/'.$pathUpload.'/'.$name;
			$file["thumbnail_source"] = '/'.$pathUpload.'/thumb/'.$name;
			$file["toursphere_url"] = '/image/'.$now;

			$ret['data'] = $file;
			return response()->json($ret['data']);
		}
	}

	/**
	 * Ajax
	 * Upload image minimap
	 */
	public function uploadPlan(Request $request) {
		if($request->hasFile('file')) {
			$now = Carbon::now()->timestamp;
			$pathUpload = 'uploads/plans';

			if (!file_exists($pathUpload)) {
				File::makeDirectory($pathUpload, $mode = 0777, true, true);
			}

			$img = $request->file('file');
			$name = $now.'-'.$img->getClientOriginalName();
			$img->move($pathUpload, $name);

			$objPlanImage = new Ot_Plan_Images();
			$objPlanImage->title = '';
			$objPlanImage->image_url = $name;
			$objPlanImage->description = '';
			$objPlanImage->created_by = Auth::user()->name;
			$objPlanImage->updated_by = Auth::user()->name;
			$objPlanImage->save();

			$file = array();
			$file["source"] = '/'.$pathUpload.'/'.$name;
			$file["id"] = $objPlanImage->id;

			$ret['data'] = $file;
			return response()->json($ret['data']);
		}
	}

	/**
	 * Ajax
	 * Delete image minimap
	 */
	public function deletePlan(Request $request) {
		$ret['data'] = false;
		if($request->has('id')) {
			$imagePlan = DB::table('ot_plan_images')->where('id', $request->id)->first();
			if($imagePlan != null) {
				DB::table('ot_plan_images')->where('id', $request->id)->delete();
				$ret['data'] = true;
			}
		}
		return response()->json($ret['data']);
	}

	/**
	 * Ajax
	 * Check tour key exist
	 */
	public function checkTourKey(Request $request) {
		$ret['data'] = false;
		if($request->has('key')) {
			$tourByKey = DB::table('ot_tours')->where('tour_key', $request->key)->first();
			if($tourByKey != null) {
				$ret['data'] = true;
			}
		}
		return response()->json($ret['data']);
	}

	/**
	 * Show detail tour VR
	 * If user is admin, can show detail of all tours
	 * If user is different admin, only show detail tour created by user
	 */
	public function getTourDetail(Request $request) {
		$tour = array();
		if(Auth::user()->name == "admin") {
			$tour = DB::table('ot_tours')->where('id', $request->id)->get();
		} else {
			$tour = DB::table('ot_tours')
						->where('created_by', '=', Auth::user()->name)
						->where('id', $request->id)->get();
		}

		if(count($tour) > 0) {
			return view('admincp.detailTour', ['tour' => $tour]);
		} else {
			return redirect()->intended('/admincp');
		}
	}

	/**
	 * Show view list tour VR
	 * If user is admin, show all tours
	 * If user is different admin, show list tour created by user
	 */
	public function showList() {
		$tours = array();
		if(Auth::user()->name == "admin") {
			$tours = DB::table('ot_tours')
				->get();
		} else {
			$tours = DB::table('ot_tours')
				->where('created_by', '=', Auth::user()->name)
				->get();
		}
		// $tours = DB::table('ot_tours')
		// 	->where('created_by', '=', Auth::user()->name)
		// 	->get();
		return view('admincp.listTour', ['tours' => $tours]);
	}

	/**
	 * Show view edit tour VR
	 * If user is admin, can show edit of all tours
	 * If user is different admin, only show edit tour created by user
	 */
	public function editTour(Request $request) {
		$tour = array();
		if(Auth::user()->name == "admin") {
			$tour 		= DB::table('ot_tours')
							->where('id', $request->id)->get();
		} else {
			$tour 		= DB::table('ot_tours')
							->where('created_by', '=', Auth::user()->name)
							->where('id', $request->id)->get();
		}
		if(count($tour) > 0) {
			$floorMapId = DB::table('ot_tours')->where('id', $request->id)->pluck('plan_image_id');
			$floorMap 	= DB::table('ot_plan_images')->where('id', $floorMapId)->pluck('image_url');
			$categories = DB::table('ot_categories')->get();
			return view('admincp.editTour', ['tour' => $tour, 'floorMapUrl' => $floorMap, 'categories' => $categories]);
		} else {
			return redirect()->intended('/admincp');
		}
	}

	/**
	 * Ajax
	 * Delete a tour VR
	 */
	public function destroy(Request $request) {
		$id = $request->id;

		$xmlPath = DB::table('ot_tours')->where('id', $id)->pluck('xml_url');
		$fullXmlPath = public_path($xmlPath);
		$fullXmlPath = str_replace(array("\"","[","]","/"), "", $fullXmlPath);
		if (File::exists($fullXmlPath)) {
			File::delete($fullXmlPath);
		}

		$imageFloorId 	= DB::table('ot_tours')->where('id', $id)->pluck('plan_image_id');
		$imageFloorUrl 	= DB::table('ot_plan_images')->where('id', $imageFloorId)->pluck('image_url');

		$fullFloorMapPath = 'uploads/plans/'. $imageFloorUrl;
		$fullFloorMapPath = str_replace(array("\"","[","]"), "", $fullFloorMapPath);
		if (File::exists($fullFloorMapPath)) {
			File::delete($fullFloorMapPath);
		}
		DB::table('ot_plan_images')->where('id', $imageFloorId)->delete();

		$imageList = Ot_Images::where('tour_id', $id)->get();
		foreach ($imageList as $img) {
			$imageUrl 	= $img->image_url;
			$imagePath 	= 'uploads/images/'. $imageUrl;
			if (File::exists($imagePath)) {
				File::delete($imagePath);
			}

			$imageThumbPath = 'uploads/images/thumb/' . $imageUrl;
			if (File::exists($imageThumbPath)) {
				File::delete($imageThumbPath);
			}
			$img->delete();
		}

		$row = DB::table("ot_tours")
			->where('id', $id)
			->where('created_by', '=', Auth::user()->name)
			->delete();

		return response()->json(['success' => "コンテンツを削除しました。", 'row' => $row, 'id' => $id]);
	}

	/**
	 * Ajax
	 * Delete multi select tours VR
	 */
	public function deleteAllTour(Request $request) {
		$ids = $request->ids;
		$idArray =  explode(',', $ids);
		for ($i = 0; $i < count($idArray); $i++) {
			$xmlPath = DB::table('ot_tours')->where('id', $idArray[$i])->pluck('xml_url');
			$fullXmlPath = public_path($xmlPath);
			$fullXmlPath = str_replace(array("\"","[","]","/"), "", $fullXmlPath);
			if (File::exists($fullXmlPath)) {
				File::delete($fullXmlPath);
			}

			$imageFloorId = DB::table('ot_tours')->where('id', $idArray[$i])->pluck('plan_image_id');
			$imageFloorUrl = DB::table('ot_plan_images')->where('id', $imageFloorId)->pluck('image_url');

			$fullFloorMapPath = 'uploads/plans/'. $imageFloorUrl;
			$fullFloorMapPath = str_replace(array("\"","[","]"), "", $fullFloorMapPath);
			if (File::exists($fullFloorMapPath)) {
				File::delete($fullFloorMapPath);
			}
			DB::table('ot_plan_images')->where('id', $imageFloorId)->delete();

			$imageList = Ot_Images::where('tour_id', $idArray[$i])->get();
			foreach ($imageList as $img) {
				$imageUrl = $img->image_url;
				$imagePath = 'uploads/images/'. $imageUrl;
				if (File::exists($imagePath)) {
					File::delete($imagePath);
				}

				$imageThumbPath = 'uploads/images/thumb/' . $imageUrl;
				if (File::exists($imageThumbPath)) {
					File::delete($imageThumbPath);
				}
				$img->delete();
			}
			DB::table('ot_tours')->where('id', $idArray[$i])->delete();
		}
		$tourCount = DB::table('ot_tours')->count();

		return response()->json(['success' => "コンテンツを削除しました。", 'tourCount' => $tourCount]);
	}

	/**
	 * Show view 6 newest tour VR by category
	 * If user is admin, show all image
	 * If user is different admin, show list image created by user
	 */
	public function showRecentTour() {
		$tours_model_house = array();
		if(Auth::user()->name == "admin") {
			$tours_model_house 	= DB::table('ot_tours')
				->where('category_id', 1)->orderBy('created_at','desc')->take(6)->get();
		} else {
			$tours_model_house 	= DB::table('ot_tours')
				->where('created_by', '=', Auth::user()->name)
				->where('category_id', 1)->orderBy('created_at','desc')->take(6)->get();
		}

		$tours_property = array();
		if(Auth::user()->name == "admin") {
			$tours_property 	= DB::table('ot_tours')->where('category_id', 2)->orderBy('created_at','desc')->take(6)->get();
		} else {
			$tours_property 	= DB::table('ot_tours')
				->where('created_by', '=', Auth::user()->name)
				->where('category_id', 2)->orderBy('created_at','desc')->take(6)->get();
		}
		$countResult 		= $tours_model_house->count();

		$imageListModelHouse 	= array();
		$tourModelHouseIdList 	= DB::table('ot_tours')->where('category_id', 1)->orderBy('created_at','desc')->take(6)->pluck('id');
		for ($i = 0; $i < $countResult; $i++) {
			$image = DB::table('ot_images')->where('tour_id', $tourModelHouseIdList[$i])->pluck('image_url')->first();
			array_push($imageListModelHouse, $image);
		}

		$countResult 	= $tours_property->count();
		$imageListProperty 		= array();
		$tourPropertyIdList 	= DB::table('ot_tours')->where('category_id', 2)->orderBy('created_at','desc')->take(6)->pluck('id');
		for ($i = 0; $i < $countResult; $i++) {
			$image = DB::table('ot_images')->where('tour_id', $tourPropertyIdList[$i])->pluck('image_url')->first();
			array_push($imageListProperty, $image);
		}

		return view('admincp.top', ['toursModelHouse' => $tours_model_house, 'imagesModelHouse' => $imageListModelHouse,
									'toursProperty' => $tours_property, 'imagesProperty' => $imageListProperty]);
	}
}
