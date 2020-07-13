<?php
/**
 * seed functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package seed
 */

if( class_exists('Kirki') ) { include_once( dirname( __FILE__ ) . '/inc/kirki.php' );}

/* LAYOUT */
if (!isset($GLOBALS['s_header_m']))             {$GLOBALS['s_header_m']             = 'auto-show';}     // standard, fixed, auto-show
if (!isset($GLOBALS['s_header_d']))             {$GLOBALS['s_header_d']             = 'auto-show';}     // standard, fixed, auto-show
if (!isset($GLOBALS['s_header_action']))        {$GLOBALS['s_header_action']        = array('search');} // search, cart, none
if (!isset($GLOBALS['s_blog_layout']))          {$GLOBALS['s_blog_layout']          = 'full-width';}    // full-width, leftbar, rightbar
if (!isset($GLOBALS['s_blog_layout_single']))   {$GLOBALS['s_blog_layout_single']   = 'rightbar';}    // full-width, leftbar, rightbar
if (!isset($GLOBALS['s_blog_columns_m']))       {$GLOBALS['s_blog_columns_m']       = '1';}             // 1,2,3
if (!isset($GLOBALS['s_blog_columns_d']))       {$GLOBALS['s_blog_columns_d']       = '3';}             // 1,2,3,4,5,6
if (!isset($GLOBALS['s_blog_template']))        {$GLOBALS['s_blog_template']        = 'card';}          // list, card, hero, caption
if (!isset($GLOBALS['s_blog_profile']))         {$GLOBALS['s_blog_profile']         = 'disable';}        // disable, enable
if (!isset($GLOBALS['s_blog_archive_profile'])) {$GLOBALS['s_blog_archive_profile'] = 'enable';}        // disable, enable
if (!isset($GLOBALS['s_shop_layout']))          {$GLOBALS['s_shop_layout']          = 'full-width';}    // full-width, leftbar, rightbar
if (!isset($GLOBALS['s_shop_pagebuilder']))     {$GLOBALS['s_shop_pagebuilder']     = 'disable';}       // disable, enable
if (!isset($GLOBALS['s_logo_path']))            {$GLOBALS['s_logo_path']            = 'none';}          // theme folder relative path, such as img/logo.svg .
if (!isset($GLOBALS['s_logo_width']))           {$GLOBALS['s_logo_width']           = '200';}           // any number, use in Custom Logo
if (!isset($GLOBALS['s_logo_height']))          {$GLOBALS['s_logo_height']          = '100';}           // any number, use in Custom Logo
if (!isset($GLOBALS['s_thumb_width']))          {$GLOBALS['s_thumb_width']          = '350';}           // any number
if (!isset($GLOBALS['s_thumb_height']))         {$GLOBALS['s_thumb_height']         = '184';}           // any number
if (!isset($GLOBALS['s_thumb_crop']))           {$GLOBALS['s_thumb_crop']           = true;}            // true, false
if (!isset($GLOBALS['s_title_style']))          {$GLOBALS['s_title_style']          = 'banner';}        // minimal, banner

/* ADD-ON */
if (!isset($GLOBALS['s_cart_icon']))            {$GLOBALS['s_cart_icon']            = 'cart';}          // cart, cart-o, basket, basket-al, bag, bag-alt
if (!isset($GLOBALS['s_header_scroll']))        {$GLOBALS['s_header_scroll']        = '300';}           // 1-600 px scroll for header effect on home
if (!isset($GLOBALS['s_member_url']))           {$GLOBALS['s_member_url']           = '/my-account/';}  // none, url path such as: /my-account/
if (!isset($GLOBALS['s_member_label']))         {$GLOBALS['s_member_label']         = 'Member';}        // ex: Member, สมาชิก
if (!isset($GLOBALS['s_style_css']))            {$GLOBALS['s_style_css']            = 'disable';}       // disable, enable
if (!isset($GLOBALS['s_jquery']))               {$GLOBALS['s_jquery']               = 'disable';}       // disable, enable
if (!isset($GLOBALS['s_fontawesome']))          {$GLOBALS['s_fontawesome']          = 'disable';}       // disable, enable
if (!isset($GLOBALS['s_flickity']))             {$GLOBALS['s_flickity']             = 'enable';}        // disable, enable
if (!isset($GLOBALS['s_wp_comments']))          {$GLOBALS['s_wp_comments']          = 'disable';}       // disable, enable
if (!isset($GLOBALS['s_admin_bar']))            {$GLOBALS['s_admin_bar']            = 'show';}          // hide, show

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));

}

/* CHECK WOOCOMMERCE */
include_once ABSPATH . 'wp-admin/includes/plugin.php';
if (is_plugin_active('woocommerce/woocommerce.php')) {
    $GLOBALS['s_is_woo']       = true;
    $GLOBALS['s_member_url']   = '/my-account/';
} else {
    $GLOBALS['s_is_woo']       = false;
}

