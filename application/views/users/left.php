      <div class="col-2 col-lg-2 .no-gutters qz-left">
        <ul>
            <?php if(isset($menu)){
                foreach ($menu as $key => $value) {
                    if(is_array($value['sub'])){?>
                    <li>
                        <a href="javascript:void(0);">
                            <i class="<?php echo $value['icon'] ?>"></i>
                            <?php echo $value['name'];
                            if($value['status']){?>
                                <i class="fa fa-angle-up arrow"></i>
                            <?php }else{?>
                                <i class="fa fa-angle-down arrow"></i>
                            <?php }?>
                        </a>
                        <?php foreach ($value['sub'] as $k => $v) {?>
                            <?php if($value['status']){?>
                                <div style="display: block;">
                            <?php }else{?>
                            <div style="display:none;">
                            <?php }?>
                                <?php if($v['status']){
                                    echo $html->link($v['name'],
                                                    $v['url'],
                                                    null,
                                                    "",
                                                    " style='color: #009688;background: #28313c;' ");
                                }else{
                                    echo $html->link($v['name'],$v['url']);
                                }?>
                            </div>
                        <?php }?>
                    </li>
                <?php }else {?>
                    <li>
                        <?php if($value['status']){
                            echo $html->link('<i class="'.$value['icon'].'"></i>'.$value['name'],
                                            $value['url'],
                                            null,
                                            "",
                                            "style='color: #009688;background: #28313c;' ");
                        }else{
                            echo $html->link('<i class="'.$value['icon'].'"></i>'.$value['name'],$value['url']);
                        }?>
                    </li>
                <?php }
                }
            }?>
        </ul>
    </div>