    <div class="container">
        <div class="row" style="margin-bottom: 30px;">
            <div class="col-sm-12 col-md-12 col-lg-12">
        <?php if(!empty($error_page)):?>
        <?php require_once ('notfound.php');echo "</div>";?>
        <?php else:?>
                <?php if (!empty($article)):?>
                <?php if (!empty($article[0]['Article'])):?>
                <?php foreach ($categories as $category):?>
                  <?php if ($article[0]['Article']['category_id']==$category['Category']['id']):?>
                    <section><p>当前位置：<?php echo $category['Category']['name'];?></p></section>
                  <?php endif?>
                <?php endforeach?>
                <?php $date = mb_substr($article[0]['Article']['date'],0,10,'utf-8');
                  $dateFormat = explode('-', $date);
                  $dateFormat = implode('/', $dateFormat);
                  ?>
                <div class="post-default post-has-no-thumb">
                    <div class="post-data">
                        <div class="title">
                            <h2><?php echo $html->link($article[0]['Article']['title'],$dateFormat.'/'.$article[0]['Article']['title']) ?></h2>
                        </div>
                        <!-- Post Meta -->
                        <ul class="nav meta align-items-center">
                            <li class="meta-author">
                                <a href="#"><?php echo $article[0]['Article']['author']?></a>
                            </li>
                            <li class="meta-date"><a href="#"><?php echo  $dateFormat;?></a></li>
                            <li class="meta-view"><a href="#"><i class="fa fa-eye"></i><?php echo $article[0]['Article']['hits'];?></a></li>
                            <li class="meta-comments">
                                <a href="#comment-area">
                                    <i class="fa fa-comment"></i>
                                    <?php if(isset($comment_num) && !empty($comment_num[$article[0]['Article']['id']])) {echo $comment_num[$article[0]['Article']['id']];}else{echo 0;}?>
                                </a>
                            </li>
                        </ul>
                        <!-- Post Desc -->
                        <div class="desc">
                            <div>
                                <?php echo $article[0]['Article']['content'];?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif;?>
                <ul style="margin:20px 0px 10px 0px;padding:0px;list-style-type: none;">
                    <?php if (empty($previous) && !empty($next)): 
                        $date = mb_substr($next[0]['Article']['date'],0,10,'utf-8');
                        $dateFormat = implode('/',explode('-', $date));
                    ?> 
                    <li>上一篇：<a href="#">没有了</a></li>
                    <li>下一篇：<?php echo $html->link($next[0]['Article']['title'],$dateFormat.'/'.$next[0]['Article']['index_id']);?></li>
                    <?php elseif (!empty($previous) && empty($next)):
                        $date = mb_substr($previous[0]['Article']['date'],0,10,'utf-8');
                        $dateFormat = implode('/',explode('-', $date));
                    ?> 
                    <li>上一篇：<?php echo $html->link($previous[0]['Article']['title'],$dateFormat.'/'.$previous[0]['Article']['index_id']);?></li>
                    <li>下一篇：<a href="#">没有了</a></li>
                    <?php elseif (empty($previous) && empty($next)):?>
                    <li>上一篇：<a>没有了</a></li>
                    <li>下一篇：<a>没有了</a></li>
                    <?php else:
                        $datePrevious = mb_substr($previous[0]['Article']['date'],0,10,'utf-8');
                        $datePreviousFormat = implode('/',explode('-', $datePrevious));
                        $dateNext = mb_substr($next[0]['Article']['date'],0,10,'utf-8');
                        $dateNextFormat = implode('/',explode('-', $dateNext));
                    ?>
                    <li>上一篇：<?php echo $html->link($previous[0]['Article']['title'],$datePreviousFormat.'/'.$previous[0]['Article']['index_id'])?></li>
                    <li>下一篇：<?php echo $html->link($next[0]['Article']['title'],$dateNextFormat.'/'.$next[0]['Article']['index_id'])?></li>
                    <?php endif;?>
                </ul>
                <?php endif;?> 
            </div>
        </div>
        <div class="row" style="margin-bottom: 10px;">
            <div class="col-sm-7 col-md-7 col-lg-7 qz-news">
                <?php if (!empty($titlehash)):?>
                <?php //echo $titlehash;?>
                <?php endif?>
                <?php if (!empty($article[0]['Article'])):?>
                <?php require 'comment.php';?>
                <?php endif?>
            </div>
        </div>
        <?php endif?>
    </div>






