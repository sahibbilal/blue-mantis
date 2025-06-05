<?php
/**
 * The share icons partial.
 *
 * @package Propel
 * @since   2.2.0
 */

?>

<div class="a2a_kit share-icons wp-block-buttons">
	<?php
	echo wp_kses_post(
		array_to_link(
			array(
				'title' => __( 'Share on Facebook', 'propel' ),
				'url'   => '#',
			),
			'is-style-social',
			array(
				'icon'         => 'icon-facebook',
				'link_classes' => 'a2a_button_facebook share-icons__link',
			)
		)
	);

	echo wp_kses_post(
		array_to_link(
			array(
				'title' => __( 'Share on Twitter', 'propel' ),
				'url'   => '#',
			),
			'is-style-social',
			array(
				'icon'         => 'icon-social-x',
				'link_classes' => 'a2a_button_twitter share-icons__link',
			)
		)
	);

	echo wp_kses_post(
		array_to_link(
			array(
				'title' => __( 'Share on LinkedIn', 'propel' ),
				'url'   => '#',
			),
			'is-style-social',
			array(
				'icon'         => 'icon-linkedin',
				'link_classes' => 'a2a_button_linkedin share-icons__link',
			)
		)
	);

	echo wp_kses_post(
		array_to_link(
			array(
				'title' => __( 'Share', 'propel' ),
				'url'   => '#',
			),
			'is-style-social',
			array(
				'icon'         => 'icon-link',
				'link_classes' => 'a2a_dd share-icons__link',
			)
		)
	);
	?>
</div>
