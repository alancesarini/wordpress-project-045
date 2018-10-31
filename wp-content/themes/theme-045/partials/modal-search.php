<div class="coming_pop">
	<div class="pop_crs"><a href="#" class="close-popup-search" data-toggle="modal"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/pop_cross_white.png" alt="cerrar"></a></div>
	<div class="pop_contain">
    	<div class="pop">
        	<h2><?php _e( 'Buscar noticias', 'flaats' ); ?></h2>
            <div class="clearfix">
            	<form role="search" metod="GET" action="<?php echo home_url(); ?>/">
                    <input type="text" name="s" id="text_search" />
                    <input type="hidden" name="post_type" value="post" />
                    <input class="bb" type="submit" value="<?php _e( 'BUSCAR', 'flaats' ); ?>" />
				</form>
            </div>
        </div>
    </div>
</div>