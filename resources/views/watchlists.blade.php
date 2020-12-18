@extends('layouts.theme')
@section('title',"Your Watchlist")
@section('main-wrapper')
  <!-- main wrapper -->
  <section class="main-wrapper">
    <div class="container-fluid">
      <div class="watchlist-section">
        <h5 class="watchlist-heading">{{$header_translations->where('key', 'watchlist')->first->value['value']}}</h5>
        <div class="watchlist-btn-block">
          <div class="btn-group">
            @php
               $auth=Auth::user();
               if(isset($auth) || $auth->is_admin){
               $nav=App\Menu::all();
             }
            @endphp
              @if (isset($nav))
                 
                  @foreach ($nav as $menu)
                 
                    <a class="{{isset($menu) ? 'active' : ''}}" href="{{url('account/watchlist', $menu->slug)}}"  title="{{$menu->name}}">{{$menu->name}}</a>
                    
                  @endforeach
              
              @endif
            
          </div>
        </div>
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
        <h5 style="color: #c0392b">Sorry! This is Age Restricted Video. You are Not Allowed to Watch</h5>
      </div>
      </div>
      <div class="modal-footer">
       
      </div>
     {!! Form::close() !!}
    </div>

  </div>
</div>
        @if(isset($movies))
          <div class="watchlist-main-block">
            @foreach($movies as $key => $item)
              @if($item->type=='S')
              @if($item->tvseries['status'] == 1)
              <div class="watchlist-block">
                <div class="watchlist-img-block protip" data-pt-placement="outside" data-pt-title="#prime-show-description-block{{$item->id}}">
                  <a href="{{url('show/detail',$item->id)}}">
                    @if($item->thumbnail != null)
                      <img src="{{asset('images/tvseries/thumbnails/'.$item->thumbnail)}}" class="img-responsive" alt="genre-image">
                    @elseif($item->tvseries['thumbnail'] != null)
                      <img src="{{asset('images/tvseries/thumbnails/'.$item->tvseries->thumbnail)}}" class="img-responsive" alt="genre-image">
                    @else
                      <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                    @endif
                  </a>
                </div>
                {!! Form::open(['method' => 'DELETE', 'action' => ['WishListController@showdestroy', $item->id]]) !!}
                  {!! Form::submit("Remove", ["class" => "remove-btn"]) !!}
                {!! Form::close() !!}
                <div id="prime-show-description-block{{$item->id}}" class="prime-description-block">
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
                      <p>{{$item->tvseries['detail']}}</p>
                    @endif
                    <a href="#"></a>
                  </div>
                  <div class="des-btn-block">
                    
                          @if(isset($item->episodes[0]))
                             @if($item->tvseries['age_req'] == 'all age' || $age>=str_replace('+', '', $item->tvseries['age_req']))
                            @if($item->episodes[0]->video_link['iframeurl'] !="")

                               <a href="#" onclick="playoniframe('{{ $item->episodes[0]->video_link['iframeurl'] }}','{{ $item->tvseries['id'] }}','tv')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                             </a>

                            @else
                              <a href="{{ route('watchTvShow',$item->id) }}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                            @endif
                      @else

                            <a onclick="myage({{$age}})" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                             </a>
                      @endif
                      @endif
                  </div>
                </div>
              </div>
              @endif
              @endif
            @endforeach
          </div>
        @endif
      
        
        @if(isset($movies))
          <div class="watchlist-main-block">
            @foreach($movies as $key => $movie)
             @if($movie->type=="M")
             @if($movie->status == 1)
              <div class="watchlist-block">
                <div class="watchlist-img-block protip" data-pt-placement="outside" data-pt-title="#prime-description-block{{$movie->id}}">
                  <a href="{{url('movie/detail',$movie->id)}}">
                    @if($movie->thumbnail != null || $movie->thumbnail != '')
                      <img src="{{asset('images/movies/thumbnails/'.$movie->thumbnail)}}" class="img-responsive" alt="genre-image">
                    @else
                      <img src="{{asset('images/default-thumbnail.jpg')}}" class="img-responsive" alt="genre-image">
                    @endif
                  </a>
                </div>
                {!! Form::open(['method' => 'DELETE', 'action' => ['WishListController@moviedestroy', $movie->id]]) !!}
                    {!! Form::submit("Remove", ["class" => "remove-btn"]) !!}
                {!! Form::close() !!}
                <div id="prime-description-block{{$movie->id}}" class="prime-description-block">
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
                    <div class="des-btn-block">
                      @if( $auth)
                           @if($movie->maturity_rating == 'all age' || $age>=str_replace('+', '', $movie->maturity_rating))
                       @if($movie->video_link['iframeurl'] != null)
                          
                              <a onclick="playoniframe('{{ $movie->video_link['iframeurl'] }}','{{ $movie->id }}','movie')" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                              </a>

                             @else 
                      <a href="{{ route('watchmovie',$movie->id) }}" class="iframe btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span></a>
                       @endif
                        @else
                            <a onclick="myage({{$age}})" class="btn btn-play"><span class="play-btn-icon"><i class="fa fa-play"></i></span> <span class="play-text">{{$popover_translations->where('key', 'play')->first->value['value']}}</span>
                              </a>

                       @endif
                      @if($movie->trailer_url != null || $movie->trailer_url != '')
                       <a href="{{ route('watchTrailer',$movie->id) }}" class="iframe btn btn-default">{{$popover_translations->where('key', 'watch trailer')->first->value['value']}}</a>

                      

                      @endif
                      @else
                         @if($movie->trailer_url != null || $movie->trailer_url != '')
                       <a href="{{ route('guestwatchtrailer',$movie->id) }}" class="iframe btn btn-default">{{$popover_translations->where('key', 'watch trailer')->first->value['value']}}</a>

                      

                      @endif
                      @endif

                    </div>
                  </div>
                </div>
              </div>
              @endif
               @endif
            @endforeach
          </div>
        @endif
        
      </div>
      
    </div>
      <!-- google adsense code -->
        <div class="container-fluid">
         <?php
          if (isset($ad)) {
           if ($ad->iswishlist==1 && $ad->status==1) {
              $code=  $ad->code;
              echo html_entity_decode($code);
           }
          }
?>
      </div>
  </section>


  <!--End-->
 
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

      function myage(age){
        if (age==0) {
        $('#ageModal').modal('show'); 
      }else{
          $('#ageWarningModal').modal('show');
      }
    }
      
    </script>
@endsection
