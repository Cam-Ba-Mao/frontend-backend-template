<?php
namespace BM\Core\Common;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Options {

	/**
	 * Get option by key
	 * @param $key
	 * @return mixed|void
	 */
	public static function getOption( $key = '') {
	    if (!empty($key)) {
            return get_field( $key, 'option' );
        }
	    return get_fields('option');
	    //return get_fields(pll_current_language('slug'));
	}

}