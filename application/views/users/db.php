	<?php if(isset($reply)):echo $reply;?>
	<?php else:?>
          <?php require 'left.php';?>
      <div class="col-10 col-lg-10 offset-md-2 offset-lg-2 .no-gutters qz-right">
          <?php if(!empty($view) && $view == 'backup'):?>
          <table class="qz-table" style="margin-top: 25px;">
            <thead>
              <tr>
                <th><input type="checkbox" name="all-tables"></th>
                <th>表名</th>
                <th>表说明</th>
                <th>引擎</th>
                <th>编码</th>
                <th>数据量</th>
                <th>数据大小</th>
                <th>创建时间</th>
                <th>最近更新时间</th>
                <th>备份状态</th>
                <th>操作</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($tables)):?>
              <?php foreach ($tables as $table):?>
              <tr>
              <td><input type="checkbox" name=<?php echo $table['Table']['TABLE_NAME'];?> ></td>
              <td><?php echo $table['Table']['TABLE_NAME'];?></td>
              <td><?php echo $table['Table']['TABLE_COMMENT'];?></td>
              <td><?php echo $table['Table']['ENGINE'];?></td>
              <td><?php echo $table['Table']['TABLE_COLLATION'];?></td>
              <td><?php echo $table['Table']['TABLE_ROWS'];?></td>

              <td><?php echo ((int)($table['Table']['DATA_LENGTH'])/1024).'KB';?></td>
              <td><?php echo $table['Table']['CREATE_TIME'];?></td>
              <td><?php echo $table['Table']['UPDATE_TIME'];?></td>
              <td>未备份</td>
              <td>
              	<a href="javascript:;" class="backup" data-table-name=<?php echo '"'.$table['Table']['TABLE_NAME'].'"';?> >备份</a>
              </td>
              </tr>
              <?php endforeach?>
              <?php endif?>
              <tr><td><input type="checkbox" name="all-tables" /></td>
              	<td colspan="10"><span style="float: right;"><a href="javascript:;" class="backup" data-table-name='all'>备份所有表</a></span>
              	</td>
              </tr>
            </tbody>
          </table>
         <script type="text/javascript">
         $('.backup').click(function () {
           id = $(this).get(0).getAttribute("data-table-name");
           console.log(id);
           $.ajax({
               url: <?php echo $html->url('admin/db/download')?>,
               type:'post',
               data:{
                   id: id
               },
               success: function (data,status,xhr) {
                  console.log(data);
					       var r=confirm("是否下载!");
					       if (r==true){
					       	window.location.assign(data);
					       }
					       else{
					       	x="你按下了\"取消\"按钮!";
					       }
               },
               error:function(data,status,xhr){
               		console.log(data);
               },
           });
         });
         </script>
         <?php elseif(!empty($view) && $view == 'recovery'):?>

          <table class="qz-table" style="margin-top: 25px;">
            <thead>
              <tr>
                <th>备份文件名</th>
                <th>文件数量</th>
                <th>大小</th>
                <th>备份时间</th>
                <th>操作</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($backupfiles)):?>
              <?php foreach ($backupfiles as $backupfile):?>
              <tr>
                <td><?php echo basename($backupfile);?></td>
                <td>1</td>
                <td><?php echo ((int)(filesize($backupfile))/1024).'KB';?></td>
                <td><?php echo date("Y-m-d H:i:s",fileatime($backupfile));?></td>
                <td>
                    <a href="javascript:;" class="recovery" data-backup-name=<?php echo '"'.basename($backupfile).'"';?> >还原</a>
                    <span>&nbsp;&nbsp;</span>
                    <?php echo $html->link('下载','db/'.basename($backupfile)) ;?>
                    <span>&nbsp;&nbsp;</span>
                    <a href="javascript:;" class="del" data-backup-name=<?php echo '"'.basename($backupfile).'"';?> >删除</a>
                </td>
              </tr>
              <?php endforeach?>
              <?php else:?>
                <?php echo "<pre>";print_r($backupfiles);echo "</pre>";?>
              <?php endif?>
            </tbody>
          </table>
            <script type="text/javascript">
            $('.recovery').click(function () {
              id = $(this).get(0).getAttribute("data-backup-name");
              console.log(id);
              $.ajax({
                  url: <?php echo $html->url('admin/db/recovery')?>,
                  type:'post',
                  data:{
                      id: id,
                      action: "rec"
                  },
                  success: function (data,status,xhr) {
                     console.log(data);
                     alert(data);
                  },
                  error:function(data,status,xhr){
                     console.log(data);

                  },
                });
            });
            $('.del').click(function () {
              id = $(this).get(0).getAttribute("data-backup-name");
              console.log(id);
              $.ajax({
                  url: <?php echo $html->url('admin/db/recovery')?>,
                  type:'post',
                  data:{
                      id: id,
                      action: "del"
                  },
                  success: function (data,status,xhr) {
                     console.log(data);
                     window.location.reload()
                  },
                  error:function(data,status,xhr){
                     console.log(data);
                  },
              });
            });
            </script>
          <?php else:?>
          <?php require 'error.php'?>
          <?php endif?>
      </div>
 	<?php endif?>