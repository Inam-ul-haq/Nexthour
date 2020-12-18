<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;

class SocialLoginController extends Controller
{
    
   public function index(){
    return view('admin.sociallogin.index');
   }
     
    public function facebook()
    {
      $env_files = [
        'FACEBOOK_CLIENT_ID' => env('FACEBOOK_CLIENT_ID'),
        'FACEBOOK_CLIENT_SECRET' => env('FACEBOOK_CLIENT_SECRET'),
        'FACEBOOK_CALLBACK' => env('FACEBOOK_CALLBACK'),
        'GOOGLE_CLIENT_ID' => env('GOOGLE_CLIENT_ID'),
        'GOOGLE_CLIENT_SECRET' => env('GOOGLE_CLIENT_SECRET'),
        'GOOGLE_CALLBACK' => env('GOOGLE_CALLBACK'),
        'GITLAB_CLIENT_ID' => env('GITLAB_CLIENT_ID'),
        'GITLAB_CLIENT_SECRET' => env('GITLAB_CLIENT_SECRET'),
        'GITLAB_CALLBACK' => env('GITLAB_CALLBACK')
      ];

      

      return view('admin.sociallogin.index',compact('env_files'));


    }

     public function updateFacebookKey(Request $request)
    {
      //return $request;
        $input = $request->all();
        if(isset($request->fb_check)){
            
            $request->validate([
                              'FACEBOOK_CLIENT_ID' => 'required',
                              'FACEBOOK_CLIENT_SECRET' => 'required',
                              'FACEBOOK_CALLBACK' => 'required'
            ],
            [
                'FACEBOOK_CLIENT_ID.required' => 'Forget to Enter Facebook client id',
                'FACEBOOK_CLIENT_SECRET.required' => 'Forget to Enter Facebook client secret key',
                'FACEBOOK_CALLBACK.required' => 'Forget to Enter Facebook Callback url'
            ]);
        }
        // some code
        $env_update = $this->changeEnv([
          'FACEBOOK_CLIENT_ID' => $request->FACEBOOK_CLIENT_ID,
          'FACEBOOK_CLIENT_SECRET' => $request->FACEBOOK_CLIENT_SECRET,
          'FACEBOOK_CALLBACK' => $request->FACEBOOK_CALLBACK
        ]);

        if(isset($request->fb_check)){
       
            Config::where('id','=',1)->update(['fb_login' => "1"]);

        }else{
       
            Config::where('id','=',1)->update(['fb_login' => "0"]);

        }
        return back()->with('updated','Facebook Config Enabled');


      }

      public function updateGoogleKey(Request $request)
    {
        $input = $request->all();
         if(isset($request->google_login)){
            
            $request->validate([
                              'GOOGLE_CLIENT_ID' => 'required',
                              'GOOGLE_CLIENT_SECRET' => 'required',
                              'GOOGLE_CALLBACK' => 'required'
            ],
            [
                'GOOGLE_CLIENT_ID.required' => 'Forget to Enter Google client id',
                'GOOGLE_CLIENT_SECRET.required' => 'Forget to Enter Google client secret key',
                'GOOGLE_CALLBACK.required' => 'Forget to Enter Google Callback url'
            ]);
        }
        // some code
        $env_update = $this->changeEnv([
          'GOOGLE_CLIENT_ID' => $request->GOOGLE_CLIENT_ID,
          'GOOGLE_CLIENT_SECRET' => $request->GOOGLE_CLIENT_SECRET,
          'GOOGLE_CALLBACK' => $request->GOOGLE_CALLBACK,
        ]);

        if(isset($request->google_login)){
        
            Config::where('id','=',1)->update(['google_login' => 1]);

        }else{
            
            Config::where('id','=',1)->update(['google_login' => 0]);

        }



        return back()->with('updated','Google Config updated');


      }

      public function updategitlabKey(Request $request)
    {
        $input = $request->all();
         if(isset($request->git_lab_check)){
            
            $request->validate([
                              'GITLAB_CLIENT_ID' => 'required',
                              'GITLAB_CLIENT_SECRET' => 'required',
                              'GITLAB_CALLBACK' => 'required'
            ],
            [
                'GITLAB_CLIENT_ID.required' => 'Forget to Enter Gitlab client id',
                'GITLAB_CLIENT_SECRET.required' => 'Forget to Enter Gitlab client secret key',
                'GITLAB_CALLBACK.required' => 'Forget to Enter Gitlab Callback url'
            ]);
        }
        // some code
        $env_update = $this->changeEnv([
          'GITLAB_CLIENT_ID' => $request->GITLAB_CLIENT_ID,
          'GITLAB_CLIENT_SECRET' => $request->GITLAB_CLIENT_SECRET,
          'GITLAB_CALLBACK' => $request->GITLAB_CALLBACK,
        ]);

        if(isset($request->git_lab_check)){
        
            Config::where('id','=',1)->update(['gitlab_login' => 1]);

        }else{
            
            Config::where('id','=',1)->update(['gitlab_login' => 0]);
            

        }



        return back()->with('updated','Gitlab Config is enabled !');


      }

   
    

    protected function changeEnv($data = array()){
    {
        if ( count($data) > 0 ) {

            // Read .env-file
            $env = file_get_contents(base_path() . '/.env');

            // Split string on every " " and write into array
            $env = preg_split('/\s+/', $env);;

            // Loop through given data
            foreach((array)$data as $key => $value){
              // Loop through .env-data
              foreach($env as $env_key => $env_value){
                // Turn the value into an array and stop after the first split
                // So it's not possible to split e.g. the App-Key by accident
                $entry = explode("=", $env_value, 2);

                // Check, if new key fits the actual .env-key
                if($entry[0] == $key){
                    // If yes, overwrite it with the new one
                    $env[$env_key] = $key . "=" . $value;
                } else {
                    // If not, keep the old one
                    $env[$env_key] = $env_value;
                }
              }
            }

            // Turn the array back to an String
            $env = implode("\n\n", $env);

            // And overwrite the .env with the new data
            file_put_contents(base_path() . '/.env', $env);

            return true;

        } else {

          return false;
        }
    }
  }

}
