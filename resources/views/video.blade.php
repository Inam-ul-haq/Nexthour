@extends('layouts.theme')

@foreach($movies as $movie)
    <div id="myDiv">

    </div>

    <ul id="playlists" style="display:none;">
			<li data-source="playlist1" data-playlist-name="MY HTML PLAYLIST 1" data-thumbnail-path="content/thumbnails/large1.jpg">
				<p class="minimalDarkCategoriesTitle"><span class="minimialDarkBold">Title: </span>My HTML playlist 1</p>
				<p class="minimalDarkCategoriesType"><span class="minimialDarkBold">Type: </span>HTML</p>
				<p class="minimalDarkCategoriesDescription"><span class="minimialDarkBold">Description: </span>Created using html elements, videos are loaded and played from the server.</p>
			</li>

			<li data-source="list=PLxKHVMqMZqUQFbRO0VWaHMaWuQagIgpJe"  data-playlist-name="MY YOUTUBE PLAYLIST 1" data-thumbnail-path="content/thumbnails/large2.jpg">
				<p class="minimalDarkCategoriesTitle"><span class="minimialDarkBold">Title: </span>My Youtube playlist 1</p>
				<p class="minimalDarkCategoriesType"><span class="minimialDarkBold">Type: </span>YOUTUBE</p>
				<p class="minimalDarkCategoriesDescription"><span class="minimialDarkBold">Description: </span>Created by loading a Youtube playlist, videos are loaded and played from Youtube.</p>
			</li>

			<li data-source="mixedPlaylist" data-playlist-name="MY MIXED PLAYLIST 1" data-thumbnail-path="content/thumbnails/large3.jpg">
				<p class="minimalDarkCategoriesTitle"><span class="minimialDarkBold">Title: </span>My mixed playlist 1</p>
				<p class="minimalDarkCategoriesType"><span class="minimialDarkBold">Type: </span>MIXED</p>
				<p class="minimalDarkCategoriesDescription"><span class="minimialDarkBold">Description: </span>Created using HTML elements, videos are loaded and played from the server or Youtube.</p>
			</li>

			<li data-source="http://www.webdesign-flash.ro/p/uvp/content/playlist_dark.xml" data-playlist-name="MY XML PLAYLIST 1" data-thumbnail-path="content/thumbnails/large4.jpg">
				<p class="minimalDarkCategoriesTitle"><span class="minimialDarkBold">Title: </span>My XML playlist 1</p>
				<p class="minimalDarkCategoriesType"><span class="minimialDarkBold">Type: </span>XML</p>
				<p class="minimalDarkCategoriesDescription"><span class="minimialDarkBold">Description: </span>Created using a XML file, videos are loaded and played from the server or Youtube.</p>
			</li>

			<li data-source="vimeoPlaylist" data-playlist-name="VIMEO PLAYLIST" data-thumbnail-path="content/thumbnails/large19.jpg">
				<p class="minimalDarkCategoriesTitle"><span class="minimialDarkBold">Title: </span>MY VIMEO PLAYLIST 1</p>
				<p class="minimalDarkCategoriesType"><span class="minimialDarkBold">Type: </span>VIMEO</p>
				<p class="minimalDarkCategoriesDescription"><span class="minimialDarkBold">Description: </span>Created using HTML elements, videos are loaded and played from Vimeo.</p>
			</li>

			<li data-source="folder=videos" data-playlist-name="MY FOLDER PLAYLIST 1" data-thumbnail-path="content/thumbnails/large5.jpg">
				<p class="minimalDarkCategoriesTitle"><span class="minimialDarkBold">Title: </span>My folder playlist 1</p>
				<p class="minimalDarkCategoriesType"><span class="minimialDarkBold">Type: </span>FOLDER</p>
				<p class="minimalDarkCategoriesDescription"><span class="minimialDarkBold">Description: </span>Created using a folder with mp4 files, videos are loaded and played from the server.</p>
			</li>

			<li data-source="playlist1" data-playlist-name="MY HTML PLAYLIST 2" data-thumbnail-path="content/thumbnails/large6.jpg">
				<p class="minimalDarkCategoriesTitle"><span class="minimialDarkBold">Title: </span>My HTML playlist 2</p>
				<p class="minimalDarkCategoriesType"><span class="minimialDarkBold">Type: </span>HTML</p>
				<p class="minimalDarkCategoriesDescription"><span class="minimialDarkBold">Description: </span>Created using html elements, videos are loaded and played from the server.</p>
			</li>

		</ul>

		<!--  HTML playlist -->
		<ul id="playlist1" style="display:none;">

				<li data-thumb-source="content/thumbnails/small-fwd.jpg" data-video-source="{{ $movie->trailer_url }}" data-start-at-subtitle="2" data-downloadable="yes">	<div data-video-short-description="">
						<div>
							<p class="classicDarkThumbnailTitle">VIDEO TITLE</p>
							<p class="minimalDarkThumbnailDesc">Each video can contain a short description, the description can be formatted with CSS as you like.</p>
						</div>
					</div>
					<div data-video-long-description="">
						<div>
							<p class="minimalDarkVideoTitleDesc">VIDEO TITLE</p>
							<p class="minimalDarkVideoMainDesc">Each video can contain a detailed description, the description can be formatted with CSS as you like. The description window and description button can be disabled individually for each video or globally for all videos.</p>
							<p class="minimalDarkLink">For more information about this please follow <a href="http://www.webdesign-flash.ro/" target="_blank">this link</a></p>
						</div>
					</div>
				</li>

				<li data-thumb-source="content/thumbnails/small-grid.jpg" data-video-source="content/videos/grid.mp4,content/videos/grid-mobile.mp4" data-poster-source="content/posters/mp4-poster.jpg,content/posters/mp4-poster-mobile.jpg" data-downloadable="yes">
				<ul data-ads="">
						<li data-source="content/videos/ad.mp4" data-time-start="00:00:20" data-time-to-hold-ads=4 data-thumbnail-source="content/images/thumbnail.jpg" data-link="http://www.webdesign-flash.ro" data-target="_blank"></li>
						<li data-source="https://www.youtube.com/watch?v=Bv09DRd4lsM" data-time-start="00:00:32" data-time-to-hold-ads=4 data-thumbnail-source="content/images/thumbnail.jpg" data-link="http://www.webdesign-flash.ro" data-target="_blank"></li>
						<li data-source="content/images/ad.jpg" data-time-start="00:00:48" data-time-to-hold-ads=4 data-add-duration="00:00:20" data-thumbnail-source="" data-link="http://www.webdesign-flash.ro/p/evp/content/images/ad.jpg" data-target="_blank"></li>
					</ul>
					<div data-video-short-description="">
						<div>
							<p class="classicDarkThumbnailTitle">HORIZONTAL GRIDFOLIO PRO</p>
							<p class="minimalDarkThumbnailDesc">Fully responsive media grid plugin with HTML content support.</p>
						</div>
					</div>
					<div data-video-long-description="">
						<div>
							<p class="minimalDarkVideoTitleDesc">HORIZONTAL GRIDFOLIO PRO</p>
							<p class="minimalDarkVideoMainDesc">Each video can contain a detailed description, the description can be formatted with CSS as you like. The description window and description button can be disabled individually for each video or globally for all videos.</p>
							<p class="minimalDarkLink">For more information about this please follow <a href="http://www.webdesign-flash.ro/p/horizontal-gridfolio-pro/" target="_blank">this link</a></p>
						</div>
					</div>
				</li>

				<li data-thumb-source="content/thumbnails/small-rap.jpg" data-video-source="[{source:'content/videos2/fwd-480p.mp4', label:'small version'}, {source:'content/videos2/fwd-720p.mp4', label:'hd720'},{source:'content/videos2/fwd-1080p.mp4', label:'hd1080'}]" data-start-at-video="2" data-poster-source="content/posters/mp4-poster.jpg,content/posters/mp4-poster-mobile.jpg" data-downloadable="yes">
				<div data-video-short-description="">
					<div>
						<p class="classicDarkThumbnailTitle">ROYAL AUDIO PLAYER</p>
						<p class="minimalDarkThumbnailDesc">HTML5 mp3 player for your website that runs on all major browsers and mobile devices.</p>
					</div>
				</div>
				<div data-video-long-description="">
					<div>
						<p class="minimalDarkVideoTitleDesc">ROYAL AUDIO PLAYER</p>
						<p class="minimalDarkVideoMainDesc">Each video can contain a detailed description, the description can be formatted with CSS as you like. The description window and description button can be disabled individually for each video or globally for all videos.</p>
						<p class="minimalDarkLink">For more information about this please follow <a href="http://www.webdesign-flash.ro/p/rap/" target="_blank">this link</a></p>
					</div>
				</div>
				<ul data-annotations="">
						<li data-start-time="00:00:01" data-end-time="00:00:29" data-left="8" data-top="96" data-show-close-button="yes" data-normal-state-class="UVPAnnotationNormal">
							<div> Annotations like this can be added with ease!</div>
						</li>

						<li data-start-time="00:00:02" data-end-time="00:00:29" data-left="10" data-top="135" data-show-close-button="yes" data-click-source="http://www.webdesign-flash.ro" data-click-source-target="_blank" data-normal-state-class="UVPAnnotationLinkNormal" data-selected-state-class="UVPAnnotationLinkSelected">
							<div><span style="font-weight:bold; text-decoration: underline;">LINK</span> support, href and target can be specified, also animation between annotation states is possible as you can see here on hover.</div>
						</li>

						<li data-start-time="00:00:03" data-end-time="00:00:29" data-left="10" data-top="222" data-show-close-button="yes" data-click-source="alert('This is a javascript function called using the annotations feature of Ultimate Video Player!');" data-click-source-target="_blank" data-normal-state-class="UVPAnnotationJavascriptNormal" data-selected-state-class="UVPAnnotationJavascriptSelected">
							<div><span <span style="font-weight:bold; text-decoration: underline;">JAVASCRIPT</span> support, a javascript function can be called on click.</div>
						</li>

						<li data-start-time="00:00:04" data-end-time="00:00:29" data-left="670" data-top="280" data-normal-state-class="UVPAnnotationCSSNormal">
							<div>
							<p><span style="color:#0099FF; font-familly:myFont; font-weight:bold;">FULL CSS SUPPORT</span></p>
							<p><span style="color:#FFFFFF; font-familly:myFont; font-weight:bold;">OPTIONAL CLOSE BUTTON</span></div></p>
							<p><span style="color:#0099FF; font-familly:myFont; font-weight:bold;">FULL HTML SUPPORT</span></div></p>
							<p>The <span style="color:#0099FF; font-familly:myFont; font-weight:bold; text-decoration: underline;">start</span> / <span style="color:#0099FF; font-familly:myFont; font-weight:bold; text-decoration: underline;">show</span> time and <span style="color:#FFFFFF; font-familly:myFont; font-weight:bold; text-decoration: underline;">end</span> / <span style="color:#FFFFFF; font-familly:myFont; font-weight:bold; text-decoration: underline;">stop</span> time for each annotation can be specified with ease.</p>
						</li>

						<li data-start-time="00:00:32" data-end-time="00:01:06" data-left="590" data-top="98" data-show-close-button="no" data-normal-state-class="UVPAnnotationAPINormal">
							<div>ANNOTATIONS CAN BE USED TO CALL API METHODS!</div>
						</li>

						<li data-start-time="00:00:33" data-end-time="00:01:06" data-left="790" data-top="132" data-show-close-button="no" data-click-source="player1.play();" data-normal-state-class="UVPAnnotationPlayNormal" data-selected-state-class="UVPAnnotationPlaySelected">
							<div>play</div>
						</li>

						<li data-start-time="00:00:34" data-end-time="00:01:06" data-left="790" data-top="177" data-show-close-button="no" data-click-source="player1.pause();" data-normal-state-class="UVPAnnotationPlayNormal" data-selected-state-class="UVPAnnotationPlaySelected">
							<div>pause</div>
						</li>

						<li data-start-time="00:00:35" data-end-time="00:01:06" data-left="790" data-top="222" data-show-close-button="no" data-click-source="player1.scrub(0.6);" data-normal-state-class="UVPAnnotationPlayNormal" data-selected-state-class="UVPAnnotationPlaySelected">
							<div>scrub to 60%</div>
						</li>

						<li data-start-time="00:00:36" data-end-time="00:01:06" data-left="790" data-top="266" data-show-close-button="no" data-click-source="player1.setVolume(0.5);" data-normal-state-class="UVPAnnotationPlayNormal" data-selected-state-class="UVPAnnotationPlaySelected">
							<div>set volume to 50%</div>
						</li>

						<li data-start-time="00:00:37" data-end-time="00:01:06" data-left="790" data-top="310" data-show-close-button="no" data-click-source="player1.goFullScreen();" data-normal-state-class="UVPAnnotationPlayNormal" data-selected-state-class="UVPAnnotationPlaySelected">
							<div>go full screen</div>
						</li>

					</ul>
			</li>


			<li data-thumb-source="content/thumbnails/small-r3dcov.jpg" data-video-source="content/videos/grid.mp4" data-poster-source="content/posters/mp4-poster.jpg,content/posters/mp4-poster-mobile.jpg" data-downloadable="yes">
				<div data-video-short-description="">
					<div>
						<p class="classicDarkThumbnailTitle">ROYAL 3D COVERFLOW</p>
						<p class="minimalDarkThumbnailDesc">Fully responsive 3D Coverflow that allows to display media or HTML content with an unique layout.</p>
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

			<li data-thumb-source="content/thumbnails/small-r3dcar.jpg" data-video-source="[{source:'content/videos2/fwd-480p.mp4', label:'small version'}, {source:'content/videos2/fwd-720p.mp4', label:'hd720'},{source:'content/videos2/fwd-1080p.mp4', label:'hd1080'}]" data-downloadable="yes">
				<div data-video-short-description="">
					<div>
						<p class="classicDarkThumbnailTitle">VIDEO TITLE</p>
						<p class="minimalDarkThumbnailDesc">Each video can contain a short description, the description can be formatted with CSS as you like.</p>
					</div>
				</div>
				<div data-video-long-description="">
					<div>
						<p class="minimalDarkVideoTitleDesc">VIDEO TITLE</p>
						<p class="minimalDarkVideoMainDesc">Each video can contain a detailed description, the description can be formatted with CSS as you like. The description window and description button can be disabled individually for each video or globally for all videos.</p>
						<p class="minimalDarkLink">For more information about this please follow <a href="http://www.webdesign-flash.ro/" target="_blank">this link</a></p>
					</div>
				</div>
				<ul data-cuepoints="">
					<li data-time-start="00:00:10" data-javascript-call="alert('cuepoint called at time: 00:00:10');"></li>
					<li data-time-start="00:00:20" data-javascript-call="alert('cuepoint called at time: 00:00:20');"></li>
				</ul>
			</li>

			<li data-thumb-source="content/thumbnails/small-msp.jpg" data-video-source="content/videos2/fwd-1080p.mp4" data-poster-source="content/posters/mp4-poster.jpg,content/posters/mp4-poster-mobile.jpg" data-is-private="yes" data-private-video-password="428c841430ea18a70f7b06525d4b748a">
				<div data-video-short-description="">
					<div>
						<p class="minimalDarkThumbnailTitle">PRIVATE VIDEO EXAMPLE</p>
						<p class="minimalDarkThumbnailDesc">Support for private videos.</p>
					</div>
				</div>
				<div data-video-long-description="">
					<div>
						<p class="minimalDarkVideoTitleDesc">MP3 STICKY PLAYER</p>
						<p class="minimalDarkVideoMainDesc">Each video can contain a detailed description, the description can be formatted with CSS as you like. The description window and description button can be disabled individually for each video or globally for all videos.</p>
						<p class="minimalDarkLink">For more information about this please follow <a href="http://www.webdesign-flash.ro/p/msp/" target="_blank">this link</a></p>
					</div>
				</div>
			</li>

			<li data-thumb-source="content/thumbnails/small-rap.jpg" data-video-source="content/videos2/fwd-1080p.mp4" data-poster-source="content/posters/mp4-poster.jpg,content/posters/mp4-poster-mobile.jpg" data-start-at-time="00:00:10" data-stop-at-time="00:00:40">
				<div data-video-short-description="">
					<div>
						<p class="minimalDarkThumbnailTitle">START / STOP AT TIME EXAMPLE</p>
						<p class="minimalDarkThumbnailDesc">UVP can be set to start or / and stop at a specified time.</p>
					</div>
				</div>
				<div data-video-long-description="">
					<div>
						<p class="minimalDarkVideoTitleDesc">MP3 STICKY PLAYER</p>
						<p class="minimalDarkVideoMainDesc">Each video can contain a detailed description, the description can be formatted with CSS as you like. The description window and description button can be disabled individually for each video or globally for all videos.</p>
						<p class="minimalDarkLink">For more information about this please follow <a href="http://www.webdesign-flash.ro/p/msp/" target="_blank">this link</a></p>
					</div>
				</div>
			</li>

			<li data-thumb-source="content/thumbnails/small-rap.jpg" data-video-source="content/videos2/fwd-1080p.mp4" data-poster-source="content/posters/mp4-poster.jpg,content/posters/mp4-poster-mobile.jpg" data-advertisement-on-pause-source="http://www.webdesign-flash.ro/iframe.html">
				<div data-video-short-description="">
					<div>
						<p class="minimalDarkThumbnailTitle">ADVERTISEMENT WINDOW ON PAUSE EXAMPLE</p>
						<p class="minimalDarkThumbnailDesc">The source can be any webpage.</p>
					</div>
				</div>

			</li>

			<li data-thumb-source="content/thumbnails/small-s3dcov.jpg" data-video-source="content/videos2/fwd-1080p.mp4" data-poster-source="content/posters/mp4-poster.jpg,content/posters/mp4-poster-mobile.jpg" data-downloadable="no" data-vast-url="content/vast-pod.xml" data-vast-clicktrough-target="_blank" data-vast-linear-astart-at-time="00:00:00">
				<div data-video-short-description="">
					<div>
						<p class="classicDarkThumbnailTitle">VAST XML EXAMPLE</p>
						<p class="minimalDarkThumbnailDesc">Support for VAST <span style='color:#FFFFFF'> "Video Ad Serving Template"</span> pre-roll, mid-roll, post roll with unique functionality.</p>
					</div>
				</div>
				<div data-video-long-description="">
					<div>
						<p class="classicDarkThumbnailTitle">VAST XML EXAMPLE</p>
						<p class="minimalDarkVideoMainDesc">Each video can contain a detailed description, the description can be formatted with CSS as you like. The description window and description button can be disabled individually for each video or globally for all videos.</p>
						<p class="minimalDarkLink">For more information about this please follow <a href="http://www.webdesign-flash.ro/p/s3dcov/" target="_blank">this link</a></p>
					</div>
				</div>
			</li>

		</ul>

		<!--  HTML mixed playlist -->
		<ul id="mixedPlaylist" style="display:none;">
				<li data-thumb-source="content/thumbnails/small-fwd.jpg" data-video-source="[{source:'content/videos2/fwd-480p.mp4', label:'small version'}, {source:'content/videos2/fwd-720p.mp4', label:'hd720'},{source:'content/videos2/fwd-1080p.mp4', label:'hd1080'}]" data-start-at-video="2" data-poster-source="content/posters/mp4-poster.jpg,content/posters/mp4-poster-mobile.jpg" data-subtitle-soruce="[{source:'content/english_subtitle.txt', label:'English'}, {source:'content/romanian_subtitle.txt', label:'Romanian'},{source:'content/spanish_subtitle.txt', label:'Spanish'}]"  data-start-at-subtitle="2" data-downloadable="no">
					<div data-video-short-description="">
						<div>
							<p class="classicDarkThumbnailTitle">VIDEO TITLE</p>
							<p class="minimalDarkThumbnailDesc">Each video can contain a short description, the description can be formatted with CSS as you like.</p>
						</div>
					</div>
					<div data-video-long-description="">
						<div>
							<p class="minimalDarkVideoTitleDesc">VIDEO TITLE</p>
							<p class="minimalDarkVideoMainDesc">Each video can contain a detailed description, the description can be formatted with CSS as you like. The description window and description button can be disabled individually for each video or globally for all videos.</p>
							<p class="minimalDarkLink">For more information about this please follow <a href="http://www.webdesign-flash.ro/" target="_blank">this link</a></p>
						</div>
					</div>
				</li>

				<li data-thumb-source="content/thumbnails/small-lora.jpg" data-video-source="https://www.youtube.com/watch?v=oIHyVibVwVA" data-poster-source="content/posters/youtube-poster.jpg,content/posters/youtube-poster-mobile.jpg" data-downloadable="no">
					<div data-video-short-description="">
						<div>
							<p class="classicDarkThumbnailTitle">LORA PUISOR</p>
							<p class="minimalDarkThumbnailDesc">Each video can contain a short description, the description can be formatted with CSS as you like.</p>
						</div>
					</div>
					<div data-video-long-description="">
						<div>
							<p class="minimalDarkVideoTitleDesc">LORA - PUISOR</p>
							<p class="minimalDarkVideoMainDesc">Each video can contain a detailed description, the description can be formatted with CSS as you like. The description window and description button can be disabled individually for each video or globally for all videos.</p>
							<p class="minimalDarkLink">For more information about this please follow <a href="http://www.webdesign-flash.ro/" target="_blank">this link</a></p>
						</div>
					</div>
				</li>

				<li data-thumb-source="content/thumbnails/v1.jpg" data-video-source="https://vimeo.com/channels/top/62092214" data-poster-source="content/posters/vimeo-poster.jpg,content/posters/vimeo-poster-mobile.jpg">
					<div data-video-short-description="">
						<div>
							<p class="classicDarkThumbnailTitle">BITING ELBOWS</p>
							<p class="minimalDarkThumbnailDesc">Support 'Hardcore' - the spiritual sequel to Bad Motherfucker on Indiegogo.</p>
						</div>
					</div>
					<div data-video-long-description="">
						<div>
							<p class="minimalDarkVideoTitleDesc">BITING ELBOWS</p>
							<p class="minimalDarkVideoMainDesc">Each video can contain a detailed description, the description can be formatted with CSS as you like. The description window and description button can be disabled individually for each video or globally for all videos.</p>
							<p class="minimalDarkLink">For more information about this please follow <a href="http://www.webdesign-flash.ro/" target="_blank">this link</a></p>
						</div>
					</div>
				</li>
			</ul>

		<!--  HTML vimeo playlist -->
		<ul id="vimeoPlaylist" style="display:none;">
				<li data-thumb-source="content/thumbnails/v1.jpg" data-video-source="https://vimeo.com/channels/top/62092214" data-poster-source="content/posters/vimeo-poster.jpg,content/posters/vimeo-poster-mobile.jpg">
					<div data-video-short-description="">
						<div>
							<p class="classicDarkThumbnailTitle">BITING ELBOWS</p>
							<p class="minimalDarkThumbnailDesc">Support 'Hardcore' - the spiritual sequel to Bad Motherfucker on Indiegogo.</p>
						</div>
					</div>
					<div data-video-long-description="">
						<div>
							<p class="minimalDarkVideoTitleDesc">BITING ELBOWS</p>
							<p class="minimalDarkVideoMainDesc">Each video can contain a detailed description, the description can be formatted with CSS as you like. The description window and description button can be disabled individually for each video or globally for all videos.</p>
							<p class="minimalDarkLink">For more information about this please follow <a href="http://www.webdesign-flash.ro/" target="_blank">this link</a></p>
						</div>
					</div>
				</li>

				<li data-thumb-source="content/thumbnails/v2.jpg" data-video-source="https://vimeo.com/channels/top/22439234" data-poster-source="content/posters/vimeo-poster.jpg,content/posters/vimeo-poster-mobile.jpg">
					<div data-video-short-description="">
						<div>
							<p class="classicDarkThumbnailTitle">THE MOUNTAIN</p>
							<p class="minimalDarkThumbnailDesc">This was filmed between 4th and 11th April 2011. I had the pleasure of visiting El Teide.</p>
						</div>
					</div>
					<div data-video-long-description="">
						<div>
							<p class="minimalDarkVideoTitleDesc">THE MOUNTAIN</p>
							<p class="minimalDarkVideoMainDesc">Each video can contain a detailed description, the description can be formatted with CSS as you like. The description window and description button can be disabled individually for each video or globally for all videos.</p>
							<p class="minimalDarkLink">For more information about this please follow <a href="http://www.webdesign-flash.ro/" target="_blank">this link</a></p>
						</div>
					</div>
				</li>
			</ul>


