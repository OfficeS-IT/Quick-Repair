<?php
/**
 * VW Automobile Lite Theme Customizer
 *
 * @package VW Automobile Lite
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function vw_automobile_lite_customize_register($wp_customize) {

	//add home page setting pannel
	$wp_customize->add_panel('vw_automobile_lite_panel_id', array(
			'priority'       => 10,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => __('VW Settings', 'vw-automobile-lite'),
			'description'    => __('Description of what this panel does.', 'vw-automobile-lite'),
		));

	$wp_customize->add_section('vw_automobile_lite_left_right', array(
			'title'    => __('General Settings', 'vw-automobile-lite'),
			'priority' => 30,
			'panel'    => 'vw_automobile_lite_panel_id',
		));

	// Add Settings and Controls for Layout
	$wp_customize->add_setting('vw_automobile_lite_theme_options', array(
			'default'           => __('Right Sidebar', 'vw-automobile-lite'),
			'sanitize_callback' => 'vw_automobile_lite_sanitize_choices',
		));

	$wp_customize->add_control('vw_automobile_lite_theme_options',
		array(
			'type'           => 'radio',
			'label'          => __('Do you want this section', 'vw-automobile-lite'),
			'section'        => 'vw_automobile_lite_left_right',
			'choices'        => array(
				'Left Sidebar'  => __('Left Sidebar', 'vw-automobile-lite'),
				'Right Sidebar' => __('Right Sidebar', 'vw-automobile-lite'),
				'One Column'    => __('One Column', 'vw-automobile-lite'),
				'Three Columns' => __('Three Columns', 'vw-automobile-lite'),
				'Four Columns'  => __('Four Columns', 'vw-automobile-lite'),
				'Grid Layout'   => __('Grid Layout', 'vw-automobile-lite')
			),
		)
	);

	$font_array = array(
		''                       => 'No Fonts',
		'Abril Fatface'          => 'Abril Fatface',
		'Acme'                   => 'Acme',
		'Anton'                  => 'Anton',
		'Architects Daughter'    => 'Architects Daughter',
		'Arimo'                  => 'Arimo',
		'Arsenal'                => 'Arsenal', 
		'Arvo'                   => 'Arvo', 
		'Alegreya'               => 'Alegreya',
		'Alfa Slab One'          => 'Alfa Slab One',
		'Averia Serif Libre'     => 'Averia Serif Libre',
		'Bangers'                => 'Bangers',
		'Boogaloo'               => 'Boogaloo',
		'Bad Script'             => 'Bad Script',
		'Bitter'                 => 'Bitter',
		'Bree Serif'             => 'Bree Serif', 
		'BenchNine'              => 'BenchNine', 
		'Cabin'                  => 'Cabin',
		'Cardo'                  => 'Cardo',
		'Courgette'              => 'Courgette',
		'Cherry Swash'           => 'Cherry Swash',
		'Cormorant Garamond'     => 'Cormorant Garamond',
		'Crimson Text'           => 'Crimson Text',
		'Cuprum'                 => 'Cuprum',
		'Cookie'                 => 'Cookie',
		'Chewy'                  => 'Chewy',
		'Days One'               => 'Days One', 
		'Dosis'                  => 'Dosis', 
		'Droid Sans'             => 'Droid Sans', 
		'Economica'              => 'Economica', 
		'Fredoka One'            => 'Fredoka One',
		'Fjalla One'             => 'Fjalla One', 
		'Francois One'           => 'Francois One', 
		'Frank Ruhl Libre'       => 'Frank Ruhl Libre', 
		'Gloria Hallelujah'      => 'Gloria Hallelujah',
		'Great Vibes'            => 'Great Vibes',
		'Handlee'                => 'Handlee',
		'Hammersmith One'        => 'Hammersmith One',
		'Inconsolata'            => 'Inconsolata',
		'Indie Flower'           => 'Indie Flower',
		'IM Fell English SC'     => 'IM Fell English SC',
		'Julius Sans One'        => 'Julius Sans One',
		'Josefin Slab'           => 'Josefin Slab',
		'Josefin Sans'           => 'Josefin Sans', 
		'Kanit'                  => 'Kanit',
		'Lobster'                => 'Lobster',
		'Lato'                   => 'Lato',
		'Lora'                   => 'Lora',
		'Libre Baskerville'      => 'Libre Baskerville',
		'Lobster Two'            => 'Lobster Two',
		'Merriweather'           => 'Merriweather',
		'Monda'                  => 'Monda',
		'Montserrat'             => 'Montserrat',
		'Muli'                   => 'Muli',
		'Marck Script'           => 'Marck Script',
		'Noto Serif'             => 'Noto Serif',
		'Open Sans'              => 'Open Sans',
		'Overpass'               => 'Overpass',
		'Overpass Mono'          => 'Overpass Mono',
		'Oxygen'                 => 'Oxygen',
		'Orbitron'               => 'Orbitron',
		'Patua One'              => 'Patua One',
		'Pacifico'               => 'Pacifico',
		'Padauk'                 => 'Padauk',
		'Playball'               => 'Playball',
		'Playfair Display'       => 'Playfair Display',
		'PT Sans'                => 'PT Sans',
		'Philosopher'            => 'Philosopher',
		'Permanent Marker'       => 'Permanent Marker',
		'Poiret One'             => 'Poiret One',
		'Quicksand'              => 'Quicksand',
		'Quattrocento Sans'      => 'Quattrocento Sans',
		'Raleway'                => 'Raleway',
		'Rubik'                  => 'Rubik',
		'Rokkitt'                => 'Rokkitt',
		'Russo One'              => 'Russo One', 
		'Righteous'              => 'Righteous',
		'Slabo'                  => 'Slabo',
		'Source Sans Pro'        => 'Source Sans Pro',
		'Shadows Into Light Two' => 'Shadows Into Light Two',
		'Shadows Into Light'     => 'Shadows Into Light', 
		'Sacramento'             => 'Sacramento', 
		'Shrikhand'              => 'Shrikhand', 
		'Tangerine'              => 'Tangerine',
		'Ubuntu'                 => 'Ubuntu',
		'VT323'                  => 'VT323', 
		'Varela Round'           => 'Varela Round',
		'Vampiro One'            => 'Vampiro One',
		'Vollkorn'               => 'Vollkorn', 
		'Volkhov'                => 'Volkhov', 
		'Yanone Kaffeesatz'      => 'Yanone Kaffeesatz'
	);

	//Typography
	$wp_customize->add_section('vw_automobile_lite_typography', array(
			'title'    => __('Typography', 'vw-automobile-lite'),
			'priority' => 30,
			'panel'    => 'vw_automobile_lite_panel_id',
		));

	// This is Paragraph Color picker setting
	$wp_customize->add_setting('vw_automobile_lite_paragraph_color', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
		));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_automobile_lite_paragraph_color', array(
				'label'    => __('Paragraph Color', 'vw-automobile-lite'),
				'section'  => 'vw_automobile_lite_typography',
				'settings' => 'vw_automobile_lite_paragraph_color',
			)));

	//This is Paragraph FontFamily picker setting
	$wp_customize->add_setting('vw_automobile_lite_paragraph_font_family', array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'vw_automobile_lite_sanitize_choices',
		));
	$wp_customize->add_control(
		'vw_automobile_lite_paragraph_font_family', array(
			'section' => 'vw_automobile_lite_typography',
			'label'   => __('Paragraph Fonts', 'vw-automobile-lite'),
			'type'    => 'select',
			'choices' => $font_array,
		));

	$wp_customize->add_setting('vw_automobile_lite_paragraph_font_size', array(
			'default'           => '12px',
			'sanitize_callback' => 'sanitize_text_field',
		));

	$wp_customize->add_control('vw_automobile_lite_paragraph_font_size', array(
			'label'   => __('Paragraph Font Size', 'vw-automobile-lite'),
			'section' => 'vw_automobile_lite_typography',
			'setting' => 'vw_automobile_lite_paragraph_font_size',
			'type'    => 'text',
		));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting('vw_automobile_lite_atag_color', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
		));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_automobile_lite_atag_color', array(
				'label'    => __('"a" Tag Color', 'vw-automobile-lite'),
				'section'  => 'vw_automobile_lite_typography',
				'settings' => 'vw_automobile_lite_atag_color',
			)));

	//This is "a" Tag FontFamily picker setting
	$wp_customize->add_setting('vw_automobile_lite_atag_font_family', array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'vw_automobile_lite_sanitize_choices',
		));
	$wp_customize->add_control(
		'vw_automobile_lite_atag_font_family', array(
			'section' => 'vw_automobile_lite_typography',
			'label'   => __('"a" Tag Fonts', 'vw-automobile-lite'),
			'type'    => 'select',
			'choices' => $font_array,
		));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting('vw_automobile_lite_li_color', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
		));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_automobile_lite_li_color', array(
				'label'    => __('"li" Tag Color', 'vw-automobile-lite'),
				'section'  => 'vw_automobile_lite_typography',
				'settings' => 'vw_automobile_lite_li_color',
			)));

	//This is "li" Tag FontFamily picker setting
	$wp_customize->add_setting('vw_automobile_lite_li_font_family', array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'vw_automobile_lite_sanitize_choices',
		));
	$wp_customize->add_control(
		'vw_automobile_lite_li_font_family', array(
			'section' => 'vw_automobile_lite_typography',
			'label'   => __('"li" Tag Fonts', 'vw-automobile-lite'),
			'type'    => 'select',
			'choices' => $font_array,
		));

	// This is H1 Color picker setting
	$wp_customize->add_setting('vw_automobile_lite_h1_color', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
		));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_automobile_lite_h1_color', array(
				'label'    => __('H1 Color', 'vw-automobile-lite'),
				'section'  => 'vw_automobile_lite_typography',
				'settings' => 'vw_automobile_lite_h1_color',
			)));

	//This is H1 FontFamily picker setting
	$wp_customize->add_setting('vw_automobile_lite_h1_font_family', array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'vw_automobile_lite_sanitize_choices',
		));
	$wp_customize->add_control(
		'vw_automobile_lite_h1_font_family', array(
			'section' => 'vw_automobile_lite_typography',
			'label'   => __('H1 Fonts', 'vw-automobile-lite'),
			'type'    => 'select',
			'choices' => $font_array,
		));

	//This is H1 FontSize setting
	$wp_customize->add_setting('vw_automobile_lite_h1_font_size', array(
			'default'           => '50px',
			'sanitize_callback' => 'sanitize_text_field',
		));

	$wp_customize->add_control('vw_automobile_lite_h1_font_size', array(
			'label'   => __('H1 Font Size', 'vw-automobile-lite'),
			'section' => 'vw_automobile_lite_typography',
			'setting' => 'vw_automobile_lite_h1_font_size',
			'type'    => 'text',
		));

	// This is H2 Color picker setting
	$wp_customize->add_setting('vw_automobile_lite_h2_color', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
		));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_automobile_lite_h2_color', array(
				'label'    => __('h2 Color', 'vw-automobile-lite'),
				'section'  => 'vw_automobile_lite_typography',
				'settings' => 'vw_automobile_lite_h2_color',
			)));

	//This is H2 FontFamily picker setting
	$wp_customize->add_setting('vw_automobile_lite_h2_font_family', array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'vw_automobile_lite_sanitize_choices',
		));
	$wp_customize->add_control(
		'vw_automobile_lite_h2_font_family', array(
			'section' => 'vw_automobile_lite_typography',
			'label'   => __('h2 Fonts', 'vw-automobile-lite'),
			'type'    => 'select',
			'choices' => $font_array,
		));

	//This is H2 FontSize setting
	$wp_customize->add_setting('vw_automobile_lite_h2_font_size', array(
			'default'           => '45px',
			'sanitize_callback' => 'sanitize_text_field',
		));

	$wp_customize->add_control('vw_automobile_lite_h2_font_size', array(
			'label'   => __('h2 Font Size', 'vw-automobile-lite'),
			'section' => 'vw_automobile_lite_typography',
			'setting' => 'vw_automobile_lite_h2_font_size',
			'type'    => 'text',
		));

	// This is H3 Color picker setting
	$wp_customize->add_setting('vw_automobile_lite_h3_color', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
		));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_automobile_lite_h3_color', array(
				'label'    => __('h3 Color', 'vw-automobile-lite'),
				'section'  => 'vw_automobile_lite_typography',
				'settings' => 'vw_automobile_lite_h3_color',
			)));

	//This is H3 FontFamily picker setting
	$wp_customize->add_setting('vw_automobile_lite_h3_font_family', array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'vw_automobile_lite_sanitize_choices',
		));
	$wp_customize->add_control(
		'vw_automobile_lite_h3_font_family', array(
			'section' => 'vw_automobile_lite_typography',
			'label'   => __('h3 Fonts', 'vw-automobile-lite'),
			'type'    => 'select',
			'choices' => $font_array,
		));

	//This is H3 FontSize setting
	$wp_customize->add_setting('vw_automobile_lite_h3_font_size', array(
			'default'           => '36px',
			'sanitize_callback' => 'sanitize_text_field',
		));

	$wp_customize->add_control('vw_automobile_lite_h3_font_size', array(
			'label'   => __('h3 Font Size', 'vw-automobile-lite'),
			'section' => 'vw_automobile_lite_typography',
			'setting' => 'vw_automobile_lite_h3_font_size',
			'type'    => 'text',
		));

	// This is H4 Color picker setting
	$wp_customize->add_setting('vw_automobile_lite_h4_color', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
		));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_automobile_lite_h4_color', array(
				'label'    => __('h4 Color', 'vw-automobile-lite'),
				'section'  => 'vw_automobile_lite_typography',
				'settings' => 'vw_automobile_lite_h4_color',
			)));

	//This is H4 FontFamily picker setting
	$wp_customize->add_setting('vw_automobile_lite_h4_font_family', array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'vw_automobile_lite_sanitize_choices',
		));
	$wp_customize->add_control(
		'vw_automobile_lite_h4_font_family', array(
			'section' => 'vw_automobile_lite_typography',
			'label'   => __('h4 Fonts', 'vw-automobile-lite'),
			'type'    => 'select',
			'choices' => $font_array,
		));

	//This is H4 FontSize setting
	$wp_customize->add_setting('vw_automobile_lite_h4_font_size', array(
			'default'           => '30px',
			'sanitize_callback' => 'sanitize_text_field',
		));

	$wp_customize->add_control('vw_automobile_lite_h4_font_size', array(
			'label'   => __('h4 Font Size', 'vw-automobile-lite'),
			'section' => 'vw_automobile_lite_typography',
			'setting' => 'vw_automobile_lite_h4_font_size',
			'type'    => 'text',
		));

	// This is H5 Color picker setting
	$wp_customize->add_setting('vw_automobile_lite_h5_color', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
		));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_automobile_lite_h5_color', array(
				'label'    => __('h5 Color', 'vw-automobile-lite'),
				'section'  => 'vw_automobile_lite_typography',
				'settings' => 'vw_automobile_lite_h5_color',
			)));

	//This is H5 FontFamily picker setting
	$wp_customize->add_setting('vw_automobile_lite_h5_font_family', array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'vw_automobile_lite_sanitize_choices',
		));
	$wp_customize->add_control(
		'vw_automobile_lite_h5_font_family', array(
			'section' => 'vw_automobile_lite_typography',
			'label'   => __('h5 Fonts', 'vw-automobile-lite'),
			'type'    => 'select',
			'choices' => $font_array,
		));

	//This is H5 FontSize setting
	$wp_customize->add_setting('vw_automobile_lite_h5_font_size', array(
			'default'           => '25px',
			'sanitize_callback' => 'sanitize_text_field',
		));

	$wp_customize->add_control('vw_automobile_lite_h5_font_size', array(
			'label'   => __('h5 Font Size', 'vw-automobile-lite'),
			'section' => 'vw_automobile_lite_typography',
			'setting' => 'vw_automobile_lite_h5_font_size',
			'type'    => 'text',
		));

	// This is H6 Color picker setting
	$wp_customize->add_setting('vw_automobile_lite_h6_color', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
		));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_automobile_lite_h6_color', array(
				'label'    => __('h6 Color', 'vw-automobile-lite'),
				'section'  => 'vw_automobile_lite_typography',
				'settings' => 'vw_automobile_lite_h6_color',
			)));

	//This is H6 FontFamily picker setting
	$wp_customize->add_setting('vw_automobile_lite_h6_font_family', array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'vw_automobile_lite_sanitize_choices',
		));
	$wp_customize->add_control(
		'vw_automobile_lite_h6_font_family', array(
			'section' => 'vw_automobile_lite_typography',
			'label'   => __('h6 Fonts', 'vw-automobile-lite'),
			'type'    => 'select',
			'choices' => $font_array,
		));

	//This is H6 FontSize setting
	$wp_customize->add_setting('vw_automobile_lite_h6_font_size', array(
			'default'           => '18px',
			'sanitize_callback' => 'sanitize_text_field',
		));

	$wp_customize->add_control('vw_automobile_lite_h6_font_size', array(
			'label'   => __('h6 Font Size', 'vw-automobile-lite'),
			'section' => 'vw_automobile_lite_typography',
			'setting' => 'vw_automobile_lite_h6_font_size',
			'type'    => 'text',
		));

	//home page slider
	$wp_customize->add_section('vw_automobile_lite_slidersettings', array(
			'title'    => __('Slider Settings', 'vw-automobile-lite'),
			'priority' => 30,
			'panel'    => 'vw_automobile_lite_panel_id',
		));

	for ($count = 1; $count <= 4; $count++) {

		// Add color scheme setting and control.
		$wp_customize->add_setting('vw_automobile_lite_slidersettings-page-'.$count, array(
				'default'           => '',
				'sanitize_callback' => 'vw_automobile_lite_sanitize_dropdown_pages',
			));

		$wp_customize->add_control('vw_automobile_lite_slidersettings-page-'.$count, array(
				'label'   => __('Select Slide Image Page', 'vw-automobile-lite'),
				'section' => 'vw_automobile_lite_slidersettings',
				'type'    => 'dropdown-pages',
			));

	}

	//Topbar section
	$wp_customize->add_section('vw_automobile_lite_topbar_icon', array(
			'title'       => __('Topbar Section', 'vw-automobile-lite'),
			'description' => __('Add Top Header Content here', 'vw-automobile-lite'),
			'priority'    => null,
			'panel'       => 'vw_automobile_lite_panel_id',
		));

	$wp_customize->add_setting('vw_automobile_lite_contact', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		));

	$wp_customize->add_control('vw_automobile_lite_contact', array(
			'label'   => __('Add Phone Number', 'vw-automobile-lite'),
			'section' => 'vw_automobile_lite_topbar_icon',
			'setting' => 'vw_automobile_lite_contact',
			'type'    => 'text',
		));

	$wp_customize->add_setting('vw_automobile_lite_email', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		));

	$wp_customize->add_control('vw_automobile_lite_email', array(
			'label'   => __('Add Email', 'vw-automobile-lite'),
			'section' => 'vw_automobile_lite_topbar_icon',
			'setting' => 'vw_automobile_lite_email',
			'type'    => 'text',
		));

	$wp_customize->add_setting('vw_automobile_lite_headertimings', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		));

	$wp_customize->add_control('vw_automobile_lite_headertimings', array(
			'label'   => __('Add Timing', 'vw-automobile-lite'),
			'section' => 'vw_automobile_lite_topbar_icon',
			'setting' => 'vw_automobile_lite_headertimings',
			'type'    => 'text',
		));

	//Our Services
	$wp_customize->add_section('vw_automobile_lite_choose_us', array(
			'title'       => __('Choose Us Section', 'vw-automobile-lite'),
			'description' => '',
			'priority'    => null,
			'panel'       => 'vw_automobile_lite_panel_id',
		));

	$wp_customize->add_setting('vw_automobile_lite_title', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		));

	$wp_customize->add_control('vw_automobile_lite_title', array(
			'label'   => __('Title', 'vw-automobile-lite'),
			'section' => 'vw_automobile_lite_choose_us',
			'type'    => 'text',
		));

	$categories = get_categories();
	$cats       = array();
	$i          = 0;
	foreach ($categories as $category) {
		if ($i == 0) {
			$default = $category->slug;
			$i++;
		}
		$cats[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('vw_automobile_lite_choose_us_category', array(
			'default'           => 'select',
			'sanitize_callback' => 'vw_automobile_lite_sanitize_choices',
		));
	$wp_customize->add_control('vw_automobile_lite_choose_us_category', array(
			'type'    => 'select',
			'choices' => $cats,
			'label'   => __('Select Category to display Latest Post', 'vw-automobile-lite'),
			'section' => 'vw_automobile_lite_choose_us',
		));

	//Footer
	$wp_customize->add_section('vw_automobile_lite_footer', array(
			'title'       => __('Footer Section', 'vw-automobile-lite'),
			'description' => '',
			'priority'    => null,
			'panel'       => 'vw_automobile_lite_panel_id',
		));

	$wp_customize->add_setting('vw_automobile_lite_footer_copy', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		));
	$wp_customize->add_control('vw_automobile_lite_footer_copy', array(
			'label'   => __('Copyright Text', 'vw-automobile-lite'),
			'section' => 'vw_automobile_lite_footer',
			'type'    => 'text',
		));
}

add_action('customize_register', 'vw_automobile_lite_customize_register');

load_template(trailingslashit(get_template_directory()).'/inc/logo-resizer.php');

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class VW_Automobile_Lite_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if (is_null($instance)) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action('customize_register', array($this, 'sections'));

		// Register scripts and styles for the controls.
		add_action('customize_controls_enqueue_scripts', array($this, 'enqueue_control_scripts'), 0);
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections($manager) {

		// Load custom sections.
		load_template(trailingslashit(get_template_directory()).'/inc/section-pro.php');

		// Register custom section types.
		$manager->register_section_type('VW_Automobile_Lite_Customize_Section_Pro');

		// Register sections.
		$manager->add_section(
			new VW_Automobile_Lite_Customize_Section_Pro(
				$manager,
				'example_1',
				array(
					'priority' => 9,
					'title'    => esc_html__('VW Automobile Pro', 'vw-automobile-lite'),
					'pro_text' => esc_html__('Upgrade Pro', 'vw-automobile-lite'),
					'pro_url'  => esc_url('https://www.vwthemes.com/premium/automobile-wordpress-theme/')
				)
			)
		);

		// Register sections.
		$manager->add_section(
			new VW_Automobile_Lite_Customize_Section_Pro(
				$manager,
				'example_2',
				array(
					'priority' => 9,
					'title'    => esc_html__('Documentation', 'vw-automobile-lite'),
					'pro_text' => esc_html__('Docs', 'vw-automobile-lite'),
					'pro_url'  => admin_url('themes.php?page=vw_automobile_lite_guide')
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script('vw-automobile-lite-customize-controls', trailingslashit(get_template_directory_uri()).'/js/customize-controls.js', array('customize-controls'));

		wp_enqueue_style('vw-automobile-lite-customize-controls', trailingslashit(get_template_directory_uri()).'/css/customize-controls.css');
	}
}

// Doing this customizer thang!
VW_Automobile_Lite_Customize::get_instance();