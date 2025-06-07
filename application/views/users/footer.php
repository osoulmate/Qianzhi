
  </div>
</div>

</body>
<script type="text/javascript">
$(function(){
    $('.qz-left ul li').on('click','a,div',function(){
       if($(this).children('.arrow').hasClass("fa-angle-down")){
            $(this).nextAll('div').show();
            $(this).children('.arrow').removeClass("fa-angle-down").addClass("fa-angle-up");      
       }else if($(this).children('.arrow').hasClass("fa-angle-up")){
            $(this).nextAll('div').hide();
            $(this).children('.arrow').removeClass("fa-angle-up").addClass("fa-angle-down");          
       }else if($(this).prev('a').children('.arrow').hasClass("fa-angle-down")){
            $(this).children('.arrow').removeClass("fa-angle-down").addClass("fa-angle-up"); 
       }else if($(this).prev('a').children('.arrow').hasClass("fa-angle-up")){
            $(this).children('.arrow').removeClass("fa-angle-up").addClass("fa-angle-down");        
       }else{
       }
   });
});
</script>
</html>
