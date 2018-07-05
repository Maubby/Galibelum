<?php
/**
 * Section | vc_tta_section
 *
 * Supports vc_tta_tabs & vc_tta_accordion
 *
 * @var array                            $atts    Shortcode attributes
 * @var mixed                            $content Shortcode content
 * @var WPBakeryShortCode_VC_Tta_Section $this
 *
 * @author 8guild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter the default shortcode attributes
 *
 * @param array  $atts      Pairs of default attributes
 * @param string $shortcode Shortcode tag
 */
$a = shortcode_atts( apply_filters( 'silicon_shortcode_default_atts', array(
	'title'            => '',
	'tab_id'           => '',
	'animation'        => 'fade', // for tabs
	'is_icon'          => 'disable',
	'icon_library'     => 'silicon',
	'icon_position'    => 'left',
	'icon_silicon'     => '',
	'icon_socicon'     => '',
	'icon_material'    => '',
	'icon_fontawesome' => '',
	'icon_custom'      => '',
	'class'            => '',
), 'vc_tta_section' ), $atts );

$this->resetVariables( $a, $content );
WPBakeryShortCode_VC_Tta_Section::$self_count ++;
WPBakeryShortCode_VC_Tta_Section::$section_info[] = $a;

$parent = WPBakeryShortCode_VC_Tta_Section::$tta_base_shortcode;

// render the tab and tour panel
if ( 'vc_tta_tabs' === $parent->shortcode || 'vc_tta_tour' === $parent->shortcode ) {
	$is_active    = ( WPBakeryShortCode_VC_Tta_Section::$self_count <= 1 );
	$is_animation = ( 'fade' !== $a['animation'] );

	$class = silicon_get_classes( array(
		'tab-pane',
		'transition',
		'fade',
		$is_animation ? esc_attr( $a['animation'] ) : '',
		$is_active ? 'in active' : '',
		$a['class'],
	) );

	$tab = array(
		'id'    => esc_attr( $this->getTemplateVariable( 'tab_id' ) ),
		'class' => esc_attr( $class ),
	);

	echo silicon_get_tag( 'div', $tab, $this->getTemplateVariable( 'content' ) );
	unset( $is_active, $is_animation, $class, $tab );
}

// render the accordion panel
if ( 'vc_tta_accordion' === $parent->shortcode ) {
	$active    = (int) $parent->atts['active_section'];
	$is_active = WPBakeryShortCode_VC_Tta_Section::$self_count === $active;

	// accordion ID
	$parent_id = esc_attr( $parent->atts['unique'] );

	// panel ID, also used as a target
	$panel_id = esc_attr( silicon_get_unique_id( 'panel-' ) );

	$heading = esc_html( $a['title'] );
	if ( 'enable' === $a['is_icon'] ) {
		$i   = silicon_parse_array( $a, 'icon_' );
		$lib = esc_attr( $i['library'] );

		// enqueue the stylesheet
		silicon_vc_enqueue_icon_font( $lib );

		$icon = silicon_get_tag( 'i', array( 'class' => esc_attr( $i[ $lib ] ) ), '' );

		if ( 'left' === $i['position'] ) {
			$heading = "{$icon} &nbsp;{$heading}"; // note, there is a whitespace after the icon
		} else {
			$heading = "{$heading}&nbsp; {$icon}";
		}

		unset( $i, $lib, $icon );
	}

	$template = <<<'TEMPLATE'
<div class="{class}">
	<h4 class="panel-title">
		<a href="#{panel-id}" class="{is-collapsed} border-default-bottom" data-toggle="collapse" data-parent="#{parent-id}">
			<span class="si si-plus text-gray"></span>
			{heading}
		</a>
	</h4>
	<div id="{panel-id}" class="panel-collapse border-default-bottom collapse {is-active}">
		<div class="panel-collapse-inner">
			{content}
		</div>
	</div>
</div>
TEMPLATE;

	$r = array(
		'{class}'        => esc_attr( silicon_get_classes( array( 'panel', '', $a['class'] ) ) ),
		'{panel-id}'     => $panel_id,
		'{is-collapsed}' => $is_active ? 'open' : 'collapsed',
		'{parent-id}'    => $parent_id,
		'{heading}'      => $heading,
		'{is-active}'    => $is_active ? 'in' : 'out',
		'{content}'      => $this->getTemplateVariable( 'content' ),
	);

	echo str_replace( array_keys( $r ), array_values( $r ), $template );
}
