<?php
/**
 * Plugin Name: Unsemantic Grid for Gravity Forms
 * Plugin URI: https://github.com/WestCoastDigital/gp-gravityforms
 * Description: Applies GeneratePress customisations & styles to Gravity Forms
 * Version: 0.1
 * Author: Jon Mather
 * Author URI: https://westcoastdigital.com.au
 */

defined('ABSPATH') or die("These aren't the droids you're looking for");

// Enable Gravity Forms field label visibility
add_filter('gform_enable_field_label_visibility_settings', '__return_true');

class gpGfStyle
{
    public static function gp_gf_add_unsemantic_classes($classes, $field, $form)
    {

        // Turn field classes into array
        $field_classes = explode(' ', $classes);
        $skip_classes = ['gform_validation_container', 'gform_hidden'];

        // Skip validation container
        if (count(array_intersect($skip_classes, $field_classes)) != 0) {
            return $classes;
        }

        // Get the unsemantic classes
        $bsClasses = apply_filters('gp-gf-us-classes', gpGfStyle::gp_gf_default_classes());

        // Fixed sizes array size => field type
        $fixedSizes = [
            'name'             => 'large',
            'fileupload'     => 'large'
        ];

        // Set specific fields to certain size and add field type as extra class
        if (array_key_exists($field->type, $fixedSizes)) {
            $field->size = $fixedSizes[$field->type];
            $field_classes[] = 'gfield_type_' . $field->type;
        }

        // Merge unsemantic classes based on field size
        $classes = array_merge($field_classes, $bsClasses[$field->size], ['gfield-us']);
        return implode(' ', $classes);
    }

    // Set default classes
    public static function gp_gf_default_classes()
    {
        return [
            'small'    => [
                get_theme_mod('gp_gf_small_mobile', 'mobile-grid-100'),
                get_theme_mod('gp_gf_small_tablet', 'tablet-grid-50'),
                get_theme_mod('gp_gf_small_desktop', 'grid-33')
            ],
            'medium' => [
                get_theme_mod('gp_gf_medium_mobile', 'mobile-grid-100'),
                get_theme_mod('gp_gf_medium_tablet', 'tablet-grid-50'),
                get_theme_mod('gp_gf_medium_desktop', 'grid-50')
            ],
            'large' => [
                get_theme_mod('gp_gf_large_mobile', 'mobile-grid-100'),
                get_theme_mod('gp_gf_large_tablet', 'tablet-grid-100'),
                get_theme_mod('gp_gf_large_desktop', 'grid-100')
            ]
        ];
    }

    // Add custom styles
    public static function gp_gf_default_style()
    {
        wp_register_style('gp-gravityforms',  plugin_dir_url(__FILE__) . "/style.css");
        wp_enqueue_style('gp-gravityforms');
    }

