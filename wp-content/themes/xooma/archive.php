<?php
/**
 * xooma template for displaying Archives
 *
 * @package    WordPress
 * @subpackage xooma
 * @since      xooma 0.0.1
 */

get_header(); ?>

    <section class="page-content primary" role="main"><?php

        if ( have_posts() ) : ?>

            <h1 class="archive-title">
            <?php
            if ( is_category() ):
                printf( __( 'Category Archives: %s', 'xooma' ), single_cat_title( '', FALSE ) );

            elseif ( is_tag() ):
                printf( __( 'Tag Archives: %s', 'xooma' ), single_tag_title( '', FALSE ) );

            elseif ( is_tax() ):
                $term     = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                $taxonomy = get_taxonomy( get_query_var( 'taxonomy' ) );
                printf( __( '%s Archives: %s', 'xooma' ), $taxonomy->labels->singular_name, $term->name );

            elseif ( is_day() ) :
                printf( __( 'Daily Archives: %s', 'xooma' ), get_the_date() );

            elseif ( is_month() ) :
                printf( __( 'Monthly Archives: %s', 'xooma' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'xooma' ) ) );

            elseif ( is_year() ) :
                printf( __( 'Yearly Archives: %s', 'xooma' ), get_the_date( _x( 'Y', 'yearly archives date format', 'xooma' ) ) );

            elseif ( is_author() ) : the_post();
                printf( __( 'All posts by %s', 'xooma' ), get_the_author() );

            else :
                _e( 'Archives', 'xooma' );

            endif;
            ?>
            </h1><?php

            if ( is_category() || is_tag() || is_tax() ):
                $term_description = term_description();
                if ( !empty( $term_description ) ) : ?>

                    <div class="archive-description"><?php
                    echo $term_description; ?>
                    </div><?php

                endif;
            endif;

            if ( is_author() && get_the_author_meta( 'description' ) ) : ?>

                <div class="archive-description">
                <?php the_author_meta( 'description' ); ?>
                </div><?php

            endif;

            while ( have_posts() ) : the_post();

                get_template_part( 'loop', get_post_format() );

            endwhile;

        else :

            get_template_part( 'loop', 'empty' );

        endif; ?>

        <div class="pagination">

            <?php get_template_part( 'template-part', 'pagination' ); ?>

        </div>
    </section>

<?php get_footer(); ?>