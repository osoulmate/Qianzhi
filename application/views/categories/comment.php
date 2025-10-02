<?php echo $html->includeCss('style')?>
<?php echo $html->includeCss('comment')?>
<?php echo $html->includeJsEx('uikit/js/uikit.min')?>
<div class="qz-comment-all" id="comment-area">
    <div class="clearfix">
    	<?php if(isset($_COOKIE['name'])&&!empty($_COOKIE['name'])&&isset($_COOKIE['newtoken'])):?>
    	<div><span>你好，<a id="username" href="#comment-area"><?php echo urldecode($_COOKIE['name']);?></a></span><span style="margin-left: 5px;"><a id='exit' href="#comment-area">退出</a></span></div>
    	<?php endif?>
        <textarea  class="qz-textarea qz-comment-input" placeholder="点赞还是评论，这是个问题..." onkeyup="keyUP(this)"></textarea>
        <a href="javascript:;" class="qz-pl-btn">评论</a>
        <?php require 'clicklogin.php';?>
        <?php require 'main.php';?>
    </div>
    <?php if(isset($comments)&&!empty($comments)):?>
    <?php foreach ($comments as $comment):?>    
    <div class="qz-comment-rows clearfix">
        <?php if($comment['Comment']['parent_id']==0):?>
        <div class="qz-comment-img pull-left"><img src="/img/default.png" alt=""></div>
        <div class="qz-comment-body pull-left">
            <div class="qz-comment-meta">
                <a href="javascript:void(0)" class="qz-comment-user"><?php echo $comment['User']['name'];?></a>
                <span class="qz-comment-time pull-right"><?php echo $comment['Comment']['date'];?></span>
                <?php if(isset($_COOKIE['name'])&&($comment['User']['name']==$_COOKIE['name'])):?>
                <a href="javascript:;" class="qz-comment-del pull-right">删除</a>
                <?php endif?>
            </div>
            <div class="qz-comment-content qz-block pull-left">
                <span class="qz-pl-content" data-comment-id=<?php echo '"'.$comment['Comment']['id'].'"';?>>
                <?php echo $comment['Comment']['content'];?></span>
            </div>             
            <?php foreach ($comments as $subcomment):?>
            <?php if($subcomment['Comment']['parent_id']==$comment['Comment']['id']):?>
            <div class="qz-comment-add qz-comment-reply pull-right">
                <div class="qz-comment-img pull-left"><img src="/img/header-img-comment_03.png" alt=""></div>
                <div  class="qz-comment-reply-body pull-left">                        
                    <div class="qz-comment-meta">
                        <a  class="qz-comment-user" href="javascript:void(0)"><?php echo $subcomment['User']['name'];?></a> 
                        <span class="qz-comment-time pull-right"><?php echo $subcomment['Comment']['date'];?></span>
                        <?php if(isset($_COOKIE['name'])&&($subcomment['User']['name']==$_COOKIE['name'])):?>
                        <a href="javascript:;" class="qz-comment-del pull-right">删除</a>
                        <?php endif?>                            
                    </div>
                    <div class="qz-comment-content qz-block pull-left">
                        <span>回复</span>
                        <span class="qz-comment-user-disabled"><?php echo $comment['User']['name'];?>:</span>
                        <span class="qz-pl-content" data-comment-id=<?php echo '"'.$subcomment['Comment']['id'].'"';?>><?php echo $subcomment['Comment']['content'];?></span>
                    </div>    
                </div>
            </div>
            <?php foreach ($comments as $subsubcomment):?>
            <?php if($subsubcomment['Comment']['parent_id']==$subcomment['Comment']['id']):?>
            <div class="qz-comment-add qz-comment-reply pull-right">
                <div class="qz-comment-img pull-left"><img src="/img/default.png" alt=""></div>
                <div  class="qz-comment-reply-body pull-left">                        
                    <div class="qz-comment-meta">
                        <a class="qz-comment-user" href="javascript:void(0)"><?php echo $subsubcomment['User']['name'];?></a> 
                        <span class="qz-comment-time pull-right"><?php echo $subsubcomment['Comment']['date'];?></span>
                        <?php if(isset($_COOKIE['name'])&&($subsubcomment['User']['name']==$_COOKIE['name'])):?>
                        <a href="javascript:;" class="qz-comment-del pull-right">删除</a>
                        <?php endif?>
                    </div>
                    <div class="qz-comment-content qz-block pull-left">
                        <span>回复</span>
                        <span class="qz-comment-user-disabled"><?php echo $subcomment['User']['name'];?>:</span>
                        <span class="qz-pl-content" data-comment-id=<?php echo '"'.$subsubcomment['Comment']['id'].'"';?>><?php echo $subsubcomment['Comment']['content'];?></span>
                    </div>    
                </div>
            </div>
            <?php foreach ($comments as $subsubsubcomment):?>
            <?php if($subsubsubcomment['Comment']['parent_id']==$subsubcomment['Comment']['id']):?>
            <div class="qz-comment-add qz-comment-reply pull-right">
                <div class="qz-comment-img pull-left"><img src="/img/header-img-comment_03.png" alt=""></div>
                <div  class="qz-comment-reply-body pull-left">                        
                    <div class="qz-comment-meta">
                        <a class="qz-comment-user" href="javascript:void(0)"><?php echo $subsubsubcomment['User']['name'];?></a>                            
                        <span class="qz-comment-time pull-right"><?php echo $subsubsubcomment['Comment']['date'];?></span>
                        <?php if(isset($_COOKIE['name'])&&($subsubsubcomment['User']['name']==$_COOKIE['name'])):?>
                        <a  href="javascript:;" class="qz-comment-del pull-right">删除</a>
                        <?php endif?>
                    </div>
                    <div class="qz-comment-content qz-block pull-left">
                        <span>回复</span>
                        <span class="qz-comment-user-disabled"><?php echo $subsubcomment['User']['name'];?>:</span>
                        <span class="qz-pl-content" data-comment-id=<?php echo '"'.$subsubsubcomment['Comment']['id'].'"';?>><?php echo $subsubsubcomment['Comment']['content'];?></span>
                    </div>    
                </div>
            </div>
            <?php endif?>
            <?php endforeach?>
            <?php endif?>
            <?php endforeach?>
            <?php endif?>
            <?php endforeach?>
        </div>
        <?php endif?>                   
    </div>           
    <?php endforeach?>
    <?php endif?>
