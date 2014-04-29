<?php
/**
 * Notepad Theme Customizer support
 *
 * @package WordPress
 * @subpackage Notepad
 * @since Notepad 1.0
 */

/**
 * Add postMessage support for site title, description and 
 * reorganize other elements for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function sprint_customize_organizer($wp_customize) {
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_control('background_color')->section = 'sprint_theme_style_settings';
}

add_action('customize_register', 'sprint_customize_organizer', 12);

/**
 * Implement Theme Customizer additions and adjustments.
 *
 * @since Notepad 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function sprint_customize_register($wp_customize) {

    /** ===============
     * Extends CONTROLS class to add textarea
     */
    class sprint_customize_textarea_control extends WP_Customize_Control {

        public $type = 'textarea';

        public function render_content() {
            ?>

            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <textarea rows="5" style="width:98%;" <?php $this->link(); ?>><?php echo esc_textarea($this->value()); ?></textarea>
            </label>

            <?php
        }

    }

    // Displays a list of categories in dropdown
    class WP_Customize_Dropdown_Categories_Control extends WP_Customize_Control {

        public $type = 'dropdown-categories';

        public function render_content() {
            $dropdown = wp_dropdown_categories(
                    array(
                        'name' => '_customize-dropdown-categories-' . $this->id,
                        'echo' => 0,
                        'hide_empty' => false,
                        'show_option_none' => '&mdash; ' . __('Select', 'sprint') . ' &mdash;',
                        'hide_if_empty' => false,
                        'selected' => $this->value(),
                    )
            );

            $dropdown = str_replace('<select', '<select ' . $this->get_link(), $dropdown);

            printf(
                    '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>', $this->label, $dropdown
            );
        }

    }

    // Add new section for theme layout and color schemes
    $wp_customize->add_section('sprint_theme_style_settings', array(
        'title' => __('Styling Option', 'sprint'),
        'priority' => 30,
    ));

    // Add setting for primary color
    $wp_customize->add_setting('sprint_color_scheme', array(
        'default' => '#EF7A7A',
        'sanitize_callback' => 'sprint_sanitize_hex_color',
        'sanitize_js_callback' => 'sprint_sanitize_escaping',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'sprint_color_scheme', array(
        'label' => 'Primary Color',
        'section' => 'sprint_theme_style_settings',
        'settings' => 'sprint_color_scheme',
            )
    ));

    // Add setting for link color
    $wp_customize->add_setting('sprint_theme_link_color', array(
        'default' => '#FFF',
        'sanitize_callback' => 'sprint_sanitize_hex_color',
        'sanitize_js_callback' => 'sprint_sanitize_escaping',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'sprint_theme_link_color', array(
        'label' => 'Link Color',
        'section' => 'sprint_theme_style_settings',
        'settings' => 'sprint_theme_link_color',
            )
    ));

    // Add setting for link hover color
    $wp_customize->add_setting('sprint_theme_linkhover_color', array(
        'default' => '#333',
        'sanitize_callback' => 'sprint_sanitize_hex_color',
        'sanitize_js_callback' => 'sprint_sanitize_escaping',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'sprint_theme_linkhover_color', array(
        'label' => 'Link Hover Color',
        'section' => 'sprint_theme_style_settings',
        'settings' => 'sprint_theme_linkhover_color',
            )
    ));

    // Add setting for theme layout
    $wp_customize->add_setting('sprint_layout', array(
        'default' => __('content-sidebar', 'sprint'),
        'sanitize_callback' => 'sprint_sanitize_layout_option',
            )
    );

    $wp_customize->add_control('sprint_layout', array(
        'label' => 'Layout Options',
        'section' => 'sprint_theme_style_settings',
        'type' => 'radio',
        'choices' => array(
            'content-sidebar' => __('Content-sidebar', 'sprint'),
            'sidebar-content' => __('Sidebar-content', 'sprint'),
        ),
    ));

    // Add setting for primary color
    $wp_customize->add_setting('sprint_bg_color', array(
        'default' => '#FFFFFF',
        'sanitize_callback' => 'sprint_sanitize_hex_color',
        'sanitize_js_callback' => 'sprint_sanitize_escaping',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'sprint_bg_color', array(
        'label' => 'Background Color',
        'section' => 'sprint_theme_style_settings',
        'settings' => 'sprint_bg_color',
            )
    ));

    $wp_customize->add_setting('sprint_bg_pattern_upload');

    $wp_customize->add_control(
            new WP_Customize_Image_Control(
            $wp_customize, 'sprint_bg_pattern_upload', array(
        'label' => 'Custom Background Image',
        'section' => 'sprint_theme_style_settings',
        'settings' => 'sprint_bg_pattern_upload'
            )
            )
    );

    // Add new section for general settings
    $wp_customize->add_section('sprint_theme_general_settings', array(
        'title' => __('General Settings', 'sprint'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('sprint_logo');

    $wp_customize->add_control(
            new WP_Customize_Image_Control(
            $wp_customize, 'sprint_logo', array(
        'label' => 'Logo Image',
        'section' => 'sprint_theme_general_settings',
        'settings' => 'sprint_logo'
            )
            )
    );

    $wp_customize->add_setting('sprint_footer_logo');

    $wp_customize->add_control(
            new WP_Customize_Image_Control(
            $wp_customize, 'sprint_footer_logo', array(
        'label' => 'Footer Logo Image',
        'section' => 'sprint_theme_general_settings',
        'settings' => 'sprint_footer_logo'
            )
            )
    );

    $wp_customize->add_setting('sprint_footer_logo');

    $wp_customize->add_control(
            new WP_Customize_Image_Control(
            $wp_customize, 'sprint_footer_logo', array(
        'label' => 'Footer Logo Image',
        'section' => 'sprint_theme_general_settings',
        'settings' => 'sprint_footer_logo'
            )
            )
    );


    $wp_customize->add_setting('sprint_favicon');

    $wp_customize->add_control(
            new WP_Customize_Image_Control(
            $wp_customize, 'sprint_favicon', array(
        'label' => 'Favicon',
        'section' => 'sprint_theme_general_settings',
        'settings' => 'sprint_favicon'
            )
            )
    );


    // Add new section for general settings
    $wp_customize->add_section('sprint_featured_cat_settings', array(
        'title' => __('Featured Category Setting', 'sprint'),
        'priority' => 30,
    ));

    // select category for featured posts 
    $wp_customize->add_setting('sprint_featured_slider_cat', array('default' => 0,));
    $wp_customize->add_control(new WP_Customize_Dropdown_Categories_Control($wp_customize, 'sprint_featured_slider_cat', array(
        'label' => __('Featured Category', 'sprint'),
        'section' => 'sprint_featured_cat_settings',
        'type' => 'dropdown-categories',
        'settings' => 'sprint_featured_slider_cat',
        'priority' => 20,
    )));

    // Add footer text section
    $wp_customize->add_section('sprint_footer', array(
        'title' => 'Copyrights Text', // The title of section
        'priority' => 75,
    ));

    $wp_customize->add_setting('sprint_copyrights', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'sanitize_js_callback' => 'sprint_sanitize_escaping',
    ));

    $wp_customize->add_control(new sprint_customize_textarea_control($wp_customize, 'sprint_copyrights', array(
        'section' => 'sprint_footer', // id of section to which the setting belongs
        'settings' => 'sprint_copyrights',
    )));

    // Add custom CSS section 
    $wp_customize->add_section(
            'sprint_custom_css_section', array(
        'title' => __('Custom CSS', 'sprint'),
        'priority' => 80,
    ));

    $wp_customize->add_setting(
            'sprint_custom_css', array(
        'default' => '',
        'sanitize_callback' => 'sprint_sanitize_custom_css',
        'sanitize_js_callback' => 'sprint_sanitize_escaping',
    ));



    $wp_customize->add_control(
            new sprint_customize_textarea_control(
            $wp_customize, 'sprint_custom_css', array(
        'label' => __('Add your custom css here and design live! (for advanced users)', 'sprint'),
        'section' => 'sprint_custom_css_section',
        'settings' => 'sprint_custom_css'
    )));


    // Add custom CSS section 
    $wp_customize->add_section(
            'sprint_header_code_section', array(
        'title' => __('Header Code', 'sprint'),
        'priority' => 80,
    ));

    $wp_customize->add_setting(
            'sprint_header_code', array(
        'default' => '',
    ));

    $wp_customize->add_control(
            new sprint_customize_textarea_control(
            $wp_customize, 'sprint_header_code', array(
        'label' => __('Add your header code here', 'sprint'),
        'section' => 'sprint_header_code_section',
        'settings' => 'sprint_header_code'
    )));

    $wp_customize->add_section('sprint_trending', array(
        'title' => __('Trending Setting', 'sprint'),
        'priority' => 70,
    ));


    $wp_customize->add_setting('sprint_trending_articles_cat', array(
        'default' => 0,
    ));
    $wp_customize->add_control('sprint_trending_articles_cat', array(
        'label' => __('Trending', 'sprint'),
        'section' => 'sprint_trending',
        'priority' => 10,
        'type' => 'checkbox',
    ));


    $wp_customize->add_section('sprint_single_post_options', array(
        'title' => __('Single Posts', 'sprint'),
        'priority' => 70,
    ));


    $wp_customize->add_setting('sprint_tags', array(
        'default' => 0,
    ));
    $wp_customize->add_control('sprint_tags', array(
        'label' => __('Tag Links', 'sprint'),
        'section' => 'sprint_single_post_options',
        'priority' => 10,
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('sprint_related_posts', array(
        'default' => 0,
    ));
    $wp_customize->add_control('sprint_related_posts', array(
        'label' => __('Related Posts', 'sprint'),
        'section' => 'sprint_single_post_options',
        'priority' => 10,
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('sprint_author_box', array(
        'default' => 0,
    ));
    $wp_customize->add_control('sprint_author_box', array(
        'label' => __('Author Box', 'sprint'),
        'section' => 'sprint_single_post_options',
        'priority' => 10,
        'type' => 'checkbox',
    ));

    $wp_customize->add_section('sprint_ad_management_options', array(
        'title' => __('Ad Management', 'sprint'),
        'priority' => 70,
    ));


    $wp_customize->add_setting(
            'sprint_header_adcode', array(
        'default' => '',
    ));

    $wp_customize->add_control(
            new sprint_customize_textarea_control(
            $wp_customize, 'sprint_header_adcode', array(
        'label' => __('Header Banner', 'sprint'),
        'section' => 'sprint_ad_management_options',
        'settings' => 'sprint_header_adcode'
    )));

    $wp_customize->add_setting(
            'sprint_posttopleft_adcode', array(
        'default' => '',
    ));

    $wp_customize->add_control(
            new sprint_customize_textarea_control(
            $wp_customize, 'sprint_posttopleft_adcode', array(
        'label' => __('Below Header Right Side', 'sprint'),
        'section' => 'sprint_ad_management_options',
        'settings' => 'sprint_posttopleft_adcode'
    )));

    $wp_customize->add_setting(
            'sprint_posttop_adcode', array(
        'default' => '',
    ));

    $wp_customize->add_control(
            new sprint_customize_textarea_control(
            $wp_customize, 'sprint_posttop_adcode', array(
        'label' => __('Below Post Title', 'sprint'),
        'section' => 'sprint_ad_management_options',
        'settings' => 'sprint_posttop_adcode'
    )));



    $wp_customize->add_setting('sprint_posttop_adcode_time', array(
        'default' => '',
    ));
    $wp_customize->add_control('sprint_posttop_adcode_time', array(
        'label' => __('Show After X Days', 'sprint'),
        'section' => 'sprint_ad_management_options',
        'settings' => 'sprint_posttop_adcode_time',
        'priority' => 60,
    ));

    $wp_customize->add_setting(
            'sprint_postend_adcode', array(
        'default' => '',
    ));

    $wp_customize->add_control(
            new sprint_customize_textarea_control(
            $wp_customize, 'sprint_postend_adcode', array(
        'label' => __('Below Post Content', 'sprint'),
        'section' => 'sprint_ad_management_options',
        'settings' => 'sprint_postend_adcode'
    )));


    $wp_customize->add_setting('sprint_postend_adcode_time', array(
        'default' => '',
    ));
    $wp_customize->add_control('sprint_postend_adcode_time', array(
        'label' => __('Show After X Days', 'sprint'),
        'section' => 'sprint_ad_management_options',
        'settings' => 'sprint_postend_adcode_time',
        'priority' => 60,
    ));

    $wp_customize->add_section('sprint_home_featured', array(
        'title' => __('Homepage Front Featured', 'sprint'),
        'priority' => 70,
    ));

    // enable featured products on front page?
    $wp_customize->add_setting('sprint_featured_slider', array(
        'default' => 0,
    ));
    $wp_customize->add_control('sprint_featured_slider', array(
        'label' => __('Show home page featured', 'sprint'),
        'section' => 'sprint_home_featured',
        'priority' => 10,
        'type' => 'checkbox',
    ));

    $wp_customize->add_control(
            new sprint_customize_textarea_control(
            $wp_customize, 'sprint_header_code', array(
        'label' => __('Add your header code here', 'sprint'),
        'section' => 'sprint_header_code_section',
        'settings' => 'sprint_header_code'
    )));

    $wp_customize->add_section('sprint_footer_featured', array(
        'title' => __('Footer Featured', 'sprint'),
        'priority' => 70,
    ));

    // enable featured products on front page?
    $wp_customize->add_setting('sprint_featured_carousel', array(
        'default' => 0,
    ));
    $wp_customize->add_control('sprint_featured_carousel', array(
        'label' => __('Show Footer featured', 'sprint'),
        'section' => 'sprint_footer_featured',
        'priority' => 10,
        'type' => 'checkbox',
    ));

    $wp_customize->remove_section('background_image');
}

add_action('customize_register', 'sprint_customize_register');

/**
 * Bind JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Notepad 1.0
 */
function sprint_customize_preview_js() {
    wp_enqueue_script('sprint_customizer', get_template_directory_uri() . '/js/customizer.js', array('customize-preview'), '20131205', true);
}

add_action('customize_preview_init', 'sprint_customize_preview_js');

/*
 * Sanitize Hex Color for 
 * Primary and Secondary Color options
 * 
 * @since Notepad 1.4
 */

function sprint_sanitize_hex_color($color) {
    if ($unhashed = sanitize_hex_color_no_hash($color)) {
        return '#' . $unhashed;
    }
    return $color;
}

/*
 * Sanitize Custom CSS 
 * 
 * @since Notepad 1.4
 */

function sprint_sanitize_custom_css($input) {
    $input = wp_kses_stripslashes($input);
    return $input;
}

/*
 * Escaping for input values
 * 
 * @since Notepad 1.4
 */

function sprint_sanitize_escaping($input) {
    $input = esc_attr($input);
    return $input;
}

/*
 * Sanitize layout options 
 * 
 * @since SmartShop 1.4
 */

function sprint_sanitize_layout_option($layout_option) {
    if (!in_array($layout_option, array('content-sidebar', 'sidebar-content'))) {
        $layout_option = 'content-sidebar';
    }

    return $layout_option;
}

/**
 * Change theme colors based on theme options from customizer.
 *
 * @since Notepad 1.0
 */
function sprint_color_style() {
    $primary_color = get_theme_mod('sprint_theme_primary_color');
    $link_color = get_theme_mod('sprint_theme_link_color');
    $linkhover_color = get_theme_mod('sprint_theme_linkhover_color');

    // If no custom options for text are set, let's bail
    if ($primary_color == '#ef7a7a' || $primary_color == '#EF7A7A') {
        return;
    }
    // If we get this far, we have custom styles.
    ?>
    <style type="text/css" id="sprint-colorscheme-css">

        #footercontainer,
        .pagination .page-numbers:hover,
        li span.current,
        li a:hover.page-numbers,
        button:hover,
        input:hover[type="button"],
        input:hover[type="reset"],
        input[type="submit"],
        .button:hover,
        .entry-content .button:hover,
        .main-navigation ul ul,
        .more-link,
        div.gform_wrapper .gform_footer input[type="submit"]
        {
            background: <?php echo $primary_color; ?> ;
        }

        ::selection,
        ::-webkit-selection,
        ::-moz-selection,
        .widget_search #searchsubmit
        {
            background:<?php echo $primary_color; ?> ;
            color:<?php echo $link_color; ?> ;
        }

        .more-link:hover,
        .entry-header .entry-title a:hover,
        .header-meta a:hover,
        .widget_search #searchsubmit:hover,
        div.gform_wrapper .gform_footer input[type="submit"]:hover
        {
            color:<?php echo $linkhover_color; ?> ; 
        }

        .site-title a,
        .sidebar a,
        .entry-header .entry-title a,
        .entry-header .entry-title,
        .entry-header h1 a:visited,
        .main-navigation ul a:hover,
        .main-navigation ul ul a:hover,
        .gform_wrapper .gfield_required,
        .gform_wrapper h3.gform_title,
        label .required,
        span.required{
            color:<?php echo $primary_color; ?> ;
        }

        .main-navigation ul ul a,
        .more-link,
        .main-navigation ul a{
            color:<?php echo $link_color; ?> ;
        }

    </style>
    <style type="text/css" id="sprint-custom-css">
    <?php echo trim(get_theme_mod('sprint_custom_css')); ?>
    </style>
        <?php
    }

    add_action('wp_head', 'sprint_color_style');


    