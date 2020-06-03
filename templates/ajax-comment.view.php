<div <?= $comment_class ?> id="comment-<?= $comment->comment_ID ?>">			

	<div class="anony-comment-author vcard">
		<?= $avatar ?> <cite class="fn"><?= $author_link ?></cite> <span class="says"><?= $says ?></span>
	</div>

	<div class="anony-comment-metadata">
		<a href="<?= $comment_link ?>"><?= $when_text ?></a>

		<?php if( $edit_link ) : ?>
		
			<span class="edit-link"><a class="anony-comment-edit-link" href="<?= $edit_link ?>"><?= $edit_text ?></a></span>
			
		<?php endif ?>

	</div>

	<?php if ( $comment_approved == '0' ) : ?>
		
		<p class="anony-comment-awaiting-moderation"><?= $waiting_approve ?></p>
	
	<?php endif ?>

	<div class="anony-comment-content"><?= $comment_text ?></div>

	<?php if($maxNOcomments > $comment_depth) : ?>
		
		<div class="reply"><?= $reply_link ?></div>
		
	<?php else : ?>
		
		<p class="limit-reach"><?= $limit_reached_text ?><p>
			
	<?php endif ?>

</div>