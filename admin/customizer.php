<?php

/**
 * Create the section
 */
function my_custom_section( $wp_customize ) {

	// Header
	$wp_customize->add_section( 'header', array(
		'title'    => __( 'Header', 'roots' ),
		'priority' => 10
	) );

	// Footer
	$wp_customize->add_section( 'social', array(
		'title'    => __( 'Social', 'roots' ),
		'priority' => 20
	) );

	// Footer
	$wp_customize->add_section( 'footer', array(
		'title'    => __( 'Footer', 'roots' ),
		'priority' => 30
	) );

}
add_action( 'customize_register', 'my_custom_section' );

/**
 * Create the setting
 */
function my_custom_setting( $controls ) {

    //Social
	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'facebook',
		'label'    => __( 'Faceook URL', 'roots' ),
		'section'  => 'social',
		'default'  => 'http://facebook.com',
		'priority' => 20,
	);
	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'twitter',
		'label'    => __( 'Twitter URL', 'roots' ),
		'section'  => 'social',
		'default'  => 'http://twitter.com',
		'priority' => 21,
	);
	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'googleplus',
		'label'    => __( 'Google Plus URL', 'roots' ),
		'section'  => 'social',
		'default'  => 'http://googleplus.com',
		'priority' => 22,
	);
    //Footer
	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'map',
		'label'    => __( 'Address', 'roots' ),
		'section'  => 'footer',
		'default'  => '2046 Lorem Ipsum Dolor Sit 20707',
		'priority' => 10,
	);
	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'phone',
		'label'    => __( 'Phone number', 'roots' ),
		'section'  => 'footer',
		'default'  => 'TEL: 000 123 45678',
		'priority' => 11,
	);
	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'email',
		'label'    => __( 'Email', 'roots' ),
		'section'  => 'footer',
		'default'  => 'info@example.com',
		'priority' => 12,
	);
	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'lang',
		'label'    => __( 'Languages', 'roots' ),
		'section'  => 'footer',
		'default'  => 'Change language',
		'priority' => 13,
	);
	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'copy',
		'label'    => __( 'Copyright', 'roots' ),
		'section'  => 'footer',
		'default'  => 'All rights reserved',
		'priority' => 14,
	);

	return $controls;
}
add_filter( 'kirki/controls', 'my_custom_setting' );
