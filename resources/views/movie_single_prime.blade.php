@extends('layouts.theme')
 @php
 
  $withlogin= App\Config::findOrFail(1)->withlogin;
   $configs= App\Config::findOrFail(1);
   Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
           $auth=Auth::user();
             $subscribed = null;
         
            if (isset($auth)) {

              $current_date = date("d/m/y");
                  
              $auth = Illuminate\Support\Facades\Auth::user();
              if ($auth->is_admin == 1) {
                $subscribed = 1;
              } else if ($auth->stripe_id != null) {
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $customer = \Stripe\Customer::retrieve($auth->stripe_id);
                $invoices = $customer->invoices();
                if(isset($invoices) && $invoices != null && count($invoices->data) > 0)
                
                {
                $user_plan_end_date = date("d/m/y", $invoices->lines->data[0]->period_end);
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
@if(isset($movie))
@section('custom-meta')
<meta name="Description" content="{{$movie->description}}" />
<meta name="keyword" content="{{$movie->title}}, {{$movie->keyword}}">
@endsection
@section('title',"$movie->title")
@elseif($season)

@php
 $title = $season->tvseries->title;
 @endphp
@section('custom-meta')
<meta name="Description" content="{{$season->tvseries->description}}" />
<meta name="keyword" content="{{$season->tvseries->title}}, {{$season->tvseries->keyword}}">
@endsection

@section('title',"$title")

@endif
@section('main-wrapper')
<!-- main wrapper -->
  <section class="main-wrapper main-wrapper-single-movie-prime">
    <div class="background-main-poster-overlay">
      
<!-- Modal -->
<div id="ageModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header text-danger">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Age Restricted Video</h4>
      </div>
       {!! Form::open(['method' => 'POST', 'action' => 'UsersController@update_age']) !!}
      <div class="modal-body">
        <h6 style="color: #e74c3c">This is an Age Restricted Video. Please Provide Your Date of Birth</h6><br>
  
              
           <div class="search form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                {!! Form::label('dob', 'Date Of Birth') !!}

                <input type="date" class="form-control"  name="dob"  />   
                <small class="text-danger">{{ $errors->first('dob') }}</small>
              </div>
            
            
        
      </div>
      <div class="modal-footer">
        <div class="pull-right">      
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
      </div>
     {!! Form::close() !!}
    </div>

  </div>
</div>
<!-- Modal -->
<div id="ageWarningModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header text-danger">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Age Restricted Video</h4>
      </div>
      <div class="modal-body">
        <h5 style="color: #c0392b">Sorry! This is Age Restricted Video. You are Not Allowed to Wactch</h5>
      </div>


      </div>
      <div class="modal-footer">
       
      </div>
     {!! Form::close() !!}
    </div>

  </div>

      @if(isset($movie))
        @if($movie->poster != null)
          <div class="background-main-poster col-md-offset-4 col-md-6" style="background-image: url('{{asset('images/movies/posters/'.$movie->poster)}}');">
        @else
          <div class="background-main-poster col-md-offset-4 col-md-6" style="background-image: url('{{asset('images/default-poster.jpg')}}');">
        @endif
      @endif
      @if(isset($season))
        @if($season->poster != null)
          <div class="background-main-poster col-md-offset-4 col-md-6" style="background-image: url('{{asset('images/tvseries/posters/'.$season->poster)}}');">
        @elseif($season->tvseries->poster != null)
          <div class="background-main-poster col-md-offset-4 col-md-6" style="background-image: url('{{asset('images/tvseries/posters/'.$season->tvseries->poster)}}');">
        @else
          <div class="background-main-poster col-md-offset-4 col-md-6" style="background-image: url('{{asset('images/default-poster.jpg')}}');">
        @endif
      @endif
      </div>
      <div class="overlay-bg gredient-overlay-right"></div>
      <div class="overlay-bg"></div>
    </div>
    <div id="full-movie-dtl-main-block" class="full-movie-dtl-main-block">
      <div class="container-fluid">
        @if(isset($movie))
          @php
            $subtitles = collect();
            if ($movie->subtitle == 1) {
              $subtitle_list = explode(',', $movie->subtitle_list);
              for($i = 0; $i < count($subtitle_list); $i++) {
                try {
                  $subtitle = \App\AudioLanguage::find($subtitle_list[$i])->language;
                  $subtitles->push($subtitle);
                } catch (Exception $e) {
                }
              }
            }
            $a_languages = collect();
            if ($movie->a_language != null) {
              $a_lan_list = explode(',', $movie->a_language);
              for($i = 0; $i < count($a_lan_list); $i++) {
                try {
                  $a_language = \App\AudioLanguage::find($a_lan_list[$i])->language;
                  $a_languages->push($a_language);
                } catch (Exception $e) {
                }
              }
            }
          if(isset($auth)){
            $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                        ['user_id', '=', $auth->id],
                                                                        ['movie_id', '=', $movie->id],
                                                                       ])->first();
                                                                     }
            // Directors list of movie from model
            $directors = collect();
            if ($movie->director_id != null) {
              $p_directors_list = explode(',', $movie->director_id);
              for($i = 0; $i < count($p_directors_list); $i++) {
                try {
                  $p_director = \App\Director::find($p_directors_list[$i])->name;
                  $directors->push($p_director);
                } catch (Exception $e) {

                }
              }
            }

            // Actors list of movie from model
            $actors = collect();
            if ($movie->actor_id != null) {
              $p_actors_list = explode(',', $movie->actor_id);
              for($i = 0; $i < count($p_actors_list); $i++) {
                try {
                  $p_actor = \App\Actor::find($p_actors_list[$i])->name;
                  $actors->push($p_actor);
                } catch (Exception $e) {

                }
              }
            }

            // Genre list of movie from model
            $genres = collect();
            if (isset($movie->genre_id)){
              $genre_list = explode(',', $movie->genre_id);
              for ($i = 0; $i < count($genre_list); $i++) {
                try {
                  $genre = \App\Genre::find($genre_list[$i])->name;
                  $genres->push($genre);
                } catch (Exception $e) {

                }
              }
            }

          @endphp
          <div class="row">
            <div class="col-md-8">
              <div class="full-movie-dtl-block">
                <h2 class="section-heading">{{$movie->title}}</h2>
                <div class="imdb-ratings-block">
                  <ul>
                    <li>{{$movie->publish_year}}</li>
                     @if($movie->live!=1)
                    <li>{{$movie->duration}} {{$popover_translations->where('key', 'mins')->first->value['value']}}</li>
                    @endif
                    <li>{{$movie->maturity_rating}}</li>
                     @if($movie->live!=1)
                    <li>{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$movie->rating}}</li>
                    @endif
                    @if($movie->subtitle == 1 && isset($subtitles))
                      <li>CC</li>
                      <li>
                        @for($i = 0; $i < count($subtitles); $i++)
                          @if($i == count($subtitles)-1)
                            {{$subtitles[$i]}}
                          @else
                            {{$subtitles[$i]}},
                          @endif
                        @endfor
                      </li>
                    @endif

                    <li><i title="views" class="fa fa-eye"></i> {{ views($movie)
                      ->unique()
                      ->count() }}</li>
                  </ul>
                </div>
                 @auth
                  @if($configs->user_rating==1)
                @php
                $uid=Auth::user()->id;
                $rating=App\UserRating::where('user_id',$uid)->
                where('movie_id',$movie->id)->first();
                $avg_rating=App\UserRating::where('movie_id',$movie->id)->avg('rating');
                @endphp
                   <h6>{{$header_translations->where('key', 'average rating') ? $header_translations->where('key', 'average rating')->first->value['value'] : ''}}  <span style="margin-left: 10px;">{{ number_format($avg_rating, 2) }}</span></h6>
                    {!! Form::open(['method' => 'POST', 'id'=>'formrating', 'action' => 'UserRatingController@store']) !!}
                  <input type="text" hidden="" name="movie_id" value="{{$movie->id}}">
                    <input type="text" hidden="" name="user_id" value="{{$auth->id}}">
                  <input id="rating" name="rating" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" onmouseover="mouseoverrating()" value="{{isset($rating)? $rating->rating: 2}}">
                  <button type="submit" hidden="" id="submitrating"> Submit Rating</button>
                  {!!Form::close()!!} 
                  <a href="javascript:video(0)" onclick="myrate()">Give Rating</a>
                  <button onclick="myrate()">Click me</button>
                  @endif
                 @endauth
                <p>
                  {{$movie->detail}}
                </p>
              </div>
              <div class="screen-casting-dtl">
                <ul class="casting-headers">
                   @if($movie->live!=1)
                  <li>{{$home_translations->where('key', 'directors')->first->value['value']}}</li>
                  <li>{{$home_translations->where('key', 'starring')->first->value['value']}}</li>
                  @endif
                  <li>{{$home_translations->where('key', 'genres')->first->value['value']}}</li>
                  <li>{{$popover_translations->where('key', 'subtitles')->first->value['value']}}</li>
                  <li>{{$home_translations->where('key', 'audio languages')->first->value['value']}}</li>
                </ul>
                <ul class="casting-dtl">
                   @if($movie->live!=1)
                  <li>
                    @if (count($directors) > 0)
                      @for($i = 0; $i < count($directors); $i++)
                        @if($i == count($directors)-1)
                          <a href="{{url('video/detail/director_search', trim($directors[$i]))}}">{{$directors[$i]}}</a>
                        @else
                          <a href="{{url('video/detail/director_search', trim($directors[$i]))}}">{{$directors[$i]}}</a>,
                        @endif
                      @endfor
                    @else
                      -
                    @endif
                  </li>
                  <li>
                    @if (count($actors) > 0)
                      @for($i = 0; $i < count($actors); $i++)
                        @if($i == count($actors)-1)
                          <a href="{{url('video/detail/actor_search', trim($actors[$i]))}}">{{$actors[$i]}}</a>
                        @else
                          <a href="{{url('video/detail/actor_search', trim($actors[$i]))}}">{{$actors[$i]}}</a>,
                        @endif
                      @endfor
                    @else
                      -
                    @endif
                  </li>
                  @endif
                  <li>
                    @if (count($genres) > 0)
                      @for($i = 0; $i < count($genres); $i++)
                        @if($i == count($genres)-1)
                          <a href="{{url('video/detail/genre_search', trim($genres[$i]))}}">{{$genres[$i]}}</a>
                        @else
                          <a href="{{url('video/detail/genre_search', trim($genres[$i]))}}">{{$genres[$i]}}</a>,
                        @endif
                      @endfor
                    @else
                      -
                    @endif
                  </li>
                  <li>
                    @if (count($subtitles) > 0)
                      @if($movie->subtitle == 1 && isset($subtitles))
                        @for($i = 0; $i < count($subtitles); $i++)
                          @if($i == count($subtitles)-1)
                            {{$subtitles[$i]}}
                          @else
                            {{$subtitles[$i]}},
                          @endif
                        @endfor
                      @else
                        -
                      @endif
                    @else
                      -
                    @endif
                  </li>
                  <li>
                    @if (count($a_languages) > 0)
                      @if($movie->a_language != null && isset($a_languages))
                        @for($i = 0; $i < count($a_languages); $i++)
                          @if($i == count($a_languages)-1)
                            {{$a_languages[$i]}}
                          @else
                            {{$a_languages[$i]}},
                          @endif
                        @endfor
                      @else
                        -
                      @endif
                    @else
                      -
                    @endif
                  </li>
                </ul>
              </div>
              <div id="wishlistelement" class="screen-play-btn-block">
                
                @if($subscribed==1 && $auth)
                  @if($movie->maturity_rating == 'all age' || $age>=str_replace('+', '', $movie->maturity_rating))
                    @if($movie->video_link['iframeurl'] != null)
                        
                        <a href="#" onclick="playoniframe('{{ $movie->video_link['iframeurl'] }}','{{ $movie->id }}','movie')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                       </a>

                      @else
                        <a href="{{route('watchmovie',$movie->id)}}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                      </a>
                    @endif
                  @else
                    <a onclick="myage({{$age}})" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                     </a>
                  @endif

                @endif

                @if($auth && $subscribed ==1)
                  @if($movie->trailer_url != null || $movie->trailer_url != '')
                    <a href="{{ route('watchTrailer',$movie->id) }}" class="iframe btn-default">{{$popover_translations->where('key', 'watch trailer')->first->value['value']}}</a>
                  @endif
                  @if($config->download ==1 && $movie->video_link['upload_video']!='')
                    <a href="{{route('movie.download',$movie->video_link['upload_video'])}}" class="btn-default"><i class="fa fa-download" aria-hidden="true"></i> {{$popover_translations->where('key', 'Download')->first->value['value']}}</a>
                  @endif
                @else
                  @if($movie->trailer_url != null || $movie->trailer_url != '')
                    <a href="{{ route('guestwatchtrailer',$movie->id) }}" class="iframe btn-default">{{$popover_translations->where('key', 'watch trailer')->first->value['value']}}</a>
                  @endif
                @endif
              </div>
            </div>
  
        
            <div class="col-md-4">
              <div class="poster-thumbnail-block">
                @if($movie->thumbnail != null || $movie->thumbnail != '')
                  <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                @else
                  <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                @endif
              </div>
            </div>
          </div>

        </div>

        @elseif(isset($season))
          @php
            $subtitles = collect();

            if ($season->subtitle == 1) {
              $subtitle_list = explode(',', $season->subtitle_list);
              for($i = 0; $i < count($subtitle_list); $i++) {
                try {
                  $subtitle = App\AudioLanguage::find($subtitle_list[$i])->language;
                  $subtitles->push($subtitle);
                } catch (Exception $e) {
                }
              }
            }
            $a_languages = collect();
            if ($season->a_language != null) {
              $a_lan_list = explode(',', $season->a_language);
              for($i = 0; $i < count($a_lan_list); $i++) {
                try {
                  $a_language = \App\AudioLanguage::find($a_lan_list[$i])->language;
                  $a_languages->push($a_language);
                } catch (Exception $e) {
                }
              }
            }
             if(isset($auth)){
            $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                          ['user_id', '=', $auth->id],
                                                                          ['season_id', '=', $season->id],
                                                                         ])->first();
                                                                       }
            // Actors list of movie from model
            $actors = collect();
            if ($season->actor_id != null) {
              $p_actors_list = explode(',', $season->actor_id);
              for($i = 0; $i < count($p_actors_list); $i++) {
                try {
                  $p_actor = \App\Actor::find(trim($p_actors_list[$i]))->name;
                  $actors->push($p_actor);
                } catch (Exception $e) {
                }
              }
            }

            // Genre list of movie from model
            $genres = collect();
            if ($season->tvseries->genre_id != null){
              $genre_list = explode(',', $season->tvseries->genre_id);
              for ($i = 0; $i < count($genre_list); $i++) {
                try {
                  $genre = \App\Genre::find($genre_list[$i])->name;
                  $genres->push($genre);
                } catch (Exception $e) {
                }
              }
            }
          @endphp
          <div class="row">
            <div class="col-md-8">
              <div class="full-movie-dtl-block">
                <h2 class="section-heading">{{$season->tvseries->title}}</h2>
                 <br/>
                <select style="width:20%;-webkit-box-shadow: none;box-shadow: none;color: #FFF;background: #000;display: block;clear: both;border: 1px solid #666;border-radius: 0;" name="" id="selectseason" class="form-control">
                  @foreach($season->tvseries->seasons as $allseason)

                    <option {{ $season->id == $allseason->id ? "selected" : "" }} value="{{ $allseason->id }}">Season {{ $allseason->season_no }}</option>
                  
                  @endforeach
                </select>
                <br>
                <div class="imdb-ratings-block">
                  <ul>
                    <li>{{$season->publish_year}}</li>
                    <li>{{$season->season_no}} {{$popover_translations->where('key', 'season')->first->value['value']}}</li>
                    <li>{{$season->tvseries->age_req}}</li>
                    <li>{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$season->tvseries->rating}}</li>
                    @if(isset($subtitles))
                      <li>CC</li>
                      <li>
                        @for($i = 0; $i < count($subtitles); $i++)
                          @if($i == count($subtitles)-1)
                            {{$subtitles[$i]}}
                          @else
                            {{$subtitles[$i]}},
                          @endif
                        @endfor
                      </li>
                      <li> <li><i title="views" class="fa fa-eye"></i> {{ views($season)
                        ->unique()
                        ->count() }}</li></li>
                    @endif
                  </ul>
                </div>
                    @auth
                  @if($configs->user_rating==1)
                   @php
                $uid=Auth::user()->id;
                $rating=App\UserRating::where('user_id',$uid)->
                where('tv_id',$season->tvseries->id)->first();
                $avg_rating=App\UserRating::where('tv_id',$season->tvseries->id)->avg('rating');
                @endphp
                  <h6>{{$header_translations->where('key', 'average rating') ? $header_translations->where('key', 'average rating')->first->value['value'] : ''}}  <span style="margin-left: 10px;"> {{ number_format($avg_rating, 2) }}</span></h6>
                    {!! Form::open(['method' => 'POST', 'id'=>'formratingtv', 'action' => 'UserRatingController@store']) !!}
                  <input type="text" hidden="" name="tv_id" 
                  value="{{$season->tvseries->id}}">
                    <input type="text" hidden="" name="user_id" value="{{$auth->id}}">
                  <input id="rating" name="rating" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" onmouseover ="mouseoverratingtv()" 
                  value="{{isset($rating)? $rating->rating: 2}}">
                  <button type="submit" hidden="" id="submitrating"> Submit Rating</button>
                  {!!Form::close()!!}
                  <a href="javascript:video(0)" onclick="myrateTv()">Give Rating</a>
                  <button onclick="myrateTv()">Click me</button>
                  @endif
                 @endauth
                <p>
                  @if ($season->detail != null || $season->detail != '')
                    {{$season->detail}}
                  @else
                    {{$season->tvseries->detail}}
                  @endif
                </p>
              </div>
              <div class="screen-casting-dtl">
                <ul class="casting-headers">
                  <li>{{$home_translations->where('key', 'starring')->first->value['value']}}</li>
                  <li>{{$home_translations->where('key', 'genres')->first->value['value']}}</li>
                  <li>{{$popover_translations->where('key', 'subtitles')->first->value['value']}}</li>
                  <li>{{$home_translations->where('key', 'audio languages')->first->value['value']}}</li>
                </ul>
                <ul class="casting-dtl">
                  <li>
                    @if (count($actors) > 0)
                      @for($i = 0; $i < count($actors); $i++)
                        @if($i == count($actors)-1)
                          <a href="{{url('video/detail/actor_search', trim($actors[$i]))}}">{{$actors[$i]}}</a>
                        @else
                          <a href="{{url('video/detail/actor_search', trim($actors[$i]))}}">{{$actors[$i]}}</a>,
                        @endif
                      @endfor
                    @else
                      -
                    @endif
                  </li>
                  <li>
                    @if (count($genres) > 0)
                      @for($i = 0; $i < count($genres); $i++)
                        @if($i == count($genres)-1)
                          <a href="{{url('video/detail/genre_search', trim($genres[$i]))}}">{{$genres[$i]}}</a>
                        @else
                          <a href="{{url('video/detail/genre_search', trim($genres[$i]))}}">{{$genres[$i]}}</a>,
                        @endif
                      @endfor
                    @else
                      -
                    @endif
                  </li>
                  <li>
                    @if (count($subtitles) > 0)
                      @for($i = 0; $i < count($subtitles); $i++)
                        @if($i == count($subtitles)-1)
                          {{$subtitles[$i]}}
                        @else
                          {{$subtitles[$i]}},
                        @endif
                      @endfor
                    @else
                      -
                    @endif
                  </li>
                  <li>
                    @if($season->a_language != null && isset($a_languages))
                      @for($i = 0; $i < count($a_languages); $i++)
                        @if($i == count($a_languages)-1)
                          {{$a_languages[$i]}}
                        @else
                          {{$a_languages[$i]}},
                        @endif
                      @endfor
                    @else
                      -
                    @endif
                  </li>
                </ul>
              </div>
              <div class="screen-play-btn-block">
                @if($auth && $subscribed ==1)
                @if (isset($season->episodes[0]))
                  @if($season->tvseries->age_req == 'all age' || $age>=str_replace('+', '', $season->tvseries->age_req))
                            @if($season->episodes[0]->video_link['iframeurl'] !="")

                            <a href="#" onclick="playoniframe('{{ $season->episodes[0]->video_link['iframeurl'] }}','{{ $season->tvseries->id }}','tv')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                             </a>
                            @else
                <a href="{{route('watchTvShow',$season->id)}}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
               @endif
               @else
                <a  onclick="myage({{$age}})" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                             </a>
               @endif
               @endif
               @endif
                @if($subscribed==1)
                <div id="wishlistelement" class="btn-group btn-block">
                  <div>
                    @if (isset($wishlist_check->added))
                      <a onclick="addWish({{$season->id}},'{{$season->type}}')" class="addwishlistbtn{{$season->id}}{{$season->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                    @else
                      <a onclick="addWish({{$season->id}},'{{$season->type}}')" class="addwishlistbtn{{$season->id}}{{$season->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}</a>
                    @endif
                  </div>
                </div>
                @endif
              </div>
            </div>
            <div class="col-md-4">
              <div class="poster-thumbnail-block">
                @if($season->thumbnail != null)
                  <img src="{{asset('images/tvseries/thumbnails/'.$season->thumbnail)}}" class="img-responsive" alt="genre-image">
                @elseif($season->tvseries->thumbnail != null)
                  <img src="{{asset('images/tvseries/thumbnails/'.$season->tvseries->thumbnail)}}" class="img-responsive" alt="genre-image">
                @else
                  <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                @endif
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
{{-- comments section start from here --}}
@if(isset($movie))
 @if($configs->comments==1)
    <div class="container">
   <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#showcomment" aria-controls="showcomment" role="tab" data-toggle="tab">Comments</a></li>
    <li role="presentation"><a href="#postcomment" aria-controls="postcomment" role="tab" data-toggle="tab">Post Comment</a></li>
  </ul>
  <br/>
  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="showcomment">
      <h4 class="title" style="color:#B1B1B1;"><span class="glyphicon glyphicon-comment"></span> {{$movie->comments->count()}} Comments </h4> <br/>
         
          @foreach ($movie->comments as $comment)

              <div class="comment">
                <div class="author-info">
                  <img src="{{"https://www.gravatar.com/avatar/" . md5(strtolower(trim($comment->name))). "?s=50&d=monsterid" }}" class="author-image">
                  <div class="author-name">
                    <h4>{{$comment->name}}</h4>
                    <p class="author-time">{{date('F nS, Y - g:i a',strtotime($comment->created_at))}}</p>
                  </div>
                </div>

                <div class="comment-content">
                 {{$comment->comment}}
                </div>
              </div>
              <div>
                  <button type="button" class="btn-danger btn-floating pull-right" data-toggle="modal" data-target="#{{$comment->id}}deleteModal">Reply </button>
                    <!-- Modal -->
                  
                   
              </div>

               @foreach($comment->subcomments as $subcomment)

                  <div class="comment" style="margin-left:50px;">
                  <div class="author-info">
                    <img src="{{"https://www.gravatar.com/avatar/" . md5(strtolower(trim($subcomment->name))). "?s=50&d=monsterid" }}" class="author-image">
                    <div class="author-name">
                      @php
                         $name=App\User::where('id',$subcomment->user_id)->first();
                       @endphp
                      <h5>{{$name->name}}</h5>
                      <p class="author-time">{{date('F nS, Y - g:i a',strtotime($subcomment->created_at))}}</p>
                    </div>
                  </div>

                  <div class="comment-content">
                   {{$subcomment->reply}}
                  </div>
                </div>
              
              @endforeach
               <div id="{{$comment->id}}deleteModal" class="modal fade" role="dialog"  style="margin-top: 20px;">
                      <div class="modal-dialog modal-md" style="margin-top:70px;">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                             
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <div class="delete-icon"></div>
                           <h4 style="color:#B1B1B1;"> Reply for {{$comment->name}}</h4>
                          </div>
                          <div class="modal-body text-center">
                             
                              <form action="{{route('movie.comment.reply', ['cid' =>$comment->id])}}" method ="POST">
                                {{ csrf_field() }}
                              {{Form::label('reply','Your Reply:')}}
                              {{Form::textarea('reply', null, ['class' => 'form-control', 'rows'=> '5','cols' => '10'])}} 
                              <br/>
                                <button type="submit" class="btn btn-danger">Submit</button>
                           </form>
                          </div>
                          <div class="modal-footer">
                           
                          </div>
                        </div>
                      </div>
                    </div>
              

          @endforeach
          

    </div>
    @auth
    <div role="tabpanel" class="tab-pane fade" id="postcomment">
        <div style="width: 90%;color:#B1B1B1;" class=" " >
            <h3>Post Comment:</h3><br/>
             
                {{Form::open( ['route' => ['movie.comment.store', $movie->id], 'method' => 'POST'])}}
                {{Form::label('name', 'Name:')}}
                {{Form::text('name', null, ['class' => 'form-control'])}}
                <br/>
                {{Form::label('email', 'Email:')}}
                 {{Form::email('email', null, ['class' => 'form-control'])}}
                <br/>
                {{Form::label('comment','Comment:')}}
                {{Form::textarea('comment', null, ['class' => 'form-control', 'rows'=> '5','cols' => '10'])}}
                <br/>
                {{Form::submit('Add Comment', ['class' => 'btn btn-md btn-primary'])}}
        </div>

    </div>
    @endauth
  </div>
