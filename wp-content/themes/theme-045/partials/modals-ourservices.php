<div id="modal-concierge" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="pop_img"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/bkg_popup_concierge.jpg" alt="foto"></div>                
				<div class="popup_field">
					<?php echo wpautop( $array_data['section4']['text_popup'] ); ?>
				</div>
				<a class="popup-close" href="javascript:void(0);"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/pop_cross.png" alt="cerrar"></a>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="modal-lawyer" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="pop_img"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/bkg_popup_lawyer.jpg" alt="foto"></div>                				
				<div class="popup_field">
                    <?php echo $array_data['section5']['text_popup']; ?>
				</div>
				<a class="popup-close" href="javascript:void(0);"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/pop_cross.png" alt="cerrar"></a>
				</div>
			</div>
		</div>
	</div>
</div>