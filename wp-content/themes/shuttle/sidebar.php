<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package ShuttleThemes
 */
?>

		<div id="sidebar">
		<div id="sidebar-core">

			<?php do_action( 'before_sidebar' ); ?>
			<?php if ( ! dynamic_sidebar( shuttle_input_sidebars() ) and current_user_can( 'edit_theme_options' ) ) : ?>

				<aside class="widget widget_text">
					<h3 class="widget-title"><?php _e( 'Please Add Widgets', 'shuttle' ); ?></h3>
					<div class="textwidget"><div class="error-icon">
						<p><?php _e( 'Remove this message by adding widgets to the Sidebar from the Widgets section of the Wordpress admin area.', 'shuttle' ); ?></p>
						<a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>" title="<?php esc_attr_e( 'No Widgets Selected', 'shuttle' ); ?>"><?php _e( 'Click here to go to Widget area.', 'shuttle' ); ?></a>
					</div></div>
				</aside>

			<?php endif; ?>

		</div>
		</div><!-- #sidebar -->
				