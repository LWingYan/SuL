<?php

/**
 * 动态
 * 微语
 * @package custom
 *
 */
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit; ?>

<?php $this->need('header.php'); ?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
define('__TYPECHO_GRAVATAR_PREFIX__', 'https://cravatar.cn/avatar/');
?>
<div id="post">
    <div id="comments">
    <?php fixPjaxComment($this) ?>
    <?php $this->comments()->to($comments); ?>
    <?php if ($comments->have()) : ?>
        <h3><?php $this->commentsNum(_t('暂无动态'), _t('仅有一条动态'), _t('已有 %d 条动态')); ?></h3>

        <?php $comments->listComments(); ?>

        <?php $comments->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>

    <?php endif; ?>

    <?php if ($this->allow('comment')) : ?>
        <div id="<?php $this->respondId(); ?>" class="respond">

            <form method="post" action="<?php $this->commentUrl() ?>"> <?php if ($this->user->hasLogin()) : ?>
                    <p class="has-login"><?php _e('登录身份: '); ?>
                        <a href="<?php $this->options->profileUrl(); ?>">
                            <?php $this->user->screenName(); ?></a> |
                        <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;
                        </a>
                    </p>
                
                <p class="relpy-content">
                    <textarea placeholder="说点什么吗？" name="text" id="textarea" class="textarea" required><?php $this->remember('text'); ?></textarea>
                </p>
                <p>
                    <button type="submit" class="submit"><?php _e('提交评论'); ?></button>
                </p>
                <?php else : ?>
                <?php endif; ?>
            </form>
        </div>
    <?php else : ?>
        <h3><?php _e('评论已关闭'); ?></h3>
    <?php endif; ?>
</div>
    <br /><br /><br /><br />
</div><!-- end #main-->
<style>
    #comments .comment-list li .comment-reply, #comments .comment-list li .cancel-comment-reply {
    line-height: 20px;
    text-align: right;
    display: none;
}
</style>
<?php $this->need('footer.php'); ?>