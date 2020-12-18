@extends('layouts.theme')
@section('title',"Watch History")
@section('main-wrapper')
<br>
@php
 $withlogin= App\Config::findOrFail(1)->withlogin;
           $auth=Auth::user();
             $subscribed = null;
          
          
            if (isset($auth)) {

              $current_date = date("d/m/y");
                  
              $auth = Illuminate\Support\Facades\Auth::user();
              if ($auth->is_admin == 1) {
                $subscribed = 1;
              } else if ($auth->stripe_id != null) {
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                if(isset($invoices) && $invoices != null && count($invoices->data) > 0)
                
                {
                $user_plan_end_date = date("d/m/y", $invoice->lines->data[0]->period->end);
                $plans = App\Package::all();
                foreach ($plans as $key => $plan) {
                  if ($auth->subscriptions($plan->plan_id)) {
                   
                  if($current_date <= $user_plan_end_date)
                  {
                  
                      $subscribed = 1;
                  }
                      
                  }
                } 
                }
                
                
              } else if (isset($auth->paypal_subscriptions)) {  
                //Check Paypal Subscription of user
                $last_payment = $auth->paypal_subscriptions->last();
                if (isset($last_payment) && $last_payment->status == 1) {
                  //check last date to current date
                  $current_date = Illuminate\Support\Carbon::now();
                  if (date($current_date) <= date($last_payment->subscription_to)) {
                    $subscribed = 1;
                  }
                }
              }
            }
@endphp
  @if (isset($pusheditems) && count($pusheditems) > 0 )
          <div class="genre-prime-block">
           
            
            <div class="container-fluid">
              <h5 class="section-heading"> {{$header_translations->where('key', 'watch history') ? $header_translations->where('key', 'watch history')->first->value['value'] : ''}} </h5>
              <a href="{{url('account/watchhistory/delete')}}"><button class=" btn btn-danger">Clear All</button></a>
              <div class="">
                @if(isset($pusheditems))

            

                  @foreach($pusheditems as $item)
                  
                   @if($auth && $subscribed==1)
                  
                    @php
                     if ($item->type == 'M') {
                      $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                          ['user_id', '=', $auth->id],
                                                                          ['movie_id', '=', $item->id],
                                                                         ])->first();
                     }

                    if ($item->type == 'S') {
                       $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                        ['user_id', '=', $auth->id],
                                                                        ['season_id', '=', $item->id],
                                                                      ])->first();
                    }
                    @endphp
                      @endif
                    
                  
                  @if($item->type == "M")
                   @if($item->status == 1)
                  <div class="col-lg-2 col-md-3 col-xs-6 col-sm-4">
                        <div class="cus_img">
                          
                        
                      <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block{{$item->id}}">
                        <a href="{{url('movie/detail',$item->id)}}">
                          @if($item->thumbnail != null || $item->thumbnail != '')
                            <img src="{{asset('images/movies/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else

                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                      </div>
                       {!! Form::open(['method' => 'DELETE', 'action' => ['WatchController@moviedestroy', $item->id]]) !!}
                    {!! Form::submit("Remove", ["class" => "btn btn-danger"]) !!}
                {!! Form::close() !!}
                      <div id="prime-next-item-description-block{{$item->id}}" class="prime-description-block">
                        <div class="prime-description-under-block">
                          <h5 class="description-heading">{{$item->title}}</h5>
                          <div class="item-rating">Rating {{$item->rating}}</div>
                          <ul class="description-list">
                            <li>{{$item->duration}} {{$popover_translations->where('key', 'mins')->first->value['value']}}</li>
                            <li>{{$item->publish_year}}</li>
                            <li>{{$item->maturity_rating}}</li>
                            @if($item->subtitle == 1)
                              <li>
                               {{$popover_translations->where('key', 'subtitles')->first->value['value']}}
                              </li>
                            @endif
                          </ul>
                          <div class="main-des">
                            <p>{{$item->detail}}</p>
                            <a href="{{url('movie/detail',$item->id)}}">Read more</a>
                          </div>
                          @if($auth)
                          <div class="des-btn-block">
                            @if($item->video_link['iframeurl'] != null)
                          
                            <a onclick="playoniframe('{{ $item->video_link['iframeurl'] }}','{{ $item->id }}','movie')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                            </a>

                            @else 
                              <a href="{{route('watchmovie',$item->id)}}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                            @endif
                           
                            @if($item->trailer_url != null || $item->trailer_url != '')
                
                            <a class="iframe btn btn-default" href="{{ route('watchTrailer',$item->id) }}">{{$popover_translations->where('key', 'watch trailer')->first->value['value']}}</a>

                            @endif
                            @if (isset($wishlist_check->added))
                              <a onclick="addWish({{$item->id}},'{{$item->type}}')" class="addwishlistbtn{{$item->id}}{{$item->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                            @else
                              <a onclick="addWish({{$item->id}},'{{$item->type}}')" class="addwishlistbtn{{$item->id}}{{$item->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}</a>
                            @endif
                          </div>
                          @else
                          @if($item->trailer_url != null || $item->trailer_url != '')
                          <div class="des-btn-block"> 
                            <a class="iframe btn btn-default" href="{{ route('guestwatchtrailer',$item->id) }}">{{$popover_translations->where('key', 'watch trailer')->first->value['value']}}</a>
                          </div>
                           

                            @endif
                          @endif
                        </div>
                      </div>
                      </div>
                       
                    </div>
                    @endif
                    @elseif($item->type == "S")
                    @if($item->tvseries['status'] == 1)
                    <div class="col-lg-2 col-md-3 col-xs-6 col-sm-4">
                      <div class="cus_img">
                        
                      
                  <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block{{$item->id}}{{ $item->type }}">
                      <a href="{{url('show/detail',$item->id)}}">
                        @if($item->tvseries->thumbnail != null || $item->tvseries->thumbnail != '')
                          <img src="{{asset('images/tvseries/thumbnails/'.$item->tvseries->thumbnail)}}" class="img-responsive" alt="genre-image">
                        @else

                          <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                        @endif
                      </a>

                    </div>
 {!! Form::open(['method' => 'DELETE', 'action' => ['WatchController@showdestroy', $item->tvseries->id]]) !!}
                    {!! Form::submit("Remove", ["class" => "btn btn-danger"]) !!}
                {!! Form::close() !!}
                    
                    <div id="prime-next-item-description-block{{$item->id}}{{$item->type}}" class="prime-description-block">
                        <h5 class="description-heading">{{$item->tvseries->title}}</h5>
                        <div class="movie-rating">{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$item->tvseries->rating}}</div>
                        <ul class="description-list">
                          <li>{{$popover_translations->where('key', 'season')->first->value['value']}} {{$item->season_no}}</li>
                          <li>{{$item->publish_year}}</li>
                          <li>{{$item->tvseries->age_req}}</li>
                          @if($item->subtitle == 1)
                            <li>
                              {{$popover_translations->where('key', 'subtitles')->first->value['value']}}
                            </li>
                          @endif
                        </ul>
                        <div class="main-des">
                          @if ($item->detail != null || $item->detail != '')
                            <p>{{$item->detail}}</p>
                          @else
                            <p>{{$item->tvseries->detail}}</p>
                          @endif
                          <a href="#"></a>
                        </div>
                        @if($subscribed==1 && $auth)
                        <div class="des-btn-block">
                          @if (isset($item->episodes[0]))
                            
                            @if($item->episodes[0]->video_link['iframeurl'] !="")

                            <a href="#" onclick="playoniframe('{{ $item->episodes[0]->video_link['iframeurl'] }}','{{ $item->tvseries->id }}','tv')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                             </a>

                            @else
                            <a href="{{ route('watchTvShow',$item->id) }}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                            @endif
                           
                          @endif
                          @if (isset($wishlist_check->added))
                            <a onclick="addWish({{$item->id}},'{{$item->type}}')" class="addwishlistbtn{{$item->id}}{{$item->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                          @else
                            <a onclick="addWish({{$item->id}},'{{$item->type}}')" class="addwishlistbtn{{$item->id}}{{$item->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}
                            </a>
                          @endif
                        </div>
                        
                        @endif
                      </div>
                    </div>
                   
                     
                  </div>
                    @endif
                    @endif
                  @endforeach

                @endif
                
              </div>
             <div class="col-md-12">
                <div align="center">
                   {!! $pusheditems->links() !!}
                </div>
             </div>


            </div>
           
          </div>
          
        @endif
