<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckFormContact;
use Carbon\Carbon;
use Image;
use File;
use Mail;
use DB;
use App\Models\Ot_Images;
use App\Models\Ot_Plan_Images;
use App\Models\Ot_Tours;
use App\Models\Ot_Categories;
use SimpleXMLElement;
use Session;

class UserController extends Controller
{
    public function index() {
        $houses = Ot_Tours::where('is_public', true)->orderBy('created_at','desc')->take(6)->get();
        foreach ($houses as $house) {
            $id = $house->id;
            $image_thumb = Ot_Images::where('tour_id', $id)->pluck('image_url')->first();
            $house->image_thumbnail = $image_thumb;
        }

        return view('user.index', ['houses' => $houses]);
    }

    public function contact(){
        $houses = Ot_Tours::where('is_public', true)->get();
        foreach ($houses as $house) {
            $id = $house->id;
            $image_thumb = Ot_Images::where('tour_id', $id)->pluck('image_url')->first();
            $house->image_thumbnail = $image_thumb;
        }
        return view('user.contact')->with(['houses' => json_encode($houses)]);
    }

    public function allHouse(){
        $houses = Ot_Tours::where('is_public', true)->get();
        foreach ($houses as $house) {
            $id = $house->id;
            $image_thumb = Ot_Images::where('tour_id', $id)->pluck('image_url')->first();
            $house->image_thumbnail = $image_thumb;
        }

        return view('user.house', ['houses' => $houses, 'allHouse' => json_encode($houses), 'search' => false]);
    }

    public function getHouseDetail(Request $request) {
        $house = Ot_Tours::where('id', $request->id)->get();
        if (count($house) == 0) {
            return Redirect('/user/home');
        }

        $id = null;
        $category_id = null;
        $title = null;

        $favorites = Session::get('favorites');
        if ($favorites == null){
            $favorites = [];
        }
        $fav = in_array($request->id, $favorites);

        foreach ($house as $h) {
            $id = $h->id;
            $category_id = $h->category_id;
            $title = $h->title;
            $category_name = Ot_Categories::where('id', $category_id)->pluck('name')->first();
            $h->category_name = $category_name;
            $h->fav = $fav;
        }
        
        $houseSimilar = Ot_Tours::where('is_public', true)
                                ->where('category_id', $category_id)
                                ->where('id', '<>', $id)
                                ->orderBy('created_at','desc')->take(3)->get();

        foreach ($houseSimilar as $hs) {
            $image_thumb = Ot_Images::where('tour_id', $hs->id)->pluck('image_url')->first();
            $hs->image_thumbnail = $image_thumb;
        }

       

        return view('user.house_detail')->with(['house' => $house, 'houseSimilar' => $houseSimilar, 'title'=> $title, 'fav' => $fav]);
    }

    public function search(Request $request){
        // dd($request->all());
        $houses = Ot_Tours::where('is_public', true)
                            ->where('category_id', '=', $request->category)
                            ->where('num_bedrooms', '=', $request->num_bedrooms)
                            ->where('price', '>=', $request->price_min)
                            ->where('price', '<=', $request->price_max)
                            ->get();
        foreach ($houses as $house) {
            $id = $house->id;
            $image_thumb = Ot_Images::where('tour_id', $id)->pluck('image_url')->first();
            $house->image_thumbnail = $image_thumb;
        }
        
        return view('user.house')->with(['houses' => $houses, 'allHouse' => json_encode($houses), 'search' => true]);
    }

    public function sendRequest(Request $request){
        $name           = $request->get("name");
        $email          = $request->get("email");
        $phone          = $request->get("phone");
        $address        = $request->get("address");
        $content        = $request->get("content");

        $mailTo     = config("mail.username");
        $mailType   = '';
        $params     = [ 'name'  => $name,
                        'email' => $email,
                        'phone' => $phone,
                        'address'=> $address,
                        'content'=> $content
        ];

        try {
            $mailData =array_merge(array('mail' => $mailTo), $params);
            Mail::send('emails.request', array('name'       =>$mailData['name'], 
                                                'email'     =>$mailData['email'],
                                                'address'   =>$mailData['address'],
                                                'phone'     =>$mailData['phone'],
                                                'content'   =>$mailData['content']), 
                function ($m) use ($mailData) {
                    $m->from($mailData['email']);
                    $m->to($mailData['mail'])->subject('There is a request from guest');
            });

            return Redirect('/contact');
        } catch(Exception $e) {

            return array("flag" => 'error');
        }
    }

    public function contactAgent(Request $request){
        $name           = $request->get("name");
        $email          = $request->get("email");
        $phone          = $request->get("phone");
        $message        = $request->get("message");
        $id             = $request->get("id");

        $mailTo = DB::table('houses')
                ->join('users', 'houses.created_by', '=', 'users.name')
                ->where('houses.id', '=', $id)
                ->pluck('users.email');
        $mailType   = '';
        $params     = [ 'name'  => $name,
                        'email' => $email,
                        'phone' => $phone,
                        'message'=> $message
        ];

        try {
            $mailData =array_merge(array('mail' => $mailTo), $params);
            Mail::send('emails.request', array('name'       =>$mailData['name'], 
                                                'email'     =>$mailData['email'],
                                                'phone'     =>$mailData['phone'],
                                                'content'   =>$mailData['message']), 
                function ($m) use ($mailData) {
                    $m->from($mailData['email']);
                    $m->to($mailData['mail'])->subject('There is a request from guest');
            });

            return response()->json(['success' => 'success']);
        } catch(Exception $e) {
            return array("flag" => 'error');
        }
    }

    public function wishlist(){
        // $favorites = [1, 2];
        // Session::put('favorites', $favorites);
        $ids = Session::get('favorites');
        if ($ids !== null) {
            $houses = Ot_Tours::whereIn('id', $ids)->get();
            foreach ($houses as $house) {
                $id = $house->id;
                $image_thumb = Ot_Images::where('tour_id', $id)->pluck('image_url')->first();
                $house->image_thumbnail = $image_thumb;
            }
        } else {
            $houses = [];
        }
        
        return view('user.wishlist')->with(['houses' => $houses]);
    }

    public function addWishlist(Request $request){
        $id = $request->get('id');
        $favorites = Session::get('favorites');
        if ($favorites == null){
            $favorites = [];
        }
        if (!in_array($id, $favorites)) {
            array_push($favorites, $id);
            Session::put('favorites', $favorites);
        }
        return response()->json(['success' => $id]);
    }
    public function removeWishlist(Request $request) {
        $id = $request->get('id');
        $favorites = Session::get('favorites');
        if (($key = array_search($id, $favorites)) !== false) {
            unset($favorites[$key]);
            Session::put('favorites', $favorites);
        }
        return response()->json(['success' => $id]);   
    }
}
