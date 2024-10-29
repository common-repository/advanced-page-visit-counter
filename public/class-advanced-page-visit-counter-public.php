<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://pagevisitcounter.com
 * @since      3.0.1
 *
 * @package    Advanced_Visit_Counter
 * @subpackage Advanced_Visit_Counter/public
 */
// Load the classes.
// use GeoIp2\Database\Reader;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Advanced_Visit_Counter
 * @subpackage Advanced_Visit_Counter/public
 * @author     Ankit Panchal <wptoolsdev@gmail.com>
 */
class Advanced_Visit_Counter_Public {

    /**
     * The ID of this plugin.
     *
     * @var      string $plugin_name The ID of this plugin.
     * @since    3.0.1
     * @access   private
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @var      string $version The current version of this plugin.
     * @since    3.0.1
     * @access   private
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of the plugin.
     * @param string $version The version of this plugin.
     *
     * @since    3.0.1
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version     = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    3.0.1
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Advanced_Visit_Counter_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Advanced_Visit_Counter_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        if ( apvc_fs()->is__premium_only() ) {
            wp_enqueue_style( 'apvc_icons_ui', plugin_dir_url( __FILE__ ) . 'css/simple-line-icons.css', [], $this->version, 'all' );
        }
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/advanced-page-visit-counter-public.css', [], $this->version, 'all' );

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    3.0.1
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Advanced_Visit_Counter_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Advanced_Visit_Counter_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/advanced-page-visit-counter-public.js', [ 'jquery' ], $this->version, FALSE );

        wp_localize_script( $this->plugin_name, 'apvc_rest',
            [
                'ap_rest_url' => get_rest_url(),
                'wp_rest'     => wp_create_nonce( "wp_rest" ),
                'ap_cpt'      => get_post_type(),
            ]
        );
    }

    public function avp_get_Browser( $is_rest = FALSE, $user_agent = "" ) {

        if ( $is_rest == TRUE ) {
            $user_agent = $user_agent;
        } else {
            $user_agent = sanitize_text_field($_SERVER['HTTP_USER_AGENT']);
        }
        $browser_name = 'Unknown';
        $platform     = 'Unknown';
        $version      = "";

        // $result = new WhichBrowser\Parser( $user_agent );

        return [
            'userAgent'        => $user_agent,
            'full_name'        => ( isset( $result->browser->name ) ) ? $result->browser->name : _x( 'Unknown', 'Browser', 'advanced-page-visit-counter' ),
            'short_name'       => ( isset( $result->browser->name ) ) ? $result->browser->name : _x( 'Unknown', 'Browser', 'advanced-page-visit-counter' ),
            'version'          => ( isset( $result->os->version->value ) ) ? $result->os->version->value : _x( 'Unknown', 'Version', 'advanced-page-visit-counter' ),
            'operation_system' => ( isset( $result->os->name ) ) ? $result->os->name : _x( 'Unknown', 'Platform', 'advanced-page-visit-counter' ),
            'device_type'      => ( isset( $result->device->type ) ) ? $result->device->type : _x( 'Unknown', 'Platform', 'advanced-page-visit-counter' ),

        ];
    }

    /**
     * Advanced Page Visit Counter Get referer url of the page
     *
     * @since    3.0.1
     */
    public function avp_get_HttpReferer() {
        $http_referer = isset( $_SERVER['HTTP_REFERER'] ) ? sanitize_text_field($_SERVER['HTTP_REFERER']) : '';

        return $http_referer;
    }

    /**
     * Advanced Page Visit Counter Checks current page is woocommerce template
     * page or not.
     *
     * @since    3.0.1
     */
    public function AVP_isWooCommercePage() {

        $woocommerce_keys = [
            "woocommerce_shop_page_id",
            "woocommerce_terms_page_id",
            "woocommerce_cart_page_id",
            "woocommerce_checkout_page_id",
            "woocommerce_pay_page_id",
            "woocommerce_thanks_page_id",
            "woocommerce_myaccount_page_id",
            "woocommerce_edit_address_page_id",
            "woocommerce_view_order_page_id",
            "woocommerce_change_password_page_id",
            "woocommerce_logout_page_id",
            "woocommerce_lost_password_page_id",
        ];
        foreach ( $woocommerce_keys as $wc_page_id ) {
            if ( get_the_ID() == get_option( $wc_page_id, 0 ) ) {
                return TRUE;
            }
        }

        return FALSE;
    }

