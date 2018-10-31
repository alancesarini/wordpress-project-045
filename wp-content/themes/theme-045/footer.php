
<section class="footer">
	<div class="container">
    	<div class="row border_btm">
        	<div class="first_one">
            	<h2><span class="notranslate">dream<em>homes</em></span></h2>
                <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Texto en pie de página' ) ) : ?>
                <?php endif; ?>
            </div>
            <div class="second_one">
                <?php wp_nav_menu( array( 'theme_location' => 'footermenu' ) ); ?>           
            </div>
            <div class="third_one">
                <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Menú de áreas en pie de página' ) ) : ?>
                <?php endif; ?>
            </div>
            <div class="last_one">
                <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Dirección en pie de página' ) ) : ?>
                <?php endif; ?>
            </div>
            
            
        </div>
        
        <div class="row border_btm">
        	<div class="col-md-8">
                <?php wp_nav_menu( array( 'theme_location' => 'footermenulegal', 'menu_class' => 'bttm_menu' ) ); ?>           
            </div>
            <div class="col-md-4 text-right">
            	<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon14.png" alt="icon">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon15.png" alt="icon">
            </div>
        </div>
        
        <div class="row bt_pd">
        	<div class="col-md-6">
                <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Iconos sociales en pie de página' ) ) : ?>    
                <?php endif; ?>                          
            </div>
            <div class="col-md-3 text-right"><a href="<?php if( 'es' == pll_current_language() ) echo home_url( 'subvencionado-con-fondos-europeos' ); else echo home_url(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon16.png" alt="unión europea"></a></div>
            <div class="col-md-3 text-right2">
            	<a href="#">powered by <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/rtheme.png" alt="rentalthemes"></a>
            </div>
        </div>
    </div>
</section>


<?php wp_footer(); ?>

<script>
    var ajax_url = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
    var home_url_es = '<?php if( 'es' == pll_current_language() ) echo home_url(); else echo home_url() . '/es'; ?>';
    var home_url_en = '<?php if( 'en' == pll_current_language() ) echo home_url(); else echo str_replace( '/es', '', home_url() ); ?>';
    var developments_url = '<?php echo pll_home_url(); ?><?php if( 'en' == pll_current_language() ) echo 'developments'; else echo 'promociones'; ?>';
    var search_url = '<?php echo pll_home_url(); ?><?php if( 'en' == pll_current_language() ) echo 'find-on-map'; else echo 'buscar-en-el-mapa'; ?>';
</script>

<div class="popup" id="overlay"> </div>

<?php get_template_part( 'partials/modals', 'register' ); ?>

<?php get_template_part( 'partials/modal', 'search' ); ?>

</body>
</html>
