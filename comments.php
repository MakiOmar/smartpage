<?php
if ( post_password_required() )
	return;
?>

<div id="anony-comments" class="anony-comments-area anony-grid-col">
	<?php if ( have_comments() ) : ?>
		<h2 class="anony-comments-title">
			<?php printf( _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', ANONY_TEXTDOM ), number_format_i18n( get_comments_number() ) );?>
		</h2>
		<div class="anony-commentlist">
			<?php wp_list_comments( array( 'avatar_size'=>'64','format'=>'xhtml','style' => 'div' ) ); ?>
		</div><!-- .anony-commentlist -->


		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php esc_html_e( 'Comments off' , ANONY_TEXTDOM ); ?></p>
		<?php endif; ?>

	<?php endif; 
	comment_form(array( 
		'class_form' => 'anony-grid-col',
		'id_form'    => 'anony-commentform',
		'action'     =>'',
	));
	?>

</div><!-- #anony-comments .anony-comments-area -->