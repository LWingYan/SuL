<?php
/**
 * .______    __    __       ___        ______
 * |   _  \  |  |  |  |     /   \      /  __  \
 * |  |_)  | |  |__|  |    /  ^  \    |  |  |  |
 * |   _  <  |   __   |   /  /_\  \   |  |  |  |
 * |  |_)  | |  |  |  |  /  _____  \  |  `--'  |
 * |______/  |__|  |__| /__/     \__\  \______/
 *
 * Setting
 *
 * @author Bhao
 * @link https://dwd.moe/
 * @date 2023-11-27
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

require_once(__DIR__ ."/setting.php");

function setting($name, $content, $type = 0) {
  if($type == 0){
    $type = staticFiles($content, 1);
  }elseif($type == 1){
    $type = $content;
  }
  echo (Helper::options()->$name) ? Helper::options()->$name : $type;
}

function getTheme() {
  static $themeName = NULL;
  if ($themeName === NULL) {
    $db = Typecho_Db::get();
    $query = $db->select('value')->from('table.options')->where('name = ?', 'theme');
    $result = $db->fetchAll($query);
    $themeName = $result[0]["value"];
  }
  return $themeName;
}

function themeOptions($name) {
  static $themeOptions = NULL;
  if ($themeOptions === NULL) {
    $db = Typecho_Db::get();
    $query = $db->select('value')->from('table.options')->where('name = ?', 'theme:'.getTheme());
    $result = $db->fetchAll($query);
    $themeOptions = unserialize($result[0]["value"]);
  }

  return ($name === NULL) ? $themeOptions : (isset($themeOptions[$name]) ? $themeOptions[$name] : NULL);
}

function themeConfig($form) {
  require_once(__DIR__ ."/setting/header.php");
  $config = new SuL_Setting($form); ?>
  <div class="index">
      <div id="message">
        <div class="setting-title">基础信息</div>
        <div id="data" data-update="<?php echo base64_encode('theme='.THEME_NAME.'&site='.$_SERVER['HTTP_HOST'].'&version='.THEME_VERSION.'&token='.md5('SuL@'.THEME_VERSION)) ?>"></div>
        <img class="mdui-table-img" src="<?php setting("logoUrl", "img/typecho/Banner.png"); ?>">
        <div class="mdui-table-fluid">
          <table class="mdui-table">
            <tbody>
            <tr>
              <td>当前版本</td>
              <td><?php echo THEME_VERSION; ?></td>
            </tr>
            <tr>
              <td>云端版本</td>
              <td>懒得整</td>
            </tr>
            <tr>
              <td>公告</td>
              <td>主题版权陈睿-Moz</td>
            </tr>
            <tr>
              <td>功能</td>
              <td>
                <form class="protected" action="?SuLBackup" method="post" style="display: block!important">
                  <input class="mdui-btn mdui-btn-raised mdui-color-theme setting-button" type="submit" name="type" value="备份数据">
                  <input class="mdui-btn mdui-btn-raised mdui-color-theme setting-button" type="submit" name="type" value="还原数据">
                  <input class="mdui-btn mdui-btn-raised mdui-color-theme setting-button" type="submit" name="type" value="删除备份">
                </form>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
      <form id="SuL-form" class="mdui-typo" action="<?php echo $config->security->getIndex('/action/themes-edit?config') ?>" method="post" enctype="application/x-www-form-urlencoded" style="display: block!important">
        <div id="basic" style="display: block;">
          <div class="setting-title">基础设置</div>
          <div class="setting-content">
            <?php echo 
            // 头像图
            $config->input('logo', '头像图', '这里填写 URL 地址,最好能走cdn或者oss,毕竟带宽小').
            // 你的名字
            $config->input('yourname', '你的名字', '在左上角头向下面,太长会自动...省略', '林厌Yan').
            // 座右铭好
            $config->input('motto', '座右铭', '座右铭会默认显示在首页').
            // 缩略图
            $config->textarea('Thumbnail',
                            '自定义缩略图',
                            '介绍：博客全局缩略图<br/>
                            格式：图片地址，一行一个 <br />
                            注意：默认使用API，若宽带大的话可以把喜欢的图片保存在assets/thumb里格式为.jpg最多可保存42张<br>
                            例如：1.jpg 2.jpg 3.jpg ...',
                            'https://picsum.photos/600/300').
            // 首页公告
            $config->input('notice', '滚动文本框（公告）', '首页显示的滚动文本框，可以用作小站公告，需结合页面模板使用，请输入用作公告页面的slug名（缩略名）。<br>
                说明：slug（标题下面那个）根据自身喜好填写。例如：<code> announcement </code>那么这里就填写<code> announcement <br>首页最多显示最新三条动态，多了不显示。</code>').
                
            // 底部版权
            $config->input('icpNum', 'ICP备案号', '管局爸爸很严厉,备案过程中最好关闭站点,如：苏ICP备1000000号').
            
            // 侧边栏
            $config->text('Show', '下面是侧栏设置，最少需要一个，否修改代码去掉侧栏').
            
            $config->input('loveSitetime', '恋爱日期', '这里被我改成了结婚，需要可以去文件sidebar.php第70行修改<br>格式：2018, 09, 5, 8, 30, 00','2018, 09, 5, 8, 30, 00').
              
            // 侧边栏最新文章
            $config->select('ShowRecentPosts',
              ['ShowRecentPosts'        => '显示',
                'on'        => '不显示'
              ],'显示最新文章', '默认显示', 'ShowRecentPosts').
            // 侧边栏最近回复
            $config->select('ShowRecentComments',
              ['ShowRecentComments'        => '显示',
                'on'        => '不显示'
              ],'显示最近回复', '默认显示', 'ShowRecentComments').
            // 侧边栏关于我们
            $config->select('ShowCategory',
              ['ShowCategory'        => '显示',
                'on'        => '不显示'
              ],'显示关于', '默认显示', 'ShowCategory').
            // 侧边栏显示归档
            $config->select('ShowArchive',
              ['ShowArchive'        => '显示',
                'on'        => '不显示'
              ],'显示归档', '默认显示', 'ShowArchive')?>
          </div>
        </div>
        <div id="menu" style="display:none;">
          <div class="setting-title">更多设置</div>
          <div class="setting-content">
            <?php echo 
            
            // 关键词
            $config->input('Keywordspress', '关键字内链', '每行1组以 " 关键词|(半角竖线)链接 " 形式填写)<br>文章内容替换为内链，有助于SEO优化').
            
            // 百度统计
            $config->input('baiduAnlysis', '百度统计', '注册百度统计账号->新增网站->代码获取->找到 hm.src = "https://hm.baidu.com/hm.js?f045130eebcf5750255929de04bd5bff"; ->复制(问号后面的一串)').
            
            // 代码风格
            $config->select('PrismTheme',
              ['//npm.elemecdn.com/prismjs@1.29.0/themes/prism.min.css' =>   'prism（默认）',
                '//npm.elemecdn.com/prismjs@1.29.0/themes/prism-dark.min.css'         =>   'prism-dark',
                '//npm.elemecdn.com/prismjs@1.29.0/themes/prism-okaidia.min.css' => 'prism-okaidia',
                '//npm.elemecdn.com/prismjs@1.29.0/themes/prism-solarizedlight.min.css' => 'prism-solarizedlight',
                '//npm.elemecdn.com/prismjs@1.29.0/themes/prism-tomorrow.min.css' => 'prism-tomorrow',
                '//npm.elemecdn.com/prismjs@1.29.0/themes/prism-twilight.min.css' => 'prism-twilight',
                '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-a11y-dark.min.css' => 'prism-a11y-dark',
                '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-atom-dark.min.css' => 'prism-atom-dark',
                '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-base16-ateliersulphurpool.light.min.css' => 'prism-base16-ateliersulphurpool.light',
                '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-cb.min.css' => 'prism-cb',
                '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-coldark-cold.min.css' => 'prism-coldark-cold',
                '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-coldark-dark.min.css' => 'prism-coldark-dark',
                '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-darcula.min.css' => 'prism-darcula',
                '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-dracula.min.css' => 'prism-dracula',
                '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-duotone-dark.min.css' => 'prism-duotone-dark',
                '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-duotone-earth.min.css' => 'prism-duotone-earth',
                '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-duotone-forest.min.css' => 'prism-duotone-forest',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-duotone-light.min.css' => 'prism-duotone-light',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-duotone-sea.min.css' => 'prism-duotone-sea',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-duotone-space.min.css' => 'prism-duotone-space',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-ghcolors.min.css' => 'prism-ghcolors',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-gruvbox-dark.min.css' => 'prism-gruvbox-dark',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-hopscotch.min.css' => 'prism-hopscotch',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-lucario.min.css' => 'prism-lucario',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-material-dark.min.css' => 'prism-material-dark',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-material-light.min.css' => 'prism-material-light',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-material-oceanic.min.css' => 'prism-material-oceanic',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-night-owl.min.css' => 'prism-night-owl',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-nord.min.css' => 'prism-nord',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-pojoaque.min.css' => 'prism-pojoaque',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-shades-of-purple.min.css' => 'prism-shades-of-purple',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-synthwave84.min.css' => 'prism-synthwave84',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-vs.min.css' => 'prism-vs',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-vsc-dark-plus.min.css' => 'prism-vsc-dark-plus',
            '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-xonokai.min.css' => 'prism-xonokai',
            '//npm.elemecdn.com/prism-theme-one-light-dark@1.0.4/prism-onelight.min.css' => 'prism-onelight',
            '//npm.elemecdn.com/prism-theme-one-light-dark@1.0.4/prism-onedark.min.css' => 'prism-onedark',
            '//npm.elemecdn.com/prism-theme-one-dark@1.0.0/prism-onedark.min.css' => 'prism-onedark2'
              ], '代码高亮', '选择一款您喜欢的代码高亮样式', '//npm.elemecdn.com/prismjs@1.29.0/themes/prism.min.css').
              
            // 静态资源
            $config->select('staticFiles',
                ['local'       => '本地',
                  'jsdelivr'   => 'JsDelivr',
                  'cdnjs'      => 'cdnjs',
                  'staticfile' => 'Staticfile',
                  'bootcdn'    => 'Bootcdn',
                  'baomitu'    => 'Baomitu',
                  'cdn'        => '自定义 CDN'
                ], '静态文件源', '推荐选择 “JsDelivr源”', 'local').
                
            $config->input('staticCdn', '自定义静态文件CDN', '在这里填写你自己的CDN(如 api.xxx.xxx)，以获取静态文件(需在上方选择自定义CDN)')
            
            ?>
          </div>
        </div>
        <div id=" " style="display:none;">
            <div class="setting-title">高级设置</div>
            <div class="setting-content">没有发现高级功能</div>
        </div>
        <div id="plugins" style="display:none;">
          <div class="setting-title">插件扩展</div>
          <div class="setting-content">
          <?php $config->plugin('Links', '友链插件',
          $config->text('linksIndexNum', '请尽情使用SuL吧'))
          ?>
          </div>
        </div>
        <p class="mdui-button-theme">
            <button class="mdui-fab mdui-fab-fixed mdui-ripple mdui-color-theme"><span>储存样式</span></button>
        </p>
      </form>
  </div>
<?php require_once(__DIR__ ."/setting/footer.php"); themeBackup();}

function themeBackup(){
  $db = Typecho_Db::get();
  $sjdq=$db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:'.getTheme()));
  $ysj = $sjdq['value'];
  if(isset($_POST['type'])){
    if($_POST["type"]=="备份数据"){
      if($db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:SuLBackup'))){
        $update = $db->update('table.options')->rows(array('value'=>$ysj))->where('name = ?', 'theme:SuLBackup');
        $updateRows= $db->query($update);
        echo '<script language="JavaScript">
                window.setTimeout("location=\''.Helper::options()->adminUrl.'options-theme.php\'", 2500);
                mdui.snackbar({
                message: "备份已更新，请等待自动刷新！如果等不到请点击",
                buttonText: "这里",
                onButtonClick: function(){
                  window.location.href = "'.Helper::options()->adminUrl.'options-theme.php";
                }});
              </script>';
      }else{
        if($ysj){
          $insert = $db->insert('table.options')->rows(array('name' => 'theme:SuLBackup','user' => '0','value' => $ysj));
          $insertId = $db->query($insert);
          echo '<script language="JavaScript">
                window.setTimeout("location=\''.Helper::options()->adminUrl.'options-theme.php\'", 2500);
                mdui.snackbar({
                message: "备份已更新，请等待自动刷新！如果等不到请点击",
                buttonText: "这里",
                onButtonClick: function(){
                  window.location.href = "'.Helper::options()->adminUrl.'options-theme.php";
                }});
              </script>';
        }
      }
    }
    if($_POST["type"]=="还原数据"){
      if($db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:SuLBackup'))){
        $sjdub=$db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:SuLBackup'));
        $bsj = $sjdub['value'];
        $update = $db->update('table.options')->rows(array('value'=>$bsj))->where('name = ?', 'theme:'.getTheme());
        $updateRows= $db->query($update);
        echo '<script language="JavaScript">
                window.setTimeout("location=\''.Helper::options()->adminUrl.'options-theme.php\'", 2500);
                mdui.snackbar({
                message: "检测到模板备份数据，恢复完成，请等待自动刷新！如果等不到请点击",
                buttonText: "这里",
                onButtonClick: function(){
                  window.location.href = "'.Helper::options()->adminUrl.'options-theme.php";
                }});
              </script>';
      }else{
        echo '<script language="JavaScript">mdui.snackbar({message: "恢复失败，因为你没备份过设置哇（；´д｀）ゞ"})</script>';
      }
    }
    if($_POST["type"] == "删除备份"){
      if($db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:SuLBackup'))){
        $delete = $db->delete('table.options')->where ('name = ?', 'theme:SuLBackup');
        $deletedRows = $db->query($delete);
        echo '<script language="JavaScript">
                window.setTimeout("location=\''.Helper::options()->adminUrl.'options-theme.php\'", 2500);
                mdui.snackbar({
                message: "删除成功，请等待自动刷新，如果等不到请点击",
                buttonText: "这里",
                onButtonClick: function(){
                  window.location.href = "'.Helper::options()->adminUrl.'options-theme.php";
                }});
              </script>';
      }else{
        echo '<script language="JavaScript">mdui.snackbar({message: "删除失败，检测不到备份ㄟ( ▔, ▔ )ㄏ"})</script>';
      }
    }
  }
}
?>
