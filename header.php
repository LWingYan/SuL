<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html class="no-js">

<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <!-- 网站图标 -->
    <link rel="shortcut icon" href="<?php $this->options->themeUrl('./img/favicon.ico'); ?>" type="image/x-icon" />
    <!-- 样式文件 -->
    <link rel="stylesheet" href="<?php staticFiles('css/style.css') ?>" />
    <link rel="stylesheet" href="<?php staticFiles('css/font-awesome.min.css') ?>" />
    

    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/nprogress/0.2.0/nprogress.min.css" rel="stylesheet">
    <?php if ($this->options->PrismTheme) : ?>
    <link href="<?php $this->options->PrismTheme() ?>" rel="stylesheet">
    <?php else : ?>
    <link href="<?php staticFiles('lib/prism/prism.min.css'); ?>" rel="stylesheet">
    <?php endif; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php $this->archiveTitle(array(
                'category'  =>  _t('分类 %s 下的文章'),
                'search'    =>  _t('包含关键字 %s 的文章'),
                'tag'       =>  _t('标签 %s 下的文章'),
                'author'    =>  _t('%s 发布的文章')
            ), '', ' - '); ?><?php $this->options->title(); ?></title>

    <!-- 使用url函数转换相关路径 -->

    <!-- 通过自有函数输出HTML头部信息 -->
    <?php $this->header('commentReply='); ?>
    <style>
        @font-face {
            font-display: swap;
            font-family: wodeziti;
            src: url('https://dsfs.oppo.com/store/public/font/OPPOSans-Medium.woff2') format("truetype");
        }
    </style>
    <script>
      localStorage.getItem("data-night") && document.querySelector("html").setAttribute("data-night", "night");
      window.SuL = {
        THEME_URL: `<?php Helper::options()->themeUrl() ?>`,
      }
    </script>
</head>

<body>
    
    <!-- 左侧导航 -->
    <div class="left-nav">

        <!-- 主人信息 -->
        <div class="blogger">
            <div><img src="<?php $this->options->logo() ?>"></div>
            <p class="ellipse"><?php $this->options->yourname() ?></p>
        </div>


        <!-- 搜索域 -->
        <div class="search">
            <form method="post" id="search" action="<?php $this->options->siteUrl(); ?>">
                <label for="s" class="sr-only"><?php _e('搜索关键字'); ?></label>
                <input type="text" id="s" name="s" class="text" placeholder="<?php _e('搜索'); ?>" autocomplete="off" />
                <button type="submit" class="submit"><i class="ri-seo-line"></i></button>
            </form>
        </div>

        <!-- 导航 -->
        <nav>
            <ul class="nav">
                <div class="ninja"></div>
                <li>
                    <a <?php if ($this->is('index')) : ?> class="active" <?php endif; ?> href="<?php $this->options->siteUrl(); ?>"><i class="ri-home-7-line"></i><span><?php _e('首页'); ?></span></a>
                </li>
                <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                <?php while ($pages->next()) : ?>
                    <li>
                        <a <?php if ($this->is('page', $pages->slug)) : ?> class="active" <?php endif; ?> href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><i class="<?php $pages->fields->fontawesome(); ?>"></i><span><?php $pages->title(); ?></span></a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </nav>
        
        <footer class="footer_nav">
            <li class="top" id="top" style="display: none;" ><a class="top"><i class="ri-rocket-line"></i><span>起飞</span></a></li>
            <?php if ($this->user->hasLogin()) : ?>
				<li class="login-admin"><a target="_blank" href="<?php $this->options->adminUrl(); ?>"><i class="ri-settings-2-line"></i><span>管理</span></a></li>
				<li class="exit-admin"><a href="<?php $this->options->logoutUrl(); ?>"><i class="ri-shut-down-line"></i><span>退出</span></a></li>
			<?php else : ?>
				<li><a target="_blank" href="<?php $this->options->adminUrl('login.php'); ?>"><i class="ri-map-pin-user-fill"></i><span>登入</span></a></li>
			<?php endif; ?>
        </footer>

    </div>
    <!-- 中间sidebar -->
    <?php $this->need('sidebar.php'); ?>
    <!-- 右侧app -->
    <div id="app">
        <div id="content" class="container">

	<div class="header">
		<!-- 操作栏 -->
			<ul class="admin clearfix">
				<!-- 小屏折叠 -->
                <li><a class="minilize"><i class="ri-menu-unfold-fill"></i></a></li>
				<li><a target="_blank" href="<?php $this->options->feedUrl(); ?>"><i class="ri-rss-fill"></i></a></li>
				<li><a class="btn-read-mode"><i class="<?php getReadMode(true);?>"></i></a></li>
			</ul>
	</div>