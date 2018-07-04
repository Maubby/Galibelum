<?php
/**
 * BuddyPress - Users Forums
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<div class="item-list-tabs no-ajax si-bp-sub-nav" id="subnav" aria-label="<?php esc_attr_e( 'Member secondary navigation', 'silicon' ); ?>" role="navigation">
	<ul>
		<?php bp_get_options_nav(); ?>

		<li id="forums-order-select" class="last filter">

			<label for="forums-order-by"><?php esc_html_e( 'Order By:', 'silicon' ); ?></label>
			<select id="forums-order-by">
				<option value="active"><?php esc_html_e( 'Last Active', 'silicon' ); ?></option>
				<option value="popular"><?php esc_html_e( 'Most Posts', 'silicon' ); ?></option>
				<option value="unreplied"><?php esc_html_e( 'Unreplied', 'silicon' ); ?></option>

				<?php

				/**
				 * Fires inside the members forums order options select input.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_forums_directory_order_options' ); ?>

			</select>
		</li>
	</ul>
</div><!-- .item-list-tabs -->

<?php

if ( bp_is_current_action( 'favorites' ) ) :
	bp_get_template_part( 'members/single/forums/topics' );

else :

	/**
	 * Fires before the display of member forums content.
	 *
	 * @since 1.5.0
	 */
	do_action( 'bp_before_member_forums_content' ); ?>

	<div class="forums myforums">

		<?php bp_get_template_part( 'forums/forums-loop' ) ?>

	</div>

	<?php

	/**
	 * Fires after the display of member forums content.
	 *
	 * @since 1.5.0
	 */
	do_action( 'bp_after_member_forums_content' ); ?>

<?php endif; ?>
