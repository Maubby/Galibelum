<?php
/**
 * Template Part for displaying the post item in Recent Post widget
 *
 * @author 8guild
 */

?>
<article class="post-item">

	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" class="post-thumb">
			<?php the_post_thumbnail( 'thumbnail' ); ?>
		</a>
	<?php endif; ?>

	<div class="post-info">
		<?php
		silicon_entry_meta();
		the_title(
			sprintf( '<h4 class="post-title"><a href="%s" class="navi-link-color navi-link-hover-color">', esc_url( get_permalink() ) ),
			'</a></h4>'
		);
		?>
	</div>

</article>
