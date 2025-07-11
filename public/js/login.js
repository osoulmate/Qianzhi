$(function(){
    var tab = 'account_number';
    var code = '';
    // 选项卡切换
    $(".account_number").click(function () {
        $('.tel-warn').addClass('hide');
        tab = $(this).attr('class').split(' ')[0];
        checkBtn();
        $(this).addClass("on");
        $(".message").removeClass("on");
        $(".form2").addClass("hide");
        $(".form1").removeClass("hide");
    });
    // 选项卡切换
    $(".message").click(function () {
        $('.tel-warn').addClass('hide');
        tab = $(this).attr('class').split(' ')[0];
        checkBtn();
        $(this).addClass("on");
        $(".account_number").removeClass("on");
        $(".form2").removeClass("hide");
        $(".form1").addClass("hide");
        
    });

    $('#num').keyup(function(event) {
        $('.tel-warn').addClass('hide');
        checkBtn();
    });

    $('#pass').keyup(function(event) {
        $('.tel-warn').addClass('hide');
        checkBtn();
    });

    $('#veri').keyup(function(event) {
        $('.tel-warn').addClass('hide');
        checkBtn();
    });

    $('#num2').keyup(function(event) {
        $('.tel-warn').addClass('hide');
        checkBtn();
    });

    $('#veri-code').keyup(function(event) {
        $('.tel-warn').addClass('hide');
        checkBtn();
    });

    // 按钮是否可点击
    function checkBtn()
    {
        if (tab == 'account_number') {
            var inp = $('#num').val();
            var pass = $('#pass').val();
            if (inp != '' && pass != '') {
                $(".log-btn").removeClass("off");
            } else {
                $(".log-btn").addClass("off");
            }
        } else {
            var phone = $.trim($('#num2').val());
            var code2 = $.trim($('#veri-code').val());
            if (phone != '' && code2 != '') {
                $(".log-btn").removeClass("off");
                sendBtn();
            } else {
                $(".log-btn").addClass("off");
            }
        }
    }

    function checkAccount(username){
        if (username == '') {
            $('.num-err').removeClass('hide').find("em").text('请输入账户');
            return false;
        } else {
            $('.num-err').addClass('hide');
            return true;
        }
    }

    function checkPass(pass){
        if (pass == '') {
            $('.pass-err').removeClass('hide').text('请输入密码');
            return false;
        } else {
            $('.pass-err').addClass('hide');
            return true;
        }
    }

    function checkCode(code){
        if (code == '') {
            // $('.tel-warn').removeClass('hide').text('请输入验证码');
            return false;
        } else {
            // $('.tel-warn').addClass('hide');
            return true;
        }
    }

    function checkPhone(phone){
        var status = true;
        if (phone == '') {
            $('.num2-err').removeClass('hide').find("em").text('请输入手机号');
            return false;
        }
        var param = /^1[34578]\d{9}$/;
        if (!param.test(phone)) {
            $('.num2-err').removeClass('hide');
            $('.num2-err').text('手机号不合法，请重新输入');
            return false;
        }
        $.ajax({
            url: '/checkPhone',
            type: 'post',
            dataType: 'json',
            async: false,
            data: {phone:phone,type:"login"},
            success:function(data){
                if (data.code == '0') {
                    $('.num2-err').addClass('hide');
                    // console.log('aa');
                    // return true;
                } else {
                    $('.num2-err').removeClass('hide').text(data.msg);
                    // console.log('bb');
                    status = false;
                    // return false;
                }
            },
            error:function(){
                status = false;
                // return false;
            }
        });
        return status;
    }

    function checkPhoneCode(pCode){
        if (pCode == '') {
            $('.error').removeClass('hide').text('请输入验证码');
            return false;
        } else {
            $('.error').addClass('hide');
            return true;
        }
    }

    // 登录点击事件
    function sendBtn(){
        if (tab == 'account_number') {
            $(".log-btn").click(function(){
                // var type = 'phone';
                var inp = $.trim($('#num').val());
                var pass = $.md5($.trim($('#pass').val()));
                if (checkAccount(inp) && checkPass(pass)) {
                    var ldata = {userinp:inp,password:pass};
                    if (!$('.code').hasClass('hide')) {
                        code = $.trim($('#veri').val());
                        if (!checkCode(code)) {
                            return false;
                        }
                        ldata.code = code;
                    }
                    $.ajax({
                        url: '/dologin',
                        type: 'post',
                        dataType: 'json',
                        async: true,
                        data: ldata,
                        success:function(data){
                            if (data.code == '0') {
                                // globalTip({'msg':'登录成功!','setTime':3,'jump':true,'URL':'http://www.ui.cn'});
                                globalTip(data.msg);
                            } else if(data.code == '2') {
                                $(".log-btn").off('click').addClass("off");
                                $('.pass-err').removeClass('hide').find('em').text(data.msg);
                                $('.pass-err').find('i').attr('class', 'icon-warn').css("color","#d9585b");
                            } else if(data.code == '3') {
                                $(".log-btn").off('click').addClass("off");
                                $('.img-err').removeClass('hide').find('em').text(data.msg);
                                $('.img-err').find('i').attr('class', 'icon-warn').css("color","#d9585b");
                                $('.code').removeClass('hide');
                                $('.code').find('img').attr('src','/verifyCode?'+Math.random()).click(function(event) {
                                    $(this).attr('src', '/verifyCode?'+Math.random());
                                });
                                return false;
                            } else if(data.code == '1'){
                                $(".log-btn").off('click').addClass("off");
                                $('.num-err').removeClass('hide').find('em').text(data.msg);
                                $('.num-err').find('i').attr('class', 'icon-warn').css("color","#d9585b");
                                return false;
                            }
                        },
                        error:function(){
                            
                        }
                    });
                } else {
                    return false;
                }
            });
        } else {
            $(".log-btn").click(function(){
                // var type = 'phone';
                var phone = $.trim($('#num2').val());
                var pcode = $.trim($('#veri-code').val());
                if (checkPhone(phone) && checkPass(pcode)) {
                    $.ajax({
                        url: '/plogin',
                        type: 'post',
                        dataType: 'json',
                        async: true,
                        data: {phone:phone,code:pcode},
                        success:function(data){
                            if (data.code == '0') {
                                // globalTip({'msg':'登录成功!','setTime':3,'jump':true,'URL':'http://www.ui.cn'});
                                globalTip(data.msg);
                            } else if(data.code == '1') {
                                $(".log-btn").off('click').addClass("off");
                                $('.num2-err').removeClass('hide').text(data.msg);
                                return false;
                            } else if(data.code == '2') {
                                $(".log-btn").off('click').addClass("off");
                                $('.error').removeClass('hide').text(data.msg);
                                return false;
                            }
                        },
                        error:function(){
                            
                        }
                    });
                } else {
                    $(".log-btn").off('click').addClass("off");
                    // $('.tel-warn').removeClass('hide').text('登录失败');
                    return false;
                }
            });
        }
    }

    // 登录的回车事件
    $(window).keydown(function(event) {
        if (event.keyCode == 13) {
            $('.log-btn').trigger('click');
        }
    });


    $(".form-data").delegate(".send","click",function () {
        var phone = $.trim($('#num2').val());
        if (checkPhone(phone)) {
                $.ajax({
                    url: '/getcode',
                    type: 'post',
                    dataType: 'json',
                    async: true,
                    data: {phone:phone,type:"login"},
                    success:function(data){
                        if (data.code == '0') {
                            
                        } else {
                            
                        }
                    },
                    error:function(){
                        
                    }
                });
            var oTime = $(".form-data .time"),
            oSend = $(".form-data .send"),
            num = parseInt(oTime.text()),
            oEm = $(".form-data .time em");
            $(this).hide();
            oTime.removeClass("hide");
            var timer = setInterval(function () {
            var num2 = num-=1;
                oEm.text(num2);
                if(num2==0){
                    clearInterval(timer);
                    oSend.text("重新发送验证码");
                    oSend.show();
                    oEm.text("120");
                    oTime.addClass("hide");
                }
            },1000);
        }
    });
    var handler = function (captchaObj) {
        captchaObj.appendTo('.captcha');
        captchaObj.onReady(function () {
            $(".wait").hide();
        });
        $('.log-btn').click(function () {
            var result = captchaObj.getValidate();
            console.log('captchaObj2',captchaObj.getValidate());
            console.log(hex_md5($('#pass').val()));
            if (!result) {
                $('.num-err').removeClass('hide').find('em').text('请先完成验证');
                $('.num-err').find('i').attr('class', 'icon-warn').css("color","#d9585b");
                $('.pass-err').removeClass('hide').find('em').text('请先完成验证');
                $('.pass-err').find('i').attr('class', 'icon-warn').css("color","#d9585b");
                return;
            }
            if(!$('#num').val()&&!$('#pass').val()){
                $('.num-err').removeClass('hide').find('em').text('请输入用户名');
                $('.num-err').find('i').attr('class', 'icon-warn').css("color","#d9585b");
                $('.pass-err').removeClass('hide').find('em').text('请输入密码');
                $('.pass-err').find('i').attr('class', 'icon-warn').css("color","#d9585b");
                return;
            }else if(!$('#num').val()&&$('#pass').val()){
                $('.num-err').removeClass('hide').find('em').text('请输入用户名');
                $('.num-err').find('i').attr('class', 'icon-warn').css("color","#d9585b");
                return;
            }else if($('#num').val()&&!$('#pass').val()){
                $('.pass-err').removeClass('hide').find('em').text('请输入密码');
                $('.pass-err').find('i').attr('class', 'icon-warn').css("color","#d9585b");
                return;
            }else{
                $('.num-err').addClass('hide');
                $('.pass-err').addClass('hide');
            }
            $.ajax({
                url: "/admin/verify",
                type: 'post',
                dataType: 'json',
                data: {
                    user: $('#num').val(),
                    password: hex_md5($('#pass').val()),
                    geetest_challenge: result.geetest_challenge,
                    geetest_validate: result.geetest_validate,
                    geetest_seccode: result.geetest_seccode
                },
                success: function (data,status,xhr) {
                        if(data['flag']=="OK"){
                            window.location.href=data['url'].substring(1,data['url'].length-1);
                        }else{
                            //$("#tip").text(data['flag']);
                            $(".log-btn").addClass("off");
                            $('.num-err').removeClass('hide').find('em').text(data['flag']);
                            $('.num-err').find('i').attr('class', 'icon-warn').css("color","#d9585b");
                            $('.pass-err').removeClass('hide').find('em').text(data['flag']);
                            $('.pass-err').find('i').attr('class', 'icon-warn').css("color","#d9585b");
                            captchaObj.reset();
                        }
                },
                error: function (data,status,xhr) {
                    console.log(data);
                    console.log(status);
                    console.log(xhr);
                    captchaObj.reset();
                },
            });
        })
    };
    $.ajax({
        url: "/admin/check?t=microtime()",
        type: "get",
        dataType: "json",
        success: function (data) {
            $('.text').hide();
            $('.wait').show();
            initGeetest({
                gt: data.gt,
                challenge: data.challenge,
                offline: !data.success, 
                new_captcha: data.new_captcha, 
                product: "embed",
                width: '100%'
            }, handler);
        }
    });
});
