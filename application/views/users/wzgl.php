
          <?php require 'left.php';?>
      <div class="col-10 col-lg-10 offset-md-2 offset-lg-2 .no-gutters qz-right">
          <?php if(!empty($action) && $action == 'list'):?>
          <?php require 'wzlb.php';?>
          <?php elseif(!empty($action) && $action == 'hsz'):?>
          <?php require 'hsz.php';?>
          <?php elseif(!empty($action) && $action == 'edit'):?>
                <?php if(!empty($article)):?>
                <?php echo $html->includeJs('kindeditor-min');?>
                <script>
                KE.show({
                        id : "editor_id",
                        width: "100%",
                        height: "750px",
                        resizeMode : 0
                })
                </script>
                <form class="qz-form" method="post" action=<?php echo $html->url('admin/write/update/id/'.$article['Article']['id']);?> >
                    <div class="row">
                        <div class="col-12">
                            <input type="text"  name="title" value="<?php echo $article['Article']['title'];?>">
                        </div>
                    </div>
                    <div class="row">
                          <div class="col-12">
                            <textarea id="editor_id"  name="content">
                            <?php echo htmlentities($article['Article']['content']);?>
                            </textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <span>
                                分类：
                                <select name="classid">
                                    <?php foreach($users as $parent):?>
                                        <?php if(empty($parent['Parent']['id'])):?>
                                            <option <?php if($article['Article']['category_id']==$parent['Son']['id']){echo 'selected="selected"';}?> value="<?php echo $parent['Son']['id']?>" >
                                              <?php echo $parent['Son']['name']?> 
                                            </option>
                                            <?php foreach($users as $sub):?>
                                              <?php if($sub['Son']['parent_id']==$parent['Son']['id']):?>
                                                <?php if($article['Article']['category_id']==$sub['Son']['id']):?>
                                                <?php echo "<option selected='selected' value='".$sub['Son']['id']."'>".str_repeat('　',1)."|-{$sub['Son']['name']}</option>";?>
                                                <?php else:?>
                                                <?php echo "<option value='".$sub['Son']['id']."'>".str_repeat('　',1)."|-{$sub['Son']['name']}</option>";?>
                                                <?php endif?>
                                              <?php endif?>
                                            <?php endforeach?>
                                        <?php endif?>
                                    <?php endforeach?>
                                </select>
                            </span>
                            <span>
                                <input type="checkbox" name="top" value="top" <?php if($article['Article']['flag']==2){echo 'checked="checked"';}?>/> 置顶
                            </span>
                            <span>
                                <input type="checkbox" name="view" value="view"<?php if($article['Article']['isview']==1){echo 'checked="checked"';}?> /> 显示
                            </span>
                            <span>
                                <input type="submit" value="发布" />
                            </span>
                        </div>
                    </div>
                </form>
              <?php endif?>
          <?php else:?>
          <?php require 'error.php'?>
          <?php endif?>
      </div>
