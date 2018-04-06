<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Heisenberg
 */

get_header(); ?>

	<main class="row column">

		<?php
		if ( have_posts() ) : ?>

			<?php
			printf( '<h1>Search Results for: %s</h1>',
				esc_html( get_search_query() )
			);

			while ( have_posts() ) :

				the_post();

				the_title( '<h2>', '</h2>' );

				the_excerpt();

				printf( '<a href="%s" class="button">Read More</a>',
					esc_url( get_the_permalink() )
				);

			endwhile;

			$navArgs = array(
				'prev_text'          => __( 'Next page' ),
				'next_text'          => __( 'Previous page' ),
				'screen_reader_text' => __( 'Search results navigation' ),
			);

			the_posts_navigation($navArgs);

		else :

			printf( '<h1>Search Results for: %s</h1>',
				esc_html( get_search_query() )
			);

			printf( 'Sorry, no results found for \'%s\'. Maybe try again?',
				esc_html( get_search_query() )
			);

			get_search_form();

		endif; ?>

	</main>

<?php
get_footer();
