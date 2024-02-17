<?php
/**
 * 
 * 文章相关
 * 
 * @author 林厌Yan
 * @link http://www.liyizi.top/
 * @date  24 2 16
 */
/* 获取文章摘要 */
function _getAbstract($item, $num)
{
	$abstract = "";
	if ($item->password) {
		$abstract = "⚠️此文章已加密";
	} else {
		if ($item->fields->post_abstract) {
			$abstract = $item->fields->post_abstract;
		} else {
			$abstract = strip_tags($item->excerpt);
			$abstract = preg_replace('/\-o\-/', '', $abstract);
            $abstract = preg_replace('/{[^{]+}/', '', $abstract);
		}
	}
	if ($abstract === '') $abstract = "此文章暂无简介";
	return mb_substr($abstract, 0, $num);
}

function reply_unformat($text, $type = true)
{
    if (check_XSS($text)) {
        return "该回复疑似异常，已被系统拦截！";
    } else {
        if(Helper::options()->comment_IMGcode){
            $text = preg_replace('/{' . Helper::options()->comment_IMGcode . '}([\s\S]*?){\/' . Helper::options()->comment_IMGcode . '}/', '<span class="reply_media"><i class="ri-image-fill"></i> 图片</span>', $text);
        }else{
            $text = preg_replace('/{IMG}([\s\S]*?){\/IMG}/', '<span class="reply_media"><i class="ri-image-fill"></i> 图片</span>', $text);
        }
        $text = preg_replace('/{linkname name="([\s\S]*?)" link="([\s\S]*?)"}/', '<a style="color: var(--theme);margin: 0 0.25rem;" href="${2}" target="_blank">${1}</a>', $text);
        return $text;
    }
}
function reply($text)
{
    echo reply_unformat(strip_tags($text));
}
function check_XSS($text)
{
    $isXss = false;
    $list = array(
        '/onabort/is',
        '/onblur/is',
        '/onchange/is',
        '/onclick/is',
        '/ondblclick/is',
        '/onerror/is',
        '/onfocus/is',
        '/onkeydown/is',
        '/onkeypress/is',
        '/onkeyup/is',
        '/onload/is',
        '/onmousedown/is',
        '/onmousemove/is',
        '/onmouseout/is',
        '/onmouseover/is',
        '/onmouseup/is',
        '/onreset/is',
        '/onresize/is',
        '/onselect/is',
        '/onsubmit/is',
        '/onunload/is',
        '/eval/is',
        '/ascript:/is',
        '/style=/is',
        '/width=/is',
        '/width:/is',
        '/height=/is',
        '/height:/is',
        '/src=/is',  
    );
    if (strip_tags($text)) {
        for ($i = 0; $i < count($list); $i++) {
            if (preg_match($list[$i], $text) > 0) {
                $isXss = true;
                break;
            }
        }
    } else {
        $isXss = true;
    };
    return $isXss;
}
// 文章自定义设置
function themeFields($layout) {
    $uri = $_SERVER['REQUEST_URI'];
    if (strstr($uri, "write-page")) {
        ?>
    <?php
      $fontawesome = new Typecho_Widget_Helper_Form_Element_Text('fontawesome', NULL, NULL, _t('导航图标'), _t('例如：<i class="ri-camera-lens-fill"></i> 只需要填写ri-camera-lens-fill'));
      $layout->addItem($fontawesome);
      
      
    } elseif (strstr($uri, "write-post")) {
        
        $post_abstract = new Typecho_Widget_Helper_Form_Element_Text(
        'post_abstract',
        NULL,
        NULL,
        '自定义输出',
        '填写时：将会显示填写的文章输出 <br>
             不填写时：默认文章内容输出'
        );
        $layout->addItem($post_abstract);
        
        $thumb = new Typecho_Widget_Helper_Form_Element_Textarea(
        'thumb',
        NULL,
        NULL,
        '自定义缩略图（非必填）',
        '填写时：将会显示填写的文章缩略图 <br>
             不填写时：<br>
                1、若文章有图片则取文章内图片 <br>
                2、若文章无图片，但外观设置里填写了·自定义缩略图·选项，则取自定义缩略图图片'
        );
        $layout->addItem($thumb);
      
        $catalog = new Typecho_Widget_Helper_Form_Element_Select('catalog',array('false' => '关闭', 'true' => '启用'), 'false', _t('文章目录'), _t('默认关闭，启用则显示“文章目录”'));
        $layout->addItem($catalog);
    }
}
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('Editor', 'edit');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('Editor', 'edit');
class Editor
{
    public static function edit()
    {
        echo "<link rel='stylesheet' href='" . Helper::options()->themeUrl . '/assets/typecho/option.css' . "'>";
        echo "<script src='" . Helper::options()->themeUrl . '/assets/typecho/editor.js' . "'></script>";

    }
}
function article_changetext($post, $login){
    $content = $post->content;
    $cid = $post->cid;
    $content = strtr($content, array(
        "{x}" => '✅',
        "{ }" => '☑️'
    ));
    $content = preg_replace('/{{([\s\S]*?)}{([\s\S]*?)}}/', '<span class="e" title="${2}">${1}</span>' , $content);
    $content = preg_replace('/{bili p="([\s\S]*?)" key="([\s\S]*?)"}/', '<article_video><iframe src="https://www.bilibili.com/blackboard/html5mobileplayer.html?bvid=${2}&amp;page=${1}&amp;as_wide=1&amp;danmaku=0&amp;hasMuteButton=1" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true"></iframe></article_video>', $content);
    $content = preg_replace('/<img src([\s\S]*?)title="([\s\S]*?)">/', '<post_image><img src="' . get_Lazyload() . '" class="postimg isfancy lazyload" data-src${1}></post_image>', $content);
    $content = preg_replace('/<p><post_image([\s\S]*?)<\/post_image><\/p>/', '<post_image${1}</post_image>', $content);
    $content = preg_replace('/<img src="(.*?)" class="(.*?)" data-src="(.*?)" alt="(.*?)"(.*?)>/', '<span data-fancybox="gallery" data-caption="${4}" href="${3}"><img src="${1}" class="${2}" data-src="${3}" alt="${4}"></span>', $content);
    $content = preg_replace('/{time}([\s\S]*?){\/time}/', '<div class="time"><span>${1}</span></div>', $content);
    $content = preg_replace('/{left_img="(.*?)" left_text="(.*?)"}/', '<div class="flex flex-row left_comment-content relative"><img src="${1}"><b class="left_commentText">${2}</b></div>', $content);
    
    $content = preg_replace('/{right_img="(.*?)" right_text="(.*?)"}/', '<div class="flex justify-end right_comment-content relative"><b class="right_commentText">${2}</b><img class="flex justify-end" src="${1}"></div>', $content);
    
    $content = preg_replace('/{y_right_img="(.*?)" y_right="(.*?)" y_right_text="(.*?)"}/', '<div style="overflow: auto;"><div class="flex justify-end y_right_comment-content relative"><b style="width:${2}em;" class="justify-end flex y_right_commentText"><span>${2}</span><i class="ri-wifi-line"></i></b><img class="flex justify-end" src="${1}"></div><div class="y_right-commentText"><b>${3}</b></div></div>', $content);
    
    $content = preg_replace('/{y_left_img="(.*?)" y_left="(.*?)" y_left_text="(.*?)"}/', '<div style="overflow: auto;"><div class="flex flex-row y_left_comment-content relative"><img src="${1}"><b style="width:${2}em;" class="y_left_commentText flex"><i class="ri-wifi-line"></i><span>${2}</span></b></div><div class="y_left-commentText"><b>${3}</b></div></div>', $content);
    echo $content;
}
