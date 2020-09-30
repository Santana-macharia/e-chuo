<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Category;
use App\Contact_query;
use App\Country;
use App\Post;
use App\Slider;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        $limit_premium_ads = get_option('number_of_premium_ads_in_home');
        $limit_regular_ads = get_option('number_of_free_ads_in_home');
        $limit_urgent_ads = get_option('number_of_urgent_ads_in_home');

        $total_school = 0;
        $total_school = Ad::count();
        $sliders = Slider::all();
        $countries = Country::all();
        $categories = Category::all();
        $premium_ads = Ad::activePremium()->with('city', 'feature_img', 'media_img')->limit($limit_premium_ads)->orderBy('id', 'desc')->get();
        $regular_ads = Ad::activeRegular()->with('city', 'feature_img', 'media_img')->limit($limit_regular_ads)->orderBy('id', 'desc')->get();
        $urgent_ads = Ad::activeUrgent()->with('city', 'feature_img', 'media_img')->limit($limit_urgent_ads)->orderBy('id', 'desc')->get();
        
        $posts = Post::whereType('post')->with('feature_img', 'author')->whereStatus('1')->limit(get_option('blog_post_amount_in_homepage'))->get();

       // return view($this->theme.'index', compact( 'premium_ads', 'regular_ads','urgent_ads', 'countries', 'sliders', 'posts'));
         return view('theme.echuo.index', compact( 'premium_ads', 'regular_ads','urgent_ads', 'countries', 'sliders', 'posts', 'categories', 'total_school'));
    }

    public function contactUs(){
        $title = trans('app.contact_us');
        return view('theme.echuo.contact_us', compact('title'));
    }

    public function contactUsPost(Request $request){
        $rules = [
            'name'  => 'required',
            'email'  => 'required|email',
            'message'  => 'required',
        ];
        $this->validate($request, $rules);
        Contact_query::create(array_only($request->input(), ['name', 'email', 'message']));
        return redirect()->back()->with('success', trans('app.your_message_has_been_sent'));
    }
    
    public function contactMessages(){
        $title = trans('app.contact_messages');
        $contact_messages = Contact_query::select('name', 'email', 'message','created_at')->orderBy('id', 'desc')->get();

        return view('admin.contact_messages', compact('title', 'contact_messages'));
    }

    /**
     * Switch Language
     */
    public function switchLang($lang){
        session(['lang'=>$lang]);
        //return redirect(route('home'));
        return back();
    }

    /**
     * Reset Database
     */
    public function resetDatabase(){
        $database_location = base_path("database-backup/classified.sql");
        // Temporary variable, used to store current query
        $templine = '';
        // Read in entire file
        $lines = file($database_location);
        // Loop through each line
        foreach ($lines as $line)
        {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;
            // Add this line to the current segment
            $templine .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';')
            {
                // Perform the query
                DB::statement($templine);
                // Reset temp variable to empty
                $templine = '';
            }
        }
        $now_time = date("Y-m-d H:m:s");
        DB::table('ads')->update(['created_at' => $now_time, 'updated_at' => $now_time]);
    }


    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * Clear all cache
     */
    public function clearCache(){
        Artisan::call('debugbar:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        if (function_exists('exec')){
            exec('rm ' . storage_path('logs/*'));
        }
        $this->rrmdir(storage_path('logs/'));

        return redirect(route('home'));
    }
    public function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir."/".$object))
                        $this->rrmdir($dir."/".$object);
                    else
                        unlink($dir."/".$object);
                }
            }
            //rmdir($dir);
        }
    }


}