/* Admin Bar */
if ($GLOBALS['s_admin_bar'] == 'hide') {
    add_filter('show_admin_bar', '__return_false');
}

/**
 * Setup Theme
 */
if (!function_exists('seed_setup')) {
    function seed_setup() {
        load_theme_textdomain('seed', get_template_directory() . '/languages');
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('custom-logo', array(
            'width'       => $GLOBALS['s_logo_width'],
            'height'      => $GLOBALS['s_logo_height'],
            'flex-width'  => true,
            'flex-height' => true,
        ));
        add_theme_support('post-thumbnails');
        add_image_size( 'condo', 350, 350, true );
        set_post_thumbnail_size($GLOBALS['s_thumb_width'], $GLOBALS['s_thumb_height'], $GLOBALS['s_thumb_crop']);
        register_nav_menus(array(
            'primary' => esc_html__('Main Menu', 'seed'),
            'mobile'  => esc_html__('Mobile Menu', 'seed'),
        ));
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));
        add_theme_support('customize-selective-refresh-widgets');
        add_theme_support('align-wide');
    }
}
add_action('after_setup_theme', 'seed_setup');

function seed_content_width() {
    $GLOBALS['content_width'] = apply_filters('seed_content_width', 750);
}
add_action('after_setup_theme', 'seed_content_width', 0);

/**
 * Register widget area.
 */
