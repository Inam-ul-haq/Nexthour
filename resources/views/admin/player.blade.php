<div id="myDiv2" style="margin:auto;" >
<!--  <div class="close-btn-block text-right">
   <a class="close-btn" onclick="pause()"></a>
 </div> -->

</div>

<ul id="playlists1" style="display:none;">
   <li data-source="playlist2" data-playlist-name="MY HTML PLAYLIST 1" data-thumbnail-path="">
     <p class="minimalDarkCategoriesTitle"><span class="minimialDarkBold">Title: </span>My HTML playlist 1</p>
     <p class="minimalDarkCategoriesType"><span class="minimialDarkBold">Type: </span>HTML</p>
     <p class="minimalDarkCategoriesDescription"><span class="minimialDarkBold">Description: </span>Created using html elements, videos are loaded and played from the server.</p>
   </li>




</ul>

 <!--  HTML playlist -->
<ul id="playlist2" style="display:none;">



                 @if(isset($season->episodes))
                   @if(count($season->episodes) > 0)

         @foreach($season->episodes as $key => $episode)
            <?php
                  $poster_link = $season->tvseries['poster'];
                  $slink = \Illuminate\Support\Facades\DB::table('videolinks')->where([
                                                                     ['episode_id', '=', $episode->id],

                                                                    ])->first();


                                                                     ?>

   <li  data-thumb-source="{{asset('images/tvseries/thumbnails/'.$episode->seasons->thumbnail)}}" data-video-source="{{$slink->ready_url}}" data-poster-source="{{asset('images/tvseries/posters/'.$poster_link)}}" data-downloadable="yes">
     <div data-video-short-description="">
       <div>
         <p class="classicDarkThumbnailTitle">{{$key+1}}. {{$episode->title}}</p>
         <p class="minimalDarkThumbnailDesc">{{$episode->detail}}</p>
       </div>
     </div>
     <div data-video-long-description="">
       <div>
         <p class="minimalDarkVideoTitleDesc">ROYAL 3D COVERFLOW</p>
         <p class="minimalDarkVideoMainDesc">Each video can contain a detailed description, the description can be formatted with CSS as you like. The description window and description button can be disabled individually for each video or globally for all videos.</p>
         <p class="minimalDarkLink">For more information about this please follow <a href="http://www.webdesign-flash.ro/p/royal-3d-coverflow/" target="_blank">this link</a></p>
       </div>
     </div>
     <div data-add-popup="">
     <p data-image-path="content/images/img.jpg" data-time-start="00:00:01" data-time-end="00:00:10" data-link="http://www.webdesign-flash.ro" data-target="_blank"></p>
       <p data-image-path="content/images/img2.jpg" data-time-start="00:00:11" data-time-end="00:00:20" data-link="http://www.google.com" data-target="_blank"></p>
       <p data-google-ad-client="ca-pub-9227170916808685" data-google-ad-slot="7711195609" data-google-ad-width=400 data-google-ad-height=100 data-time-start="00:00:21" data-time-end="00:00:30"></p>
       <p data-google-ad-client="ca-pub-9227170916808685" data-google-ad-slot="7711195609" data-google-ad-width=400 data-google-ad-height=300 data-time-start="00:00:31" data-time-end="00:00:40"></p>
     </div>
   </li>


         @endforeach

   @endif
 @endif






   </ul>

   @section('custom-script')
     <script type="text/javascript">
       function playTest(id,type)
       {
         var lightboxIntervalId;
       openLightboxWhenPageReady();
       function openLightboxWhenPageReady(){
         clearInterval(lightboxIntervalId);
         if(window["player2"]){
           window["player2"].showLightbox();
         }else{
           lightboxIntervalId = setInterval(openLightboxWhenPageReady, 100);
         }
       };

       player2.play();
       $('#myDiv2').show();
       }
     </script>
     <script>
     FWDUVPUtils.onReady(function(){

           new FWDUVPlayer({
             //main settings
             instanceName:"player2",
             parentId:"myDiv2",
             playlistsId:"playlists1",
             mainFolderPath:"http://localhost/nexthour/public/content",
             skinPath:"minimal_skin_dark",
             displayType:"lightbox",
             initializeOnlyWhenVisible:"no",
             useVectorIcons:"no",
             fillEntireVideoScreen:"yes",
             privateVideoPassword:"428c841430ea18a70f7b06525d4b748a",
             useHEXColorsForSkin:"no",
             normalHEXButtonsColor:"#FF0000",
             selectedHEXButtonsColor:"#000000",
             googleAnalyticsTrackingCode:"",
             useDeepLinking:"yes",
             showPreloader:"yes",
             preloaderBackgroundColor:"#000000",
             preloaderFillColor:"#FFFFFF",
             rightClickContextMenu:"developer",
             useResumeOnPlay:"yes",
             addKeyboardSupport:"yes",
             autoScale:"yes",
             showButtonsToolTip:"yes",
             stopVideoWhenPlayComplete:"no",
             playAfterVideoStop:"no",
             autoPlay:"yes",
             loop:"no",
             shuffle:"no",
             maxWidth:1080,
             maxHeight:556,
             buttonsToolTipHideDelay:1.5,
             volume:.8,
             backgroundColor:"#000000",
             videoBackgroundColor:"#000000",
             posterBackgroundColor:"#000000",
             buttonsToolTipFontColor:"#5a5a5a",
             //logo settings
             showLogo:"yes",
             hideLogoWithController:"yes",
             logoPosition:"topRight",
             logoLink:"http://www.webdesign-flash.ro/",
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
            
             showPlaylistButtonAndPlaylist:"yes",
             playlistPosition:"right",
             showPlaylistByDefault:"yes",
             showPlaylistName:"yes",
             showSearchInput:"yes",
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
             showSubtitleButton:"yes",
             showDownloadButton:"yes",
             showShareButton:"yes",
             showEmbedButton:"yes",
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
             subtitlePath:"subtitle.txt",
             showSubtitileByDefault:"no",
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
             mainBackgroundImagePath:"http://localhost/nexthour/public/content/minimal_skin_dark/main-background.png",
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
         });

         //Register API (an setInterval is required because the player is not available until the youtube API is loaded).
      var registerAPIInterval;
         function registerAPI(){
           clearInterval(registerAPIInterval);
           if(window.player2){
             player2.addListener(FWDUVPlayer.READY, readyHandler);
             player2.addListener(FWDUVPlayer.ERROR, errorHandler);
             player2.addListener(FWDUVPlayer.PLAY, playHandler);
             player2.addListener(FWDUVPlayer.PAUSE, pauseHandler);
             player2.addListener(FWDUVPlayer.STOP, stopHandler);
             player2.addListener(FWDUVPlayer.UPDATE, updateHandler);
             player2.addListener(FWDUVPlayer.UPDATE_TIME, updateTimeHandler);
             player2.addListener(FWDUVPlayer.UPDATE_VIDEO_SOURCE, updateVideoSourceHandler);
             player2.addListener(FWDUVPlayer.UPDATE_POSTER_SOURCE, updatePosterSourceHandler);
             player2.addListener(FWDUVPlayer.START_TO_LOAD_PLAYLIST, startToLoadPlaylistHandler);
             player2.addListener(FWDUVPlayer.LOAD_PLAYLIST_COMPLETE, loadPlaylistCompleteHandler);
             player2.addListener(FWDUVPlayer.PLAY_COMPLETE, playCompleteHandler);
           }else{
             registerAPIInterval = setInterval(registerAPI, 100);
           }
         };

    //      $( document ).ready(function() {
    // player2.hidePlayer();
    //      });

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

         function updateVideoSourceHandler(){
           // console.log("API -- video source update: " + player2.getVideoSource());

         }

         function updatePosterSourceHandler(e){
           //console.log("API -- video source update: " + player2.getPosterSource());
         }

         function startToLoadPlaylistHandler(e){
           // console.log("API -- start to load playlist: " + player2.getCurCatId());
         }

         function loadPlaylistCompleteHandler(e){
           //console.log("API -- playlist load complete: " + player2.getCurCatId());
         }

         function playCompleteHandler(e){
           //console.log("API -- play complete");
         }
     </script>
   @endsection
