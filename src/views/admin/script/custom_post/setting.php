<?php
/**
 * @version 1.5.0
 * @author Technote
 * @since 1.4.0
 * @since 1.5.0 Changed: trivial change
 * @copyright Technote All Rights Reserved
 * @license http://www.opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2
 * @link https://technote.space/
 */

if ( ! defined( 'MARKER_ANIMATION' ) ) {
	return;
}
/** @var \WP_Framework_Presenter\Interfaces\Presenter $instance */
/** @var array $args */
$instance->add_script_view( 'admin/script/dashboard', $args );
