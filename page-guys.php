<?php

/**
 * guys
 * 友人
 * @package custom
 *
 */
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit; ?>

<?php $this->need('header.php'); ?>

<div id="post">
    <article class="post-card">
        <div class="links-list">
            <?php
                if(array_key_exists("Links", Typecho_Plugin::export()['activated'])){
                $shuffle = Helper::options()->linksshuffle;
                $link_limit = Helper::options()->linksIndexNum;
                if($type == 0) {
                  $Links = Links_Plugin::output("
                  <div class='links-card'>
                      <i class='mdui-img-circle'>
                        <img src='{image}'>
                      </i>
                      <div class='links-text'>
                        <a href='{url}' target='_blank' class='links-url'>{name}
                            <br>
                            <span>{description}</span>
                        </a>
                      </div>
                  </div>");
                }elseif($type == 1) {
                  $Links = Links_Plugin::output("
                  <div class='mdui-col'>
                    <a target='_blank' href='{url}'>
                     <li class='mdui-list-item mdui-ripple sidebar-module-list'>
                        <div class='sidebar-reply-text'>{name}</div>
                      </li>
                    </a>
                  </div>");
                }
                if($shuffle && in_array('open', $shuffle)){
                  shuffle($Links);
                }
                $link_limit = (!$type || $link_limit > count($Links)) ? count($Links) : $link_limit;
                for($i = 0; $i < $link_limit; $i++){
                  echo $Links[$i];
                }
              }
            ?>
        </div>
        <div class="links-intro">
            <h2>说明</h2>
            <p>请留言申请友情链接，格式如下：</p>
            <ul>
                <li>图：<span>40×40以上，走你的服务器，我带宽小，233</span></li>
                <li>名字：<span>例如：xxx</span></li>
                <li>网址：<span>例如：https://xxx</span></li>
                <li>骚话：<span>例如：无与伦比的追求冰冷的敲打着我的灵魂</span></li>
            </ul>
            <div class=""style="position: absolute;
                                top: 0;
                                right: 0;
                                font-size: 100px;
                                opacity: .1;">
                <i class="ri-alert-line"></i>
            </div>
        </div>
    </article>
    <br /><br /><br /><br />
    <?php $this->need('comments.php'); ?>
</div><!-- end #main-->

<?php $this->need('footer.php'); ?>