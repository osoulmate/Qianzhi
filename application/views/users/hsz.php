          <table class="qz-table">
            <thead>
              <tr>
                <th>编号</th>
                <th>标题</th>
                <th>分类</th>
                <th>浏览</th>
                <th>作者</th>
                <th>发表时间</th>
                <th>操作</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($recycle)):$i=0;?>
              <?php foreach ($recycle as $article): $i=$i+1;?>
              <tr>
              <td><?php echo $i?></td>
              <td><?php echo $article['Article']['title']?></td>
              <td><?php echo $article['Category']['name']?></td>
              <td><?php echo $article['Article']['hits']?></td>
              <td><?php echo $article['Article']['author']?></td>
              <td><?php echo $article['Article']['date']?></td>
              <td>
                  <?php echo $html->link('恢复','admin/wzgl/recovery/id/'.$article['Article']['id']);?>
                  <span>&nbsp;&nbsp;</span>
                  <?php echo $html->link('删除','admin/wzgl/del/id/'.$article['Article']['id']);?>
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
          <li><?php echo $html->link('首页','admin/wzgl/hsz');?></li>
          <li><?php echo $html->link('上一页','admin/wzgl/hsz/page/'.($page-1));?></li>
          <?php endif?>
  
          <?php if($page==ceil($postNumber/10)||$postNumber==0):?>
          <li class="disabled"><a>下一页</a></li> 
          <li class="disabled"><a>尾页</a></li>
          <?php else:?>
          <li><?php echo $html->link('下一页','admin/wzgl/hsz/page/'.($page+1));?></li> 
          <li><?php echo $html->link('尾页','admin/wzgl/hsz/page/'.(ceil($postNumber/10)));?></li> 
          <?php endif?>
          <li><?php echo $page?>/<?php echo ceil($postNumber/10);?>页</li>
          </ul>
