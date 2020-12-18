@extends('layouts.admin')
@section('title','Pricing Text Setting')
@section('content')
  <div class="admin-form-main-block mrg-t-40">
    <h4 class="admin-form-text">Pricing Text Setting</h4>
    <div class="admin-form-block z-depth-1">
      <div class="row">
        {!! Form::model($pricingtexts, ['method' => 'POST', 'action' => 'CustomStyleController@pricingTextUpdate']) !!}
         <div class="form-group{{ $errors->has('package_id') ? ' has-error' : '' }}">
                      {!! Form::label('package_id', 'Select Package') !!}
                      {{-- <p class="inline info"> - Please enter genre name</p> --}}
                      <select class="form-control select2" id="package_id" name="package_id"
                       onChange="window.location.href=this.value">
                        @if(isset($package))
                        @foreach($package as $p)
                        @if($selectid == $p->id)
                           <option value="{{$p->id}}" selected="true">{{$p->name}}</option>
                        @else
                           <option value="{{$p->id}}">{{$p->name}}</option>
                        @endif
                      
                         @endforeach
                         @endif
                       </select>
                      <small class="text-danger">{{ $errors->first('package_id') }}</small>
                  </div>
                 @php
                 $title1=null;$title2=null;$title3=null;
                 $title4=null;$title5=null;$title6=null;
                 if (isset($pricingtexts) && count($pricingtexts)>0) {
                   foreach ($pricingtexts as $key => $value) {
                     $title1=$value->title1;
                      $title2=$value->title2;
                       $title3=$value->title3;
                        $title4=$value->title4;
                         $title5=$value->title5;
                          $title6=$value->title6;
                   }
                 }
                 @endphp
                 
                <div class="col-md-4">
                {{-- title 1 --}}
                  <div class="form-group{{ $errors->has('title1') ? ' has-error' : '' }}">
                      {!! Form::label('title1', 'title 1') !!}
                      {{-- <p class="inline info"> - Please enter genre name</p> --}}
                    {!! Form::text('title1',$title1, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('title1') }}</small>
                  </div>
                </div>

                <div class="col-md-4">
                {{-- title 2 --}}
                  <div class="form-group{{ $errors->has('title2') ? ' has-error' : '' }}">
                      {!! Form::label('title2', 'title 2') !!}
                      {{-- <p class="inline info"> - Please enter genre name</p> --}}
                    {!! Form::text('title2',$title2, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('title2') }}</small>
                  </div>
                </div>
                <div class="col-md-4">
                {{-- title 3 --}}
                  <div class="form-group{{ $errors->has('title3') ? ' has-error' : '' }}">
                      {!! Form::label('title3', 'title 3') !!}
                      {{-- <p class="inline info"> - Please enter genre name</p> --}}
                    {!! Form::text('title3',$title3, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('title3') }}</small>
                  </div>
                </div>
                 <div class="col-md-4">
                {{-- title 4 --}}
                  <div class="form-group{{ $errors->has('title4') ? ' has-error' : '' }}">
                      {!! Form::label('title4', 'title 4') !!}
                      {{-- <p class="inline info"> - Please enter genre name</p> --}}
                    {!! Form::text('title4',$title4, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('title4') }}</small>
                  </div>
                </div>
                <div class="col-md-4">
                {{-- title 5 --}}
                  <div class="form-group{{ $errors->has('title5') ? ' has-error' : '' }}">
                      {!! Form::label('title5', 'title 5') !!}
                      {{-- <p class="inline info"> - Please enter genre name</p> --}}
                    {!! Form::text('title5',$title5, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('title5') }}</small>
                  </div>
                </div>
                 <div class="col-md-4">
                {{-- title 6 --}}
                  <div class="form-group{{ $errors->has('title6') ? ' has-error' : '' }}">
                      {!! Form::label('title6', 'title 6') !!}
                      {{-- <p class="inline info"> - Please enter genre name</p> --}}
                    {!! Form::text('title6',$title6, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('title6') }}</small>
                  </div>
                </div>
            
            

          <div class="">
            <button type="submit" class="btn btn-block btn-success">UPDATE</button>
          </div>
         
          <div class="clear-both"></div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection
