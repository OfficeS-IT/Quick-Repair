<?php
/**
 * Template Name: Custom Home
 */

get_header(); ?>

<?php do_action( 'vw_automobile_lite_above_slider' ); ?>

<?php /** slider section **/ ?>
	<?php
	// Get pages set in the customizer (if any)
	$pages = array();
	for ( $count = 1; $count <= 5; $count++ ) {
	$mod = intval( get_theme_mod( 'vw_automobile_lite_slidersettings-page-' . $count ));
	if ( 'page-none-selected' != $mod ) {
	  $pages[] = $mod;
	}
	}
	if( !empty($pages) ) :
	  $args = array(
	    'post_type' => 'page',
	    'post__in' => $pages,
	    'orderby' => 'post__in'
	  );
	  $query = new WP_Query( $args );
	  if ( $query->have_posts() ) :
	    $count = 1;
	    ?>
		<div class="slider-main">
	    	<div id="slider" class="nivoSlider">
		      <?php
		        $vw_automobile_lite_n = 0;
				while ( $query->have_posts() ) : $query->the_post();
				  
				  $vw_automobile_lite_n++;
				  $vw_automobile_lite_slideno[] = $vw_automobile_lite_n;
				  $vw_automobile_lite_slidetitle[] = get_the_title();
				  $vw_automobile_lite_slidelink[] = esc_url(get_permalink());
				  ?>
				   <img src="<?php the_post_thumbnail_url('full'); ?>" title="#slidecaption<?php echo esc_attr( $vw_automobile_lite_n ); ?>" />
				  <?php
				$count++;
				endwhile;
				wp_reset_postdata();
		      ?>
		    </div>

		    <?php
		    $vw_automobile_lite_k = 0;
	      	foreach( $vw_automobile_lite_slideno as $vw_automobile_lite_sln )
	      	{ ?>
		      <div id="slidecaption<?php echo esc_attr( $vw_automobile_lite_sln ); ?>" class="nivo-html-caption">
		        <div class="slide-cap  ">
		          <div class="container">
		            <h2><?php echo esc_html($vw_automobile_lite_slidetitle[$vw_automobile_lite_k]); ?></h2>
		            <a class="read-more" href="<?php echo esc_url($vw_automobile_lite_slidelink[$vw_automobile_lite_k] ); ?>"><?php esc_html_e( 'Learn More','vw-automobile-lite' ); ?></a>
		          </div>
		        </div>
		      </div>
		        <?php $vw_automobile_lite_k++;
		        wp_reset_postdata();
		    } ?>
		</div>
	  <?php else : ?>
	      <div class="header-no-slider"></div>
	    <?php
	  endif;
	endif;
?>

<?php do_action( 'vw_automobile_lite_below_slider' ); ?>

<?php /*--why choose us --*/?>

<section id="choose_us" class="darkbox" >
	<?php if( get_theme_mod('vw_automobile_lite_title') != ''){ ?>
	    <div class="heading-line">
	      	<h3><?php echo esc_html(get_theme_mod('vw_automobile_lite_title','')); ?> </h3>
	      	<div class="images_border">
	          	<img src="<?php echo esc_url( get_theme_mod('',get_template_directory_uri().'/images/car-border.png') ); ?>" alt="">
	        </div>
	    </div>
    <?php } ?>
	<div class="container">
		<div class="row">
			<?php 
			    $page_query = new WP_Query(array( 'category_name' => get_theme_mod('vw_automobile_lite_choose_us_category','theblog')));?>
			  	<?php while( $page_query->have_posts() ) : $page_query->the_post(); ?>
			  		<div class="col-md-4 col-sm-4">
			    		<div class="choose-img"><?php if(has_post_thumbnail()) { ?><?php the_post_thumbnail(); ?><?php } ?></div>
			    		<a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
			    		<p><?php the_excerpt(); ?></p>
				    </div>
				<?php endwhile; 
				wp_reset_postdata();
			?>
		</div>
		<div class="clearfix"></div>
	</div>
</section>

<?php do_action( 'vw_automobile_lite_below_choose_us' ); ?>

<div class="container">
	<?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
    <?php endwhile; // end of the loop. ?>
</div>

<?php get_footer(); ?>