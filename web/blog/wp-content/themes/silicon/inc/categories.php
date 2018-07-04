<?php
/**
 * Custom fields on Category screen
 *
 * @author 8guild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'EQUIP_VERSION' ) ) {
	return;
}

/**
 * Add custom fields to Category screen
 *
 * @see equip_create_layout()
 * @see equip_add()
 */
function silicon_add_category_fields() {
	try {
		$layout = equip_create_layout( 'category' );

		$layout->set_setting( 'label', esc_html__( 'Additions', 'silicon' ) );
		$layout->set_flag( 'container', false ); // disable the container

		// add fields
		$layout
			->add_field( 'background-color', 'color', array(
				'label'   => esc_html__( 'Background Color', 'silicon' ),
				'default' => '#3d59f9',
			) )
			->add_field( 'color', 'color', array(
				'label'   => esc_html__( 'Text Color', 'silicon' ),
				'default' => '#ffffff',
			) );

		equip_add( 'category', 'silicon_additions', $layout, array(
			'description' => esc_html__( 'Extra fields in Categories, required by Silicon theme.', 'silicon' ),
		) );
	} catch ( Exception $e ) {
		trigger_error( $e->getMessage() );
	}
}

add_action( 'equip/register', 'silicon_add_category_fields' );

/**
 * Add custom columns to Category taxonomy list
 *
 * @param array $columns
 *
 * @return array
 */
function silicon_category_columns( $columns ) {
	$columns['silicon_bg_color'] = esc_html__( 'Background Color', 'silicon' );
	$columns['silicon_color']    = esc_html__( 'Text Color', 'silicon' );

	return $columns;
}

add_filter( 'manage_edit-category_columns', 'silicon_category_columns' );

/**
 * Echo the content of custom columns in Categories
 *
 * @param string $content     Column content
 * @param string $column_name Column name
 * @param int    $term_id     Term ID
 *
 * @return string
 */
function silicon_category_columns_content( $content, $column_name, $term_id ) {
	$preview = '<span style="display: block; width: 30px; height: 30px; background-color: %s; border: 1px solid #eee;"></span>';
	$output  = '';
	switch ( $column_name ) {
		case 'silicon_bg_color':
			$meta = get_term_meta( $term_id, 'silicon_additions', true );
			if ( ! empty( $meta['background-color'] ) ) {
				$output = sprintf( $preview, sanitize_hex_color( $meta['background-color'] ) );
			}
			break;

		case 'silicon_color':
			$meta = get_term_meta( $term_id, 'silicon_additions', true );
			if ( ! empty( $meta['color'] ) ) {
				$output = sprintf( $preview, sanitize_hex_color( $meta['color'] ) );
			}
			break;
	}

	return empty( $content ) ? $output : "{$content} {$output}";
}

add_filter( 'manage_category_custom_column', 'silicon_category_columns_content', 10, 3 );
