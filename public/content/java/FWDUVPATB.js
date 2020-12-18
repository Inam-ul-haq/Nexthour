/* FWDUVPATB */
(function (window){
var FWDUVPATB = function(
		controller
		){
		var self = this;
		var prototype = FWDUVPATB.prototype;

		self.useHEXColorsForSkin_bl = controller.useHEXColorsForSkin_bl;
		self.main = controller.parent;
		self.timeBackgroundColor = controller.data.atbTimeBackgroundColor;
		self.timeTextColorNormal = controller.data.atbTimeTextColorNormal;
		self.timeTextColorSelected = controller.data.atbTimeTextColorSelected;
		self.buttonTextNormalColor = controller.data.atbButtonTextNormalColor;
		self.buttonTextSelectedColor = controller.data.atbButtonTextSelectedColor;
		self.buttonBackgroundNormalColor = controller.data.atbButtonBackgroundNormalColor;
		self.buttonBackgroundSelectedColor = controller.data.atbButtonBackgroundSelectedColor;
		this.isMobile_bl = FWDUVPUtils.isMobile;
		self.pa = 0;
		self.pb = 1;
	
		//##########################################//
		/* initialize self */
		//##########################################//
		self.init = function(){
			self.setOverflow("visible");
			self.mainHolder_do = new FWDUVPDisplayObject("div");
			self.addChild(self.mainHolder_do);
			if(controller.repeatBackground_bl){
				self.mainHolder_do.getStyle().background = "url('" + controller.controllerBkPath_str +  "')";
			}else{
				self.bk_do = new FWDUVPDisplayObject("img");
				var img = new Image();
				img.src = controller.controllerBkPath_str;
				self.bk_do.setScreen(img);
				self.mainHolder_do.addChild(self.bk_do);
			}
			self.setupLeftAndRight();
			self.setupMainScrubber();
		};

		self.resize = function(){
			self.setWidth(controller.stageWidth);
			self.setHeight(controller.stageHeight);
			self.mainHolder_do.setWidth(controller.stageWidth);
			self.mainHolder_do.setHeight(controller.stageHeight);

			if(self.bk_do){
				self.bk_do.setWidth(controller.stageWidth);
				self.bk_do.setHeight(controller.stageHeight);
			}
			if(self.isShowed_bl){
				var offset = 0;
				if(controller.isMainScrubberOnTop_bl) offset += controller.mainScrubber_do.h - controller.mainScrubberOffestTop - 1;
				self.mainHolder_do.setY(-self.h - 1 - offset);
			}
			
			self.positionText();
			self.positionButtons();
			self.resizeProgress();
			self.resizeMainScrubber();
		}

		self.setupLeftAndRight = function(){

			self.leftText_do = new FWDUVPDisplayObject("div");
			self.leftText_do.hasTransform3d_bl = false;
			self.leftText_do.hasTransform2d_bl = false;
			self.leftText_do.setBackfaceVisibility();
			self.leftText_do.getStyle().fontFamily = "Arial";
			self.leftText_do.getStyle().fontSize= "12px";
			self.leftText_do.getStyle().whiteSpace= "nowrap";
			self.leftText_do.getStyle().textAlign = "center";
			self.leftText_do.getStyle().padding = "4px";
			self.leftText_do.getStyle().paddingLeft = "4px";
			self.leftText_do.getStyle().paddingRIght = "4px";
			self.leftText_do.getStyle().color = self.timeTextColorNormal;
			self.leftText_do.getStyle().backgroundColor = self.timeBackgroundColor;
			self.leftText_do.getStyle().fontSmoothing = "antialiased";
			self.leftText_do.getStyle().webkitFontSmoothing = "antialiased";
			self.leftText_do.getStyle().textRendering = "optimizeLegibility";
			self.leftText_do.setInnerHTML("00:00");
			self.mainHolder_do.addChild(self.leftText_do);

			self.rightText_do = new FWDUVPDisplayObject("div");
			self.rightText_do.hasTransform3d_bl = false;
			self.rightText_do.hasTransform2d_bl = false;
			self.rightText_do.setBackfaceVisibility();
			self.rightText_do.getStyle().fontFamily = "Arial";
			self.rightText_do.getStyle().fontSize= "12px";
			self.rightText_do.getStyle().whiteSpace= "nowrap";
			self.rightText_do.getStyle().textAlign = "center";
			self.rightText_do.getStyle().padding = "4px";
			self.rightText_do.getStyle().paddingLeft = "6px";
			self.rightText_do.getStyle().paddingRIght = "6px";
			self.rightText_do.getStyle().color = self.timeTextColorNormal;
			self.rightText_do.getStyle().backgroundColor = self.timeBackgroundColor;
			self.rightText_do.getStyle().fontSmoothing = "antialiased";
			self.rightText_do.getStyle().webkitFontSmoothing = "antialiased";
			self.rightText_do.getStyle().textRendering = "optimizeLegibility";
			self.rightText_do.setInnerHTML("00:00");
			self.mainHolder_do.addChild(self.rightText_do);
		}
		

		self.setLeftLabel = function(label){
			self.leftText_do.setInnerHTML(label);
		}

		self.setRightLabel = function(label){
			self.rightText_do.setInnerHTML(label);
		}

		self.setupInitLabels = function(){
			self.pa = 0;
			self.pb = 1;
			self.updateTime();
			self.positionText();
			setTimeout(self.positionText, 300);
		}

		self.updateTime = function(){
			var hasHours = FWDUVPUtils.formatTime(self.duration).length > 5;
			var totalTime = FWDUVPUtils.formatTime(self.duration);
			self.rightTime = FWDUVPUtils.formatTime(self.duration * self.pb);
			self.leftTime = FWDUVPUtils.formatTime(self.duration * self.pa);
			if(self.rightTime.length < 6 && hasHours) self.rightTime = "00:" + self.rightTime; 

			if(self.rightTime.length > 5 && self.leftTime.length < 6) self.leftTime = "00:" + self.leftTime;
			self.setLeftLabel(self.leftTime);
			self.setRightLabel(self.rightTime);
		}

		self.positionText = function(){
			self.leftText_do.setX(controller.startSpaceBetweenButtons);
			self.leftText_do.setY(Math.round((controller.stageHeight - self.leftText_do.getHeight())/2));
			self.rightText_do.setX(controller.stageWidth - controller.startSpaceBetweenButtons - self.rightText_do.getWidth());
			self.rightText_do.setY(Math.round((controller.stageHeight - self.rightText_do.getHeight())/2));
		}

		//################################################//
		/* Setup main scrubber */
		//################################################//
		this.setupMainScrubber = function(){
			//setup background bar
			self.mainScrubber_do = new FWDUVPDisplayObject("div");
			self.mainScrubber_do.setOverflow('visible');
			self.mainScrubber_do.setY(parseInt((controller.stageHeight - controller.mainScrubberHeight)/2));
			self.mainScrubber_do.setHeight(controller.mainScrubberHeight);
		
			var mainScrubberBkLeft_img = new Image();
			mainScrubberBkLeft_img.src = controller.mainScrubberBkLeft_img.src;
			mainScrubberBkLeft_img.width = controller.mainScrubberBkLeft_img.width;
			mainScrubberBkLeft_img.height = controller.mainScrubberBkLeft_img.height;
			self.mainScrubberBkleftText_do = new FWDUVPDisplayObject("img");
			self.mainScrubberBkleftText_do.setScreen(mainScrubberBkLeft_img);

			var rightImage = new Image();
			rightImage.src = controller.data.mainScrubberBkRightPath_str;
			self.mainScrubberBkrightText_do = new FWDUVPDisplayObject("img");
			self.mainScrubberBkrightText_do.setScreen(rightImage);
			self.mainScrubberBkrightText_do.setWidth(self.mainScrubberBkleftText_do.w);
			self.mainScrubberBkrightText_do.setHeight(self.mainScrubberBkleftText_do.h);
			
			var middleImage = new Image();
			middleImage.src = controller.mainScrubberBkMiddlePath_str;
			if(self.isMobile_bl){
				self.mainScrubberBkMiddle_do = new FWDUVPDisplayObject("div");	
				self.mainScrubberBkMiddle_do.getStyle().background = "url('" + controller.mainScrubberBkMiddlePath_str + "') repeat-x";
			}else{
				self.mainScrubberBkMiddle_do = new FWDUVPDisplayObject("img");
				self.mainScrubberBkMiddle_do.setScreen(middleImage);
			}
				
			self.mainScrubberBkMiddle_do.setHeight(controller.mainScrubberHeight);
			self.mainScrubberBkMiddle_do.setX(controller.scrubbersBkLeftAndRightWidth);

			self.mainScrubber_do.addChild(self.mainScrubberBkleftText_do);
			self.mainScrubber_do.addChild(self.mainScrubberBkMiddle_do);
			self.mainScrubber_do.addChild(self.mainScrubberBkrightText_do);
			self.mainHolder_do.addChild(self.mainScrubber_do);

			//setup progress bar
			self.mainScrubberDrag_do = new FWDUVPDisplayObject("div");
			self.mainScrubberDrag_do.setHeight(controller.mainScrubberHeight);
			
			self.mainScrubberMiddleImage = new Image();
			self.mainScrubberMiddleImage.src = controller.mainScrubberDragMiddlePath_str;
			
			if(self.useHEXColorsForSkin_bl){
				self.mainScrubberDragMiddle_do = new FWDUVPDisplayObject("div");
				self.mainScrubberMiddleImage.onload = function(){
					var testCanvas = FWDUVPUtils.getCanvasWithModifiedColor(self.mainScrubberMiddleImage, controller.normalButtonsColor_str, true);
					self.mainSCrubberMiddleCanvas = testCanvas.canvas;
					self.mainSCrubberDragMiddleImageBackground = testCanvas.image;
					self.mainScrubberDragMiddle_do.getStyle().background = "url('" + self.mainSCrubberDragMiddleImageBackground.src + "') repeat-x";
				}
			}else{
				self.mainScrubberDragMiddle_do = new FWDUVPDisplayObject("div");	
				self.mainScrubberDragMiddle_do.getStyle().background = "url('" + controller.mainScrubberDragMiddlePath_str + "') repeat-x";
			}
		
			self.mainScrubberDragMiddle_do.setHeight(controller.mainScrubberHeight);
			self.mainScrubber_do.addChild(self.mainScrubberDragMiddle_do);
			

			// Setup a to b loop buttons
			FWDUVPTextButton.setPrototype();
			self.left_do = new FWDUVPTextButton(
				'A',
				 self.buttonTextNormalColor,
				 self.buttonTextSelectedColor,
				 self.buttonBackgroundNormalColor,
				 self.buttonBackgroundSelectedColor,
				 controller.data.handPath_str,
				 controller.data.grabPath_str
				 );
			self.mainScrubber_do.addChild(self.left_do);
			self.left_do.addListener(FWDUVPTextButton.MOUSE_DOWN, self.aDown);
			self.left_do.addListener(FWDUVPTextButton.MOUSE_UP, self.aUp);

			FWDUVPTextButton.setPrototype();
			self.right_do = new FWDUVPTextButton(
				'B',
				 self.buttonTextNormalColor,
				 self.buttonTextSelectedColor,
				 self.buttonBackgroundNormalColor,
				 self.buttonBackgroundSelectedColor,
				 controller.data.handPath_str,
				 controller.data.grabPath_str
				 );
			self.mainScrubber_do.addChild(self.right_do);
			self.right_do.addListener(FWDUVPTextButton.MOUSE_DOWN, self.bDown);
			self.right_do.addListener(FWDUVPTextButton.MOUSE_UP, self.bUp);
		}

		self.bDown = function(e){
			self.scrub = true
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e.e);	
			self.lastPresedX = vc.screenX;
			self.leftXPositionOnPress = self.right_do.getX();
			if(self.isMobile_bl){
				window.addEventListener("touchmove", self.bMoveHandler);
			}else{
				window.addEventListener("mousemove", self.bMoveHandler);
			}
			FWDAnimation.to(self.rightText_do.screen, .8, {css:{color:self.timeTextColorSelected}, ease:Expo.easeOut});
			self.dispatchEvent(FWDUVPATB.START_TO_SCRUB);
		}

		self.bUp = function(e){
			self.scrub = false;
			if(self.isMobile_bl){
				window.removeEventListener("touchmove", self.bMoveHandler);
			}else{
				window.removeEventListener("mousemove", self.bMoveHandler);
			}
			FWDAnimation.to(self.rightText_do.screen, .8, {css:{color:self.timeTextColorNormal}, ease:Expo.easeOut});
			self.dispatchEvent(FWDUVPATB.STOP_TO_SCRUB);
		}

		self.bMoveHandler = function(e){
			if(e.preventDefault) e.preventDefault();
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			self.finalHandlerX = Math.round(self.leftXPositionOnPress + vc.screenX - self.lastPresedX);
			if(self.finalHandlerX <= Math.round(self.left_do.x + self.left_do.getWidth() + 2)){
				self.finalHandlerX = Math.round(self.left_do.x + self.left_do.getWidth() + 2);
			}else if(self.finalHandlerX > self.mainScrubber_do.w - self.right_do.getWidth()){
				self.finalHandlerX = self.mainScrubber_do.w - self.right_do.getWidth();
			}
			self.right_do.setX(self.finalHandlerX);
			self.pb = self.right_do.x/(self.mainScrubber_do.w - self.right_do.getWidth());
			self.updateTime();
			self.resizeProgress();
		}

		self.aDown = function(e){
			self.scrub = true;
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e.e);	
			self.lastPresedX = vc.screenX;
			self.leftXPositionOnPress = self.left_do.getX();
			if(self.isMobile_bl){
				window.addEventListener("touchmove", self.aMoveHandler);
			}else{
				window.addEventListener("mousemove", self.aMoveHandler);
			}
			FWDAnimation.to(self.leftText_do.screen, .8, {css:{color:self.timeTextColorSelected}, ease:Expo.easeOut});
			self.dispatchEvent(FWDUVPATB.START_TO_SCRUB);
		}

		self.aUp = function(e){
			self.scrub = false;
			if(self.isMobile_bl){
				window.removeEventListener("touchmove", self.aMoveHandler);
			}else{
				window.removeEventListener("mousemove", self.aMoveHandler);
			}
			FWDAnimation.to(self.leftText_do.screen, .8, {css:{color:self.timeTextColorNormal}, ease:Expo.easeOut});
			self.dispatchEvent(FWDUVPATB.STOP_TO_SCRUB);
		}

		self.aMoveHandler = function(e){
			if(e.preventDefault) e.preventDefault();
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			self.finalHandlerX = Math.round(self.leftXPositionOnPress + vc.screenX - self.lastPresedX);
			if(self.finalHandlerX <= 0){
				self.finalHandlerX = 0;
			}else if(self.finalHandlerX > Math.round(self.right_do.x - self.left_do.getWidth() - 2)){
				self.finalHandlerX = Math.round(self.right_do.x - self.left_do.getWidth() - 2);
			}
			self.left_do.setX(self.finalHandlerX);
			self.pa = self.left_do.x/self.mainScrubber_do.w;
			self.updateTime();
			self.resizeProgress();
		}

		this.resizeMainScrubber = function(){
			self.mainScrubberWidth = controller.stageWidth - controller.startSpaceBetweenButtons * 6 - self.leftText_do.getWidth() - self.rightText_do.getWidth();
			self.mainScrubber_do.setWidth(self.mainScrubberWidth);
			self.mainScrubber_do.setX(self.leftText_do.getWidth() + controller.startSpaceBetweenButtons * 3);
			self.mainScrubber_do.setY(parseInt((controller.stageHeight - controller.mainScrubberHeight)/2));
			self.mainScrubberBkMiddle_do.setWidth(self.mainScrubberWidth - controller.scrubbersBkLeftAndRightWidth * 2);
			self.mainScrubberBkrightText_do.setX(self.mainScrubberWidth - controller.scrubbersBkLeftAndRightWidth);
		}

		self.positionButtons = function(){
			self.left_do.setX(self.pa * self.mainScrubber_do.w);
			self.right_do.setX(self.pb * (self.mainScrubber_do.w - self.right_do.getWidth()));
		}

		self.resizeProgress = function(){
			self.mainScrubberDragMiddle_do.setX(self.left_do.x + self.left_do.getWidth() + 1);
			self.mainScrubberDragMiddle_do.setWidth(self.right_do.x - (self.left_do.x + self.left_do.getWidth() + 2));
		}

		//################################################//
		/* Hide and show */
		//################################################//
		this.show = function(animate){
			if(self.isShowed_bl) return;
			self.duration = self.main.totalTimeInSeconds;
			self.setupInitLabels();
			
			self.positionText();
			self.positionButtons();
			self.resizeProgress();
			self.resizeMainScrubber();
			setTimeout(function(){
				self.positionText();
				self.positionButtons();
				self.resizeProgress();
				self.resizeMainScrubber();
			}, 300);
			self.isShowed_bl = true;
			var offset = 0;
			if(controller.isMainScrubberOnTop_bl) offset += controller.mainScrubber_do.h - controller.mainScrubberOffestTop - 1;
			if(animate){
				FWDAnimation.to(self.mainHolder_do, .8, {y:-self.h - 1 - offset, ease:Expo.easeInOut});
			}else{
				FWDAnimation.killTweensOf(self.mainHolder_do);
				self.mainHolder_do.setY(-self.h - 1);
			}
			setTimeout(self.positionButtons, 200);
			
		};

		this.hide = function(animate){
			if(!self.isShowed_bl) return;
			self.isShowed_bl = false;
			if(animate){
				FWDAnimation.to(self.mainHolder_do, .8, {y:0, ease:Expo.easeInOut});
			}else{
				FWDAnimation.killTweensOf(self.mainHolder_do);
				self.mainHolder_do.setY(0);
			}
			setTimeout(self.positionButtons, 200);
		};
	
		
		self.init();
	};
	
	/* set prototype */
	FWDUVPATB.setPrototype = function(){
		FWDUVPATB.prototype = null;
		FWDUVPATB.prototype = new FWDUVPTransformDisplayObject("div");
	};

	FWDUVPATB.START_TO_SCRUB = "startToScrub";
	FWDUVPATB.SCRUB = "scrub";
	FWDUVPATB.STOP_TO_SCRUB = "stopToScrub";

	FWDUVPATB.prototype = null;
	window.FWDUVPATB = FWDUVPATB;
}(window));

