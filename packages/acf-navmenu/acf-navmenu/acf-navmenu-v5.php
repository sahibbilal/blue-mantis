<?php

class acf_field_navmenu extends acf_field {
	
	
	/*
	*  This function will setup the field type data
	*/
	
	function __construct()
	{
		$this->name = 'navmenu';
		$this->label = __('Nav Menu', 'acf');
		$this->category = 'relational';
		$this->defaults = array(
			'output' => 'html',
			'menu_class' => '',
			'menu_id' => '',
			'container' => '',
			'container_class' => '',
			'container_id' => '',
			'before' => '',
			'after' => '',
			'link_before' => '',
			'link_after' => ''
		);


		// do not delete!
    	parent::__construct();
	}
	
	
	/*
	*  Create extra settings for your field. These are visible when editing a field
	*/
	
	function render_field_settings( $field )
	{
		acf_render_field_setting( $field, array(
			'label'			=> __( 'Output', 'acf' ),
			'instructions'	=> '',
			'type'			=> 'radio',
			'name'			=> 'output',
			'layout'		=> 'horizontal',
			'choices'		=> array(
				'html'           => __( 'HTML', 'acf' ),
				'menuid' => __( 'Menu ID', 'acf' )
			)
		));

		acf_render_field_setting( $field, array(
			'label' => __( 'Menu class', 'acf' ),
			'instructions' => __( 'If left empty the default class .menu will be used' ),
			'type' => 'text',
			'name' => 'menu_class'
		));

		acf_render_field_setting( $field, array(
			'label' => __( 'Menu ID', 'acf' ),
			'instructions' => '',
			'type' => 'text',
			'name' => 'menu_id'
		));

		acf_render_field_setting( $field, array(
			'label' => __( 'Container', 'acf' ),
			'instructions' => __( 'If left empty no container will be used' ) . '<br>' . __( 'Allowed tags are div and nav' ),
			'type' => 'text',
			'name' => 'container'
		));

		acf_render_field_setting( $field, array(
			'label' => __( 'Container class', 'acf' ),
			'instructions' => __( 'If left empty, .menu-{menu_slug}-container will be used' ),
			'type' => 'text',
			'name' => 'container_class'
		));

		acf_render_field_setting( $field, array(
			'label' => __( 'Container ID', 'acf' ),
			'instructions' => '',
			'type' => 'text',
			'name' => 'container_id'
		));

		acf_render_field_setting( $field, array(
			'label' => __( 'Before', 'acf' ),
			'instructions' => __( 'Text before &lt;a&gt;' ),
			'type' => 'text',
			'name' => 'before'
		));

		acf_render_field_setting( $field, array(
			'label' => __( 'After', 'acf' ),
			'instructions' => __( 'Text after &lt;a&gt;' ),
			'type' => 'text',
			'name' => 'after'
		));

		acf_render_field_setting( $field, array(
			'label' => __( 'Before link', 'acf' ),
			'instructions' => __( 'Text before link inside &lt;a&gt;' ),
			'type' => 'text',
			'name' => 'link_before'
		));

		acf_render_field_setting( $field, array(
			'label' => __( 'After link', 'acf' ),
			'instructions' => __( 'Text after link inside &lt;a&gt;' ),
			'type' => 'text',
			'name' => 'link_after'
		));
	}
	
	
	
	/*
	*  Create the HTML interface for your field
	*/
	
	function render_field( $field )
	{
		$menus = get_terms( 'nav_menu', array('hide_empty' => true) );
		$menu_locations = get_nav_menu_locations();

		foreach( $menus as $key => $menu ) {
			if ( in_array( $menu->term_id, $menu_locations) ) {
				unset( $menus[$key] );
			}
		}

		$atts = array(
			'name' => $field['name'],
			'id' => $field['id']
		);
		
		?>

		<select <?php echo acf_esc_attr( $atts ); ?>>
			
			<?php foreach( $menus as $menu ): ?>
				<?php

				if ($field['value'] == $menu->term_id)
					$selected = 'selected = "selected"';
				else
					$selected = '';

				?>
				<option value="<?php echo $menu->term_id; ?>" <?php echo $selected; ?>><?php echo $menu->name; ?></option>
			<?php endforeach; ?>

		</select>

		<?php
	}



	/*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*/
	
	function format_value( $value, $post_id, $field )
	{
		if( empty($value) ) {
			return $value;
		}

		if ($field['output'] == 'menuid')
			return $value;
		else {
			$params = array(
				'menu' => $value,
				'container' => '',
				'echo' => 0
			);


			$additional_params = array( 'menu_class', 'menu_id', 'container', 'container_class', 'container_id', 'before', 'after', 'link_before', 'link_after' );

			foreach( $additional_params as $param ) {
				if (!empty( $field[$param] ))
					$params[$param] = $field[$param];
			}


			return wp_nav_menu( $params );
		}
	}



	/*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your render_field() action.
	*/

	function input_admin_enqueue_scripts()
	{
		$dir = plugin_dir_url( __FILE__ );
		
		wp_register_script( 'acf-input-navmenu', $dir . 'js/input.js', ['acf-input'] );
		wp_enqueue_script('acf-input-navmenu');

		wp_register_style( 'acf-input-navmenu', $dir . 'css/input.css' ); 
		wp_enqueue_style('acf-input-navmenu');
	}


}


// create field
new acf_field_navmenu();

?>