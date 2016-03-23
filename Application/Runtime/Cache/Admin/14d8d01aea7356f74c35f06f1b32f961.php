<?php if (!defined('THINK_PATH')) exit();?>    <!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta name="keywords" content="后台管理系统" />
<meta name="description" content="Juuz管理平台" />

<link rel="shortcut icon" href="favicon.ico" />
<link rel="bookmark" href="favicon.ico" />
<link rel="stylesheet" href="/Public/Admin/Css/Base.css" />
<link rel="stylesheet" href="/Public/Admin/Css/Manage.css" />
<script>
    var CONF = {
        UMEDITOR_HOME_URL : "/Public/Admin/Js/Plugin/UMEditor/",
        UMEDITOR_IMAGEURL : "<?php echo U('Admin/Public/editUpload');?>",
        UMEDITOR_IMAGEPATH: "<?php echo C('WEB_DOMAIN');?>",

        UPLOAD_SWF_DIR : "/Public/Admin/Js/Plugin/Swfupload/",
        UPLOAD_PHP_FILE : "<?php echo U('Admin/Public/flashupload');?>"
    }
</script>

<script src="/Public/Admin/Js/Jquery/jquery-1.8.0.min.js"></script>
<!-- Template模板 -->
<script src="/Public/Admin/Js/Template/template-native.js"></script>
<script src="/Public/Admin/Js/Template/tpl.js"></script>
<!-- ArtDialog弹出框 -->
<link rel="stylesheet" href="/Public/Admin/Js/ArtDialog/dialog.css" />
<script src="/Public/Admin/Js/ArtDialog/dialog.min.js"></script>
<!-- json转换 -->
<script src="/Public/Admin/Js/Plugin/Json/json2.js"></script>
<!-- mydata97日期插件 -->
<script src="/Public/Admin/Js/Plugin/MyData97/WdatePicker.js"></script>
<!-- UMEdit编辑器 -->
<link rel="stylesheet" href="/Public/Admin/Js/Plugin/UMEditor/themes/default/css/umeditor.css" />
<script src="/Public/Admin/Js/Plugin/UMEditor/umeditor.config.js"></script>
<script src="/Public/Admin/Js/Plugin/UMEditor/umeditor.js"></script>
<!-- kindEditor编辑器 -->
<link rel="stylesheet" href="/Public/Admin/Js/Plugin/kindEditor/themes/default/default.css" />
<script src="/Public/Admin/Js/Plugin/kindEditor/kindeditor.js"></script>
<script src="/Public/Admin/Js/Plugin/kindEditor/zh_CN.js"></script>
<!-- 下拉选择框插件 -->
<script src="/Public/Admin/Js/Plugin/jquery.select.js"></script>
<!-- 用户插件 -->
<script src="/Public/Admin/Js/Plugin/jquery.user.js"></script>
<script src="/Public/Admin/Js/Plugin/jquery.resize.js"></script>
<!-- swf图片上传 -->
<script src="/Public/Admin/Js/Plugin/Swfupload/swfupload.js"></script>
<script src="/Public/Admin/Js/Plugin/Swfupload/swfupload-handlers.js"></script>
<!-- 树形控件 -->
<link rel="stylesheet" href="/Public/Admin/Js/Plugin/Ztree/css/zTreeStyle.css" />
<script src="/Public/Admin/Js/Plugin/Ztree/jquery.ztree.core-3.5.min.js"></script>
<script src="/Public/Admin/Js/Plugin/Ztree/jquery.ztree.excheck-3.5.min.js"></script>
<script src="/Public/Admin/Js/Plugin/Ztree/jquery.ztree.exedit-3.5.min.js"></script>
<!-- 图表jsChart -->
<script src="/Public/Admin/Js/Plugin/Highcharts/highcharts.js"></script>
<script src="/Public/Admin/Js/Plugin/Highcharts/highcharts-3d.js"></script>
<!-- 颜色选择器 -->
<link rel="stylesheet" href="/Public/Admin/Js/Plugin/minicolors/jquery.minicolors.css" />
<script src="/Public/Admin/Js/Plugin/minicolors/jquery.minicolors.min.js"></script>
<!-- 核心js -->
<script src="/Public/Admin/Js/Juuz/Juuz.js"></script>
<script src="/Public/Admin/Js/Manage/Manage.js"></script>
    <title>标题</title>
