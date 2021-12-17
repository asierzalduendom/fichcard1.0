<?php 
$intecopress_page_header_disabled = get_theme_mod('designexo_page_header_disabled', true);
$intecopress_page_header_background_color = get_theme_mod('designexo_page_header_background_color');

// theme page header Url functions
function intecopress_curPageURL() {
	$page_url = 'http';
	if ( key_exists("HTTPS", $_SERVER) && ( $_SERVER["HTTPS"] == "on" ) ){
		$page_url .= "s";
	}
	$page_url .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$page_url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$page_url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $page_url;
}
// theme page header breadcrumbs functions
if( !function_exists('intecopress_page_header_breadcrumbs') ):
	function intecopress_page_header_breadcrumbs() { 	
		global $post;
		$home_Link = home_url();
	    //echo '<ul class="page-breadcrumb text-center">';			
				if (is_home() || is_front_page()) :
					//echo '<li><a href="'.esc_url($home_Link).'">'.esc_html__('Home','intecopress').'</a></li>';
					   // echo '<li class="active">'; echo single_post_title(); echo '</li>';
						else:
						//echo '<li><a href="'.esc_url($home_Link).'">'.esc_html__('Home','intecopress').'</a></li>';
						if ( is_category() ) {
							//echo '<li class="active"><a href="'. intecopress_curPageURL() .'">' . esc_html__('Archive by category','intecopress').' "' . single_cat_title('', false) . '"</a></li>';
						} elseif ( is_day() ) {
							//echo '<li class="active"><a href="'. esc_url(get_year_link(esc_attr(get_the_time('Y')))) . '">'. esc_html(get_the_time('Y')) .'</a>';
						//	echo '<li class="active"><a href="'. esc_url(get_month_link(esc_attr(get_the_time('Y')),esc_attr(get_the_time('m')))) .'">'. esc_html(get_the_time('F')) .'</a>';
							//echo '<li class="active"><a href="'. intecopress_curPageURL() .'">'. esc_html(get_the_time('d')) .'</a></li>';
						} elseif ( is_month() ) {
						//	echo '<li class="active"><a href="' . get_year_link(esc_attr(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a>';
						//	echo '<li class="active"><a href="'. intecopress_curPageURL() .'">'. esc_html(get_the_time('F')) .'</a></li>';
						} elseif ( is_year() ) {
							//echo '<li class="active"><a href="'. intecopress_curPageURL() .'">'. esc_html(get_the_time('Y')) .'</a></li>';
                        } elseif ( is_single() && !is_attachment() && is_page('single-product') ) {
						if ( get_post_type() != 'post' ) {
							$cat = get_the_category(); 
							$cat = $cat[0];
							echo '<li>';
								echo get_category_parents($cat, TRUE, '');
							echo '</li>';
							//echo '<li class="active"><a href="' . intecopress_curPageURL() . '">'. get_the_title() .'</a></li>';
						} }  
						elseif ( is_page() && $post->post_parent ) {
							$parent_id  = $post->post_parent;
							$breadcrumbs = array();
							while ($parent_id) {
							$page = get_page($parent_id);
							$breadcrumbs[] = '<li class="active"><a href="' . esc_url(get_permalink($page->ID)) . '">' . get_the_title($page->ID) . '</a>';
							$parent_id  = $page->post_parent;
                            }
							$breadcrumbs = array_reverse($breadcrumbs);
							foreach ($breadcrumbs as $crumb) echo $crumb;
							//echo '<li class="active"><a href="' . intecopress_curPageURL() . '">'. get_the_title().'</a></li>';
                        }
						elseif( is_search() )
						{
							//echo '<li class="active"><a href="' . intecopress_curPageURL() . '">'. get_search_query() .'</a></li>';
						}
						elseif( is_404() )
						{
							//echo '<li class="active"><a href="' . intecopress_curPageURL() . '">'.esc_html__('Error 404','intecopress').'</a></li>';
						}
						else { 
						   // echo '<li class="active"><a href="' . intecopress_curPageURL() . '">'. get_the_title() .'</a></li>';
						}
					endif;
			echo '</ul>';
        }
