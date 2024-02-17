<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<footer id="footer">
    &copy; <?php echo date('Y'); ?> <?php $this->options->icpNum(); ?> |
    <?php _e('<a href="http://typecho.org">Powered by Typecho</a> | <a class="author" href="http://www.liyizi.top/">Theme SuL</a>'); ?>
</footer><!-- end #footer -->

<?php $this->footer(); ?>

</div><!-- end #core -->
</div><!-- end #content -->
</div><!-- end #app -->

</body>
<!-- 百度统计 -->
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?<?php $this->options->baiduAnlysis() ?>";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
    
</script>

<!-- lib -->
<script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
<script src="<?php staticFiles('js/lib/md-toc.min.js') ?>"></script>
<script src="<?php staticFiles('lib/prism/prism.min.js'); ?>" class="S_pjax"></script>
<!-- main -->
<script src="<?php staticFiles('js/core.min.js') ?>"></script>
<script src="<?php staticFiles('js/theme.min.js') ?>"></script>
<script src="<?php staticFiles('js/qrcode.min.js') ?>"></script>
<!-- /main -->
<script src="<?php staticFiles('js/lib/view-image.min.js') ?>"></script>
<script src="<?php staticFiles('js/lib/jquery.pjax.min.js') ?>"></script>
<script src="<?php staticFiles('js/pjax.js') ?>"></script>
<script src="<?php staticFiles('js/Main.js') ?>" class="S_pjax"></script>
<script>

</script>
<script src="https://cdn.bootcss.com/nprogress/0.2.0/nprogress.min.js"></script>
<!-- /lib -->
</html>
