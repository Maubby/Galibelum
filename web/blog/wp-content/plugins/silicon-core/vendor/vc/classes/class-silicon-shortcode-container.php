<?php

/**
 * Overrides the default VC Container class
 *
 * This is a base class for all container shortcodes
 *
 * @author 8guild
 */
class Silicon_Shortcode_Container extends WPBakeryShortCodesContainer {

	protected $controls_css_settings = 'out-tc vc_controls-content-widget';
	protected $controls_list = array( 'add', 'edit', 'clone', 'delete' );
	protected $predefined_atts = array(
		'animation' => '',
		'class'     => '',
	);

	public function __construct( $settings ) {
		parent::__construct( $settings );
	}

	/**
	 * Add a "wpb_vc_tta_tabs" class to wrapper for controls styling
	 *
	 * @param $width
	 * @param $i
	 *
	 * @return string
	 */
	public function mainHtmlBlockParams( $width, $i ) {
		$isSortable = vc_user_access_check_shortcode_all( $this->shortcode );

		// classes for main wrapper
		$classes = silicon_get_classes( array(
			'wpb_' . $this->settings['base'],
			$isSortable ? 'wpb_sortable' : $this->nonDraggableClass,
			empty( $this->settings['class'] ) ? '' : $this->settings['class'],
			'wpb_content_holder',
			'vc_shortcodes_container',
			'wpb_vc_tta_tabs', // magic!
		) );

		// attributes
		$attr = silicon_get_attr( array(
			'data-element_type' => $this->settings['base'],
			'class'             => esc_attr( $classes ),
		) );

		return $attr . ' ' . $this->customAdminBlockParams();
	}

	/**
	 * Remove the icon from shortcode
	 *
	 * @param string $title
	 *
	 * @return string
	 */
	protected function outputTitle( $title ) {
		return '';
	}

	public function containerContentClass() {
		return 'wpb_column_container vc_container_for_children vc_clearfix silicon-vc-reduce-spaces';
	}

	/**
	 * Build new modern controls for shortcode.
	 *
	 * @param string $extended_css
	 *
	 * @return string
	 */
	public function getColumnControlsModular( $extended_css = '' ) {
		$shortcode      = $this->shortcode;
		$position       = $this->controls_css_settings;
		$name           = $this->settings( 'name' );
		$controls       = $this->getControlsList();
		$name_css_class = $this->getBackendEditorControlsElementCssClass();
		$add_allowed    = $this->getAddAllowed();

		ob_start();
		require SILICON_PLUGIN_ROOT . '/vendor/vc/editor_templates/backend_controls_custom.tpl.php';

		return ob_get_clean();
	}

	/**
	 * New modern controls
	 *
	 * @param string $controls
	 * @param string $extended_css
	 *
	 * @return string
	 */
	public function getColumnControls( $controls = 'full', $extended_css = '' ) {
		if ( 'bottom-controls' === $extended_css ) {
			return ''; // skip bottom controls
		}

		return $this->getColumnControlsModular( $extended_css );
	}
}