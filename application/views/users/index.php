
      <?php require 'left.php';?> 
      <div class="col-10 col-lg-10 offset-md-2 offset-lg-2 .no-gutters qz-right">
            <h1 class="page-header">概览</h1>  
            <div class="row placeholders">
              <div class="col-xs-6 col-sm-3 placeholder">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                <h4>一级分类</h4>
                <span class="text-muted"><?php echo $levelOneNumber; ?>个</span>
              </div>
              <div class="col-xs-6 col-sm-3 placeholder">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                <h4>二级分类</h4>
                <span class="text-muted"><?php echo $levelTwoNumber; ?>个</span>
              </div>
              <div class="col-xs-6 col-sm-3 placeholder">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                <h4>已发文章</h4>
                <span class="text-muted"><?php echo $postNumber;?>篇</span>
              </div>
              <div class="col-xs-6 col-sm-3 placeholder">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                <h4>草稿箱</h4>
                <span class="text-muted"><?php echo $recycleNumber;?>篇</span>
              </div>
              <?php echo $_SERVER['PHP_SELF'];?> 
              <?php echo dirname($_SERVER['PHP_SELF']);echo dirname(dirname(dirname(dirname(__FILE__)))) ;?> 
      </div>

