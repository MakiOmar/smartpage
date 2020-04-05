<?php
if ( post_password_required() )
	return;
$data = [
	'have_comments'   => have_comments(),
	'comments_number' => sprintf( 
							_nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', ANONY_TEXTDOM ), 
							number_format_i18n( get_comments_number() ) 
						),

	'comments' => wp_list_comments( 
		[ 
			'echo'=> false ,
			'avatar_size'=>'64',
			'format'=>'xhtml',
			'style' => 'div'
		] 
	),

	'comments_open' => comments_open(),
	'comments_off_text' => esc_html__( 'Comments off' , ANONY_TEXTDOM ),

];

extract($data);
?>

<div id="anony-comments" class="anony-comments-area anony-grid-col">
	<?php if ( $have_comments ) : ?>

		<h2 class="anony-comments-title">
			<?= $comments_number ;?>
		</h2>

		<div class="anony-commentlist">
			<?= $comments ?>
		</div><!-- .anony-commentlist -->


		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( $comments_open  ) : ?>
		<p class="nocomments"><?= $comments_off_text ?></p>
		<?php endif ?>

	<?php endif; 
	comment_form(array( 
		'class_form' => 'anony-grid-col',
		'id_form'    => 'anony-commentform',
		'action'     =>'',
	));
	?>

</div><!-- #anony-comments .anony-comments-area -->