<?php
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area grid-col">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php printf( _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', TEXTDOM ), number_format_i18n( get_comments_number() ) );?>
		</h2>
		<div class="commentlist">
			<?php wp_list_comments( array( 'avatar_size'=>'64','format'=>'xhtml','style' => 'div' ) ); ?>
		</div><!-- .commentlist -->


		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Comments-off' , TEXTDOM ); ?></p>
		<?php endif; ?>

	<?php endif; 
	comment_form(array( 'class_form' => 'grid-col' ));
	?>

</div><!-- #comments .comments-area -->