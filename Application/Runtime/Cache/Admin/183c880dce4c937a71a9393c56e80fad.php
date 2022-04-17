<?php if (!defined('THINK_PATH')) exit();?><style>
    .ui_pop_foot{
        background-color:#F4F5F9;border-top:1px solid #ddd;text-align:right;
        position:absolute;padding:8px 0;bottom:0;left:0;width:100%;
    }
</style> 
<form class="clearfix" action="<?php echo U('useredit');?>" method="post" onsubmit="return Juuz.ajaxForm(this);">
    <div class="ui_col_10" style="padding:10px 20px 62px">
        <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>">
        <div class="ui_col_5">
            <label class="ui_label">用户帐号 : </label>
            <input class="ui_text_input" type="text" name="username" value="<?php echo ($info["username"]); ?>" data-opt='{
                type : "require",
                msg : "请输入用户帐号"
            }' />
        </div>
        <div class="ui_col_3">
            <div class="ui_col_2">
                <label class="ui_label">排序 : </label>
                <input class="ui_text_input" name="sort" data-opt='{
                    type : "require number",
                    msg : "请输入顺序 排序只能是数字"
                }' <?php if(($info["sort"]) == ""): ?>value="99"<?php else: ?>value="<?php echo ($info["sort"]); ?>"<?php endif; ?> />
 
            </div>
        </div>
        <div class="ui_col_5">
            <?php if($info == null): ?><label class="ui_label">用户密码 : </label>
                <input class="ui_text_input" name="password" type="password" value="<?php echo ($info["password"]); ?>" data-opt='{
                type : "require password",
                msg : "请输入用户密码 密码只能是6-16位字符"
            }'  />
            <?php else: ?>
                <label class="ui_label">最新密码 : </label>
                <input class="ui_text_input"  name="regpassword" type="password" value="" /><?php endif; ?>
        </div>
        <div class="ui_col_5">
            <label class="ui_label">用户姓名: </label>
            <input class="ui_text_input" name="name" type="text"  value="<?php echo ($info["name"]); ?>" data-opt='{
                type : "require",
                msg : "请输入用户姓名"
            }'/>
        </div>
        <div class="ui_col_5">
            <label class="ui_label">邮箱地址: </label>
            <input class="ui_text_input"  name="email" type="text" value="<?php echo ($info["email"]); ?>" data-opt='{
                type : "require email",
                msg : "请输入邮箱地址 邮箱格式不正确"
            }'/>
        </div>
        <div class="ui_col_5">
            <label class="ui_label">电话号码: </label>
            <input class="ui_text_input" name="phone"  type="text"  value="<?php echo ($info["phone"]); ?>" data-opt='{
                type : "require phone",
                msg : "请输入手机号码 手机格式不正确"
            }'/>
        </div>
        
        <div class="ui_col_10">
            <div class="ui_checkbox_wrap">
                <label class="ui_label">请选择权限分组</label>
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><label class="ui_checkbox">
                        <input type="checkbox" value="<?php echo ($vo["id"]); ?>" name="group_id[]" <?php if(in_array(($vo["id"]), is_array($group_id)?$group_id:explode(',',$group_id))): ?>checked<?php endif; ?>/><?php echo ($vo["title"]); ?>
                    </label><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>

    </div>
    <div class="ui_pop_foot">
        <button type="submit" class="ui_button small mr10">提 交</button>
    </div>
</form>