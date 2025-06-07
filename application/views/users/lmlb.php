          <div class="qz-div">
              <span class="fa fa-plus-circle"></span>
              <?php echo $html->link('添加栏目','admin/lmgl/add');?>
          </div>
          <table class="qz-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>排序</th>
                <th>名称</th>
                <th>上级分类</th>
                <th>显示</th>
                <th>操作</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($categories)):?>
              <?php foreach ($categories as $category):?>
              <?php if($category['Son']['parent_id']==0):?>
              <tr>
                <td><?php echo $category['Son']['id']?></td>
                <td>99</td>
                <td style="text-align: left;padding-left: 25px;"><?php echo $category['Son']['name']?></td>
                <td>无</td>
                <td>
                  <label class="switch">
                    <input type="checkbox" name="switch" checked="checked"  data-class-id=<?php echo $category['Son']['id'];?> />
                    <div class="slider round"><span>开启</span></div>
                  </label>                    
                </td>
                <td>
                     <?php echo $html->link('修改','admin/lmgl/modify/id/'.$category['Son']['id']);?>
                    <span>&nbsp;&nbsp;</span>
                    <a href="" data-class-id=<?php echo $category['Son']['id'];?>>删除</a>
                </td>
              </tr>
              <?php foreach ($categories as $subcategory):?>
              <?php if($category['Son']['name'] == $subcategory['Parent']['name']):?>
              <tr>
                <td><?php echo $subcategory['Son']['id']?></td>
                <td>99</td>
                <td style="text-align: left;padding-left: 25px;">|------<?php echo $subcategory['Son']['name']?></td>
                <td><?php echo $subcategory['Parent']['name']?></td>
                <td>
                  <label class="switch">
                    <input type="checkbox" name="switch" checked="checked"  data-class-id=<?php echo $subcategory['Son']['id'];?> />
                    <div class="slider round"><span>开启</span></div>
                  </label>                    
                </td>
                <td>
                    <?php echo $html->link('修改','admin/lmgl/modify/id/'.$subcategory['Son']['id']);?>
                    <span>&nbsp;&nbsp;</span>
                    <a href="" data-class-id=<?php echo $subcategory['Son']['id'];?>>删除</a>
                </td>
              </tr>
              <?php endif?>
              <?php endforeach?>
              <?php endif?>
              <?php endforeach?>
              <?php endif?>
            </tbody>
          </table>
<script type="text/javascript">
$('.qz-table td a').click(function () {
  id = $(this).get(0).getAttribute("data-class-id");
  console.log(id);
  if($(this).text()=='删除'){
      var r=confirm("你确定要删除本栏目吗?"); 
      if (r==true){
        $.ajax({
            url: <?php echo $html->url('admin/lmgl/del')?>,
            type: 'post',
            dataType: 'json',
            data:{
                id: id
            },
            success: function (data,status,xhr) {
            },
        });
      }
  }
});
</script>
