/*==================================================================================
    Custom JS (Any custom js code you want to apply should be defined here).
====================================================================================*/
$(function(){
   var index = sessionStorage.getItem("currentNav");
   if(index){
   		var li = $(".header .header-fixed .nav-menu-cover .nav-menu").children('li').eq(index);
   		li.children('a').css("color","#FF7171").siblings().children('a').css("color","#333");   	
   	}
   $(".header .header-fixed .nav-menu-cover .nav-menu").children('li').click(function () {
       var index = $(this).index();
       sessionStorage.setItem("currentNav",index);
   });
});