function seed_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Right Sidebar', 'seed'),
        'id'            => 'rightbar',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ));
    register_sidebar(array(
        'name'          => esc_html__('Left Sidebar', 'seed'),
        'id'            => 'leftbar',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ));
    register_sidebar(array(
        'name'          => esc_html__('Shop Sidebar', 'seed'),
        'id'            => 'shopbar',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ));
    register_sidebar(array(
        'name'          => esc_html__('Home Banner', 'seed'),
        'id'            => 'home_banner',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ));
    register_sidebar(array(
        'name'          => esc_html__('Header Action', 'seed'),
        'id'            => 'action',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<!--',
        'after_title'   => '-->',
    ));
    register_sidebar(array(
        'name'          => esc_html__('Footbar', 'seed'),
        'id'            => 'footbar',
        'description'   => '',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

}
add_action('widgets_init', 'seed_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function seed_scripts() {

    // wp_enqueue_style('s-vanilla-js-dropdown', get_theme_file_uri('/vendor/vanilla-js-dropdown/vanilla-js-dropdown.css'), array(),'5.13.0');
    wp_enqueue_style('s-mobile', get_theme_file_uri('/css/mobile.css'), array(), filemtime(get_theme_file_path('/css/mobile.css')));
    wp_enqueue_style('s-desktop', get_theme_file_uri('/css/desktop.css'), array(), filemtime(get_theme_file_path('/css/desktop.css')), '(min-width: 992px)');

    if ($GLOBALS['s_style_css'] == 'enable') {
        wp_enqueue_style('s-style', get_stylesheet_uri());
    }

    if ($GLOBALS['s_is_woo']) {
        wp_enqueue_style('s-woo', get_theme_file_uri('/css/woo.css'), array(), filemtime(get_theme_file_path('/css/woo.css')));
    }

    if ($GLOBALS['s_fontawesome'] == 'enable') {
        wp_enqueue_style('s-fa', get_theme_file_uri('/fonts/fontawesome/css/all.min.css'), array(),'5.13.0');
    }
    
    if ($GLOBALS['s_flickity'] == 'enable') {
        wp_enqueue_script('s-fkt', get_theme_file_uri('/js/flickity.js'), array(), '2.2.1', true);
    }

    if(is_single() && get_post_type()=='project') {
        wp_enqueue_script('s-mobile-detect', get_theme_file_uri('/js/mobile-detect.min.js'), array(), '3.3.1', true);
        wp_enqueue_script('s-float-sidebar', get_theme_file_uri('/js/float-sidebar.min.js'), array(), '3.3.1', true);
    }

    wp_enqueue_script('s-scripts', get_theme_file_uri('/js/scripts.js'), array(), filemtime(get_theme_file_path('/js/scripts.js')), true);
    wp_enqueue_script('s-vanilla', get_theme_file_uri('/js/main-vanilla.js'), array(), filemtime(get_theme_file_path('/js/main-vanilla.js')), true);

    if(is_single() && get_post_type()=='project') {
        wp_enqueue_script('s-vanilla-js-dropdown', get_theme_file_uri('/vendor/vanilla-js-dropdown/vanilla-js-dropdown.min.js'), array(), '2.2.0', true);
        wp_enqueue_script('s-project', get_theme_file_uri('/js/project.js'), array(), filemtime(get_theme_file_path('/js/project.js')), true);
    }

    if (($GLOBALS['s_jquery'] == 'enable') || $GLOBALS['s_is_woo']) {
        wp_enqueue_script('s-jquery', get_theme_file_uri('/js/main-jquery.js'), array('jquery'), filemtime( get_theme_file_path('/js/main-jquery.js')), true);
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'seed_scripts');



/**
 * Admin CSS
 */
function seed_admin_style() {
    wp_enqueue_style('seed-admin-style', get_template_directory_uri() . '/css/wp-admin.css');
}
add_action('admin_enqueue_scripts', 'seed_admin_style');


/**
 * Remove "Category: ", "Tag: ", "Taxonomy: " from archive title
 */
add_filter('get_the_archive_title', 'seed_get_the_archive_title');
function seed_get_the_archive_title($title) {
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    } elseif (is_author()) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif (is_tax()) {
        $title = single_term_title('', false);
    }
    return $title;
}

/**
 * Custom WooCommerce Settings
 */
if ($GLOBALS['s_is_woo']) {
    require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Custom Shortcode
 */
require get_template_directory() . '/inc/shortcode.php';

/**
 * Redirect after login - Subscriber to home page.
 */
function seed_redirect_to_request( $redirect_to, $request, $user ) {
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        if ( in_array( 'subscriber', $user->roles ) ) {
            return home_url();
        } else {
            return $redirect_to;
        }
    } else {
        return $redirect_to;
    }
}
if($GLOBALS['s_member_url'] != 'none') {  
    add_filter('login_redirect', 'seed_redirect_to_request', 10, 3);
}


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {require get_template_directory() . '/inc/jetpack.php';}

/**
 * Smart Slider 3 Pro
 */
function plant_smartslider3_skip_license_modal() {
	return true;
}
add_filter('smartslider3_skip_license_modal', 'plant_smartslider3_skip_license_modal');

/**
 * Include Advanced Custom Fields
 */
define( 'S_ACF_PATH', get_template_directory() . '/vendor/acf/' );
define( 'S_ACF_URL', get_template_directory_uri() . '/vendor/acf/' );
include_once( S_ACF_PATH . 'acf.php' );
add_filter('acf/settings/url', 'seed_acf_settings_url');
function seed_acf_settings_url( $url ) {
    return S_ACF_URL;
}
/**
 * ACF Blocks
 */
require get_template_directory() . '/inc/blocks.php';

function seed_theme_updater() {
	require( get_template_directory() . '/vendor/seedthemes/updater/theme-updater.php' );
}
add_action( 'after_setup_theme', 'seed_theme_updater' );

/**
 * TGMPA
 */
require_once get_template_directory() . '/vendor/TGMPA/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'plant_register_required_plugins' );

function plant_register_required_plugins() {
	$plugins = array(
		array(
			'name'               => 'Kirki',
			'slug'               => 'kirki',
			'source'             => get_template_directory() . '/vendor/kirki/kirki.3.1.1.zip',
			'required'           => true,
			'version'            => '3.1.1',
			'force_activation'   => true,
			'force_deactivation' => false,
			'external_url'       => '',
			'is_callable'        => '',
		),
	);
	$config = array(
		'id'           => 'plant',                 
		'default_path' => '',                      
		'menu'         => 'tgmpa-install-plugins', 
		'parent_slug'  => 'themes.php',            
		'capability'   => 'edit_theme_options',   
		'has_notices'  => true,                    
		'dismissable'  => true,                    
		'dismiss_msg'  => '',                      
		'is_automatic' => true,                   
		'message'      => '',                      
	);
	tgmpa( $plugins, $config );
}

function risland_styles_method() {
    if(is_checkout()) {
        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                $projectId          = (int)get_field('project', $cart_item['product_id']);
                $color              = get_field('color', $projectId);
                $secondary_color    = get_field('secondary_color', $projectId);
            }
        }
    } else {
        $color              = get_field('color', get_the_ID());
        $secondary_color    = get_field('secondary_color', get_the_ID());
    }

    if(!empty($color)) {
        wp_register_style( 'color-custom-style', false );
        wp_enqueue_style( 'color-custom-style' );

        $custom_css = "
        .js-Dropdown-title {
            background: $color;
        }
        .js-Dropdown-list li {
            color: $color;
        }
        .js-Dropdown-list li.is-selected {
            background-color: $color;
        }
        .js-Dropdown-list li:hover {
            background-color: $secondary_color;
            color: #fff;
        }
        .js-Dropdown-title:after {
            border-color: #fff transparent transparent transparent;
        }
        .option-roomtype ul li:first-child {
            color: $color;
        }
        .floor-plan-gallery {
            background-color: $color;
        }
        #main .woocommerce-checkout {
            background-color: $color;
        }
        .total-price {
            color: $color;
        }
        .side-reserve .form-reserve .buttons .btn:hover {
            color: $color;
        }
        #main #payment .place-order .button {
            background-color: $color;
        }
        ";

        
        wp_add_inline_style( 'color-custom-style', $custom_css );
    }

    $font_color    = get_field('font_color', get_the_ID());

    if($font_color) {
        wp_register_style( 'font-color-custom-style', false );
        wp_enqueue_style( 'font-color-custom-style' );

        $custom_font_css = "
        .option-roomtype ul li a {
            color: $font_color;
        }
        .option-roomtype ul li a:hover {
            border-color: $font_color;
        }
        .option-roomtype ul li a.active {
            border-color: $font_color;
        }
        .option-roomtype ul li:first-child {
            color: $font_color;
        }
        .option-content {
            color: $font_color;
        }
        .js-Dropdown-title {
            background: #fff;
            color: $font_color;
        }
        .js-Dropdown-list li {
            color: $font_color;
        }
        .js-Dropdown-title:after {
            border-color: $font_color transparent transparent transparent;
        }
        .js-Dropdown-list li.is-selected {
            color: $font_color;
        }
        .js-Dropdown-list li:hover {
            color: $font_color;
        }
        .price-description .item.-promotion {
            color: $font_color;
        }
        .side-reserve {
            color: $font_color;
        }
        .side-reserve .reserve {
            border-bottom: 1px solid $font_color;
        }
        .side-reserve .reserve .title {
            color: $font_color;
        }
        .side-reserve .detail {
            color: $font_color;
        }
        .side-reserve .form-reserve .buttons .btn {
            border-color: $font_color;
            color: $font_color;
        }
        ";

        wp_add_inline_style( 'font-color-custom-style', $custom_font_css );
    }

}
add_action( 'wp_enqueue_scripts', 'risland_styles_method' );

