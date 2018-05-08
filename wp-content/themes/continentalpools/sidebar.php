<div id="sidebar-widgets" class="four columns">

    <?php 
    wp_reset_query(); // needs to be wp_reset_query() instead of wp_reset_postdata() so that get_the_ID() pulls the correct ID.

	if(is_page() || is_page_template('page-blog.php')){
		// Page Sidebar 
		if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar(get_post_meta( get_the_ID(), 'minti_sidebar', true )) );
	} elseif(is_search()){
		// Search Results Sidebar 
		if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Search Results Widgets') );
	} else {
		// Blog Sidebar && Default Sidebar
		if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Blog Widgets') );
	}

	?>

</div>