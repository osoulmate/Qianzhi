
          <?php require 'left.php';?>
      <div class="col-10 col-lg-10 offset-md-2 offset-lg-2 .no-gutters qz-right">
          <?php if(!empty($view) && $view == 'setup'):?>
          <div class="qz-system-setup">
            <fieldset style="border:1px solid #eee;padding-left: 20px;border-left:0px;border-right:0px;border-bottom:0px;">
             <legend style="margin-left:10px;margin-right:10px;padding-left:10px;padding-right:10px;width:120px;">网站配置</legend>
            </fieldset>
            <form method="post" action=<?php echo $html->url('admin/system/setup/update');?>>
                <div>
                  <label>网站名称：</label>
                  <input type="text" name="siteName" value="<?php echo $systems['System']['name']?>"/>
                </div>
                <div>
                  <label>网站标题：</label>
                  <input type="text" name="siteTitle" value="<?php echo $systems['System']['name']?>"/>
                </div>
                <div>
                  <label>关键词：</label>
                  <input type="text" name="sitKey" value="Linux 运维 云计算"/>
                </div>
                <div>
                  <label>网站描述：</label>
                  <input type="text" name="siteDesc" value="千知，永无止境"/>
                </div>
                <div>
                  <label>版权信息：</label>
                  <input type="text" name="siteCopy" value="<?php echo $systems['System']['copyright']?>"/>
                </div>
                <div>
                  <label>备案号：</label>
                  <input type="text" name="siteRecord" value="<?php echo $systems['System']['copyright']?>"/>
                </div>
                <div>
                  <label>首页视图条目数：</label>
                  <input type="text" name="siteIndexLimit" value="<?php echo $systems['System']['index_view_items_limit']?>" />
                </div>
                <div>
                  <label>分类视图条目数：</label>
                  <input type="text" name="siteClassLimit" value="<?php echo $systems['System']['class_view_items_limit']?>"/>
                </div>
                <div>
                  <label>年度视图条目数：</label>
                  <input type="text" name="siteYearLimit" value="<?php echo $systems['System']['year_view_items_limit']?>" />
                </div>
                <div>
                  <label>月度视图条目数：</label>
                  <input type="text" name="siteMonthLimit" value="<?php echo $systems['System']['month_view_items_limit']?>" />
                </div>
                <div>
                  <label>每日视图条目数：</label>
                  <input type="text" name="siteDayLimit" value="<?php echo $systems['System']['day_view_items_limit']?>"/>
                </div>
                <div>
                  <label>搜索视图条目数：</label>
                  <input type="text" name="siteSearchLimit" value="<?php echo $systems['System']['search_view_items_limit']?>" />
                </div>
                <div>
                  <label>是否闭站：</label>
                  <label class="switch">
                    <input type="checkbox" name="switch" checked="checked"  name="siteStatus" />
                    <div class="slider round"><span>开启</span></div>
                  </label>
                </div>
                <div>
                  <label>闭站提示：</label>
                  <input type="text" name="siteDownTip" value="网站睡着了"/>
                </div>
                <input id="submit" type="submit" value="立即提交" />
            </form>
          </div>
          <?php elseif(!empty($view) && $view == 'resetpass'):?>
          <div class="qz-system-resetpass">
            <fieldset style="border:1px solid #eee;padding-left: 20px;border-left:0px;border-right:0px;border-bottom:0px;">
             <legend style="margin-left:10px;margin-right:10px;padding-left:10px;padding-right:10px;width:120px;">修改密码</legend>
            </fieldset>
            <form method="post" action=<?php echo $html->url('admin/system/resetpass/update');?>>
                <div>
                  <label>新密码：</label>
                  <input type="password" name="newPass"/>
                </div>
                <div>
                  <label>确认密码：</label>
                  <input type="password" name="newPassVerify"/>
                </div>
                <input id="submit" type="submit" value="立即提交" />
              </form>
            </div>
          <?php elseif(!empty($view) && $view == 'friend'):?>
          <div class="qz-div">
              <span class="fa fa-plus-circle"></span>
              <?php echo $html->link('添加友链','admin/system/friend/add');?>
          </div>
          <?php elseif(!empty($view) && $view == 'nav'):?>
          <div class="qz-div">
              <span class="fa fa-plus-circle"></span>
              <?php echo $html->link('添加导航','admin/system/nav/add');?>
          </div>
          <?php else:?>
          <?php require 'error.php'?>
          <?php endif?>
      </div>
<script type="text/javascript">
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
</script>
