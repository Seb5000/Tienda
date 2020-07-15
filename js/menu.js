$(function () {
  $(document).scroll(function () {
    var $nav = $(".menu");
    if($(window).scrollTop() > $nav.height()){
      console.log($(window).scrollTop() , $nav.height() )
		$(".menu").css({"background":"rgba(255, 36, 36, 0.6)"});
		$(".menu").css({"backdrop-filter":"blur(10px)"});
	}
	else{
    $('.menu').css({'background':'transparent'});
    $(".menu").css({"backdrop-filter":"blur(0px)"});
	}
    
    if($nav.scrollTop() > $nav.height())
    $nav.toggleClass('scrolled', $(this).scrollTop() > $nav.height());
    
  });
});