</div>
@endif
@endif
    <!-- movie series -->
    @if(isset($movie->movie_series) && $movie->series != 1)
      @if(count($movie->movie_series) > 0)
        <div class="container-fluid movie-series-section search-section">
          <h5 class="movie-series-heading">Series {{count($movie->movie_series)}}</h5>
          <div>
            @foreach($movie->movie_series as $series)
              @php
                $single_series = \App\Movie::where('id', $series->series_movie_id)->first();
                 if(isset($auth)){
                $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                            ['user_id', '=', $auth->id],
                                                                            ['movie_id', '=', $single_series->id],
                                                                           ])->first();
                                                                         }
              @endphp
              <div class="movie-series-block">
                <div class="row">
                  <div class="col-sm-3">
                    <div class="movie-series-img">
                      @if($single_series->thumbnail != null || $single_series->thumbnail != '')
                        <img src="{{asset('images/movies/thumbnails/'.$single_series->thumbnail)}}" class="img-responsive" alt="genre-image">
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-7 pad-0">
                    <h5 class="movie-series-heading movie-series-name"><a href="{{url('movie/detail', $single_series->id)}}">{{$single_series->title}}</h5>
                    <ul class="movie-series-des-list">
                      <li>{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$single_series->rating}}</li>
                      <li>{{$single_series->duration}} {{$popover_translations->where('key', 'mins')->first->value['value']}}</li>
                      <li>{{$single_series->publish_year}}</li>
                      <li>{{$single_series->maturity_rating}}</li>
                      @if($single_series->subtitle == 1)
                        <li>{{$popover_translations->where('key', 'subtitles')->first->value['value']}}</li>
                      @endif
                    </ul>
                    <p>
                      {{$single_series->detail}}
                    </p>
                     
                    <div class="des-btn-block des-in-list">
                      @if($subscribed==1 && $auth)
                        <a href="{{route('watchmovie',$single_series->id)}}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                        @if($single_series->trailer_url != null || $single_series->trailer_url != '')
                          <a href="{{route('watchTrailer',$single_series->id)}}" class="btn-default">{{$popover_translations->where('key', 'watch trailer')->first->value['value']}}</a>
                        @endif
                        @if (isset($wishlist_check->added))
                          <a onclick="addWish({{$single_series->id}},'{{$single_series->type}}')" class="addwishlistbtn{{$single_series->id}}{{$single_series->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                        @else
                          <a onclick="addWish({{$single_series->id}},'{{$single_series->type}}')" class="addwishlistbtn{{$single_series->id}}{{$single_series->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}</a>
                        @endif
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    @endif
    @if(isset($filter_series) && $movie->series == 1)
      @if(count($filter_series) > 0)
        <div class="container-fluid movie-series-section search-section">
          <h5 class="movie-series-heading">{{$home_translations->where('key', 'series')->first->value['value']}} {{count($filter_series)}}</h5>
          <div>
            @foreach($filter_series as $key => $series)
              @php
               if(isset($auth)){
                $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                            ['user_id', '=', $auth->id],
                                                                            ['movie_id', '=', $series->id],
                                                                           ])->first();
                                                                         }
              @endphp
              <div class="movie-series-block">
                <div class="row">
                  <div class="col-sm-3">
                    <div class="movie-series-img">
                      @if($series->thumbnail != null)
                        <img src="{{asset('images/movies/thumbnails/'.$series->thumbnail)}}" class="img-responsive" alt="genre-image">
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-7 pad-0">
                    <h5 class="movie-series-heading movie-series-name"><a href="{{url('movie/detail', $series->id)}}">{{$series->title}}</a></h5>
                    <ul class="movie-series-des-list">
                      <li>{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$series->rating}}</li>
                      <li>{{$series->duration}} {{$popover_translations->where('key', 'mins')->first->value['value']}}</li>
                      <li>{{$series->publish_year}}</li>
                      <li>{{$series->maturity_rating}}</li>
                      @if($series->subtitle == 1)
                        <li>{{$popover_translations->where('key', 'subtitles')->first->value['value']}}</li>
                      @endif
                    </ul>
                    <p>
                      {{$series->detail}}
                    </p>
                     
                    <div class="des-btn-block des-in-list">
                      @if($subscribed==1 && $auth)
                       @if($series->maturity_rating == 'all age' || $age>=str_replace('+', '', $series->maturity_rating))
                          <a onclick="playVideo({{$series->id}}, '{{$series->type}}')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                        @else
                           <a onclick="myage({{$age}})" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                       @endif
                        @if($series->trailer_url != null || $series->trailer_url != '')
                          <a onclick="playTrailer('{{$series->trailer_url}}')" class="btn-default">{{$popover_translations->where('key', 'watch trailer')->first->value['value']}}</a>
                        @endif
                        @if (isset($wishlist_check->added))
                          <a onclick="addWish({{$series->id}},'{{$series->type}}')" class="addwishlistbtn{{$series->id}}{{$series->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                        @else
                          <a onclick="addWish({{$series->id}},'{{$series->type}}')" class="addwishlistbtn{{$series->id}}{{$series->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}</a>
                        @endif
                      @else

                      @endif
                    </div>

                   
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    @endif
    <!-- end movie series -->
{{-- comments section start from here --}}
 @if(isset($season))
 @if($configs->comments==1)
    <div class="container">
   <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#showcomment" aria-controls="showcomment" role="tab" data-toggle="tab">Comments</a></li>
    <li role="presentation"><a href="#postcomment" aria-controls="postcomment" role="tab" data-toggle="tab">Post Comment</a></li>
  </ul>
  <br/>
  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="showcomment">
      <h4 class="title" style="color:#B1B1B1;"><span class="glyphicon glyphicon-comment"></span> {{$season->tvseries->comments->count()}} Comments </h4> <br/>
         
          @foreach ($season->tvseries->comments as $comment)

              <div class="comment">
                <div class="author-info">
                  <img src="{{"https://www.gravatar.com/avatar/" . md5(strtolower(trim($comment->name))). "?s=50&d=monsterid" }}" class="author-image">
                  <div class="author-name">
                    <h4>{{$comment->name}}</h4>
                    <p class="author-time">{{date('F jS, Y - g:i a',strtotime($comment->created_at))}}</p>
                  </div>
                </div>

                <div class="comment-content">
                 {{$comment->comment}}
                </div>
              </div>
              <div>
                  <button type="button" class="btn-danger btn-floating pull-right" data-toggle="modal" data-target="#{{$comment->id}}deleteModal">Reply </button>
                    <!-- Modal -->
                   
                    <div id="{{$comment->id}}deleteModal" class="delete-modal modal fade" role="dialog"  style="margin-top: 20px;">
                      <div class="modal-dialog modal-md" style="margin-top:70px;">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                             
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <div class="delete-icon"></div>
                           <h4 style="color:#B1B1B1;"> Reply for {{$comment->name}}</h4>
                          </div>
                          <div class="modal-body text-center">
                             
                              <form action="{{route('tv.comment.reply', ['cid' =>$comment->id])}}" method ="POST">
                                {{ csrf_field() }}
                              {{Form::label('reply','Your Reply:')}}
                              {{Form::textarea('reply', null, ['class' => 'form-control', 'rows'=> '5','cols' => '10'])}} 
                              <br/>
                                <button type="submit" class="btn btn-danger">Submit</button>
                           </form>
                          </div>
                          <div class="modal-footer">
                           
                          </div>
                        </div>
                      </div>
                    </div>
              </div>
               @foreach($comment->subcomments as $subcomment)
                
                  <div class="comment" style="margin-left:50px;">
                  <div class="author-info">
                    <img src="{{"https://www.gravatar.com/avatar/" . md5(strtolower(trim($subcomment->name))). "?s=50&d=monsterid" }}" class="author-image">
                    <div class="author-name">
                      @php
                         $name=App\User::where('id',$subcomment->user_id)->first();
                       @endphp
                      <h5>{{$name->name}}</h5>
                      <p class="author-time">{{date('F jS, Y - g:i a',strtotime($subcomment->created_at))}}</p>
                    </div>
                  </div>

                  <div class="comment-content">
                   {{$subcomment->reply}}
                  </div>
                </div>

              @endforeach
             
              

          @endforeach
          

    </div>
    @auth
    <div role="tabpanel" class="tab-pane fade" id="postcomment">
        <div style="width: 90%;color:#B1B1B1;" class=" " >
            <h3>Post Comment:</h3><br/>
          
                {{Form::open( ['route' => ['tv.comment.store', $season->tvseries->id], 'method' => 'POST'])}}
                {{Form::label('name', 'Name:')}}
                {{Form::text('name', null, ['class' => 'form-control'])}}
                <br/>
                {{Form::label('email', 'Email:')}}
                 {{Form::email('email', null, ['class' => 'form-control'])}}
                <br/>
                {{Form::label('comment','Comment:')}}
                {{Form::textarea('comment', null, ['class' => 'form-control', 'rows'=> '5','cols' => '10'])}}
                <br/>
                {{Form::submit('Add Comment', ['class' => 'btn btn-md btn-primary'])}}
        </div>

    </div>
    @endauth
  </div>
