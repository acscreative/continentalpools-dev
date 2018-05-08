<?php
/*-----------------------------------------------------------------------------------*/
/*  Breadcrumbs Function based on Dimox
    Source: http://dimox.net/wordpress-breadcrumbs-without-a-plugin/ */
/*-----------------------------------------------------------------------------------*/

function minti_breadcrumbs() {

  global $minti_data;
  
  /* Options */
  $text['home']     = get_bloginfo('name'); // text for the 'Home' link
  $text['category'] = __( 'Archive by Category "%s"', 'minti' ); // text for a category page
  $text['search']   = __( 'Search Results for "%s" Query', 'minti' ); // text for a search results page
  $text['tag']      = __( 'Posts Tagged "%s"', 'minti' ); // text for a tag page
  $text['author']   = __( 'Articles Posted by %s', 'minti' ); // text for an author page
  $text['404']      = __( 'Error 404', 'minti' ); // text for the 404 page
  $text['page']     = __( 'Page %s', 'minti' ); // text 'Page N'
  $text['cpage']    = __( 'Comment Page %s', 'minti' ); // text 'Comment Page N'

  $wrap_before    = '<div id="crumbs">'; // the opening wrapper tag
  $wrap_after     = '</div><!-- #crumbs -->'; // the closing wrapper tag
  $sep            = '/'; // separator between crumbs
  $sep_before     = '<span class="sep">'; // tag before separator
  $sep_after      = '</span>'; // tag after separator
  $show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
  $show_on_home   = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
  $show_current   = 1; // 1 - show current page title, 0 - don't show
  $before         = '<span class="current">'; // tag before the current crumb
  $after          = '</span>'; // tag after the current crumb
  $sep            = ' ' . $sep_before . $sep . $sep_after . ' ';

  // WooCommerce
  if ( function_exists( 'woocommerce_breadcrumb' ) AND ( is_shop() OR is_product_category() OR is_product_tag() OR is_product() OR is_account_page() ) ) {
    echo woocommerce_breadcrumb( array(
      'delimiter' => $sep,
      'wrap_before' => '<div class="g-breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">',
      'wrap_after' => '</div>',
      'before' => $before,
      'after' => $after,
      'home' => $text['home'],
    ) );
    return;
  }

  // bbPress
  if ( function_exists( 'bbp_get_breadcrumb' ) AND in_array( get_post_type(), array( 'topic', 'forum' ) ) ) {
    echo bbp_get_breadcrumb( array(
      'before' => '<div class="g-breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">',
      'after' => '</div>',
      'sep' => $sep,
      'crumb_before' => $before,
      'crumb_after' => $after,
      'home_text' => $text['home'],
    ) );
    return;
  }

  global $post;
  $home_link      = home_url('/');
  $link_before    = '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">';
  $link_after     = '</span>';
  $link_attr      = ' itemprop="url"';
  $link_in_before = '<span itemprop="title">';
  $link_in_after  = '</span>';
  $link           = $link_before . '<a href="%1$s"' . $link_attr . '>' . $link_in_before . '%2$s' . $link_in_after . '</a>' . $link_after;
  $frontpage_id   = get_option('page_on_front');
  if (have_posts()) {
    $parent_id = $post->post_parent;
  }

  if (is_home() || is_front_page()) {

    if ($show_on_home) echo $wrap_before . '<a href="' . $home_link . '">' . $text['home'] . '</a>' . $wrap_after;

  } else {

    echo $wrap_before;
    if ($show_home_link) echo sprintf($link, $home_link, $text['home']);

    if ( is_category() ) {
      $cat = get_category(get_query_var('cat'), false);
      if ($cat->parent != 0) {
        $cats = get_category_parents($cat->parent, TRUE, $sep);
        $cats = preg_replace("#^(.+)$sep$#", "$1", $cats);
        $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
        if ($show_home_link) echo $sep;
        echo $cats;
      }
      if ( get_query_var('paged') ) {
        $cat = $cat->cat_ID;
        echo $sep . sprintf($link, get_category_link($cat), get_cat_name($cat)) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
      } else {
        if ($show_current) echo $sep . $before . sprintf($text['category'], single_cat_title('', false)) . $after;
      }

    } elseif ( is_search() ) {
      if (have_posts()) {
        if ($show_home_link && $show_current) echo $sep;
        if ($show_current) echo $before . sprintf($text['search'], get_search_query()) . $after;
      } else {
        if ($show_home_link) echo $sep;
        echo $before . sprintf($text['search'], get_search_query()) . $after;
      }

    } elseif ( is_day() ) {
      if ($show_home_link) echo $sep;
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $sep;
      echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F'));
      if ($show_current) echo $sep . $before . get_the_time('d') . $after;

    } elseif ( is_month() ) {
      if ($show_home_link) echo $sep;
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y'));
      if ($show_current) echo $sep . $before . get_the_time('F') . $after;

    } elseif ( is_year() ) {
      if ($show_home_link && $show_current) echo $sep;
      if ($show_current) echo $before . get_the_time('Y') . $after;

    } elseif ( is_single() && ! is_attachment() ) {
          echo $sep; 
          if ( get_post_type() != 'post' ) {
            $post_type = get_post_type_object( get_post_type() );
            if ( ! empty( $post_type->labels->name ) ) {
              echo $post_type->labels->name;
            }
            if ( $show_current == 1 ) {
              echo $sep . $before . get_the_title() . $after;
            }
          } else {
            $cat = get_the_category();
            $cat = $cat[0];
            $cats = get_category_parents( $cat, TRUE, $sep );
            if ( $show_current == 0 ) {
              $cats = preg_replace( "#^(.+)$sep$#", "$1", $cats );
            }
            echo $cats;
            if ( $show_current == 1 ) {
              echo $before . get_the_title() . $after;
            }
          }

    // custom post type
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      if ( get_query_var('paged') ) {
        echo $sep . sprintf($link, get_post_type_archive_link($post_type->name), $post_type->label) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
      } else {
        if ($show_current) echo $sep . $before . $post_type->label . $after;
      }

    } elseif ( is_attachment() ) {
      if ($show_home_link) echo $sep;
      $parent = get_post($parent_id);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      if ($cat) {
        $cats = get_category_parents($cat, TRUE, $sep);
        $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
        echo $cats;
      }
      printf($link, get_permalink($parent), $parent->post_title);
      if ($show_current) echo $sep . $before . get_the_title() . $after;

    } elseif ( is_page() && !$parent_id ) {
      if ($show_current) echo $sep . $before . get_the_title() . $after;

    } elseif ( is_page() && $parent_id ) {
      if ($show_home_link) echo $sep;
      if ($parent_id != $frontpage_id) {
        $breadcrumbs = array();
        while ($parent_id) {
          $page = get_page($parent_id);
          if ($parent_id != $frontpage_id) {
            $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
          }
          $parent_id = $page->post_parent;
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        for ($i = 0; $i < count($breadcrumbs); $i++) {
          echo $breadcrumbs[$i];
          if ($i != count($breadcrumbs)-1) echo $sep;
        }
      }
      if ($show_current) echo $sep . $before . get_the_title() . $after;

    } elseif ( is_tag() ) {
      if ( get_query_var('paged') ) {
        $tag_id = get_queried_object_id();
        $tag = get_tag($tag_id);
        echo $sep . sprintf($link, get_tag_link($tag_id), $tag->name) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
      } else {
        if ($show_current) echo $sep . $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
      }

    } elseif ( is_author() ) {
      global $author;
      $author = get_userdata($author);
      if ( get_query_var('paged') ) {
        if ($show_home_link) echo $sep;
        echo sprintf($link, get_author_posts_url($author->ID), $author->display_name) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
      } else {
        if ($show_home_link && $show_current) echo $sep;
        if ($show_current) echo $before . sprintf($text['author'], $author->display_name) . $after;
      }

    } elseif ( is_404() ) {
      if ($show_home_link && $show_current) echo $sep;
      if ($show_current) echo $before . $text['404'] . $after;

    } elseif ( has_post_format() && !is_singular() ) {
      if ($show_home_link) echo $sep;
      echo get_post_format_string( get_post_format() );
    }

    echo $wrap_after;

  }
}