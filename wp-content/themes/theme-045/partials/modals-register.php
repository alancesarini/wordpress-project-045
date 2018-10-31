<div id="modal-register" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="pop_img"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/img14.jpg" alt="foto"></div>
				<div class="popup_field">
					<div class="pop_top clearfix">
						<h2><?php _e( 'Registro', 'project045' ); ?></h2>
						<?php do_action( 'facebook_login_button' ); ?>
					</div>
					<form id="register" class="ajax-auth"  action="register" method="post">
							<p class="status"></p>
							<?php wp_nonce_field( 'ajax-register-nonce', 'signonsecurity' ); ?>         
							<input id="signonname" type="text" name="signonname" class="required" placeholder="<?php _e( 'Nombre de usuario', 'project045' ); ?>">
							<input id="email" type="text" class="required email" name="email" placeholder="<?php _e( 'Email', 'project045' ); ?>">
							<input id="signonpassword" type="password" class="required" name="signonpassword"  placeholder="<?php _e( 'Contraseña', 'project045' ); ?>">
							<input type="password" id="password2" class="required" name="password2" placeholder="<?php _e( 'Confirmar contraseña', 'project045' ); ?>">
							<input class="submit_button signup" type="submit" value="<?php _e( 'REGISTRARSE', 'project045' ); ?>">
					</form>								
				</div>
				<a class="popup-close" href="javascript:void(0);"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/pop_cross.png" alt="cerrar"></a>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="modal-login" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="pop_img"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/img14.jpg" alt="foto"></div>
				<div class="popup_field">
					<div class="pop_top clearfix">
						<h2><?php _e( 'Acceder', 'project045' ); ?></h2>
						<?php do_action( 'facebook_login_button' ); ?>
					</div>
					<div class="modal-login-form">
						<form id="login" action="login" method="post">
							<p class="status"></p>
							<input id="username" type="text" name="username" placeholder="<?php _e( 'Nombre de usuario', 'project045' ); ?>">
							<input id="password" type="password" name="password" placeholder="<?php _e( 'Contraseña', 'project045' ); ?>">
							<p><a class="link-lost-password" href="#"><?php _e( '¿Ha olvidado su contraseña?', 'project045' ); ?></a></p>
							<p class="pull-right"><input class="submit_button signup" type="submit" value="<?php _e( 'Acceder', 'project045' ); ?>" name="submit"></p>
							<?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
							<div class="pop_bt">
							<div class="pop_l">
							<p><span>*</span> <?php _e( 'campos obligatorios', 'project045' ); ?></p>
								<ul>
									<li>
										<input type="checkbox" id="chk-legal-login" name="chk-legal-login" />
										<label for="chk-legal-login"><?php _e( 'He leído y acepto el', 'project045' ); ?> <a href="/aviso-legal/"><?php _e( 'Aviso Legal y la Ley de Protección de Datos', 'project045' ); ?></a></label>
									</li>
								</ul>
							</div>
							<div class="pop_r"></div>
							</div>
						</form>
					</div>
					<div class="modal-lostpassword-form" style="display:none">
						<form id="forgot_password" class="ajax-auth" action="forgot_password" method="post">    
								<h2><?php _e( 'Nueva contraseña', 'project045' ); ?></h2>
								<p class="status"></p>  
								<?php wp_nonce_field('ajax-forgot-nonce', 'forgotsecurity'); ?>  
								<input id="user_login" type="text" class="required" name="user_login" placeholder="<?php _e( 'Nombre de usuario o email', 'project045' ); ?>">
								<input class="submit_button signup" type="submit" value="<?php _e( 'Enviar', 'project045' ); ?>">
						</form> 							
					</div>				
				</div>
				<a class="popup-close" href="javascript:void(0);"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/pop_cross.png" alt="cerrar"></a>
				</div>
			</div>
		</div>
	</div>
</div>