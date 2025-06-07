    <div class="container" style="margin-bottom:10px">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
            <?php if(!empty($pageL)):?>
            <?php echo "<pre>";print_r($pageL);echo "</pre>";?>
            <?php else:?>
            	<?php if (!empty($article)):?>
                <?php foreach ($article as $article):?> 
                <?php $date = mb_substr($article['Article']['date'],0,10,'utf-8');
                  $dateFormat = explode('-', $date);
                  $dateFormat = implode('/', $dateFormat);
                  ?>
                <div class="post-default post-has-no-thumb">
                    <div class="post-data">
                        <div class="title">
                            <h2><?php echo $html->link($article['Article']['title'],$dateFormat.'/'.$article['Article']['index_id']) ?></h2>
                        </div>
                        <!-- Post Meta -->
                        <ul class="nav meta align-items-center">
                            <li class="meta-author">
                                <a href="#"><?php echo $article['Article']['author'];?></a>
                            </li>
                            <li class="meta-date"><a href="#"><?php echo  $dateFormat;?></a></li>
                            <li class="meta-view"><a href="#"><i class="fa fa-eye"></i><?php echo $article['Article']['hits'];?></a></li>
                            <li class="meta-comments">
                                <a href="#">
                                    <i class="fa fa-comment"></i>
                                    <?php if(isset($comment_num) && !empty($comment_num[$article['Article']['id']])) {echo $comment_num[$article['Article']['id']];}else{echo 0;}?>
                                </a>
                            </li>
                        </ul>
                        <!-- Post Desc -->
                        <div class="desc">
                            <p>
                                <?php echo mb_substr(strip_tags($article['Article']['content'],'<br>'),0,150,'utf-8')?>
                            </p>
                        </div>
                        <div class="title" style="margin-top: 20px;font-weight:bold;">
                            <em><?php echo $html->link('继续阅读',$dateFormat.'/'.$article['Article']['index_id']) ?></em>
                        </div>
                    </div>
                </div>
                <?php endforeach?>
            	<?php endif?>
            <?php endif?>
            </div>
        </div>
    </div>



