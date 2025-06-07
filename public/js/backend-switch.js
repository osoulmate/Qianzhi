$('.switch').click(function () {
  ok = $(this).children("input[name='switch']").prop("checked");
  //id = $(this).children('input').get(0).getAttribute("ata-class-id");
  if(ok){
    $(this).children('div').children('span').text('关闭');
    $(this).children("input[name='switch']").prop("checked",false);
  }else{
    $(this).children('div').children('span').text('开启');
    $(this).children("input[name='switch']").prop("checked",true);
  }
});
