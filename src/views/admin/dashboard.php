<?php
/**
 * @version 1.3.1
 * @author technote-space
 * @since 1.0.0
 * @since 1.3.0 Added: preset color
 * @since 1.3.1 Updated: preview
 * @copyright technote All Rights Reserved
 * @license http://www.opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2
 * @link https://technote.space/
 */

if ( ! defined( 'TECHNOTE_PLUGIN' ) ) {
	return;
}
/** @var \Technote\Interfaces\Presenter $instance */
/** @var array $args */
/** @var array $setting */
?>

<?php $instance->form( 'open', $args ); ?>
<div id="<?php $instance->id(); ?>-dashboard" class="wrap narrow">
    <div id="<?php $instance->id(); ?>-content-wrap">
        <table class="form-table">
			<?php foreach ( $setting as $k => $v ) : ?>
                <tr>
                    <th>
                        <label for="<?php $instance->h( $v['id'] ); ?>"><?php $instance->h( $v['label'] ); ?></label>
                    </th>
                    <td>
						<?php $instance->form( $v['form'], $args, $v ); ?>
                    </td>
                </tr>
			<?php endforeach; ?>
        </table>
        <div>
	        <?php $instance->form( 'input/submit', $args, [
		        'name'  => 'update',
		        'value' => 'Update',
		        'class' => 'button-primary left',
	        ] ); ?>
	        <?php $instance->form( 'input/button', $args, [
		        'name'  => 'reset',
		        'value' => 'Reset',
		        'class' => 'button-primary left',
	        ] ); ?>
        </div>
        <div class="marker-setting-preview">
            Hello, Dolly<br>
            <span class="default-color">Well, hello, Dolly</span><br>
            It's so nice to have you back where you belong<br>
            You're lookin' swell, Dolly<br>
            I can tell, Dolly<br>
            <span class="preset-color preset-color1">You're still glowin', you're still crowin'</span><br>
            You're still goin' strong<br>
            I feel the room swayin'<br>
            While the band's playin'<br>
            One of our old favorite songs from way back when<br>
            <span class="default-color">So, take her wrap, fellas<br>
            Dolly, never go away again</span><br>
            Hello, Dolly<br>
            Well, hello, Dolly<br>
            It's so nice to have you back where you belong<br>
            <span class="preset-color preset-color2"> You're lookin' swell, Dolly<br>
            I can tell, Dolly<br>
            You're still glowin'</span>, you're still crowin'<br>
            You're still goin' strong<br>
            I feel the room swayin'<br>
            <span class="default-color">While the band's playin'<br>
            One of our old favorite songs from way back when</span><br>
            So, golly, gee, fellas<br>
            <span class="preset-color preset-color3">Have a little faith in me, fellas<br>
            Dolly, never go away</span><br>
            Promise, you'll never go away<br>
            Dolly'll never go away again
        </div>
    </div>
</div>
<?php $instance->form( 'close', $args ); ?>




