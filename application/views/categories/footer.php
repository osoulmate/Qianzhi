    <!-- 上接正文区域 如index.php,article.php等-->
    </div>
    <div id="wrapper" style="margin-bottom:0;">
    <!-- Footer -->
    <footer class="footer-container d-flex text-center qz-footer-bg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 d-flex justify-content-center order-md-2 order-1">
                    <div class="footer-social qz-footer-a2">
                        <a href="#"><i class="zi zi_tmQq zi_1x"></i></a>
                        <a href="#"><i class="zi zi_tmWeixin zi_1x"></i></a>
                        <a target="_blank" href="https://github.com/osoulmate"><i class="zi zi_tmGithub zi_1x"></i></a>
                        <a target="_blank" href="https://gitee.com/osoulmate"><i class="zi zi_tmGitee zi_1x"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 justify-content-center qz-footer-a2">
                    <span style="color: #7f7f7f;">&copy; 2018 osoulmate &nbsp;&nbsp;</span>
                    <a href="https://beian.miit.gov.cn/" rel="nofollow" target="_blank">豫ICP备18016282号&nbsp;&nbsp;</a>
                    <?php echo $html->link('版权信息','版权信息','','','rel="nofollow"  target="_blank" ')?>
                    &nbsp;&nbsp;
                    <?php echo $html->link('关于本站','关于本站','','','rel="nofollow"  target="_blank" ')?>
                    &nbsp;&nbsp;
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-12 d-flex justify-content-center order-md-2 order-1">
                    <p>千知，永无止境</p>
                </div>
            </div>
        </div>
    </footer>
    </div>
    <!-- End of Footer -->

    <!-- Back to Top Button -->
    <div class="back-to-top d-flex align-items-center justify-content-center">
        <span><i class="fa fa-long-arrow-up"></i></span>
    </div>
    <!-- End of Back to Top Button -->    

    <!-- JS Files -->

    <!-- ==== Bootstrap js file ==== -->
    <?php echo $html->includeJsEx("assets/js/bootstrap.bundle.min"); echo PHP_EOL;?>

    <!-- ==== Owl Carousel ==== -->
    <?php echo $html->includeJsEx("assets/plugins/owl-carousel/owl.carousel.min"); echo PHP_EOL;?>

    <!-- ==== Magnific Popup ==== -->
    <?php echo $html->includeJsEx("assets/plugins/magnific-popup/jquery.magnific-popup.min"); echo PHP_EOL;?>
     
    <!-- ==== Script js file ==== -->
    <?php echo $html->includeJsEx("assets/js/scripts"); echo PHP_EOL;?>

    <!-- ==== Custom js file ==== -->
    <?php echo $html->includeJsEx("assets/js/custom"); echo PHP_EOL;?>
<script type="text/javascript">
function switchNightMode(){
    var night = document.cookie.replace(/(?:(?:^|.*;\s*)night\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
    if(night == '0'){
        document.body.classList.add('night');
        document.cookie = "night=1;path=/"
        console.log('深色模式开启');
    }else{
        document.body.classList.remove('night');
        document.cookie = "night=0;path=/"
        //console.log('深色模式关闭');
    }
}
</script>
</body>
</html>


