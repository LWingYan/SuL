<?php

/**
 * 
 * 版权：陈睿-Moz
 * 
 * SuL
 * 
 * @package SuL
 * @author 林厌Yan
 * @version 1.1
 * @link http://www.liyizi.top/
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

	<!-- 核心 -->
	<div id="core" class="clearfix">
		<!-- 文章区 -->
		<div class="article-list">
			<!-- top4 -->
			<div class="top4 clearfix">
				<?php $obj = $this->widget('Widget_Contents_Post_Recent'); ?>
				<?php $count = 1; ?>
				<?php while ($obj->next()) : ?>
					<?php if ($count < 5) : ?>
						<?php if ($count == 1 || $count == 4) : ?>
							<article class="article post-thumb-big" href="<?php $obj->permalink() ?>" style="background-image:url(<?php echo _getThumbnails($this)[0] ?>)">
								<div class="mask"></div>
								<h2 class="ellipse">
								    <a href="<?php $obj->permalink() ?>" >
								        <?php subText($obj->title, 10) ?>
								    </a>
								</h2>
								<ul class="clearfix flex">
								    <li class="modify-img"><a href="<?php echo _getThumbnails($this)[0] ?>">
								            <i class="ri-folder-image-line"></i>
								        </a></li>
									<li class="modify-time"><?php diffTime($obj->created) ?></li>
								</ul>
								<div class="post-content ellipse">
									<?php echo _getAbstract($obj,30); ?>
								</div>
							</article>
						<?php else : ?>
							<article class="article post-thumb-small" style="background-image:url(<?php echo _getThumbnails($this)[0] ?>)">
								<div class="mask"></div>
								<h2 class="ellipse">
								    <a href="<?php $obj->permalink() ?>" >
								        <?php subText($obj->title, 10) ?>
								    </a>
								</h2>
								<ul class="clearfix flex">
								    <li class="modify-img">
								        <a href="<?php echo _getThumbnails($this)[0] ?>">
								            <i class="ri-folder-image-line"></i>
								        </a>
								        </li>
									<li class="modify-time"><?php diffTime($obj->created) ?></li>
								</ul>
								<div class="post-content ellipse">
									<?php echo _getAbstract($obj,30); ?>
								</div>
							</article>
						<?php endif; ?>
					<?php endif; ?>
					<?php $count++ ?>
				<?php endwhile; ?>

			</div>
			
			<!---->
            <?php if($this->options->notice && $this->is('index')) :?>
            <link rel="stylesheet" href="<?php staticFiles('css/lib/swiper-bundle.min.css') ?>" />
            <script src="<?php staticFiles('js/lib/swiper-bundle.min.js'); ?>"></script>
            <div class="Category_List friends_block" style="width: 100%;padding: 1rem;font-size: 1rem;line-height: 2rem; margin-bottom: var(--margin);">
                <div class="swiper" style="z-index: 0;">
    				<div class="swiper-wrapper">
    				    <?php
                            $db = $this->db;
                            $options = $this->options;
                            $page = $db->fetchRow($db->select()->from('table.contents')
                                ->where('table.contents.created < ?', $options->gmtTime)
                                ->where('table.contents.slug = ?', $options->notice));
                            if ($page) {
                                $type = $page['type'];
                                $routeExists = (NULL != Typecho_Router::get($type));
                                $page['pathinfo'] = $routeExists ? Typecho_Router::url($type, $page) : '#';
                                $page['permalink'] = Typecho_Common::url($page['pathinfo'], $options->index);
                                $comments = $db->fetchAll($db->select()->from('table.comments')
                                    ->where('table.comments.status = ?', 'approved')
                                    ->where('table.comments.created < ?', $options->gmtTime)
                                    ->where('table.comments.type = ?', 'comment')
                                    ->where('table.comments.cid = ?', $page['cid'])
                                    ->order('table.comments.created', Typecho_Db::SORT_DESC)
                                    ->limit(3));
                        ?>
                        <?php foreach ($comments AS $comment) : ?>
                            <div class="swiper-slide">
                                <?php echo '<b style="color:var(--ThemeB);">' . $page['title']. '：</b><span style="color:#999999;">（' . date("n月j日",$comment["created"]) . '）</span>'; ?>
    						    <a class="item" href="<?php echo $page["permalink"] . '#li-comment-' . $comment["coid"]; ?>" target="_blank" rel="noopener noreferrer nofollow">
    							    <?php reply($comment['text']); ?>
    							</a>
    						</div>
                        <?php endforeach; ?>
                        <?php
                            } else {
                                echo "<div>暂无内容</div>";
                            }
                        ?>
    				</div>
                        <!-- If we need scrollbar -->
                        <div class="swiper-scrollbar"></div>
    			</div>
            </div>
            <?php endif; ?>
            <style>
                .swiper-pagination-bullets.swiper-pagination-horizontal {
                    bottom: unset;
                    left: unset;
                    width: auto;
                    right: 10px;
                    top: 10px;
                }
                .swiper {
                  width: 100%;
                  height: 23px;
                }
            </style>
            <script>
                const swiper = new Swiper('.swiper', {
                  // Optional parameters
                  direction: 'vertical',
                  loop: true,
                  autoplay:true,
                
                  // If we need pagination
                  pagination: {
                    el: '.swiper-pagination',
                  },
                
                  // Navigation arrows
                  navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                  },
                
                  // And if we need scrollbar
                  scrollbar: {
                    el: '.swiper-scrollbar',
                  },
                });
            </script>
			
			<ul id="Category_List" class="Category_List">
			    <?php $this->widget('Widget_Metas_Category_List')->to($categories); ?>
                <?php while ($categories->next()): ?>
                 
                <!--循环当前分类下的文章-->
                <?php $this->widget('Widget_Archive@category-' . $categories->mid, 'pageSize=7&type=category', 'mid=' . $categories->mid)->to($posts); ?>
                <li class="Category_article-strip">
                    <div class="Category_List_title">
                        <i class="ri-arrow-drop-up-line"></i>
                        <span><?php $categories->name(); ?></span>
                        <b><i class="ri-book-3-line"></i> <?php $categories->count(); ?></b>
                    </div>
                    <ul class="post-list" style="display: none;">
                    <?php while ($posts->next()): ?>
                          <!--//文章列表-->
                        <li class="Category_article-strip flex justify-sp-b">
                            <a href="<?php $posts->permalink(); ?>"><?php $posts->title(40); ?></a>
                            <span class="comment-num"><i class="ri-message-3-line"></i> <?php $posts->commentsNum(); ?></span>
                        </li>
                    <?php endwhile; ?>
                    </ul>
                </li>
                <?php endwhile; ?>
            </ul>
            

            
		</div>


		<?php $this->need('footer.php'); ?>