    // Add customizer controls to change default classes
    public static function gp_gf_customizer_settings($wp_customize)
    {
        $wp_customize->add_panel(
            'gp_gf_panel',
            array(
                'title' => __('Gravity Forms'),
            )
        );
        $wp_customize->add_section(
            'gp_gf_small_class',
            array(
                'title' => __('Small Field Classes'),
                'description' => esc_html__('These are the default classes when a GF field is set to small.'),
                'panel' => 'gp_gf_panel',
            )
        );
        $wp_customize->add_section(
            'gp_gf_medium_class',
            array(
                'title' => __('Medium Field Classes'),
                'description' => esc_html__('These are the default classes when a GF field is set to medium.'),
                'panel' => 'gp_gf_panel',
            )
        );
        $wp_customize->add_section(
            'gp_gf_large_class',
            array(
                'title' => __('Large Field Classes'),
                'description' => esc_html__('These are the default classes when a GF field is set to large.'),
                'panel' => 'gp_gf_panel',
            )
        );

        // small mobile class
        $wp_customize->add_setting(
            'gp_gf_small_mobile',
            array(
                'default' => 'mobile-grid-100',
                'transport' => 'refresh',
            )
        );
        $wp_customize->add_control(
            'gp_gf_small_mobile',
            array(
                'label' => __('Mobile Class'),
                'section' => 'gp_gf_small_class',
                'priority' => 10,
                'type' => 'text',
                'input_attrs' => array(
                    'placeholder' => __('mobile-grid-100'),
                ),
            )
        );

        // small tablet class
        $wp_customize->add_setting(
            'gp_gf_small_tablet',
            array(
                'default' => 'tablet-grid-50',
                'transport' => 'refresh',
            )
        );
        $wp_customize->add_control(
            'gp_gf_small_tablet',
            array(
                'label' => __('Tablet Class'),
                'section' => 'gp_gf_small_class',
                'priority' => 10,
                'type' => 'text',
                'input_attrs' => array(
                    'placeholder' => __('tablet-grid-50'),
                ),
            )
        );

        // small desktop class
        $wp_customize->add_setting(
            'gp_gf_small_desktop',
            array(
                'default' => 'grid-33',
                'transport' => 'refresh',
            )
        );
        $wp_customize->add_control(
            'gp_gf_small_desktop',
            array(
                'label' => __('Desktop Class'),
                'section' => 'gp_gf_small_class',
                'priority' => 10,
                'type' => 'text',
                'input_attrs' => array(
                    'placeholder' => __('grid-33'),
                ),
            )
        );

        // medium mobile class
        $wp_customize->add_setting(
            'gp_gf_medium_mobile',
            array(
                'default' => 'mobile-grid-100',
                'transport' => 'refresh',
            )
        );
        $wp_customize->add_control(
            'gp_gf_medium_mobile',
            array(
                'label' => __('Mobile Class'),
                'section' => 'gp_gf_medium_class',
                'priority' => 10,
                'type' => 'text',
                'input_attrs' => array(
                    'placeholder' => __('mobile-grid-100'),
                ),
            )
        );

        // medium tablet class
        $wp_customize->add_setting(
            'gp_gf_medium_tablet',
            array(
                'default' => 'tablet-grid-50',
                'transport' => 'refresh',
            )
        );
        $wp_customize->add_control(
            'gp_gf_medium_tablet',
            array(
                'label' => __('Tablet Class'),
                'section' => 'gp_gf_medium_class',
                'priority' => 10,
                'type' => 'text',
                'input_attrs' => array(
                    'placeholder' => __('tablet-grid-50'),
                ),
            )
        );

        // medium desktop class
        $wp_customize->add_setting(
            'gp_gf_medium_desktop',
            array(
                'default' => 'grid-50',
                'transport' => 'refresh',
            )
        );
        $wp_customize->add_control(
            'gp_gf_medium_desktop',
            array(
                'label' => __('Desktop Class'),
                'section' => 'gp_gf_medium_class',
                'priority' => 10,
                'type' => 'text',
                'input_attrs' => array(
                    'placeholder' => __('grid-50'),
                ),
            )
        );

        // large mobile class
        $wp_customize->add_setting(
            'gp_gf_large_mobile',
            array(
                'default' => 'mobile-grid-100',
                'transport' => 'refresh',
            )
        );
        $wp_customize->add_control(
            'gp_gf_large_mobile',
            array(
                'label' => __('Mobile Class'),
                'section' => 'gp_gf_large_class',
                'priority' => 10,
                'type' => 'text',
                'input_attrs' => array(
                    'placeholder' => __('mobile-grid-100'),
                ),
            )
        );

        // large tablet class
        $wp_customize->add_setting(
            'gp_gf_large_tablet',
            array(
                'default' => 'tablet-grid-100',
                'transport' => 'refresh',
            )
        );
        $wp_customize->add_control(
            'gp_gf_large_tablet',
            array(
                'label' => __('Tablet Class'),
                'section' => 'gp_gf_large_class',
                'priority' => 10,
                'type' => 'text',
                'input_attrs' => array(
                    'placeholder' => __('tablet-grid-100'),
                ),
            )
        );

        // large desktop class
        $wp_customize->add_setting(
            'gp_gf_large_desktop',
            array(
                'default' => 'grid-100',
                'transport' => 'refresh',
            )
        );
        $wp_customize->add_control(
            'gp_gf_large_desktop',
            array(
                'label' => __('Desktop Class'),
                'section' => 'gp_gf_large_class',
                'priority' => 10,
                'type' => 'text',
                'input_attrs' => array(
                    'placeholder' => __('grid-100'),
                ),
            )
        );
    }
}
add_filter('gform_field_css_class', 'gpGfStyle::gp_gf_add_unsemantic_classes', 10, 3);
add_action('wp_enqueue_scripts', 'gpGfStyle::gp_gf_default_style');
add_action('customize_register', 'gpGfStyle::gp_gf_customizer_settings');
