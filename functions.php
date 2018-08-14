<?php
/*------------------------------------*\
    載入外部檔案
\*------------------------------------*/
include_once "include/cpt.php";         // 自定義文章
include_once "include/nav.php";         // 選單
include_once "include/widget.php";      // 側邊欄小工具
include_once "include/shortcode.php";   // shortcode
include_once "include/tool.php";        // 新增功能
include_once "include/admin.php";       // 後台相關設定

/*------------------------------------*\
    增加主題支援選單、特色圖片、翻譯檔
\*------------------------------------*/
if (function_exists('add_theme_support')) {
    add_theme_support('menus');
    add_theme_support('post-thumbnails');
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
    載入網站資源
\*------------------------------------*/
//載入 js                                                                                   
function html5blank_header_scripts() {      
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
        wp_register_script('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), null);
        wp_enqueue_script('modernizr');
        wp_register_script('plugin', get_template_directory_uri() . '/js/plugin.js', array(), null);
        wp_enqueue_script('plugin'); 
        wp_register_script('html5blankscripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), null);
        wp_enqueue_script('html5blankscripts');
    }
}
add_action('init', 'html5blank_header_scripts'); 

// 載入 css
function html5blank_styles() {
    wp_register_style('normalize', get_template_directory_uri() . '/css/normalize.css', array(), null, 'all');
    wp_enqueue_style('normalize'); 
    wp_register_style('html5blank', get_template_directory_uri() . '/css/style.css', array(), null, 'all');
    wp_enqueue_style('html5blank'); 
}
add_action('wp_enqueue_scripts', 'html5blank_styles');

/*------------------------------------*\
    修改原生功能
\*------------------------------------*/

function html5_style_remove($tag){return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);}                           // 移除 text/css
add_filter('style_loader_tag', 'html5_style_remove');



function my_wp_nav_menu_args($args = ''){$args['container'] = false;return $args;}                                          // 移除選單的div
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args');




function remove_category_rel_from_category_list($thelist){return str_replace('rel="category tag"', 'rel="tag"', $thelist);} // 移除分類invalid rel
add_filter('the_category', 'remove_category_rel_from_category_list');



function my_remove_recent_comments_style() {                                                                                // 移除最新留言style
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}
add_action('widgets_init', 'my_remove_recent_comments_style');



// 移除特色圖片長寬屬性
function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10);
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10);




// 自訂閱讀全文按鈕 HTML
function html5_blank_view_article($more) {
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
}
add_filter('excerpt_more', 'html5_blank_view_article');



/*------------------------------------*\
	Actions + Filters 
\*------------------------------------*/

add_filter('show_admin_bar', '__return_false');
add_filter('xmlrpc_enabled', '__return_false');
add_filter('widget_text', 'do_shortcode');
add_filter('widget_text', 'shortcode_unautop');
add_filter('the_excerpt', 'shortcode_unautop');
add_filter('the_excerpt', 'do_shortcode');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link'); 
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_head', 'print_emoji_detection_script', 7 );
remove_action('wp_print_styles', 'print_emoji_styles' );
remove_action('welcome_panel', 'wp_welcome_panel');
remove_filter('the_excerpt', 'wpautop');

?>