add_action( 'rest_api_init', function () {
    register_rest_route( 'risland/v1', '/project/(?P<id>\d+)', array(
      'methods' => 'GET',
      'callback' => 'risland_get_project_unit',
    ) );
} );

function risland_get_project_unit( $data ) {

    foreach((array)$data as $key => $value) {
        if(!empty($value['GET'])) {
            foreach($value['GET'] as $dataKey => $dataValue) {
                if($dataKey == 'room_type') {
                    $roomType = $dataValue;
                }
                if($dataKey == 'room_size') {
                    $roomSize = $dataValue;
                }
                if($dataKey == 'floor') {
                    $floor = $dataValue;
                }
                if($dataKey == 'unit_id') {
                    $unitId = $dataValue;
                }
            }
        }
    }

    $args = array(
        'post_type'         => 'product',
        'meta_query'	    => array(
            'relation'		=> 'AND',
            array(
                'key'		=> 'project',
                'value'		=> (int)$data['id'],
                'compare'	=> '='
            ),
            // array(
            //     'key'		=> 'attendees',
            //     'value'		=> 100,
            //     'type'		=> 'NUMERIC',
            //     'compare'	=> '>'
            // )
        ),
        'posts_per_page'    => -1
        // 'tax_query' => array(
        //     array(
        //         'taxonomy' => 'people',
        //         'field'    => 'slug',
        //         'terms'    => 'bob',
        //     ),
        // ),
    );

    if(!empty($roomType)) {
        $roomTypeArgs = array(
            'taxonomy' => 'room_type',
            'field'    => 'term_id',
            'terms'    => (int)$roomType,
        );
    }
    if(!empty($roomSize)) {
        $roomSizeArgs = array(
            'taxonomy' => 'room_size',
            'field'    => 'term_id',
            'terms'    => (int)$roomSize,
        );
    }
    if(!empty($floor)) {
        $floorArgs = array(
            'taxonomy' => 'floor',
            'field'    => 'term_id',
            'terms'    => (int)$floor,
        );
    }

    $args['tax_query'] = array(
        'relation' => 'AND', $roomTypeArgs, $roomSizeArgs, $floorArgs
    );

    if(!empty($unitId)) {
        $args['p'] = (int)$unitId;
    }

    $query = new WC_Order_Query( array(
        // 'customer_id' => risland_get_user_id(),
        'limit'     => '-1',
        'status'    =>  ['wc-processing'],
        'orderby'   => 'date',
        'order'     => 'DESC',
        'return'    => 'ids',
    ) );
    $orders = $query->get_orders();

    foreach ($orders as $key => $value) {
        $order = wc_get_order( $value );
        $items = $order->get_items();

        foreach ( $items as $item ) {
            $order_success_product_id[] = $item->get_product_id();
        }
    }

    // var_dump($order_success_product_id);

    $args['post__not_in'] = $order_success_product_id;

    $query = new WP_Query( $args );

    // The Loop
    if ( $query->have_posts() ) {
        $i = 0;
        while ( $query->have_posts() ) {
            $query->the_post();

            unset($item);
            unset($items);

            $propertyType = get_field('property_type', (int)$data['id']);
            foreach ($propertyType as $key => $value) {
                $propertyId		= get_term($value)->term_id;
                $propertySlug	= get_term($value)->slug;
                $propertyName	= get_term($value)->name;
            }

            $return['property_type'][0]['id']      = $propertyId;
            $return['property_type'][0]['name']    = $propertyName;
            $return['property_type'][0]['slug']    = $propertySlug;

            $roomType = get_the_terms( get_the_id(), 'room_type' );
            unset($roomTypeData);
            $x = 0;
            foreach($roomType as $key => $value) {
                unset($roomTypeGroupItem);

                $roomTypeGroupItem['id']        = $value->term_id;
                $roomTypeGroupItem['name']      = $value->name;

                $roomTypeGroup[$value->term_id] = $roomTypeGroupItem;

                $roomTypeData[$x]['id']         = $value->term_id;
                $roomTypeData[$x]['name']       = $value->name;
                $x++;
            }

            $roomSize = get_the_terms( get_the_id(), 'room_size' );
            unset($roomSizeData);
            $x = 0;
            foreach($roomSize as $key => $value) {
                unset($roomSizeGroupItem);

                $roomSizeGroupItem['id']        = $value->term_id;
                $roomSizeGroupItem['name']      = $value->name;

                $roomSizeGroup[$value->term_id] = $roomSizeGroupItem;

                $roomSizeData[$x]['id']         = $value->term_id;
                $roomSizeData[$x]['name']       = $value->name;
                $x++;
            }

            $floor = get_the_terms( get_the_id(), 'floor' );
            unset($floorData);
            $x = 0;
            foreach($floor as $key => $value) {
                unset($floorGroupItem);

                $floorGroupItem['id']        = $value->term_id;
                $floorGroupItem['name']      = $value->name;

                $floorGroup[$value->term_id] = $floorGroupItem;

                $floorData[$x]['id']         = $value->term_id;
                $floorData[$x]['name']       = $value->name;
                $x++;
                // $floorData[$x]                  = (int)$value->name;
                // $floorGroup[(int)$value->name]  = (int)$value->name;
                // $x++;
            }

            $direction = get_the_terms( get_the_id(), 'direction' );
            unset($directionData);
            $x = 0;
            foreach($direction as $key => $value) {
                $directionData[$x]              = $value->name;
                $x++;
            }

            unset($perPeriodData);
            $y = 0;
            if( have_rows('per_period_price') ):
                while ( have_rows('per_period_price') ) : the_row();
                    // display a sub field value
                    $perPeriodData[$y]['name'] = get_sub_field('name');
                    $perPeriodData[$y]['price'] = get_sub_field('price');
                    $y++;
                endwhile;
           endif;

            $item['id']                     = get_the_id();
            $item['title']                  = get_the_title();
            $item['room_type']              = $roomTypeData;
            $item['room_size']              = $roomSizeData;
            $item['floor']                  = $floorData;
            $item['direction']              = $directionData;

            $product                        = wc_get_product( get_the_id() );
            $item['price']                  = (int)$product->get_price();
            $item['unit_price']             = (int)get_field('unit_price', get_the_id());
            if(get_field('floor_plan', get_the_id())) {
                $item['floor_plan']['id']   = get_field('floor_plan', get_the_id())['ID'];
                $item['floor_plan']['title']    = get_field('floor_plan', get_the_id())['title'];
                $item['floor_plan']['url']  = get_field('floor_plan', get_the_id())['url'];
            }
            $item['promotion']              = get_field('promotion', get_the_id());
            $item['reserve_price']          = (int)get_field('reserve_price', get_the_id());
            $item['contract']               = (int)get_field('contract', get_the_id());
            $item['deposit_price']          = (int)get_field('deposit_price', get_the_id());
            $item['deposit_period']         = (int)get_field('deposit_period', get_the_id());
            $item['transfer']               = (int)get_field('transfer', get_the_id());
            if(!empty($perPeriodData)) {
                $item['per_period']         = $perPeriodData;
            }
            // $item['per_period']          = get_field('per_period', get_the_id());

            // $return[$i]['room_type']     = get_field('room_type', get_the_id());

            // $return[$i]['room_type']     = get_the_terms( get_the_id(), 'room_type' );
            // echo '<li>' . get_the_title() . '</li>';

            $items[] = $item;

            $i++;
        }

        foreach($roomTypeGroup as $key => $value) {
            $return['room_types'][]     = $value;
            // $roomTypeGroupSort[]     = $value;
        }

        // usort($roomTypeGroupSort, function($a, $b) {
        //     return $a->id < $b->id ? 0 : -1;
        // });

        // $return['room_types'][]      = $roomTypeGroupSort;

        foreach($roomSizeGroup as $key => $value) {
            $return['room_sizes'][]     = $value;
        }

        foreach($floorGroup as $key => $value) {
            $return['floors'][]         = $value;
        }

        $return['items']                = $items;

        $return['status']               = 'success';
    } else {
    // no posts found
    }
    /* Restore original Post Data */
    wp_reset_postdata();

    // $posts = get_posts( array(
    //   'id' => $data['id'],
    // ) );
   
    if ( empty( $return ) ) {
        $return['status'] = 'no-product';
        return $return;
    }
   
    return $return;
}

