<?php get_header(); ?>

<?php 
while( have_posts() ) {
    the_post();
}
?>

<section class="pagebanner" style="background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/images/banner-news.jpg)">
	<div class="container">
    	<h1><?php _e( 'Noticias', 'flaats' ); ?></h1>
    </div>
</section>

<section class="post-detail">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="post-header">
                    <div class="post-header-left">
                        <h1><?php the_title(); ?></h1>
                        <span><?php the_time( 'j M Y' ); ?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon-comments.png" alt="icon"> <?php echo get_comments_number( get_the_ID() ); ?></span>
                    </div>
                    <div class="post-header-right">
                        <?php previous_post_link( '%link', "" ); ?>
                        <?php next_post_link( '%link', "" ); ?>
                    </div>
                </div>
                <div class="post-thumbnail">
                    <?php the_post_thumbnail(); ?>
                </div>
                <div class="post-content">
                    <?php echo Flaats_Functions::multi_col_text( get_the_content() ); ?>
                </div>
                <div class="post-comments">
                    <h2><?php echo get_comments_number( get_the_ID() ); ?> <strong><?php _e( 'comentarios', 'flaats' ); ?></strong></h2>
                    <?php comments_template(); ?>
                </div>
                <div class="post-new-comment">
                    <a name="respond"></a>
                <?php 
                    $fields =  array(

                        'author' =>
                        '<p class="form-row form-row-name">' .
                        '<input id="author" name="author" type="text" placeholder="' . __( 'Nombre', 'flaats' ) . '" value="' . esc_attr( $commenter['comment_author'] ) .
                        '" size="30" /></p>',
                    
                        'email' =>
                        '<p class="form-row form-row-email">' .
                        '<input id="email-comment" name="email" type="text" placeholder="' . __( 'Email', 'flaats' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) .
                        '" size="30" /></p>',
                    
                        'url' =>
                        '<p class="form-row form-row-web">' .
                        '<input id="url" name="url" type="text" placeholder="' . __( 'Web', 'flaats' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) .
                        '" size="30" /></p>',
                    );                
                        comment_form( array(
                            'logged_in_as' => '',
                            'comment_field' => '
                                <p class="form-row form-row-comment">
                                  <textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
                                </p>',
                            'class_submit' => 'btn-blue',
                            'title_reply' => '',
                            'label_submit' => __( 'Enviar', 'flaats' ),
                            'comment_notes_before' => '',
                            'comment_notes_after' => '',
                            'title_reply_before' => '<h3>' . __( 'Responder', 'flaats' ) . '</h3>',
                            'cancel_reply_link' => __( 'Cancelar respuesta', 'flaats' ),
                            'title_reply_to' => __( 'Responder a %s', 'flaats' ),
                            'fields' => apply_filters( 'comment_form_default_fields', $fields )
                        ) );
                        ?>    

                        <div class="form-row-legal">
                             <input type="checkbox" id="chk-legal-comment" name="chk-legal-comment" />
                          	 <label for="chk-legal-comment"><?php _e( 'He leído y acepto el', 'flaats' ); ?><a href="/aviso-legal/"> <?php _e( 'Aviso Legal y la Ley de Protección de Datos', 'flaats' ); ?></a></label>
                        </div>                        
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>