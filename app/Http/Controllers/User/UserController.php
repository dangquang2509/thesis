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
use App\Models\User;
use App\Models\Ot_Categories;
use App\Models\View_Stat;
use App\Models\Request_Stat;
use SimpleXMLElement;
use Session;

class UserController extends Controller
{
    public function index() {
        $houses = Ot_Tours::where('is_public', true)->orderBy('created_at','desc')->take(3)->get();
        foreach ($houses as $house) {
            $id = $house->id;
            $image_thumb = Ot_Images::where('tour_id', $id)
                                    ->orderBy('created_at','desc')
                                    ->pluck('image_url')
                                    ->first();
            $house->image_thumbnail = $image_thumb;
        }
        return view('user.index', ['houses' => $houses, 'message' => '']);
    }

    public function contact(){
        $houses = Ot_Tours::where('is_public', true)->get();
        foreach ($houses as $house) {
            $id = $house->id;
            $image_thumb = Ot_Images::where('tour_id', $id)
                                    ->orderBy('created_at','desc')
                                    ->pluck('image_url')
                                    ->first();
            $house->image_thumbnail = $image_thumb;
        }
        return view('user.contact')->with(['houses' => json_encode($houses)]);
    }

    public function allHouse(Request $request){
        $order = $request->get("order");
        if ($order === 'price_desc') {
            $houses = Ot_Tours::where('is_public', true)
                                ->orderBy('price', 'desc')
                                ->get();
        } else if ($order === 'price_asc') {
            $houses = Ot_Tours::where('is_public', true)
                                ->orderBy('price', 'asc')
                                ->get();
        } else if ($order === 'time_desc') {
            $houses = Ot_Tours::where('is_public', true)
                                ->orderBy('created_at', 'desc')
                                ->get();
        } else if ($order === 'view_desc') {
            $houses = Ot_Tours::where('is_public', true)
                                ->orderBy('num_views', 'desc')
                                ->get();
        } else {
            $houses = Ot_Tours::where('is_public', true)->get();
        }
        foreach ($houses as $house) {
            $id = $house->id;
            $image_thumb = Ot_Images::where('tour_id', $id)
                                    ->orderBy('created_at','desc')
                                    ->pluck('image_url')
                                    ->first();
            $house->image_thumbnail = $image_thumb;
        }

        return view('user.house', ['houses' => $houses, 'allHouse' => json_encode($houses), 'search' => false, 'order' => $order]);
    }

    public function getHouseDetail(Request $request) {
        $house = Ot_Tours::find($request->id);
        if (!$house) {
            return Redirect('/');
        }
        $now = Carbon::now()->toDateTimeString();

        $house->increment('num_views');
        
        $view_stat = new View_Stat();
        $view_stat->house_id    = $request->id;
        $view_stat->viewed_at   = $now;
        $view_stat->created_at  = $now;
        $view_stat->updated_at  = $now;
        $view_stat->save();

        $title = $house->title;

        $favorites = Session::get('favorites');
        if ($favorites == null){
            $favorites = [];
        }
        $fav = in_array($request->id, $favorites);
        $house->fav = $fav;
        
        $category_name = Ot_Categories::where('id', $house->category_id)->pluck('name')->first();
        $house->category_name = $category_name;
        
        $houseSimilar = Ot_Tours::where('is_public', true)
                                ->where('category_id', $house->category_id)
                                ->where('id', '<>', $house->id)
                                ->orderBy('created_at','desc')->take(3)->get();

        foreach ($houseSimilar as $hs) {
            $image_thumb = Ot_Images::where('tour_id', $hs->id)->pluck('image_url')->first();
            $hs->image_thumbnail = $image_thumb;
        }

        $username = $house->created_by;
        $user = User::where('name', '=', $username)->first();

        $photos = Ot_Images::where('tour_id', $request->id)
                            ->where('type', 2)
                            ->get();

        return view('user.house_detail')->with(['house'         => $house, 
                                                'houseSimilar'  => $houseSimilar, 
                                                'title'         => $title, 
                                                'fav'           => $fav, 
                                                'user'          => $user,
                                                'photos'        => $photos]);
    }

    public function search(Request $request){
        $district = $request->district;
        $houses = Ot_Tours::where('is_public', true)
                            ->where('category_id', '=', $request->category)
                            ->where('num_bedrooms', '=', $request->num_bedrooms)
                            ->where('price', '>=', $request->price_min)
                            ->where('price', '<=', $request->price_max)
                            ->where('district', '=', $request->district)
                            ->get();
        foreach ($houses as $house) {
            $id = $house->id;
            $image_thumb = Ot_Images::where('tour_id', $id)->pluck('image_url')->first();
            $house->image_thumbnail = $image_thumb;
        }
        
        return view('user.house')->with(['houses' => $houses, 'allHouse' => json_encode($houses), 'search' => true, 'order' => ""]);
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
                    $m->to($mailData['email'])->subject('There is a request from guest');
            });

            $now = Carbon::now()->toDateTimeString();

            $request_stat = new Request_Stat();
            $request_stat->house_id     = $id;
            $request_stat->name         = $name;
            $request_stat->email        = $email;
            $request_stat->phone        = $phone;
            $request_stat->message      = $message;
            $request_stat->requested_at = $now;
            $request_stat->created_at   = $now;
            $request_stat->updated_at   = $now;

            $request_stat->save();


            return response()->json(['success' => 'success']);
        } catch(Exception $e) {
            return array("flag" => 'error');
        }
    }

    public function wishlist(){
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

    public function register(Request $request){
        $name           = $request->get("name");
        $email          = $request->get("email");
        $phone          = $request->get("phone");
        $now = Carbon::now()->toDateTimeString();
        
        DB::table('users')->insert([
            'name' => $name,
            'email' => $email,
            'remember_token' => $request->_token,
            'created_at' => $now,
            'updated_at' => $now,
            'role_id' => 2,
            'is_active' => 0
        ]);

        return response()->json(['success' => 'success']);
        
    }
    public function setPublic(Request $request) {
        $id = $request->get("id");
        $house = Ot_Tours::where('id','=', $id)
                            ->first();
        if ($house->is_public) {
            $house->is_public = false;
        } else {
            $house->is_public = true;
        }
        $house->save();
        return response()->json(['success' => 'success']);


    }
}
