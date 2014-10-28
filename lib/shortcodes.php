<?php

// Image with shadow
function img_shadow_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
      'image' => '',
      'size' => 'full',
      'classes' => ''
	), $atts));

    if (!empty($classes)) $classes = ' ' . $classes;
    $imgSrc = wp_get_attachment_image_src( $image, $size );

    $imgHtml = '<div class="shadow '. $classes .' motopress-image-obj">';
    $imgHtml .= '<img src="'.$imgSrc[0].'" class="motopress-image-obj-basic">';
    $imgHtml .= '</div>';

	return $imgHtml;
}
// register your shortcode
add_shortcode('img_shadow', 'img_shadow_shortcode');


// Create function. Everything will be done here.
function img_shadow_function($motopressCELibrary) {

    // Create an object with your shortcode specific parameters
	$imgShadowObject = new MPCEObject('img_shadow', _('Image Shadow'), null,
        array(
          'image' => array(
              'type' => 'image',
              'label' => __('Image dialog', 'roots'),
              'default' => '',
              'description' => __('Description', 'roots'),
          ),
          'size' => array(
              'type' => 'select',
              'label' => __('Size', 'roots'),
              'default' => '',
              'description' => __('Change size of your image', 'roots'),
              'list' => array(
                'full' => 'Full',
                'large' => 'Large',
                'medium' => 'Medium',
                'thumbnail' => 'Thumbnail',
              )
          ),
        ),
        0,
        MPCEObject::SELF_CLOSED
	);

	// Add this object into any group you need
	$motopressCELibrary->addObject($imgShadowObject, $group = 'image');
}

// Integrate your shortcode into MotoPress Content Editor
add_action('mp_library', 'img_shadow_function', 10, 1);
