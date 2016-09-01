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
// 載入 css
function html5blank_styles() {
    wp_register_style('normalize', get_template_directory_uri() . '/css/normalize.css', array(), null, 'all');
    wp_enqueue_style('normalize'); 
    wp_register_style('html5blank', get_template_directory_uri() . '/css/style.css', array(), null, 'all');
    wp_enqueue_style('html5blank'); 
}

/*------------------------------------*\
    修改原生功能
\*------------------------------------*/
function html5_style_remove($tag){return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);}                           // 移除 text/css
function my_wp_nav_menu_args($args = ''){$args['container'] = false;return $args;}                                          // 移除選單的div
function my_css_attributes_filter($var){return is_array($var) ? array() : '';}                                              // 移除選單多餘的ID
function remove_category_rel_from_category_list($thelist){return str_replace('rel="category tag"', 'rel="tag"', $thelist);} // 移除分類invalid rel
function my_remove_recent_comments_style() {                                                                                // 移除最新留言style
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}
// 移除特色圖片長寬屬性
function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}
// 自訂閱讀全文按鈕 HTML
function html5_blank_view_article($more) {
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
}
// 自訂留言 HTML
function html5blankcomments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);
    if ( 'div' == $args['style'] ) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
?>
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>
    <div class="comment-author vcard">
    <?php echo get_avatar( $comment, 90 ); ?>
    <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
    </div>
<?php if ($comment->comment_approved == '0') : ?>
    <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
<?php endif; ?>
    <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
    <?php
        printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
    ?>
    </div>
    <?php comment_text() ?>
    <div class="reply">
    <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </div>
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters 
\*------------------------------------*/
add_action('init', 'html5blank_header_scripts'); 
add_action('wp_enqueue_scripts', 'html5blank_styles');
add_action('widgets_init', 'my_remove_recent_comments_style');
add_action('init', 'html5wp_pagination');
add_action('login_head', 'new_login_logo' );
add_action('wp_dashboard_setup', 'wpc_dashboard_widgets');
add_action('init', 'mycpt');
add_action('admin_footer', 'custom_admin_res');
add_filter('body_class', 'add_slug_to_body_class');
add_filter('widget_text', 'do_shortcode');
add_filter('widget_text', 'shortcode_unautop');
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args');
add_filter('the_category', 'remove_category_rel_from_category_list');
add_filter('the_excerpt', 'shortcode_unautop');
add_filter('the_excerpt', 'do_shortcode');
add_filter('excerpt_more', 'html5_blank_view_article');
add_filter('style_loader_tag', 'html5_style_remove');
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10);
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10);
add_filter( 'login_headerurl', 'custom_loginlogo_url' );
add_filter('login_headertitle', 'put_my_title');
add_action( 'admin_bar_menu', 'remove_wp_logo', 999 );
add_filter('admin_footer_text', 'custom_dashboard_footer');
add_filter('admin_footer_text', 'change_footer_admin', 9999);
add_filter( 'update_footer', 'change_footer_version', 9999);
add_filter('show_admin_bar', '__return_false');
add_filter('xmlrpc_enabled', '__return_false');
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