@endsection
@section('custom-script')

<script>
      $(document).ready(function(){
        
        $(".group1").colorbox({rel:'group1'});
        $(".group2").colorbox({rel:'group2', transition:"fade"});
        $(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
        $(".group4").colorbox({rel:'group4', slideshow:true});
        $(".ajax").colorbox();
        $(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
        $(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
        $(".iframe").colorbox({iframe:true, width:"100%", height:"100%"});
        $(".inline").colorbox({inline:true, width:"50%"});
        $(".callbacks").colorbox({
          onOpen:function(){ alert('onOpen: colorbox is about to open'); },
          onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
          onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
          onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
          onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
        });

        $('.non-retina').colorbox({rel:'group5', transition:'none'})
        $('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});
        
        
        $("#click").click(function(){ 
          $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
          return false;
        });
      });
    </script>
<script>

  function playoniframe(url,id,type){
      
 
   $(document).ready(function(){
    var SITEURL = '{{URL::to('')}}';
       $.ajax({
            type: "get",
            url: SITEURL + "/user/watchhistory/"+id+'/'+type,
            success: function (data) {
             console.log(data);
            },
            error: function (data) {
               console.log(data)
            }
        });
       
   
         
  
  });       
    $.colorbox({ href: url, width: '100%', height: '100%', iframe: true });
  }
  
</script>
 <script>

   

    var app = new Vue({
      el: '.des-btn-block',
      data: {
        result: {
          id: '',
          type: '',
        },
      },
      methods: {
        addToWishList(id, type) {
          this.result.id = id;
          this.result.type = type;
          this.$http.post('{{route('addtowishlist')}}', this.result).then((response) => {
          }).catch((e) => {
            console.log(e);
          });
          this.result.item_id = '';
          this.result.item_type = '';
        }
      }
    });

</script>

 <script>
     function addWish(id, type) {
      app.addToWishList(id, type);
      setTimeout(function() {
        $('.addwishlistbtn'+id+type).text(function(i, text){
          return text == "{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}" ? "{{$popover_translations->where('key', 'remove from watchlist')->first->value['value']}}" : "{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}";
        });
      }, 100);
    }

  </script>
@endsection