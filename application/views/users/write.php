<?php echo $html->includeJs('kindeditor-min');?>
<script>
KE.show({
        id : "editor_id",
        width: "100%",
        height: "680px",
        resizeMode : 0 //编辑器只能调整高度
})
</script>
            <?php require 'left.php';?>
        <div class="col-10 col-lg-10 offset-md-2 offset-lg-2 .no-gutters qz-right">
                <form class="qz-form" method="post" action=<?php echo $html->url('admin/write/add');?> >
                    <div class="row">
                        <div class="col-12">
                            <input type="text"  name="title" placeholder="<?php echo $title;?>">
                        </div>
                    </div>
                    <div class="row">
                          <div class="col-12">
                            <textarea id="editor_id"  name="content">
                            <?php if(isset($content)){echo $content;}?>
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
                                            <option 
                                                value="<?php echo $parent['Son']['id']?>"><?php echo $parent['Son']['name']?> 
                                            </option>
                                            <?php foreach($users as $sub):?>
                                                <?php if(($sub['Son']['parent_id'])==$parent['Son']['id']):?>
                                                <?php echo "<option value='".$sub['Son']['id']."'>".str_repeat('　',1)."|-{$sub['Son']['name']}</option>";?>
                                                <?php endif?>
                                            <?php endforeach?>
                                        <?php endif?>
                                    <?php endforeach?>
                                </select>
                            </span>
                            <span>
                                <input type="checkbox" name="top" value="top"/> 置顶
                            </span>
                            <span>
                                <input type="checkbox" name="view" value="view"/> 显示
                            </span>
                            <span>
                                <input type="submit" value="发布" />
                            </span>
                        </div>
                    </div>
                </form>
          </div>
