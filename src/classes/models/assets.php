<?php
/**
 * @version 1.4.1
 * @author technote-space
 * @since 1.0.0
 * @since 1.2.0
 * @since 1.2.7 Added: cache options
 * @since 1.3.0 Added: preset color
 * @since 1.4.0 Deleted: preset color
 * @since 1.4.0 Added: marker setting feature
 * @since 1.4.1 Fixed: default value of setting form
 * @copyright technote All Rights Reserved
 * @license http://www.opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2
 * @link https://technote.space/
 */

namespace Marker_Animation\Classes\Models;

/**
 * Class Assets
 * @package Marker_Animation\Classes\Models
 */
class Assets implements \Technote\Interfaces\Singleton, \Technote\Interfaces\Hook, \Technote\Interfaces\Presenter {

	use \Technote\Traits\Singleton, \Technote\Traits\Hook, \Technote\Traits\Presenter;

	/**
	 * setup assets
	 */
	/** @noinspection PhpUnusedPrivateMethodInspection */
	private function setup_assets() {
		if ( ! $this->is_valid() ) {
			return;
		}

		$this->enqueue_marker_animation();
	}

	/**
	 * enqueue marker animation
	 * @since 1.4.0
	 */
	public function enqueue_marker_animation() {
		$this->enqueue_script( $this->app->slug_name . '-marker_animation', 'marker-animation.min.js', [
			'jquery',
		] );
		$this->localize_script( $this->app->slug_name . '-marker_animation', $this->get_marker_object_name(), $this->get_marker_options() );
	}

	/**
	 * @return bool
	 */
	private function is_valid() {
		return $this->apply_filters( 'is_valid' );
	}

	/**
	 * @return string
	 */
	public function get_default_marker_animation_class() {
		return 'marker-animation';
	}

	/**
	 * @return string
	 */
	private function get_selector() {
		$selector = trim( $this->apply_filters( 'selector' ) );
		if ( ! empty( $selector ) ) {
			$selector .= ', ';
		}
		$selector .= '.' . $this->get_default_marker_animation_class();

		return $selector;
	}

	/**
	 * @return string
	 */
	public function get_marker_object_name() {
		return 'marker_animation';
	}

	/**
	 * @since 1.2.7
	 * @return string
	 */
	private function get_marker_options_cache_key() {
		return 'marker_options_cache';
	}

	/**
	 * @since 1.3.0
	 * @return string
	 */
	public function get_data_prefix() {
		return 'ma_';
	}

	/**
	 * @since 1.2.7 Added: cache options
	 * @return array
	 */
	public function get_marker_options() {
		if ( $this->apply_filters( 'is_valid_marker_options_cache' ) ) {
			$options = $this->app->get_option( $this->get_marker_options_cache_key() );
			if ( is_array( $options ) && ! empty( $options['version'] ) && version_compare( $options['version'], $this->app->get_plugin_version(), '>=' ) ) {
				return $options;
			}
			$options = $this->load_marker_options();
			$this->app->option->set( $this->get_marker_options_cache_key(), $options );
		} else {
			$options = $this->load_marker_options();
		}

		return $options;
	}

	/**
	 * @since 1.2.7
	 * @return array
	 */
	private function load_marker_options() {
		/** @var Custom_Post\Setting $setting */
		$setting = Custom_Post\Setting::get_instance( $this->app );
		$options = [
			'version'  => $this->app->get_plugin_version(),
			'selector' => $this->get_selector(),
			'prefix'   => $this->get_data_prefix(),
			'settings' => $setting->get_settings( 'front' ),
		];
		foreach ( $this->get_setting_details( 'front' ) as $key => $setting ) {
			list( $name, $value ) = $this->parse_setting( $setting, $key );
			$options[ $name ] = $value;
		}

		return $options;
	}

	/**
	 * @since 1.4.0
	 *
	 * @param array $setting
	 * @param string $key
	 *
	 * @return array
	 */
	public function parse_setting( $setting, $key ) {
		$value = $setting['attributes']['data-value'];
		if ( ! empty( $setting['attributes']['data-option_name'] ) ) {
			$name = $setting['attributes']['data-option_name'];
		} else {
			$name = $key;
		}
		if ( 'input/checkbox' === $setting['form'] ) {
			if ( ! empty( $value ) ) {
				if ( array_key_exists( 'data-option_value-true', $setting['attributes'] ) ) {
					$value = $setting['attributes']['data-option_value-true'];
				} else {
					$value = true;
				}
			} else {
				if ( array_key_exists( 'data-option_value-false', $setting['attributes'] ) ) {
					$value = $setting['attributes']['data-option_value-false'];
				} else {
					$value = false;
				}
			}
		}

		return [ $name, $value ];
	}

