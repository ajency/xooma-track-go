<?php
/**
 * xooma template for displaying Pages
 *
 * @package    WordPress
 * @subpackage xooma
 * @since      xooma 0.0.1
 */

get_header(); ?>

    <section class="page-content primary" role="main">

        <?php
        if ( have_posts() ) : the_post();

            get_template_part( 'loop' ); ?>

            <aside class="post-aside"><?php

            wp_link_pages(
                array(
                    'before'         => '<div class="linked-page-nav"><p>' . sprintf( __( '<em>%s</em> is separated in multiple parts:', 'xooma' ), get_the_title() ) . '<br />',
                    'after'          => '</p></div>',
                    'next_or_number' => 'number',
                    'separator'      => ' ',
                    'pagelink'       => __( '&raquo; Part %', 'xooma' ),
                )
            ); ?>

            <?php
            if ( comments_open() || get_comments_number() > 0 ) :
                comments_template( '', TRUE );
            endif;
            ?>

            </aside><?php

        else :

            get_template_part( 'loop', 'empty' );

        endif;
        ?>

    </section>

<?php get_footer(); ?>