</head>
<body>
    <!-- 头部 -->
    <div class="heade" id="header">
    <div class="head_box">
        <h1 class="logo">
            <a href="#" title="Juuz"><img src="/Public/Admin/Images/logo_header.png" /></a>
        </h1>
        <div class="account">
            <span class="account_bg_left"></span>
            <span class="account_bg_right"></span>
            <span class="account_welcom">当前用户：<strong><?php echo ($UserName); ?></strong></span>
            <a href="javascript:void(0);" class="account_update" target="popDialog">修改密码</a>
            <a href="<?php echo U('Admin/Public/logout');?>" class="account_logout">安全退出</a>
        </div>
        <div class="head_menu">
            <?php if(is_array($web_top_menu_url)): $i = 0; $__LIST__ = $web_top_menu_url;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo ($vo["url"]); ?>" <?php if((MODULE_NAME) == $vo['module']): ?>class='selected'<?php endif; ?>><?php echo ($vo["title"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
</div>
    <div class="body">
        <div class="inner clearfix">
            <div class="col_side">
               <?php
$name = CONTROLLER_NAME; ?>
<div class="menu_box">
    <dl class="menu first">
        <dt class="menu_title">
            <i class="icon_menu"><img src="/Public/Admin/Images/icon_menu_function.png"/></i>平台信息
        </dt>
        <dd class='menu_item <?php if((CONTROLLER_NAME) == "Index"): ?>active<?php endif; ?>'>
            <a href="<?php echo U('Index/index');?>">站点首页</a>
        </dd>
    </dl>
    <dl class="menu">
        <dt class="menu_title">
            <i class="icon_menu"><img src="/Public/Admin/Images/icon_menu_management.png"/></i>内容管理
        </dt>

        <?php if(is_array($menu_url)): $i = 0; $__LIST__ = $menu_url;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $url = explode('/', $vo['name']); $cname = $url[2]; ?>
            <dd class='menu_item <?php if(($cname) == $name): ?>active<?php endif; ?>'>
                <a href="<?php echo $vo['name'];?>"><?php echo ($vo["title"]); ?></a>
            </dd><?php endforeach; endif; else: echo "" ;endif; ?>
    </dl>
</div>

            </div>
            <div class="col_main">
                <div class="main_hd">
                    <h2>列表标题</h2>
                    <div class="title_tab">
                        <ul class="tab_ul dib-wrap">
                            <?php if(is_array($top_menu_url)): $i = 0; $__LIST__ = $top_menu_url;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class='dib <?php if(in_array((ACTION_NAME), is_array($vo['method'])?$vo['method']:explode(',',$vo['method']))): ?>selected<?php endif; ?>'><a href="<?php echo U($vo['method']);?>"><?php echo ($vo["title"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                </div>
 
                
                <div class="main_bd">
                    <div class="category_wrap clearfix">
                        <div class="category_left">
                            <h2 class="border_r">权限分类</h2>
                            <ul id="categoryTree" class="ztree"></ul>
                        </div>
                        <div class="category_right">
                            <h2>分组操作</h2>
                            <div id="categoryInfo" class="category_main">
                                <p class="category_tips">请选择左侧分类在进行相关操作</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var setting = {
            data: {
                simpleData: {
                    enable: true,
                    idKey : 'id',
                    pIdKey : 'pid'
                },
                key:{
                    name : 'title'
                }
            },
            callback:{
                onDblClick: ztreeOnDbClick,
                onClick: ztreeOnClick
            }
        };
        var zNodes =<?php echo ($list); ?>;

        var clickTime = null, currentCategory = null;
        function ztreeOnClick(event, treeId, treeNode){
            if (clickTime) {
                clearTimeout(clickTime);
                clickTime = null;
            } else {
                clickTime = setTimeout(function() {
                    currentCategory = treeNode;
                    var url = "<?php echo U('authinfo');?>";
                    var data = {
                        id: treeNode.id,
                        cid: treeNode.cid,
                        tid: treeNode.tid
                    }

                    Juuz.ajaxHtml(url, data, 'html', function(html){
                        $('#categoryInfo').html(html);
                        Manage.uiInit('#categoryInfo');
                    }, Juuz.noop);

                    clickTime = null;
                }, 250);
            }
        }

        function ztreeOnDbClick(event, treeId, treeNode){
            clickTime = null;
        }

        $(function(){
            $.fn.zTree.init($("#categoryTree"), setting, zNodes);
        })
    </script>

            </div>
        </div>
    </div>
</body>
</html>