/* FWDUVPTextButton */
(function (window){
var FWDUVPTextButton = function(
		label,
		colorN,
		colorS,
		bkColorN,
		bkColorS,
		cursor,
		cursor2
		){
		
		var self = this;
		var prototype = FWDUVPTextButton.prototype;
		
		this.nImg_img = null;
		this.sImg_img = null;
		
		this.dumy_do = null;
		this.cursor = cursor;
		this.cursor2 = cursor2;
	
		this.label_str = label;
		this.colorN_str = colorN;	
		this.colorS_str = colorS;
		this.bkColorN_str = bkColorN;
		this.bkColorS_str = bkColorS;
	
		this.isDisabled_bl = false;
		this.isMobile_bl = FWDUVPUtils.isMobile;
		
		//##########################################//
		/* initialize this */
		//##########################################//
		this.init = function(){
			self.setupMainContainers();
			
		};
		
		//##########################################//
		/* setup main containers */
		//##########################################//
		this.setupMainContainers = function(){
			
			self.hasTransform3d_bl = false;
			self.hasTransform2d_bl = false;
			self.setBackfaceVisibility();
			self.getStyle().display = "inline-block";
			self.getStyle().clear = "both";
			self.getStyle().fontFamily = "Arial";
			self.getStyle().fontSize= "12px";
			self.getStyle().whiteSpace= "nowrap";
			self.getStyle().padding = "3px 4px";
			self.getStyle().color = self.colorN_str;
			self.getStyle().backgroundColor = self.bkColorN_str;
			self.getStyle().fontSmoothing = "antialiased";
			self.getStyle().webkitFontSmoothing = "antialiased";
			self.getStyle().textRendering = "optimizeLegibility";	
			self.setInnerHTML(self.label_str);
			
			self.dumy_do = new FWDUVPDisplayObject("div");
			if(FWDUVPUtils.isIE){
				self.dumy_do.setBkColor("#00FF00");
				self.dumy_do.setAlpha(0.0001);
			}
			self.dumy_do.getStyle().cursor = 'grab';
			self.dumy_do.getStyle().width = "100%";
			self.dumy_do.getStyle().height = "50px";
			self.addChild(self.dumy_do);
			
			if(self.hasPointerEvent_bl){
				self.screen.addEventListener("pointerup", self.onMouseUp);
				self.screen.addEventListener("pointerover", self.onMouseOver);
				self.screen.addEventListener("pointerout", self.onMouseOut);
			}else if(self.screen.addEventListener){	
				if(!self.isMobile_bl){
					self.screen.addEventListener("mouseover", self.onMouseOver);
					self.screen.addEventListener("mouseout", self.onMouseOut);
					self.screen.addEventListener("mousedown", self.onMouseDown);
				}
				self.screen.addEventListener("touchstart", self.onMouseDown);
			}
		};
		
		this.onMouseOver = function(e){
			if(self.isDisabled_bl) return;
			self.setSelectedState();
		};
			
		this.onMouseOut = function(e){
			if(self.isDisabled_bl || self.grabed) return;
			self.setNormalState();
		};


		this.onMouseDown = function(e){
			if(self.isDisabled_bl) return;
		
			self.grabed = true;
			if(!self.isMobile_bl){
				window.addEventListener('mouseup', self.checkUp)
			}else{
				window.addEventListener('touchend', self.checkUp)
			}
			self.dumy_do.getStyle().cursor = 'grabbing';
			document.getElementsByTagName("body")[0].style.cursor = 'grabbing';

			self.dispatchEvent(FWDUVPTextButton.MOUSE_DOWN, {e:e});
		};

		this.checkUp = function(e){
			var vc = FWDUVPUtils.getViewportMouseCoordinates(e);	
			if(!FWDUVPUtils.hitTest(self.screen, vc.screenX, vc.screenY)){
				self.setNormalState();	
				if(!self.isMobile_bl){
					window.removeEventListener('mouseup', self.checkUp);
				}else{
					window.addEventListener('touchend', self.checkUp);
				}
			}
			self.grabed = false;
			self.dumy_do.getStyle().cursor = 'grab';
			document.getElementsByTagName("body")[0].style.cursor = 'auto';
			self.dispatchEvent(FWDUVPTextButton.MOUSE_UP);
		}

		//####################################//
		/* Set normal / selected state */
		//####################################//
		this.setNormalState = function(animate){
			FWDAnimation.to(self.screen, .8, {css:{color:self.colorN_str, backgroundColor:self.bkColorN_str}, ease:Expo.easeOut});
		};
		
		this.setSelectedState = function(animate){
			FWDAnimation.to(self.screen, .8, {css:{color:self.colorS_str, backgroundColor:self.bkColorS_str}, ease:Expo.easeOut});
		};

		this.disable = function(){
			this.onMouseOver();
			this.dumy_do.setButtonMode(false);
			FWDAnimation.to(self, .8, {alpha:.4, ease:Expo.easeOut});
			this.isDisabled_bl = true;
		}
		
		this.enable = function(){
			this.isDisabled_bl = false;
			this.onMouseOut();
			this.dumy_do.setButtonMode(true);
			FWDAnimation.to(self, .8, {alpha:1, ease:Expo.easeOut});
			
		}
		
	
		self.init();
	};
	
	/* set prototype */
	FWDUVPTextButton.setPrototype = function(){
		FWDUVPTextButton.prototype = null;
		FWDUVPTextButton.prototype = new FWDUVPDisplayObject("div");
	};
	
	FWDUVPTextButton.MOUSE_UP = 'mouseUp';
	FWDUVPTextButton.MOUSE_DOWN = 'mouseDown';
	
	FWDUVPTextButton.prototype = null;
	window.FWDUVPTextButton = FWDUVPTextButton;
}(window));