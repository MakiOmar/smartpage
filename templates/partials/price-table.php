<?php
/**
 * Price table partial
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
	:root{
		--pinkish-red: #C35A74;
		--medium-blue: #307BAA;
		--greenish-blue: #53BAB5;
		--bright-orange: #FF7445;
		--white-smoke: #F5F5F4;
		--white: #FFF;
		--dark-gray: #7D7C7C;
		--black: #000;
	}

	#anony-price-table-wrapper{
		display: flex;
		justify-content: center;
		align-items: center;
		min-height: 100vh;
	}

	#anony-price-table-wrapper .content{
		display: flex;
		justify-content: space-between;
		width: 1200px;
		margin: 100px;
	}

	#anony-price-table-wrapper .box{
		display: flex;
		flex-direction: column;
		width: 300px;
		border-radius: 20px;
		margin: 10px;
		background: var(--white);
		box-shadow: 0 1rem 2rem rgba(0, 0, 0, 20%);
	}

	#anony-price-table-wrapper .title{
		width: 100%;
		padding: 10px 0;
		font-size: 1.2em;
		font-weight: lighter;
		text-align: center;
		border-top-left-radius: 20px;
		border-top-right-radius: 20px;

		color: var(--white-smoke);
	}

	#anony-price-table-wrapper .basic .title{
		background: var(--pinkish-red);
	}

	#anony-price-table-wrapper .standard .title{
		background: var(--medium-blue);
	}

	#anony-price-table-wrapper .business .title{
		background: var(--greenish-blue);
	}

	#anony-price-table-wrapper .view{
		display: block;
		width: 100%;
		padding: 30px 0 20px;

		background: var(--white-smoke);
	}

	#anony-price-table-wrapper .icon{
		display: flex;
		justify-content: center;
	}

	#anony-price-table-wrapper .icon img{
		width: 100px;
	}

	#anony-price-table-wrapper .cost{
		display: flex;
		justify-content:center;
		flex-direction: row;
		margin-top: 10px;
	}

	#anony-price-table-wrapper .amount{
		font-size: 2.8em;
		font-weight: bolder;
	}

	#anony-price-table-wrapper .detail{
		margin: auto 0 auto 5px;
		font-size: 0.7em;
		font-weight: bold;
		line-height: 15px;
		color: #7D7C7C;
	}

	#anony-price-table-wrapper .description{
		margin: 30px auto;
		font-size: 0.8em;
		color: #7D7C7C;
	}

	#anony-price-table-wrapper ul{
		list-style: none;
	}

	#anony-price-table-wrapper li{
		margin-top: 10px;
	}

	#anony-price-table-wrapper li::before{
		content: "\2713";
		opacity: 0.5;
		display: inline-flex;
		width: 10px;
		height: 10px;
		margin: 0 10px;
		padding: 3px;
		border: 1px solid #000;
		border-radius:50%;
		vertical-align: middle;
		justify-content: center;
		align-items: center;
	}

	#anony-price-table-wrapper .price-table-button{
		margin: 0 auto 30px;
	}

	#anony-price-table-wrapper .price-table-button button{
		height: 40px;
		width: 250px;
		font-size: 0.7em;
		font-weight: bold;
		letter-spacing: 0.5px;
		color: #7D7C7C;
		border: 2px solid var(--dark-gray);
		border-radius: 50px;

		background: transparent;
	}

	#anony-price-table-wrapper .price-table-button button:hover{
		color: var(--white-smoke);
		transition: 0.5s;
		border: none;
		background: #039e8c;
	}

	/* Responsiveness:Start */
	@media screen and (max-width:970px) {
		#anony-price-table-wrapper .content{
			display: flex;
			align-items: center;
			flex-direction: column;
			margin: 50px auto;
		}
		#anony-price-table-wrapper .standard, .business{
			margin-top: 25px;
		}
	}
/* Responsiveness:End */
</style>
<div id="anony-price-table-wrapper">
	<div class="content">
		<?php
		foreach ( $data as $price_table ) {
			?>
			<form action="<?php echo esc_url( $price_table['button_link'] ); ?>" method="post">
			<div class="basic box">
				
					<h2 class="title" style="background-color:<?php echo esc_html( $price_table['title_bg_color'] ); ?>"><?php echo esc_html( $price_table['title'] ); ?></h2>
					<div class="view">
						<div class="icon">
						<?php echo wp_kses_post( $price_table['icon'] ); ?>
						</div>
						<div class="cost">
							<p class="amount"><?php echo esc_html( $price_table['price'] ); ?></p>
							<p class="detail"><?php echo esc_html( $price_table['price_per'] ); ?></p>
						</div>
						<div class="cost">
							<p><?php echo esc_html( $price_table['subtitle'] ); ?></p>
						</div>
					</div>
					<div class="description">
						<?php echo wp_kses_post( $price_table['content'] ); ?>
					</div>
					<div class="price-table-button">
						<button type="submit" ><?php echo esc_html( $price_table['button_text'] ); ?></button>
					</div>
				
			</div>
			</form>
			<?php
		}
		?>
	</div>
</div>