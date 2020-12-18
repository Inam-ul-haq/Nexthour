@extends('layouts.theme')

@if(isset($blogdetail))
  @section('title',"$blogdetail->title")
@endif
@section('main-wrapper')
 <section class="main-wrapper">
    <div class="container">
        @php
          $uname=App\User::where('id',$blogdetail->user_id)->get();
          foreach($uname as $name)
          {
            $user_name = $name->name;
          }

          @endphp
        <div class="plan-block-dtl">
          <h3 class="plan-dtl-heading" style="color:white;">{{$blogdetail->title}}</h3>
          <span style="color:white;"><i class="fa fa-clock-o"></i>&nbsp;{{date ('d.m.Y',strtotime($blogdetail->created_at))}}&emsp;<i class="fa fa-user" style="color:white;"></i>&nbsp;{{$user_name}}</span>
        </div>

        <div class="col-md-12">
              <div class="col-sm-12 plan-title">
                 <img src="{{ asset('images/blog/'.$blogdetail->image) }}" class="img-responsive" alt="image">
              </div><br/>
              <div class=" col-sm-12 main-plan-section">
                   <p class="blog" style="font-size:16px;">{!! $blogdetail->detail !!}</p>
               
              </div>

              <div>
                @php
                  $like=App\Like::orderBy('created_at','desc')->where('added','1')->where('blog_id',$blogdetail->id)->count();
                   $unlike=App\Like::orderBy('created_at','desc')->where('added','-1')->where('blog_id',$blogdetail->id)->count();
                 
                  @endphp
                <a  id="{{$blogdetail->id}}"  class="col-sm-2 like_list"><i class="fa fa-thumbs-o-up" style="font-size:22px;"> {{$like}}</i></a> 
                <a data-id="{{$blogdetail->id}}"  class="col-sm-2 unlike"><i class="fa fa-thumbs-o-down" style="font-size:22px;"> {{$unlike}}</i></a>
                <br/>
              </div>
         </div>
   </div><br/>
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
      <h4 class="title" style="color:#B1B1B1;"><span class="glyphicon glyphicon-comment"></span> {{$blogdetail->comments->count()}} Comments </h4> <br/>
         
          @foreach ($blogdetail->comments as $comment)

              <div class="comment">
                <div class="author-info">
                  <img src="{{"https://www.gravatar.com/avatar/" . md5(strtolower(trim($comment->name))). "?s=50&d=monsterid" }}" class="author-image">
                  <div class="author-name">
                    <h4>{{ucfirst($comment->name)}}</h4>
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
                    <br/>
                    <div id="{{$comment->id}}deleteModal" class="delete-modal modal fade" role="dialog">
                      <div class="modal-dialog modal-md" style="margin-top:70px;">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                             
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <div class="delete-icon"></div>
                           <h4 style="color:#B1B1B1;"> Reply for {{$comment->name}}</h4>
                          </div>
                          <div class="modal-body text-center">
                             
                              <form action="{{route('comment.reply', ['cid' =>$comment->id,'bid'=> $blogdetail->id])}}" method ="POST">
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
                      <h5>{{ucfirst($name->name)}}</h5>
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
                {{Form::open( ['route' => ['comment.store', $blogdetail->id], 'method' => 'POST'])}}
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
 </section>
 <script>
$(document).ready(function() {
    $(".like_list").click(function() {
    var item = $(this).attr('id');
    
    $.ajax({
      url: '{{route('addtolike')}}',
      type: 'GET',
      data: { item: item},
      success:function(data){ 
        //console.log(data);
        if(data == 'exist'){
          swal({
            title:"Oops !",
            text: "This post is already liked",
            icon:'warning'
          });
          //sweetalert("Oops ..... ", "This Post is Already Liked");
          console.log('Already liked');
        }else{
            swal({
            title:"Success !",
            text: "Post Liked successfully!",
            icon:'success'
          });
        }
       
      }
    
    });
  });

    $(".unlike").click(function() {
    var item = $(this).attr('data-id');
    //alert(item);
    $.ajax({
      url: '{{route('unlike')}}',
      type: 'GET',
      data: { item: item},

      success:function(data){ 
        if(data == 'exist'){
          swal({
            title:"Oops !",
            text: "This post is already unliked",
            icon:'warning'
          });
          //sweetalert("Oops ..... ", "This Post is Already Liked");
          console.log('Already liked');
        }else{
            swal({
            title:"Success !",
            text: "Post UnLiked successfully!",
            icon:'success'
          });
        }
       
      }
    
    });
  });


});

</script>

 @endsection