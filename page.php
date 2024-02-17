<!-- 自定义页面 -->
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

    <div id="post">
    <article class="post-card">
        <h1 class="post-title" itemprop="name headline"><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h1>
        <div id="post-toc" class="post-content markdown-body"><?php article_changetext($this, $this->user->hasLogin()) ?></div>
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
    <br /><br /><br /><br />
    <?php $this->need('comments.php'); ?>

</div><!-- end #app-->

<?php $this->need('footer.php'); ?>