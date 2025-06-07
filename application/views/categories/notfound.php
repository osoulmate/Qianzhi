    <div class="container container-404 text-center d-flex align-items-center">
        <div class="data">
            <h1>404</h1>
            <h2>Page Not Found!</h2>
            <p>你访问的页面不存在，请检查访问链接是否正确或者返回<a href="/">首页.</a></p>

            <form class="search-form" method="post" action="/search">
                <div class="input-group">
                    <input type="text" class="form-control" name="key" placeholder="Search..." style="text-decoration: none;outline: none !important;border: 0px;box-shadow: none;padding: 0px 20px;min-height: 52px;">
                    <div class="input-group-append">
                        <button class="btn">
                        	<?php echo $html->includeimgEx("assets/images/search-icon.svg",' class="img-fluid svg" alt="" '); echo PHP_EOL;?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
