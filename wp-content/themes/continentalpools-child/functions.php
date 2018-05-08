<?php 
function multid_sort($arr, $index) {
    $b = array();
    $c = array();
    foreach ($arr as $key => $value) {
        $b[$key] = $value[$index];
    }

    asort($b);

    foreach ($b as $key => $value) {
        $c[] = $arr[$key];
    }

    return $c;
}

add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );
function _remove_script_version( $src ){
	$parts = explode( '?ver', $src );
	return $parts[0];
}

add_shortcode( 'page_title', 'get_page_title' );
function get_page_title( ){
   return get_the_title();
}

add_action( 'pre_get_posts', 'custom_pre_get_posts_query' );
function custom_pre_get_posts_query( $q ) {
	if (!$q->is_main_query())
		return;
	if (!$q->is_post_type_archive())
		return;
	if (!is_admin() && is_shop()) :
		$q->set( 'tax_query', array(
			array(
				'taxonomy' => 'product_cat',
				'field' => 'slug',
				'terms' => array( 'classes' ), 
				'operator' => 'NOT IN'
			)
		));
	endif;
	remove_action( 'pre_get_posts', 'custom_pre_get_posts_query' );
}

add_action( 'init', 'stop_heartbeat', 1 );
function stop_heartbeat() {
        wp_deregister_script('heartbeat');
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
add_action('woocommerce_before_main_content', 'continentalpools_wrapper_start', 10);
function continentalpools_wrapper_start() {
  echo '<div id="content" class="woocommerce" style="width: 100%">';
}

remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_after_main_content', 'continentalpools_wrapper_end', 10);
function continentalpools_wrapper_end() {
  echo '</div>';
}

add_action('wp_enqueue_scripts', 'theme_styles');
function theme_styles() {
	wp_enqueue_style('main', get_template_directory_uri() . '/style.css');
}

add_theme_support ('menus');
add_theme_support ('woocommerce');

// Shortcode: Training Courses
add_shortcode('cp_get_courses','cp_courses');
function cp_courses($atts) {
	if (empty($atts['category']))
		return;
	$args = array(
		'post_type' => 'product',
		'tax_query' => array(
        'relation' => 'AND',
	        array(
	            'taxonomy' => 'product_cat',
	            'field' => 'slug',
	            'terms' => 'classes'
	        ),
	        array(
	            'taxonomy' => 'product_cat',
	            'field' => 'slug',
	            'terms' => $atts['category']
	        )
	    ),
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key' => 'start_date',
				'value' => date('Ymd'),
				'compare' => '>=',
			),
		),
		'meta_key' => 'start_date',
		'orderby' => 'meta_value',
		'order' => 'ASC'
	);
	$courses = new WP_Query($args);
	//echo '<pre>';print_r($courses);die();
	if (!empty($courses->posts)) :
		global $woocommerce;
		$return = '<ul class="cp_courses">';
		foreach ($courses->posts as $course) :
			$_product = new WC_Product($course->ID);
			$return .= '<li class="cp_course">';
			$return .= '<a href="' . get_permalink($course->ID) . '">';
			$return .= '<h4>' . $course->post_title . '</h4>';
			$return .= '<span class="cp_course_facility">' . get_field('facility', $course->ID) . '</span>';
			//$return .= '<span class="cp_course_start_date">' . date('m-d-Y', strtotime(get_field('start_date', $course->ID))) . '</span>';
			$return .= '<span class="cp_course_address">' . get_field('address', $course->ID) . '</span>';
			$return .= '<span class="cp_course_price">' . wc_price($_product->get_price()) . '</span>';
			$return .= '</a>';
			$return .= '</li>';
		endforeach;
		$return .= '</ul>';
	endif;
	return $return;
}
/*
add_shortcode( 'cp_training_courses', 'cp_training_courses' );
function cp_training_courses ($office) {
	ob_start();
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
	wc_print_notices();
	do_action( 'woocommerce_before_main_content' );
	$args = array(
		'posts_per_page'     => -1,
		'order'      => 'DESC',
		'orderby' => 'id',
		'hide_empty' => '0',
		'parent' => 34
	);
	
	//Create array to store matched courses and classes data later
	$coursesArray = array();
	
	$product_categories = get_terms( 'product_cat', $args );
	//echo '<pre>';print_r($product_categories);echo '</pre>';
	$i = 0;
	foreach( $product_categories as $cat ) {
		$approx_time = get_field('approximate_time', 'product_cat_' . $cat->term_id);
		$prerequisites = get_field('prerequisites', 'product_cat_' . $cat->term_id);
		
		$args = array( 
			'post_type' => 'product',
			'posts_per_page' => -1,
			'product_cat' => $cat->slug,
			'orderby' => 'DESC',
			'meta_query' => array(
				array(
					'key'		=> 'start_date',
					'value'		=> date('Ymd'),
					'compare'	=> '>='
				)
			)
		);

		$loop = new WP_Query( $args );
		//echo '<pre style="display:none;" data-cat="'.$cat->slug.'">';print_r($loop);echo '</pre>';
		//check if $loop course is the one we're looking for by comparing it to $office
		preg_match("/^(\w+)/",$cat->name,$firstWord);
		if (strtolower($firstWord[1]) == strtolower($office['office'])) {
			//add course and classes to array
			$coursesArray[$i] = array('name'=>$cat->name,'prerequisites'=>$prerequisites,'approx_time'=>$approx_time,'classes'=>array());
			wp_reset_query();
			$loop = new WP_Query( $args );
			//set counter for classes
			$c = 0;
			while ( $loop->have_posts() ) : 
				$loop->the_post();
				$fields = get_field_objects();
				global $product; 
				$in_stock = $product->is_in_stock() ? 1 : 0;
				
				//add this class to the coursearray
				$coursesArray[$i]['classes'][$c] = array('ID'=>$product->post->ID,'price'=>$product->price,'office'=>$fields[office][value],'start_date'=>date('m/d/Y',strtotime($fields[start_date][value])),'end_date'=>date('m/d/Y',strtotime($fields[end_date][value])),'facility'=>$fields[facility][value],'address'=>$fields[address][value],'notes'=>$fields[notes][value],'link'=>$product->post->guid,'in_stock'=>$in_stock);
				$c++;
			endwhile; 
			$i++;
		}
	}
	$x = 0;
	if (!empty($coursesArray)) :
		foreach($coursesArray as $course) {
			$sortedClasses = multid_sort($course['classes'], 'start_date');
			$coursesArray[$x]['classes'] = $sortedClasses;
			$x++;
		}
		sort($coursesArray);
		//Print the courses and classes!
		foreach ($coursesArray as $course) {
			if (!empty($course['classes'])) :
				echo '<h2>'.$course['name'].'</h2>';
				echo '<p>'.$course['approx_time'].'</p>';
				echo '<h2>Prerequisites</h2>'.$course['prerequisites'];
		?>
				<table class="classes-table">
					<thead>
						<th style="width:48px">Office</th>
						<th style="width:98px">Dates</th>
						<th style="width:87px">Facility Name</th>
						<th style="width:181px">Address</th>
						<th style="width:225px">Notes</th>
						<th style="width:100px">Price</th>
						<th style="width:85px">Registration</th>
					</thead>
		<?php 
					foreach ($course['classes'] as $class) {
						echo '<tr data-class-id="' . $class['ID'] . '"><td>' . $class['office'] . '</td>';
						echo '<td>' . $class['start_date'] . ' - ' . $class['end_date'] . '</td>';
						echo '<td>' . $class['facility'] . '</td>';
						echo '<td>' . $class['address'] . '</td>';
						echo '<td>' . $class['notes'] . '</td>';
						echo '<td>$';
						echo (ctype_digit($class['price'])) ? $class['price'] . '.00' : $class['price'];
						echo '</td><td>';
						if ($class['in_stock'] == 0)
							echo '<button type="" class="closed">Closed</button>';
						else
							echo '<a href="'.$class['link'].'"><button type="submit" class="add_to_cart_button button alt">Register</button></a>';
					}
		?>
				</table>
				<hr />
	<?php
			endif;
		}
	else : 
		echo '<p>We\'re sorry, there are no courses available at this time. Please check back later!</p>';
	endif;
	
	//echo '<pre>';print_r ($coursesArray);echo '</pre>';
	
	do_action( 'woocommerce_after_main_content' );
	return ob_get_clean();
}
*/

