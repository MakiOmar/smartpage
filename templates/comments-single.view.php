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
	));?>

</div><!-- #anony-comments .anony-comments-area -->