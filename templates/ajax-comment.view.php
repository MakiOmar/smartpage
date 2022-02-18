<div <?php echo $comment_class; ?> id="comment-<?php echo $comment->comment_ID; ?>">            

	<div class="anony-comment-author vcard">
		<?php echo $avatar; ?> <cite class="fn"><?php echo $author_link; ?></cite> <span class="says"><?php echo $says; ?></span>
	</div>

	<div class="anony-comment-metadata">
		<a href="<?php echo $comment_link; ?>"><?php echo $when_text; ?></a>

		<?php if ( $edit_link ) : ?>
		
			<span class="edit-link"><a class="anony-comment-edit-link" href="<?php echo $edit_link; ?>"><?php echo $edit_text; ?></a></span>
			
		<?php endif ?>

	</div>

	<?php if ( $comment_approved == '0' ) : ?>
		
		<p class="anony-comment-awaiting-moderation"><?php echo $waiting_approve; ?></p>
	
	<?php endif ?>

	<div class="anony-comment-content"><?php echo $comment_text; ?></div>

	<?php if ( $maxNOcomments > $comment_depth ) : ?>
		
		<div class="reply"><?php echo $reply_link; ?></div>
		
	<?php else : ?>
		
		<p class="limit-reach"><?php echo $limit_reached_text; ?><p>
			
	<?php endif ?>

</div>