@endforeach
@section('script')
  <script>
        FWDUVPUtils.onReady(function(){

            new FWDUVPlayer({

            //main settings
            instanceName:"player1",
            parentId:"myDiv",
            playlistsId:"playlists",
            mainFolderPath:"http://localhost/nexthour/public/content",
            skinPath:"minimal_skin_dark",
            displayType:"responsive",
            initializeOnlyWhenVisible:"no",
            useVectorIcons:"no",
            fillEntireVideoScreen:"no",
            useHEXColorsForSkin:"no",
            normalHEXButtonsColor:"#FF0000",
            selectedHEXButtonsColor:"#000000",
            useDeepLinking:"yes",
            rightClickContextMenu:"default",
            addKeyboardSupport:"yes",
            showPreloader:"yes",
            preloaderBackgroundColor:"#000000",
            preloaderFillColor:"#FFFFFF",
            autoScale:"yes",
            useResumeOnPlay:"yes",
            showButtonsToolTip:"yes",
            stopVideoWhenPlayComplete:"no",
            playAfterVideoStop:"no",
            autoPlay:"no",
            loop:"no",
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
            showLogo:"yes",
            hideLogoWithController:"yes",
            logoPosition:"topRight",
            logoLink:"http://www.webdesign-flash.ro/",
            logoMargins:5,
            //playlists/categories settings
            showPlaylistsSearchInput:"no",
            usePlaylistsSelectBox:"no",
            showPlaylistsButtonAndPlaylists:"no",
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
            showPlaylistByDefault:"no",
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
            showDownloadButton:"yes",
            showFacebookButton:"yes",
            showEmbedButton:"yes",
            showFullScreenButton:"yes",
            disableVideoScrubber:"no",
            showDefaultControllerForVimeo:"no",
            showMainScrubberToolTipLabel:"yes",
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
            //loggin
            isLoggedIn:"no",
            playVideoOnlyWhenLoggedIn:"no",
            loggedInMessage:"Please login to view this video.",
            //playback rate / speed
            defaultPlaybackRate:1, //0.25, 0.5, 1, 1.25, 1.2, 2
            //cuepoints
            executeCuepointsOnlyOnce:"no",
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
            atbTimeTextColorSelected:"#000000",
            atbButtonTextNormalColor:"#FFFFFF",
            atbButtonTextSelectedColor:"#FFFFFF",
            atbButtonBackgroundNormalColor:"#888888",
            atbButtonBackgroundSelectedColor:"#000000"
            });
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
@endsection
