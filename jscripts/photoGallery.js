var gallerySize = 'small';
var galleryCurrentIndex = 0;
var gallerySlideshow = false;
var galleryInterval = 3000;// millisec of photo changing interval
var galleryIntervalFade = 800;// millisec of fading interval
var galleryCenterHorz = ($(window).width()) / 2;
var galleryCenterVert = ($(window).height() - 64) / 2;

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
$(document).keyup(function(e){
	// bind escape key to close photo popup
	if(e.keyCode === 27){
		galleryClose();
	}
	// left arrow = prev()
	if(e.keyCode === 37){
		galleryPrev();
	}
	// right arrow = next()
	if(e.keyCode === 39){
		galleryNext();
	}
});

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
function galleryClose(){
	// restore body scrollbars
	document.body.style.overflow = 'scroll'; 

	// hide photo viewer
	$("div#photoGalleryPopup").hide();
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
function fadeInImage(imgSrc){
	$("img#photoGalleryImagePreload").attr('src', imgSrc);// preload the image

	//find sizes of image to determine wider or taller
	thisImgWidth  = $("img#photoGalleryImagePreload").width();
	thisImgHeight = $("img#photoGalleryImagePreload").height();

	if (thisImgWidth > thisImgHeight){// wide photos
		newTop  = galleryCenterVert - 240;
		newLeft = galleryCenterHorz - 320;
	}else{// tall photos
		newTop  = galleryCenterVert - 320;
		newLeft = galleryCenterHorz - 240;
	}

	// move the preload image
	$("img#photoGalleryImagePreload").css('top',  newTop);
	$("img#photoGalleryImagePreload").css('left', newLeft);

	// fade out the previous image, which blends in the one below
	$("img#photoGalleryImage").fadeOut(galleryIntervalFade);
	$("img#photoGalleryImagePreload").fadeIn(galleryIntervalFade);

	// after the fade-in above...
	setTimeout(
		function(){
			// display actual image change now
			// not sure why, but show() doesnt work, HAVE to use fadeIn(0)...
			$("img#photoGalleryImage").fadeIn(galleryIntervalFade);
			$("img#photoGalleryImage").attr('src', imgSrc);
			// set the matching caption
			$("div#photoGalleryImageCaption").html(arrGalleryCaptions[galleryCurrentIndex]);
			// position the regular image now
			$("img#photoGalleryImage").css('top',  newTop);
			$("img#photoGalleryImage").css('left', newLeft);
		},
		galleryIntervalFade
	);
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
function setGallerySize(strTo){
	gallerySize = strTo;

	if (strTo == 'large'){
		$('div#photoGalleryImageContainer').css('height', '640px');
		$('div#photoGalleryImageContainer').css('width',  '640px');

		$('input#btnGallerySmall').show();
		$('input#btnGalleryLarge').hide();
	}else if (strTo == 'small'){
		$('div#photoGalleryImageContainer').css('height', '480px');
		$('div#photoGalleryImageContainer').css('width',  '480px');

		$('input#btnGallerySmall').hide();
		$('input#btnGalleryLarge').show();
	}

	$("img#photoGalleryImagePreload").load();
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
function toggleGallerySlideshow(){
	if (gallerySlideshow == true){
		$("input#btnGallerySlideshowStart").show();
		$("input#btnGallerySlideshowStop").hide();

		gallerySlideshow = false;
		clearTimeout();
	}else{
		$("input#btnGallerySlideshowStart").hide();
		$("input#btnGallerySlideshowStop").show();

		gallerySlideshow = true;
		setTimeout("galleryNext()", galleryInterval);
	}
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
function galleryNext(){
	if (galleryCurrentIndex+1 > intGallerySize){
		alert('This is the last photo in the gallery.');
		// turn off slideshow in case it was on
		gallerySlideshow = false;
	}else{
		galleryCurrentIndex += 1;
		newImg = arrGalleryLarge[galleryCurrentIndex];

		fadeInImage(newImg);
	}

	// if playing slideshow, time for the next one
	if (gallerySlideshow){
		setTimeout("galleryNext()", galleryInterval);
	}
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
function galleryPrev(){
	if (galleryCurrentIndex-1 < 0){
		alert('This is the first photo in the gallery.');
	}else{		
		galleryCurrentIndex -= 1;
		newImg = arrGalleryLarge[galleryCurrentIndex];

		fadeInImage(newImg);
	}
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
$(document).ready(function(){
	$("#content-slider").slider({
		animate: true,
		change: handleSliderChange,
		slide: handleSliderSlide
	});

	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	$("a.galleryThumbnail").each(function(){
		$(this).click(function(){
			var newImg = $(this).attr('href');
			var index = $("a.galleryThumbnail").index(this);

			galleryCurrentIndex = index;

			// hide scroll bars while full-screened
			document.body.style.overflow = 'hidden'; 

//			$("img#photoGalleryImagePreload").attr('src', newImg);// preload the image
//			$("img#photoGalleryImage").attr('src', newImg);// display actual image now
//			$("div#photoGalleryImageCaption").html(arrGalleryCaptions[index]);// set caption

			$("div#photoGalleryPopup").show();
			// move to current position
			$("div#photoGalleryPopup").css('top', $(window).scrollTop());
			// set the size of the full-size image holder
			// size of nav (32px) + size of caption (32px) minus total window height
			$("div#photoGalleryImageContainer").css('height', $(window).height());
			$("div#photoGalleryImageContainer").css('width', $(window).width());
			// set image
			fadeInImage(arrGalleryLarge[galleryCurrentIndex]);

			return false;
		});
	});

	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	$("img#photoGalleryImagePreload").load(function(){
		var width = $(this).width();
		var height = $(this).height();

		if (gallerySize == 'large'){
			sizeMax = '640px';
			sizeMin = '480px';
		}else if (gallerySize == 'small'){
			sizeMax = '480px';
			sizeMin = '320px';
		}


		if (width > height){
			newWidth = '640px';
			newHeight = '480px';
		}else if (height > width){
			newWidth = '480px';
			newHeight = '640px';
		}

		if (gallerySlideshow){
			fadeInImage(newImg);
		}
	});

	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	// load up the first image from the gallery by simulating a click
//	$("a.galleryThumbnail")[0].click();
});

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
// check if the thumbnails strip is smaller than the container. if it is, then
// we can hide the scroll bar
$(window).load(function(){
	if ($("div#photoGalleryThumbs table").width() > $("div#photoGalleryThumbsContainer").width()){
		$("div#content-slider").show();
	}
});

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
function handleSliderChange(e, ui){
	var maxScroll = $("#photoGalleryThumbsContainer").prop("scrollWidth") - $("#photoGalleryThumbsContainer").width();
	$("#photoGalleryThumbsContainer").animate({scrollLeft: ui.value * (maxScroll / 100) }, 1000);
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
function handleSliderSlide(e, ui){
	var maxScroll = $("#photoGalleryThumbsContainer").prop("scrollWidth") - $("#photoGalleryThumbsContainer").width();
	$("#photoGalleryThumbsContainer").attr({scrollLeft: ui.value * (maxScroll / 100) });
}
