<?php 
	
function custom_comment($comment, $args, $depth) {

    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>
    <div class="comment-avatar">
        <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
    </div>
    <div class="comment-content">
        <span class="comment-date"><?php echo get_comment_date( 'd - m - Y' ); ?></span>&nbsp;&nbsp;|&nbsp;&nbsp;
        <span class="comment-author"><?php printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() ); ?></span>
        <?php comment_text(); ?>
        <p><?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></p>
    </div>
	
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
    <?php
    }

?>

<ul class="comments">
	<?php
		wp_list_comments( array(
			'avatar_size' => 80,
			'reply_text' => __( 'Responder', 'flaats' ),
			'callback' => 'custom_comment'
		) );
	?>
</ul>