endif;

// theme page header title functions
function intecopress_theme_page_header_title(){
	if( is_archive() )
	{
		echo '<div class="page-header-title text-center"><h1 class="text-white">';
		if ( is_day() ) :
		/* translators: %1$s %2$s: day */
		  printf( esc_html__( '%1$s %2$s', 'intecopress' ), esc_html__('Archives','intecopress'), get_the_date() );  
        elseif ( is_month() ) :
		/* translators: %1$s %2$s: month */
		  printf( esc_html__( '%1$s %2$s', 'intecopress' ), esc_html__('Archives','intecopress'), get_the_date( 'F Y' ) );
        elseif ( is_year() ) :
		/* translators: %1$s %2$s: year */
		  printf( esc_html__( '%1$s %2$s', 'intecopress' ), esc_html__('Archives','intecopress'), get_the_date( 'Y' ) );
		elseif( is_author() ):
		/* translators: %1$s %2$s: author */
			printf( esc_html__( '%1$s %2$s', 'intecopress' ), esc_html__('All posts by','intecopress'), get_the_author() );
        elseif( is_category() ):
		/* translators: %1$s %2$s: category */
			printf( esc_html__( '%1$s %2$s', 'intecopress' ), esc_html__('Category','intecopress'), single_cat_title( '', false ) );
		elseif( is_tag() ):
		/* translators: %1$s %2$s: tag */
			printf( esc_html__( '%1$s %2$s', 'intecopress' ), esc_html__('Tag','intecopress'), single_tag_title( '', false ) );
		elseif( class_exists( 'WooCommerce' ) && is_shop() ):
		/* translators: %1$s %2$s: WooCommerce */
			printf( esc_html__( '%1$s %2$s', 'intecopress' ), esc_html__('Shop','intecopress'), single_tag_title( '', false ));
        elseif( is_archive() ): 
		the_archive_title( '<h1 class="text-white">', '</h1>' ); 
		endif;
		echo '</h1></div>';
	}
	elseif( is_404() )
	{
		echo '<div class="page-header-title text-center"><h1 class="text-white">';
		/* translators: %1$s: 404 */
		printf( esc_html__('404','intecopress') );
		echo '</h1></div>';
	}
	elseif( is_search() )
	{
		echo '<div class="page-header-title text-center"><h1 class="text-white">';
		/* translators: %1$s %2$s: search */
		printf( esc_html__( '%1$s %2$s', 'intecopress' ), esc_html__('Search results for','intecopress'), get_search_query() );
		echo '</h1></div>';
	}
	else
	{
		echo '<div class="page-header-title text-center"><h1 class="text-white">'.esc_html( get_the_title() ).'</h1></div>';
	}
}



?>
<?php if($intecopress_page_header_disabled == true): ?>
<!-- Theme Page Header Area -->		
	<section class="theme-page-header-area">
	<?php if($intecopress_page_header_background_color != null): ?>
		<div class="overlay" style="background-color: <?php echo esc_attr($intecopress_page_header_background_color); ?>;"></div>
    <?php else: ?>
        <div class="overlay"></div>
	<?php endif; ?>	
		<div id="content" class="container">
			<div class="row wow animate fadeInUp" data-wow-delay="0.3s">
				<div class="col-lg-12 col-md-12 col-sm-12">
			        <?php 
                    if(is_home() || is_front_page()) {
                        echo '<div class="page-header-title text-center"><h1 class="text-white">'; echo single_post_title(); echo '</h1></div>';
                    } else{
                        intecopress_theme_page_header_title();
                    } 
                    intecopress_page_header_breadcrumbs();

                    ?>					
			     
			    </div>
			</div>
		</div>	
	</section>	
<!-- Theme Page Header Area -->		
<?php endif; ?>