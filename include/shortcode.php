<?php 

function shortcode_demo($atts, $content = null){
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode 
}
//add_shortcode('shortcode_demo', 'shortcode_demo');



function shortcode_demo_2($atts, $content = null){
    return '<h2>' . $content . '</h2>';
}
//add_shortcode('shortcode_demo_2', 'shortcode_demo_2');


?>