function risland_get_user_id() {

    $user_id = apply_filters( 'determine_current_user', false );
    // wp_set_current_user( $user_id );

    return $user_id;
}

add_action('init', 'get_your_current_user_id');
function get_your_current_user_id(){
        $your_current_user_id = get_current_user_id();
        //do something here with it
}

add_filter( 'woocommerce_add_to_cart_validation', 'bbloomer_only_one_in_cart', 99, 2 );
   
function bbloomer_only_one_in_cart( $passed, $added_product_id ) {
   wc_empty_cart();
   return $passed;
}

// add_filter( 'woocommerce_add_to_cart_validation', 'remove_cart_item_before_add_to_cart', 20, 3 );
// function remove_cart_item_before_add_to_cart( $passed, $product_id, $quantity ) {
//     if( ! WC()->cart->is_empty() )
//         WC()->cart->empty_cart();
//     return $passed;
// }

add_action('template_redirect','check_if_logged_in');
function check_if_logged_in()
{
    $pageid = 20; // your checkout page id
    if(!is_user_logged_in() && is_page($pageid))
    {
        // $url = add_query_arg(
        //     'redirect_to',
        //     get_permalink($pagid),
        //     site_url('/my-account/') // your my acount url
        // );
        wp_redirect(site_url('/my-account/'));
        exit;
    }
}

