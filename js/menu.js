$(function () {
  $(document).scroll(function () {
    var $nav = $(".menu");
    if($(window).scrollTop() > $nav.height()){
      console.log($(window).scrollTop() , $nav.height() )
		$(".menu").css({"background":"rgb(255,36,36)"});
	}
	else{
		$('.menu').css({'background':'transparent'});
	}
    
    if($nav.scrollTop() > $nav.height())
    $nav.toggleClass('scrolled', $(this).scrollTop() > $nav.height());
    
  });
});