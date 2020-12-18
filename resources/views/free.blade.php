@extends('layouts.theme')
@section('title',"$menu->name")
@section('main-wrapper')

  <!-- main wrapper  slider -->
  <section id="wishlistelement" class="main-wrapper">
{{-- code to get age for age restriction --}}


    <div>
      <div id="home-main-block" class="home-main-block">
        <div id="home-slider-one" class="home-slider-one owl-carousel">
          @if(isset($home_slides))
            @foreach($home_slides as $slide)
              @if($slide->active == 1)
                <div class="slider-block">
                  <div class="slider-image">
                    @if($slide->movie_id != null)
                    @if($auth && $subscribed==1)
                      <a href="{{url('movie/detail', $slide->movie->id)}}">
                        @if ($slide->slide_image != null)
                          <img src="{{asset('images/home_slider/movies/'. $slide->slide_image)}}" class="img-responsive" alt="slider-image">
                        @elseif ($slide->movie->poster != null)
                          <img src="{{asset('images/movies/posters/'. $slide->movie->poster)}}" class="img-responsive" alt="slider-image">
                        @endif
                      </a>
                      @else
                       <a href="{{url('movie/guest/detail', $slide->movie->id)}}">
                        @if ($slide->slide_image != null)
                          <img src="{{asset('images/home_slider/movies/'. $slide->slide_image)}}" class="img-responsive" alt="slider-image">
                        @elseif ($slide->movie->poster != null)
                          <img src="{{asset('images/movies/posters/'. $slide->movie->poster)}}" class="img-responsive" alt="slider-image">
                        @endif
                      </a>
                      @endif
                    @elseif($slide->tv_series_id != null && isset($slide->tvseries->seasons[0]))
                      <a href="{{url('show/detail', $slide->tvseries->seasons[0]->id)}}">
                        @if ($slide->slide_image != null)
                          <img src="{{asset('images/home_slider/shows/'. $slide->slide_image)}}" class="img-responsive" alt="slider-image">
                        @elseif ($slide->tvseries->poster != null)
                          <img src="{{asset('images/tvseries/posters/'. $slide->tvseries->poster)}}" class="img-responsive" alt="slider-image">
                        @endif
                      </a>
                    @endif
                  </div>
                </div>
              @endif
            @endforeach
          @endif
        </div>
      </div>
   {{-- modal to ask for age --}}

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
</div>
      @if($prime_genre_slider == 1)
        @if(count($all_mix) > 0)
         @if(isset($sliderview))
         @foreach($sliderview as $s)
         @if($s->id==1  && $s->sliderview==1)
          <div class="genre-prime-block">

         
            @php
             $block_no = 0;
              $t = DB::table('home_translations')->where('key','=','watch next tv series and movies')->first();
            @endphp

            @if($t->status==1)
            <div class="container-fluid">
              <h5 class="section-heading">{{ $home_translations->where('key', 'watch next tv series and movies')->first->value['value']}} </h5>
              @if($auth && $subscribed==1)
              <a href="{{ route('showall',['menuid' => $menu->id, 'menuname' => $menu->name]) }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
              @else
              <a href="{{ route('guestshowall',['menuid' => $menu->id, 'menuname' => $menu->name]) }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
              @endif
              <div class="genre-prime-slider owl-carousel">
                @foreach($all_mix as $key => $item)
                   @php
                   if(isset($auth)){


                     if ($item->type == 'M') {
                      $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                        ['user_id', '=', $auth->id],
                                                                        ['movie_id', '=', $item->id],
                                                                      ])->first();
                    }
                     }
                  @endphp
                  
                  @if($item->type == 'T')

                   @php
 if(isset($auth)){
                            $gets1 = App\Season::where('tv_series_id','=',$item->id)->first();

                            if (isset($gets1)) {


                              $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                          ['user_id', '=', $auth->id],
                                                                          ['season_id', '=', $gets1->id],
                                ])->first();


                              }
                            }
                   @endphp


                    <div class="genre-prime-slide">
                      <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-title="#prime-mix-description-block{{$item->id}}{{$item->type}}">
                        @if($auth && $subscribed==1)
                        <a @if(isset($gets1)) href="{{url('show/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                         <a @if(isset($gets1)) href="{{url('show/guest/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif                      </div>
                      <div id="prime-mix-description-block{{$item->id}}{{$item->type}}" class="prime-description-block">
                        <h5 class="description-heading">{{$item->title}}</h5>
                        <div class="movie-rating">{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$item->rating}}</div>
                        <ul class="description-list">
                          <li>{{$popover_translations->where('key', 'season')->first->value['value']}} {{$item->season_no}}</li>
                          <li>{{$item->publish_year}}</li>
                          <li>{{$item->age_req}}</li>
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
                            <p>{{$item->detail}}</p>
                          @endif
                          <a href="#"></a>
                        </div>
                        @if($auth && $subscribed==1)
                        <div class="des-btn-block">
                          @if (isset($gets1->episodes[0]))
                             @if($age>=str_replace('+', '', $item->age_req))

                            @if($gets1->episodes[0]->video_link->iframeurl !="")
                             
                            <a href="#" onclick="playoniframe('{{ $gets1->episodes[0]->video_link->iframeurl }}')" class="btn btn-play"><span class= "play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                             </a>

                            @else
                            <a href="{{ route('watchTvShow',$gets1->id) }}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                            @endif
                            @else
                             <a onclick="myage({{$age}})" class=" btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                            @endif
                           
                          @endif
                           @if(isset($gets1))
                          @if (isset($wishlist_check->added))
                            <a onclick="addWish({{$gets1->id}},'{{$gets1->type}}')" class="addwishlistbtn{{$gets1->id}}{{$gets1->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                          @else
                          @if($gets1)
                            <a onclick="addWish({{$gets1->id}},'{{$gets1->type}}')" class="addwishlistbtn{{$gets1->id}}{{$gets1->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}
                            </a>
                            @endif
                            @endif
                          @endif
                        </div>
                        @endif
                      </div>
                    </div>
                  @elseif($item->type == 'M')
                    <div class="genre-prime-slide">
                      <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-title="#prime-mix-description-block{{$item->id}}">
                        @if($auth && $subscribed==1)
                        <a href="{{url('movie/detail',$item->id)}}">
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/movies/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                          <a href="{{url('movie/guest/detail',$item->id)}}">
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/movies/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
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
                            <li>
                              {{$popover_translations->where('key', 'subtitles')->first->value['value']}}
                            </li>
                          @endif
                        </ul>
                        <div class="main-des">
                          <p>{{$item->detail}}</p>
                          <a href="#"></a>
                        </div>
                        @if($catlog==1 && is_null($subscribed))
                        @if($withlogin==0 && $auth)
                          @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('watchTrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @else
                           @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('guestwatchtrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @endif

                          @endif

                          @if($auth && $subscribed==1)
                        <div class="des-btn-block">
                           @if($age>=str_replace('+', '', $item->maturity_rating))
                          @if($item->video_link->iframeurl != null)
                          
                          <a onclick="playoniframe('{{ $item->video_link->iframeurl }}')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                          </a>

                          @else
                            <a href="{{route('watchmovie',$item->id)}}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                            </a>
                          @endif
                          @else
                            <a onclick="myage({{$age}})" class=" btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                            </a>
                          @endif
                          
                          @if($withlogin==0 && $auth)
                          @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('watchTrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @else
                           @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('guestwatchtrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @endif

                          @if (isset($wishlist_check->added))
                            <button onclick="addWish({{$item->id}},'{{$item->type}}')" class="addwishlistbtn{{$item->id}}{{$item->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</button>
                          @else
                         
                            <button onclick="addWish({{$item->id}},'{{$item->type}}')" class="addwishlistbtn{{$item->id}}{{$item->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}</button>
                          @endif
                          
                        </div>
                        @endif
                      </div>
                    </div>
                  @endif
                @endforeach
              </div>
            </div>
            @endif

          </div>
            @break

            <!-- starting grid view code -->
          @elseif($s->id==1  && $s->sliderview==0)
          <div class="genre-prime-block">

             @php
             $block_no = 0;
              $t = DB::table('home_translations')->where('key','=','watch next tv series and movies')->first();
            @endphp

            @if($t->status==1)
            <div class="container-fluid">
              <h5 class="section-heading">{{ $home_translations->where('key', 'watch next tv series and movies')->first->value['value']}} </h5>
               @if($auth && $subscribed==1)
              <a href="{{ route('showall',['menuid' => $menu->id, 'menuname' => $menu->name]) }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
             
                @else
                <a href="{{ route('guestshowall',['menuid' => $menu->id, 'menuname' => $menu->name]) }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
               
                @endif
  <div class="">
               @foreach($all_mix as $key => $item)
                   @php
 if(isset($auth)){
                     if ($item->type == 'M') {
                      $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                        ['user_id', '=', $auth->id],
                                                                        ['movie_id', '=', $item->id],
                                                                      ])->first();
                    }
                  }
                  @endphp
                  
                  @if($item->type == 'T')

                   @php
 if(isset($auth)){
                            $gets1 = App\Season::where('tv_series_id','=',$item->id)->first();

                            if (isset($gets1)) {


                              $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                          ['user_id', '=', $auth->id],
                                                                          ['season_id', '=', $gets1->id],
                                ])->first();


                              }
                            }
                   @endphp
                    <div class="col-lg-2 col-md-3 col-xs-6 col-sm-4">
                      <div class="cus_img">
                    <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-mix-description-block{{$item->id}}{{$item->type}}">
                       @if($auth && $subscribed==1)
                        <a @if(isset($gets1)) href="{{url('show/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                         <a @if(isset($gets1)) href="{{url('show/guest/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif

                    </div>
                     <div id="prime-mix-description-block{{$item->id}}{{$item->type}}" class="prime-description-block">
                        <h5 class="description-heading">{{$item->title}}</h5>
                        <div class="movie-rating">{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$item->rating}}</div>
                        <ul class="description-list">
                          <li>{{$popover_translations->where('key', 'season')->first->value['value']}} {{$item->season_no}}</li>
                          <li>{{$item->publish_year}}</li>
                          <li>{{$item->age_req}}</li>
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
                            <p>{{$item->detail}}</p>
                          @endif
                          <a href="#"></a>
                        </div>
  @if($auth && $subscribed==1)
                        <div class="des-btn-block">
                          @if (isset($gets1->episodes[0]))
                              @if($age>=str_replace('+', '', $item->age_req))

                            @if($gets1->episodes[0]->video_link->iframeurl !="")
                          
                            <a href="#" onclick="playoniframe('{{ $gets1->episodes[0]->video_link->iframeurl }}')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                             </a>

                            @else
                          <a href="{{ route('watchTvShow',$gets1->id) }}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play">
                            </i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                            </a>

                            @endif
                            @else
                              <a onclick="myage({{$age}})" class=" btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                            @endif
                           
                          @endif

                           @if(isset($gets1))
                          @if (isset($wishlist_check->added))
                            <a onclick="addWish({{$gets1->id}},'{{$gets1->type}}')" class="addwishlistbtn{{$gets1->id}}{{$gets1->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                          @else
                          @if($gets1)
                            <a onclick="addWish({{$gets1->id}},'{{$gets1->type}}')" class="addwishlistbtn{{$gets1->id}}{{$gets1->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}
                            </a>
                            @endif
                            @endif
                          @endif
                        </div>
                        @endif
                      </div>
                   
                  </div>
                </div>
                  @elseif($item->type == 'M')
                  <div class="col-lg-2 col-md-3 col-xs-6 col-sm-4">
                      <div class="cus_img">
                        <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-mix-description-block{{$item->id}}">
                          @if($auth && $subscribed==1)
                          <a href="{{url('movie/detail',$item->id)}}">
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/movies/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                         <a href="{{url('movie/guest/detail',$item->id)}}">
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/movies/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
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
                            <li>
                              {{$popover_translations->where('key', 'subtitles')->first->value['value']}}
                            </li>
                          @endif
                        </ul>
                        <div class="main-des">
                          <p>{{$item->detail}}</p>
                          <a href="#"></a>
                        </div>
                         @if($catlog==1 && is_null($subscribed))
                       @if($withlogin==0 && $auth)
                          @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('watchTrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @else
                           @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('guestwatchtrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @endif

                          @endif
                          @if($auth && $subscribed==1)
                        <div class="des-btn-block">
                            @if($age>=str_replace('+', '', $item->maturity_rating))

                          @if($item->video_link->iframeurl != null)
                          
                          <a onclick="playoniframe('{{ $item->video_link->iframeurl }}')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                          </a>

                          @else
                            <a href="{{route('watchmovie',$item->id)}}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                            </a>
                          @endif
                          @else
                            <a  onclick="myage({{$age}})" class=" btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                            </a>
                          @endif

                          @if($withlogin==0 && $auth)
                          @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('watchTrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @else
                           @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('guestwatchtrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @endif

                          @if (isset($wishlist_check->added))
                            <button onclick="addWish({{$item->id}},'{{$item->type}}')" class="addwishlistbtn{{$item->id}}{{$item->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</button>
                          @else
                         
                            <button onclick="addWish({{$item->id}},'{{$item->type}}')" class="addwishlistbtn{{$item->id}}{{$item->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}</button>
                          @endif
                          
                        </div>
                        @endif
                      </div>
                      </div>
                    </div>

                   @endif
                   @endforeach
            </div>
          </div>
          </div>
            @break
          @endif
          @endif
          @endforeach
          @endif

        @endif
<!-- watch next movies -->
        @if ( isset($movies) && count($movies) > 0 )
         @if(isset($sliderview))
         @foreach($sliderview as $s)
         @if($s->id==2  && $s->sliderview==1)
          <div class="genre-prime-block">
            @php
            $block_no = 1;
              $t1 = DB::table('home_translations')->where('key','=','watch next movies')->first();
            @endphp
            @if($t1->status == 1)
            <div class="container-fluid">
              <h5 class="section-heading">{{$home_translations->where('key', 'watch next movies') ? $home_translations->where('key', 'watch next movies')->first->value['value'] : ''}}</h5>
                  @if($auth && $subscribed==1)
              <a href="{{ route('showall2') }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
               @else
                 <a href="{{ route('guestshowall2') }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
               @endif
              <div class="genre-prime-slider owl-carousel">
                @if(isset($movies))

               @php 
                $getmoviecount = App\FrontSliderUpdate::where('id',2)->first()->item_show;
                $mco = $getmoviecount; 
               @endphp

                  
                  @foreach($movies as $a => $movie)
                   @if($a<$mco)
                    @php
                     if(isset($auth)){
                      $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                          ['user_id', '=', $auth->id],
                                                                          ['movie_id', '=', $movie->id],
                                                                         ])->first();
                                                                       }
                    @endphp
                     
                    <div class="genre-prime-slide">
                      
                      <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-movie-description-block{{$movie->id}}">
                        @if($auth && $subscribed==1)
                        <a href="{{url('movie/detail',$movie->id)}}">
                          @if($movie->thumbnail != null || $movie->thumbnail != '')
                            <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                        
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                            </a>
                          @else
                           <a href="{{url('movie/guest/detail',$movie->id)}}">
                          @if($movie->thumbnail != null || $movie->thumbnail != '')
                            <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                        
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                           </a>
                          @endif
                       
                      </div>
                      <div id="prime-next-movie-description-block{{$movie->id}}" class="prime-description-block">
                        <div class="prime-description-under-block">
                          <h5 class="description-heading">{{$movie->title}}</h5>
                          <div class="movie-rating">{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$movie->rating}}</div>
                          <ul class="description-list">
                            <li>{{$movie->duration}} {{$popover_translations->where('key', 'mins')->first->value['value']}}</li>
                            <li>{{$movie->publish_year}}</li>
                            <li>{{$movie->maturity_rating}}</li>
                            @if($movie->subtitle == 1)
                              <li>
                               {{$popover_translations->where('key', 'subtitles')->first->value['value']}}
                              </li>
                            @endif
                          </ul>
                          <div class="main-des">
                            <p>{{$movie->detail}}</p>
                            <a href="#">Read more</a>
                          </div>
                           @if($catlog==1 && is_null($subscribed))
                      @if($withlogin==0 && $auth)
                          @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('watchTrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @else
                           @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('guestwatchtrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @endif

                          @endif
                            @if($auth && $subscribed==1)
                          <div class="des-btn-block">
                              @if($age>=str_replace('+', '', $movie->maturity_rating))
                            @if($movie->video_link->iframeurl != null)
                          
                            <a onclick="playoniframe('{{ $movie->video_link->iframeurl }}')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                            </a>

                            @else 
                              <a href="{{route('watchmovie',$movie->id)}}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                            @endif
                            @else
                             <a onclick="myage({{$age}})" class=" btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                            @endif
                           
                           @if($withlogin==0 && $auth)
                          @if($movie->trailer_url != null || $movie->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('watchTrailer',$movie->id) }}">Watch Trailer</a>
                          @endif
                          @else
                           @if($movie->trailer_url != null || $movie->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('guestwatchtrailer',$movie->id) }}">Watch Trailer</a>
                          @endif
                          @endif

                            @if (isset($wishlist_check->added))
                              <a onclick="addWish({{$movie->id}},'{{$movie->type}}')" class="addwishlistbtn{{$movie->id}}{{$movie->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                            @else
                              <a onclick="addWish({{$movie->id}},'{{$movie->type}}')" class="addwishlistbtn{{$movie->id}}{{$movie->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}</a>
                            @endif
                          </div>
                          @endif
                        </div>
                      </div>
                    </div>
                    @else
                      <?php break; ?>
                    @endif
                  @endforeach
                @endif
              </div>
            </div>
            @endif
          </div>
            @break
            @elseif($s->id==2  && $s->sliderview==0)
            <div class="genre-prime-block">
               @php
            $block_no = 1;
              $t1 = DB::table('home_translations')->where('key','=','watch next movies')->first();
            @endphp
            @if($t1->status == 1)
            <div class="container-fluid">
              <h5 class="section-heading">{{$home_translations->where('key', 'watch next movies') ? $home_translations->where('key', 'watch next movies')->first->value['value'] : ''}}</h5>
                @if($auth && $subscribed==1)
              <a href="{{ route('showall2') }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
          
                @else
                   <a href="{{ route('guestshowall2') }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
             
                @endif
                    <div class="">
              @if(isset($movies))

               @php 
                $getmoviecount = App\FrontSliderUpdate::where('id',2)->first()->item_show;
                $mco = $getmoviecount; 
               @endphp
                  @foreach($movies as $a => $movie)
                   @if($a<$mco)
                    @php
                      if(isset($auth)){
                      $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                          ['user_id', '=', $auth->id],
                                                                          ['movie_id', '=', $movie->id],
                                                                         ])->first();
                                                                       }
                    @endphp

                     <div class="col-lg-2 col-md-3 col-xs-6 col-sm-4">
                        <div class="cus_img">
                           <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-movie-description-block{{$movie->id}}">
                            @if($auth && $subscribed==1)
                        <a href="{{url('movie/detail',$movie->id)}}">
                          @if($movie->thumbnail != null || $movie->thumbnail != '')
                            <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else

                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                            </a>
                          @else
                           <a href="{{url('movie/guest/detail',$movie->id)}}">
                          @if($movie->thumbnail != null || $movie->thumbnail != '')
                            <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else

                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                            </a>
                          @endif
                       
                      </div>
                      <div id="prime-next-movie-description-block{{$movie->id}}" class="prime-description-block">
                        <div class="prime-description-under-block">
                          <h5 class="description-heading">{{$movie->title}}</h5>
                          <div class="movie-rating">{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$movie->rating}}</div>
                          <ul class="description-list">
                            <li>{{$movie->duration}} {{$popover_translations->where('key', 'mins')->first->value['value']}}</li>
                            <li>{{$movie->publish_year}}</li>
                            <li>{{$movie->maturity_rating}}</li>
                            @if($movie->subtitle == 1)
                              <li>
                               {{$popover_translations->where('key', 'subtitles')->first->value['value']}}
                              </li>
                            @endif
                          </ul>
                          <div class="main-des">
                            <p>{{$movie->detail}}</p>
                            <a href="#">Read more</a>
                          </div>
                            @if($catlog==1 && is_null($subscribed))
                        @if($withlogin==0 && $auth)
                          @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('watchTrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @else
                           @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('guestwatchtrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @endif

                          @endif
                            @if($auth && $subscribed==1)
                          <div class="des-btn-block">
                              @if($age>=str_replace('+', '', $movie->maturity_rating))

                            @if($movie->video_link->iframeurl != null)
                          
                            <a onclick="playoniframe('{{ $movie->video_link->iframeurl }}')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                            </a>

                            @else 
                              <a href="{{route('watchmovie',$movie->id)}}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                            @endif
                            @else
                             <a onclick="myage({{$age}})" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                            @endif
                           
                            @if($withlogin==0 && $auth)
                          @if($movie->trailer_url != null || $movie->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('watchTrailer',$movie->id) }}">Watch Trailer</a>
                          @endif
                          @else
                           @if($movie->trailer_url != null || $movie->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('guestwatchtrailer',$movie->id) }}">Watch Trailer</a>
                          @endif
                          @endif

                            @if (isset($wishlist_check->added))
                              <a onclick="addWish({{$movie->id}},'{{$movie->type}}')" class="addwishlistbtn{{$movie->id}}{{$movie->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                            @else
                              <a onclick="addWish({{$movie->id}},'{{$movie->type}}')" class="addwishlistbtn{{$movie->id}}{{$movie->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}</a>
                            @endif
                          </div>@endif
                        </div>
                      </div>
                        </div></div>
      @else
                      <?php break; ?>
                    
   @endif
 

                      @endforeach
                           @endif

              </div>
              </div>
              @break
              @endif
            </div>
        @endif
        @endforeach
        @endif
        @endif
<br>
<!-- Tv Series  Next -->
        @if ( isset($tvserieses) && count($tvserieses) > 0 )
         @if(isset($sliderview))
         @foreach($sliderview as $s)
         @if($s->id==3  && $s->sliderview==1)
         
          <div class="genre-prime-block">
            
            @php
            
              $t2 = DB::table('home_translations')->where('key','=','watch next tv series')->first();
             
                $getvs = App\FrontSliderUpdate::where('id',3)->first()->item_show;
                
            @endphp

              @if($t2->status == 1)<div class="container-fluid">
              <h5 class="section-heading">{{$home_translations->where('key', 'watch next tv series')->first->value['value']}}</h5>
               @if($auth && $subscribed==1)
              <a href="{{ route('showall3') }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
               @else
                <a href="{{ route('guestshowall3') }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
                @endif
              <div class="genre-prime-slider owl-carousel">

                @if(isset($tvserieses))

              
                  @foreach($tvserieses as $y => $series)
                  
                  @if($y<$getvs)
                  
                      
                        
                        @php
                         if(isset($auth)){
                            $gets1 = App\Season::where('tv_series_id','=',$series->id)->first();

                        if (isset($gets1)) {


                              $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                          ['user_id', '=', $auth->id],
                                                                          ['season_id', '=', $gets1->id],
                                ])->first();


                              }
                            }
                      @endphp

                        <div class="genre-prime-slide">
                          <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-title="#prime-next-show-description-block{{$series->id}}{{$series->type}}">
                              @if($auth && $subscribed==1)
                        <a @if(isset($gets1)) href="{{url('show/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$series->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$series->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                         <a @if(isset($gets1)) href="{{url('show/guest/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$series->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$series->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif
                          </div>
                          <div id="prime-next-show-description-block{{$series->id}}{{$series->type}}" class="prime-description-block">
                            <h5 class="description-heading">{{$series->title}}</h5>
                            <div class="movie-rating">{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$series->rating}}</div>
                            <ul class="description-list">
                              <li>{{$popover_translations->where('key', 'season')->first->value['value']}} {{$series->season_no}}</li>
                              <li>{{$series->publish_year}}</li>
                              <li>{{$series->age_req}}</li>
                              @if($series->subtitle == 1)
                                <li>
                                  {{$popover_translations->where('key', 'subtitles')->first->value['value']}}
                                </li>
                              @endif
                            </ul>
                            <div class="main-des">
                              @if ($series->detail != null || $series->detail != '')
                                <p>{{$series->detail}}</p>
                              @else
                                <p>{{$series->detail}}</p>
                              @endif
                              <a href="#"></a>
                            </div>
                              @if($auth && $subscribed==1)
                            <div class="des-btn-block">
                              @if (isset($gets1->episodes[0]))
                                @if($age>=str_replace('+', '', $series->age_req))
                              @if($gets1->episodes[0]->video_link->iframeurl !="")

                              <a href="#" onclick="playoniframe('{{ $gets1->episodes[0]->video_link->iframeurl }}')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                              </a>
                              @else
                              <a href="{{ route('watchTvShow',$gets1->id) }}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                              
                              @endif
                              @else
                               <a  onclick="myage({{$age}})" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                              </a>
                              @endif

                              @endif
                         @if(isset($gets1))
                              @if (isset($wishlist_check->added))
                                <a onclick="addWish({{$gets1->id}},'{{$gets1->type}}')" class="addwishlistbtn{{$gets1->id}}{{$gets1->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                              @else
                              @if(isset($gets1))
                                <a onclick="addWish({{$gets1->id}},'{{$gets1->type}}')" class="addwishlistbtn{{$gets1->id}}{{$gets1->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}
                                </a>
                                @endif
                              @endif
                              @endif
                            </div>
                            @endif
                          </div>
                        </div>   

                   @endif

                  @endforeach
                @endif
              </div>
            </div>@endif
          </div>
          @break
          @elseif($s->id==3  && $s->sliderview==0)
          <div class="genre-prime-block">
            @php
            
              $t2 = DB::table('home_translations')->where('key','=','watch next tv series')->first();
             
                $getvs = App\FrontSliderUpdate::where('id',3)->first()->item_show;
                
            @endphp

              @if($t2->status == 1)<div class="container-fluid">
              <h5 class="section-heading">{{$home_translations->where('key', 'watch next tv series')->first->value['value']}}</h5>
                 @if($auth && $subscribed==1)
              <a href="{{ route('showall3') }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>

              @else
                <a href="{{ route('guestshowall3') }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b>
              @endif

           <div class="">
                @if(isset($tvserieses))

              
                  @foreach($tvserieses as $y => $series)
                  
                  @if($y<$getvs)
                  
                      
                        
                        @php
                         if(isset($auth)){
                            $gets1 = App\Season::where('tv_series_id','=',$series->id)->first();

                        if (isset($gets1)) {


                              $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                          ['user_id', '=', $auth->id],
                                                                          ['season_id', '=', $gets1->id],
                                ])->first();


                              }
                            }
                      @endphp
   <div class="col-lg-2 col-md-3 col-xs-6 col-sm-4">
                        <div class="cus_img">
                       <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-title="#prime-next-show-description-block{{$series->id}}{{$series->type}}">
                             @if($auth && $subscribed==1)
                        <a @if(isset($gets1)) href="{{url('show/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                         <a @if(isset($gets1)) href="{{url('show/guest/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif
                          </div>
                          <div id="prime-next-show-description-block{{$series->id}}{{$series->type}}" class="prime-description-block">
                            <h5 class="description-heading">{{$series->title}}</h5>
                            <div class="movie-rating">{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$series->rating}}</div>
                            <ul class="description-list">
                              <li>{{$popover_translations->where('key', 'season')->first->value['value']}} {{$series->season_no}}</li>
                              <li>{{$series->publish_year}}</li>
                              <li>{{$series->age_req}}</li>
                              @if($series->subtitle == 1)
                                <li>
                                  {{$popover_translations->where('key', 'subtitles')->first->value['value']}}
                                </li>
                              @endif
                            </ul>
                            <div class="main-des">
                              @if ($series->detail != null || $series->detail != '')
                                <p>{{$series->detail}}</p>
                              @else
                                <p>{{$series->detail}}</p>
                              @endif
                              <a href="#"></a>
                            </div>
                              @if($auth && $subscribed==1)
                            <div class="des-btn-block">
                              @if (isset($gets1->episodes[0]))
                               @if($age>=str_replace('+', '', $series->age_req))
                              @if($gets1->episodes[0]->video_link->iframeurl !="")

                              <a href="#" onclick="playoniframe('{{ $gets1->episodes[0]->video_link->iframeurl }}')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                              </a>
                              @else
                              <a href="{{ route('watchTvShow',$gets1->id) }}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                              
                              @endif
                              @else
                                <a  onclick="myage({{$age}})" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                              </a>
                              @endif
                             
                            @if(isset($gets1))
                              @if (isset($wishlist_check->added))
                                <a onclick="addWish({{$gets1->id}},'{{$gets1->type}}')" class="addwishlistbtn{{$gets1->id}}{{$gets1->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                              @else
                              @if(isset($gets1))
                                <a onclick="addWish({{$gets1->id}},'{{$gets1->type}}')" class="addwishlistbtn{{$gets1->id}}{{$gets1->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}
                                </a>
                                @endif
                              @endif
                              @endif
                               @endif
                            </div>
                            @endif
                          </div>
                          </div></div>
                    @endif
                  @endforeach
                @endif
              </div>
              </div>
            </div>@endif
          </div>
            @break
          @endif
          @endforeach
          @endif
        @endif

        <!-- genre block  for movies-->
          @if(isset($genres))
          @foreach($genres as $key => $genre)

            @php
              
              $all_movies = collect();
              $fil_movies = $menu->menu_data;
              foreach ($fil_movies as $key => $value) {
                
                if ( isset($value->movie) ) {
                  $all_movies->push($value->movie);
                }
              }

              $all_movies = $all_movies->flatten();
              $all_movies =  $all_movies->filter(function($value, $key) {
                return  $value != null;
              });

              $movies = null;
              $movies = collect();
              foreach ($all_movies as $item) {
                if ($item->genre_id != null && $item->genre_id != '') {
                  $movie_genre_list = explode(',', $item->genre_id);
                  for($i = 0; $i < count($movie_genre_list); $i++) {
                    $check = Illuminate\Support\Facades\DB::table('genres')->where('id', '=', trim($movie_genre_list[$i]))->get();
                    if (isset($check[0]) && $check[0]->id == $genre->id) {
                      $movies->push($item);
                    }
                  }
                }
              }
 
            @endphp

            @if (count($movies) > 0)
               @if(isset($sliderview))
         @foreach($sliderview as $s)
         @if($s->id==5  && $s->sliderview==1)
         <div class="genre-prime-block">

                @php
                  $genre_index = $key;
                  $t3 = DB::table('home_translations')->where('key','=','movies')->first();

                  $getvs = App\FrontSliderUpdate::where('id',4)->first()->item_show;
                  
                  $orderby = App\FrontSliderUpdate::where('id',4)->first()->orderby;
              
                     if($orderby == 0){
                      $movies = collect($movies)->sortByDesc('id');
                     }
   
                @endphp
                @if($t3->status == 1)
                <div class="container-fluid">

                  <h5 class="section-heading inline">{{$genre->name}} {{$home_translations->where('key', 'movies')->first->value['value']}}</h5>
                  <p> here{{$getvs}}</p>
                 @if($auth && $subscribed==1)
                  <a href="{{url('movies/genre', $genre->id)}}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
                  @else
                      <a href="{{url('movies/guest/genre', $genre->id)}}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
                  @endif
                  <div class="genre-prime-slider owl-carousel">
                    @foreach($movies as $t => $movie)
                    @if($t<$getvs)
                      @php

                       if(isset($auth)){
                        $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([['user_id', '=', $auth->id],['movie_id', '=', $movie->id]])->first();
                         }
                      @endphp
                      <div class="genre-prime-slide">
                        <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-title="#prime-genre-movie-description-block{{$movie->id}}">
                          @if($auth && $subscribed==1)
                          <a href="{{url('movie/detail',$movie->id)}}">
                            @if($movie->thumbnail != null || $movie->thumbnail != '')
                              <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                            @else
                              <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                            @endif
                              </a>
                            @else
                             <a href="{{url('movie/guest/detail',$movie->id)}}">
                            @if($movie->thumbnail != null || $movie->thumbnail != '')
                              <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                            @else
                              <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                            @endif
                              </a>
                            @endif
                         
                        </div>
                        <div id="prime-genre-movie-description-block{{$movie->id}}" class="prime-description-block">
                          <div class="prime-description-under-block">
                            <h5 class="description-heading">{{$movie->title}}</h5>
                            <div class="movie-rating">{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$movie->rating}}</div>
                            <ul class="description-list">
                              <li>{{$movie->duration}} {{$popover_translations->where('key', 'mins')->first->value['value']}}</li>
                              <li>{{$movie->publish_year}}</li>
                              <li>{{$movie->maturity_rating}}</li>
                              @if($movie->subtitle == 1)
                                <li>
                                  {{$popover_translations->where('key', 'subtitles')->first->value['value']}}
                                </li>
                              @endif
                            </ul>
                            <div class="main-des">
                              <p>{{$movie->detail}}</p>
                              <a href="#"></a>
                            </div>
                             @if($catlog==1 && is_null($subscribed))
                        @if($withlogin==0 && $auth)
                          @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('watchTrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @else
                           @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('guestwatchtrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @endif

                          @endif
                              @if($auth && $subscribed==1)
                            <div class="des-btn-block">
                               @if($age>=str_replace('+', '', $movie->maturity_rating))
                              @if($movie->video_link->iframeurl != null)
                          
                            <a onclick="playoniframe('{{ $movie->video_link->iframeurl }}')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                            </a>
                             @else 
                            <a href="{{route('watchmovie',$movie->id)}}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                             @endif
                             @else

                            <a onclick="myage({{$age}})" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                            </a>
                             @endif

                              
                              @if($withlogin==0 && $auth)
                          @if($movie->trailer_url != null || $movie->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('watchTrailer',$movie->id) }}">Watch Trailer</a>
                          @endif
                          @else
                           @if($movie->trailer_url != null || $movie->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('guestwatchtrailer',$movie->id) }}">Watch Trailer</a>
                          @endif
                          @endif

                              @if (isset($wishlist_check->added))
                                <a onclick="addWish({{$movie->id}},'{{$movie->type}}')" class="addwishlistbtn{{$movie->id}}{{$movie->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                              @else
                                <a onclick="addWish({{$movie->id}},'{{$movie->type}}')" class="addwishlistbtn{{$movie->id}}{{$movie->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}</a>
                              @endif
                            </div>
                            @endif
                          </div>
                        </div>
                      </div>
                   
@endif
                    @endforeach
                  </div>
                </div>@endif
              </div>
              @break
                 @elseif($s->id==5  && $s->sliderview==0)
 <div class="genre-prime-block">

                @php
                  $genre_index = $key;
                  $t3 = DB::table('home_translations')->where('key','=','movies')->first();

                  $getvs = App\FrontSliderUpdate::where('id',4)->first()->item_show;
                  
                  $orderby = App\FrontSliderUpdate::where('id',4)->first()->orderby;
              
                     if($orderby == 0){
                      $movies = collect($movies)->sortByDesc('id');
                     }
   
                @endphp
                @if($t3->status == 1)
                <div class="container-fluid">
                  <h5 class="section-heading inline">{{$genre->name}} {{$home_translations->where('key', 'movies')->first->value['value']}}</h5>
 @if($auth && $subscribed==1)
                  <a href="{{url('movies/genre', $genre->id)}}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
                  @else
                    <a href="{{url('movies/guest/genre', $genre->id)}}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
                  @endif
                  <div class="">
                    @foreach($movies as $t => $movie)
                    @if($t<$getvs)
                      @php
                       if(isset($auth)){
                        $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                            ['user_id', '=', $auth->id],
                                                                            ['movie_id', '=', $movie->id],
                                                                           ])->first();
                                                                         }
                      @endphp
                     
                         <div class="col-lg-2 col-md-3 col-xs-6 col-sm-4">
                        <div class="cus_img">
                      <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-genre-movie-description-block{{$movie->id}}">
                        @if($auth && $subscribed==1)
                         <a href="{{url('movie/detail',$movie->id)}}">
                            @if($movie->thumbnail != null || $movie->thumbnail != '')
                              <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                            @else
                              <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                            @endif
                          </a>
                          @else
                           <a href="{{url('movie/guest/detail',$movie->id)}}">
                            @if($movie->thumbnail != null || $movie->thumbnail != '')
                              <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                            @else
                              <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                            @endif
                          </a>
                          @endif
                      </div>
                      <div id="prime-genre-movie-description-block{{$movie->id}}" class="prime-description-block">
                          <div class="prime-description-under-block">
                            <h5 class="description-heading">{{$movie->title}}</h5>
                            <div class="movie-rating">{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$movie->rating}}</div>
                            <ul class="description-list">
                              <li>{{$movie->duration}} {{$popover_translations->where('key', 'mins')->first->value['value']}}</li>
                              <li>{{$movie->publish_year}}</li>
                              <li>{{$movie->maturity_rating}}</li>
                              @if($movie->subtitle == 1)
                                <li>
                                  {{$popover_translations->where('key', 'subtitles')->first->value['value']}}
                                </li>
                              @endif
                            </ul>
                            <div class="main-des">
                              <p>{{$movie->detail}}</p>
                              <a href="#"></a>
                            </div>
                              @if($catlog==1 && is_null($subscribed))
                         @if($withlogin==0 && $auth)
                          @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('watchTrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @else
                           @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('guestwatchtrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @endif

                          @endif
                              @if($auth && $subscribed==1)
                            <div class="des-btn-block">
                                @if($age>=str_replace('+', '', $movie->maturity_rating))
                              @if($movie->video_link->iframeurl != null)
                          
                            <a onclick="playoniframe('{{ $movie->video_link->iframeurl }}')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                            </a>
                             @else 
                                <a href="{{route('watchmovie',$movie->id)}}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                             @endif
                             @else
                              <a onclick="myage({{$age}})" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                            </a>
                             @endif

                              
                              @if($withlogin==0 && $auth)
                          @if($movie->trailer_url != null || $movie->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('watchTrailer',$movie->id) }}">Watch Trailer</a>
                          @endif
                          @else
                           @if($movie->trailer_url != null || $movie->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('guestwatchtrailer',$movie->id) }}">Watch Trailer</a>
                          @endif
                          @endif

                              @if (isset($wishlist_check->added))
                                <a onclick="addWish({{$movie->id}},'{{$movie->type}}')" class="addwishlistbtn{{$movie->id}}{{$movie->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                              @else
                                <a onclick="addWish({{$movie->id}},'{{$movie->type}}')" class="addwishlistbtn{{$movie->id}}{{$movie->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}</a>
                              @endif
                            </div>
                            @endif
                          </div>
                        </div>
                    </div>
                  </div>
                       
                     @endif
                    @endforeach
                  </div>
                </div>@endif
              </div>
                 @break

         @endif
         @endforeach
         @endif
              
            @endif
          @endforeach
        @endif

        <!-- genere Tv Series -->
        @if(isset($genres))
          @foreach($genres as $key => $genre)
            @php
              $all_tvseries = collect();
              $fil_tvserieses = $menu->menu_data;
              foreach ($fil_tvserieses as $key => $value) {
                if (isset($value->tvseries)) {
                  $all_tvseries->push($value->tvseries);
                }
              }

              $all_tvseries = $all_tvseries->flatten();
              $all_tvseries =  $all_tvseries->filter(function($value, $key) {
                return  $value != null;
              });

              $seasons = collect();
              foreach ($all_tvseries as $item) {
                if ($item->genre_id != null && $item->genre_id != '') {
                  $tvseries_genre_list = explode(',', $item->genre_id);
                  for($i = 0; $i < count($tvseries_genre_list); $i++) {
                    $check = Illuminate\Support\Facades\DB::table('genres')->where('id', '=', trim($tvseries_genre_list[$i]))->get();
                    if (isset($check[0]) && $check[0]->id == $genre->id) {
                      $seasons->push($item);
                    }
                  }
                }
              }
              $seasons = $seasons->shuffle()->flatten();
            @endphp
            @if (count($seasons) > 0)
             @if(isset($sliderview))
         @foreach($sliderview as $s)
         @if($s->id==6  && $s->sliderview==1)
              <div class="genre-prime-block">
                @php
                  $t4 = DB::table('home_translations')->where('key','=','tv shows')->first();

                  $getvs = App\FrontSliderUpdate::where('id',5)->first()->item_show;
                  
                  $orderby = App\FrontSliderUpdate::where('id',5)->first()->orderby;
              
                     if($orderby == 0){
                      $seasons = collect($seasons)->sortByDesc('id');
                     }
   
                @endphp
                @if($t4->status ==1)
                <div class="container-fluid">
                  <h5 class="section-heading inline">{{$genre->name}} {{$home_translations->where('key', 'tv shows')->first->value['value']}}</h5>
                  @if($auth && $subscribed==1)
                  <a href="{{url('tvseries/genre', $genre->id)}}" class="see-more"><b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b> </a>
                  @else
                    <a href="{{url('tvseries/guest/genre', $genre->id)}}" class="see-more"><b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b> </a>
                  @endif
                  <div class="genre-prime-slider owl-carousel">
                    @foreach($seasons as $key => $item)
                      @if($key<$getvs)
                     @php
                       if(isset($auth)){
                        $gets1 = App\Season::where('tv_series_id','=',$item->id)->first();
                      

                        if(isset($gets1))
                        {
                             $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                              ['user_id', '=', $auth->id],
                                                                              ['season_id', '=', $gets1->id],
                                                                             ])->first();
                        }
                      }
                        
                      @endphp

                      <div class="genre-prime-slide">
                        <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-title="#prime-genre-tvseries-description-block{{$item->id}}{{$item->type}}">
                          @if($auth && $subscribed==1)
                        <a @if(isset($gets1)) href="{{url('show/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                         <a @if(isset($gets1)) href="{{url('show/guest/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif
                        </div>
                        <div id="prime-genre-tvseries-description-block{{$item->id}}{{$item->type}}" class="prime-description-block">
                          <h5 class="description-heading">{{$item->title}}</h5>
                          <div class="movie-rating">{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$item->rating}}</div>
                          <ul class="description-list">
                            <li>{{$popover_translations->where('key', 'season')->first->value['value']}} {{$item->season_no}}</li>
                            <li>{{$item->publish_year}}</li>
                            <li>{{$item->age_req}}</li>
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
                              <p>{{$item->detail}}</p>
                            @endif
                            <a href="#"></a>
                          </div>
                            @if($auth && $subscribed==1)
                          <div class="des-btn-block">
                            @if (isset($gets1->episodes[0]))
                              @if($age>=str_replace('+', '', $movie->maturity_rating))
                              @if($gets1->episodes[0]->video_link->iframeurl !="")

                              <a href="#" onclick="playoniframe('{{ $gets1->episodes[0]->video_link->iframeurl }}')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                              </a>
                              @else
                              <a href="{{ route('watchTvShow',$gets1->id) }}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                              @endif
                              @else
                               <a onclick="myage({{$age}})" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                              </a>
                              @endif
                            @endif
                             @if(isset($gets1))
                            @if (isset($wishlist_check->added))
                              <a onclick="addWish({{$gets1->id}},'{{$gets1->type}}')" class="addwishlistbtn{{$gets1->id}}{{$gets1->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                            @else
                            @if($gets1)
                              <a onclick="addWish({{$gets1->id}},'{{$gets1->type}}')" class="addwishlistbtn{{$gets1->id}}{{$gets1->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}
                              </a>
                              @endif
                              @endif
                            @endif
                          </div>
                          @endif
                        </div>
                      </div>
                      @endif
                    @endforeach
                  </div>
                </div>@endif
              </div>
              @break
              {{-- slider view start for genre block of tv shows --}}
              @elseif($s->id==6  && $s->sliderview==0)
                <div class="genre-prime-block">
                @php
                  $t4 = DB::table('home_translations')->where('key','=','tv shows')->first();
                   $getvs = App\FrontSliderUpdate::where('id',5)->first()->item_show;
                  
                  $orderby = App\FrontSliderUpdate::where('id',5)->first()->orderby;
              
                     if($orderby == 0){
                      $seasons = collect($seasons)->sortByDesc('id');
                     }
                @endphp
                @if($t4->status ==1)
                <div class="container-fluid">
                  <h5 class="section-heading inline">{{$genre->name}} {{$home_translations->where('key', 'tv shows')->first->value['value']}}</h5>
                   @if($auth && $subscribed==1)
                  <a href="{{url('tvseries/genre', $genre->id)}}" class="see-more"><b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b> </a>
                  @else
                    <a href="{{url('tvseries/guest/genre', $genre->id)}}" class="see-more"><b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b> </a>
                  @endif
                  <div class="">
                    @foreach($seasons as $key => $item)
                     @if($key<$getvs)
                     @php
                       if(isset($auth)){
                        $gets1 = App\Season::where('tv_series_id','=',$item->id)->first();
                      

                        if(isset($gets1))
                        {
                             $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                              ['user_id', '=', $auth->id],
                                                                              ['season_id', '=', $gets1->id],
                                                                             ])->first();
                        }
                      }
                        
                      @endphp

                           
                  <div class="col-lg-2 col-md-3 col-xs-6 col-sm-4">
                        <div class="cus_img">
                         
                         <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-genre-tvseries-description-block{{$item->id}}{{$item->type}}">
                       
                         @if($auth && $subscribed==1)
                        <a @if(isset($gets1)) href="{{url('show/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                         <a @if(isset($gets1)) href="{{url('show/guest/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif
                        </div>
                        <div id="prime-genre-tvseries-description-block{{$item->id}}{{$item->type}}" class="prime-description-block">
                          <h5 class="description-heading">{{$item->title}}</h5>
                          <div class="movie-rating">{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$item->rating}}</div>
                          <ul class="description-list">
                            <li>{{$popover_translations->where('key', 'season')->first->value['value']}} {{$item->season_no}}</li>
                            <li>{{$item->publish_year}}</li>
                            <li>{{$item->age_req}}</li>
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
                              <p>{{$item->detail}}</p>
                            @endif
                            <a href="#"></a>
                          </div>
                            @if($auth && $subscribed==1)
                          <div class="des-btn-block">
                            @if (isset($gets1->episodes[0]))
                              @if($age>=str_replace('+', '', $movie->maturity_rating))
                              @if($gets1->episodes[0]->video_link->iframeurl !="")

                              <a href="#" onclick="playoniframe('{{ $gets1->episodes[0]->video_link->iframeurl }}')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                              </a>
                              @else
                              <a href="{{ route('watchTvShow',$gets1->id) }}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                              @endif
                              @else
                                <a  onclick="myage({{$age}})" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                              </a>
                              @endif
                            @endif
                             @if(isset($gets1))
                            @if (isset($wishlist_check->added))
                              <a onclick="addWish({{$gets1->id}},'{{$gets1->type}}')" class="addwishlistbtn{{$gets1->id}}{{$gets1->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                            @else
                            @if($gets1)
                              <a onclick="addWish({{$gets1->id}},'{{$gets1->type}}')" class="addwishlistbtn{{$gets1->id}}{{$gets1->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}
                              </a>
                              @endif
                              @endif
                            @endif
                          </div>
                          @endif
                        </div>
                    </div>
                        </div>
                        @endif
                    @endforeach
                  </div>
                </div>@endif
              </div>
              @break
                @endif
          @endforeach
        @endif
            @endif
          @endforeach
        @endif

        <!-- language movies -->
        @if(isset($a_languages))
          @foreach($a_languages as $key => $lang)
            @php
              $all_movies = collect();
              $fil_movies = $menu->menu_data;
              foreach ($fil_movies as $key => $value) {
                if (isset($value->movie)) {
                  $all_movies->push($value->movie);
                }
              }

              $all_movies = $all_movies->flatten();
              $all_movies =  $all_movies->filter(function($value, $key) {
                return  $value != null;
              });

              $movies = null;
              $movies = collect();
              foreach ($all_movies as $item) {
                if ($item->a_language != null && $item->a_language != '') {
                  $movie_lang_list = explode(',', $item->a_language);
                  for($i = 0; $i < count($movie_lang_list); $i++) {
                    $check = \App\AudioLanguage::find(trim($movie_lang_list[$i]));
                    if (isset($check) && $check->id == $lang->id) {
                      $movies->push($item);
                    }
                  }
                }
              }
            @endphp
            @if (count($movies) > 0)
              @if(isset($sliderview))
         @foreach($sliderview as $s)
         @if($s->id==7  && $s->sliderview==1)
              <div class="genre-prime-block">
                @php
                  $t5 = DB::table('home_translations')->where('key','=','movies in')->first();
                   $getvs = App\FrontSliderUpdate::where('id',6)->first()->item_show;
                  
                  $orderby = App\FrontSliderUpdate::where('id',6)->first()->orderby;
              
                     if($orderby == 0){
                      $movies = collect($movies)->sortByDesc('id');
                     }
                @endphp
                @if($t5->status==1)<div class="container-fluid">
                  <h5 class="section-heading inline">{{$home_translations->where('key', 'movies in')->first->value['value']}} {{$lang->language}}</h5>
                   @if($auth && $subscribed==1)
                  <a href="{{url('movies/language', $lang->id)}}" class="see-more"><b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b> </a>
                  @else
                    <a href="{{url('movies/guest/language', $lang->id)}}" class="see-more"><b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b> </a>
                  @endif

                  <div class="genre-prime-slider owl-carousel">
                    @foreach($movies as $key => $movie)
                    @if($key<$getvs)
                      @php
                       if(isset($auth)){
                        $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                            ['user_id', '=', $auth->id],
                                                                            ['movie_id', '=', $movie->id],
                                                                           ])->first();
                                                                         }
                      @endphp
                      <div class="genre-prime-slide">
                        <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-title="#prime-lang-movie-description-block{{$movie->id}}">
                             @if($auth && $subscribed==1)
                          <a href="{{url('movie/detail',$movie->id)}}">
                            @if($movie->thumbnail != null || $movie->thumbnail != '')
                              <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                            @else
                              <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                            @endif
                              </a>
                            @else
                             <a href="{{url('movie/guest/detail',$movie->id)}}">
                            @if($movie->thumbnail != null || $movie->thumbnail != '')
                              <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                            @else
                              <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                            @endif
                              </a>
                            @endif
                          
                        </div>
                        <div id="prime-lang-movie-description-block{{$movie->id}}" class="prime-description-block">
                          <div class="prime-description-under-block">
                            <h5 class="description-heading">{{$movie->title}}</h5>
                            <div class="movie-rating">{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$movie->rating}}</div>
                            <ul class="description-list">
                              <li>{{$movie->duration}} {{$popover_translations->where('key', 'mins')->first->value['value']}}</li>
                              <li>{{$movie->publish_year}}</li>
                              <li>{{$movie->maturity_rating}}</li>
                              @if($movie->subtitle == 1)
                                <li>
                                  {{$popover_translations->where('key', 'subtitles')->first->value['value']}}
                                </li>
                              @endif
                            </ul>
                            <div class="main-des">
                              <p>{{$movie->detail}}</p>
                              <a href="#"></a>
                            </div>
                              @if($catlog==1 && is_null($subscribed))
                        @if($withlogin==0 && $auth)
                          @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('watchTrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @else
                           @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('guestwatchtrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @endif

                          @endif
                              @if($auth && $subscribed==1)
                            <div class="des-btn-block">
                               @if($age>=str_replace('+', '', $movie->maturity_rating))
                               @if($movie->video_link->iframeurl != null)
                          
                            <a onclick="playoniframe('{{ $movie->video_link->iframeurl }}')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                            </a>
                             @else 
                              <a href="{{route('watchmovie',$movie->id)}}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                              @endif 
                              @else

                            <a onclick="myage({{$age}})" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                            </a>
                              @endif
                              @if($withlogin==0 && $auth)
                          @if($movie->trailer_url != null || $movie->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('watchTrailer',$movie->id) }}">Watch Trailer</a>
                          @endif
                          @else
                           @if($movie->trailer_url != null || $movie->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('guestwatchtrailer',$movie->id) }}">Watch Trailer</a>
                          @endif
                          @endif

                              @if (isset($wishlist_check->added))
                                <a onclick="addWish({{$movie->id}},'{{$movie->type}}')" class="addwishlistbtn{{$movie->id}}{{$movie->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                              @else
                                <a onclick="addWish({{$movie->id}},'{{$movie->type}}')" class="addwishlistbtn{{$movie->id}}{{$movie->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}</a>
                              @endif
                            </div>
                            @endif
                          </div>
                        </div>
                      </div>
                      @endif
                    @endforeach
                  </div>
                </div>@endif
              </div>
              @break
              @elseif($s->id==7  && $s->sliderview==0)
                 <div class="genre-prime-block">
                @php
                  $t5 = DB::table('home_translations')->where('key','=','movies in')->first();
                   $getvs = App\FrontSliderUpdate::where('id',6)->first()->item_show;
                  
                  $orderby = App\FrontSliderUpdate::where('id',6)->first()->orderby;
              
                     if($orderby == 0){
                      $movies = collect($movies)->sortByDesc('id');
                     }
                @endphp
                @if($t5->status==1)<div class="container-fluid">
                  <h5 class="section-heading inline">{{$home_translations->where('key', 'movies in')->first->value['value']}} {{$lang->language}}</h5>
                    @if($auth && $subscribed==1)
                  <a href="{{url('movies/language', $lang->id)}}" class="see-more"><b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b> </a>
                  @else
                    <a href="{{url('movies/guest/language', $lang->id)}}" class="see-more"><b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b> </a>
                  @endif
                  <div class="">
                    @foreach($movies as $key => $movie)
                    @if($key<$getvs)
                      @php
                       if(isset($auth)){
                        $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                            ['user_id', '=', $auth->id],
                                                                            ['movie_id', '=', $movie->id],
                                                                           ])->first();
                                                                         }
                      @endphp
                     <div class="col-lg-2 col-md-3 col-xs-6 col-sm-4">
                        <div class="cus_img">
                          
                        
                      <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-lang-movie-description-block{{$movie->id}}">
                        @if($auth && $subscribed==1)
                          <a href="{{url('movie/detail',$movie->id)}}">
                            @if($movie->thumbnail != null || $movie->thumbnail != '')
                              <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                            @else
                              <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                            @endif
                              </a>
                            @else
                              <a href="{{url('movie/guest/detail',$movie->id)}}">
                            @if($movie->thumbnail != null || $movie->thumbnail != '')
                              <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                            @else
                              <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                            @endif
                              </a>
                            @endif
                        
                        </div>
                        <div id="prime-lang-movie-description-block{{$movie->id}}" class="prime-description-block">
                          <div class="prime-description-under-block">
                            <h5 class="description-heading">{{$movie->title}}</h5>
                            <div class="movie-rating">{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$movie->rating}}</div>
                            <ul class="description-list">
                              <li>{{$movie->duration}} {{$popover_translations->where('key', 'mins')->first->value['value']}}</li>
                              <li>{{$movie->publish_year}}</li>
                              <li>{{$movie->maturity_rating}}</li>
                              @if($movie->subtitle == 1)
                                <li>
                                  {{$popover_translations->where('key', 'subtitles')->first->value['value']}}
                                </li>
                              @endif
                            </ul>
                            <div class="main-des">
                              <p>{{$movie->detail}}</p>
                              <a href="#"></a>
                            </div>
                            @if($subscribed!=1)
                             @if($withlogin==0 && $auth)
                          @if($movie->trailer_url != null || $movie->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('watchTrailer',$movie->id) }}">Watch Trailer</a>
                          @endif
                          @else
                           @if($movie->trailer_url != null || $movie->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('guestwatchtrailer',$movie->id) }}">Watch Trailer</a>
                          @endif
                          @endif
                           @endif
                              @if($auth && $subscribed==1)
                            <div class="des-btn-block">
                                @if($age>=str_replace('+', '', $movie->maturity_rating))
                               @if($movie->video_link->iframeurl != null)
                          
                            <a onclick="playoniframe('{{ $movie->video_link->iframeurl }}')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                            </a>
                             @else 
                              <a href="{{route('watchmovie',$movie->id)}}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                              @endif 
                              @else
                                <a onclick="myage({{$age}})" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                               </a>
                              @endif
                               @if($withlogin==0 && $auth)
                          @if($movie->trailer_url != null || $movie->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('watchTrailer',$movie->id) }}">Watch Trailer</a>
                          @endif
                          @else
                           @if($movie->trailer_url != null || $movie->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('guestwatchtrailer',$movie->id) }}">Watch Trailer</a>
                          @endif
                          @endif

                              @if (isset($wishlist_check->added))
                                <a onclick="addWish({{$movie->id}},'{{$movie->type}}')" class="addwishlistbtn{{$movie->id}}{{$movie->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                              @else
                                <a onclick="addWish({{$movie->id}},'{{$movie->type}}')" class="addwishlistbtn{{$movie->id}}{{$movie->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}</a>
                              @endif
                            </div>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                      @endif
                    @endforeach
                  </div>
                </div>@endif
              </div>
              @break
               @endif
          @endforeach
        @endif
            @endif
          @endforeach
        @endif

        <!-- language tv shows -->
       @if(isset($a_languages))
          @foreach($a_languages as $key => $lang)
            @php
              $all_tvseries = collect();
              $fil_tvserieses = $menu->menu_data;
              foreach ($fil_tvserieses as $key => $value) {
                if (isset($value->tvseries)) {
                  $all_tvseries->push($value->tvseries);
                }
              }

              $all_tvseries = $all_tvseries->flatten();
              $all_tvseries =  $all_tvseries->filter(function($value, $key) {
                return  $value != null;
              });

              $all_seasons = null;
              $all_seasons = collect();

              foreach ($all_tvseries as $tv) {
                if ( isset($tv->seasons) && count($tv->seasons) > 0 ) {
                  $all_seasons->push($tv->seasons[0]);
                }
              }

              $all_seasons = $all_seasons->flatten();
              $all_seasons =  $all_seasons->filter(function($value, $key) {
                return  $value != null;
              });

              $seasons = null;
              $seasons = collect();
              foreach ($all_seasons as $item) {
                if ($item->a_language != null && $item->a_language != '') {
                  $season_lang_list = explode(',', $item->a_language);
                  for($i = 0; $i < count($season_lang_list); $i++) {
                    $check = \App\AudioLanguage::find(trim($season_lang_list[$i]));
                    if (isset($check) && $check->id == $lang->id) {
                      $seasons->push($item);
                    }
                  }
                }
              }
              $seasons = $seasons->flatten();
            @endphp
            @if (count($seasons) > 0)
             @if(isset($sliderview))
         @foreach($sliderview as $s)
         @if($s->id==8  && $s->sliderview==1)
              <div class="genre-prime-block">
                @php
                  $t6 = DB::table('home_translations')->where('key','=','tv shows in')->first();
                  $getvs = App\FrontSliderUpdate::where('id',7)->first()->item_show;
                  
                  $orderby = App\FrontSliderUpdate::where('id',7)->first()->orderby;
              
                     if($orderby == 0){
                      $seasons = collect($seasons)->sortByDesc('id');
                     }

                @endphp
                @if($t6->status==1)<div class="container-fluid">
                  <h5 class="section-heading inline">{{$home_translations->where('key', 'tv shows in')->first->value['value']}} {{$lang->language}}</h5>
                    @if($auth && $subscribed==1)
                  <a href="{{url('tvseries/language', $lang->id)}}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
                  @else
                     <a href="{{url('tvseries/guest/language', $lang->id)}}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
                  @endif
                  <div class="genre-prime-slider owl-carousel">
                    @foreach($seasons as $key => $item)
                    @if($key<$getvs)
                      @php
                       if(isset($auth)){
                           $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                            ['user_id', '=', $auth->id],
                                                                            ['season_id', '=', $item->id],
                                                                           ])->first();
                                                                         }
                      @endphp
                      <div class="genre-prime-slide">
                        <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-title="#prime-genre-tvseries-description-block{{$item->id}}{{$item->type}}">
                           @if($auth && $subscribed==1)
                        <a @if(isset($gets1)) href="{{url('show/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                         <a @if(isset($gets1)) href="{{url('show/guest/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif
                        </div>
                        <div id="prime-genre-tvseries-description-block{{$item->id}}{{$item->type}}" class="prime-description-block">
                          <h5 class="description-heading">{{$item->tvseries['title']}}</h5>
                          <div class="movie-rating">{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$item->tvseries['rating']}}</div>
                          <ul class="description-list">
                            <li>{{$popover_translations->where('key', 'season')->first->value['value']}} {{$item->season_no}}</li>
                            <li>{{$item->publish_year}}</li>
                            <li>{{$item->tvseries['age_req']}}</li>
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
                          <div class="des-btn-block">
                            
                            <a href="{{ route('watchTvShow',$item->id) }}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>

                            @if (isset($wishlist_check->added))
                              <a onclick="addWish({{$item->id}},'{{$item->type}}')" class="addwishlistbtn{{$item->id}}{{$item->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                            @else
                              <a onclick="addWish({{$item->id}},'{{$item->type}}')" class="addwishlistbtn{{$item->id}}{{$item->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}</a>
                            @endif
                          </div>
                        </div>
                      </div>
                      @endif
                    @endforeach
                  </div>
                </div>@endif
              </div>
              @break
              @elseif($s->id==8  && $s->sliderview==0)
<div class="genre-prime-block">
                @php
                  $t6 = DB::table('home_translations')->where('key','=','tv shows in')->first();
                   $getvs = App\FrontSliderUpdate::where('id',7)->first()->item_show;
                  
                  $orderby = App\FrontSliderUpdate::where('id',7)->first()->orderby;
              
                     if($orderby == 0){
                      $seasons = collect($seasons)->sortByDesc('id');
                     }
                @endphp
                @if($t6->status==1)<div class="container-fluid">
                  <h5 class="section-heading inline">{{$home_translations->where('key', 'tv shows in')->first->value['value']}} {{$lang->language}}</h5>
                   @if($auth && $subscribed==1)
                  <a href="{{url('tvseries/language', $lang->id)}}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
                  @else
                   <a href="{{url('tvseries/guest/language', $lang->id)}}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
                  @endif
                  <div class="">
                    @foreach($seasons as $key => $item)
                    @if($key<$getvs)
                      @php
                       if(isset($auth)){
                           $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                            ['user_id', '=', $auth->id],
                                                                            ['season_id', '=', $item->id],
                                                                           ])->first();
                                                                         }
                      @endphp
                    <div class="col-lg-2 col-md-3 col-xs-6 col-sm-4">
                        <div class="cus_img">
                          
                        
                      <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-genre-tvseries-description-block{{$item->id}}{{$item->type}}">
                       
                           @if($auth && $subscribed==1)
                        <a @if(isset($gets1)) href="{{url('show/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                         <a @if(isset($gets1)) href="{{url('show/guest/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif
                        </div>
                        <div id="prime-genre-tvseries-description-block{{$item->id}}{{$item->type}}" class="prime-description-block">
                          <h5 class="description-heading">{{$item->tvseries['title']}}</h5>
                          <div class="movie-rating">{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$item->tvseries['rating']}}</div>
                          <ul class="description-list">
                            <li>{{$popover_translations->where('key', 'season')->first->value['value']}} {{$item->season_no}}</li>
                            <li>{{$item->publish_year}}</li>
                            <li>{{$item->tvseries['age_req']}}</li>
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
                          <div class="des-btn-block">
                            
                            <a href="{{ route('watchTvShow',$item->id) }}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>

                            @if (isset($wishlist_check->added))
                              <a onclick="addWish({{$item->id}},'{{$item->type}}')" class="addwishlistbtn{{$item->id}}{{$item->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                            @else
                              <a onclick="addWish({{$item->id}},'{{$item->type}}')" class="addwishlistbtn{{$item->id}}{{$item->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}</a>
                            @endif
                          </div>
                        </div>
                    </div>
                  </div>
                  @endif
                    @endforeach
                  </div>
                </div>@endif
              </div>
              @break
                @endif
          @endforeach
        @endif
            @endif
          @endforeach
        @endif
        <!-- featured movies -->
        @if(isset($featured_movies) && count($featured_movies) > 0)
         @if(isset($sliderview))
         @foreach($sliderview as $s)
         @if($s->id==9  && $s->sliderview==1)
          <div class="genre-prime-block">
            @php
              $t7 = DB::table('home_translations')->where('key','=','featured')->first();
                                 $getvs = App\FrontSliderUpdate::where('id',8)->first()->item_show;
                  
                  $orderby = App\FrontSliderUpdate::where('id',8)->first()->orderby;
              
                     if($orderby == 0){
                      $featured_movies = collect($featured_movies)->sortByDesc('id');
                     }
            @endphp
            @if($t7->status==1)
            <div class="container-fluid">
              <h5 class="section-heading">{{$home_translations->where('key', 'featured')->first->value['value']}} {{$home_translations->where('key', 'movies')->first->value['value']}}</h5>
              <div class="genre-prime-slider owl-carousel">
                @foreach($featured_movies as $key => $movie)
                @if($key<$getvs)
                  @php
                   if(isset($auth)){
                    $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                        ['user_id', '=', $auth->id],
                                                                        ['movie_id', '=', $movie->id],
                                                                       ])->first();

                                                                     }
                  @endphp
                  <div class="genre-prime-slide">
                    <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-title="#prime-genre-movie-description-block{{$movie->id}}">
                       @if($auth && $subscribed==1)
                      <a href="{{url('movie/detail',$movie->id)}}">
                        @if($movie->thumbnail != null || $movie->thumbnail != '')
                          <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                        @else
                          <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                        @endif
                      </a>
                      @else
                      <a href="{{url('movie/guest/detail',$movie->id)}}">
                        @if($movie->thumbnail != null || $movie->thumbnail != '')
                          <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                        @else
                          <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                        @endif
                      </a>
                      @endif
                    </div>
                    <div id="prime-genre-movie-description-block{{$movie->id}}" class="prime-description-block">
                      <div class="prime-description-under-block">
                        <h5 class="description-heading">{{$movie->title}}</h5>
                        <div class="movie-rating">{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$movie->rating}}</div>
                        <ul class="description-list">
                          <li>{{$movie->duration}} {{$popover_translations->where('key', 'mins')->first->value['value']}}</li>
                          <li>{{$movie->publish_year}}</li>
                          <li>{{$movie->maturity_rating}}</li>
                          @if($movie->subtitle == 1)
                            <li>
                              {{$popover_translations->where('key', 'subtitles')->first->value['value']}}
                            </li>
                          @endif
                        </ul>
                        <div class="main-des">
                          <p>{{$movie->detail}}</p>
                          <a href="#"></a>
                        </div>
                         @if($catlog==1 && is_null($subscribed))
                        @if($withlogin==0 && $auth)
                          @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('watchTrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @else
                           @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('guestwatchtrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @endif

                          @endif
                          @if($auth && $subscribed==1)
                        <div class="des-btn-block">
                            @if($age>=str_replace('+', '', $movie->maturity_rating))
                           @if($movie->video_link->iframeurl != null)
                          
                            <a onclick="playoniframe('{{ $movie->video_link->iframeurl }}')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                            </a>
                             @else 
                          <a href="{{route('watchmovie',$movie->id)}}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                          @endif
                          @else

                            <a onclick="myage({{$age}})" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                            </a>
                          @endif
                        @if($withlogin==0 && $auth)
                          @if($movie->trailer_url != null || $movie->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('watchTrailer',$movie->id) }}">Watch Trailer</a>
                          @endif
                          @else
                           @if($movie->trailer_url != null || $movie->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('guestwatchtrailer',$movie->id) }}">Watch Trailer</a>
                          @endif
                          @endif

                          @if (isset($wishlist_check->added))
                            <a onclick="addWish({{$movie->id}},'{{$movie->type}}')" class="addwishlistbtn{{$movie->id}}{{$movie->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                          @else
                            <a onclick="addWish({{$movie->id}},'{{$movie->type}}')" class="addwishlistbtn{{$movie->id}}{{$movie->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}</a>
                          @endif
                        </div>
                        @endif
                      </div>
                    </div>
                  </div>
                  @endif
                @endforeach
              </div>
            </div>@endif
          </div>
          @break
          @elseif($s->id==9  && $s->sliderview==0)
             <div class="genre-prime-block">
            @php
              $t7 = DB::table('home_translations')->where('key','=','featured')->first();
                                 $getvs = App\FrontSliderUpdate::where('id',8)->first()->item_show;
                  
                  $orderby = App\FrontSliderUpdate::where('id',8)->first()->orderby;
              
                     if($orderby == 0){
                      $featured_movies = collect($featured_movies)->sortByDesc('id');
                     }
            @endphp
            @if($t7->status==1)
            <div class="container-fluid">
              <h5 class="section-heading">{{$home_translations->where('key', 'featured')->first->value['value']}} {{$home_translations->where('key', 'movies')->first->value['value']}}</h5>
              <div class="">
                @foreach($featured_movies as $key => $movie)
                @if($key<$getvs)
                  @php
                   if(isset($auth)){
                    $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                        ['user_id', '=', $auth->id],
                                                                        ['movie_id', '=', $movie->id],
                                                                       ])->first();
                                                                     }
                  @endphp
                  <div class="col-lg-2 col-md-3 col-xs-6 col-sm-4">
                        <div class="cus_img">    
                      <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-genre-movie-description-block{{$movie->id}}">
                      @if($auth && $subscribed==1)
                      <a href="{{url('movie/detail',$movie->id)}}">
                        @if($movie->thumbnail != null || $movie->thumbnail != '')
                          <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                        @else
                          <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                        @endif
                      </a>
                      @else
                       <a href="{{url('movie/guest/detail',$movie->id)}}">
                        @if($movie->thumbnail != null || $movie->thumbnail != '')
                          <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                        @else
                          <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                        @endif
                      </a>
                      @endif
                    </div>
                    <div id="prime-genre-movie-description-block{{$movie->id}}" class="prime-description-block">
                      <div class="prime-description-under-block">
                        <h5 class="description-heading">{{$movie->title}}</h5>
                        <div class="movie-rating">{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$movie->rating}}</div>
                        <ul class="description-list">
                          <li>{{$movie->duration}} {{$popover_translations->where('key', 'mins')->first->value['value']}}</li>
                          <li>{{$movie->publish_year}}</li>
                          <li>{{$movie->maturity_rating}}</li>
                          @if($movie->subtitle == 1)
                            <li>
                              {{$popover_translations->where('key', 'subtitles')->first->value['value']}}
                            </li>
                          @endif
                        </ul>
                        <div class="main-des">
                          <p>{{$movie->detail}}</p>
                          <a href="#"></a>
                        </div>
                          @if($catlog==1 && is_null($subscribed))
                       @if($withlogin==0 && $auth)
                          @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('watchTrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @else
                           @if($item->trailer_url != null || $item->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('guestwatchtrailer',$item->id) }}">Watch Trailer</a>
                          @endif
                          @endif

                          @endif
                          @if($auth && $subscribed==1)
                        <div class="des-btn-block">
                             @if($age>=str_replace('+', '', $movie->maturity_rating))
                           @if($movie->video_link->iframeurl != null)
                          
                            <a onclick="playoniframe('{{ $movie->video_link->iframeurl }}')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                            </a>
                             @else 
                          <a href="{{route('watchmovie',$movie->id)}}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                          @endif
                          @else
                           <a onclick="myage({{$age}})" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                            </a>
                          @endif
                          @if($withlogin==0 && $auth)
                          @if($movie->trailer_url != null || $movie->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('watchTrailer',$movie->id) }}">Watch Trailer</a>
                          @endif
                          @else
                           @if($movie->trailer_url != null || $movie->trailer_url != '')
                             <a class="iframe btn btn-default" href="{{ route('guestwatchtrailer',$movie->id) }}">Watch Trailer</a>
                          @endif
                          @endif

                          @if (isset($wishlist_check->added))
                            <a onclick="addWish({{$movie->id}},'{{$movie->type}}')" class="addwishlistbtn{{$movie->id}}{{$movie->type}} btn-default">{{$wishlist_check->added == 1 ? ($popover_translations->where('key', 'remove from watchlist')->first->value['value']) : ($popover_translations->where('key', 'add to watchlist')->first->value['value'])}}</a>
                          @else
                            <a onclick="addWish({{$movie->id}},'{{$movie->type}}')" class="addwishlistbtn{{$movie->id}}{{$movie->type}} btn-default">{{$popover_translations->where('key', 'add to watchlist')->first->value['value']}}</a>
                          @endif
                        </div>
                        @endif
                      </div>
                    </div>
                  </div></div>
                  @endif
                @endforeach
              </div>
            </div>@endif
          </div>
          @break
            @endif
          @endforeach
        @endif
        @endif
        @if(isset($featured_seasons) && count($featured_seasons) > 0)
         @if(isset($sliderview))
         @foreach($sliderview as $s)
         @if($s->id==10  && $s->sliderview==1)
          <div class="genre-prime-block">
            @php
              $t8 = DB::table('home_translations')->where('key','=','featured')->first();
                                 $getvs = App\FrontSliderUpdate::where('id',9)->first()->item_show;
                  
                  $orderby = App\FrontSliderUpdate::where('id',9)->first()->orderby;
              
                     if($orderby == 0){
                      $featured_seasons = collect($featured_seasons)->sortByDesc('id');
                     }
            @endphp
            @if($t8->status==1)<div class="container-fluid">
              <h5 class="section-heading">{{$home_translations->where('key', 'featured')->first->value['value']}} {{$home_translations->where('key', 'tv shows')->first->value['value']}}</h5>
              <div class="genre-prime-slider owl-carousel">
                @foreach($featured_seasons as $key => $item)
                @if($key<$getvs)
                  @php
                   if(isset($auth)){
                       $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                        ['user_id', '=', $auth->id],
                                                                        ['season_id', '=', $item->id],
                                                                       ])->first();
                                                                     }
                  @endphp
                  <div class="genre-prime-slide">
                    <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-title="#prime-genre-tvseries-description-block{{$item->id}}{{$item->type}}">
                      @if($auth && $subscribed==1)
                        <a @if(isset($gets1)) href="{{url('show/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                         <a @if(isset($gets1)) href="{{url('show/guest/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif
                    </div>
                    <div id="prime-genre-tvseries-description-block{{$item->id}}{{$item->type}}" class="prime-description-block">
                      <h5 class="description-heading">{{$item->tvseries['title']}}</h5>
                      <div class="movie-rating">{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$item->tvseries['rating']}}</div>
                      <ul class="description-list">
                        <li>{{$popover_translations->where('key', 'season')->first->value['value']}} {{$item->season_no}}</li>
                        <li>{{$item->publish_year}}</li>
                        <li>{{$item->tvseries['age_req']}}</li>
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
                        @if($auth && $subscribed==1)
                      <div class="des-btn-block">
                      @if(isset($item->episodes[0]))
                        @if($age>=str_replace('+', '',$item->tvseries['age_req']))
                         @if($item->episodes[0]->video_link->iframeurl !="")

                              <a href="#" onclick="playoniframe('{{ $item->episodes[0]->video_link->iframeurl }}')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                              </a>
                          @else
                            <a href="{{ route('watchTvShow',$item->id) }}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                          @endif
                          @else
                              <a  onclick="myage({{$age}})" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                              </a>
                          @endif
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
                @endforeach
              </div>
            </div>@endif
          </div>
          @break

          @elseif($s->id==10  && $s->sliderview==0)
          <div class="genre-prime-block">
            @php
              $t8 = DB::table('home_translations')->where('key','=','featured')->first();
                                 $getvs = App\FrontSliderUpdate::where('id',9)->first()->item_show;
                  
                  $orderby = App\FrontSliderUpdate::where('id',9)->first()->orderby;
              
                     if($orderby == 0){
                      $featured_seasons = collect($featured_seasons)->sortByDesc('id');
                     }
            @endphp
            @if($t8->status==1)<div class="container-fluid">
              <h5 class="section-heading">{{$home_translations->where('key', 'featured')->first->value['value']}} {{$home_translations->where('key', 'tv shows')->first->value['value']}}</h5>
              <div class="">
                @foreach($featured_seasons as $key => $item)
                @if($key<$getvs)
                  @php
                   if(isset($auth)){
                       $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                        ['user_id', '=', $auth->id],
                                                                        ['season_id', '=', $item->id],
                                                                       ])->first();
                                                                     }
                  @endphp
                <div class="col-lg-2 col-md-3 col-xs-6 col-sm-4">
                        <div class="cus_img">
                        
                      <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-genre-tvseries-description-block{{$item->id}}{{$item->type}}">
                   
                       @if($auth && $subscribed==1)
                        <a @if(isset($gets1)) href="{{url('show/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                         <a @if(isset($gets1)) href="{{url('show/guest/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif
                    </div>
                    <div id="prime-genre-tvseries-description-block{{$item->id}}{{$item->type}}" class="prime-description-block">
                      <h5 class="description-heading">{{$item->tvseries['title']}}</h5>
                      <div class="movie-rating">{{ $home_translations->where('key', 'TMDB Rating')->first->value['value']}} {{$item->tvseries['rating']}}</div>
                      <ul class="description-list">
                        <li>{{$popover_translations->where('key', 'season')->first->value['value']}} {{$item->season_no}}</li>
                        <li>{{$item->publish_year}}</li>
                        <li>{{$item->tvseries['age_req']}}</li>
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
                        @if($auth && $subscribed==1)
                      <div class="des-btn-block">
                      @if(isset($item->episodes[0]))
                        @if($age>=str_replace('+', '', $item->tvseries['age_req']))
                         @if($item->episodes[0]->video_link->iframeurl !="")

                              <a href="#" onclick="playoniframe('{{ $item->episodes[0]->video_link->iframeurl }}')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                              </a>
                          @else
                            <a href="{{ route('watchTvShow',$item->id) }}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                          @endif
                          @else
                           <a  onclick="myage({{$age}})" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                              </a>
                          @endif
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
               </div>
               @endif
                @endforeach
              </div>
            </div>@endif
          </div>
          @break
           @endif
          @endforeach
        @endif
        @endif
        <!-- google adsense code -->
        <div class="container-fluid" id="adsense">
         <?php
          if (isset($ad) ) {
           if ($ad->ishome==1 && $ad->status==1) {
              $code=  $ad->code;
              echo html_entity_decode($code);
           }
          }
?>
      </div>
      @else
          @if(isset($sliderview))
         @foreach($sliderview as $s)
         @if($s->id==1  && $s->sliderview==1)
         <!-- watch next movies and tv shows -->
        <div class="genre-main-block">
          @php
            $t9 = DB::table('home_translations')->where('key','=','at the big screen at home')->first();
          @endphp
          @if($t9->status==1)<div class="container-fluid">
            <div class="row">
              <div class="col-md-3">
                <div class="genre-dtl-block">
                  <h3 class="section-heading">{{$home_translations->where('key', 'watch next tv series and movies')->first->value['value']}}</h3>
                  <p class="section-dtl">{{$home_translations->where('key', 'at the big screen at home')->first->value['value']}}</p>
                 @if($auth && $subscribed==1)
                    <a href="{{ route('showall',['menuid' => $menu->id, 'menuname' => $menu->name]) }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
                    @else
                     <a href="{{ route('guestshowall',['menuid' => $menu->id, 'menuname' => $menu->name]) }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
                    @endif
                </div>
              </div>
              <div class="col-md-9">
                <div class="genre-main-slider owl-carousel">
                  @if(isset($all_mix))
                    @foreach($all_mix as $key => $item)
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
                      @if($item->type == 'S')
                        <div class="genre-slide">
                          <div class="genre-slide-image">
                             @if($auth && $subscribed==1)
                        <a @if(isset($gets1)) href="{{url('show/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                         <a @if(isset($gets1)) href="{{url('show/guest/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif
                          </div>
                          <div class="genre-slide-dtl">
                    <h5 class="genre-dtl-heading"><a href="{{url('show/detail/'.$item->id)}}">{{$item->tvseries['title']}}</a></h5>
                          </div>
                        </div>
                      @elseif($item->type == 'M')
                        <div class="genre-slide">
                          <div class="genre-slide-image">
                              @if($auth && $subscribed==1)
                            <a href="{{url('movie/detail/'.$item->id)}}">
                              @if($item->thumbnail != null)
                                <img src="{{asset('images/movies/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                              @else
                                <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                              @endif
                            </a>
                            @else
                              <a href="{{url('movie/guest/detail/'.$item->id)}}">
                              @if($item->thumbnail != null)
                                <img src="{{asset('images/movies/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                              @else
                                <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                              @endif
                            </a>
                            @endif
                          </div>
                          <div class="genre-slide-dtl">
                            <h5 class="genre-dtl-heading">
                               @if($auth && $subscribed==1)
                            <a href="{{url('movie/detail/'.$item->id)}}">{{$item->title}}</a>
                            @else
                            <a href="{{url('movie/guest/detail/'.$item->id)}}">{{$item->title}}</a>
                              @endif
                            </h5>
                          </div>
                        </div>
                      @endif
                    @endforeach
                  @endif
                </div>
              </div>
            </div>
          </div>
          @endif

        </div>

        @break
        @elseif($s->id==1  && $s->sliderview==0)
        <div class="genre-main-block">
          @php
            $t9 = DB::table('home_translations')->where('key','=','at the big screen at home')->first();
          @endphp
          @if($t9->status==1)<div class="container-fluid">
            <div class="row">
              <div class="col-md-3">
                <div class="genre-dtl-block">
                  <h3 class="section-heading">{{$home_translations->where('key', 'watch next tv series and movies')->first->value['value']}}</h3>
                  <p class="section-dtl">{{$home_translations->where('key', 'at the big screen at home')->first->value['value']}}</p>
                  @if($auth && $subscribed==1)
                    <a href="{{ route('showall',['menuid' => $menu->id, 'menuname' => $menu->name]) }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
                    @else
                      <a href="{{ route('guestshowall',['menuid' => $menu->id, 'menuname' => $menu->name]) }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
                    @endif
                </div>
              </div>
              <div class="col-md-9">
                <div class="cus_img">
                  @if(isset($all_mix))
                    @foreach($all_mix as $key => $item)
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
                      @if($item->type == 'S')
                        <div class="col-lg-4 col-md-9 col-xs-6 col-sm-6">
                          <div class="genre-slide-image">
                             @if($auth && $subscribed==1)
                        <a @if(isset($gets1)) href="{{url('show/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                         <a @if(isset($gets1)) href="{{url('show/guest/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif
                          </div>
                          <div class="genre-slide-dtl">
                            <h5 class="genre-dtl-heading"><a href="{{url('show/detail/'.$item->id)}}">{{$item->tvseries['title']}}</a></h5>
                          </div>
                        </div>
                      @elseif($item->type == 'M')
                      <div class="col-lg-4 col-md-9 col-xs-6 col-sm-6">
                          <div class="genre-slide-image">
                              @if($auth && $subscribed==1)
                            <a href="{{url('movie/detail/'.$item->id)}}">
                              @if($item->thumbnail != null)
                                <img src="{{asset('images/movies/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                              @else
                                <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                              @endif
                            </a>
                            @else
                             <a href="{{url('movie/guest/detail/'.$item->id)}}">
                              @if($item->thumbnail != null)
                                <img src="{{asset('images/movies/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                              @else
                                <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                              @endif
                            </a>
                            @endif
                          </div>
                          <div class="genre-slide-dtl">
                            <h5 class="genre-dtl-heading">
                               @if($auth && $subscribed==1)
                              <a href="{{url('movie/detail/'.$item->id)}}">{{$item->title}}</a>
                              @else
                              <a href="{{url('movie/guest/detail/'.$item->id)}}">{{$item->title}}</a>

                              @endif
                            </h5>
                          </div>
                        </div>
                      @endif
                    @endforeach
                  @endif
                </div>
              </div>
            </div>
          </div>@endif
        </div>
        @break
        @endif
        @endforeach
        @endif
        <!-- next movies -->
          @if(isset($sliderview))
         @foreach($sliderview as $s)
         @if($s->id==2  && $s->sliderview==1)
        <div class="genre-main-block">
          @php
            $t10 = DB::table('home_translations')->where('key','=','at the big screen at home')->first();
          @endphp
          @if($t10->status==1)<div class="container-fluid">
            <div class="row">
              <div class="col-md-3">
                <div class="genre-dtl-block">
                  <h3 class="section-heading">{{$home_translations->where('key', 'watch next movies')->first->value['value']}}</h3>
                  <p class="section-dtl">{{$home_translations->where('key', 'at the big screen at home')->first->value['value']}}</p>
                    @if($auth && $subscribed==1)
                  <a href="{{ route('showall2') }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
                  @else
                   <a href="{{ route('guestshowall2') }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
                  @endif
                </div>
              </div>
              <div class="col-md-9">
                <div class="genre-main-slider owl-carousel">
                  @if(isset($movies))
                    @foreach($movies as $key => $movie)
                      @php
                       if(isset($auth)){
                          $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                            ['user_id', '=', $auth->id],
                                                                            ['movie_id', '=', $movie->id],
                                                                           ])->first();
                                                                         }
                      @endphp
                      <div class="genre-slide">
                        <div class="genre-slide-image">
                          @if($auth && $subscribed==1)
                          <a href="{{url('movie/detail/'.$movie->id)}}">
                            @if($movie->thumbnail != null)
                              <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                            @else
                              <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                            @endif
                          </a>
                          @else
                           <a href="{{url('movie/guest/detail/'.$movie->id)}}">
                            @if($movie->thumbnail != null)
                              <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                            @else
                              <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                            @endif
                          </a>
                          @endif
                        </div>
                        <div class="genre-slide-dtl">
                          <h5 class="genre-dtl-heading">
                             @if($auth && $subscribed==1)
                            <a href="{{url('movie/detail/'.$movie->id)}}">{{$movie->title}}</a>
                            @else
                          <a href="{{url('movie/guest/detail/'.$movie->id)}}">{{$movie->title}}</a>

                            @endif
                          </h5>
                        </div>
                      </div>
                    @endforeach
                  @endif
                </div>
              </div>
            </div>
          </div>@endif
        </div>

  @break
        @elseif($s->id==2  && $s->sliderview==0)
         <div class="genre-main-block">
          @php
            $t10 = DB::table('home_translations')->where('key','=','at the big screen at home')->first();
          @endphp
          @if($t10->status==1)<div class="container-fluid">
            <div class="row">
              <div class="col-md-3">
                <div class="genre-dtl-block">
                  <h3 class="section-heading">{{$home_translations->where('key', 'watch next movies')->first->value['value']}}</h3>
                  <p class="section-dtl">{{$home_translations->where('key', 'at the big screen at home')->first->value['value']}}</p>
                   @if($auth && $subscribed==1)
                  <a href="{{ route('showall2') }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
                  @else
                   <a href="{{ route('guestshowall2') }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
                  @endif
                </div>
              </div>
              <div class="col-md-9">
                <div class="cus_img">
                  @if(isset($movies))
                    @foreach($movies as $key => $movie)
                      @php if(isset($auth)){
                          $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                            ['user_id', '=', $auth->id],
                                                                            ['movie_id', '=', $movie->id],
                                                                           ])->first();
                                                                         }
                      @endphp
                      <div class="col-lg-3 col-md-9 col-xs-3 col-sm-6">
                        <div class="genre-slide-image">
                           @if($auth && $subscribed==1)
                          <a href="{{url('movie/detail/'.$movie->id)}}">
                            @if($movie->thumbnail != null)
                              <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                            @else
                              <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                            @endif
                          </a>
                          @else
                           <a href="{{url('movie/guest/detail/'.$movie->id)}}">
                            @if($movie->thumbnail != null)
                              <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                            @else
                              <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                            @endif
                          </a>
                          @endif
                        </div>
                        <div class="genre-slide-dtl">
                          <h5 class="genre-dtl-heading">
                             @if($auth && $subscribed==1)
                            <a href="{{url('movie/detail/'.$movie->id)}}">{{$movie->title}}</a>
                            @else
                             <a href="{{url('movie/guest/detail/'.$movie->id)}}">{{$movie->title}}</a>
                            @endif
                          </h5>
                        </div>
                      </div>
                    @endforeach
                  @endif
                </div>
              </div>
            </div>
          </div>@endif
        </div>
       
        @break
        @endif
        @endforeach
        @endif
<!-- next tv shows -->
 @if(isset($sliderview))
         @foreach($sliderview as $s)
         @if($s->id==3  && $s->sliderview==1)
        <div class="genre-main-block">

          @php
            $t11 = DB::table('home_translations')->where('key','=','at the big screen at home')->first();
          @endphp
          @if($t11->status==1)<div class="container-fluid">
            <div class="row">
              <div class="col-md-3">
                <div class="genre-dtl-block">
                  <h3 class="section-heading">{{$home_translations->where('key', 'watch next tv series')->first->value['value']}}</h3>
                  <p class="section-dtl">{{$home_translations->where('key', 'at the big screen at home')->first->value['value']}}</p>
                   @if($auth && $subscribed==1)
                  <a href="{{ route('showall3') }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
                  @else
                   <a href="{{ route('guestshowall3') }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
                  @endif

                </div>
              </div>
              <div class="col-md-9">
                <div class="genre-main-slider owl-carousel">
                  @if(isset($tvserieses))

                    @foreach($tvserieses as $tvseries)
                      @foreach($tvseries->seasons as $item)
                        @php
 if(isset($auth)){
                         $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                          ['user_id', '=', $auth->id],
                                                                          ['season_id', '=', $item->id],
                                                                         ])->first();
                                                                       }
                        @endphp
                        <div class="genre-slide">
                          <div class="genre-slide-image">
                              @if($auth && $subscribed==1)
                        <a @if(isset($gets1)) href="{{url('show/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                         <a @if(isset($gets1)) href="{{url('show/guest/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif
                          </div>
                          <div class="genre-slide-dtl">
                            <h5 class="genre-dtl-heading"><a href="{{url('show/detail/'.$item->id)}}">{{$item->tvseries['title']}}</a></h5>
                          </div>
                        </div>
                      @endforeach
                    @endforeach
                  @endif
                </div>
              </div>
            </div>
          </div>@endif
        </div>
         @break
        @elseif($s->id==3  && $s->sliderview==0)
         <div class="genre-main-block">
          @php
            $t11 = DB::table('home_translations')->where('key','=','at the big screen at home')->first();
          @endphp
          @if($t11->status==1)<div class="container-fluid">
            <div class="row">
              <div class="col-md-3">
                <div class="genre-dtl-block">
                  <h3 class="section-heading">{{$home_translations->where('key', 'watch next tv series')->first->value['value']}}</h3>
                  <p class="section-dtl">{{$home_translations->where('key', 'at the big screen at home')->first->value['value']}}</p>
                     @if($auth && $subscribed==1)
                  <a href="{{ route('showall3') }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
                  @else
                    <a href="{{ route('guestshowall3') }}" class="see-more"> <b>{{$home_translations->where('key', 'view all')->first->value['value']}}</b></a>
                  @endif
                </div>
              </div>
              <div class="col-md-9">
                <div class="cus_img">
                  @if(isset($tvserieses))
                    @foreach($tvserieses as $tvseries)
                      @foreach($tvseries->seasons as $item)
                        @php
                         if(isset($auth)){
                         $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                          ['user_id', '=', $auth->id],
                                                                          ['season_id', '=', $item->id],
                                                                         ])->first();
                                                                       }
                        @endphp
                           <div class="col-lg-3 col-md-9 col-xs-6 col-sm-6">
                          <div class="genre-slide-image">
                            @if($auth && $subscribed==1)
                        <a @if(isset($gets1)) href="{{url('show/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                         <a @if(isset($gets1)) href="{{url('show/guest/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif
                          </div>
                          <div class="genre-slide-dtl">
                            <h5 class="genre-dtl-heading"><a href="{{url('show/detail/'.$item->id)}}">{{$item->tvseries['title']}}</a></h5>
                          </div>
                        </div>
                      @endforeach
                    @endforeach
                  @endif
                </div>
              </div>
            </div>
          </div>@endif
        </div>
       
        @break
        @endif
        @endforeach
        @endif
        <!-- Genre Movies -->
        @if(isset($genres))
          @foreach($genres as $key => $genre)
            @php
              $all_movies = collect();
              $fil_movies = $menu->menu_data;
              foreach ($fil_movies as $key => $value) {
                if ( isset($value->movie) ) {
                  $all_movies->push($value->movie);
                }
              }

              $all_movies = $all_movies->flatten();
              $all_movies =  $all_movies->filter(function($value, $key) {
                return  $value != null;
              });

              $movies = null;
              $movies = collect();
              foreach ($all_movies as $item) {
                if ($item->genre_id != null && $item->genre_id != '') {
                  $movie_genre_list = explode(',', $item->genre_id);
                  for($i = 0; $i < count($movie_genre_list); $i++) {
                    $check = Illuminate\Support\Facades\DB::table('genres')->where('id', '=', trim($movie_genre_list[$i]))->get();
                    if (isset($check[0]) && $check[0]->id == $genre->id) {
                      $movies->push($item);
                    }
                  }
                }
              }
            @endphp
            @if (count($movies) > 0)
            @if(isset($sliderview))
         @foreach($sliderview as $s)
         @if($s->id==5  && $s->sliderview==1)
              <div class="genre-main-block">
                @php
                  $t12 = DB::table('home_translations')->where('key','=','view all')->first();
                @endphp
                @if($t12->status==1)<div class="container-fluid">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="genre-dtl-block">
                        <h3 class="section-heading">{{$genre->name}} {{$home_translations->where('key', 'movies')->first->value['value']}}</h3>
                        <p class="section-dtl">{{$home_translations->where('key', 'at the big screen at home')->first->value['value']}}</p>
                           @if($auth && $subscribed==1)
                        <a href="{{url('movies/genre', $genre->id)}}" class="btn-more">{{$home_translations->where('key', 'view all')->first->value['value']}}</a>
                        @else
                         <a href="{{url('movies/guest/genre', $genre->id)}}" class="btn-more">{{$home_translations->where('key', 'view all')->first->value['value']}}</a>
                        @edif
                      </div>
                    </div>
                    <div class="col-md-9">
                      <div class="genre-main-slider owl-carousel">
                        @if(isset($movies))
                          @foreach($movies as $key => $movie)
                            @php
                             if(isset($auth)){
                                $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                                  ['user_id', '=', $auth->id],
                                                                                  ['movie_id', '=', $item->id],
                                                                                 ])->first();
                                                                               }
                            @endphp
                            <div class="genre-slide">
                              <div class="genre-slide-image">
                                  @if($auth && $subscribed==1)
                                <a href="{{url('movie/detail/'.$movie->id)}}">
                                  @if($movie->thumbnail != null)
                                    <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                                  @else
                                    <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                                  @endif
                                </a>
                                @else
                                  <a href="{{url('movie/guest/detail/'.$movie->id)}}">
                                  @if($movie->thumbnail != null)
                                    <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                                  @else
                                    <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                                  @endif
                                </a>
                                @endif
                              </div>
                              <div class="genre-slide-dtl">
                                <h5 class="genre-dtl-heading">
                                     @if($auth && $subscribed==1)
                                  <a href="{{url('movie/detail/'.$movie->id)}}">{{$movie->title}}
                                  </a>
                                  @else
                                   <a href="{{url('movie/guest/detail/'.$movie->id)}}">{{$movie->title}}
                                  </a>
                                  @endif
                                </h5>
                              </div>
                            </div>
                          @endforeach
                        @endif
                      </div>
                    </div>
                  </div>
                </div>@endif
              </div>
               @break
        @elseif($s->id==5  && $s->sliderview==0)
          <div class="genre-main-block">
                @php
                  $t12 = DB::table('home_translations')->where('key','=','view all')->first();
                @endphp
                @if($t12->status==1)<div class="container-fluid">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="genre-dtl-block">
                        <h3 class="section-heading">{{$genre->name}} {{$home_translations->where('key', 'movies')->first->value['value']}}</h3>
                        <p class="section-dtl">{{$home_translations->where('key', 'at the big screen at home')->first->value['value']}}</p>
                         @if($auth && $subscribed==1)
                        <a href="{{url('movies/genre', $genre->id)}}" class="btn-more">{{$home_translations->where('key', 'view all')->first->value['value']}}</a>
                        @else
                         <a href="{{url('movies/guest/genre', $genre->id)}}" class="btn-more">{{$home_translations->where('key', 'view all')->first->value['value']}}</a>
                        @endif
                      </div>
                    </div>
                    <div class="col-md-9">
                      <div class="cus_img">
                        @if(isset($movies))
                          @foreach($movies as $key => $movie)
                            @php
                             if(isset($auth)){
                                $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                                  ['user_id', '=', $auth->id],
                                                                                  ['movie_id', '=', $item->id],
                                                                                 ])->first();
                                                                               }
                            @endphp
                          <div class="col-lg-3 col-md-9 col-xs-6 col-sm-6">
                              <div class="genre-slide-image">
                                  @if($auth && $subscribed==1)
                                <a href="{{url('movie/detail/'.$movie->id)}}">
                                  @if($movie->thumbnail != null)
                                    <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                                  @else
                                    <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                                  @endif
                                </a>
                                @else
                                   <a href="{{url('movie/guest/detail/'.$movie->id)}}">
                                  @if($movie->thumbnail != null)
                                    <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                                  @else
                                    <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                                  @endif
                                </a>
                                        @endif
                              </div>
                              <div class="genre-slide-dtl">
                                <h5 class="genre-dtl-heading">
                                    @if($auth && $subscribed==1)
                                  <a href="{{url('movie/detail/'.$movie->id)}}">{{$movie->title}}</a>
                                     @else
                                      <a href="{{url('movie/guest/detail/'.$movie->id)}}">{{$movie->title}}</a>
                                        @endif
                                </h5>
                              </div>
                            </div>
                          @endforeach
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
                @endif
              </div>
   
        @break
        @endif
          @endif
        @endforeach
        @endif
            @endif
          @endforeach
        @endif

        <!-- Genre Tv Shows -->
        @if(isset($genres))
          @foreach($genres as $key => $genre)
            @php
              $all_tvseries = collect();
              $fil_tvserieses = $menu->menu_data;
              foreach ($fil_tvserieses as $key => $value) {
                if (isset($value->tvseries)) {
                  $all_tvseries->push($value->tvseries);
                }
              }

              $all_tvseries = $all_tvseries->flatten();
              $all_tvseries =  $all_tvseries->filter(function($value, $key) {
                return  $value != null;
              });

              $seasons = collect();
              foreach ($all_tvseries as $item) {
                if ($item->genre_id != null && $item->genre_id != '') {
                  $tvseries_genre_list = explode(',', $item->genre_id);
                  for($i = 0; $i < count($tvseries_genre_list); $i++) {
                    $check = Illuminate\Support\Facades\DB::table('genres')->where('id', '=', trim($tvseries_genre_list[$i]))->get();
                    if (isset($check[0]) && $check[0]->id == $genre->id) {
                      $seasons->push($item->seasons);
                    }
                  }
                }
              }
              $seasons = $seasons->shuffle()->flatten();
            @endphp
            @if (count($seasons) > 0)
            @if(isset($sliderview))
         @foreach($sliderview as $s)
         @if($s->id==6  && $s->sliderview==1)
              <div class="genre-main-block">
                @php
                  $t13 = DB::table('home_translations')->where('key','=','view all')->first();
                @endphp
                @if($t13->status==1)<div class="container-fluid">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="genre-dtl-block">
                        <h3 class="section-heading">{{$genre->name}} {{$home_translations->where('key', 'tv shows')->first->value['value']}}</h3>
                        <p class="section-dtl">{{$home_translations->where('key', 'at the big screen at home')->first->value['value']}}</p>
                         @if($auth && $subscribed==1)
                        <a href="{{url('tvseries/genre', $genre->id)}}" class="btn-more">{{$home_translations->where('key', 'view all')->first->value['value']}}</a>
                        @else
                           <a href="{{url('tvseries/guest/genre', $genre->id)}}" class="btn-more">{{$home_translations->where('key', 'view all')->first->value['value']}}</a>
                        @endif
                      </div>
                    </div>
                    <div class="col-md-9">
                      <div class="genre-main-slider owl-carousel">
                        @if(isset($seasons))
                          @foreach($seasons as $item)
                            @php
                             if(isset($auth)){
                             $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                              ['user_id', '=', $auth->id],
                                                                              ['season_id', '=', $item->id],
                                                                             ])->first();
                                                                           }
                            @endphp
                            <div class="genre-slide">
                              <div class="genre-slide-image">
                                 @if($auth && $subscribed==1)
                        <a @if(isset($gets1)) href="{{url('show/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                         <a @if(isset($gets1)) href="{{url('show/guest/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif
                              </div>
                              <div class="genre-slide-dtl">
                                <h5 class="genre-dtl-heading"><a href="{{url('show/detail/'.$item->id)}}">{{$item->tvseries['title']}}</a></h5>
                              </div>
                            </div>
                          @endforeach
                        @endif
                      </div>
                    </div>
                  </div>
                </div>@endif
              </div>
               @break

               @elseif($s->id==6  && $s->sliderview==0)
                <div class="genre-main-block">
                @php
                  $t13 = DB::table('home_translations')->where('key','=','view all')->first();
                @endphp
                @if($t13->status==1)<div class="container-fluid">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="genre-dtl-block">
                        <h3 class="section-heading">{{$genre->name}} {{$home_translations->where('key', 'tv shows')->first->value['value']}}</h3>
                        <p class="section-dtl">{{$home_translations->where('key', 'at the big screen at home')->first->value['value']}}</p>
                          @if($auth && $subscribed==1)
                        <a href="{{url('tvseries/genre', $genre->id)}}" class="btn-more">{{$home_translations->where('key', 'view all')->first->value['value']}}</a>
                        @else
                         <a href="{{url('tvseries/guest/genre', $genre->id)}}" class="btn-more">{{$home_translations->where('key', 'view all')->first->value['value']}}</a>
                        @endif
                      </div>
                    </div>
                    <div class="col-md-9">
                      <div class="cus_img">
                        @if(isset($seasons))
                          @foreach($seasons as $item)
                            @php
                             if(isset($auth)){
                             $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                              ['user_id', '=', $auth->id],
                                                                              ['season_id', '=', $item->id],
                                                                             ])->first();
                                                                           }
                            @endphp
                            <div class="col-lg-3 col-md-9 col-xs-6 col-sm-6">
                              <div class="genre-slide-image">
                                @if($auth && $subscribed==1)
                        <a @if(isset($gets1)) href="{{url('show/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                         <a @if(isset($gets1)) href="{{url('show/guest/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif
                              </div>
                              <div class="genre-slide-dtl">
                                <h5 class="genre-dtl-heading"><a href="{{url('show/detail/'.$item->id)}}">{{$item->tvseries['title']}}</a></h5>
                              </div>
                            </div>
                          @endforeach
                        @endif
                      </div>
                    </div>
                  </div>
                </div>@endif
              </div>
              
               @break
        @endif
        @endforeach
        @endif
            @endif
          @endforeach
        @endif

        <!-- Language Movies -->
        @if(isset($a_languages))
          @foreach($a_languages as $key => $lang)
            @php
              $all_movies = collect();
              $fil_movies = $menu->menu_data;
              foreach ($fil_movies as $key => $value) {
                if (isset($value->movie)) {
                  $all_movies->push($value->movie);
                }
              }

              $all_movies = $all_movies->flatten();
              $all_movies =  $all_movies->filter(function($value, $key) {
                return  $value != null;
              });

              $movies = null;
              $movies = collect();
              foreach ($all_movies as $item) {
                if ($item->a_language != null && $item->a_language != '') {
                  $movie_lang_list = explode(',', $item->a_language);
                  for($i = 0; $i < count($movie_lang_list); $i++) {
                    $check = \App\AudioLanguage::find(trim($movie_lang_list[$i]));
                    if (isset($check) && $check->id == $lang->id) {
                      $movies->push($item);
                    }
                  }
                }
              }
            @endphp
            @if (count($movies) > 0)
              @if(isset($sliderview))
         @foreach($sliderview as $s)
         @if($s->id==7  && $s->sliderview==1)
              <div class="genre-main-block">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="genre-dtl-block">
                        <h3 class="section-heading">{{$home_translations->where('key', 'movies in')->first->value['value']}} {{$lang->language}}</h3>
                        <p class="section-dtl">{{$home_translations->where('key', 'at the big screen at home')->first->value['value']}}</p>
                          @if($auth && $subscribed==1)
                        <a href="{{url('movies/language', $lang->id)}}" class="btn-more">{{$home_translations->where('key', 'view all')->first->value['value']}}</a>
                        @else
                         <a href="{{url('movies/guest/language', $lang->id)}}" class="btn-more">{{$home_translations->where('key', 'view all')->first->value['value']}}</a>
                        @endif
                      </div>
                    </div>
                    <div class="col-md-9">
                      <div class="genre-main-slider owl-carousel">
                        @if(isset($movies))
                          @foreach($movies as $key => $movie)
                            @php
                             if(isset($auth)){
                                $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                                  ['user_id', '=', $auth->id],
                                                                                  ['movie_id', '=', $item->id],
                                                                                 ])->first();
                                                                               }
                            @endphp
                            <div class="genre-slide">
                              <div class="genre-slide-image">
                                  @if($auth && $subscribed==1)
                                <a href="{{url('movie/detail/'.$movie->id)}}">
                                  @if($movie->thumbnail != null)
                                    <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                                  @else
                                    <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                                  @endif
                                </a>
                                @else 
                                 <a href="{{url('movie/guest/detail/'.$movie->id)}}">
                                  @if($movie->thumbnail != null)
                                    <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                                  @else
                                    <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                                  @endif
                                </a>
                                @endif
                              </div>
                              <div class="genre-slide-dtl">
                                <h5 class="genre-dtl-heading">
                                    @if($auth && $subscribed==1)
                                  <a href="{{url('movie/detail/'.$movie->id)}}">{{$movie->title}}</a>
                                @else
                                <a href="{{url('movie/guest/detail/'.$movie->id)}}">{{$movie->title}}</a>
                              @endif
                            </h5>
                              </div>
                            </div>
                          @endforeach
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>
               @break
               @elseif($s->id==7  && $s->sliderview==0)
                   <div class="genre-main-block">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="genre-dtl-block">
                        <h3 class="section-heading">{{$home_translations->where('key', 'movies in')->first->value['value']}} {{$lang->language}}</h3>
                        <p class="section-dtl">{{$home_translations->where('key', 'at the big screen at home')->first->value['value']}}</p>
                        @if($auth && $subscribed==1)
                        <a href="{{url('movies/language', $lang->id)}}" class="btn-more">{{$home_translations->where('key', 'view all')->first->value['value']}}</a>
                        @else
                          <a href="{{url('movies/guest/language', $lang->id)}}" class="btn-more">{{$home_translations->where('key', 'view all')->first->value['value']}}</a>
                        @endif
                      </div>
                    </div>
                    <div class="col-md-9">
                      <div class="cus_img">
                        @if(isset($movies))
                          @foreach($movies as $key => $movie)
                            @php
                             if(isset($auth)){
                                $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                                  ['user_id', '=', $auth->id],
                                                                                  ['movie_id', '=', $item->id],
                                                                                 ])->first();
                                                                               }
                            @endphp
                             <div class="col-lg-3 col-md-9 col-xs-6 col-sm-6">
                              <div class="genre-slide-image">
                                 @if($auth && $subscribed==1)
                                <a href="{{url('movie/detail/'.$movie->id)}}">
                                  @if($movie->thumbnail != null)
                                    <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                                  @else
                                    <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                                  @endif
                                </a>
                                @else
                                  <a href="{{url('movie/guest/detail/'.$movie->id)}}">
                                  @if($movie->thumbnail != null)
                                    <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                                  @else
                                    <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                                  @endif
                                </a>
                                @endif
                              </div>
                              <div class="genre-slide-dtl">
                                <h5 class="genre-dtl-heading">
                                   @if($auth && $subscribed==1)
                                  <a href="{{url('movie/detail/'.$movie->id)}}">{{$movie->title}}</a>
                                @else
                                 <a href="{{url('movie/guest/detail/'.$movie->id)}}">{{$movie->title}}</a>
                              @endif
                            </h5>
                              </div>
                            </div>
                          @endforeach
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>
               
               @break
        @endif
        @endforeach
        @endif
            @endif
          @endforeach
        @endif
        <!-- Language TV Shows -->
        @if(isset($a_languages))
          @foreach($a_languages as $key => $lang)
            @php
              $all_tvseries = collect();
              $fil_tvserieses = $menu->menu_data;
              foreach ($fil_tvserieses as $key => $value) {
                if (isset($value->tvseries)) {
                  $all_tvseries->push($value->tvseries);
                }
              }

              $all_tvseries = $all_tvseries->flatten();
              $all_tvseries =  $all_tvseries->filter(function($value, $key) {
                return  $value != null;
              });

              $all_seasons = null;
              $all_seasons = collect();

              foreach ($all_tvseries as $tv) {
                if ( isset($tv->seasons) && count($tv->seasons) > 0 ) {
                  $all_seasons->push($tv->seasons);
                }
              }
              $all_seasons = $all_seasons->flatten();
              $all_seasons =  $all_seasons->filter(function($value, $key) {
                return  $value != null;
              });

              $seasons = null;
              $seasons = collect();
              foreach ($all_seasons as $item) {
                if ($item->a_language != null && $item->a_language != '') {
                  $season_lang_list = explode(',', $item->a_language);
                  for($i = 0; $i < count($season_lang_list); $i++) {
                    $check = \App\AudioLanguage::find(trim($season_lang_list[$i]));
                    if (isset($check) && $check->id == $lang->id) {
                      $seasons->push($item);
                    }
                  }
                }
              }
              $seasons = $seasons->flatten();
            @endphp
            @if (count($seasons) > 0)
               @if(isset($sliderview))
         @foreach($sliderview as $s)
         @if($s->id==8  && $s->sliderview==1)
              <div class="genre-main-block">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="genre-dtl-block">
                        <h3 class="section-heading">{{$home_translations->where('key', 'tv shows in')->first->value['value']}} {{$lang->language}}</h3>
                        <p class="section-dtl">{{$home_translations->where('key', 'at the big screen at home')->first->value['value']}}</p>
                          @if($auth && $subscribed==1)
                        <a href="{{url('tvseries/language', $lang->id)}}" class="btn-more">{{$home_translations->where('key', 'view all')->first->value['value']}}</a>
                        @else
                         <a href="{{url('tvseries/guest/language', $lang->id)}}" class="btn-more">{{$home_translations->where('key', 'view all')->first->value['value']}}</a>
                        @endif
                      </div>
                    </div>
                    <div class="col-md-9">
                      <div class="genre-main-slider owl-carousel">
                        @if(isset($seasons))
                          @foreach($seasons as $item)
                            @php
                             if(isset($auth)){
                             $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                              ['user_id', '=', $auth->id],
                                                                              ['season_id', '=', $item->id],
                                                                             ])->first();
                                                                           }
                            @endphp
                            <div class="genre-slide">
                              <div class="genre-slide-image">
                                @if($auth && $subscribed==1)
                        <a @if(isset($gets1)) href="{{url('show/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                         <a @if(isset($gets1)) href="{{url('show/guest/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif
                              </div>
                              <div class="genre-slide-dtl">
                                <h5 class="genre-dtl-heading"><a href="{{url('show/detail/'.$item->id)}}">{{$item->tvseries['title']}}</a></h5>
                              </div>
                            </div>
                          @endforeach
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>
               @break
               @elseif($s->id==8  && $s->sliderview==0)
                  <div class="genre-main-block">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="genre-dtl-block">
                        <h3 class="section-heading">{{$home_translations->where('key', 'tv shows in')->first->value['value']}} {{$lang->language}}</h3>
                        <p class="section-dtl">{{$home_translations->where('key', 'at the big screen at home')->first->value['value']}}</p>
                         @if($auth && $subscribed==1)
                        <a href="{{url('tvseries/language', $lang->id)}}" class="btn-more">{{$home_translations->where('key', 'view all')->first->value['value']}}</a>
                        @else
                          <a href="{{url('tvseries/guest/language', $lang->id)}}" class="btn-more">{{$home_translations->where('key', 'view all')->first->value['value']}}</a>
                        @endif
                      </div>
                    </div>
                    <div class="col-md-9">
                      <div class="cus_img">
                        @if(isset($seasons))
                          @foreach($seasons as $item)
                            @php
                             if(isset($auth)){
                             $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                              ['user_id', '=', $auth->id],
                                                                              ['season_id', '=', $item->id],
                                                                             ])->first();
                                                                           }
                            @endphp
                            <div class="col-lg-3 col-md-9 col-xs-6 col-sm-6">
                              <div class="genre-slide-image">
                                 @if($auth && $subscribed==1)
                        <a @if(isset($gets1)) href="{{url('show/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                         <a @if(isset($gets1)) href="{{url('show/guest/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif
                              </div>
                              <div class="genre-slide-dtl">
                                <h5 class="genre-dtl-heading"><a href="{{url('show/detail/'.$item->id)}}">{{$item->tvseries['title']}}</a></h5>
                              </div>
                            </div>
                          @endforeach
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>
               
               @break
        @endif
        @endforeach
        @endif
            @endif
          @endforeach
        @endif
        <!-- Featured Movies -->
        @if(isset($featured_movies) && count($featured_movies) > 0)
           @if(isset($sliderview))
         @foreach($sliderview as $s)
         @if($s->id==9  && $s->sliderview==1)
          <div class="genre-main-block">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-3">
                  <div class="genre-dtl-block">
                    <h3 class="section-heading">{{$home_translations->where('key', 'featured')->first->value['value']}} {{$home_translations->where('key', 'movies')->first->value['value']}}</h3>
                    <p class="section-dtl">{{$home_translations->where('key', 'at the big screen at home')->first->value['value']}}</p>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="genre-main-slider owl-carousel">
                    @foreach($featured_movies as $key => $movie)
                      @php
                       if(isset($auth)){
                          $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                            ['user_id', '=', $auth->id],
                                                                            ['movie_id', '=', $item->id],
                                                                           ])->first();
                                                                         }
                      @endphp
                      <div class="genre-slide">
                        <div class="genre-slide-image">
                            @if($auth && $subscribed==1)
                          <a href="{{url('movie/detail/'.$movie->id)}}">
                            @if($movie->thumbnail != null)
                              <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                            @else
                              <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                            @endif
                          </a>
                          @else
                           <a href="{{url('movie/guest/detail/'.$movie->id)}}">
                            @if($movie->thumbnail != null)
                              <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                            @else
                              <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                            @endif
                          </a>
                          @endif
                        </div>
                        <div class="genre-slide-dtl">
                          <h5 class="genre-dtl-heading">
                              @if($auth && $subscribed==1)
                              <a href="{{url('movie/detail/'.$movie->id)}}">{{$movie->title}}</a>

                              @else
                              <a href="{{url('movie/guest/detail/'.$movie->id)}}">{{$movie->title}}</a>
                              @endif
                               </h5>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
              @break
               @elseif($s->id==9  && $s->sliderview==0)
                <div class="genre-main-block">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-3">
                  <div class="genre-dtl-block">
                    <h3 class="section-heading">{{$home_translations->where('key', 'featured')->first->value['value']}} {{$home_translations->where('key', 'movies')->first->value['value']}}</h3>
                    <p class="section-dtl">{{$home_translations->where('key', 'at the big screen at home')->first->value['value']}}</p>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="cus_img">
                    @foreach($featured_movies as $key => $movie)
                      @php
                       if(isset($auth)){
                          $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                            ['user_id', '=', $auth->id],
                                                                            ['movie_id', '=', $item->id],
                                                                           ])->first();
                                                                         }
                      @endphp
                    <div class="col-lg-3 col-md-9 col-xs-6 col-sm-6">
                        
                          
                        <div class="genre-slide-image">
                           @if($auth && $subscribed==1)
                          <a href="{{url('movie/detail/'.$movie->id)}}">
                            @if($movie->thumbnail != null)
                              <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                            @else
                              <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                            @endif
                          </a>
                          @else
                           <a href="{{url('movie/guest/detail/'.$movie->id)}}">
                            @if($movie->thumbnail != null)
                              <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                            @else
                              <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                            @endif
                          </a>
                          @endif
                        </div>
                        <div class="genre-slide-dtl">
                          <h5 class="genre-dtl-heading">
                             @if($auth && $subscribed==1)

                            <a href="{{url('movie/detail/'.$movie->id)}}">{{$movie->title}}</a>
                            @else
                            <a href="{{url('movie/guest/detail/'.$movie->id)}}">{{$movie->title}}</a>
                            @endif
                          </h5>
                        </div>
                     </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
               @break
        @endif
        @endforeach
        @endif
        @endif
        <!-- Featured Tv Shows -->
        @if(isset($featured_seasons) && count($featured_seasons) > 0)
          @if(isset($sliderview))
         @foreach($sliderview as $s)
         @if($s->id==10  && $s->sliderview==1)
          <div class="genre-main-block">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-3">
                  <div class="genre-dtl-block">
                    <h3 class="section-heading">{{$home_translations->where('key', 'featured')->first->value['value']}} {{$home_translations->where('key', 'tv shows')->first->value['value']}}</h3>
                    <p class="section-dtl">{{$home_translations->where('key', 'at the big screen at home')->first->value['value']}}</p>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="genre-main-slider owl-carousel">
                    @foreach($featured_seasons as $item)
                      @php
                       if(isset($auth)){
                       $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                        ['user_id', '=', $auth->id],
                                                                        ['season_id', '=', $item->id],
                                                                       ])->first();
                                                                     }
                      @endphp
                      <div class="genre-slide">
                        <div class="genre-slide-image">
                           @if($auth && $subscribed==1)
                        <a @if(isset($gets1)) href="{{url('show/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                         <a @if(isset($gets1)) href="{{url('show/guest/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif
                        </div>
                        <div class="genre-slide-dtl">
                          <h5 class="genre-dtl-heading"><a href="{{url('show/detail/'.$item->id)}}">{{$item->tvseries['title']}}</a></h5>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
           @break
               @elseif($s->id==10  && $s->sliderview==0)
                 <div class="genre-main-block">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-3">
                  <div class="genre-dtl-block">
                    <h3 class="section-heading">{{$home_translations->where('key', 'featured')->first->value['value']}} {{$home_translations->where('key', 'tv shows')->first->value['value']}}</h3>
                    <p class="section-dtl">{{$home_translations->where('key', 'at the big screen at home')->first->value['value']}}</p>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="cus_img">
                    @foreach($featured_seasons as $item)
                      @php
                       if(isset($auth)){
                       $wishlist_check = \Illuminate\Support\Facades\DB::table('wishlists')->where([
                                                                        ['user_id', '=', $auth->id],
                                                                        ['season_id', '=', $item->id],
                                                                       ])->first();
                                                                     }
                      @endphp
                      <div class="col-lg-3 col-md-9 col-xs-6 col-sm-6">
                        <div class="genre-slide-image">
                           @if($auth && $subscribed==1)
                        <a @if(isset($gets1)) href="{{url('show/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @else
                         <a @if(isset($gets1)) href="{{url('show/guest/detail',$gets1->id)}}" @endif>
                          @if($item->thumbnail != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @elseif($item->tvseries['thumbnail'] != null)
                            <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                          @else
                            <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                          @endif
                        </a>
                        @endif
                        </div>
                        <div class="genre-slide-dtl">
                          <h5 class="genre-dtl-heading"><a href="{{url('show/detail/'.$item->id)}}">{{$item->tvseries['title']}}</a></h5>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
               @break
        @endif
        @endforeach
        @endif
        @endif
        </div>
     <!-- google adsense code -->
        <div class="container-fluid" id="adsense">
         <?php
          if (isset($ad) ) {
           if ($ad->ishome==1 && $ad->status==1) {
              $code=  $ad->code;
              echo html_entity_decode($code);
           }
          }
?>
      </div>
      @endif

  </section>


  



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

      function playoniframe(url){
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

  <script>

      function playoniframe(url){
        $.colorbox({ href: url, width: '100%', height: '100%', iframe: true });
      }
      
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
  
@endsection