function iconic_login_redirect($redirect) {
    global $woocommerce;
    if ( $woocommerce->cart->cart_contents_count > 0 ) {
        return wc_get_checkout_url();
    } else {
        return site_url();
    }
    // $redirect_page_id = url_to_postid( $redirect );
    // $checkout_page_id = wc_get_page_id( 'checkout' );
    
    // if( $redirect_page_id == $checkout_page_id ) {
    //     return $redirect;
    // }
 
    // return wc_get_page_permalink( 'shop' );
}
 
add_filter( 'woocommerce_login_redirect', 'iconic_login_redirect' );

// After registration, logout the user and redirect to home page
function custom_registration_redirect() {
    global $woocommerce;
    if ( $woocommerce->cart->cart_contents_count > 0 ) {
        return wc_get_checkout_url();
    } else {
        return home_url('/');
    }   
}
add_action('woocommerce_registration_redirect', 'custom_registration_redirect', 2);

add_filter( 'wpseo_breadcrumb_links', 'wpseo_breadcrumb_add_woo_shop_link' );

function wpseo_breadcrumb_add_woo_shop_link( $links ) {
    global $post;

    $propertyType = get_field('property_type', get_the_ID());
    if($propertyType) {
        foreach ($propertyType as $key => $value) {
            $propertyId		= get_term($value)->term_id;
            $propertySlug	= get_term($value)->slug;
            $propertyName	= get_term($value)->name;
        }
    }
    //get_permalink( woocommerce_get_page_id( 'shop' ) )

    if ( get_post_type() == 'project' ) {
        $breadcrumb[] = array(
            'url' => site_url() . '/' . $propertySlug,
            'text' => $propertyName,
        );

        array_splice( $links, 1, -2, $breadcrumb );
    }

    return $links;
}

add_filter( 'woocommerce_order_button_text', 'woo_custom_order_button_text' ); 

function woo_custom_order_button_text() {
    return __( 'จองเลย', 'woocommerce' ); 
}

add_filter( 'wc_order_statuses', 'wc_renaming_order_status' );
function wc_renaming_order_status( $order_statuses ) {
    foreach ( $order_statuses as $key => $status ) {
        if ( 'wc-processing' === $key ) 
            $order_statuses['wc-processing'] = _x( 'ชำระเงินแล้ว', 'Order status', 'woocommerce' );
    }
    return $order_statuses;
}

function risland_get_account_formatted_address( $address_type = 'billing', $customer_id = 0 ) {
    $getter  = "get_{$address_type}";
    $address = array();
  
    if ( 0 === $customer_id ) {
      $customer_id = get_current_user_id();
    }
  
    $customer = new WC_Customer( $customer_id );
  
    if ( is_callable( array( $customer, $getter ) ) ) {
      $address = $customer->$getter();
      unset( $address['email'], $address['tel'] );
    }
    
    $address['state'] = risland_states($address['state']);
  
    return WC()->countries->get_formatted_address( apply_filters( 'woocommerce_my_account_my_address_formatted_address', $address, $customer->get_id(), $address_type ) );
}

