<?php 
/*------------------------------------*\
    後臺相關功能
\*------------------------------------*/

function new_login_logo() {                                                             /* 自訂登入畫面LOGO */ 
     echo '<style type="text/css">.login h1 a { background-image:url('.get_template_directory_uri().'/img/company-logo.png) !important; background-size: 270px 164px!important; width:270px!important; height:164px !important; }</style>';
}
add_action('login_head', 'new_login_logo' );


function custom_loginlogo_url($url) { return get_bloginfo('url'); }                     /* 變更自訂登入畫面上LOGO的連結 */ 
add_filter( 'login_headerurl', 'custom_loginlogo_url' );


function put_my_title(){ return ('FemtoPath'); }                                        /* 變更自訂登入畫面上LOGO的Hover所出現的標題 */
add_filter('login_headertitle', 'put_my_title');


function remove_wp_logo( $wp_admin_bar ) { $wp_admin_bar->remove_node( 'wp-logo' ); }   /* 移除控制台左上角WP-LOGO */ 
add_action( 'admin_bar_menu', 'remove_wp_logo', 999 );


function custom_dashboard_footer () {                                                   /* 修改後台底下的wordpress文字宣告 */ 
    echo '官網維護單位 : <a href="http://nongdesign.com/">弄弄設計</a>。後台如有任何問題, 請聯絡<a href="http://nongdesign.com/">弄弄設計</a>'; 
} 
add_filter('admin_footer_text', 'custom_dashboard_footer');


function change_footer_admin () {return '&nbsp;';}                                      /* 隱藏後台右下角wp版本號 */ 
add_filter('admin_footer_text', 'change_footer_admin', 9999);


function change_footer_version() {return ' ';}
add_filter( 'update_footer', 'change_footer_version', 9999);

/* 強制關閉後台登入首頁的小工具 */ 
function wpc_dashboard_widgets() {
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);        // 活動
    //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);        // 現況
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);  // 近期迴響
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);   // 收到新鏈結
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);          // 外掛
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);        // 快貼
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);      // 近期草稿
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);            // WordPress Blog
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);          // Other WordPress News
}
add_action('wp_dashboard_setup', 'wpc_dashboard_widgets');


/* 在後臺加入自訂 JS、CSS */ 
function custom_admin_res() {
    $url = get_bloginfo('template_directory') . '/js/custom-wp-admin.js';
    echo '<script src="'. $url . '"></script>';
}
//add_action('admin_footer', 'custom_admin_res');


/* 允許後臺上傳 svg */
function cc_mime_types( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );



// 後台右上角會員按鈕-改成"登出"字樣
function custom_logout_link() {
    global $wp_admin_bar;
    $wp_admin_bar->add_menu( array(
        'id'    => 'wp-custom-logout',
        'title' => '登出',
        'parent'=> 'top-secondary',
        'href'  => wp_logout_url()
    ) );
    $wp_admin_bar->remove_menu('my-account');
}
add_action( 'wp_before_admin_bar_render', 'custom_logout_link' );



//移除後台上方檢視留言按鈕
//移除後台上方"+新增"按鈕
function my_admin_bar_render() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
    $wp_admin_bar->remove_menu( 'new-content' );
    $wp_admin_bar->remove_node( 'updates' );
    $wp_admin_bar->remove_node( 'view' );
}
add_action( 'wp_before_admin_bar_render', 'my_admin_bar_render' );



//隱藏後台發文"可見度(隱私文章)"選項
add_action('add_meta_boxes', function() {
    add_action('admin_head', function() {
        echo <<<EOS
<style type="text/css">
#visibility {
    display: none;
}
</style>
EOS;
    });
});



//特色圖片名稱修改
function cyb_filter_gettext_with_context( $translated, $original, $context, $domain ) {

    // Use the text string exactly as it is in the translation file
    if ( $translated == "精選圖片" ) {
        $translated = "封面";
	}
	if ( $translated == "移除精選圖片" ) {
        $translated = "移除封面";
	}
	if ( $translated == "設定精選圖片" ) {
        $translated = "設定封面";
    }
    return $translated;
}
add_filter( 'gettext_with_context', 'cyb_filter_gettext_with_context', 10, 4 );

?>