<?php
/**
 * Get all translation options
 *
 * @return array Returns list of all translation strings available in theme options panel
 * @since  1.0
 */

if ( !function_exists( 'kbg_get_translate_options' ) ):
	function kbg_get_translate_options() {
		global $kbg_translate;

		if ( !empty( $kbg_translate ) ) {
			return $kbg_translate;
		}

		$translate = array(

			'menu_label' => array( 'text' => esc_html__( 'Menu', 'knowledge-guru' ), 'desc' => 'Menu (hamburger) label inside header' ),
			'social_label' => array( 'text' => esc_html__( 'Follow me: ', 'knowledge-guru' ), 'desc' => 'Social icons label inside header' ),
			'by' => array( 'text' => esc_html__( ' ', 'knowledge-guru' ), 'desc' => 'By author name prefix' ),
			'newer_entries' => array( 'text' => esc_html__( 'Newer Entries', 'knowledge-guru' ), 'desc' => 'Pagination (prev/next) link text' ),
			'older_entries' => array( 'text' => esc_html__( 'Older Entries', 'knowledge-guru' ), 'desc' => 'Pagination (prev/next) link text' ),
			'load_more' => array( 'text' => esc_html__( 'Load more', 'knowledge-guru' ), 'desc' => 'Pagination (load more) link text' ),
			'previous_posts' => array( 'text' => esc_html__( 'Previous', 'knowledge-guru' ), 'desc' => 'Pagination (numeric) link text' ),
			'next_posts' => array( 'text' => esc_html__( 'Next', 'knowledge-guru' ), 'desc' => 'Pagination (numeric) link text' ),
			'read_more' => array( 'text' => esc_html__( 'Read more', 'knowledge-guru' ), 'desc' => 'Read more button text' ),
			'category' => array( 'text' => esc_html__( '', 'knowledge-guru' ), 'desc' => 'Category archive title prefix', 'default' => '-1' ),
			'tag' => array( 'text' => esc_html__( 'Tag: ', 'knowledge-guru' ), 'desc' => 'Tag archive title prefix' ),
			'author' => array( 'text' => esc_html__( 'Author: ', 'knowledge-guru' ), 'desc' => 'Author archive title prefix', 'default' => '-1' ),
			'archive' => array( 'text' => esc_html__( 'Archive: ', 'knowledge-guru' ), 'desc' => 'Archive title prefix' ),
			'search_results_for' => array( 'text' => esc_html__( 'You searched for:', 'knowledge-guru' ), 'desc' => 'Title for search results template' ),
			'search_placeholder' => array( 'text' => esc_html__( 'How can we help?', 'knowledge-guru' ), 'desc' => 'Search placeholder text' ),
			'search_label' => array( 'text' => esc_html__( 'Search', 'knowledge-guru' ), 'desc' => 'Search label inside header' ),
			'search_button' => array( 'text' => esc_html__( 'Search', 'knowledge-guru' ), 'desc' => 'Search button text' ),
			'search_again' => array( 'text' => esc_html__( 'Search again', 'knowledge-guru' ), 'desc' => 'Search results button text' ),
			'min_read' => array( 'text' => esc_html__( 'min read', 'knowledge-guru' ), 'desc' => 'Used in post meta data (reading time)' ),
			'author_box_label' => array( 'text' => esc_html__( 'About the author', 'knowledge-guru' ), 'desc' => 'Line before author name' ),
			'author_view_all' => array( 'text' => esc_html__( 'View all posts', 'knowledge-guru' ), 'desc' => 'View all link for author box on post.' ),
			
			'prev_post' => array( 'text' => esc_html__( 'Previous post', 'knowledge-guru' ), 'desc' => 'Single previous post meta subtitle.' ),
			'next_post' => array( 'text' => esc_html__( 'Next post', 'knowledge-guru' ), 'desc' => 'Single next post meta subtitle.' ),
			'related_blog' => array( 'text' => esc_html__( 'Related posts', 'knowledge-guru' ), 'desc' => 'Title of the Related box area on single blog template.' ),
			'related_kb' => array( 'text' => esc_html__( 'Related articles', 'knowledge-guru' ), 'desc' => 'Title of the Related box area on knowledge base template.' ),
			
			'leave_a_reply' => array( 'text' => esc_html__( 'Join the discussion', 'knowledge-guru' ), 'desc' => 'Title of comments box' ),
			'comment_reply' => array( 'text' => esc_html__( 'Reply', 'knowledge-guru' ), 'desc' => 'Comment reply label' ),
			'comment_submit' => array( 'text' => esc_html__( 'Submit comment', 'knowledge-guru' ), 'desc' => 'Comment form submit button label' ),
			'comment_text' => array( 'text' => esc_html__( 'Comment', 'knowledge-guru' ), 'desc' => 'Comment form text area label' ),
			'comment_email' => array( 'text' => esc_html__( 'Email', 'knowledge-guru' ), 'desc' => 'Comment form email label' ),
			'comment_name' => array( 'text' => esc_html__( 'Name', 'knowledge-guru' ), 'desc' => 'Comment form name label' ),
			'comment_website' => array( 'text' => esc_html__( 'Website', 'knowledge-guru' ), 'desc' => 'Comment form website label' ),
			'comment_cookie_gdpr' => array( 'text' => esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'knowledge-guru' ), 'desc' => 'Comment form checkbox cookie consent label' ),
			'comment_cancel_reply' => array( 'text' => esc_html__( 'Cancel reply', 'knowledge-guru' ), 'desc' => 'Comment cancel reply label' ),
			'no_comments' => array( 'text' => esc_html__( 'Add comment', 'knowledge-guru' ), 'desc' => 'Comment meta data (if zero comments)' ),
			'one_comment' => array( 'text' => esc_html__( '1 comment', 'knowledge-guru' ), 'desc' => 'Comment meta data (if 1 comment)' ),
			'multiple_comments' => array( 'text' => esc_html__( '% comments', 'knowledge-guru' ), 'desc' => 'Comment meta data (if more than 1 comments)' ),
		
			'articles' => array( 'text' => esc_html__( 'articles found', 'knowledge-guru' ), 'desc' => 'Number of posts/articles label for categories' ),
			'content_none' => array( 'text' => esc_html__( 'Sorry, there is no content found on this page. Feel free to contact the website administrator regarding this issue.', 'knowledge-guru' ), 'desc' => 'Message when there are no posts on archive pages. i.e an empty Category' ),
			'content_none_search' => array( 'text' => esc_html__( 'No results found. Please try again with a different keyword.', 'knowledge-guru' ), 'desc' => 'Message when there are no search results.' ),
			'404_title' => array( 'text' => esc_html__( 'Page not found', 'knowledge-guru' ), 'desc' => '404 page title' ),
			'404_text' => array( 'text' => esc_html__( 'This is an example of a 404 page. The page that you are looking for does not exist on this website. You may have accidentally mistyped the page address, or followed an expired link. Anyway, we will help you get back on track. Why not try to search for the page you were looking for:', 'knowledge-guru' ), 'desc' => '404 page text' ),


		);

		$kbg_translate = apply_filters( 'kbg_modify_translate_options', $translate );

		return $kbg_translate;

	}
endif;