	/**
	 * clear cache when changed option
	 * @since 1.2.7
	 *
	 * @param string $key
	 */
	/** @noinspection PhpUnusedPrivateMethodInspection */
	private function changed_option( $key ) {
		if ( $this->app->utility->starts_with( $key, $this->get_filter_prefix() ) ) {
			$this->clear_options_cache();
		}
	}

	/**
	 * clear options cache
	 * @since 1.3.0
	 * @since 1.4.0 Changed: visibility (private to public)
	 */
	public function clear_options_cache() {
		$this->app->option->delete( $this->get_marker_options_cache_key() );
	}

	/**
	 * @since 1.4.0
	 * @return array
	 */
	public function get_animation_functions() {
		return $this->apply_filters( 'animation_functions', [
			'ease'        => $this->translate( 'ease' ),
			'linear'      => $this->translate( 'linear' ),
			'ease-in'     => $this->translate( 'ease-in' ),
			'ease-out'    => $this->translate( 'ease-out' ),
			'ease-in-out' => $this->translate( 'ease-in-out' ),
		] );
	}

	/**
	 * @since 1.3.0 Added: preset color
	 * @since 1.4.1 Added: detail setting
	 * @return array
	 */
	public function get_setting_keys() {
		return [
			'is_valid'        => [
				'form' => 'input/checkbox',
				'args' => [
					'target' => [ 'dashboard', 'setting' ],
				],
			],
			'color'           => 'color',
			'thickness'       => 'input/text',
			'duration'        => 'input/text',
			'delay'           => 'input/text',
			'function'        => [
				'form' => 'select',
				'args' => [
					'options' => $this->get_animation_functions(),
				],
			],
			'bold'            => [
				'form' => 'input/checkbox',
				'args' => [
					'attributes' => [
						'data-option_name'        => 'font_weight',
						'data-option_value-true'  => 'bold',
						'data-option_value-false' => null,
					],
				],
			],
			'repeat'          => 'input/checkbox',
			'padding_bottom'  => 'input/text',
			'is_valid_button' => [
				'form'   => 'input/checkbox',
				'args'   => [
					'target' => [ 'setting' ],
				],
				'detail' => [
					'value' => 1,
					'label' => $this->translate( 'show' ),
				],
			],
			'is_valid_style'  => [
				'form'   => 'input/checkbox',
				'args'   => [
					'target' => [ 'setting' ],
				],
				'detail' => [
					'value' => 0,
					'label' => $this->translate( 'show' ),
				],
			],
		];
	}

	/**
	 * @since 1.3.0 Added: target filter
	 *
	 * @param string $target
	 *
	 * @return array
	 */
	public function get_setting_details( $target ) {
		$args = [];
		foreach ( $this->get_setting_keys() as $key => $form ) {
			if ( is_array( $form ) && ! empty( $form['args']['target'] ) && ! in_array( $target, $form['args']['target'] ) ) {
				continue;
			}
			$args[ $key ] = $this->get_setting( $key, $form );
		}

		return $args;
	}

	/**
	 * @since 1.4.1 Changed: use detail setting if exists
	 *
	 * @param string $name
	 * @param string|array $form
	 *
	 * @return array
	 */
	private function get_setting( $name, $form ) {
		$detail = $this->app->utility->array_get( is_array( $form ) ? $form : [], 'detail', $this->app->setting->get_setting( $name, true ) );
		$value  = $this->app->utility->array_get( $detail, 'value' );
		$ret    = [
			'id'         => $this->get_id_prefix() . $name,
			'class'      => 'marker-animation-option',
			'name'       => $this->get_name_prefix() . $name,
			'value'      => $value,
			'label'      => $this->translate( $this->app->utility->array_get( $detail, 'label', $name ) ),
			'attributes' => [
				'data-value'   => $value,
				'data-default' => $this->app->utility->array_get( $detail, 'default' ),
			],
			'detail'     => $detail,
		];
		if ( is_array( $form ) ) {
			$ret['form'] = $form['form'];
			$ret         = array_replace_recursive( $ret, isset( $form['args'] ) && is_array( $form['args'] ) ? $form['args'] : [] );
		} else {
			$ret['form'] = $form;
		}
		if ( $this->app->utility->array_get( $detail, 'type' ) === 'bool' ) {
			$ret['value'] = 1;
			! empty( $value ) and $ret['attributes']['checked'] = 'checked';
		}
		if ( $ret['form'] === 'select' ) {
			$ret['selected'] = $value;
			if ( ! empty( $ret['options'] ) && ! isset( $ret['options'][ $value ] ) ) {
				$ret['options'][ $value ] = $value;
			}
		}

		return $ret;
	}

	/**
	 * @return string
	 */
	public function get_id_prefix() {
		return $this->app->slug_name . '-';
	}

	/**
	 * @return string
	 */
	public function get_name_prefix() {
		return $this->get_filter_prefix();
	}
}