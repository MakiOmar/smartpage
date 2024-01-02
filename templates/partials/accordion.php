<?php
/**
 * Accordion partial
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<style>
	.anony-accordion-container {
		max-width: 450px;
		max-width: 600px;
	}

	.anony-accordion-item {
		background-color: #FFFFFF; /* White background for items */
		border: 1px solid #E0E0E0; /* Light border */
		border-radius: 8px;
		margin-bottom: 10px;
		box-shadow: 0 2px 5px rgba(0,0,0,0.1); /* Softer shadow */
	}

	.anony-accordion-header {
		color: #000; /* White text */
		padding: 15px;
		font-size: 18px;
		border: none;
		width: 100%;
		text-align: inherit;
		cursor: pointer;
		outline: none;
		display: flex;
		justify-content: space-between;
		align-items: center;
		border-radius: 8px 8px 0 0;
		transition: background-color 0.3s ease;
	}

	.anony-accordion-header:hover {
		background-color: #000; /* Darker shade of purple */
		color: #fff
	}

	.anony-accordion-content {
		background-color: #FAFAFA; /* Very light grey for content */
		overflow: hidden;
		padding: 0 15px;
		max-height: 0;
		transition: max-height 0.3s ease;
	}

	.anony-accordion-content p {
		margin: 15px 0;
		line-height: 1.5;
	}

	.anony-accordion-icon {
		transition: transform 0.3s ease;
	}

	.active .anony-accordion-icon {
		transform: rotate(45deg);
	}
</style>
<div id="anony-accordion-wrapper">
	<div class="anony-grid-row flex-h-center">
		<div class="anony-accordion-container anony-grid-col">
			<?php
			foreach ( $data as $item ) {
				?>
				<div class="anony-accordion-item">
					<button class="anony-accordion-header">
						<?php echo esc_html( $item['title'] ); ?> <span class="anony-accordion-icon">+</span>
					</button>
					<div class="anony-accordion-content">
						<?php echo esc_html( $item['content'] ); ?>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>

<script type="text/javascript">
	document.querySelectorAll('.anony-accordion-header').forEach(button => {
		button.addEventListener('click', () => {
			const accordionContent = button.nextElementSibling;

			button.classList.toggle('active');

			if (button.classList.contains('active')) {
				accordionContent.style.maxHeight = accordionContent.scrollHeight + 'px';
			} else {
				accordionContent.style.maxHeight = 0;
			}

			// Close other open accordion items
			document.querySelectorAll('.anony-accordion-header').forEach(otherButton => {
				if (otherButton !== button) {
					otherButton.classList.remove('active');
					otherButton.nextElementSibling.style.maxHeight = 0;
				}
			});
		});
	});
</script>