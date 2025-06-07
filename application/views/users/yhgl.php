
          <?php require 'left.php';?>
      <div class="col-10 col-lg-10 offset-md-2 offset-lg-2 .no-gutters qz-right">
          <?php if(!empty($view) && $view == 'list'):?>
          <div class="qz-div">
              <span class="fa fa-plus-circle"></span>
              <?php echo $html->link('添加用户','admin/yhgl/add');?>
          </div>
          <table class="qz-table">
            <thead>
              <tr>
                <th>UID</th>
                <th>手机</th>
                <th>用户名</th>
                <th>昵称</th>
                <th>QQ</th>
                <th>邮箱</th>
                <th>最近登陆时间</th>
                <th>登陆次数</th>
                <th>管理员</th>
                <th>账户状态</th>
                <th>注册方式</th>
                <th>操作</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($users)):?>
              <?php foreach ($users as $user):?>
              <tr>
              <td><?php echo $user['User']['id'];?></td>
              <td>13710111011</td>
              <td><?php echo $user['User']['username'];?></td>
              <td><?php echo $user['User']['name'];?></td>
              <td>250401016</td>
              <td><?php echo $user['User']['email'];?></td>
              <td><?php echo date("Y-m-d h:m:s");?></td>
              <td>0</td>
              <td>
                <?php if($user['User']['admin'] == '1'): echo '管理员';?>
                <?php else: echo "普通用户";?>
                <?php endif?>
              </td>
              <td>
                <?php if($user['User']['status'] == '1'):?>
                <label class="switch">
                  <input type="checkbox" name="switch" checked="checked" data-user-id=<?php echo '"'.$user['User']['id'].'"';;?>/>
                  <div class="slider round"><span>正常</span></div>
                </label>
                <?php else:?>
                <label class="switch">
                  <input type="checkbox" name="switch" data-user-id=<?php echo '"'.$user['User']['id'].'"';;?>/>
                  <div class="slider round"><span>封禁</span></div>
                </label>
                <?php endif?>
              </td>
              <td>
                <?php if($user['User']['registry_source'] == 'local'):?>本站
                <?php else: echo $user['User']['registry_source'];?><?php endif?> 
              </td>
              <td>
                    <?php echo $html->link('修改','admin/yhgl/modify/id/'.$user['User']['id']);?>
                    <span>&nbsp;&nbsp;</span>
                    <?php echo $html->link('删除','admin/yhgl/del/id/'.$user['User']['id']);?>
              </td>
              </tr>
              <?php endforeach?>
              <?php endif?>
            </tbody>
          </table>
          <ul class="qz-pagination">
          <li>共有<?php echo $postNumber;?>个用户</li>
          <?php if($page==1):?>
          <li class="disabled"><a>首页</a></li>
          <li class="disabled"><a>上一页</a></li>
          <?php else:?>
          <li><?php echo $html->link('首页','admin/yhgl/list/page/1');?></li>
          <li><?php echo $html->link('上一页','admin/yhgl/list/page/'.($page-1));?></li>
           <?php endif?>
          <?php if($page==ceil($postNumber/10)):?>
          <li class="disabled"><a>下一页</a></li> 
          <li class="disabled"><a>尾页</a></li>
          <?php else:?>
          <li><?php echo $html->link('下一页','admin/yhgl/list/page/'.($page+1));?></li> 
          <li><?php echo $html->link('尾页','admin/yhgl/list/page/'.(ceil($postNumber/10)));?></li> 
         <?php endif?>
          <li><?php echo $page?>/<?php echo ceil($postNumber/10);?>页</li>
          </ul>
         <script type="text/javascript">
         $('.switch').click(function () {
           ok = $(this).children("input[name='switch']").prop("checked");
           id = $(this).children('input').get(0).getAttribute("data-user-id");
           console.log(ok);
           console.log(id);
           if(ok){
             $(this).children('div').children('span').text('封禁');
             $(this).children("input[name='switch']").prop("checked",false);
             $.ajax({
                 url: <?php echo $html->url('admin/yhgl/disable')?>,
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
                 url: <?php echo $html->url('admin/yhgl/enable')?>,
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
          <?php elseif(!empty($view) && $view == 'disable'): echo 'ok';?>
          <?php elseif(!empty($view) && $view == 'enable'): echo 'ok';?>
          <?php elseif(!empty($view) && $view == 'add'):?>
          <div class="qz-system-setup">
            <fieldset style="border:1px solid #eee;padding-left: 20px;border-left:0px;border-right:0px;border-bottom:0px;">
             <legend style="margin-left:10px;margin-right:10px;padding-left:10px;padding-right:10px;width:120px;">添加用户</legend>
            </fieldset>
            <form method="post" action=<?php echo $html->url('admin/yhgl/add');?>>
                <div>
                  <label>昵称：</label>
                  <input type="text" name="addname" />
                </div>
                <div>
                  <label>用户名：</label>
                  <input type="text" name="adduser" />
                </div>
                <div>
                  <label>密码：</label>
                  <input type="password" name="addpass"/>
                </div>
                <div>
                  <label>是否禁用：</label>
                  <label class="switch">
                    <input type="checkbox" name="switch" checked="checked"/>
                    <div class="slider round"><span>开启</span></div>
                  </label>
                </div>
                <input id="submit" type="submit" value="立即提交" />
            </form>
          </div>
          <?php echo $html->includeJs('backend-switch');?>
          <?php elseif(!empty($view) && $view == 'modify'):?>
          <div class="qz-system-setup">
            <fieldset style="border:1px solid #eee;padding-left: 20px;border-left:0px;border-right:0px;border-bottom:0px;">
             <legend style="margin-left:10px;margin-right:10px;padding-left:10px;padding-right:10px;width:120px;">修改用户</legend>
            </fieldset>
            <?php if(!empty($user)):?>
            <form method="post" action=<?php echo $html->url('admin/yhgl/modify/id/'.$user['User']['id']);?>>
                <div>
                  <label>昵称：</label>
                  <input type="text" name="modifyname" value=<?php echo $user['User']['name'];?> />
                </div>
                <div>
                  <label>用户名：</label>
                  <input type="text" name="modifyuser" value=<?php echo $user['User']['username'];?> />
                </div>
                <div>
                  <label>QQ：</label>
                  <input type="text" name="modifyqq" placeholder='暂空' />
                </div>
                <div>
                  <label>邮箱：</label>
                  <input type="text" name="modifymail" value='<?php echo $user['User']['email'];?>' />
                </div>
                <div>
                  <label>手机号：</label>
                  <input type="text" name="modifytel" placeholder='暂空' />
                </div>
                <div>
                  <label>密码：</label>
                  <input type="password" name="modifypass" placeholder='<?php echo $user['User']['password'];?>' />
                </div>
                <div>
                  <label>是否禁用：</label>
                  <label class="switch">
                    <input type="checkbox" name="switch" checked="checked"/>
                    <div class="slider round"><span>开启</span></div>
                  </label>
                </div>
                <input id="submit" type="submit" value="立即提交" />
            </form>
          <?php echo $html->includeJs('backend-switch');?>
          <?php endif?>
          </div>
          <?php else:?>
          <?php require 'error.php'?>
          <?php endif?>
      </div>