</div>
@endif
@endif
    <!-- episodes -->
    @if(isset($season->episodes))
      @if(count($season->episodes) > 0)
        <div class="container-fluid movie-series-section search-section">
          <h5 class="movie-series-heading">{{$home_translations->where('key', 'episodes')->first->value['value']}} {{count($season->episodes)}}</h5>
          <div>
            @foreach($season->episodes as $key => $episode)



              <div class="movie-series-block">
                <div class="row">
                  <div class="col-sm-3">
                    <div class="movie-series-img">
                      @if($episode->thumbnail != null)
                        <img src="{{asset('images/tvseries/episodes/'.$episode->thumbnail)}}" class="img-responsive" alt="genre-image">
                      @elseif($episode->thumbnail != null)
                        <img src="{{asset('images/tvseries/episodes/'.$episode->thumbnail)}}" class="img-responsive" alt="genre-image">
                      @else
                        <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                      @endif
                    </div>
                  </div>
                    @if($subscribed==1)
                  <div class="col-sm-7 pad-0">
                    @if($episode->seasons->tvseries->age_req == 'all age' || $age>=str_replace('+', '', $episode->seasons->tvseries->age_req))

                     @if($episode->video_link['iframeurl'] !="")
                       <a onclick="playoniframe('{{ $episode->video_link['iframeurl'] }}','{{ $episode->seasons->tvseries->id }}','tv')" class="btn btn-play btn-sm-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text"><h5 class="movie-series-heading movie-series-name">{{$key+1}}. {{$episode->title}}</h5></span></a>
                    @else
                       <a href="{{ route('watch.Episode', $episode->id) }}" class="iframe btn btn-play btn-sm-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text"><h5 class="movie-series-heading movie-series-name">{{$key+1}}. {{$episode->title}}</h5></span></a>
                  @endif
                  @else
                    <a onclick="myage({{$age}})" class="btn btn-play btn-sm-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text"><h5 class="movie-series-heading movie-series-name">{{$key+1}}. {{$episode->title}}</h5></span></a>
                  @endif
                    <ul class="movie-series-des-list">
                      <li>{{$episode->duration}} {{$popover_translations->where('key', 'mins')->first->value['value']}}</li>
                      <li>{{$episode->released}}</li>
                      <li>{{$episode->seasons->tvseries->age_req}}</li>
                      <li>
                        @if($episode->subtitle == 1)
                         {{$popover_translations->where('key', 'subtitles')->first->value['value']}}
                        @endif
                      </li>
                    </ul>
                    @php
                    $subtitles = collect();
           
                    $a_languages = collect();
           
                    if ($episode->subtitle==1) {
                        $subtitle_list = explode(',', $episode->subtitle_list);
                         for($i = 0; $i < count($subtitle_list); $i++) {
                        try {
                          $subtitle = \App\AudioLanguage::find($subtitle_list[$i])->language;
                          $subtitles->push($subtitle);
                        } catch (Exception $e) {
                        }
                      }
                    }
                     if ($episode->a_language != null) {
                      $a_lan_list = explode(',', $episode->a_language);
                      for($i = 0; $i < count($a_lan_list); $i++) {
                        try {
                          $a_language = \App\AudioLanguage::find($a_lan_list[$i])->language;
                          $a_languages->push($a_language);
                        } catch (Exception $e) {
                        }
                      }
                     }
                    @endphp
                    <ul class="casting-headers">
                  
                  <li>{{$popover_translations->where('key', 'subtitles')->first->value['value']}}</li>
                  <li>{{$home_translations->where('key', 'audio languages')->first->value['value']}}</li>
                </ul>
               <ul class="casting-dtl">
                 <li>
                  @if(isset($subtitles))
                    @if (count($subtitles) > 0)
                      @for($i = 0; $i < count($subtitles); $i++)
                        @if($i == count($subtitles)-1)
                          {{$subtitles[$i]}}
                        @else
                          {{$subtitles[$i]}},
                        @endif
                      @endfor
                    @else
                      -
                    @endif
                    @endif
                  </li>
                  <li>
                    @if($episode->a_language != null && isset($a_languages))
                      @for($i = 0; $i < count($a_languages); $i++)
                        @if($i == count($a_languages)-1)
                          {{$a_languages[$i]}}
                        @else
                          {{$a_languages[$i]}},
                        @endif
                      @endfor
                    @else
                      -
                    @endif
                  </li>
               </ul>
                 </br>

                    <p>
                      {{$episode->detail}}
                    </p>
                    <br>
                    @if($auth && $subscribed ==1)
                      @if($config->download ==1 && $episode->video_link['upload_video']!='')
                          <a href="{{route('season.download',$episode->video_link['upload_video'])}}" class="btn-default btn-sm"><i class="fa fa-download" aria-hidden="true"></i> {{$popover_translations->where('key', 'Download')->first->value['value']}}</a>
                      @endif
                    @endif
                  </div>


                  @endif
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    @endif

      
    <!-- end episodes -->
    @if($prime_genre_slider == 1)
      @php
        $all = collect();
        $all_fil_movies = App\Movie::all();
        $all_fil_tv = App\TvSeries::all();
        if (isset($movie)) {
          $genres = explode(',', $movie->genre_id);
        } elseif (isset($season)) {
          $genres = explode(',', $season->tvseries->genre_id);
        }
        for($i = 0; $i < count($genres); $i++) {
          foreach ($all_fil_movies as $fil_movie) {
            $fil_genre_item = explode(',', trim($fil_movie->genre_id));
            for ($k=0; $k < count($fil_genre_item); $k++) {
              if (trim($fil_genre_item[$k]) == trim($genres[$i])) {
                if (isset($movie)) {
                  if ($fil_movie->id != $movie->id) {
                    $all->push($fil_movie);
                  }
                } else {
                  $all->push($fil_movie);
                }
              }
            }
          }
        }
        if (isset($movie)) {
          $all = $all->except($movie->id);
        }

        for($i = 0; $i < count($genres); $i++) {
          foreach ($all_fil_tv as $fil_tv) {
            $fil_genre_item = explode(',', trim($fil_tv->genre_id));
            for ($k=0; $k < count($fil_genre_item); $k++) {
              if (trim($fil_genre_item[$k]) == trim($genres[$i])) {
                $fil_tv = $fil_tv->seasons;
                if (isset($season)) {
                  $all->push($fil_tv->except($season->id));
                } else {
                  $all->push($fil_tv);
                }
              }
            }
          }
        }
        $all = $all->unique();
        $all = $all->flatten();
      @endphp
      @if (isset($all) && count($all) > 0)
        <div class="genre-prime-block">
          <div class="container-fluid">
            <h5 class="section-heading">{{$home_translations->where('key', 'customers also watched')->first->value['value']}}</h5>
            <div class="genre-prime-slider owl-carousel">
              @if(isset($all))
                @foreach($all as $key => $item)
                  @php
                   if(isset($auth)){
                    if ($item->type == 'S') {
                       $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                        ['user_id', '=', $auth->id],
                                                                        ['season_id', '=', $item->id],
                                                                       ])->first();
                    } elseif ($item->type == 'M') {
                      $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                        ['user_id', '=', $auth->id],
                                                                        ['movie_id', '=', $item->id],
                                                                       ])->first();
                    }

                  }
                  @endphp
                  @if($item->type == 'M')
                    @if(isset($movie))
                    <div class="genre-prime-slide">
                      <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-title="#prime-mix-description-block{{$item->id}}">
                        @if($auth && $subscribed ==1)
                        <a href="{{url('movie/detail',$item->id)}}">
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/movies/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                          <a href="{{url('movie/guest/detail',$item->id)}}">
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/movies/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif
                      </div>
                      <div id="prime-mix-description-block{{$item->id}}" class="prime-description-block">
                        <h5 class="description-heading">{{$item->title}}</h5>
                        <div class="movie-rating">{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$item->rating}}</div>
                        <ul class="description-list">
                          <li>{{$item->duration}} {{$popover_translations->where('key', 'mins')->first->value['value']}}</li>
                          <li>{{$item->publish_year}}</li>
                          <li>{{$item->maturity_rating}}</li>
                          @if($item->subtitle == 1)
                            <li>CC</li>
                            <li>
                             {{$popover_translations->where('key', 'subtitles')->first->value['value']}}
                            </li>
                          @endif
                        </ul>
                        <div class="main-des">
                          <p>{{$item->detail}}</p>
                          <a href="#"></a>
                        </div>
                        @if($subscribed!=1)
                         <div class="des-btn-block">
                         @if($item->trailer_url != null || $item->trailer_url != '')
                            <a href="{{route('guestwatchtrailer',$item->id)}}" class="iframe btn-default">{{$popover_translations->where('key', 'watch trailer')->first->value['value']}}</a>
                              @endif
                          </div>
                        
                        @endif
                          @if($subscribed==1 && $auth)
                        <div class="des-btn-block">
                           @if($item->maturity_rating == 'all age' || $age>=str_replace('+', '', $item->maturity_rating))
                           @if($item->video_link['iframeurl'] != null)
                              
                              <a onclick="playoniframe('{{ $item->video_link['iframeurl'] }}','{{ $item->id }}','tv')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                              </a>

                             @else 
                          <a href="{{route('watchmovie',$item->id)}}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                          @endif
                          @else

                              <a onclick="myage({{$age}})" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                              </a>
                          @endif
                          @if($item->trailer_url != null || $item->trailer_url != '')
                            <a href="{{route('watchTrailer',$item->id)}}" class="iframe btn-default">{{$popover_translations->where('key', 'watch trailer')->first->value['value']}}</a>
                          @endif
                          @if (isset($wishlist_check->added))
                            <a onclick="addWish({{$item->id}},'{{$item->type}}')" class="addwishlistbtn{{$item->id}}{{$item->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                          @else
                            <a onclick="addWish({{$item->id}},'{{$item->type}}')" class="addwishlistbtn{{$item->id}}{{$item->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}</a>
                          @endif
                        </div>
                        @endif
                      </div>
                    </div>
                  @endif
                  @endif

                  @if($item->type == "S")
                    @if(!isset($movie))
                    <div class="genre-prime-slide">
                      <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-title="#prime-mix-description-block{{$item->id}}{{$item->type}}">
                        @if($auth && $subscribed ==1)
                        <a href="{{url('show/detail',$item->id)}}">
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->tvseries->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                          <a href="{{url('show/guest/detail',$item->id)}}">
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->tvseries->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif
                      </div>
                      <div id="prime-mix-description-block{{$item->id}}{{$item->type}}" class="prime-description-block">
                        <h5 class="description-heading">{{$item->tvseries->title}}</h5>
                        <div class="movie-rating">{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$item->tvseries->rating}}</div>
                        <ul class="description-list">
                          <li>Season {{$item->season_no}}</li>
                          <li>{{$item->publish_year}}</li>
                          <li>{{$item->tvseries->age_req}}</li>
                          @if($item->subtitle == 1)
                            <li>CC</li>
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
                          
                        <div class="des-btn-block">
                          @if($subscribed==1 && $auth)
                          @if(isset($item->episodes[0]))
                          @if($item->tvseries->age_req == 'all age' || $age>=str_replace('+', '', $item->tvseries->age_req))
                           @if($item->episodes[0]->video_link['iframeurl'] !="")

                            <a href="#" onclick="playoniframe('{{ $item->episodes[0]->video_link['iframeurl'] }}','{{ $item->tvseries->id }}','tv')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                             </a>
                             
                            @else
                              <a href="{{route('watchTvShow',$item->id)}}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                            @endif
                          @else

                            <a onclick="myage({{$age}})" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                             </a>
                          @endif
                          @endif
                          @if (isset($wishlist_check->added))
                            <a onclick="addWish({{$item->id}},'{{$item->type}}')" class="addwishlistbtn{{$item->id}}{{$item->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                          @else
                            <a onclick="addWish({{$item->id}},'{{$item->type}}')" class="addwishlistbtn{{$item->id}}{{$item->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}</a>
                          @endif
                         
                         @endif
                        </div>
                       
                      </div>
                    </div>
                    @endif
                  @endif
                @endforeach
              @endif
            </div>
          </div>
        </div>
      @endif
    @else
      @php
        $all = collect();
        $all_fil_movies = App\Movie::all();
        $all_fil_tv = App\TvSeries::all();
        if (isset($movie)) {
          $genres = explode(',', $movie->genre_id);
        } elseif (isset($season)) {
          $genres = explode(',', $season->tvseries->genre_id);
        }
        for($i = 0; $i < count($genres); $i++) {
          foreach ($all_fil_movies as $fil_movie) {
            $fil_genre_item = explode(',', trim($fil_movie->genre_id));
            for ($k=0; $k < count($fil_genre_item); $k++) {
              if (trim($fil_genre_item[$k]) == trim($genres[$i])) {
                if (isset($movie)) {
                  if ($fil_movie->id != $movie->id) {
                    $all->push($fil_movie);
                  }
                } else {
                  $all->push($fil_movie);
                }
              }
            }
          }
        }
        if (isset($movie)) {
          $all = $all->except($movie->id);
        }

        for($i = 0; $i < count($genres); $i++) {
          foreach ($all_fil_tv as $fil_tv) {
            $fil_genre_item = explode(',', trim($fil_tv->genre_id));
            for ($k=0; $k < count($fil_genre_item); $k++) {
              if (trim($fil_genre_item[$k]) == trim($genres[$i])) {
                $fil_tv = $fil_tv->seasons;
                if (isset($season)) {
                  $all->push($fil_tv->except($season->id));
                } else {
                  $all->push($fil_tv);
                }
              }
            }
          }
        }
        $all = $all->unique();
        $all = $all->flatten();
      @endphp
      @if (isset($all) && count($all) > 0)
        <div class="genre-main-block">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-3">
                <div class="genre-dtl-block">
                  <h3 class="section-heading">{{$home_translations->where('key', 'customers also watched')->first->value['value']}}</h3>
                  <p class="section-dtl">{{$home_translations->where('key', 'at the big screen at home')->first->value['value']}}</p>
                </div>
              </div>
              <div class="col-md-9">
                <div class="genre-main-slider owl-carousel">
                  @if(isset($all))
                    @foreach($all as $key => $item)
                      @if($item->type == 'S')
                        <div class="genre-slide">
                          <div class="genre-slide-image">
                            @if($auth && $subscribed ==1)
                              <a href="{{url('show/detail/'.$item->id)}}">
                                @if($item->thumbnail != null)
                                  <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                                @elseif($item->tvseries->thumbnail != null)
                                  <img src="{{asset('images/tvseries/thumbnails/'.$item->tvseries->thumbnail)}}" class="img-responsive" alt="genre-image">
                                @else
                                  <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                                @endif
                              </a>
                            @else
                              <a href="{{url('show/guest/detail/'.$item->id)}}">
                              @if($item->thumbnail != null)
                                <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                              @elseif($item->tvseries->thumbnail != null)
                                <img src="{{asset('images/tvseries/thumbnails/'.$item->tvseries->thumbnail)}}" class="img-responsive" alt="genre-image">
                              @else
                                <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                              @endif
                            </a>
                            @endif
                          </div>
                          <div class="genre-slide-dtl">
                            @if($auth && $subscribed ==1)
                            <h5 class="genre-dtl-heading"><a href="{{url('show/detail/'.$item->id)}}">{{$item->tvseries->title}}</a></h5>
                            @else
                            <h5 class="genre-dtl-heading"><a href="{{url('show/guest/detail/'.$item->id)}}">{{$item->tvseries->title}}</a></h5>
                            @endif
                            <div class="genre-small-info">{{$item->detail != null ? $item->detail : $item->tvseries->detail}}</div>
                          </div>
                        </div>
                      @elseif($item->type == 'M')
                        <div class="genre-slide">
                          <div class="genre-slide-image">
                            @if($auth  && $subscribed ==1)
                            <a href="{{url('movie/detail/'.$item->id)}}">
                              @if($item->thumbnail != null)
                                <img src="{{asset('images/movies/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                              @endif
                            </a>
                            @else
                               <a href="{{url('movie/guest/detail/'.$item->id)}}">
                              @if($item->thumbnail != null)
                                <img src="{{asset('images/movies/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                              @endif
                            </a>
                            @endif
                          </div>
                          <div class="genre-slide-dtl">
                            @if($auth && $subscribed ==1)
                            <h5 class="genre-dtl-heading"><a href="{{url('movie/detail/'.$item->id)}}">{{$item->title}}</a></h5>
                            @else 
                            <h5 class="genre-dtl-heading"><a href="{{url('movie/guest/detail/'.$item->id)}}">{{$item->title}}</a></h5>
                            @endif
                          </div>
                        </div>
                      @endif
                    @endforeach
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      @endif
    @endif
  </section>


 @endsection

