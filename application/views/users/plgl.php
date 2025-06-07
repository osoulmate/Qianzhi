      <?php require 'left.php';?>
      <div class="col-10 col-lg-10 offset-md-2 offset-lg-2 .no-gutters qz-right">
          <?php if(!empty($view) && $view == 'list'):?>
          <table class="qz-table" style="margin-top: 25px;">
            <thead>
              <tr>
                <th>ID</th>
                <th>父ID</th>
                <th>所属文章</th>
                <th>评论内容</th>
                <th>评论日期</th>
                <th>评论用户</th>
                <th>显示</th>
                <th>操作</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($comments)):?>
              <?php foreach ($comments as $comment):?>
              <tr>
              <td><?php echo $comment['Comment']['id'];?></td>
              <td><?php echo $comment['Comment']['parent_id'];?></td>
              <td><?php echo $comment['Article']['title'];?></td>
              <td><?php echo $comment['Comment']['content'];?></td>
              <td><?php echo $comment['Comment']['date'];?></td>
              <td><?php echo $comment['User']['username'];?></td>
              <td>
                <?php if($comment['Comment']['id']):?>
                <label class="switch">
                  <input type="checkbox" name="switch" checked="checked" data-comment-id=<?php echo '"'.$comment['Comment']['id'].'"';;?>/>
                  <div class="slider round"><span>正常</span></div>
                </label>
                <?php else:?>
                <label class="switch">
                  <input type="checkbox" name="switch" data-comment-id=<?php echo '"'.$comment['Comment']['id'].'"';;?>/>
                  <div class="slider round"><span>隐藏</span></div>
                </label>
                <?php endif?>                      
              </td>
              <td>
                    <?php echo $html->link('删除','admin/plgl/del/id/'.$comment['Comment']['id']);?>
              </td>
              </tr>
              <?php endforeach?>
              <?php endif?>
            </tbody>
          </table>
          <ul class="qz-pagination">
          <li>共有<?php echo $postNumber;?>条评论</li>
          <?php if($page==1):?>
          <li class="disabled"><a>首页</a></li>
          <li class="disabled"><a>上一页</a></li>
          <?php else:?>
          <li><?php echo $html->link('首页','admin/plgl/list/page/1');?></li>
          <li><?php echo $html->link('上一页','admin/plgl/list/page/'.($page-1));?></li>
           <?php endif?>
          <?php if($page==ceil($postNumber/10)||$postNumber==0):?>
          <li class="disabled"><a>下一页</a></li> 
          <li class="disabled"><a>尾页</a></li>
          <?php else:?>
          <li><?php echo $html->link('下一页','admin/plgl/list/page/'.($page+1));?></li> 
          <li><?php echo $html->link('尾页','admin/plgl/list/page/'.(ceil($postNumber/10)));?></li> 
          <?php endif?>
          <li><?php echo $page?>/<?php echo ceil($postNumber/10);?>页</li>
          </ul>
         <script type="text/javascript">
         $('.switch').click(function () {
           ok = $(this).children("input[name='switch']").prop("checked");
           id = $(this).children('input').get(0).getAttribute("data-comment-id");
           console.log(ok);
           console.log(id);
           if(ok){
             $(this).children('div').children('span').text('隐藏');
             $(this).children("input[name='switch']").prop("checked",false);
             $.ajax({
                 url: <?php echo $html->url('admin/plgl/visible')?>,
                 type:'post',
                 data:{
                     id: id
                 },
                 success: function (data,status,xhr) {
                    console.log(data);
                 },
                error: function (data,status,xhr) {
                    console.log(data);
                    console.log(xhr);
                },
             });
           }else{
             $(this).children('div').children('span').text('正常');
             $(this).children("input[name='switch']").prop("checked",true);
             $.ajax({
                 url: <?php echo $html->url('admin/plgl/hidden')?>,
                 type:'post',
                 data:{
                     id: id
                 },
                 success: function (data,status,xhr) {
                  console.log(data);
                 },
                error: function (data,status,xhr) {
                    console.log(data);
                    console.log(xhr);
                },
             });
           }
         });
         </script>
        <?php else:?>
        <?php require 'error.php'?>
        <?php endif?>
      </div>