</div>
<?php echo $html->includeJs('jquery.flexText')?>
<script type="text/javascript">
    $(function () {
        $('.qz-textarea').flexText();
    });
</script>
<script type="text/javascript">
    function keyUP(t){
        var len = $(t).val().length;
        if(len > 139){
            $(t).val($(t).val().substring(0,140));
        }
    }
</script>
<script type="text/javascript">
/*点击用户创建回复框*/
var parentId;
$('.qz-comment-all').on('click','.qz-comment-user',function(){
    if($('.qz-comment-all').find('.qz-hf-con')){
    	//console.log('存在','true');
    	$('.qz-hf-con').remove();
    }
    var innerHtml = '<div class="qz-hf-con"><textarea  class="qz-comment-input qz-hf-input" placeholder="" onkeyup="keyUP(this)"></textarea><a href="javascript:;" class="qz-hf-btn">回复</a></div>';
    parentId = $(this).parent('.qz-comment-meta').siblings('.qz-comment-content').children('.qz-pl-content').get(0).getAttribute("data-comment-id");
    name = $(this).text();
    console.log('parentId',parentId);
    if($(this).not('qz-comment-user-click')){
    	console.log('isyes',this);
        $(this).parent('.qz-comment-meta').next('.qz-comment-content').append(innerHtml);
        $(this).addClass('qz-comment-user-click');
        $('.qz-hf-input').flexText();
        $(this).parent('.qz-comment-meta').next('.qz-comment-content').children('.qz-hf-con').find('.qz-hf-input').attr('placeholder','回复'+name+':').focus();
    }else{
    	console.log('isnot',this);
    }
});  
</script>

