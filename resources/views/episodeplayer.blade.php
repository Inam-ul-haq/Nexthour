<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Watch Episode - {{ $episode->title }}</title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="initial-scale=1, maximum-scale=1 user-scalable=no" />
		
		<link rel="stylesheet" type="text/css"  href="{{url('content/global.css')}}"/>
	
		<?php
	    	$cpy = App\PlayerSetting::first();
	    	$text = $cpy->cpy_text;
	    	$app_url = config('app.url');
		?>
		
		<script type="text/javascript">
			var cpy = "<?= $text ?>";
			var app_url = "<?= $app_url ?>";
		</script>
		

		<script type="text/javascript" src="{{ asset('java/FWDUVPlayer.js') }}"></script>
		 <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>


      <script type="text/javascript">
	 $(document).ready(function(){
	 	var SITEURL = '{{URL::to('')}}';
	 	 setInterval(function(){
	 		
	 		var tt = FWDUVPlayer.instaces_ar.length;
			var episode_id='{{$episode->id}}';
			var tv_id='{{$episode->seasons->tvseries->id}}';
			var user_id='{{Auth::check() ? Auth::user()->id : $user}}'
			 var video;
			
			 // console.log(tv_id);
		for(var i=0; i<tt; i++){
			video = FWDUVPlayer.instaces_ar[i];

			 $.ajax({
            type: "get",
            url: SITEURL + "/user/episode/time/"+video['curTime']+'/'+episode_id+'/'+user_id+'/'+tv_id,
            success: function (data) {
             console.log(data);
            },
            error: function (data) {
               console.log(data)
            }
        });
			}

	 	},5000);
         
	
  });
