<?php
/**
 * @version 1.4.0
 * @author technote-space
 * @since 1.4.0
 * @copyright technote All Rights Reserved
 * @license http://www.opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2
 * @link https://technote.space/
 */

if ( ! defined( 'TECHNOTE_PLUGIN' ) ) {
	return;
}
/** @var \Technote\Interfaces\Presenter $instance */
?>

<script>
    (function ($) {
        $(function () {
            let index = 1;
            /** @var {{settings: {options: {is_valid_button: boolean, is_valid_style: boolean}}[]}} marker_animation_params */
            Object.keys(marker_animation_params.settings).forEach(function (key) {
                const setting = marker_animation_params.settings[key];
                const options = setting.options;
                if (options.is_valid_button) {
                    $('<style type="text/css">' +
                        '.mce-btn .highlight-icon.setting-' + setting.id + ' {background-color:' + options.color + '}' +
                        '</style>').appendTo('head');
                }
                if (options.is_valid_style) {
                    $('<style type="text/css">' +
                        '.mce-menu-item:nth-of-type(' + index + ') > .highlight-icon + span {background-color:' + options.color + '}' +
                        '</style>').appendTo('head');
                    index++;
                }
            });
        });
    })(jQuery);
</script>