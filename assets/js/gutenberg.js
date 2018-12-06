/**
 * @version 1.1.4
 * @author technote-space
 * @since 1.1.4
 * @copyright technote All Rights Reserved
 * @license http://www.opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2
 * @link https://technote.space/
 */
(function (richText, element, editor) {
    const name = 'marker-animation/marker-animation';
    richText.registerFormatType(name, {
        title: marker_animation_params.title,
        tagName: 'span',
        className: marker_animation_params.class,
        edit: function ({isActive, value, onChange}) {
            return element.createElement(editor.RichTextToolbarButton, {
                icon: 'admin-customizer',
                title: marker_animation_params.title,
                onClick: function () {
                    onChange(richText.toggleFormat(value, {
                        type: name
                    }));
                },
                isActive: isActive,
            });
        },
    });
}(
    window.wp.richText,
    window.wp.element,
    window.wp.editor
));