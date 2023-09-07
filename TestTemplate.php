<?php
// Template Name: Homepage New
get_header();

?>
<div style="margin-bottom:100px; height: 500px; background: url(https://plantly.io/wp-content/uploads/2022/12/Plantly-Holidays-New-Year-Tree-in-Room.jpg);width:100%;"></div>
<?php

echo do_shortcode( '[featured_products limit=10 columns=5]' );
echo do_shortcode('[product_categories columns="5" number="0" parent="0"]');