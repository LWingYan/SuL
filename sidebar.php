<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<div id="sidebar">
    <span class="change-card"><i class="ri-refresh-fill"></i></span>
    <!-- 一言 -->
    <div class="flag">
        <div>
        <?php if ($this->options->motto != '') : ?>
            <h3 class="motto"><?php $this->options->motto() ?></h3>
        <?php else : ?>
            <h3 class="motto">你的座右铭将会出现在这里</h3>
        <?php endif; ?>
        </div>
    </div>
    <div class="loop">
        <!-- 关于 -->
        <?php if ($this->options->ShowCategory === 'ShowCategory') : ?>
            <section class="widget cate-list">
                <p class="widget-title"><i class="ri-skull-2-fill"></i><span><?php _e('ABOUT BLOG'); ?></span></p>
                <ul class="header_slideout-count">
                            
                    <?php Typecho_Widget::widget('Widget_Stat')->to($stat); ?>
                    <div class="Widget_Stat">
                        <li>文章总数：<span><?php $stat->publishedPostsNum() ?></span>篇</li>
                        <li>分类总数：<span><?php $stat->categoriesNum() ?></span>个</li>
                        <li>评论总数：<span><?php $stat->publishedCommentsNum() ?></span>条</li>
                        <li>页面总数：<span><?php $stat->publishedPagesNum() ?></span>个</li>
                        <li>待审评论：<span><?php $stat->waitingCommentsNum() ?></span>条</li>
                    </div>
                    
                    <p class="widget-title"><i class="ri-hearts-line"></i><span><?php _e('ABOUT WE'); ?></span></p>
                    
                    <div id="lovesyl" style="">
                        <div id="lovesylImage" style="width: 220px; margin: 0 auto;">
                            <!-- 左边的头像 -->
                            <img src="<?php staticFiles('img/t.jpg'); ?>" alt="love"
                                style="width: 60px; border-radius: 50%;">
                            <!-- 中间的图片 -->
                            <img src="<?php staticFiles('img/lovesyl.gif'); ?>" alt="love" style="width: 60px; border-radius: 50%;">
                            <!-- 右边的头像 -->
                            <img src="<?php staticFiles('img/a.jpg'); ?>" alt="love"
                                style="width: 60px; border-radius: 50%;">
                        </div>
                        <p id="loveSitetime" style="font-size: 1.0rem;letter-spacing: 2.2pt;"></p>
                        <script language=javascript>
                                    function loveSitetime() {
                                        window.setTimeout("loveSitetime()", 1000);
                                        var seconds = 1000
                                        var minutes = seconds * 60
                                        var hours = minutes * 60
                                        var days = hours * 24
                                        var years = days * 365
                                        var today = new Date()
                                        var todayYear = today.getFullYear()
                                        var todayMonth = today.getMonth() + 1
                                        var todayDate = today.getDate()
                                        var todayHour = today.getHours()
                                        var todayMinute = today.getMinutes()
                                        var todaySecond = today.getSeconds()
                                        // 时间设置
                                        var t1 = Date.UTC(<?php $this->options->loveSitetime() ?>)
                                        var t2 = Date.UTC(todayYear, todayMonth, todayDate, todayHour, todayMinute, todaySecond)
                                        var diff = t2 - t1
                                        var diffYears = Math.floor(diff / years)
                                        var diffDays = Math.floor((diff / days) - diffYears * 365)
                                        var diffHours = Math.floor((diff - (diffYears * 365 + diffDays) * days) / hours)
                                        var diffMinutes = Math.floor((diff - (diffYears * 365 + diffDays) * days - diffHours * hours) / minutes)
                                        var diffSeconds = Math.floor((diff - (diffYears * 365 + diffDays) * days - diffHours * hours -
                                            diffMinutes * minutes) / seconds)
                                        document.getElementById("loveSitetime").innerHTML = "我们结婚" + diffYears + "年" + diffDays + "天" +
                                            diffHours + "时" + diffMinutes + "分" 
                                    }
                                    loveSitetime()
                                </script>
                    </div>
                </ul>
            </section>
        <?php endif; ?>

        <!-- 最新文章 -->
        <?php if ($this->options->ShowRecentPosts === 'ShowRecentPosts') : ?>
            <section class="widget">
                <p class="widget-title"><i class="ri-calendar-todo-fill"></i><span><?php _e('RECENT'); ?></span></p>
                <ul class="widget-list">
                    <?php $obj = $this->widget('Widget_Contents_Post_Recent', 'pageSize=10000') ?>
                    <?php if ($obj->have()) : ?>
                        <? while ($obj->next()) : ?>
                            <?php if ($obj->password == NULL) : ?>
                                <li class="recent">
                                    <a class="content" href="<?php $obj->permalink(); ?>">
                                        <p class="article-name"><?php subText($obj->title, 10) ?></p>
                                        <p class="read-time"><i class="ri-eye-2-fill"></i>阅读<?php readTime($obj->cid); ?> <?php art_count($obj->cid); ?>字</p>
                                        <p class="article-text ellipse"> <?php echo _getAbstract($obj,40); ?></p>
                                    </a>
                                    <span class="modified-time"><?php diffTime($obj->modified) ?></span>
                                </li>
                            <? else : ?>
                                <li class="recent locked">
                                    <a class="content" href="<?php $obj->permalink(); ?>">
                                        <?php if ($obj->hidden) : ?>
                                            <p class="article-name"><?php subText($obj->title, 10) ?></p>
                                        <? else : ?>
                                            <p class="article-name"><?php subText($obj->title, 10) ?></p>
                                        <?php endif; ?>
                                    </a>
                                    <span class="modified-time"><?php diffTime($obj->modified) ?></span>
                                </li>
                            <?php endif; ?>
                        <? endwhile; ?>
                    <? else : ?>
                    <?php endif; ?>
                </ul>
            </section>
        <?php endif; ?>

        <!-- 评论 -->
        <?php if ($this->options->sidebarBlock === 'sidebarBlock') : ?>
        <?php $this->widget('Widget_Comments_Recent','ignoreAuthor=true')->to($comments); ?>
            <section class="widget">
                <p class="widget-title"><i class="ri-message-3-line"></i><span><?php _e('COMMENTS'); ?></span></p>
                <ul class="widget-list">
                    <?php $obj = $this->widget('Widget_Comments_Recent', 'pageSize=10000')->to($comments);  ?>
                    <?php if ($obj->have()) : ?>
                        <? while ($obj->next()) : ?>
                            <li class="comment-info">
                                <a href="<?php $obj->permalink(); ?>" class="comment-view">
                                    <div>
                                        <span class="comment-author" data-ip="<?php echo $obj->ip ?>"><?php nameToImg($obj->author) ?></span>
                                        <span class="comment-time"><?php diffTime($obj->created) ?></span>
                                    </div>
                                    <p>回复:<?php subText($obj->text, 40) ?></p>
                                    <p><span>《<?php subText($obj->title, 20) ?>》</span></p>
                                </a>
                            </li>
                        <? endwhile; ?>
                    <? else : ?>
                    <?php endif; ?>
                </ul>
            </section>
        <?php endif; ?>

        <!-- 归档 -->
        <?php if ($this->options->sidebarBlock === 'sidebarBlock') : ?>
            <section class="widget">
                <p class="widget-title"><i class="ri-archive-fill"></i><span><?php _e('ARCHIVE'); ?></span></p>
                <ul class="widget-list archive-list clearfix">
                    <?php $obj = $this->widget('Widget_Contents_Post_Date', 'format=Y-m&type=month&limit=10')
                            ->parse('<li><a href="{permalink}"><p>{date}月</p><p><span>{count}篇</span></p></a></li>'); ?>
                </ul>
            </section>
        <?php endif; ?>

    </div>
</div><!-- end #sidebar -->