</script>
		<!-- Setup video player-->
		<script type="text/javascript">
			 $(document).on(function () {
     
        				test();
   					 });
			FWDUVPUtils.onReady(function(){

				new FWDUVPlayer({		
					//main settings
					instanceName:"player1",
					parentId:"myDiv",
					playlistsId:"playlists",
					mainFolderPath:"{{url('content')}}",
					skinPath:"{{$cpy->skin}}",
					displayType:"fullscreen",
					initializeOnlyWhenVisible:"no",
					useVectorIcons:"no",
					fillEntireVideoScreen:"no",
					privateVideoPassword:"428c841430ea18a70f7b06525d4b748a",
					useHEXColorsForSkin:"no",
					normalHEXButtonsColor:"#FF0000",
					selectedHEXButtonsColor:"#000000",
					showChromecastButton:"yes",
					googleAnalyticsTrackingCode:"",
					useDeepLinking:"no",
					showPreloader:"yes",
					preloaderBackgroundColor:"#000000",
					preloaderFillColor:"#FFFFFF",
					rightClickContextMenu:"developer",
					addKeyboardSupport:"yes",
					autoScale:"yes",
					showButtonsToolTip:"yes", 
					stopVideoWhenPlayComplete:"no",
					playAfterVideoStop:"no",
					autoPlay:"no",
					//loop video settings
					@if($cpy->loop_video ==1)
					loop:"yes",
					@else
					loop:"no",
					@endif
					shuffle:"no",
					showErrorInfo:"yes",
					maxWidth:980,
					maxHeight:552,
					buttonsToolTipHideDelay:1.5,
					volume:.8,
					backgroundColor:"#000000",
					videoBackgroundColor:"#000000",
					posterBackgroundColor:"#000000",
					buttonsToolTipFontColor:"#5a5a5a",
				
					//logo settings
					@if($cpy->logo_enable ==1)
					showLogo:"yes",
					@else
					showLogo:"no",
					@endif
					hideLogoWithController:"yes",
					logoPosition:"topRight",
					logoLink:"{{ config('app.url') }}",
					logoMargins:5,
					//playlists/categories settings
					showPlaylistsSearchInput:"yes",
					usePlaylistsSelectBox:"yes",
					showPlaylistsButtonAndPlaylists:"yes",
					showPlaylistsByDefault:"no",
					thumbnailSelectedType:"opacity",
					startAtPlaylist:0,
					buttonsMargins:0,
					thumbnailMaxWidth:350, 
					thumbnailMaxHeight:350,
					horizontalSpaceBetweenThumbnails:40,
					verticalSpaceBetweenThumbnails:40,
					inputBackgroundColor:"#333333",
					inputColor:"#999999",
					//playlist settings
					showPlaylistButtonAndPlaylist:"yes",
					playlistPosition:"right",
					showPlaylistByDefault:"yes",
					showPlaylistName:"yes",
					showSearchInput:"no",
					showLoopButton:"yes",
					showShuffleButton:"yes",
					showNextAndPrevButtons:"yes",
					showThumbnail:"yes",
					forceDisableDownloadButtonForFolder:"yes",
					addMouseWheelSupport:"yes", 
					startAtRandomVideo:"no",
					stopAfterLastVideoHasPlayed:"no",
					folderVideoLabel:"VIDEO ",
					playlistRightWidth:310,
					playlistBottomHeight:599,
					startAtVideo:0,
					maxPlaylistItems:50,
					thumbnailWidth:70,
					thumbnailHeight:70,
					spaceBetweenControllerAndPlaylist:2,
					spaceBetweenThumbnails:2,
					scrollbarOffestWidth:8,
					scollbarSpeedSensitivity:.5,
					playlistBackgroundColor:"#000000",
					playlistNameColor:"#FFFFFF",
					thumbnailNormalBackgroundColor:"#1b1b1b",
					thumbnailHoverBackgroundColor:"#313131",
					thumbnailDisabledBackgroundColor:"#272727",
					searchInputBackgroundColor:"#000000",
					searchInputColor:"#999999",
					youtubeAndFolderVideoTitleColor:"#FFFFFF",
					folderAudioSecondTitleColor:"#999999",
					youtubeOwnerColor:"#888888",
					youtubeDescriptionColor:"#888888",
					mainSelectorBackgroundSelectedColor:"#FFFFFF",
					mainSelectorTextNormalColor:"#FFFFFF",
					mainSelectorTextSelectedColor:"#000000",
					mainButtonBackgroundNormalColor:"#212021",
					mainButtonBackgroundSelectedColor:"#FFFFFF",
					mainButtonTextNormalColor:"#FFFFFF",
					mainButtonTextSelectedColor:"#000000",
					//controller settings
					showController:"yes",
					showControllerWhenVideoIsStopped:"yes",
					showNextAndPrevButtonsInController:"no",
					showRewindButton:"yes",
					showPlaybackRateButton:"yes",
					showVolumeButton:"yes",
					showTime:"yes",
					showQualityButton:"yes",
					showInfoButton:"yes",
					showDownloadButton:"yes",
						
					@if($cpy->share_opt ==1)
					showShareButton:"yes",
					@else
					showShareButton:"no",
					@endif
					
					showEmbedButton:"no",
					showFullScreenButton:"yes",
					disableVideoScrubber:"no",
					showMainScrubberToolTipLabel:"yes",
					showDefaultControllerForVimeo:"no",
					repeatBackground:"yes",
					controllerHeight:37,
					controllerHideDelay:3,
					startSpaceBetweenButtons:7,
					spaceBetweenButtons:8,
					scrubbersOffsetWidth:2,
					mainScrubberOffestTop:14,
					timeOffsetLeftWidth:5,
					timeOffsetRightWidth:3,
					timeOffsetTop:0,
					volumeScrubberHeight:80,
					volumeScrubberOfsetHeight:12,
					timeColor:"#888888",
					youtubeQualityButtonNormalColor:"#888888",
					youtubeQualityButtonSelectedColor:"#FFFFFF",
					scrubbersToolTipLabelBackgroundColor:"#FFFFFF",
					scrubbersToolTipLabelFontColor:"#5a5a5a",
					//advertisement on pause window
					aopwTitle:"Advertisement",
					aopwWidth:400,
					aopwHeight:240,
					aopwBorderSize:6,
					aopwTitleColor:"#FFFFFF",
					//subtitle
					subtitlesOffLabel:"Subtitle off",
					//popup add windows
					showPopupAdsCloseButton:"yes",
					//embed window and info window
					embedAndInfoWindowCloseButtonMargins:0,
					borderColor:"#333333",
					mainLabelsColor:"#FFFFFF",
					secondaryLabelsColor:"#a1a1a1",
					shareAndEmbedTextColor:"#5a5a5a",
					inputBackgroundColor:"#000000",
					inputColor:"#FFFFFF",
					//loggin
					isLoggedIn:"yes",
					playVideoOnlyWhenLoggedIn:"yes",
					loggedInMessage:"Please login to view this video.",
					//audio visualizer
					audioVisualizerLinesColor:"#0099FF",
					audioVisualizerCircleColor:"#FFFFFF",
					//lightbox settings
					lightBoxBackgroundOpacity:.6,
					lightBoxBackgroundColor:"#000000",
					//sticky on scroll
					stickyOnScroll:"no",
					stickyOnScrollShowOpener:"yes",
					stickyOnScrollWidth:"700",
					stickyOnScrollHeight:"394",
					//sticky display settings
					showOpener:"yes",
					showOpenerPlayPauseButton:"yes",
					verticalPosition:"bottom",
					horizontalPosition:"center",
					showPlayerByDefault:"yes",
					animatePlayer:"yes",
					openerAlignment:"right",
					mainBackgroundImagePath:"{{url('content/minimal_skin_dark/main-background.png')}}",
					openerEqulizerOffsetTop:-1,
					openerEqulizerOffsetLeft:3,
					offsetX:0,
					offsetY:0,
					//playback rate / speed
					defaultPlaybackRate:1, //0.25, 0.5, 1, 1.25, 1.2, 2
					//cuepoints
					executeCuepointsOnlyOnce:"no",
					//annotations
					showAnnotationsPositionTool:"no",
					//ads
					openNewPageAtTheEndOfTheAds:"no",
					playAdsOnlyOnce:"no",
					adsButtonsPosition:"left",
					skipToVideoText:"You can skip to video in: ",
					skipToVideoButtonText:"Skip Ad",
					adsTextNormalColor:"#888888",
					adsTextSelectedColor:"#FFFFFF",
					adsBorderNormalColor:"#666666",
					adsBorderSelectedColor:"#FFFFFF",
					//a to b loop
					useAToB:"yes",
					atbTimeBackgroundColor:"transparent",
					atbTimeTextColorNormal:"#888888",
					atbTimeTextColorSelected:"#FFFFFF",
					atbButtonTextNormalColor:"#888888",
					atbButtonTextSelectedColor:"#FFFFFF",
					atbButtonBackgroundNormalColor:"#FFFFFF",
					atbButtonBackgroundSelectedColor:"#000000"
				});
					registerAPI();
					// registerAPI1();
					

			});
			
			//Register API (an setInterval is required because the player is not available until the youtube API is loaded).
			var registerAPIInterval;
			function registerAPI(){
				clearInterval(registerAPIInterval);
				if(window.player1){
					player1.addListener(FWDUVPlayer.READY, readyHandler);
					player1.addListener(FWDUVPlayer.ERROR, errorHandler);
					player1.addListener(FWDUVPlayer.PLAY, playHandler);
					player1.addListener(FWDUVPlayer.PAUSE, pauseHandler);
					player1.addListener(FWDUVPlayer.STOP, stopHandler);
					player1.addListener(FWDUVPlayer.UPDATE, updateHandler);
					player1.addListener(FWDUVPlayer.UPDATE_TIME, updateTimeHandler);
					player1.addListener(FWDUVPlayer.UPDATE_VIDEO_SOURCE, updateVideoSourceHandler);
					player1.addListener(FWDUVPlayer.UPDATE_POSTER_SOURCE, updatePosterSourceHandler);
					player1.addListener(FWDUVPlayer.START_TO_LOAD_PLAYLIST, startToLoadPlaylistHandler);
					player1.addListener(FWDUVPlayer.LOAD_PLAYLIST_COMPLETE, loadPlaylistCompleteHandler);
					player1.addListener(FWDUVPlayer.PLAY_COMPLETE, playCompleteHandler);
				}else{
					registerAPIInterval = setInterval(registerAPI, 100);
				}
			};
			// var registerAPIInterval1;
						
			//API event listeners examples
			function readyHandler(e){
				//console.log("API -- ready to use");
			}
			
			function errorHandler(e){
				console.log(e.error);
			}

			function playHandler(e){
				//console.log("API -- play");
			}

			function pauseHandler(e){
				//console.log("API -- pause");
			}

			function stopHandler(e){
				//console.log("API -- stop");
			}
			
			function updateHandler(e){
				//console.log("API -- update video, percent played: " + e.percent);
			}
			
			function updateTimeHandler(e){
				//console.log("API -- update time: " + e.currentTime + "/" + e.totalTime);
			}

			function updateVideoSourceHandler(e){
				//console.log("API -- video source update: " + player1.getVideoSource());
			}

			function updatePosterSourceHandler(e){
				//console.log("API -- video source update: " + player1.getPosterSource());
			}
			
			function startToLoadPlaylistHandler(e){
				//console.log("API -- start to load playlist: " + player1.getCurCatId());
			}
			
			function loadPlaylistCompleteHandler(e){
				//console.log("API -- playlist load complete: " + player1.getCurCatId());
			}
			
			function playCompleteHandler(e){
				//console.log("API -- play complete");
			}
			

			//API methods examples
			function play(){
				player1.play();
			}

			function playNext(){
				player1.playNext();
			}

			function playPrev(){
				player1.playPrev();
			}

			function playShuffle(){
				player1.playShuffle();
			}
			
			function playVideo(videoId){
				player1.playVideo(videoId);
			}
			
			function pause(){
				player1.pause();
			}

			function stop(){
				player1.stop();
			}

			function scrub(percent){
				player1.scrub(percent);
			}

			function setVolume(percent){
				player1.setVolume(percent);
			}
			
			function share(){
				player1.share();
			}
			
			function download(){
				player1.downloadVideo();
			}

			function goFullScreen(){
				player1.goFullScreen();
			}
			
			function showCategories(){
				player1.showCategories();
			}
			
			function loadPlaylist(playlistId){
				player1.loadPlaylist(playlistId);
			}
	

		</script>
		
	</head>

	<body style="background-color:#999999; padding:0px; margin:0px;">	
	
		<div id="myDiv" style="position:relative; left:1000px; top:5000px;"></div>
	
		<!--  Playlists -->
		<ul id="playlists" style="display:none;">
		
		  <li data-source="episode" data-playlist-name="{{ $episode->seasons->tvseries->title }}" data-thumbnail-path="{{asset('images/tvseries/thumbnails/'.$episode->seasons->thumbnail)}}">
        <p class="minimalDarkCategoriesTitle"><span class="minimialDarkBold">Title: {{ $episode->seasons->title }}</span></p>
        <p class="minimalDarkCategoriesDescription"><span class="minimialDarkBold">Description: </span>{{ $episode->seasons->detail }}</p>
      	</li>


			
		</ul>

		<ul id="episode">

			
			
			<li @php
			$pauseads = App\Ads::where('ad_location','=','onpause')->get();
			$pausead =  App\Ads::inRandomOrder()->where('ad_location','=','onpause')->first();

			$endtime='0';
		$user_id=Auth::check() ? Auth::user()->id : $user;
		
		$episode_id = $episode->id;

		$checkmovie=Session::get('time_'.$episode->seasons->tvseries->id.$episode_id) ;

		if (!is_null($checkmovie) && isset($checkmovie)) {
			$mid=$checkmovie['episode_id'];
      if ($mid==$episode_id) {
      	$endtime=$checkmovie['endtime'];
      }else{
      	$endtime='00:00:00';
      }
		}else{
				$endtime='00:00:00';
		}
			@endphp

			<li @if($pauseads->count()>0)
			 data-advertisement-on-pause-source="{{ asset('adv_upload/image/'.$pausead->ad_image) }}" 
			@endif data-thumb-source="{{asset('images/tvseries/thumbnails/'.$episode->seasons->thumbnail)}}" 

				@php
				$slink = \Illuminate\Support\Facades\DB::table('videolinks')->where([
                                                                     ['episode_id', '=', $episode->id],

                                                                    ])->first();
				@endphp
			
			@if(isset($slink->ready_url) && $slink->ready_url !="")
				data-start-at-time="{{date('H:i:s',strtotime($endtime))}}"
		  data-video-source="{{ $slink->ready_url }}"

		  @else
     	data-start-at-time="{{date('H:i:s',strtotime($endtime))}}"
  		data-video-source="[<?php if(isset($slink->url_360) && $slink->url_360 !=""){ ?>{source:'{{ $slink->url_360 }}', label:'360p'}, <?php } ?> <?php if(isset($slink->url_480) && $slink->url_480 !=""){ ?>{source:'{{ $slink->url_480 }}', label:'480p'}, <?php } ?> <?php if(isset($slink->url_720) && $slink->url_720 !=""){?>{source:'{{ $slink->url_720 }}', label:'hd720'}, <?php } ?> <?php if(isset($slink->url_1080) && $slink->url_1080 !=""){?> {source:'{{ $slink->url_1080 }}', label:'hd1080'}, <?php } ?>]" @endif

			 data-poster-source="{{asset('images/tvseries/posters/'.$episode->seasons->tvseries->poster)}}"> 
			    <div data-video-short-description="">
			    	 <p class="minimalDarkCategoriesTitle"><span class="minimialDarkBold">Title: </span>{{ $episode->title }}</p>
        <p class="minimalDarkCategoriesDescription"><span class="minimialDarkBold">Description: </span>{{ $episode->detail }}</p>
			    </div>

			    @php
					$popupads = App\Ads::where('ad_location','=', 'popup')->get();
					$popupad = App\Ads::inRandomOrder()->where('ad_location','=','popup')->first();	
				@endphp
				
				@if($popupads->count()>0)
			    <div data-add-popup="">
				<p data-image-path="{{ asset('adv_upload/image/'.$popupad->ad_image) }}" data-time-start="{{ $popupad->time }}" data-time-end="{{ $popupad->endtime }}" data-link="{{ $popupad->ad_target }}" data-target="_blank"></p>
				</div>
				@endif

			    @php
				
				$skipads = App\Ads::where('ad_location','=', 'skip')->get();
				$skipad = App\Ads::inRandomOrder()->where('ad_location','=','skip')->first();


				@endphp
		@if($skipads->count()>0)
  		<ul data-ads="">
						<li @if($skipad->ad_video !="no")

						data-source="{{ asset('adv_upload/video/'.$skipad->ad_video) }}" 
						@else
						data-source="{{ $skipad->ad_url }}" @endif 
						data-time-start="{{ $skipad->time }}" data-time-to-hold-ads={{ $skipad->ad_hold }} data-thumbnail-source="{{asset('images/tvseries/thumbnails/'.$season->thumbnail)}}" data-link="{{ $skipad->ad_target }}" data-target="_blank"></li>
		</ul>
		@endif
			</li>
			
		</ul>
		
	</body>
</html>




