<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="height: 407px;width: 356px;">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalCenterTitle">千知博客</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div><span id='tip'></span></div>
            <form class="form-group" role="form" style="margin:0px;padding:0px;width: 100%;height: 100%;">
                <input type="text" class="form-control" id="user" placeholder="用户名/邮箱" style="width: 100%;margin-bottom: 10%;margin-top: 10%;">
                <input type="password" class="form-control" id="password" placeholder="密码" style="width: 100%;margin-top: 10%;">
                <a href="/admin/getpass" style="float: left;margin-bottom: 10%;margin-top: 5%;">忘记密码</a>
                <a style="float: right;margin-bottom: 10%;margin-top: 5%;" href="/admin/registry">立即注册</a>
                <button type="button" class="btn btn-primary" id="login" style="width: 100%">登录</button>     
            </form> 
      </div>
      <div class="modal-footer">
      <span>第三方登录</span>
      <a href="/auth/weixin"><i class="zi zi_tmWeixin zi_2x"></i></a>
      <a href="/auth/github"><i class="zi zi_tmGithub zi_2x"></i></a>
      <a href="/auth/gitee"><i class="zi zi_tmGitee zi_2x"></i></a>
      </div>
    </div>
  </div>
</div>
