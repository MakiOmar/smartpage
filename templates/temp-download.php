<?php 
	$curr_download_meta = get_post_meta( get_the_ID(), 'smpg_download_attachment', true );
	$download_times = get_post_meta(get_the_ID(),'download_times',true);
	if(empty($download_times)){
		$download_times = 0;
	}
?>
<div id="download-<?php the_ID() ?>" class="grid-col-max-480-6 grid-col-av-4 grid-10-col-md-2">
	<div class="grid-col post-contents">
	  <div class="download-meta">
		<div class="hover-toggle post-image-wrapper" style="background-color: transparent">
		<span id="download-<?php the_ID()?>-count" class="download-counter"><?php echo $download_times.'<br>'.__('Downloads','smartpage') ?></span>

		  <?php if( has_post_thumbnail() ){
					the_post_thumbnail(array('160','180'));
				}else{?>
					<img src="<?php echo get_theme_file_uri();?>/images/temporary-book-bg.png" alt="<?php the_title() ?>"/>
					<?php }?>
		  </div>
		</div>
		<h4 class="download-title"><?php the_title() ?></h4>
		<div class="download">
			<a title="download-<?php the_ID()?>" target="_blank" class="smpg-download" href="<?php echo $curr_download_meta ?>"><i class="fa fa-download"></a></i>
		</div>
	</div>
</div>