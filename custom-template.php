<?php 
// Template Name: 'No Title Full Width'

	get_header();

    if ( ! post_password_required( $post ) ) {
          // Your custom code should here
       while(have_post()): the_post();

	   endwhile;


    }else{
      
        echo get_the_password_form();
    }

	get_footer();