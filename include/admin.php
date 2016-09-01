<?php 
/*------------------------------------*\
    後臺相關功能
\*------------------------------------*/
function new_login_logo() {                                                             /* 自訂登入畫面LOGO */ 
     echo '<style type="text/css">.login h1 a { background-image:url('.get_template_directory_uri().'/img/company-logo.png) !important; background-size: 270px 164px!important; width:270px!important; height:164px !important; }</style>';
}
function custom_loginlogo_url($url) { return get_bloginfo('url'); }                     /* 變更自訂登入畫面上LOGO的連結 */ 
function put_my_title(){ return ('FemtoPath'); }                                        /* 變更自訂登入畫面上LOGO的Hover所出現的標題 */
function remove_wp_logo( $wp_admin_bar ) { $wp_admin_bar->remove_node( 'wp-logo' ); }   /* 移除控制台左上角WP-LOGO */ 
function custom_dashboard_footer () {                                                   /* 修改後台底下的wordpress文字宣告 */ 
    echo '官網維護單位 : <a href="#">自定</a>。後台如有任何問題, 請聯絡<a href="#">自定</a>'; 
}     
function change_footer_admin () {return '&nbsp;';}                                      /* 隱藏後台右下角wp版本號 */ 
function change_footer_version() {return ' ';}

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

/* 在後臺加入自訂 JS、CSS */ 
function custom_admin_res() {
    // $url = get_bloginfo('template_directory') . '/js/custom-wp-admin.js';
    // echo '<script src="'. $url . '"></script>';
}
?>