
      <?php require 'left.php';?>
      <div class="col-10 col-lg-10 offset-md-2 offset-lg-2 .no-gutters qz-right">
          <?php if(!empty($action) && $action == 'list'):?>
          <?php require 'lmlb.php';?>
          <?php elseif(!empty($action) && $action == 'add'):?>
          <div class="qz-add-class">
            <fieldset style="border:1px solid #eee;padding-left: 20px;border-left:0px;border-right:0px;border-bottom:0px;">
             <legend style="margin-left:10px;margin-right:10px;padding-left:10px;padding-right:10px;width:120px;">添加栏目</legend>
            </fieldset>
            <form method="post" action=<?php echo $html->url('admin/lmgl/add');?>>
                <ul>
                    <li>栏目名称：<input type="text" name="name" placeholder="<?php if(isset($add)){echo $add;}?>" /></li>
                    <li>英文名称：<input type="text" name="englishname" placeholder="不能有空格" /></li>
                    <li>导航排序：<input type="text" name="order" placeholder="数小靠前，默认为99" /></li>
                    <li>栏目分类：<select name="typeid">
                    <option value="one">顶级分类</option>
                        <?php foreach($categories as $parent):?>
                            <?php if(empty($parent['Parent']['id'])):?>
                                <option 
                                    value="<?php echo $parent['Son']['id']?>"><?php echo $parent['Son']['name']?> 
                                </option>
                                <?php foreach($categories as $sub):?>
                                    <?php if(($sub['Son']['parent_id'])==$parent['Son']['id']):?>
                                    <?php echo "<option value='".$sub['Son']['id']."'>".str_repeat('　',1)."|-{$sub['Son']['name']}</option>";?>
                                    <?php endif?>
                                <?php endforeach?>
                            <?php endif?>
                        <?php endforeach?>
                    </select>
                    </li>
                    <li>是否显示:                               
                      <label class="switch">
                        <input type="checkbox" name="switch" checked="checked"  data-class-id="31" />
                        <div class="slider round"><span>开启</span></div>
                      </label>
                    </li>
                </ul>
                <input id="submit" type="submit" value="立即提交" />
            </form>
          </div>
          <?php elseif(!empty($action) && $action == 'modify'):?>
          <div class="qz-add-class">
            <fieldset style="border:1px solid #eee;padding-left: 20px;border-left:0px;border-right:0px;border-bottom:0px;">
             <legend style="margin-left:10px;margin-right:10px;padding-left:10px;padding-right:10px;width:120px;">修改栏目</legend>
            </fieldset>
            <form method="post" action=<?php echo $html->url('admin/lmgl/modify');?>>
                <ul>
                    <li>原分类名：<input type="text" name="name" readonly="readonly" style="background-color: #eeeeee;" value= <?php echo $son;?> /></li>
                    <li>新分类名：<input type="text" name="newname"/></li>
                    <li>导航排序：<input type="text" name="order"/></li>
                    <li>栏目分类：<select name="typeid">
                    <option value="one">顶级分类</option>
                        <?php foreach($categories as $parent):?>
                            <?php if(empty($parent['Parent']['id'])):?>
                                <option value="<?php echo $parent['Son']['id']?>" <?php if($sonid == $parent['Son']['id']){echo 'selected';}?>>
                                  <?php echo $parent['Son']['name']?> 
                                </option>
                                <?php foreach($categories as $sub):?>
                                    <?php if(($sub['Son']['parent_id'])==$parent['Son']['id']):?>
                                    <?php if($sonid == $sub['Son']['id']):?>
                                    <?php echo "<option selected value='".$sub['Son']['id']."'>".str_repeat('　',1)."|-{$sub['Son']['name']}</option>";?>
                                    <?php else:?>
                                    <?php echo "<option value='".$sub['Son']['id']."'>".str_repeat('　',1)."|-{$sub['Son']['name']}</option>";?>
                                    <?php endif?>
                                    <?php endif?>
                                <?php endforeach?>
                            <?php endif?>
                        <?php endforeach?>
                    </select>
                    </li>
                    <li>是否显示:                               
                      <label class="switch">
                        <input type="checkbox" name="switch" checked="checked"  data-class-id="31" />
                        <div class="slider round"><span>开启</span></div>
                      </label>
                    </li>
                </ul>
                <input id="submit" type="submit" value="立即提交" />
            </form>
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
