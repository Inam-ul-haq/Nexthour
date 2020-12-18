@extends('layouts.admin')
@section('title','Edit Post')
@section('content')
  <div class="admin-form-main-block mrg-t-40">
     <h4 class="admin-form-text"><a href="{{url('admin/blog')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Edit Post</h4> 
    {!! Form::model($blog, ['method' => 'PATCH', 'action' => ['BlogController@update', $blog->id], 'files' => true]) !!}
    <div class="row">
      <div class="col-md-10">
          <div class="row admin-form-block z-depth-1">
        <div class="col-md-6">
          <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
              {!! Form::label('title', 'Blog Title') !!} - <p class="inline info">Enter Blog name</p>
              {!! Form::text('title', null, ['class' => 'form-control','autocomplete'=>'off','required']) !!}
              <small class="text-danger">{{ $errors->first('title') }}</small>
          </div> 
          
          <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }} input-file-block">
            {!! Form::label('image', 'Image') !!} 
            {!! Form::file('image', ['class' => 'input-file', 'id'=>'image']) !!}
            <label for="image" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Product Image">
              <i class="icon fa fa-check"></i>
              <span class="js-fileName">Choose a File</span>
            </label>
            <p class="info">Choose custom image</p>
            <small class="text-danger">{{ $errors->first('image') }}</small>
          </div> 
           <div class=" form-group{{ $errors->has('detail') ? ' has-error' : '' }}">
                {!! Form::label('detail', 'Description*') !!} - <p class="inline info">Please enter Blog description</p>
                {!! Form::textarea('detail', null, ['id' => 'detail','autocomplete'=>'off', 'class' => 'form-control ckeditor', '']) !!}
                <small class="text-danger">{{ $errors->first('detail') }}</small>
            </div>

            <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }} switch-main-block">
            <div class="row">
              <div class="col-xs-4">
                {!! Form::label('is_active', 'Status') !!}
              </div>
              <div class="col-xs-5 pad-0">
                <label class="switch">                
                  {!! Form::checkbox('is_active', null, null, ['class' => 'checkbox-switch']) !!}
                  <span class="slider round"></span>
                </label>
              </div>
            </div>
            <div class="col-xs-12">
              <small class="text-danger">{{ $errors->first('is_active') }}</small>
            </div>
          </div>     
                   
          <div class="btn-group pull-right">
              <button type="submit" class="btn btn-success">Update</button>
          </div>
          <div class="clear-both"></div>
        </div>  
    
    {!! Form::close() !!}
  </div>
        </div>
    </div>
  </div>
@endsection

@section('custom-script')
	<script>
		$(document).ready(function(){
      $('.upload-image-main-block').hide();
      $('.for-custom-image input').click(function(){
        if($(this).prop("checked") == true){
          $('.upload-image-main-block').fadeIn();
        }
        else if($(this).prop("checked") == false){
          $('.upload-image-main-block').fadeOut();
        }
      });
    });
	</script>
 
@endsection