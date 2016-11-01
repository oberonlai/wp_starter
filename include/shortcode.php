<?php 
// Shortcodes
add_shortcode('shortcode_demo', 'shortcode_demo'); // You can place [shortcode_demo] in Pages, Posts now.
add_shortcode('shortcode_demo_2', 'shortcode_demo_2'); // Place [shortcode_demo_2] in Pages, Posts now.

// Shortcode Demo with Nested Capability
function shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}
?>