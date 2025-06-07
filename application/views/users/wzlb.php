          <div class="qz-div">
              <span class="fa fa-plus-circle"></span>
              <?php echo $html->link('添加文章','admin/write');?>
          </div>
          <table class="qz-table">
            <thead>
              <tr>
                <th>编号</th>
                <th>标题</th>
                <th>分类</th>
                <th>浏览</th>
                <th>显示</th>
                <th>置顶</th>
                <th>作者</th>
                <th>发表时间</th>
                <th>操作</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($articles)):$i=0;?>
              <?php foreach ($articles as $article): $i=$i+1;?>
              <tr>
              <td><?php echo $i?></td>
              <td><?php echo $article['Article']['title']?></td>
              <td><?php echo $article['Category']['name']?></td>
              <td><?php echo $article['Article']['hits']?></td>
              <td>
                <?php if($article['Article']['isview'] == '1'):?>
                <label class="switch">
                  <input type="checkbox" name="switch" checked="checked" data-flag="isview" data-article-id=<?php echo '"'.$article['Article']['id'].'"';?>/>
                  <div class="slider round"><span>开启</span></div>
                </label>
                <?php else:?>
                <label class="switch">
                  <input type="checkbox" name="switch" data-flag="isview" data-article-id=<?php echo '"'.$article['Article']['id'].'"';?> />
                  <div class="slider round"><span>关闭</span></div>
                </label>
                <?php endif?>                      
              </td>
              <td>
                <?php if($article['Article']['flag'] == '2'||$article['Article']['flag'] == '1'):?>
                <label class="switch">
                  <input type="checkbox" name="switch" checked="checked" data-flag="flag" data-article-id=<?php echo '"'.$article['Article']['id'].'"';?> />
                  <div class="slider round"><span>开启</span></div>
                </label>
                <?php else:?>
                <label class="switch">
                  <input type="checkbox" name="switch" data-flag="flag" data-article-id=<?php echo '"'.$article['Article']['id'].'"';?>/>
                  <div class="slider round"><span>关闭</span></div>
                </label>
                <?php endif?>   
              </td>
              <td><?php echo $article['Article']['author']?></td>
              <td><?php echo $article['Article']['date']?></td>
              <td>
                    <?php //echo $html->link('预览','admin/wzgl/preview/id/'.$article['Article']['id'],'','',' target="_blank" ');
                    $date = mb_substr($article['Article']['date'],0,10,'utf-8');
                    $dateFormat = explode('-', $date);
                    $dateFormat = implode('/', $dateFormat);
                    echo $html->link('预览',$dateFormat.'/'.$article['Article']['index_id'],'','',' target="_blank" ')
                    ?>
                    <span>&nbsp;&nbsp;</span>
                    <?php echo $html->link('编辑','admin/wzgl/edit/id/'.$article['Article']['id']);?>
                    <span>&nbsp;&nbsp;</span>
                    <?php echo $html->link('删除','admin/wzgl/update/id/'.$article['Article']['id']);?>
              </td>
              </tr>
              <?php endforeach?>
              <?php endif?>
            </tbody>
          </table>
          <ul class="qz-pagination">
          <li>共有<?php echo $postNumber;?>篇文章</li>
          <?php if($page==1):?>
          <li class="disabled"><a>首页</a></li>
          <li class="disabled"><a>上一页</a></li>
          <?php else:?>
          <li><?php echo $html->link('首页','admin/wzgl/list/page/1');?></li>
          <li><?php echo $html->link('上一页','admin/wzgl/list/page/'.($page-1));?></li>
      	   <?php endif?>
          <?php if($page==ceil($postNumber/10)||$postNumber==0):?>
          <li class="disabled"><a>下一页</a></li> 
          <li class="disabled"><a>尾页</a></li>
          <?php else:?>
          <li><?php echo $html->link('下一页','admin/wzgl/list/page/'.($page+1));?></li> 
          <li><?php echo $html->link('尾页','admin/wzgl/list/page/'.(ceil($postNumber/10)));?></li> 
      	 <?php endif?>
          <li><?php echo $page?>/<?php echo ceil($postNumber/10);?>页</li>
          </ul>
         <script type="text/javascript">
         $('.switch').click(function () {
           ok = $(this).children("input[name='switch']").prop("checked");
           id = $(this).children('input').get(0).getAttribute("data-article-id");
           flag = $(this).children('input').get(0).getAttribute("data-flag");
           console.log('id',id);
           console.log('flag',flag);
           if(ok){
             $(this).children('div').children('span').text('关闭');
             $(this).children("input[name='switch']").prop("checked",false);
             if(flag=='isview'){
               flag = ' isview = 0 ';
             }else{
               flag = ' flag = 0 ';
             }
             $.ajax({
                 url: <?php echo $html->url('admin/wzgl/recovery')?>,
                 type: 'post',
                 dataType: 'json',
                 data:{
                     id: id,
                     flag: flag
                 },
                 success: function (data,status,xhr) {
                 },
             });
           }else{
             $(this).children('div').children('span').text('开启');
             $(this).children("input[name='switch']").prop("checked",true);
             if(flag=='isview'){
               flag = ' isview = 1 ';
             }else{
               flag = ' flag = 2 ';
             }
             $.ajax({
                 url: <?php echo $html->url('admin/wzgl/recovery')?>,
                 type: 'post',
                 dataType: 'json',
                 data:{
                     id: id,
                     flag: flag
                 },
                 success: function (data,status,xhr) {
                 },
             });
           }
         });
         </script>
