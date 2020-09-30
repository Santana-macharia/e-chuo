<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Category;
use App\Sponsorship;
use App\City;
use App\Country;
use App\County;
use App\Media;
use App\Payment;
use App\Report_ad;
use App\State;
use App\Sub_Category;
use App\User;
use App\Gender;
use App\Accomodation;
use App\Religion;
use App\Special_need;
use App\Curriculum;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('app.all_ads');
        $ads = Ad::with('city', 'country', 'state')->whereStatus(1)->orderBy('id', 'desc')->paginate(20);

        return view('admin.all_ads', compact('title', 'ads'));
    }

    public function adminPendingAds()
    {
        $title = trans('app.pending_ads');
        $ads = Ad::with('city', 'country', 'state')->whereStatus(0)->orderBy('id', 'desc')->paginate(20);

        return view('admin.all_ads', compact('title', 'ads'));
    }
    
    public function adminBlockedAds()
    {
        $title = trans('app.blocked_ads');
        $ads = Ad::with('city', 'country', 'state')->whereStatus(2)->orderBy('id', 'desc')->paginate(20);

        return view('admin.all_ads', compact('title', 'ads'));
    }
    
    public function myAds(){
        $title = trans('app.my_ads');

        $user = Auth::user();
        $ads = $user->ads()->with('city', 'country', 'state')->orderBy('id', 'desc')->paginate(20);
        
        return view('admin.my_ads', compact('title', 'ads'));
    }

    public function pendingAds(){
        $title = trans('app.my_ads');

        $user = Auth::user();
        $ads = $user->ads()->whereStatus(0)->with('city', 'country', 'state')->orderBy('id', 'desc')->paginate(20);

        return view('admin.pending_ads', compact('title', 'ads'));
    }

    public function favoriteAds(){
        $title = trans('app.favourite_ads');

        $user = Auth::user();
        $ads = $user->favourite_ads()->with('city', 'country', 'state')->orderBy('id', 'desc')->paginate(20);
        
        return view('admin.favourite_ads', compact('title', 'ads'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = Auth::user()->id;
        $title = trans('app.post_an_ad');
        $categories = Category::all();
        $genders = Gender::all();
        $sponsorships = Sponsorship::all();
        $accomadations = Accomodation::all();
        $religions = Religion::all();
        $needs = Special_need::all();
        $curriculums = Curriculum::all();
        $counties = County::all();
        $ads_images = Media::whereUserId($user_id)->whereAdId(0)->whereRef('ad')->get();
        
        $previous_states = State::where('country_id', old('country'))->get();
        $previous_cities = City::where('state_id', old('state'))->get();


        return view('admin.create_ad', compact('title', 'categories', 'counties', 'ads_images', 'accomadations', 'previous_states', 'previous_cities', 'genders', 'sponsorships', 'religions', 'needs', 'curriculums'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $ads_price_plan = get_option('ads_price_plan');


        $rules = [
            'ad_title'  => 'required',
            'ad_description'  => 'required',
            'gender'  => 'required',
            'sponsorship'  => 'required',
        ];

        if( $ads_price_plan != 'all_ads_free'){
            $rules['price_plan'] = 'required';
        }

        $this->validate($request, $rules);

        $title = $request->ad_title;
        $slug = unique_slug($title);

        $is_negotialble = $request->negotiable ? $request->negotiable : 0;
        $mark_ad_urgent = $request->mark_ad_urgent ? $request->mark_ad_urgent : 0;
        $video_url = $request->video_url ? $request->video_url : '';

        $amenities = serialize($request->amenities);
        $distances = serialize($request->distances);

        $data = [
            'name'          => $request->ad_title,
            'motto'          => $request->motto,
            'slug'          => $slug,
            'description'   => $request->ad_description,
            'gender'        => $request->gender,

            'sponsorship'  => $request->sponsorship,
            'accomodation' => $request->accomodation,
            'needs'        => $request->needs,
            'religion'     => $request->religion,
            'curriculum'   => $request->curriculum,
            'county'       => $request->county,
            'town'         => $request->town,
            'category'     => $request->category,
            'fees'         => $request->fees,
            'yoe'          => $request->yoe,

            'email'         => $request->email,
            'email1'        => $request->email1,
            'phone'         => $request->seller_phone,
            'phone1'        => $request->phone1,
            'code'          => $request->code,
            'address'       => $request->address,
            'website'       => $request->website,


            'price_plan'    => $request->price_plan,
            'mark_ad_urgent' => $mark_ad_urgent,
            'status'        => 0,
            'user_id'       => $user_id,
        ];

        //Check ads moderation settings
        if (get_option('ads_moderation') == 'direct_publish'){
            $data['status'] = 1;
        }

        //if price_plan not in post data, then set a default value, although mysql will save it as enum first value
        if ( ! $request->price_plan){
            $data['price_plan'] = 'regular';
        }

        $created_ad = Ad::create($data);

        /**
         * iF add created
         */
        if ($created_ad){
            //Attach all unused media with this ad
            Media::whereUserId($user_id)->whereAdId(0)->whereRef('ad')->update(['ad_id'=>$created_ad->id]);

            /**
             * Payment transaction login here
             */
            $ads_price = get_ads_price($created_ad->price_plan);
            if ($mark_ad_urgent){
                $ads_price = $ads_price + get_option('urgent_ads_price');
            }

            if ($ads_price){
                //Insert checkout Logic

                $transaction_id = 'tran_'.time().str_random(6);
                // get unique recharge transaction id
                while( ( Payment::whereLocalTransactionId($transaction_id)->count() ) > 0) {
                    $transaction_id = 'reid'.time().str_random(5);
                }
                $transaction_id = strtoupper($transaction_id);

                $currency = get_option('currency_sign');
                $payments_data = [
                    'ad_id'     => $created_ad->id,
                    'user_id'   => $user_id,
                    'amount'    => $ads_price,
                    'payment_method'    => $request->payment_method,
                    'status'    => 'initial',
                    'currency'  => $currency,
                    'local_transaction_id'  => $transaction_id
                ];
                $created_payment = Payment::create($payments_data);

                return redirect(route('payment_checkout', $created_payment->local_transaction_id));
            }

            return redirect(route('my_ads'))->with('success', trans('app.ad_created_msg'));

        }
        

        //dd($request->input());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $title = trans('app.edit_ad');
        $ad = Ad::find($id);

        if (!$ad)
            return view('admin.error.error_404');

        if (! $user->is_admin()){
            if ($ad->user_id != $user_id){
                return view('admin.error.error_404');
            }
        }

        $countries = Country::all();
        $ads_images = Media::whereUserId($user_id)->whereAdId(0)->whereRef('ad')->get();

        $previous_states = State::where('country_id', $ad->country_id)->get();
        $previous_cities = City::where('state_id', $ad->state_id)->get();

        $categories = Category::all();
        $distances = Brand::all();

        return view('admin.edit_ad', compact('title', 'categories', 'countries', 'ads_images', 'ad', 'distances', 'previous_states', 'previous_cities'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ad = Ad::find($id);
        $user = Auth::user();
        $user_id = $user->id;

        if (! $user->is_admin()){
            if ($ad->user_id != $user_id){
                return view('admin.error.error_404');
            }
        }
        $mark_ad_urgent = $request->mark_ad_urgent ? $request->mark_ad_urgent : 0;

        $rules = [
            'ad_title'  => 'required',
            'ad_description'  => 'required',
            'type'  => 'required',
            'purpose'  => 'required',
            'country'  => 'required',
            'seller_name'  => 'required',
            'seller_email'  => 'required',
            'seller_phone'  => 'required',
            'address'  => 'required',
            'latitude'  => 'required',
            'longitude'  => 'required',
        ];

        $this->validate($request, $rules);

        $title = $request->ad_title;
        //$slug = unique_slug($title);
        
        $sub_category = Category::find($request->category);
        $is_negotialble = $request->negotiable ? $request->negotiable : 0;
        $brand_id = $request->brand ? $request->brand : 0;
        $video_url = $request->video_url ? $request->video_url : '';

        $amenities = serialize($request->amenities);
        $distances = serialize($request->distances);

        $data = [
             'name'          => $request->ad_title,
            'motto'          => $request->motto,
            'slug'          => $slug,
            'description'   => $request->ad_description,
            'gender'        => $request->gender,

            'sponsorship'  => $request->sponsorship,
            'accomodation' => $request->accomodation,
            'needs'        => $request->needs,
            'religion'     => $request->religion,
            'curriculum'   => $request->curriculum,
            'county'       => $request->county,
            'town'         => $request->town,
            'category'     => $request->category,
            'fees'         => $request->fees,
            'yoe'          => $request->yoe,

            'email'         => $request->email,
            'email1'        => $request->email1,
            'phone'         => $request->seller_phone,
            'phone1'        => $request->phone1,
            'code'          => $request->code,
            'address'       => $request->address,
            'website'       => $request->website,

            //'mark_ad_urgent' => $mark_ad_urgent,

        ];
        
        $updated_ad = $ad->update($data);

        /**
         * iF add created
         */
        if ($updated_ad){
            //Attach all unused media with this ad
            Media::whereUserId($user_id)->whereAdId(0)->whereRef('ad')->update(['ad_id'=>$ad->id]);
        }

        return redirect()->back()->with('success', trans('app.ad_updated'));
    }


    public function adStatusChange(Request $request){
        $slug = $request->slug;
        $ad = Ad::whereSlug($slug)->first();
        if ($ad){
            $value = $request->value;
            /*
            $ad->status = $value;
            $ad->save();*/
            ad_status_change($ad->id, $value);
            if ($value ==1){
                return ['success'=>1, 'msg' => trans('app.ad_approved_msg')];
            }elseif($value ==2){
                return ['success'=>1, 'msg' => trans('app.ad_blocked_msg')];
            }
            elseif($value ==3){
                return ['success'=>1, 'msg' => trans('app.ad_archived_msg')];
            }
        }
        return ['success'=>0, 'msg' => trans('app.error_msg')];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $slug = $request->slug;
        $ad = Ad::whereSlug($slug)->first();
        if ($ad){
            $media = Media::whereAdId($ad->id)->get();
            if ($media->count() > 0){
                foreach($media as $m){
                    $storage = Storage::disk($m->storage);
                    if ($storage->has('uploads/images/'.$m->media_name)){
                        $storage->delete('uploads/images/'.$m->media_name);
                    }
                    if ($m->type == 'image'){
                        if ($storage->has('uploads/images/thumbs/'.$m->media_name)){
                            $storage->delete('uploads/images/thumbs/'.$m->media_name);
                        }
                    }
                    $m->delete();
                }
            }
            $ad->delete();
            return ['success'=>1, 'msg' => trans('app.media_deleted_msg')];
        }
        return ['success'=>0, 'msg' => trans('app.error_msg')];
    }

    public function getSubCategoryByCategory(Request $request){
        $category_id = $request->category_id;
        $brands = Sub_Category::whereCategoryId($category_id)->select('id', 'category_name', 'category_slug')->get();
        return $brands;
    }

    public function getBrandByCategory(Request $request){
        $category_id = $request->category_id;
        $brands = Brand::whereCategoryId($category_id)->select('id', 'brand_name')->get();
        return $brands;
    }

    public function getStateByCountry(Request $request){
        $country_id = $request->country_id;
        $states = State::whereCountryId($country_id)->select('id', 'state_name')->get();
        return $states;
    }

    public function getCityByState(Request $request){
        $state_id = $request->state_id;
        $cities = City::whereStateId($state_id)->select('id', 'city_name')->get();
        return $cities;
    }

    public function getParentCategoryInfo(Request $request){
        $category_id = $request->category_id;
        $sub_category = Category::find($category_id);
        $category = Category::find($sub_category->category_id);
        return $category;
    }

    public function uploadAdsImage(Request $request){
        $user_id = Auth::user()->id;

        if ($request->hasFile('images')){
            $image = $request->file('images');
            $valid_extensions = ['jpg','jpeg','png'];

            if ( ! in_array(strtolower($image->getClientOriginalExtension()), $valid_extensions) ){
                return ['success' => 0, 'msg' => implode(',', $valid_extensions).' '.trans('app.valid_extension_msg')];
            }

            $file_base_name = str_replace('.'.$image->getClientOriginalExtension(), '', $image->getClientOriginalName());

            $resized = Image::make($image)->resize(640, null, function ($constraint) {
                $constraint->aspectRatio();
            })->stream();
            $resized_thumb = Image::make($image)->resize(320, 213)->stream();

            $image_name = strtolower(time().str_random(5).'-'.str_slug($file_base_name)).'.' . $image->getClientOriginalExtension();

            $imageFileName = 'uploads/images/'.$image_name;
            $imageThumbName = 'uploads/images/thumbs/'.$image_name;

            try{
                //Upload original image
                $is_uploaded = current_disk()->put($imageFileName, $resized->__toString(), 'public');

                if ($is_uploaded) {
                    //Save image name into db
                    $created_img_db = Media::create(['user_id' => $user_id, 'media_name'=>$image_name, 'is_feature'=>'1', 'type'=>'image', 'storage' => get_option('default_storage'), 'ref'=>'ad']);

                 

                    //upload thumb image
                    current_disk()->put($imageThumbName, $resized_thumb->__toString(), 'public');
                    $img_url = media_url($created_img_db, false);
                    return ['success' => 1, 'img_url' => $img_url];
                } else {
                    return ['success' => 0];
                }
            } catch (\Exception $e){
                return $e->getMessage();
            }

        }
    }

    /**
     * @param Request $request
     * @return array
     */

    public function deleteMedia(Request $request){
        $media_id = $request->media_id;
        $media = Media::find($media_id);

        $storage = Storage::disk($media->storage);
        if ($storage->has('uploads/images/'.$media->media_name)){
            $storage->delete('uploads/images/'.$media->media_name);
        }

        if ($media->type == 'image'){
            if ($storage->has('uploads/images/thumbs/'.$media->media_name)){
                $storage->delete('uploads/images/thumbs/'.$media->media_name);
            }
        }

        $media->delete();
        return ['success'=>1, 'msg'=>trans('app.media_deleted_msg')];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function featureMediaCreatingAds(Request $request){
        $user_id = Auth::user()->id;
        $media_id = $request->media_id;

        Media::whereUserId($user_id)->whereAdId('0')->whereRef('ad')->update(['is_feature'=>'0']);
        Media::whereId($media_id)->update(['is_feature'=>'1']);

        return ['success'=>1, 'msg'=>trans('app.media_featured_msg')];
    }

    /**
     * @return mixed
     */
    
    public function appendMediaImage(){
        $user_id = Auth::user()->id;
        $ads_images = Media::whereUserId($user_id)->whereAdId(0)->whereRef('ad')->get();

        return view('admin.append_media', compact('ads_images'));
    }

    //echuo listing




    public function search(Request $request){
        $ads = Ad::active();

        $premium_ads = Ad::activePremium();
        $total_school = 0;
        $cat = '';
        $sponsor = '';
        $county_name = '';
        $needs = '';
        $accomodation = '';
        $gender = '';
        $religion = '';
        $title = 'All Schools';

     

      

        if ($request->q){
            $ads = $ads->where(function($ads) use($request){
                $ads->where('name','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->orWhere('town','like', "%{$request->q}%");
            });

            $search = $request->q;

            $title = 'Schools in '.$search;
        }
          if ($request->category){
            $ads = $ads->whereCategory($request->category);
          
             $cat = $request->category;
             $cat = Category::whereId($cat)->first();
             $cat = $cat->category_name;
             $title = 'Search results for >>';
          
        }

        if ($request->sponsorship){
            $ads = $ads->whereSponsorship($request->sponsorship);
            $sponsor = Sponsorship::whereId($request->sponsorship)->first();
            $sponsor = $sponsor->name;
            $title = 'Search results for >>';
        }

         if ($request->county){
            $ads = $ads->whereCounty($request->county);
             $county = County::whereId($request->county)->first();
             $county_name = $county->name;
             $title = 'Search results for >>';
        }

        if ($request->special_needs){
            $ads = $ads->whereNeeds($request->special_needs);
            $needs = Special_need::whereId($request->special_needs)->first();
            $needs = $needs->name;
            $title = 'Search results for >>';
        }

          if ($request->accomodation){
            $ads = $ads->whereAccomodation($request->accomodation);
            $accomodation = Accomodation::whereId($request->accomodation)->first();
            $accomodation = $accomodation->name;    
           $title = 'Search results for >>';
                }


            if ($request->gender){
            $ads = $ads->whereGender($request->gender);
            $gender = Gender::whereId($request->gender)->first();
            $gender = $gender->name;
            $title = 'Search results for >>';
        }

           if ($request->religion){
            $ads = $ads->whereReligion($request->religion);
            $religion = Religion::whereId($request->religion)->first();
            $religion = $religion->name;
            $title = 'Search results for >>';
        }
     
     
    
        $ads_per_page = get_option('ads_per_page');
        $ads = $ads->paginate($ads_per_page);


      
      
        $categories = Category::all();
        $sponsorships = Sponsorship::all();
        $counties = county::all();

        $selected_categories = Category::find($request->category);
        $selected_sub_categories = Category::find($request->sub_category);

        $selected_countries = Country::find($request->country);
        $selected_states = State::find($request->state);
        //dd($selected_countries->states);

        //calculate total
         $total_school = $ads->count();
       


          


     $agents = User::whereActiveStatus('1')->whereFeature('1')->whereUserType('user')->with('ads', 'country')->take(10)->orderBy('id', 'desc')->get();

      return view('theme.echuo.index', compact('ads', 'title', 'selected_categories', 'selected_sub_categories', 'selected_countries', 'selected_states', 'premium_ads', 'agents', 'categories', 'total_school', 'sponsorships', 'counties' , 'cat', 'sponsor', 'county_name', 'needs', 'accomodation', 'gender', 'religion'));
  
    }


 



        /**
     * @param $slug
     * @return mixed
     */
    public function singleSchool($slug){
        $limit_regular_ads = get_option('number_of_free_ads_in_home');
        $ad = Ad::whereId($slug)->first();

        if (! $ad){
            return view('theme.error_404');
        }
        
        if ( ! $ad->is_published()){
            if (Auth::check()){
                $user = Auth::user();
                if (! $user->is_admin() && $user->id != $ad->user_id){
                    return view('theme.error_404');
                }
            }else{
                return view('theme.error_404');
            }
        }else{
            $ad->view = $ad->view+1;
            $ad->save();
        }

        $title = $ad->title;
        $ad_agent_id = $ad->user_id;

        //Get distances
        $indore_ammenties = Category::whereCategoryType('indoor')->get();
        $outdoor_ammenties = Category::whereCategoryType('outdoor')->get();
        //Get Related Ads, add [->whereCountryId($ad->country_id)] for more specific results
        $related_ads = Ad::active()->with('city', 'feature_img', 'media_img')->whereUserId($ad_agent_id)->where('id', '!=',$ad->id)->with('city')->limit($limit_regular_ads)->orderByRaw('RAND()')->get();

        $agents = User::whereActiveStatus('1')->whereFeature('1')->whereUserType('user')->with('ads', 'country')->take(10)->orderBy('id', 'desc')->get();

        return view('theme.echuo.school_details', compact('ad', 'title', 'distances', 'indore_ammenties', 'outdoor_ammenties', 'related_ads', 'agents'));
    }





    public function embeddedAd($slug){
        $ad = Ad::whereSlug($slug)->first();
        return view($this->theme.'embedded_ad', compact('ad'));
    }

    /**
     * @param Request $request
     */
    
    public function switchGridListView(Request $request){
        session(['grid_list_view' => $request->grid_list_view]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function reportAds(Request $request){
        $ad = Ad::whereSlug($request->slug)->first();
        if ($ad) {
            $data = [
                'ad_id' => $ad->id,
                'reason' => $request->reason,
                'email' => $request->email,
                'message' => $request->message,
            ];
            Report_ad::create($data);
            return ['status'=>1, 'msg'=>trans('app.ad_reported_msg')];
        }
        return ['status'=>0, 'msg'=>trans('app.error_msg')];
    }
    
    
    public function reports(){
        $reports = Report_ad::orderBy('id', 'desc')->with('ad')->paginate(20);
        $title = trans('app.ad_reports');

        return view('admin.ad_reports', compact('title', 'reports'));
    }

    public function deleteReports(Request $request){
        Report_ad::find($request->id)->delete();
        return ['success'=>1, 'msg' => trans('app.report_deleted_success')];
    }
    
    public function reportsByAds($slug){
        $user = Auth::user();

        if ($user->is_admin()){
            $ad = Ad::whereSlug($slug)->first();
        }else{
            $ad = Ad::whereSlug($slug)->whereUserId($user->id)->first();
        }

        if (! $ad){
            return view('admin.error.error_404');
        }

        $reports = $ad->reports()->paginate(20);

        $title = trans('app.ad_reports');
        return view('admin.reports_by_ads', compact('title', 'ad', 'reports'));

    }
    
}
