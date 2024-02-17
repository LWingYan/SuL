<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<!-- 文章页 -->
<div id="post">
    <article class="post-card">
        <p class="post-time">
            <i class="ri-hourglass-fill"></i>
            <time datetime="<?php $this->date('c'); ?>"><?php $this->date('m月d日y年'); ?></time>
            <span><i class="ri-eye-2-fill"></i><?php get_post_view($this) ?></span>
            <span><i class="ri-git-branch-line"></i><?php $this->category(','); ?></span>
        </p>
        <h1 class="post-title" itemprop="name headline"><?php $this->title() ?></h1>
        <div id="post-toc" class="post-content markdown-body"><?php article_changetext($this, $this->user->hasLogin()) ?></div>
        <p class="tags"><span>#</span> <?php $this->tags(' <span>#</span> ', true, 'none'); ?></p>
        <ul class="post-meta clearfix">
            <li><span>更新于: <?php echo date('Y年m月d日 H:i', $this->modified) ?></span></li>
        </ul>
        <div id="qrcode" style="text-align: -webkit-center;"></div>
        <style>
            #qrcode img{
                width: 80px;
                margin-top: 10px;
            }
        </style>
        <div style="line-height: 2.5;opacity: .2;text-align:center">扫描二维码，在手机上阅读！</div>
        <?php if (!empty($this->options->labs) && in_array('showCopyright', $this->options->labs)) : ?>
            <!-- 版权声明 -->
            <section class="post-copyright">
                <p class="author"><i class="ri-quill-pen-line"></i> 作者: <?php $this->author(); ?></p>
                <p class="link"><i class="ri-links-line"></i> 链接: <a href="<?php $this->permalink(); ?>"><?php $this->permalink(); ?></a></p>
                <p class="protocal"><i class="ri-copyright-line"></i> 版权: 除特别声明,均采用<a href="https://creativecommons.org/licenses/by-nc-sa/4.0/">BY-NC-SA 4.0</a>许可协议,转载请表明出处</p>
            </section>
        <?php endif; ?>
    </article>
    <ul class="post-near clearfix">
        <li><i class="ri-skip-left-line"></i><?php $this->thePrev('%s', '没有了'); ?></li>
        <li><?php $this->theNext('%s', '没有了'); ?><i class="ri-skip-right-line"></i></li>
    </ul>
    
    <?php if ($this->fields->catalog === 'true') : ?>
    <div id="contentTree" class="contentTree-a">
        <span class="asideOpe"><i class="ri-expand-left-fill"></i></span>
        <p>目录<span>Content</span></p>
        <div id="toc"></div>
    </div>
    <!-- 蒙版 -->
    <div class="aside-mask"></div>
    <?php endif; ?>
    
    <?php $this->need('comments.php'); ?>

</div><!-- end #app-->

<?php $this->need('footer.php'); ?>


<script type="text/javascript">
// toc
    new Toc('post-toc', {
        'level': 6,
        'top': 200,
        'class': 'toc',
        'targetId': 'toc'
    }, function() {
        $(".asideOpe").click(function() {
            if (!$("#contentTree").hasClass("contentTree-a")) {
                $(".aside-mask").removeClass("aside-mask-show");
                $("#contentTree").addClass("contentTree-a");
                $('i', this).attr('class', 'ri-expand-left-fill')
            } else {
                $(".aside-mask").addClass("aside-mask-show");
                $("#contentTree").removeClass("contentTree-a");
                $('i', this).attr('class', 'ri-expand-right-fill')
            }
        })
        $(".aside-mask").click(function() {
            if ($(this).hasClass("aside-mask-show")) {
                $(this).removeClass("aside-mask-show")
                $("#contentTree").addClass("contentTree-a");
                $('.asideOpe i').attr('class', 'ri-expand-left-fill')
            }
        })
        // 文章图片
        $("#post img").each(function() {
            if ($(this).attr("title") !== "" && $(this).attr("title") !== "请输入图片描述")
                $(this).after("<p style='text-align:center;margin:5px 0 0 0;'>" + $(this).attr("title") + "</p>")
        })
    });
</script>