<script type="text/javascript">
/*点击用户评论内容创建回复框*/
var parentId;
$('.qz-comment-all').on('click','.qz-comment-content',function(){
    if($('.qz-comment-all').find('.qz-hf-con')){
    	$('.qz-hf-con').remove();
    }
    var innerHtml = '<div class="qz-hf-con"><textarea  class="qz-comment-input qz-hf-input" placeholder="" onkeyup="keyUP(this)"></textarea><a href="javascript:;" class="qz-hf-btn">回复</a></div>';
    parentId = $(this).children('.qz-pl-content').get(0).getAttribute("data-comment-id");
    name = $(this).prev('.qz-comment-meta').children('.qz-comment-user').text();
    console.log('parentId',parentId);
    if($(this).not('qz-comment-content-click')){
    	console.log('isyes',this);
        $(this).append(innerHtml);
        $(this).addClass('qz-comment-content-click');
        $('.qz-hf-input').flexText();
        $(this).children('.qz-hf-con').find('.qz-hf-input').attr('placeholder','回复'+name+':').focus();
    }else{
    	console.log('isnot',this);
    }
});  
</script>
<script type="text/javascript">
var x = document.cookie;
console.log(x);
$('.qz-comment-all').on('click','.qz-comment-input',function(){
    if(((x.indexOf('newtoken')) == -1)||((x.indexOf('id')) == -1) ){
        $('#myModal').modal('show');
    }
})
</script>
<script type="text/javascript">
var x = document.cookie;
var content;
$('.qz-comment-all').on('click','.qz-pl-btn,.qz-hf-btn,.qz-comment-del',function(){
    if(((x.indexOf('newtoken')) == -1)||((x.indexOf('id')) == -1) ){
        $('#myModal').modal('show');
    }else{
        if($(this).is('.qz-comment-del')){
            var tmp=$(this).parent('.qz-comment-meta').next('.qz-comment-content').children('.qz-pl-content').get(0).getAttribute("data-comment-id");
            console.log('tmpid:',tmp);
            $.ajax({
                url: <?php echo $html->url('comment/del')?>,
                type: 'post',
                dataType: 'json',
                data: {
                    userid: <?php if(isset($_COOKIE['id'])){echo $_COOKIE['id'];}else{echo 'no';}?>,
                    usertoken: <?php if(isset($_COOKIE['newtoken'])){echo '"'.$_COOKIE['newtoken'].'"';}else{echo 'no';}?>,
                    commentid: tmp
                },
                success: function (data,status,xhr) {
                        if(data['flag']=="success"){
                            location.reload();
                        }else{
                            console.log(data);
                        }
                },
                error: function (data,status,xhr) {
                    console.log(data);
                },
            });
        }else{
            if($(this).is('.qz-pl-btn')){
                parentId = 0;
            }
            content = $(this).siblings('.flex-text-wrap').find('.qz-comment-input').val();
            console.log('评论内容:',content);  
            console.log('父级评论id:',parentId);
            $.ajax({
                url: <?php echo $html->url('comment/add')?>,
                type: 'post',
                dataType: 'json',
                data: {
                    userid: <?php if(isset($_COOKIE['id'])){echo $_COOKIE['id'];}else{echo 'no';}?>,
                    usertoken: <?php if(isset($_COOKIE['newtoken'])){echo '"'.$_COOKIE['newtoken'].'"';}else{echo 'no';}?>,
                    parentid: parentId,
                    articleid:<?php echo $articleid?>,
                    content: content
                },
                success: function (data,status,xhr) {
                        if(data['flag']=="success"){
                            location.reload();
                        }else{
                            console.log(data);
                        }
                },
                error: function (data,status,xhr) {
                    console.log(data);
                },
            });
        }
    }
})
</script>
<?php if(isset($_COOKIE['id'])&&isset($_COOKIE['newtoken'])&&!empty($_COOKIE['id'])&&!empty($_COOKIE['newtoken'])):?>
<script type="text/javascript">
$('#username').click(function () {
    $.ajax({
        url: <?php echo $html->url('comment/check/'.$_COOKIE['id'].'/'.$_COOKIE['newtoken'])?>,
        type: 'get',
        dataType: 'json',
        success: function (data,status,xhr) {
            console.log(data);
            if(data['flag']=="pass"){
                $.UIkit.offcanvas.show('#qz-side');
            }
        },
    });
});
</script>
<?php endif?>
<script type="text/javascript">
$('#login').click(function () {
    $.ajax({
        url: <?php echo $html->url('comment/verify')?>,
        type: 'post',
        dataType: 'json',
        data: {
            user: $('#user').val(),
            password: $('#password').val()
        },
        success: function (data,status,xhr) {
                if(data['flag']=="OK"){
                    $('#myModal').modal('hide')
                    console.log(data);
                    document.cookie="newtoken=" + encodeURI(data['token'])+";path=/";
                    document.cookie="name=" + encodeURI(data['name'])+";path=/";
                    document.cookie="id=" + encodeURI(data['id'])+";path=/";
                    location.reload();
                }else{
                    $("#tip").text(data['flag']);
                    $('#myModal').modal('show');
                }
        },
        error: function (data,status,xhr) {
            $('#myModal').modal('show');
        },
    });
});
</script>
<script type="text/javascript">
$('#exit').click(function () {
    $.ajax({
        url: <?php echo $html->url('comment/exit')?>,
        type: 'get',
        success: function (data,status,xhr) {
            console.log(data);
            document.cookie="name=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
            document.cookie="id=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
            document.cookie="newtoken=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
            document.cookie="name=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/;domain=.zhangqingya.cn";
            document.cookie="id=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/;domain=.zhangqingya.cn";
            document.cookie="newtoken=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/;domain=.zhangqingya.cn";
            location.reload();
        },
        error: function (data,status,xhr) {
            console.log(data);
        },
    });
});
</script>




