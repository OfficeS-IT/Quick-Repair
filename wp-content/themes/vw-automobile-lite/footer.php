<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package VW Automobile Lite
 */
?>
<div  id="footer" class="copyright-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <?php dynamic_sidebar('footer-1');?>
            </div>
            <div class="col-md-3 col-sm-3">
                <?php dynamic_sidebar('footer-2');?>
            </div>
            <div class="col-md-3 col-sm-3">
                <?php dynamic_sidebar('footer-3');?>
            </div>
            <div class="col-md-3 col-sm-3">
                <?php dynamic_sidebar('footer-4');?>
            </div>
        </div>
    </div>
</div>

<div id="footer-2">
  <p><?php echo esc_html(get_theme_mod('vw_automobile_lite_footer_copy',__('Automobile WordPress Theme By','vw-automobile-lite'))); ?> <?php vw_automobile_lite_credit(); ?></p>
</div>

<?php wp_footer(); ?>
</body>
</html>