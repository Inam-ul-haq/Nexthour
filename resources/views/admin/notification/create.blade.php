@extends('layouts.admin')
@section('title','Create Notification')
@section('content')
  <div class="admin-form-main-block mrg-t-40">
    <h4 class="admin-form-text"><a href="{{url('admin')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Create Notification</h4>
    <div class="row">
      <div class="col-md-6">
        <div class="admin-form-block z-depth-1">
          {!! Form::open(['method' => 'POST', 'action' => 'NotificationController@store']) !!}
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                {!! Form::label('title', 'Notification Title') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter Notification Title"></i>
                {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('title') }}</small>
            </div>
             <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                {!! Form::label('description', 'Notification Description') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter Notification description"></i>
                {!! Form::text('description', null, ['class' => 'form-control', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('description') }}</small>
            </div>
            @php
            $movie=App\Movie::orderBy('created_at', 'desc')
              
               ->get();;
            @endphp
            <div class="form-group{{ $errors->has('movie_id') ? ' has-error' : '' }}">
                {!! Form::label('movie_id', 'Select Movies') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please Select Movie Latest 15 Movies You added are visible"></i>
                
                <select class="form-control select2" name="movie_id">
                  @foreach($movie as $movies)
                   
                  <option value="{{$movies->id}}" name="{{$movies->id}}">{{$movies->title}}</option>
                  @endforeach
                </select>
              
                <small class="text-danger">{{ $errors->first('movie_id') }}</small>
            </div>
             @php
            $livetv=App\Movie::orderBy('created_at', 'desc')->where('live',1)
             
               ->get();;
            @endphp
            <div class="form-group{{ $errors->has('movie_id') ? ' has-error' : '' }}">
                {!! Form::label('movie_id', 'Select Live Tv') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please Select Movie Latest 15 Movies You added are visible"></i>
                
                <select class="form-control select2" name="movie_id">
                   <!--<option value="0">None</option>-->
                  @foreach($livetv as $movies)
                   
                  <option value="{{$movies->id}}" name="{{$movies->id}}">{{$movies->title}}</option>
                  @endforeach
                </select>
              
                <small class="text-danger">{{ $errors->first('movie_id') }}</small>
            </div>

            @php
            $tv=App\TvSeries::orderBy('created_at', 'desc')
             
               ->get();

           
            @endphp
            <div class="form-group{{ $errors->has('tv_id') ? ' has-error' : '' }}">
                {!! Form::label('tv_id', 'Select Tv Series') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please Select Tv Series; Latest 15 TvSeries You added are visible"></i>
               
                <select class="form-control select2" name="tv_id">
                   <option value="0">None</option>

                     @foreach($tv as $tvs)
                     @php
                      $seasons=App\Season::where('tv_series_id',$tvs->id)->first();
                     @endphp
                      @if(isset($seasons) )
                  <option value="{{$seasons->id}}" name="{{$seasons->id}}">{{$tvs->title}}</option>
                  @endif
                @endforeach
                </select>
                
                <small class="text-danger">{{ $errors->first('tv_id') }}</small>
            </div>
            @php
            $user=App\User::all();
            @endphp
             <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                {!! Form::label('user_id', 'Select Users') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please Select Users; You can Select Multipe Users"></i>
                <select class="form-control select2" name="user_id[]" multiple="true" required="true">
                  <option value="0">All Users</option>
                     @foreach($user as $users)
                  <option value="{{$users->id}}">{{$users->name}}</option>
                    @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('user_id') }}</small>
            </div>
            
            <div class="btn-group pull-right">
              <button type="reset" class="btn btn-info"><i class="material-icons left">toys</i> Reset</button>
              <button type="submit" class="btn btn-success"><i class="material-icons left">add_to_photos</i> Create</button>
            </div>
            <div class="clear-both"></div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection
