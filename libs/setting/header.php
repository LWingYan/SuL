<?php
/**
 *
 * Setting Header
 *
 * @author 林厌Yan
 * @link http://www.liyizi.top/
 * @date 2024-2-17
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
<link rel="stylesheet" href="<?php staticFiles('css/typecho/setting.min.css') ?>" />
<link rel="stylesheet" href="<?php staticFiles('css/font-awesome.min.css') ?>" />
<style>
    .background{
        --Theme_gradient:linear-gradient(90deg, #fff1eb 0%, #ace0f9 100%);
    background-image: var(--Theme_gradient);
    }
</style>

<body class="Setting mdui-theme-primary-<?php echo Helper::options()->primaryColor; ?> mdui-theme-accent-<?php echo Helper::options()->accentColor; ?> mdui-drawer-body-left">
<div class="background"></div>
<div class="SuL_btnav_left"><i class="ri-expand-right-fill"></i></div>
    <div class="sidebar">
	<div class="SuLsd" unselectable="on">
		<div class="SuLscrollbar">
			<!--Nav-头像栏-->
			<div class="SuLsd_hd">
				<div class="SuLsd_hd_bg">
					<img class="lazy" src="<?php setting("logoUrl", "img/typecho/bg.jpg"); ?>" style="display: inline-block;">
				</div>
				<a href="http://www.liyizi.top/">
					<div class="SuLsd_hd_tx">
						<img src="<?php setting("logoUrl", "img/t.jpg"); ?>">
					</div>
				</a>
				<div class="SuLsd_hd_wb">
					<h3>林厌Yan</h3>
					<p>世界和平</p>
				</div>
			</div>
			<!--导航-->
			<div class="SuLsd_nav">
				<div class="SuLsd_navm">
					<h3>站点导航</h3>
					<ul>
						<li>
							<a href="//www.liyizi.top/">
								<i class="ri-draft-line"></i>
								<span>主题文档</span>
							</a>
						</li>
						<li>
							<a href="<?php Helper::options()->adminUrl ?>themes.php">
								<i class="ri-t-shirt-2-line"></i>
								<span>主题列表</span>
							</a>
						</li>
						<li>
							<a href="<?php Helper::options()->adminUrl() ?>">
								<i class="ri-home-office-line"></i>
								<span>后台首页</span>
							</a>
						</li>
					</ul>
				</div>
				<div class="SuLsd_navm">
					<h3>内容组件</h3>
					<ul class="SuLrcmd_top">
						<li>
							<div id="index">
								<i class="ri-tools-fill"></i>
								<span>基础设置</span>
							</div>
						</li>
						<li>
							<div id="gengd">
								<i class="ri-dropbox-line"></i>
								<span>更多设置</span>
							</div>
						</li>
						<li>
							<div id="gaoji">
								<i class="ri-lock-star-fill"></i>
								<span>高级设置</span>
							</div>
						</li>
						<li>
							<div id="chaj">
								<i class="ri-puzzle-line"></i>
								<span>插件设置</span>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
