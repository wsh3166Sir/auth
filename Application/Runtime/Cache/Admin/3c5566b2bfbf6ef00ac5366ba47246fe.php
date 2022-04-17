<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta name="keywords" content="后台管理系统" />
<meta name="description" content="Juuz管理平台" />

<link rel="shortcut icon" href="favicon.ico" />
<link rel="bookmark" href="favicon.ico" />
<link rel="stylesheet" href="/auth/Public/Admin/Css/Base.css" />
<link rel="stylesheet" href="/auth/Public/Admin/Css/Manage.css" />
<script>
    var CONF = {
        UMEDITOR_HOME_URL : "/auth/Public/Admin/Js/Plugin/UMEditor/",
        UMEDITOR_IMAGEURL : "<?php echo U('Admin/Public/editUpload');?>",
        UMEDITOR_IMAGEPATH: "<?php echo C('WEB_DOMAIN');?>",

        UPLOAD_SWF_DIR : "/auth/Public/Admin/Js/Plugin/Swfupload/",
        UPLOAD_PHP_FILE : "<?php echo U('Admin/Public/flashupload');?>"
    }
</script>

<script src="/auth/Public/Admin/Js/Jquery/jquery-1.8.0.min.js"></script>
<!-- Template模板 -->
<script src="/auth/Public/Admin/Js/Template/template-native.js"></script>
<script src="/auth/Public/Admin/Js/Template/tpl.js"></script>
<!-- ArtDialog弹出框 -->
<link rel="stylesheet" href="/auth/Public/Admin/Js/ArtDialog/dialog.css" />
<script src="/auth/Public/Admin/Js/ArtDialog/dialog.min.js"></script>
<!-- json转换 -->
<script src="/auth/Public/Admin/Js/Plugin/Json/json2.js"></script>
<!-- mydata97日期插件 -->
<script src="/auth/Public/Admin/Js/Plugin/MyData97/WdatePicker.js"></script>
<!-- UMEdit编辑器 -->
<link rel="stylesheet" href="/auth/Public/Admin/Js/Plugin/UMEditor/themes/default/css/umeditor.css" />
<script src="/auth/Public/Admin/Js/Plugin/UMEditor/umeditor.config.js"></script>
<script src="/auth/Public/Admin/Js/Plugin/UMEditor/umeditor.js"></script>
<!-- kindEditor编辑器 -->
<link rel="stylesheet" href="/auth/Public/Admin/Js/Plugin/kindEditor/themes/default/default.css" />
<script src="/auth/Public/Admin/Js/Plugin/kindEditor/kindeditor.js"></script>
<script src="/auth/Public/Admin/Js/Plugin/kindEditor/zh_CN.js"></script>
<!-- 下拉选择框插件 -->
<script src="/auth/Public/Admin/Js/Plugin/jquery.select.js"></script>
<!-- 用户插件 -->
<script src="/auth/Public/Admin/Js/Plugin/jquery.user.js"></script>
<script src="/auth/Public/Admin/Js/Plugin/jquery.resize.js"></script>
<!-- swf图片上传 -->
<script src="/auth/Public/Admin/Js/Plugin/Swfupload/swfupload.js"></script>
<script src="/auth/Public/Admin/Js/Plugin/Swfupload/swfupload-handlers.js"></script>
<!-- 树形控件 -->
<link rel="stylesheet" href="/auth/Public/Admin/Js/Plugin/Ztree/css/zTreeStyle.css" />
<script src="/auth/Public/Admin/Js/Plugin/Ztree/jquery.ztree.core-3.5.min.js"></script>
<script src="/auth/Public/Admin/Js/Plugin/Ztree/jquery.ztree.excheck-3.5.min.js"></script>
<script src="/auth/Public/Admin/Js/Plugin/Ztree/jquery.ztree.exedit-3.5.min.js"></script>
<!-- 图表jsChart -->
<script src="/auth/Public/Admin/Js/Plugin/Highcharts/highcharts.js"></script>
<script src="/auth/Public/Admin/Js/Plugin/Highcharts/highcharts-3d.js"></script>
<!-- 颜色选择器 -->
<link rel="stylesheet" href="/auth/Public/Admin/Js/Plugin/minicolors/jquery.minicolors.css" />
<script src="/auth/Public/Admin/Js/Plugin/minicolors/jquery.minicolors.min.js"></script>
<!-- 核心js -->
<script src="/auth/Public/Admin/Js/Juuz/Juuz.js"></script>
<script src="/auth/Public/Admin/Js/Manage/Manage.js"></script>

    <title>登陆</title>
</head>
<body>
    <div id="loginWarp">
        <div class="login_warp_main">
            <div class="login_head">
                <img title="Juuz" src="/auth/Public/Admin/Images/logo_login.png" />
                <span>后台管理系统</span>
            </div>
            <div class="login_content">
                <div class="login_form">
                    <span class="login_jiantou"></span>
                    <form action="<?php echo U('islogin');?>" method="post" onsubmit=" (function(e){return Juuz.ajaxForm(e)})(this) ;">
                                            <div class="login_username">
                            <img src="/auth/Public/Admin/Images/login_img_username.jpg" />
                            <input type="text" name="username" data-opt='{
                                type : "require",
                                msg : "请输入用户名"
                            }' placeholder="请输入用户名" />
                        </div>
                        <div class="login_password">
                            <img src="/auth/Public/Admin/Images/login_img_pwd.jpg" />
                            <input type="password" name="password" data-opt='{
                                type : "require",
                                msg : "请输入密码"
                            }' placeholder="请输入密码" />
                        </div>
                        <div class="login_code">
                            <i><img src="/auth/Public/Admin/Images/login_img_code.jpg" /></i>
                            <input type="text" name="verify" placeholder="请输入验证码" />
                            <img src="<?php echo U('code');?>" class="code_img" onclick="change(this)" />
                            <script>
                                var __url = "<?php echo U('code');?>";
                                function change(img){
                                    img.src =  __url +'?t='+ Math.random();
                                }
                            </script>
                        </div>
                        <button type="submit" class="login_bt_submit">登 录</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>