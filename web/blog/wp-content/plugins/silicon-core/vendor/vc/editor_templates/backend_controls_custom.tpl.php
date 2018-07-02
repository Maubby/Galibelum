<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$editAccess = vc_user_access_check_shortcode_edit( $shortcode );
$allAccess  = vc_user_access_check_shortcode_all( $shortcode );

?>
<div class="vc_controls<?php echo ! empty( $extended_css ) ? ' ' . $extended_css : '' ?>">
    <div class="vc_controls-<?php echo $position ?>">
        <a class="<?php echo esc_attr( $name_css_class ) ?>">
            <span class="vc_btn-content"
                  title="<?php echo $allAccess ? sprintf( __( 'Drag to move %s', 'silicon' ), $name ) : $name; ?>"
            >
                <i class="vc-composer-icon vc-c-icon-dragndrop"></i><?php echo $name ?>
            </span>
        </a>
		<?php foreach ( $controls as $control ) : ?>
			<?php if ( 'add' === $control && $add_allowed ) : ?>
                <a href="#" data-vc-control="add"
                   class="vc_control-btn vc_control-btn-prepend vc_edit"
                   title="<?php printf( __( 'Prepend to %s', 'silicon' ), $name ) ?>"
                >
                    <span class="vc_btn-content">
                        <i class="vc-composer-icon vc-c-icon-add"></i>
                    </span>
                </a>
			<?php elseif ( $editAccess && 'edit' === $control ) : ?>
                <a href="#" data-vc-control="edit"
                   class="vc_control-btn vc_control-btn-edit"
                   title="<?php printf( __( 'Edit %s', 'js_composer' ), $name ) ?>"
                >
                    <span class="vc_btn-content">
                        <i class="vc-composer-icon vc-c-icon-mode_edit"></i>
                    </span>
                </a>
			<?php elseif ( $allAccess && 'clone' === $control ) : ?>
                <a href="#" data-vc-control="clone"
                   class="vc_control-btn vc_control-btn-clone"
                   title="<?php printf( __( 'Clone %s', 'js_composer' ), $name ) ?>"
                >
                    <span class="vc_btn-content">
                        <i class="vc-composer-icon vc-c-icon-content_copy"></i>
                    </span>
                </a>
			<?php elseif ( $allAccess && 'delete' === $control ) : ?>
                <a href="#" data-vc-control="delete"
                   class="vc_control-btn vc_control-btn-delete"
                   title="<?php printf( __( 'Delete %s', 'js_composer' ), $name ) ?>"
                >
                    <span class="vc_btn-content">
                        <i class="vc-composer-icon vc-c-icon-delete_empty"></i>
                    </span>
                </a>
			<?php endif ?>
		<?php endforeach ?>
    </div>
</div>
