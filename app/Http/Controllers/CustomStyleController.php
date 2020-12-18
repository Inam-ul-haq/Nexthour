<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PricingText;
use App\Package;
use App\HomeTranslation;

class CustomStyleController extends Controller
{
    public function addStyle()
    {
      $css = @file_get_contents("css/custom-style.css");
      $js = @file_get_contents('js/custom-js.js');
      return view('admin.customstyle.add',compact('css','js'));
    }

    public function storeCSS(Request $request)
    {
        $this->validate($request,array(
          'css' => 'required'
        ));
        $css = $request->css;
        file_put_contents("css/custom-style.css",$css.PHP_EOL);
        return redirect()->route('customstyle')->with('added','Added Custom CSS !');
    }

    public function storeJS(Request $request)
    {
      $this->validate($request,array(
        'js' => 'required'
      ));

      $js = $request->js;
      file_put_contents("js/custom-js.js",$js.PHP_EOL);
      return redirect()->route('customstyle')->with('added','Added Javascript !');
    }

    public function pricingText()
    {
      $packages=Package::first();
      $package=Package::all();
       $selectid=$packages->id;
      $pricingtexts = PricingText::where('package_id',$packages->id)->get();
  return view('admin.customstyle.pricingText',compact('pricingtexts','package','selectid'));
    }

    public function pricingTextUpdate(Request $request)
    {
     $texts = PricingText::where('package_id',$request->package_id)->first();
     if (isset($texts) ) {
     $texts->title1 = $request->title1;
     $texts->title2 = $request->title2;
     $texts->title3 = $request->title3;
     $texts->title4 = $request->title4;
     $texts->title5 = $request->title5;
     $texts->title6 = $request->title6;
     $texts->save();
     }
     else{
        $input=$request->all();
        PricingText::create($input);
     }
     
    	return back()->with('updated', 'Pricing translations has been updated');


    }
  public function getpricingText(Request $request){
      
     $package=Package::all();
     $selectid=$request->id;
     $pricingtexts=PricingText::where('package_id',$request->id)->get();
 return view('admin.customstyle.pricingText',compact('pricingtexts','package','selectid'));
  }

    public function getPage()
    {
      $ht1 = HomeTranslation::where('key','watch next tv series and movies')->first();
      $ht2 = HomeTranslation::where('key','watch next movies')->first();
      $ht3 = HomeTranslation::where('key','watch next tv series')->first();
      $ht4 = HomeTranslation::where('key','movies in')->first();
      $ht5 = HomeTranslation::where('key','tv shows in')->first();
      $ht6 = HomeTranslation::where('key','movies')->first();
      $ht7 = HomeTranslation::where('key','tv shows')->first();
      $ht8 = HomeTranslation::where('key','featured')->first();
      return view('admin.PageSettings.index',compact('ht1','ht2','ht3','ht4','ht5','ht6','ht7','ht8'));
    }

    public function updatePage(Request $request,$id)
    {
      $hts = HomeTranslation::findorfail($id);
      if($hts->status == 0){
        $hts->status = 1;
      }else{
        $hts->status = 0;
      }

      $hts->save();
      if($hts->status==0)
      {
        return redirect()->route('pageset')->with('updated','Page is now Deactive !');
      }else {
          return redirect()->route('pageset')->with('updated','Page is now Active !');
      }

    }


}