@section('custom-script')
<script type="text/javascript">
   function mouseoverrating () {
        
        $.ajax({
            type: "POST",
            url: "{{url('/video/rating')}}",
            data:$("#formrating").serialize(),
            success: function (data) {
              console.log(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
            }
        });
    
        }
          function mouseoverratingtv () {
        
        $.ajax({
            type: "POST",
            url: "{{url('/video/rating/tv')}}",
            data:$("#formrating").serialize(),
            success: function (data) {
              console.log(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
            }
        });
    
        }
</script>
<script type="text/javascript">


    var app = new Vue({
      el: '#wishlistelement',
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

    function addWish(id, type) {
      app.addToWishList(id, type);
      setTimeout(function() {
        $('.addwishlistbtn'+id+type).text(function(i, text){
          return text == "{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}" ? "{{$popover_translations->where('key', 'remove from watchlist')->first->value['value']}}" : "{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}";
        });
      }, 100);
    }
  </script>

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
      $('#selectseason').on('change',function(){
        var get = $('#selectseason').val();
         @if(Auth::check() && $subscribed == '1')
        window.location.href = '{{ url('show/detail/') }}/'+get;
        @else
         window.location.href = '{{ url('show/guest/detail/') }}/'+get;
        @endif
      });
    </script>
      
 <script>

      function myage(age){
        if (age==0) {
        $('#ageModal').modal('show'); 
      }else{
          $('#ageWarningModal').modal('show');
      }
    }
      
    </script>
  
 <script type="text/javascript">

  function myrate(){
            $.ajax({
            type: "POST",
            url: "{{url('/video/rating')}}",
            data:$("#formrating").serialize(),
            success: function (data) {
              console.log(data);
              location.reload();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
             console.log(XMLHttpRequest);
            }
        });
    }

     function myrateTv(){
            $.ajax({
            type: "POST",
            url: "{{url('/video/rating/tv')}}",
            data:$("#formratingtv").serialize(),
            success: function (data) {
              console.log(data);
              location.reload();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
            }
        });
    }

  $(document).ready(function(){

  $("#rating").on('mouseout',function(event){
           event.preventDefault();
           var val = $(".rating").val();

           // alert(val)

         $.ajax({
            type: "GET",
            url: "{{url('/video/rating')}}",
            data:$("#formrating").serialize(),
            success: function (data) {
              console.log(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
             console.log(XMLHttpRequest);
            }
        });

  });

  $("#rating").on('mouseover',function(event){
           event.preventDefault();
           var val = $(".rating").val();

           // alert(val)

         $.ajax({
            type: "GET",
            url: "{{url('/video/rating')}}",
            data:$("#formrating").serialize(),
            success: function (data) {
              console.log(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
             console.log(XMLHttpRequest);
            }
        });

  });

  $("#rating").on('mouseenter',function(event){
           event.preventDefault();
           var val = $(".rating").val();

           // alert(val)

         $.ajax({
            type: "GET",
            url: "{{url('/video/rating')}}",
            data:$("#formrating").serialize(),
            success: function (data) {
              console.log(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
             console.log(XMLHttpRequest);
            }
        });

  });

  $("#rating").on('mouseleave',function(event){
           event.preventDefault();
           var val = $(".rating").val();

           // alert(val)

         $.ajax({
            type: "GET",
            url: "{{url('/video/rating')}}",
            data:$("#formrating").serialize(),
            success: function (data) {
              console.log(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
             console.log(XMLHttpRequest);
            }
        });

  });

   function mouseoverrating () {
        // $.ajax({
        //     type: "GET",
        //     url: "{{url('/video/rating')}}",
        //     data:$("#formrating").serialize(),
        //     success: function (data) {
        //       console.log(data);
        //     },
        //     error: function(XMLHttpRequest, textStatus, errorThrown) {
        //      console.log(XMLHttpRequest);
        //     }
        // });
    
        }
    
          
    function mouseoverratingtv () {    
        $.ajax({
            type: "POST",
            url: "{{url('/video/rating/tv')}}",
            data:$("#formratingtv").serialize(),
            success: function (data) {
              console.log(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
            }
        });
    
        }
  });
</script>
@endsection
