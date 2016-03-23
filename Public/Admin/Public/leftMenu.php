<div class="menu_box">
    <dl class="menu first">
        <dt class="menu_title">
            <i class="icon_menu"><img src="./Images/icon_menu_function.png"/></i>平台信息
        </dt>
        <?php
            $arr = array(
                array("url" => "main", "name" => "平台信息")
            );
            foreach($arr as $key => $val){
        ?>
            <dd class="menu_item <?php if(defined("SELECT_MENU") && SELECT_MENU == $val['url']){echo 'active'; } ?>">
                <a href="<?php echo $val['url'] ?>.php"><?php echo $val['name']; ?></a>
            </dd>
        <?php
            }
        ?>
    </dl>
    <dl class="menu">
        <dt class="menu_title">
            <i class="icon_menu"><img src="./Images/icon_menu_management.png"/></i>内容管理
        </dt>
        <?php
            $arr = array(
                array("url" => "layout", "name" => "页面布局"),
                array("url" => "category", "name" => "分类管理"),
                array("url" => "goods_attr", "name" => "商品属性管理"),
                array("url" => "auth", "name" => "权限管理"),
                array("url" => "list", "name" => "列表管理"),
                array("url" => "tongdaoEdit", "name" => "内容编辑管理"),
                array("url" => "imageUpload", "name" => "图片上传管理"),
                array("url" => "map", "name" => "地图管理"),
                array("url" => "chart_bar", "name" => "图表插件"),
                array("url" => "zujian", "name" => "组件管理"),
            );
            foreach($arr as $key => $val){
        ?>
            <dd class="menu_item <?php if(defined("SELECT_MENU") && SELECT_MENU == $val['url']){echo 'active'; } ?>">
                <a href="<?php echo $val['url'] ?>.php"><?php echo $val['name']; ?></a>
            </dd>
        <?php
            }
        ?>
    </dl>
</div>
<div class="menu_bottom">
    <ul class="links dib-wrap">
        <li class="links_item first dib">
            <a href="javascript:void(0);" target="popDialog" data-opt="{
                title: '在线留言',
                url: 'Data/Html/liuyanhtml.html',
                dataType: 'html'
            }">在线留言</a>
        </li>
        <li class="links_item dib">
            <a href="tencent://message/?uin=17771258&Site=qq&Menu=yes" target="_blank">QQ交谈</a>
        </li>
        <li class="links_item dib">
            <a href="javascript:void(0);" target="popDialog" data-opt="{
                title: '版权信息',
                width: 500,
                height: 230,
                url: 'Data/Html/version.html',
                dataType: 'html'
            }">版权信息</a>
        </li>
    </ul>
    <p class="version">版本号 V2.0.1</p>
</div>