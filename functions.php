<?php

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

define("THEME_NAME", "SuL");

define("THEME_VERSION", "1.4");

require_once 'libs/Editor.php';

require_once 'libs/ThemeConfig.php';


/**
 * 主题配置

function themeConfig($form)
{


    // 百度统计
    $baiduAnlysis = new Typecho_Widget_Helper_Form_Element_Text('baiduAnlysis', null, null, _t('百度统计'), _t('注册百度统计账号->新增网站->代码获取->找到 hm.src = "https://hm.baidu.com/hm.js?f045130eebcf5750255929de04bd5bff"; ->复制(问号后面的一串)'));
    $form->addInput($baiduAnlysis);

}

*/
/* 获取列表缩略图 
<?php echo _getThumbnails($this)[0] ?>
*/
function _getThumbnails($item)
{
  $result = [];
  $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
  $patternMD = '/\!\[.*?\]\((http(s)?:\/\/.*?(jpg|jpeg|gif|png|webp))/i';
  $patternMDfoot = '/\[.*?\]:\s*(http(s)?:\/\/.*?(jpg|jpeg|gif|png|webp))/i';
  /* 如果填写了自定义缩略图，则优先显示填写的缩略图 */
  if ($item->fields->thumb) {
    $fields_thumb_arr = explode("\r\n", $item->fields->thumb);
    foreach ($fields_thumb_arr as $list) $result[] = $list;
  }
  /* 如果匹配到正则，则继续补充匹配到的图片 */
  if (preg_match_all($pattern, $item->content, $thumbUrl)) {
    foreach ($thumbUrl[1] as $list) $result[] = $list;
  }
  if (preg_match_all($patternMD, $item->content, $thumbUrl)) {
    foreach ($thumbUrl[1] as $list) $result[] = $list;
  }
  if (preg_match_all($patternMDfoot, $item->content, $thumbUrl)) {
    foreach ($thumbUrl[1] as $list) $result[] = $list;
  }
  /* 如果上面的数量不足3个，则直接补充3个随即图进去 */
  if (sizeof($result) < 3) {
    $custom_thumbnail = Helper::options()->Thumbnail;
    /* 将for循环放里面，减少一次if判断 */
    if ($custom_thumbnail) {
      $custom_thumbnail_arr = explode("\r\n", $custom_thumbnail);
      for ($i = 0; $i < 3; $i++) {
        $result[] = $custom_thumbnail_arr[array_rand($custom_thumbnail_arr, 1)] . "?key=" . mt_rand(0, 1000000);
      }
    } else {
      for ($i = 0; $i < 3; $i++) {
        $result[] = staticFiles('thumb/' . rand(1, 42) . '.jpg', false);
      }
    }
  }
  return $result;
}


/**
 * 文章创建日期转 xx前
 */
function diffTime($time = NULL)
{
    $text = '';
    $time = $time === NULL || $time > time() ? time() : intval($time);
    $t = time() - $time; //时间差 （秒）
    $y = date('Y', $time) - date('Y', time()); //是否跨年

    switch ($t) {
        case $t == 0:
            $text = '刚刚';
            break;
        case $t < 60:
            // $text = $t . '秒前'; // 一分钟内
            $text = $t . 's'; // 一分钟内
            break;
        case $t < 60 * 60:
            // $text = floor($t / 60) . '分钟前'; //一小时内
            $text = floor($t / 60) . 'min'; //一小时内
            break;
        case $t < 60 * 60 * 24:
            // $text = floor($t / (60 * 60)) . '小时前'; // 一天内
            $text = floor($t / (60 * 60)) . 'h';
            break;
        case $t < 60 * 60 * 24 * 30:
            // $text = floor($t / 86400) . '天前';
            $text = floor($t / 86400) . 'd';
            break;
        case $t < 60 * 60 * 24 * 365 && $y == 0:
            // $text = date('m月d日', $time); //一年内
            $text = date('m月', $time); //一年内
            break;
        default:
            // $text = date('Y年m月d日', $time); //一年以前
            $text = date('Y年', $time); //一年以前
            break;
    }
    echo $text;
}

/**
 * 处理字符串超长问题
 */
function subText($text, $maxlen)
{
    if (mb_strlen($text) > $maxlen) {
        echo mb_substr($text, 0, $maxlen) . '...';
    } else {
        echo $text;
    }
}

/**
 * 字符串截取的百分比
 */
function perText($text, $maxlen)
{
    if (mb_strlen($text) > $maxlen) {
        echo ceil($maxlen / mb_strlen($text)) . '%';
    } else {
        echo '100%';
    }
}

/**
 * 名字首字作头像
 */
function nameToImg($text)
{
    echo mb_substr($text, 0, 1);
}

/**
 * 文章内容替换为内链
 */
function get_glo_keywords($content)
{

   
    $settings = Helper::options()->Keywordspress;    
    $keywords_list = array();
    

    if (strpos($settings,'|')) {
            //解析关键词数组
            $kwsets = array_filter(preg_split("/(\r|\n|\r\n)/",$settings));
            foreach ($kwsets as $kwset) {
                $keywords_list[] = explode('|',$kwset);
            }
        }
    ksort($keywords_list);  //对关键词排序，短词排在前面
    
    if($keywords_list){
        $readnum = 0;
        $i = 0;
        $j = 1;
        foreach ($keywords_list as $key => $val) {
            
            $title = $val[$i];
            $len = strlen($title);
            $str = '<a href="'.$val[$j].'" target="_blank">@'.$title.'</a>';
            $str_index = mb_strpos($content, $title);            
            $content = preg_replace('/(?!<[^>]*)'.$title.'(?![^<]*>)/',$str,$content,1); 
            
            if(is_numeric($str_index)){
                $readnum += 1;
                //$content = substr_replace($content,$str,$str_index,$len);
                //$content = $this->str_replace_limit($title,$str,$content,$this->limit);
            }
            if($readnum == 8) {
            return $content; //匹配到8个关键词就退出
            $i += 2;
            $j += 2;
            }
        }
    }
    return $content;

}