function risland_states($state_key) {
    $states['TH-81'] = 'กระบี่';
    $states['TH-10'] = 'กรุงเทพมหานคร';
    $states['TH-71'] = 'กาญจนบุรี';
    $states['TH-46'] = 'กาฬสินธุ์';
    $states['TH-62'] = 'กำแพงเพชร';
    $states['TH-40'] = 'ขอนแก่น';
    $states['TH-22'] = 'จันทบุรี';
    $states['TH-24'] = 'ฉะเชิงเทรา';
    $states['TH-20'] = 'ชลบุรี';
    $states['TH-18'] = 'ชัยนาท';
    $states['TH-36'] = 'ชัยภูมิ';
    $states['TH-86'] = 'ชุมพร';
    $states['TH-57'] = 'เชียงราย';
    $states['TH-50'] = 'เชียงใหม่';
    $states['TH-92'] = 'ตรัง';
    $states['TH-23'] = 'ตราด';
    $states['TH-63'] = 'ตาก';
    $states['TH-26'] = 'นครนายก';
    $states['TH-73'] = 'นครปฐม';
    $states['TH-48'] = 'นครพนม';
    $states['TH-30'] = 'นครราชสีมา';
    $states['TH-80'] = 'นครศรีธรรมราช';
    $states['TH-60'] = 'นครสวรรค์';
    $states['TH-12'] = 'นนทบุรี';
    $states['TH-96'] = 'นราธิวาส';
    $states['TH-55'] = 'น่าน';
    $states['TH-38'] = 'บึงกาฬ';
    $states['TH-31'] = 'บุรีรัมย์';
    $states['TH-13'] = 'ปทุมธานี';
    $states['TH-77'] = 'ประจวบคีรีขันธ์';
    $states['TH-25'] = 'ปราจีนบุรี';
    $states['TH-94'] = 'ปัตตานี';
    $states['TH-14'] = 'พระนครศรีอยุธยา';
    $states['TH-56'] = 'พะเยา';
    $states['TH-82'] = 'พังงา';
    $states['TH-93'] = 'พัทลุง';
    $states['TH-66'] = 'พิจิตร';
    $states['TH-65'] = 'พิษณุโลก';
    $states['TH-76'] = 'เพชรบุรี';
    $states['TH-67'] = 'เพชรบูรณ์';
    $states['TH-54'] = 'แพร่';
    $states['TH-83'] = 'ภูเก็ต';
    $states['TH-44'] = 'มหาสารคาม';
    $states['TH-49'] = 'มุกดาหาร';
    $states['TH-58'] = 'แม่ฮ่องสอน';
    $states['TH-35'] = 'ยโสธร';
    $states['TH-95'] = 'ยะลา';
    $states['TH-45'] = 'ร้อยเอ็ด';
    $states['TH-85'] = 'ระนอง';
    $states['TH-21'] = 'ระยอง';
    $states['TH-70'] = 'ราชบุรี';
    $states['TH-16'] = 'ลพบุรี';
    $states['TH-52'] = 'ลำปาง';
    $states['TH-51'] = 'ลำพูน';
    $states['TH-42'] = 'เลย';
    $states['TH-33'] = 'ศรีสะเกษ';
    $states['TH-47'] = 'สกลนคร';
    $states['TH-90'] = 'สงขลา';
    $states['TH-91'] = 'สตูล';
    $states['TH-11'] = 'สมุทรปราการ';
    $states['TH-75'] = 'สมุทรสงคราม';
    $states['TH-74'] = 'สมุทรสาคร';
    $states['TH-27'] = 'สระแก้ว';
    $states['TH-19'] = 'สระบุรี';
    $states['TH-17'] = 'สิงห์บุรี';
    $states['TH-64'] = 'สุโขทัย';
    $states['TH-72'] = 'สุพรรณบุรี';
    $states['TH-84'] = 'สุราษฎร์ธานี';
    $states['TH-32'] = 'สุรินทร์';
    $states['TH-43'] = 'หนองคาย';
    $states['TH-39'] = 'หนองบัวลำภู';
    $states['TH-15'] = 'อ่างทอง';
    $states['TH-37'] = 'อำนาจเจริญ';
    $states['TH-41'] = 'อุดรธานี';
    $states['TH-53'] = 'อุตรดิตถ์';
    $states['TH-61'] = 'อุทัยธานี';
    $states['TH-34'] = 'อุบลราชธานี';

	return $states[$state_key];
}

function filter_woocommerce_order_formatted_billing_address( $array, $int ) {
    $array['state'] = risland_states($array['state']);
    return $array;
};
         
// add the filter 
add_filter( 'woocommerce_order_formatted_billing_address', 'filter_woocommerce_order_formatted_billing_address', 10, 3 );

