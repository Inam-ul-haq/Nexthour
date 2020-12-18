@extends('layouts.theme')
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
@section('custom-script')
    <script>
   	var url = {!! json_encode($link) !!};
      $(document).ready(function(){
        $.colorbox({ href: url, width: '100%', height: '100%', iframe: true, onLoad: function(){$('#cboxClose').remove();}});
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
        
      });
    </script>
    
@endsection