/**
 * 文章阅读数量
 * <?php get_post_view($this) ?>
 */
function get_post_view($archive)
{
    $cid    = $archive->cid;
    $db     = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        echo 0;
        return;
    }
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if ($archive->is('single')) {
        $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
    }
    echo $row['views'];
}

/**
 * 字数统计
 * <?php art_count($this->cid); ?>
 */
function  art_count($cid)
{
    $db = Typecho_Db::get();
    $rs = $db->fetchRow($db->select('table.contents.text')->from('table.contents')->where('table.contents.cid=?', $cid)->order('table.contents.cid', Typecho_Db::SORT_ASC)->limit(1));
    echo mb_strlen($rs['text'], 'UTF-8');
}


/**
 * 预计阅读时间
 */
function readTime($cid)
{
    $db = Typecho_Db::get();
    $rs = $db->fetchRow($db->select('table.contents.text')->from('table.contents')->where('table.contents.cid=?', $cid)->order('table.contents.cid', Typecho_Db::SORT_ASC)->limit(1));
    echo ceil(mb_strlen($rs['text'], 'UTF-8') / 300) . '分钟';
}

/**
 * ip获得地址
 */
function getLocation($ip)
{
    $res = '';
    if (preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/", $ip)) {
        $API = 'http://ip.taobao.com/service/getIpInfo.php?ip=';
        $re = json_decode(file_get_contents($API . $ip));
        $res = $re->data->country . ' ' . $re->data->region . ' ' . $re->data->city;
    } else {
        $res = '未知';
    }

    echo $res;
}


/**
 * 修复pjax评论
 */
function fixPjaxComment($archive)
{
    echo "<script type=\"text/javascript\">
    (function () {
        window.TypechoComment = {
            dom : function (id) {
                return document.getElementById(id);
            },
        
            create : function (tag, attr) {
                var el = document.createElement(tag);
            
                for (var key in attr) {
                    el.setAttribute(key, attr[key]);
                }
            
                return el;
            },
    
            reply : function (cid, coid) {
                var comment = this.dom(cid), parent = comment.parentNode,
                    response = this.dom('" . $archive->respondId . "'), input = this.dom('comment-parent'),
                    form = 'form' == response.tagName ? response : response.getElementsByTagName('form')[0],
                    textarea = response.getElementsByTagName('textarea')[0];
                    
                if (null == input) {
                    input = this.create('input', {
                        'type' : 'hidden',
                        'name' : 'parent',
                        'id'   : 'comment-parent'
                    });
    
                    form.appendChild(input);
                }
    
                input.setAttribute('value', coid);
    
                if (null == this.dom('comment-form-place-holder')) {
                    var holder = this.create('div', {
                        'id' : 'comment-form-place-holder'
                    });
    
                    response.parentNode.insertBefore(holder, response);
                }
    
                comment.appendChild(response);
                this.dom('cancel-comment-reply-link').style.display = '';
    
                if (null != textarea && 'text' == textarea.name) {
                    textarea.focus();
                }
    
                return false;
            },
    
            cancelReply : function () {
                var response = this.dom('{$archive->respondId}'),
                holder = this.dom('comment-form-place-holder'), input = this.dom('comment-parent');
    
                if (null != input) {
                    input.parentNode.removeChild(input);
                }
    
                if (null == holder) {
                    return true;
                }
    
                this.dom('cancel-comment-reply-link').style.display = 'none';
                holder.parentNode.insertBefore(response, holder);
                return false;
            }
        };
    })();
    </script>
    ";
}

// 静态文件源
function staticFiles($content, $type = 0, $isExternal = 0) {
  $setting = Helper::options()->staticFiles;
  if($isExternal){
    if($setting == 'local' || $setting == 'cdn'){
      $setting = Helper::options()->staticFiles;
    }else{
      $setting = 'jsdelivr';
    }
  }
  switch($setting){
    case 'jsdelivr':
      $output = 'https://gcore.jsdelivr.net/gh/Bhaoo/SuL@'.THEME_VERSION.'/assets/'.$content;
      break;
    case 'cdn':
      $output = Helper::options()->staticCdn.'/'.$content;
      break;
    case 'cdnjs':
      $output = 'https://cdnjs.cloudflare.com/ajax/libs/SuL/'.THEME_VERSION.'/'.$content;
      break;
    case 'staticfile':
      $output = 'https://cdn.staticfile.org/SuL/'.THEME_VERSION.'/'.$content;
      break;
    case 'bootcdn':
      $output = 'https://cdn.bootcdn.net/ajax/libs/SuL/'.THEME_VERSION.'/'.$content;
      break;
    case 'baomitu':
      $output = 'https://lib.baomitu.com/SuL/'.THEME_VERSION.'/'.$content;
      break;
    case 'local':
    default:
      $output = Helper::options()->themeUrl.'/assets/'.$content;
      break;
  }
  if($type == 0){
    print_r($output);
  }elseif($type == 1){
    return($output);
  }
}

function getReadMode($icon=false){
    $class = $_COOKIE['read-mode'];//获取cookie
    if($icon){
        $class = $class == 'night' ? 'ri-contrast-2-line' : 'ri-sun-line';
    }else{
        $class = 'night' == $class ? 'night-mode' : '';
    }
    echo $class;
}

/* 获取全局懒加载图 ok */
function get_Lazyload($type = true)
{
    return 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
}