function risland_send_sms($order, $status) {

    if($status == 'success') {

        require 'sendMessageService.php';

        foreach ( $order->get_items() as $item_id => $item ) {
            $product_id     = $item->get_product_id();
            $variation_id   = $item->get_variation_id();
            $product        = $item->get_product();
            $name           = $item->get_name();
            $quantity       = $item->get_quantity();
            $subtotal       = $item->get_subtotal();
            $total          = $item->get_total();
            $tax            = $item->get_subtotal_tax();
            $taxclass       = $item->get_tax_class();
            $taxstat        = $item->get_tax_status();
            $allmeta        = $item->get_meta_data();
            // $somemeta = $item->get_meta( '_whatever', true );
            $type = $item->get_type();
        }

        $projectId = (int)get_field('project', $product_id);
        $projectName = get_the_title($projectId);

        $unitPrice = number_format((int)get_field('unit_price', $product_id));

        $total = $order->get_total();
        $strTotal = $total . ' บาท';

        // define account and password
        $account = 'post01@risland1';
        $password = '4D5AB7783DF2DD6A71651140D179ABD5C81420CEAABCE23E09301A479534014A';

        $mobile_no = $order->billing_phone;
        // or $mobile_no = '0830000000,0831111111';
        $message = "ทางบริษัทฯ ขอขอบคุณสำหรับการจองโครงการ$projectName ยูนิต $name ค่าเงินจองที่ชำระแล้ว $strTotal ติดต่อเจ้าหน้าที่ 020266888";
        $category = 'General';
        $sender_name = '';

        $results = SendMessageService::sendMessage($account, $password, $mobile_no, $message, '', $category, $sender_name);

        // use http proxy
        // $proxy = 'localhost:8888';
        // $proxy_userpwd = 'username:password';
        // $results = SendMessageService::sendMessage($account, $password, $mobile_no, $message, '', $category, $sender_name, $proxy, $proxy_userpwd);

        if ($results['result']) {
            // echo 'Send Success.'.' Task ID='.$results['task_id'].', Message ID='.$results['message_id'];
            $to = get_option('admin_email');
            $subject = 'Risland Online Send SMS Success!';
            $body = 'Send Success.'.' Task ID='.$results['task_id'].', Message ID='.$results['message_id'];
            $headers = array('Content-Type: text/html; charset=UTF-8','From: Risland Online &lt;noreply@risland.co.th');

            wp_mail( $to, $subject, $body, $headers );
        } else {
            // echo $results['error'];
            $to = get_option('admin_email');
            $subject = 'Risland Online Send SMS Error!';
            $body = $results['error'];
            $headers = array('Content-Type: text/html; charset=UTF-8','From: Risland Online &lt;noreply@risland.co.th');

            wp_mail( $to, $subject, $body, $headers );
        }

    }

}

// Hook in
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {

     $fields['billing']['billing_address_1'] = array(
        'label'         => __('เลขที่บ้าน/หมู่บ้าน/คอนโด', 'woocommerce'),
        'placeholder'   => _x('เลขที่บ้าน/หมู่บ้าน/คอนโด *', 'placeholder', 'woocommerce'),
        'required'      => true,
        'class'         => array('address-field', 'form-row-first'),
        // 'clear'     => false
     );

     $fields['billing']['billing_address_2'] = array(
        'label'         => __('แขวง', 'woocommerce'),
        'placeholder'   => _x('แขวง *', 'placeholder', 'woocommerce'),
        'required'      => true,
        'class'         => array('address-field', 'form-row-first'),
        // 'clear'     => false
     );

     $fields['billing']['billing_city'] = array(
        'label'         => __('เขต', 'woocommerce'),
        'placeholder'   => _x('เขต *', 'placeholder', 'woocommerce'),
        'required'      => true,
        'class'         => array('address-field', 'form-row-last'),
        // 'clear'     => false
     );

     $fields['billing']['billing_postcode'] = array(
        'label'         => __('รหัสไปรษณีย์', 'woocommerce'),
        'placeholder'   => _x('รหัสไปรษณีย์ *', 'placeholder', 'woocommerce'),
        'required'      => true,
        'class'         => array('address-field', 'form-row-first'),
        // 'clear'     => false
     );

     return $fields;
}

/**
 * Display field value on the order edit page
 */
 
// add_action( 'woocommerce_admin_order_data_after_shipping_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

// function my_custom_checkout_field_display_admin_order_meta($order){
//     echo '<p><strong>'.__('Phone From Checkout Form').':</strong> ' . get_post_meta( $order->get_id(), '_shipping_phone', true ) . '</p>';
// }

// function get_exclude_orders_project() {
//     $order = new WC_Order( $order_id );
//     $items = $order->get_items();

//     foreach ( $items as $item ) {
//         $product_name = $item['name'];
//         $product_id = $item['product_id'];
//         $product_variation_id = $item['variation_id'];
//     }

//     var_dump($product_name);
// }

// function fb_exclude_filter($query) {
//     // if ( !$query->is_admin && $query->is_feed) {
//         $query->set('post__not_in', array(62) ); // id of page or post
//     // }
//     return $query;
// }
// add_filter( 'pre_get_posts', 'fb_exclude_filter' );

// function my_logged_in_redirect() {

//     if (strpos($_SERVER['HTTP_REFERER'], 'https://accounts.google.com/signin/oauth/') !== false) {

//         if ( is_user_logged_in() && is_checkout() === false && is_account_page() === true ) {

//             global $woocommerce;
//             if ( $woocommerce->cart->cart_contents_count > 0 ) {
//                 wp_safe_redirect( wc_get_checkout_url() );
//                 die;
//             } else {
//                 wp_safe_redirect( site_url() );
//                 die;
//             }

//         }

//     }
     
// }
// add_action( 'template_redirect', 'my_logged_in_redirect' );