add_action('the_post','check_for_classes',10);
function check_for_classes() {
	if (is_checkout() || is_cart()) {
		$contents = WC()->cart->cart_contents;
		$class_present = 0;
		$reg_present = 0;
		foreach ($contents as $item) {
			$cat = get_the_terms( $item['product_id'], 'product_cat' );
			foreach ($cat as $cat2) {
				foreach ($cat2 as $key => $value) {
					if (($key == 'term_id') && ($value == 34))
						$class_present++;
					else if ($key == 'term_id')
						$reg_present++;
				}
			}
		}
		if (($class_present > 0) && ($class_present < $reg_present)) {
			WC()->add_error( sprintf(__('Sorry, classes and clothing must be purchased separately. Please remove an item from your cart.', 'woocommerce')) );
	    	if (is_checkout())
	    		wp_redirect( get_permalink( woocommerce_get_page_id( 'cart' ) ) );
		}
	}
}

//add_action('the_post', 'remove_spinner', 10);
function remove_spinner() {
	if (is_product()) {
		global $post;
		$prod_terms = get_the_terms( $post->ID, 'product_cat' );
		foreach ($prod_terms as $prod_term) {
    		// gets product cat id
    		$product_cat_id = $prod_term->term_id;
			if ($product_cat_id == 34) {
				//echo "REMOVE SPINNER";
				?>
				<script type="text/javascript">
					jQuery(document).on('ready',function(){
						jQuery('div.quantity').hide();
					});
				</script>
				<?
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
			}
		}
	}
}

add_action('init', 'woocommerce_clear_cart_url');
function woocommerce_clear_cart_url() {
	if( isset($_REQUEST['clear-cart']) ) {
		WC()->cart->empty_cart();
	}
}

//remove_action('load-update-core.php','wp_update_plugins');
//add_filter('pre_site_transient_update_plugins','__return_null');