<?php
/*
	Plugin Name: Таймер обратного отсчета
	Plugin URI: http://osc-cms.com/store/plugins/products-specials-countdown
	Description: Плагин отсчитывает оставшееся время до конца скидки товара
	Version: 1.4
	Author: CartET
	Author URI: http://osc-cms.com
	Plugin Group: Products
*/

add_action('head', 'products_specials_countdown_head');
add_filter('build_products', 'products_specials_countdown_build_products');
add_action('products_info', 'products_specials_countdown_products_info');

function products_specials_countdown_build_products($products)
{
	if (isset($products['PRODUCTS_EXPIRES']) && !empty($products['PRODUCTS_EXPIRES']) && $products['PRODUCTS_EXPIRES'] > date("Y-m-d H:i:s"))
		$products['PRODUCTS_EXPIRES'] = '<div class="products_countdown" data-countdown="'.str_replace('-', '/', $products['PRODUCTS_EXPIRES']).'"></div>';
	else
		$products['PRODUCTS_EXPIRES'] = '';

	return $products;
}

function products_specials_countdown_products_info()
{
	global $product;

	$getSpecialsQuery = os_db_query("SELECT expires_date FROM ".TABLE_SPECIALS." WHERE status = 1 AND products_id = '".(int)$product->data['products_id']."'");
	if (os_db_num_rows($getSpecialsQuery) > 0)
	{
		$getSpecials = os_db_fetch_array($getSpecialsQuery);
		return array('name' => 'PRODUCTS_EXPIRES', 'value' => '<div class="products_countdown" data-countdown="'.str_replace('-', '/', $getSpecials['expires_date']).'"></div>');
	}
	else
		return false;
}

function products_specials_countdown_head()
{
	_e('<link rel="stylesheet" href="'._HTTP.'modules/plugins/products_specials_countdown/css/products_specials_countdown.css" type="text/css" />');
	_e('<script src="'._HTTP.'modules/plugins/products_specials_countdown/js/jquery.countdown.min.js"></script>');
	_e('<script src="'._HTTP.'modules/plugins/products_specials_countdown/js/countdown.js"></script>');
}