<?php 
/*------------------------------------*\
    新加入功能
\*------------------------------------*/
// 加入 body class 名稱
function add_slug_to_body_class($classes) {
    global $post;
    if (is_front_page()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);     // 確保只會有英數當 class
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }
    return $classes;
}
// 分頁導覽
function html5wp_pagination() {
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}
// 判斷所在位置取得頁面標題
function getTitle(){
    if( is_page('home') ) { echo ""; }
    elseif(is_category()){ single_term_title(); }
    elseif(is_singular()){ echo the_title(); } 
    elseif(is_404()) { echo '頁面錯誤'; } 
    echo ' | '.get_bloginfo('title');
}
// 如果文章有 tag 的話，則拿來做為 meta keyword
function getKeyword(){
    $posttags = get_the_tags(); 
    $i = 0;
    $len = count($posttags);
    if($posttags) {
        echo "<meta name='keywords' content='";
        foreach($posttags as $tag) {
            if ($i == $len - 1) {
                echo $tag->name;
            } else {
                echo $tag->name . ',';
            }
            $i++;
        }
        echo "'>\n";
    }
}
// 判斷所在位置取得頁面描述
function getDesp(){
    if(empty(get_the_excerpt())){
        echo get_bloginfo('description');   
    } else {
        echo get_the_excerpt();
    }
}
// 在文章頁取得作者名
function getAuthor(){
    global $post;
    if(is_single()){
        echo "<meta property='author' content='";
        $author = get_user_option('display_name', $post->post_author ); 
        echo $author;
        echo "'>\n";
    }
}
// 限制字數，第一個參數丟字串，第二個丟字數
function mySubstr($str,$num){
    return mb_substr($str,0,$num,'utf8');
}
// 增加 current menu 的 class 為 active
function special_nav_class($classes, $item){
    if( in_array('current-menu-item', $classes) ){
        $classes[] = 'active ';
    }
    return $classes;
}
// 文章沒設特色圖片時會自動抓第一張圖片顯示
function getImage() {
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/< *img[^>]*src *= *["\']?([^"\']*)/i', $post->post_content, $matches);
    if(empty($output)){
        echo get_template_directory_uri()."/img/default.png";
    } elseif (has_post_thumbnail( $post->ID ) ) {
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );    
        $first_img = $image[0];
        echo $first_img;
    } else {
        $first_img = $matches[1][0];
        echo $first_img;
    }
}
// 如果沒設摘要，取得內文第一段做為摘要
function get_first_paragraph(){
    global $post;
    if(get_the_excerpt()){
        return get_the_excerpt();
    } else {
        $str = wpautop( get_the_content() );
        $str = strip_tags(str_replace(array("<q>", "</q>"), array("_", "_"), $str));
        return $str;
    }
}
?>