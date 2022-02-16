<?php 
if (! defined('ABSPATH') ) {  exit; // Exit if accessed directly
}

get_header();?>

<div class="anony-grid">
    <div class="anony-grid-row anony-grid-col">
  
       <?php get_sidebar();?>
       
        <div class="anony-grid-col-sm-9">

            <div class="anony-grid-col anony-blog-section">

                <div class="anony-posts-section">

                         <div class="anony-grid-col anony-post-contents">
                             <?php if ($thumb ) {?>
                           
                                <div class="anony-hover-toggle anony-download-meta anony-post-info anony-grid-col-lg-3">
                                    <div class="download-image-wrapper">
                                    <?php echo $thumb_img ?>
                                     </div>
                                </div>
                             <?php }?>
                            
                            <div class="anony-grid-col-lg-9">

                                <div class="single-download-title">

                                    <div class="title-date-wrapper">
                
                                        <div class="date">

                                            <div class="date-wrapper">

                                                <h1 class="day">
                                                    <?php echo $date[0] ?>
                                                </h1>

                                                <span>
                                                    <?php echo $date[1].' '.$date[2] ?>    
                                                </span>

                                            </div>
                                        </div>

                                        
                                        <div class="download-title">
                                        
                                            <h2>
                                                <a href="<?php echo $permalink ?>">
                                                    <?php echo $title ?>
                                                </a>
                                            </h2>
                                            
                                            <div class="anony-post_meta">
                                                <div class="category">
                                                
                                                    <i class="fa fa-folder-open"></i>
                                                    
                                                    <?php
                                                    
                                                    foreach ($terms as $term) {
                                                        extract($term);?>
                                                            <a href="<?php echo $url ?>"><?php echo $name ?></a>
                                                    <?php }
                                                    
                                                    ?>
                                                    

                                                </div>
                                                
                                                
                                                <div id="download-<?php echo $id ?>-count" class="download-counts single-download-counts">
                                                
                                                    <i class="fa fa-download"></i>

                                                    <span>
                                                        <?php echo $download_times ?>
                                                    </span>
                                                    
                                                </div>

                                                <?php echo $rating ?>

                                            </div>
                                            
                                            
                                            <div class="single-download">
                                            
                                                <a title="download-<?php echo $id ?>" class="anony-download" href="<?php echo $file_url ?>" rel-id="<?php echo $id ?>">

                                                    <i class="fa fa-download"></i>

                                                    <span><?php echo $download_text ?></span>
                                                </a>
                                                
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                              
                                  <?php echo $content ?>
                              </div>
                       </div>
                       
                </div>
                 
            </div>
                 
                 <?php echo $comments_template ?>                
        </div>
       
    </div>

</div>
<?php get_footer();?>