    public function apvc_get_user_ip_address() {

        if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
            $ip = sanitize_text_field($_SERVER['HTTP_CLIENT_IP']);
        } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            $ip = sanitize_text_field($_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            $ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
        }
        if( '::1' === $ip ){
            $ip = getHostByName(getHostName());
        }
        return $ip;
    }

    public function apvc_register_rest_route() {

        register_rest_route( 'apvc/v1', '/update_visit', [
            'methods'             => \WP_REST_Server::READABLE,
            'permission_callback' => function () {
                return ( get_option( 'cache_active' ) == 'Yes' ? TRUE : FALSE );
            },
            'callback'            => [ $this, 'update_page_visit_stats_rest' ],
        ] );

    }


    public function update_page_visit_stats_rest( \WP_REST_Request $request ) {
        global $wpdb;

        $url        = sanitize_text_field($_GET['url']);
        $user_agent = sanitize_text_field($_GET['ua']);
        $referred   = sanitize_text_field($_GET['referred']);
        $ap_cpt     = sanitize_text_field($_GET['cpt']);

        $this->update_page_visit_stats( $url, $user_agent, $apvc_nonce, $referred, $ap_cpt, TRUE );
    }


    /**
     * Advanced Page Visit Counter Count Update
     *
     * @since    3.0.1
     * @update     5.0.3
     */
    public function update_page_visit_stats( $url = "", $user_agent = "", $apvc_nonce = "", $referred = "", $ap_cpt = "", $is_rest = FALSE ) {
        global $wpdb;

        if ( $is_rest == TRUE ) {
            $article_id = url_to_postid( $url );
        } else {
            $article_id = get_the_ID();
        }

        if ( is_admin() ) {
            return FALSE;
        }

        $active = get_post_meta( $article_id, "apvc_active_counter", TRUE );

        if ( $active == "No" ) {
            return FALSE;
        }

        $user          = wp_get_current_user();
        $currentUserID = $user->ID;
        $tbl_history   = APVC_DATA_TABLE;
        $avc_config    = (object) get_option( "apvc_configurations", TRUE );

        $date       = current_time( 'mysql' );
        $last_date  = current_time( 'mysql' );
        $ip_address = $this->apvc_get_user_ip_address();
        $locData    = $this->ip_info( $ip_address, 'location' );
        $country    = isset($locData['country']) ? $locData['country'] : '';
        
        if ( isset($avc_config->ip_anonymize[0]) && $avc_config->ip_anonymize[0] == 'on' ) {
            $ip_address = "***.***.***.***";
        }

        if ( $is_rest == TRUE ) {
            $browser = $this->avp_get_Browser( TRUE, $user_agent );
        } else {
            $browser = $this->avp_get_Browser();
        }

        if ( $is_rest == TRUE ) {
            $article_type = $ap_cpt;
        } else {
            $article_type = get_post_type();
        }

        $br_fullname  = $browser['full_name'];
        $br_shortname = ( $browser['short_name'] ) ? $browser['short_name'] : "-";
        $version      = $browser['version'];
        $os           = $browser['operation_system'];
        $site_id      = get_current_blog_id();

        if ( apvc_fs()->is__premium_only() ) {

            $crawlers_agents = (isset($avc_config->apvc_exclude_web_crawlers) ) ? implode( '|', $avc_config->apvc_exclude_web_crawlers ) : '';

            if ( $is_rest == TRUE ) {
                if ( strpos( $crawlers_agents, $user_agent ) === TRUE ) {
                    return FALSE;
                }
            } else {
                if ( strpos( $crawlers_agents, $_SERVER['HTTP_USER_AGENT'] ) === TRUE ) {
                    return FALSE;
                }
            }

            $exclude_countries = (isset($avc_config->apvc_exclude_by_country) ) ? $avc_config->apvc_exclude_by_country : [];
            if ( in_array( $country, $exclude_countries ) ) {
                return FALSE;
            }

            $exURoles = (isset($avc_config->apvc_exclude_count_user_roles) ) ? $avc_config->apvc_exclude_count_user_roles : [];
            if ( count( array_intersect( $user->roles, array_map( 'strtolower', $exURoles ) ) ) > 0 ) {
                return FALSE;
            }
        }

        if ( $is_rest == TRUE ) {
            $HttpReferer = $referred;
        } else {
            $HttpReferer = $this->avp_get_HttpReferer();
        }

        $HttpReferer = ( empty( $HttpReferer ) ) ? "Direct" : $HttpReferer;

        $user_id     = get_current_user_id();
        $device_type = $browser['device_type'];

        if ( is_user_logged_in() ) {
            $user_type = "Registered";
        } else {
            $user_type = "Guest";
        }

        $SpamControll = (isset($avc_config->apvc_spam_controller[0])) ? trim( $avc_config->apvc_spam_controller[0] ) : '';
        if ( $SpamControll == 'on' && ! empty( $article_id ) ) {
            $sPamtime       = $wpdb->get_var( "SELECT last_date FROM {$tbl_history} WHERE ip_address='$ip_address' AND article_id=$article_id ORDER BY last_date DESC" );
            $differenceTime = round( abs( strtotime( $date ) - strtotime( $sPamtime ) ) / 60, 2 );
        } else {
            $differenceTime = 10;
        }

        if ( $is_rest == TRUE ) {
            $currentPostType = $ap_cpt;
        } else {
            $currentPostType = get_post_type();
        }

        $ptypesTrack = [];
        if ( count( $avc_config->apvc_post_types ) == 0 || empty( $avc_config->apvc_post_types ) ) {
            $ptypesTrack = [ 'page', 'post' ];
        } else {
            $ptypesTrack = $avc_config->apvc_post_types;
        }
        if ( in_array( $currentPostType, $ptypesTrack ) ) {
            $ptExist = TRUE;
        } else {
            $ptExist = FALSE;
        }

        $allExUsers = [];
        if ( ! empty( $avc_config->apvc_exclude_users[0] ) ) {
            $tempUsrCnt = explode( ",", $avc_config->apvc_exclude_users[0] );
            foreach ( $tempUsrCnt as $exUsrCnt ):
                $allExUsers[] = $exUsrCnt;
            endforeach;
        }

        if ( $currentUserID != 0 ) {
            if ( in_array( $currentUserID, $allExUsers ) ) {
                $userExist = TRUE;
            } else {
                $userExist = FALSE;
            }
        } else {
            $userExist = FALSE;
        }
        $allIPs = [];
        if ( ! empty( $avc_config->apvc_ip_address[0] ) ) {
            $ips = explode( ",", $avc_config->apvc_ip_address[0] );
            foreach ( $ips as $ip ):

                $ttIP   = "";
                $tempIP = explode( ".", $ip );

                if ( is_array( $tempIP ) > 0 && strpos( $tempIP[3], "/" ) > 0 ) {

                    $ipRangeT = explode( "/", $tempIP[3] );
                    $ttIP     = $tempIP[0] . "." . $tempIP[1] . "." . $tempIP[2];
                    if ( count( $ipRangeT ) > 0 ) {
                        for ( $tCnt = $ipRangeT[0]; $tCnt <= $ipRangeT[1]; $tCnt ++ ) {
                            $allIPs[] = $ttIP . "." . $tCnt;
                        }
                    }

                } else if ( is_array( $tempIP ) > 0 && $tempIP[3] == "*" ) {

                    $ttIP = $tempIP[0] . "." . $tempIP[1] . "." . $tempIP[2];
                    for ( $tCnt = 0; $tCnt <= 255; $tCnt ++ ) {
                        $allIPs[] = $ttIP . "." . $tCnt;
                    }

                } else {

                    $allIPs[] = $ip;

                }

            endforeach;
        }

        if ( in_array( $ip_address, $allIPs ) ) {
            $ipExist = TRUE;
        } else {
            $ipExist = FALSE;
        }

        $allEXCounts = [];
        if ( ! empty( $avc_config->apvc_exclude_counts[0] ) ) {
            $tempCount = explode( ",", $avc_config->apvc_exclude_counts[0] );
            foreach ( $tempCount as $exCnt ):
                $allEXCounts[] = $exCnt;
            endforeach;
        }

        $excludeArticles = $allEXCounts;

        if ( $differenceTime > 5 && $ipExist == FALSE && $userExist == FALSE && $ptExist == TRUE && ! in_array( $article_id, $excludeArticles ) ) {

            if ( $this->AVP_isWooCommercePage() == TRUE && class_exists( 'WooCommerce' ) ) {

                if ( ! empty( $article_id ) ) {

                    if ( is_singular( 'product' ) ) {

                        $last_id = $wpdb->insert( $tbl_history, [
                            'article_id'         => $article_id,
                            'date'               => $date,
                            'last_date'          => $last_date,
                            'article_type'       => 'product',
                            'user_type'          => $user_type,
                            'device_type'        => $device_type,
                            'ip_address'         => $ip_address,
                            'user_id'            => $user_id,
                            'browser_full_name'  => $br_fullname,
                            'browser_short_name' => $br_shortname,
                            'browser_version'    => $version,
                            'operating_system'   => $os,
                            'http_referer'       => $HttpReferer,
                            'site_id'            => $site_id,
                            'flag'               => 1,
                            'country'            => $country,
                        ], [
                            '%d',
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                            '%d',
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                            '%d',
                            '%d',
                            '%s',
                        ] );
                        $last_id = $wpdb->insert_id;
                    } else {

                        $last_id = $wpdb->insert( $tbl_history, [
                            'article_id'         => $article_id,
                            'date'               => $date,
                            'last_date'          => $last_date,
                            'article_type'       => 'cart',
                            'user_type'          => $user_type,
                            'device_type'        => $device_type,
                            'ip_address'         => $ip_address,
                            'user_id'            => $user_id,
                            'browser_full_name'  => $br_fullname,
                            'browser_short_name' => $br_shortname,
                            'browser_version'    => $version,
                            'operating_system'   => $os,
                            'http_referer'       => $HttpReferer,
                            'site_id'            => $site_id,
                            'flag'               => 1,
                            'country'            => $country,
                        ], [
                            '%d',
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                            '%d',
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                            '%d',
                            '%d',
                            '%s',
                        ] );
                        $last_id = $wpdb->insert_id;
                    }
                }
            } else {

                if ( ! empty( $article_id ) ) {
                    $last_id = $wpdb->insert( $tbl_history, [
                        'article_id'         => $article_id,
                        'date'               => $date,
                        'last_date'          => $last_date,
                        'article_type'       => $article_type,
                        'user_type'          => $user_type,
                        'device_type'        => $device_type,
                        'ip_address'         => $ip_address,
                        'user_id'            => $user_id,
                        'browser_full_name'  => $br_fullname,
                        'browser_short_name' => $br_shortname,
                        'browser_version'    => $version,
                        'operating_system'   => $os,
                        'http_referer'       => $HttpReferer,
                        'site_id'            => $site_id,
                        'country'            => $country,
                    ], [
                        '%d',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%d',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%d',
                        '%s',
                    ] );
                    $last_id = $wpdb->insert_id;
                }
            }
        }
        $differenceTime = 0;
        if ( apvc_fs()->is__premium_only() && isset($last_id) && $last_id != "" ) {

            $realtime_users = $wpdb->prefix . "apvc_realtime_users";
            $wpdb->insert( $realtime_users, [
                'ref_id'     => $article_id,
                'date'       => date( 'Y-m-d H:i:s' ),
                'time'       => date( "H:i" ),
                'ip_address' => $ip_address,
                "country"    => $country,
            ], [ '%d', '%s', '%s', '%s', '%s' ] );

            $user_loc = $wpdb->prefix . "apvc_user_locations";
            $wpdb->insert( $user_loc,
                [
                    'ent_id'         => $last_id,
                    'city'           => isset($locData['city']) ? $locData['city'] : '',
                    'state'          => isset($locData['state']) ? $locData['state'] : '',
                    "country"        => isset($locData['country']) ? $locData['country'] : '',
                    "country_code"   => isset($locData['country_code']) ? $locData['country_code'] : '',
                    "continent"      => isset($locData['continent']) ? $locData['continent'] : '',
                    "continent_code" => isset($locData['continent_code']) ? $locData['continent_code'] : '',
                ], [ '%d', '%s', '%s', '%s', '%s', '%s', '%s' ] );
        }
    }


    public function ip_info( $ip = NULL, $purpose = "location", $deep_detect = TRUE ) {
        $output = NULL;

        if ( filter_var( $ip, FILTER_VALIDATE_IP ) === FALSE ) {
            if ( $deep_detect ) {
                if ( filter_var( @$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP ) ) {
                    $ip = sanitize_text_field($_SERVER['HTTP_X_FORWARDED_FOR']);
                }
                if ( filter_var( @$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP ) ) {
                    $ip = sanitize_text_field($_SERVER['HTTP_CLIENT_IP']);
                }
            }
        }
        $purpose    = str_replace( [
            "name",
            "\n",
            "\t",
            " ",
            "-",
            "_",
        ], NULL, strtolower( trim( $purpose ) ) );
        $support    = [
            "country",
            "countrycode",
            "state",
            "region",
            "city",
            "location",
            "address",
        ];
        $continents = [
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America",
        ];
        if ( filter_var( $ip, FILTER_VALIDATE_IP ) && in_array( $purpose, $support ) ) {
                
            $response = wp_remote_get('https://geolocation-db.com/json');
            $ipdat = @json_decode( wp_remote_retrieve_body($response) );

            if ( @strlen( trim( $ipdat->country_code ) ) == 2 ) {
                switch ( $purpose ) {
                    case "location":
                        $output = [
                            "city"           => @$ipdat->city,
                            "state"          => @$ipdat->state,
                            "country"        => @$ipdat->country_name,
                            "country_code"   => @$ipdat->country_code,
                            "continent"      => '-',
                            "continent_code" => '-',
                        ];
                        break;
                    default:
                        $output = '';
                        break;
                }
            }
        }
        return $output;
    }


    public function apvc_get_html_with_icon( $class ) {
        return '<div class="' . $class . '" {inline_style}><div>{current_visits_label}{current_visits_counts}</div><div>{today_visits_label}{today_visits_counts}</div><div>{total_visits_label}{total_visits_counts}</div></div>';
    }

    public function apvc_get_html_without_icon( $class ) {
        return '<div class="' . $class . '" {inline_style}><div>{current_visits_label}{current_visits_counts}</div><div>{today_visits_label}{today_visits_counts}</div><div>{total_visits_label}{total_visits_counts}</div></div>';
    }


    /* THIS IS SHORTCODE METHOD*/
    public function public_avc_visit_counter( $atts = [], $content = NULL, $tag = '' ) {
        global $wpdb;

        $tbl_history = APVC_DATA_TABLE;
        $atts        = array_change_key_case( (array) $atts, CASE_LOWER );

        if ( $atts['current'] == "false" && $atts['today'] == "false" && $atts['global'] == "false" ) {
            return FALSE;
        }

        if ( apvc_fs()->is__premium_only() ) {
            $avcConfig = (object) get_option( "apvc_configurations", TRUE );
            if ( $avcConfig->apvc_show_hide_shortcodes[0] == 'on' ) {
                return FALSE;
            }
        }

        $type = $atts['type'];
        if ( isset( $atts['article_id'] ) ) {
            $article_id = $atts['article_id'];
        }

        if ( $atts['type'] !== 'individual' ) {
            if ( is_admin() ) {
                $article_id = 1;
            }
        }
        if ( $atts['type'] == 'individual' ) {
            $article_id = $atts['article_id'];
        } else {
            $article_id = 1;
        }

        if ( $type == 'individual' && ! empty( $article_id ) ) {
            $pageCnt = $wpdb->get_var( "SELECT COUNT(*) FROM {$tbl_history} WHERE article_id=$article_id" );

        } else if ( $type == 'global' ) {
            $pageCnt = $wpdb->get_var( "SELECT COUNT(*) FROM {$tbl_history} WHERE `article_id` != '';" );
        } else {
            if ( is_admin() ) {
                $article_id = 1;
            } else {
                $article_id = get_the_ID();
            }
            $pageCnt = $wpdb->get_var( "SELECT COUNT(*) FROM {$tbl_history} WHERE article_id=$article_id" );
        }

        $active = get_post_meta( $article_id, "apvc_active_counter", TRUE );
        if ( $active == "No" ) {
            return FALSE;
        }

        $borderSize   = ( ! empty( $atts['border_size'] ) ) ? $atts['border_size'] : 0;
        $borderRadius = ( ! empty( $atts['border_radius'] ) ) ? 'border-radius:' . $atts['border_radius'] . 'px;' : '';
        $borderStyle  = ( ! empty( $atts['border_style'] ) ) ? $atts['border_style'] : 'solid';
        $borderColor  = ( ! empty( $atts['border_color'] ) ) ? $atts['border_color'] : '#000000';

        if ( $borderSize != 0 ) {
            $borderCSS = "border: " . $borderSize . "px " . $borderStyle . " " . $borderColor . ";";
        } else {
            $borderCSS = '';
        }

        $bgColor   = ( ! empty( $atts['background_color'] ) ) ? 'background-color: ' . $atts['background_color'] . ';' : '';
        $font_size = ( ! empty( $atts['font_size'] ) ) ? 'font-size: ' . $atts['font_size'] . 'px;' : '';
        if ( $atts['font_style'] == 'italic' ) {
            $font_style = ( ! empty( $atts['font_style'] ) ) ? 'font-style: ' . $atts['font_style'] . ';' : '';
        } else {
            $font_style = ( ! empty( $atts['font_style'] ) ) ? 'font-weight: ' . $atts['font_style'] . ';' : '';
        }
        $font_color = ( ! empty( $atts['font_color'] ) ) ? 'color:' . $atts['font_color'] . ';' : '';
        $padding    = ( ! empty( $atts['padding'] ) ) ? 'padding:' . $atts['padding'] . 'px;' : '';

        $counter_label    = ( empty( $atts['counter_label'] ) ) ? " Visits: " : $atts['counter_label'];
        $today_cnt_label  = ( empty( $atts['today_cnt_label'] ) ? $counter_label : $atts['today_cnt_label'] );
        $global_cnt_label = ( empty( $atts['global_cnt_label'] ) ? $counter_label : $atts['global_cnt_label'] );

        $widget_label = get_post_meta( get_the_ID(), "widget_label", TRUE );
        if ( empty( $widget_label ) ) {
            $widget_label = $counter_label;
        }

        $base_count = get_post_meta( $article_id, "count_start_from", TRUE );
        if ( ! empty( $base_count ) && $base_count > 0 ) {
            $pageCnt = $pageCnt + $base_count;
        }

        if ( ! isset( $atts['current'] ) ) {
            $pageCnt = $widget_label . " " . $this->apvc_number_format( $pageCnt );
        } else if ( $atts['current'] == "true" ) {
            $pageCnt = $widget_label . " " . $this->apvc_number_format( $pageCnt );
        } else {
            $pageCnt = '';
        }

        $todayDate = date( 'Y-m-d' );
        if ( $atts['today'] == "true" ) {
            $TodaypageCnt = $wpdb->get_var( "SELECT COUNT(*) FROM {$tbl_history} WHERE article_id=$article_id AND (`date` > DATE_SUB(now(), INTERVAL 1 DAY))" );
            $todaysCount  = $today_cnt_label . " " . $this->apvc_number_format( $TodaypageCnt );
        } else {
            $todaysCount = "";
        }

        $existingAllCounts = $wpdb->get_var( "SELECT SUM(meta_value) FROM $wpdb->postmeta where meta_key='count_start_from'" );

        if ( $atts['global'] == "true" ) {
            $allTime      = $wpdb->get_var( "SELECT COUNT(*) FROM {$tbl_history}" );
            $allTimeCount = $global_cnt_label . " " . $this->apvc_number_format( ( $allTime + $existingAllCounts ) );
        } else {
            $allTimeCount = "";
        }

        if ( ! empty( $atts['width'] ) ) {
            $shWidth = " width: 100%; max-width:" . $atts['width'] . "px; margin: 0 auto;";
        } else {
            $shWidth = "";
        }

        $wid_templated = $atts['widget_template'];

        if ( $wid_templated != 'None' && ! empty( $wid_templated ) ) {

            $shortcodeData = json_decode( $this->apvc_get_shortcodes( $wid_templated ) );
            if ( $shortcodeData->icon == 'yes' ) {
                $shHTML = $this->apvc_get_html_with_icon( $wid_templated );
            } else {
                $shHTML = $this->apvc_get_html_without_icon( $wid_templated );
            }

            $crReplace = '<div>{current_visits_label}{current_visits_counts}</div>';
            $tdReplace = '<div>{today_visits_label}{today_visits_counts}</div>';
            $glReplace = '<div>{total_visits_label}{total_visits_counts}</div>';

            $iconCR = $iconGL = $iconTD = '';
            if ( apvc_fs()->is__premium_only() ) {
                $iconCR = ( $atts['iconcr'] ) ? '<i class="' . $atts['iconcr'] . '"></i>' : '';
                $iconGL = ( $atts['icongl'] ) ? '<i class="' . $atts['icongl'] . '"></i>' : '';
                $iconTD = ( $atts['icontd'] ) ? '<i class="' . $atts['icontd'] . '"></i>' : '';

                if ( $atts['icon_position'] == 'Left' ) {
                    if ( $atts['current'] == "false" ) {
                        $shHTML = str_replace( $crReplace, "", $shHTML );
                    } else {
                        $shHTML = str_replace( $crReplace, '<div>' . $iconCR . " " . $pageCnt . '</div>', $shHTML );
                    }

                    if ( $atts['today'] == "false" ) {
                        $shHTML = str_replace( $tdReplace, "", $shHTML );
                    } else {
                        $shHTML = str_replace( $tdReplace, '<div>' . $iconTD . " " . $todaysCount . '</div>', $shHTML );
                    }

                    if ( $atts['global'] == "false" ) {
                        $shHTML = str_replace( $glReplace, "", $shHTML );
                    } else {
                        $shHTML = str_replace( $glReplace, '<div>' . $iconGL . " " . $allTimeCount . '</div>', $shHTML );
                    }

                } else {
                    if ( $atts['current'] == "false" ) {
                        $shHTML = str_replace( $crReplace, "", $shHTML );
                    } else {
                        $shHTML = str_replace( $crReplace, '<div>' . $pageCnt . ' ' . $iconCR . '</div>', $shHTML );
                    }

                    if ( $atts['today'] == "false" ) {
                        $shHTML = str_replace( $tdReplace, "", $shHTML );
                    } else {
                        $shHTML = str_replace( $tdReplace, '<div>' . $todaysCount . ' ' . $iconTD . '</div>', $shHTML );
                    }

                    if ( $atts['global'] == "false" ) {
                        $shHTML = str_replace( $glReplace, "", $shHTML );
                    } else {
                        $shHTML = str_replace( $glReplace, '<div>' . $allTimeCount . ' ' . $iconGL . '</div>', $shHTML );
                    }
                }
                $shHTML = str_replace( "{inline_style}", 'style="' . $shWidth . $padding . '; margin-bottom :15px; color:' . $avcConfig->apvc_default_text_color[0] . '"', $shHTML );
            } else {

                if ( ! empty( $pageCnt ) ) {
                    $shHTML = str_replace( $crReplace, '<div>' . $pageCnt . '</div>', $shHTML );
                } else {
                    $shHTML = str_replace( $crReplace, '', $shHTML );
                }
                if ( ! empty( $todaysCount ) ) {
                    $shHTML = str_replace( $tdReplace, '<div>' . $todaysCount . '</div>', $shHTML );
                } else {
                    $shHTML = str_replace( $tdReplace, '', $shHTML );
                }
                if ( ! empty( $allTimeCount ) ) {
                    $shHTML = str_replace( $glReplace, '<div>' . $allTimeCount . '</div>', $shHTML );
                } else {
                    $shHTML = str_replace( $glReplace, '', $shHTML );
                }
                $shHTML = str_replace( "{inline_style}", 'style="' . $shWidth . $padding . '; margin-bottom :15px;"', $shHTML );
            }
            $shHTML = '<style type="text/css">' . $shortcodeData->css . '</style>' . $shHTML;

        } else {

            if ( apvc_fs()->is__premium_only() ) {

                $iconHtml = $iconGL = $iconTD = '';
                if ( ! empty( $atts['iconcr'] ) ) {
                    $iconHtml = ' <i style="margin:5px; vertical-align:middle;" class="' . $atts['iconcr'] . '"></i> ';
                }
                if ( ! empty( $atts['icongl'] ) ) {
                    $iconGL = ' <i style="margin:5px; vertical-align:middle;" class="' . $atts['icongl'] . '"></i> ';
                }
                if ( ! empty( $atts['icontd'] ) ) {
                    $iconTD = ' <i style="margin:5px; vertical-align:middle;" class="' . $atts['icontd'] . '"></i> ';
                }

                if ( $atts['icon_position'] == 'Left' ) {
                    $html = "<div class='avc_visit_counter_front' style='" . $borderCSS . $bgColor . $borderRadius . $font_size . $font_style . $font_color . "" . $shWidth . "" . $padding . "'>" . $iconHtml . " " . $pageCnt . " " . $iconTD . " " . $todaysCount . " " . $iconGL . " " . $allTimeCount . "</div>";
                } else {
                    $html = "<div class='avc_visit_counter_front' style='" . $borderCSS . $bgColor . $borderRadius . $font_size . $font_style . $font_color . "" . $shWidth . "" . $padding . "'>" . $pageCnt . " " . $iconHtml . " " . $todaysCount . " " . $iconTD . " " . $allTimeCount . " " . $iconGL . "</div>";
                }
            } else {
                $html = "<div class='avc_visit_counter_front' style='" . $borderCSS . $bgColor . $borderRadius . $font_size . $font_style . $font_color . "" . $shWidth . "" . $padding . "'>" . $pageCnt . " " . $todaysCount . " " . $allTimeCount . "</div>";
            }

        }

        return $shHTML . $html;

    }

    public function public_add_counter_to_content( $content ) {
        global $wpdb;
        global $post;

        $tbl_history     = APVC_DATA_TABLE;
        $currentPostType = get_post_type();
        $article_id      = get_the_ID();

        $avcConfig = (object) get_option( "apvc_configurations", TRUE );
        $active    = get_post_meta( $article_id, "apvc_active_counter", TRUE );

        if ( $active == "No" ) {
            return $content;
        }

        if ( apvc_fs()->is__premium_only() ) {

            $user = wp_get_current_user();

            if ( is_user_logged_in() ) {
                $uStatus = 'Registered';
            } else {
                $uStatus = 'Guest';
            }
            if( isset($avcConfig->apvc_exclude_by_user_type) ) {
                if ( in_array( $uStatus, $avcConfig->apvc_exclude_by_user_type ) ) {
                    return $content;
                }
            }
            $exURoles = (isset($avcConfig->apvc_exclude_by_user_roles) ) ? $avcConfig->apvc_exclude_by_user_roles : [];
            if ( count( array_intersect( $user->roles, array_map( 'strtolower', $exURoles ) ) ) > 0 ) {
                return $content;
            }
        }

        $exShowCnt = [];
        if ( ! empty( $avcConfig->apvc_exclude_show_counter[0] ) ) {
            $tempCntShow = explode( ",", $avcConfig->apvc_exclude_show_counter[0] );
            foreach ( $tempCntShow as $exShow ):
                $exShowCnt[] = $exShow;
            endforeach;
        }

        if ( isset($avcConfig->apvc_atc_page_count[0]) && $avcConfig->apvc_atc_page_count[0] == "" && isset($avcConfig->apvc_show_global_count[0]) && $avcConfig->apvc_show_global_count[0] == "" && isset($avcConfig->apvc_show_today_count[0]) && $avcConfig->apvc_show_today_count[0] == "" ) {
            return $content;
        }

        if ( is_array( $avcConfig->apvc_post_types ) && in_array( $currentPostType, $avcConfig->apvc_post_types ) && ! is_feed() && ! is_home() && ! in_array( $article_id, $exShowCnt ) && $this->AVP_isWooCommercePage() != 1 && isset($avcConfig->apvc_show_conter_on_front_side[0]) && $avcConfig->apvc_show_conter_on_front_side[0] != "disable" ) {

            $widget_label = get_post_meta( $article_id, "widget_label", TRUE );
            if ( ! empty( $widget_label ) ) {
                $label = $widget_label;
            } else {
                $label = ( $avcConfig->apvc_default_label[0] ) ? $avcConfig->apvc_default_label[0] : "";
            }

            $TodaySlabel = ( $avcConfig->apvc_todays_label[0] ) ? $avcConfig->apvc_todays_label[0] : $label;

            $Globallabel = ( $avcConfig->apvc_global_label[0] ) ? $avcConfig->apvc_global_label[0] : $label;

            $bgColorBox = ( $avcConfig->apvc_default_background_color[0] ) ? $avcConfig->apvc_default_background_color[0] : "#FFF";

            $article_id = $post->ID;
            $pageCnt    = $wpdb->get_var( "SELECT COUNT(*) FROM {$tbl_history} WHERE article_id=$article_id" );

            $widAlignment = ( isset( $avcConfig->apvc_wid_alignment[0] ) ) ? $avcConfig->apvc_wid_alignment[0] : "";

            if ( $widAlignment == "center" ) {
                $widAlignmentCss = "margin: 0px auto;";
            } else if ( $widAlignment == "right" ) {
                $widAlignmentCss = "float: right;";
            } else {
                $widAlignmentCss = "float: left;";
            }

            $widget_width = $avcConfig->apvc_widget_width[0];

            if ( ! empty( $widget_width ) ) {
                $widget_width = " width: 100%; max-width: " . $widget_width . "px;";
            } else {
                $widget_width = " width: auto;";
            }

            if ( apvc_fs()->is__premium_only() ) {
                $icon         = $avcConfig->apvc_cr_counter_icon[0];
                $iconPosition = $avcConfig->apvc_icon_position[0];

                if ( ! empty( $icon ) && ! empty( $iconPosition ) && $icon != 'None' && $avcConfig->apvc_atc_page_count[0] == "on" ) {
                    $iconHtml = '<i class="' . $icon . '"></i>';
                } else {
                    if ( $avcConfig->apvc_atc_page_count[0] == "on" ) {
                        $iconHtml = " | ";
                    } else {
                        $iconHtml = '';
                    }
                }

                $iconGL         = $avcConfig->apvc_global_counter_icon[0];
                $iconPositionGL = $avcConfig->apvc_icon_position[0];

                if ( ! empty( $iconGL ) && ! empty( $iconPositionGL ) && $iconGL != 'None' && $avcConfig->apvc_show_global_count[0] == "on" ) {
                    $iconHtmlGL = '<i class="' . $iconGL . '"></i>';
                } else {
                    if ( $avcConfig->apvc_show_global_count[0] == "on" ) {
                        $iconHtmlGL = " ";
                    } else {
                        $iconHtmlGL = '';
                    }
                }

                $iconTD         = $avcConfig->apvc_today_counter_icon[0];
                $iconPositionTD = $avcConfig->apvc_icon_position[0];

                if ( ! empty( $iconTD ) && ! empty( $iconPositionTD ) && $iconTD != 'None' && $avcConfig->apvc_show_today_count[0] == "on" ) {
                    $iconHtmlTD = '<i class="' . $iconTD . '"></i>';
                } else {
                    if ( $avcConfig->apvc_show_today_count[0] == "on" ) {
                        $iconHtmlTD = " | ";
                    } else {
                        $iconHtmlTD = '';
                    }
                }
            }

            $padding = $avcConfig->apvc_widget_padding[0];
            if ( ! empty( $padding ) ) {
                $padding = " padding: " . $padding . "px;";
            } else {
                $padding = " padding: 5px";
            }

            if ( $avcConfig->apvc_show_today_count[0] == "on" ) {
                $TodaypageCnt = $wpdb->get_var( "SELECT COUNT(*) FROM {$tbl_history} WHERE article_id=$article_id AND (`date` > DATE_SUB(now(), INTERVAL 1 DAY))" );
                $todaysCount  = " " . $TodaySlabel . " " . $TodaypageCnt;
            } else {
                $todaysCount = "";
            }

            $existingAllCounts = $wpdb->get_var( "SELECT SUM(meta_value) FROM $wpdb->postmeta where meta_key='count_start_from' AND meta_value != ''" );

            if ( $avcConfig->apvc_show_global_count[0] == "on" ) {
                $allTime      = $wpdb->get_var( "SELECT COUNT(*) FROM {$tbl_history}" );
                $allTimeCount = " " . $Globallabel . " " . ( $allTime + $existingAllCounts );
            } else {
                $allTimeCount = "";
            }

            $style = 'style="' . $widget_width . ' border: ' . $avcConfig->apvc_default_border_width[0] . 'px solid ' . $avcConfig->apvc_default_border_color[0] . '; color:' . $avcConfig->apvc_default_text_color[0] . '; background-color:' . $bgColorBox . '; border-radius: ' . $avcConfig->apvc_default_border_radius[0] . 'px; ' . $widAlignmentCss . $padding . '"';

            $base_count = get_post_meta( $article_id, "count_start_from", TRUE );
            if ( ! empty( $base_count ) && $base_count > 0 ) {
                $pageCnt = $pageCnt + $base_count;
            }

            if ( $avcConfig->apvc_atc_page_count[0] == "on" ) {
                $pageCnt = __( $label ) . $pageCnt;
            } else {
                $pageCnt = "";
            }

            $wid_templated = $avcConfig->apvc_widget_template[0];
            $iconcr        = $avcConfig->apvc_cr_counter_icon[0];
            $icontd        = $avcConfig->apvc_today_counter_icon[0];
            $icongl        = $avcConfig->apvc_global_counter_icon[0];

            if ( $wid_templated != 'None' && ! empty( $wid_templated ) ) {
                $shortcodeData = json_decode( $this->apvc_get_shortcodes( $wid_templated ) );
                if ( $shortcodeData->icon == 'yes' ) {
                    $shHTML = $this->apvc_get_html_with_icon( $wid_templated );
                } else {
                    $shHTML = $this->apvc_get_html_without_icon( $wid_templated );
                }

                $crReplace = '<div>{current_visits_label}{current_visits_counts}</div>';
                $tdReplace = '<div>{today_visits_label}{today_visits_counts}</div>';
                $glReplace = '<div>{total_visits_label}{total_visits_counts}</div>';

                $iconCR = $iconGL = $iconTD = '';
                if ( apvc_fs()->is__premium_only() ) {
                    $iconCR = ( $iconcr ) ? '<i class="' . $iconcr . '"></i>' : '';
                    $iconGL = ( $icongl ) ? '<i class="' . $icongl . '"></i>' : '';
                    $iconTD = ( $icontd ) ? '<i class="' . $icontd . '"></i>' : '';

                    if ( $avcConfig->apvc_icon_position[0] == 'Left' ) {
                        if ( $avcConfig->apvc_atc_page_count[0] !== "on" ) {
                            $shHTML = str_replace( $crReplace, "", $shHTML );
                        } else {
                            $shHTML = str_replace( $crReplace, '<div>' . $iconCR . " " . $this->apvc_number_format( $pageCnt ) . '</div>', $shHTML );
                        }

                        if ( $avcConfig->apvc_show_today_count[0] !== "on" ) {
                            $shHTML = str_replace( $tdReplace, "", $shHTML );
                        } else {
                            $shHTML = str_replace( $tdReplace, '<div>' . $iconTD . " " . $this->apvc_number_format( $todaysCount ) . '</div>', $shHTML );
                        }

                        if ( $avcConfig->apvc_show_global_count[0] !== "on" ) {
                            $shHTML = str_replace( $glReplace, "", $shHTML );
                        } else {
                            $shHTML = str_replace( $glReplace, '<div>' . $iconGL . " " . $this->apvc_number_format( $allTimeCount ) . '</div>', $shHTML );
                        }

                    } else {
                        if ( $avcConfig->apvc_atc_page_count[0] !== "on" ) {
                            $shHTML = str_replace( $crReplace, "", $shHTML );
                        } else {
                            $shHTML = str_replace( $crReplace, '<div>' . $pageCnt . ' ' . $iconCR . '</div>', $shHTML );
                        }

                        if ( $avcConfig->apvc_show_today_count[0] !== "on" ) {
                            $shHTML = str_replace( $tdReplace, "", $shHTML );
                        } else {
                            $shHTML = str_replace( $tdReplace, '<div>' . $todaysCount . ' ' . $iconTD . '</div>', $shHTML );
                        }

                        if ( $avcConfig->apvc_show_global_count[0] !== "on" ) {
                            $shHTML = str_replace( $glReplace, "", $shHTML );
                        } else {
                            $shHTML = str_replace( $glReplace, '<div>' . $allTimeCount . ' ' . $iconGL . '</div>', $shHTML );
                        }
                    }
                    $shHTML = str_replace( "{inline_style}", 'style="' . $widget_width . $padding . '' . $widAlignmentCss . '; margin-bottom :15px; color:' . $avcConfig->apvc_default_text_color[0] . '"', $shHTML );
                } else {

                    if ( $avcConfig->apvc_atc_page_count[0] !== "on" ) {
                        $shHTML = str_replace( $crReplace, "", $shHTML );
                    } else {
                        $shHTML = str_replace( $crReplace, '<div>' . $pageCnt . '</div>', $shHTML );
                    }

                    if ( $avcConfig->apvc_show_today_count[0] !== "on" ) {
                        $shHTML = str_replace( $tdReplace, '', $shHTML );
                    } else {
                        $shHTML = str_replace( $tdReplace, '<div>' . $todaysCount . '</div>', $shHTML );
                    }

                    if ( $avcConfig->apvc_show_global_count[0] !== "on" ) {
                        $shHTML = str_replace( $glReplace, '', $shHTML );
                    } else {
                        $shHTML = str_replace( $glReplace, '<div>' . $allTimeCount . '</div>', $shHTML );
                    }

                    $shHTML = str_replace( "{inline_style}", 'style="' . $widget_width . $padding . '' . $widAlignmentCss . '; margin-bottom :15px; color:' . $avcConfig->apvc_default_text_color[0] . '"', $shHTML );
                }
                $shHTML = '<style type="text/css">' . $shortcodeData->css . '</style>' . $shHTML;

            } else {

                if ( apvc_fs()->is__premium_only() ) {
                    if ( $iconPosition == "Left Side" ) {
                        $crIcon = $iconHtml . " " . $this->apvc_number_format( $pageCnt ) . " " . $iconHtmlTD . " " . $this->apvc_number_format( $todaysCount ) . " " . $iconHtmlGL . " " . $this->apvc_number_format( $allTimeCount );
                    } else {
                        $crIcon = $this->apvc_number_format( $pageCnt ) . " " . $iconHtml . " " . $this->apvc_number_format( $todaysCount ) . " " . $iconHtmlTD . " " . $this->apvc_number_format( $allTimeCount ) . " " . $iconHtmlGL;
                    }
                    $ShortcodeHtml = "<div class='avc_visit_counter_front_simple' " . $style . ">" . $crIcon . "</div>";
                } else {
                    $ShortcodeHtml = "<div class='avc_visit_counter_front_simple' " . $style . ">" . $this->apvc_number_format( $pageCnt ) . " " . $this->apvc_number_format( $todaysCount ) . " " . $this->apvc_number_format( $allTimeCount ) . "</div>";
                }
            }

            if ( $avcConfig->apvc_show_conter_on_front_side[0] == "disable" || $avcConfig->apvc_show_conter_on_front_side[0] == '' ) {
                return $content;
            } else {
                if ( $avcConfig->apvc_show_conter_on_front_side[0] == 'below_the_content' ) {
                    return $content . $shHTML . $ShortcodeHtml;
                } else if ( $avcConfig->apvc_show_conter_on_front_side[0] == 'above_the_content' ) {
                    return $shHTML . $ShortcodeHtml . $content;
                }
            }
        } else {
            return $content;
        }
    }


    /**
     * Advanced Page Visit Counter Shortcode Library.
     *
     * @since    3.0.1
     */
    public function apvc_get_shortcodes( $shortcode = '' ) {

        $shortcodes = [];

        $shortcodes['template_3']['icon'] = 'yes';
        $shortcodes['template_3']['css']  = '.template_3{background:#1c8394;padding:15px;margin:15px;border-radius:50px;border:2px solid #1c8394;-webkit-box-shadow:3px 4px 12px -2px rgba(0,0,0,.68);-moz-box-shadow:3px 4px 12px -2px rgba(0,0,0,.68);box-shadow:3px 4px 12px -2px rgba(0,0,0,.68);font-family:calibri;font-size:13pt;text-align:center}.template_3>div{color:#fff;display:inline-block;margin:0 30px}.template_3>div>span{font-weight:700;margin-left:10px}.template_3 .icons{color:#fff;margin-right:5px;font-weight:700}@media (max-width:644px){.template_3>div{margin:0 10px}}@media (max-width:525px){.template_3>div{color:#fff;display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_3>div:last-child{border-bottom:none}}';

        $shortcodes['template_6']['icon']  = 'yes';
        $shortcodes['template_6']['class'] = 'effect2';
        $shortcodes['template_6']['css']   = '.template_6{background:#764ba2;background:linear-gradient(90deg,#667eea 0,#764ba2 100%);padding:15px;margin:15px;border-radius:40px;border:2px solid #764ba2;font-family:calibri;font-size:13pt;text-align:center}.effect2{position:relative}.effect2:after{z-index:-1;position:absolute;content:"";bottom:15px;right:10px;left:auto;width:50%;top:50%;max-width:300px;background:#777;-webkit-box-shadow:0 15px 10px #777;-moz-box-shadow:0 15px 10px #777;box-shadow:0 15px 10px #777;-webkit-transform:rotate(4deg);-moz-transform:rotate(4deg);-o-transform:rotate(4deg);-ms-transform:rotate(4deg);transform:rotate(4deg)}.template_6>div{color:#fff;display:inline-block;margin:0 30px}.template_6>div>span{font-weight:700;margin-left:10px}.template_6 .icons{color:#fff;margin-right:5px;font-weight:700}@media (max-width:644px){.template_6>div{margin:0 10px}}@media (max-width:525px){.template_6>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fcb8a1}.template_6>div:last-child{border-bottom:none}}';

        $shortcodes['template_7']['icon']  = 'yes';
        $shortcodes['template_7']['class'] = 'effect2';
        $shortcodes['template_7']['css']   = '.template_7{background:#dfa579;background:linear-gradient(90deg,#c79081 0,#dfa579 100%);padding:15px;margin:15px;border-radius:40px;border:2px solid #dfa579;font-family:calibri;font-size:13pt;text-align:center}.effect2{position:relative}.effect2:after,.effect2:before{z-index:-1;position:absolute;content:"";bottom:25px;left:10px;width:50%;top:35%;max-width:300px;background:#000;-webkit-box-shadow:0 35px 20px #000;-moz-box-shadow:0 35px 20px #000;box-shadow:0 35px 20px #000;-webkit-transform:rotate(-7deg);-moz-transform:rotate(-7deg);-o-transform:rotate(-7deg);-ms-transform:rotate(-7deg);transform:rotate(-7deg)}.effect2:after{-webkit-transform:rotate(7deg);-moz-transform:rotate(7deg);-o-transform:rotate(7deg);-ms-transform:rotate(7deg);transform:rotate(7deg);right:10px;left:auto}.template_7>div{color:#fff;display:inline-block;margin:0 30px}.template_7>div>span{font-weight:700;margin-left:10px}.template_7 .icons{color:#fff;margin-right:5px;font-weight:700}@media (max-width:644px){.template_7>div{margin:0 10px}}@media (max-width:525px){.template_7>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fcb8a1}.template_7>div:last-child{border-bottom:none}}';

        $shortcodes['template_8']['icon']  = 'yes';
        $shortcodes['template_8']['class'] = 'effect2';
        $shortcodes['template_8']['css']   = '.template_8{background:#5fc3e4;background:linear-gradient(90deg,#e55d87 0,#5fc3e4 100%);padding:15px;margin:15px;border:2px solid #5fc3e4;font-family:calibri;font-size:13pt;text-align:center}.effect2{position:relative;-webkit-box-shadow:0 1px 4px rgba(0,0,0,.3),0 0 40px rgba(0,0,0,.1) inset;-moz-box-shadow:0 1px 4px rgba(0,0,0,.3),0 0 40px rgba(0,0,0,.1) inset;box-shadow:0 1px 4px rgba(0,0,0,.3),0 0 40px rgba(0,0,0,.1) inset}.effect2:after,.effect2:before{content:"";position:absolute;z-index:-1;-webkit-box-shadow:0 0 20px rgba(0,0,0,.8);-moz-box-shadow:0 0 20px rgba(0,0,0,.8);box-shadow:0 0 20px rgba(0,0,0,.8);top:0;bottom:0;left:10px;right:10px;-moz-border-radius:100px/10px;border-radius:100px/10px}.effect2:after{right:10px;left:auto;-webkit-transform:skew(8deg) rotate(3deg);-moz-transform:skew(8deg) rotate(3deg);-ms-transform:skew(8deg) rotate(3deg);-o-transform:skew(8deg) rotate(3deg);transform:skew(8deg) rotate(3deg)}.template_8>div{color:#fff;display:inline-block;margin:0 30px}.template_8>div>span{font-weight:700;margin-left:10px}.template_8 .icons{color:#fff;margin-right:5px;font-weight:700}@media (max-width:644px){.template_8>div{margin:0 10px}}@media (max-width:525px){.template_8>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_8>div:last-child{border-bottom:none}}';

        $shortcodes['template_11']['icon'] = 'yes';
        $shortcodes['template_11']['css']  = '.template_11{background:#2980b9;background:linear-gradient(225deg,#2980b9 0,#6dd5fa 50%,#fff 100%);padding:15px;margin:15px;border-radius:40px;border:2px solid #2980b9;font-family:calibri;font-size:13pt;text-align:center}.template_11>div{color:#1a1a1a;display:inline-block;margin:0 30px}.template_11>div>span{font-weight:700;margin-left:10px}.template_11 .icons{color:#1a1a1a;margin-right:5px;font-weight:700}@media (max-width:644px){.template_11>div{margin:0 10px}}@media (max-width:525px){.template_11>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #2980b9}.template_11>div:last-child{border-bottom:none}}';

        $shortcodes['template_22']['icon'] = 'no';
        $shortcodes['template_22']['css']  = '.template_22{background:#355c7d;background:linear-gradient(90deg,#355c7d 0,#6c5b7b 50%,#c06c84 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);box-shadow:0 10px 14px 0 rgba(0,0,0,.1)}.template_22>div{color:#fff;display:inline-block;margin:0 30px}.template_22>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_22>div{margin:0 10px}}@media (max-width:525px){.template_22>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #c06c84}.template_22>div:last-child{border-bottom:none}}';

        $shortcodes['template_23']['icon'] = 'no';
        $shortcodes['template_23']['css']  = '.template_23{background:#fc5c7d;background:linear-gradient(90deg,#fc5c7d 0,#6c5b7b 50%,#6a82fb 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);box-shadow:0 10px 14px 0 rgba(0,0,0,.1)}.template_23>div{color:#fff;display:inline-block;margin:0 30px}.template_23>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_23>div{margin:0 10px}}@media (max-width:525px){.template_23>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #c06c84}.template_23>div:last-child{border-bottom:none}}';

        $shortcodes['template_24']['icon'] = 'no';
        $shortcodes['template_24']['css']  = '.template_24{background:#fffbd5;background:linear-gradient(90deg,#fffbd5 0,#b20a2c 50%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);box-shadow:0 10px 14px 0 rgba(0,0,0,.1)}.template_24>div{color:#fff;display:inline-block;margin:0 30px}.template_24>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_24>div{margin:0 10px}}@media (max-width:525px){.template_24>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fffbd5}.template_24>div:last-child{border-bottom:none}}';

        $shortcodes['template_25']['icon'] = 'no';
        $shortcodes['template_25']['css']  = '.template_25{background:#302b63;background:linear-gradient(90deg,#0f0c29 0,#7365ff 50%,#24243e 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);box-shadow:0 10px 14px 0 rgba(0,0,0,.1)}.template_25>div{color:#fff;display:inline-block;margin:0 30px}.template_25>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_25>div{margin:0 10px}}@media (max-width:525px){.template_25>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #0f0c29}.template_25>div:last-child{border-bottom:none}}';

        $shortcodes['template_26']['icon'] = 'no';
        $shortcodes['template_26']['css']  = '.template_26{background:#d3cce3;background:linear-gradient(90deg,#d3cce3 0,#e9e4f0 50%,#d3cce3 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);box-shadow:0 10px 14px 0 rgba(0,0,0,.1)}.template_26>div{color:#6a6279;display:inline-block;margin:0 30px}.template_26>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_26>div{margin:0 10px}}@media (max-width:525px){.template_26>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #7f7a8a}.template_26>div:last-child{border-bottom:none}}';

        $shortcodes['template_29']['icon'] = 'no';
        $shortcodes['template_29']['css']  = '.template_29{background:#6d6027;background:linear-gradient(90deg,#6d6027 0,#d3cbb8 80%,#3c3b3f 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);box-shadow:0 10px 14px 0 rgba(0,0,0,.2)}.template_29>div{color:#fff;display:inline-block;margin:0 30px}.template_29>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_29>div{margin:0 10px}}@media (max-width:525px){.template_29>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #00f260}.template_29>div:last-child{border-bottom:none}}';

        $shortcodes['template_31']['icon'] = 'no';
        $shortcodes['template_31']['css']  = '.template_31{background:#3a1c71;background:linear-gradient(90deg,#3a1c71 0,#d76d77 25%,#ffaf7b 50%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);box-shadow:0 10px 14px 0 rgba(0,0,0,.2)}.template_31>div{color:#1a1a1a;display:inline-block;margin:0 30px}.template_31>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_31>div{margin:0 10px}}@media (max-width:525px){.template_31>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_31>div:last-child{border-bottom:none}}';

        $shortcodes['template_34']['icon'] = 'no';
        $shortcodes['template_34']['css']  = '.template_34{background:#f7971e;background:linear-gradient(90deg,#f7971e 0,#ffd200 50%,#f7971e 1%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);box-shadow:0 10px 14px 0 rgba(0,0,0,.2)}.template_34>div{color:#1a1a1a;display:inline-block;margin:0 30px}.template_34>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_34>div{margin:0 10px}}@media (max-width:525px){.template_34>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_34>div:last-child{border-bottom:none}}';

        $shortcodes['template_39']['icon'] = 'no';
        $shortcodes['template_39']['css']  = '.template_39{background:#000;background:linear-gradient(90deg,#000 0,#b3cc2c 50%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);box-shadow:0 10px 14px 0 rgba(0,0,0,.2)}.template_39>div{color:#fff;display:inline-block;margin:0 30px}.template_39>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_39>div{margin:0 10px}}@media (max-width:525px){.template_39>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_39>div:last-child{border-bottom:none}}';

        $shortcodes['template_40']['icon'] = 'no';
        $shortcodes['template_40']['css']  = '.template_40{background:#ba8b02;background:linear-gradient(90deg,#ba8b02 0,#ffd65d 80%,#ba8b02 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);box-shadow:0 10px 14px 0 rgba(0,0,0,.2)}.template_40>div{color:#1a1a1a;display:inline-block;margin:0 30px}.template_40>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_40>div{margin:0 10px}}@media (max-width:525px){.template_40>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_40>div:last-child{border-bottom:none}}';

        if ( apvc_fs()->is__premium_only() ) {

            $shortcodes['template_1']['icon'] = 'yes';
            $shortcodes['template_1']['css']  = '.template_1{background:#4e1c94;background:linear-gradient(90deg,#4e1c94 0,#d4480c 100%);padding:15px;margin:15px;border-top-left-radius:20px;border-bottom-right-radius:20px;border:2px solid #a52e06;-webkit-box-shadow:3px 4px 12px -2px rgba(0,0,0,.38);-moz-box-shadow:3px 4px 12px -2px rgba(0,0,0,.38);box-shadow:3px 4px 12px -2px rgba(0,0,0,.38);font-family:calibri;font-size:13pt;text-align:center}.template_1>div{color:#fff;display:inline-block;margin:0 30px}.template_1>div>span{font-weight:700;margin-left:10px}.template_1 .icons{color:#fff;margin-right:5px;font-weight:700}@media (max-width:644px){.template_1>div{margin:0 10px}}@media (max-width:525px){.template_1>div{color:#fff;display:block;margin:0;padding:10px 0;border-bottom:1px solid #ca4516}.template_1>div:last-child{border-bottom:none}}';

            $shortcodes['template_2']['icon'] = 'yes';
            $shortcodes['template_2']['css']  = '.template_2{background:#1c8394;background:linear-gradient(90deg,#1c8394 0,#c2d40c 100%);padding:15px;margin:15px;border:2px solid #1c8394;-webkit-box-shadow:3px 4px 12px -2px rgba(0,0,0,.68);-moz-box-shadow:3px 4px 12px -2px rgba(0,0,0,.68);box-shadow:3px 4px 12px -2px rgba(0,0,0,.68);font-family:calibri;font-size:13pt;text-align:center}.template_2>div{color:#fff;display:inline-block;margin:0 30px}.template_2>div>span{font-weight:700;margin-left:10px}.template_2 .icons{color:#fff;margin-right:5px;font-weight:700}@media (max-width:644px){.template_2>div{margin:0 10px}}@media (max-width:525px){.template_2>div{color:#fff;display:block;margin:0;padding:10px 0;border-bottom:1px solid #1c8394}.template_2>div:last-child{border-bottom:none}}';

            $shortcodes['template_4']['icon'] = 'yes';
            $shortcodes['template_4']['css']  = '.template_4{background:#faffd1;background:linear-gradient(90deg,#a1ffce 0,#faffd1 100%);padding:15px;margin:15px;border-top-left-radius:20px;border-top-right-radius:20px;border:2px solid #d6de95;-webkit-box-shadow:0 8px 6px -6px #000;-moz-box-shadow:0 8px 6px -6px #000;box-shadow:0 8px 6px -6px #000;font-family:calibri;font-size:13pt;text-align:center}.template_4>div{color:#1a1a1a;display:inline-block;margin:0 30px}.template_4>div>span{font-weight:700;margin-left:10px}.icons{color:#1a1a1a;margin-right:5px;font-weight:700}@media (max-width:644px){.template_4>div{margin:0 10px}}@media (max-width:525px){.template_4>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #d6de95}.template_4>div:last-child{border-bottom:none}}';

            $shortcodes['template_5']['icon']  = 'yes';
            $shortcodes['template_5']['class'] = 'effect2';
            $shortcodes['template_5']['css']   = '.template_5{background:#fcb69f;background:linear-gradient(90deg,#ffecd2 0,#fcb69f 100%);padding:15px;margin:15px;border-top-left-radius:20px;border-top-right-radius:20px;border:2px solid #fcb8a1;font-family:calibri;font-size:13pt;text-align:center}.effect2{position:relative}.effect2:after,.effect2:before{z-index:-1;position:absolute;content:"";bottom:15px;left:10px;width:50%;top:60%;max-width:300px;background:#777;-webkit-box-shadow:0 15px 10px #777;-moz-box-shadow:0 15px 10px #777;box-shadow:0 15px 10px #777;-webkit-transform:rotate(-3deg);-moz-transform:rotate(-3deg);-o-transform:rotate(-3deg);-ms-transform:rotate(-3deg);transform:rotate(-3deg)}.effect2:after{-webkit-transform:rotate(3deg);-moz-transform:rotate(3deg);-o-transform:rotate(3deg);-ms-transform:rotate(3deg);transform:rotate(3deg);right:10px;left:auto}.template_5>div{color:#1a1a1a;display:inline-block;margin:0 30px}.template_5>div>span{font-weight:700;margin-left:10px}.template_5 .icons{color:#1a1a1a;margin-right:5px;font-weight:700}@media (max-width:644px){.template_5>div{margin:0 10px}}@media (max-width:525px){.template_5>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fcb8a1}.template_5>div:last-child{border-bottom:none}}';

            $shortcodes['template_9']['icon'] = 'yes';
            $shortcodes['template_9']['css']  = '.template_9{background:#009fe4;background:linear-gradient(90deg,#0f2027 0,#009fe4 100%);padding:15px;margin:15px;border:2px solid #5fc3e4;font-family:calibri;border-bottom-right-radius:40px;font-size:13pt;text-align:center;box-shadow:5px 5px rgba(0,159,228,.4),10px 10px rgba(0,159,228,.3),15px 15px rgba(0,159,228,.2),20px 20px rgba(0,159,228,.1),25px 25px rgba(0,159,228,.05)}.template_9>div{color:#fff;display:inline-block;margin:0 30px}.template_9>div>span{font-weight:700;margin-left:10px}.template_9 .icons{color:#fff;margin-right:5px;font-weight:700}@media (max-width:644px){.template_9>div{margin:0 10px}}@media (max-width:525px){.template_9>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_9>div:last-child{border-bottom:none}}';

            $shortcodes['template_10']['icon'] = 'yes';
            $shortcodes['template_10']['css']  = '.template_10{background:#c6ffdd;background:linear-gradient(90deg,#c6ffdd 0,#fbd786 50%,#f7797d 100%);padding:15px;margin:15px;border:2px solid #5fc3e4;font-family:calibri;font-size:13pt;text-align:center;-moz-transform:skew(1deg,1deg);-webkit-transform:skew(1deg,1deg);-o-transform:skew(1deg,1deg);-ms-transform:skew(1deg,1deg);transform:skew(1deg,1deg)}.template_10>div{color:#1a1a1a;display:inline-block;margin:0 30px}.template_10>div>span{font-weight:700;margin-left:10px}.template_10 .icons{color:#1a1a1a;margin-right:5px;font-weight:700}@media (max-width:644px){.template_10>div{margin:0 10px}}@media (max-width:525px){.template_10>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_10>div:last-child{border-bottom:none}}';

            $shortcodes['template_12']['icon'] = 'yes';
            $shortcodes['template_12']['css']  = '.template_12{background:#493240;background:linear-gradient(315deg,#493240 0,#f09 100%);padding:15px;margin:15px;border-bottom-left-radius:40px;border-bottom-right-radius:40px;font-family:calibri;font-size:13pt;text-align:center}.template_12>div{color:#fff;display:inline-block;margin:0 30px}.template_12>div>span{font-weight:700;margin-left:10px}.template_12 .icons{color:#fff;margin-right:5px;font-weight:700}@media (max-width:644px){.template_12>div{margin:0 10px}}@media (max-width:525px){.template_12>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #2980b9}.template_12>div:last-child{border-bottom:none}}';

            $shortcodes['template_13']['icon'] = 'yes';
            $shortcodes['template_13']['css']  = '.template_13{background:#493240;background:linear-gradient(315deg,#8e2de2 0,#4a00e0 100%);padding:15px;margin:15px;border-bottom-left-radius:40px;border-top-left-radius:40px;font-family:calibri;font-size:13pt;text-align:center}.template_13>div{color:#fff;display:inline-block;margin:0 30px}.template_13>div>span{font-weight:700;margin-left:10px}.template_13 .icons{color:#fff;margin-right:5px;font-weight:700}@media (max-width:644px){.template_13>div{margin:0 10px}}@media (max-width:525px){.template_13>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #8e2de2}.template_13>div:last-child{border-bottom:none}}';

            $shortcodes['template_14']['icon'] = 'yes';
            $shortcodes['template_14']['css']  = '.template_14{background:#99f2c8;background:linear-gradient(315deg,#99f2c8 0,#1f4037 100%);padding:15px;margin:15px;border-bottom-left-radius:40px;border-top-left-radius:40px;font-family:calibri;font-size:13pt;text-align:center;border:2px solid #99f2c8}.template_14>div{color:#fff;display:inline-block;margin:0 30px}.template_14>div>span{font-weight:700;margin-left:10px}.template_14 .icons{color:#fff;margin-right:5px;font-weight:700}@media (max-width:644px){.template_14>div{margin:0 10px}}@media (max-width:525px){.template_14>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #99f2c8}.template_14>div:last-child{border-bottom:none}}';

            $shortcodes['template_15']['icon'] = 'yes';
            $shortcodes['template_15']['css']  = '.template_15{background:#f12711;background:linear-gradient(315deg,#f12711 0,#f5af19 100%);padding:15px;margin:15px;border-bottom-left-radius:40px;border-top-left-radius:40px;font-family:calibri;font-size:13pt;text-align:center;border:2px dashed #f5af19}.template_15>div{color:#fff;display:inline-block;margin:0 30px}.template_15>div>span{font-weight:700;margin-left:10px}.template_15 .icons{color:#fff;margin-right:5px;font-weight:700}@media (max-width:644px){.template_15>div{margin:0 10px}}@media (max-width:525px){.template_15>div{display:block;margin:0;padding:10px 0;border-bottom:1px dashed #99f2c8}.template_15>div:last-child{border-bottom:none}}';

            $shortcodes['template_16']['icon'] = 'yes';
            $shortcodes['template_16']['css']  = '.template_16{background:#8360c3;background:linear-gradient(315deg,#8360c3 0,#2ebf91 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;border:2px dashed #8360c3}.template_16>div{color:#fff;display:inline-block;margin:0 30px}.template_16>div>span{font-weight:700;margin-left:10px}.template_16 .icons{color:#fff;margin-right:5px;font-weight:700}@media (max-width:644px){.template_16>div{margin:0 10px}}@media (max-width:525px){.template_16>div{display:block;margin:0;padding:10px 0;border-bottom:1px dashed #99f2c8}.template_16>div:last-child{border-bottom:none}}';

            $shortcodes['template_17']['icon'] = 'yes';
            $shortcodes['template_17']['css']  = '.template_17{background:#eaafc8;background:linear-gradient(0deg,#654ea3 0,#eaafc8 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;border:2px dashed #eaafc8}.template_17>div{color:#fff;display:inline-block;margin:0 30px}.template_17>div>span{font-weight:700;margin-left:10px}.template_17 .icons{color:#fff;margin-right:5px;font-weight:700}@media (max-width:644px){.template_17>div{margin:0 10px}}@media (max-width:525px){.template_17>div{display:block;margin:0;padding:10px 0;border-bottom:1px dashed #eaafc8}.template_17>div:last-child{border-bottom:none}}';

            $shortcodes['template_18']['icon'] = 'yes';
            $shortcodes['template_18']['css']  = '.template_18{background:#f27121;background:linear-gradient(315deg,#8a2387 0,#e94057 50%,#f27121 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;border:2px dashed #f27121}.template_18>div{color:#fff;display:inline-block;margin:0 30px}.template_18>div>span{font-weight:700;margin-left:10px}.template_18 .icons{color:#fff;margin-right:5px;font-weight:700}@media (max-width:644px){.template_18>div{margin:0 10px}}@media (max-width:525px){.template_18>div{display:block;margin:0;padding:10px 0;border-bottom:1px dashed #eaafc8}.template_18>div:last-child{border-bottom:none}}';

            $shortcodes['template_19']['icon'] = 'yes';
            $shortcodes['template_19']['css']  = '.template_19{background:#78ffd6;background:linear-gradient(315deg,#a8ff78 0,#78ffd6 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);box-shadow:0 10px 14px 0 rgba(0,0,0,.1)}.template_19>div{color:#1a1a1a;display:inline-block;margin:0 30px}.template_19>div>span{font-weight:700;margin-left:10px}.template_19 .icons{color:#1a1a1a;margin-right:5px;font-weight:700}@media (max-width:644px){.template_19>div{margin:0 10px}}@media (max-width:525px){.template_19>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #1a1a1a}.template_19>div:last-child{border-bottom:none}}';

            $shortcodes['template_20']['icon'] = 'yes';
            $shortcodes['template_20']['css']  = '.template_20{background:#f37335;background:linear-gradient(90deg,#fdc830 0,#f37335 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);box-shadow:0 10px 14px 0 rgba(0,0,0,.1)}.template_20>div{color:#1a1a1a;display:inline-block;margin:0 30px}.template_20>div>span{font-weight:700;margin-left:10px}.template_20 .icons{color:#1a1a1a;margin-right:5px;font-weight:700}@media (max-width:644px){.template_20>div{margin:0 10px}}@media (max-width:525px){.template_20>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #1a1a1a}.template_20>div:last-child{border-bottom:none}}}';

            $shortcodes['template_21']['icon'] = 'no';
            $shortcodes['template_21']['css']  = '.template_21{background:#333;background:linear-gradient(90deg,#333 0,#dd1818 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);box-shadow:0 10px 14px 0 rgba(0,0,0,.1)}.template_21>div{color:#fff;display:inline-block;margin:0 30px}.template_21>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_21>div{margin:0 10px}}@media (max-width:525px){.template_21>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_21>div:last-child{border-bottom:none}}';


            $shortcodes['template_27']['icon'] = 'no';
            $shortcodes['template_27']['css']  = '.template_27{background:#3c3b3f;background:linear-gradient(90deg,#3c3b3f 0,#b3a84d 50%,#3c3b3f 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);box-shadow:0 10px 14px 0 rgba(0,0,0,.2)}.template_27>div{color:#fff;display:inline-block;margin:0 30px}.template_27>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_27>div{margin:0 10px}}@media (max-width:525px){.template_27>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #b3a84d}.template_27>div:last-child{border-bottom:none}}';

            $shortcodes['template_28']['icon'] = 'no';
            $shortcodes['template_28']['css']  = '.template_28{background:#00f260;background:linear-gradient(90deg,#00f260 0,#0575e6 50%,#3c3b3f 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);box-shadow:0 10px 14px 0 rgba(0,0,0,.2)}.template_28>div{color:#fff;display:inline-block;margin:0 30px}.template_28>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_28>div{margin:0 10px}}@media (max-width:525px){.template_28>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #00f260}.template_28>div:last-child{border-bottom:none}}';


            $shortcodes['template_30']['icon'] = 'no';
            $shortcodes['template_30']['css']  = '.template_30{background:#03001e;background:linear-gradient(90deg,#03001e 0,#7303c0 25%,#ec38bc 50%,#fdeff9 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);box-shadow:0 10px 14px 0 rgba(0,0,0,.2)}.template_30>div{color:#fff;display:inline-block;margin:0 30px}.template_30>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_30>div{margin:0 10px}}@media (max-width:525px){.template_30>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_30>div:last-child{border-bottom:none}}';


            $shortcodes['template_32']['icon'] = 'no';
            $shortcodes['template_32']['css']  = '.template_32{background:#cbb4d4;background:linear-gradient(90deg,#20002c 0,#cbb4d4 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);box-shadow:0 10px 14px 0 rgba(0,0,0,.2)}.template_32>div{color:#fff;display:inline-block;margin:0 30px}.template_32>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_32>div{margin:0 10px}}@media (max-width:525px){.template_32>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_32>div:last-child{border-bottom:none}}';

            $shortcodes['template_33']['icon'] = 'no';
            $shortcodes['template_33']['css']  = '.template_33{background:#eb5757;background:linear-gradient(90deg,#eb5757 0,#000 50%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);box-shadow:0 10px 14px 0 rgba(0,0,0,.2)}.template_33>div{color:#fff;display:inline-block;margin:0 30px}.template_33>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_33>div{margin:0 10px}}@media (max-width:525px){.template_33>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_33>div:last-child{border-bottom:none}}';


            $shortcodes['template_35']['icon'] = 'no';
            $shortcodes['template_35']['css']  = '.template_35{background:#200122;background:linear-gradient(90deg,#200122 0,#6f0000 70%,#200122 0);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);box-shadow:0 10px 14px 0 rgba(0,0,0,.2)}.template_35>div{color:#fff;display:inline-block;margin:0 30px}.template_35>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_35>div{margin:0 10px}}@media (max-width:525px){.template_35>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_35>div:last-child{border-bottom:none}}';

            $shortcodes['template_36']['icon'] = 'no';
            $shortcodes['template_36']['css']  = '.template_36{background:#093028;background:linear-gradient(90deg,#093028 0,#237a57 30%,#093028 0);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);box-shadow:0 10px 14px 0 rgba(0,0,0,.2)}.template_36>div{color:#fff;display:inline-block;margin:0 30px}.template_36>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_36>div{margin:0 10px}}@media (max-width:525px){.template_36>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_36>div:last-child{border-bottom:none}}';

            $shortcodes['template_37']['icon'] = 'no';
            $shortcodes['template_37']['css']  = '.template_37{background:#dce35b;background:linear-gradient(90deg,#dce35b 0,#45b649 30%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);box-shadow:0 10px 14px 0 rgba(0,0,0,.2)}.template_37>div{color:#fff;display:inline-block;margin:0 30px}.template_37>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_37>div{margin:0 10px}}@media (max-width:525px){.template_37>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_37>div:last-child{border-bottom:none}}';

            $shortcodes['template_38']['icon'] = 'no';
            $shortcodes['template_38']['css']  = '.template_38{background:#ffd89b;background:linear-gradient(90deg,#ffd89b 0,#19547b 50%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);box-shadow:0 10px 14px 0 rgba(0,0,0,.2)}.template_38>div{color:#fff;display:inline-block;margin:0 30px}.template_38>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_38>div{margin:0 10px}}@media (max-width:525px){.template_38>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_38>div:last-child{border-bottom:none}}';
        }

        if ( ! empty( $shortcode ) ) {
            return wp_json_encode( $shortcodes[ $shortcode ] );
        } else {
            return wp_json_encode( $shortcodes );
        }
    }


    public function apvc_number_format( $num ) {

        $op = get_option( 'numbers_in_k' );

        if ( $op == 'Yes' ) {

            if ( $num > 1000 ) {

                $x               = round( $num );
                $x_number_format = number_format( $x );
                $x_array         = explode( ',', $x_number_format );
                $x_parts         = [ 'k', 'm', 'b', 't' ];
                $x_count_parts   = count( $x_array ) - 1;
                $x_display       = $x;
                $x_display       = $x_array[0] . ( (int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '' );
                $x_display       .= $x_parts[ $x_count_parts - 1 ];

                return $x_display;

            }
        }

        return $num;

    }

}
