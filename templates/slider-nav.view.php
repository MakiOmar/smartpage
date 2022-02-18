<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<ul>
	<li><a href="#"><i class="fa fa-arrow-left"></i></a></li>
	<li><a href="#"><i class="fa fa-arrow-right"></i></a></li>
</ul>

<?php if ( $category->name == 'C#' ) : ?>
	<div class="anony-grid-col-md-1 hidden">

		<div class="anony-grid-col hidden-child" <?php // if($category->count < 2) echo 'style="display: none"' ?>>

			<div  class="ver-nav">

				<div class="prev-next prev">

					<a href="#"><i class="fa fa-arrow-circle-o-right"></i></a>

				</div>

				<div class="prev-next next">

				  <a href="#"><i class="fa fa-arrow-circle-o-left"></i></a>

				</div>

			</div>

		</div>

	</div>
	 
<?php endif ?>
