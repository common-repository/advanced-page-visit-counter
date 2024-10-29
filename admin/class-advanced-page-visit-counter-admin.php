<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://pagevisitcounter.com
 * @since      3.0.1
 *
 * @package    Advanced_Visit_Counter
 * @subpackage Advanced_Visit_Counter/admin
 */
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Advanced_Visit_Counter
 * @subpackage Advanced_Visit_Counter/admin
 * @author     Ankit Panchal <ankitmaru@live.in>
 */
class Advanced_Visit_Counter_Admin
{
    /**
     * The ID of this plugin.
     *
     * @since    3.0.1
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private  $plugin_name ;
    /**
     * The version of this plugin.
     *
     * @since    3.0.1
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private  $version ;
    private  $transients = array(
        "apvc_yearly_data",
        "apvc_monthly_data",
        "apvc_weekly_data",
        "apvc_daily_data",
        "apvc_browser_traffic_stats_data",
        "apvc_browser_traffic_data",
        "apvc_ref_traffic_data",
        "apvc_os_data",
        "apvc_orders_total",
        "apvc_total_orders_data",
        "apvc_total_products_sales",
        "apvc_mvp_month_data",
        "apvc_mvp_daily_data",
        "apvc_fv_30_td",
        "apvc_fv_30_past",
        "apvc_fv_td",
        "apvc_fv_past",
        "apvc_get_visitors_mn_data",
        "apvc_get_visitors_data",
        "apvc_pvp_30_data",
        "apvc_pvp_ip_30_data",
        "apvc_pvp_daily_data",
        "apvc_pvp_ip_daily_data"
    ) ;
    /**
     * Initialize the class and set its properties.
     *
     * @since    3.0.1
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    
    /**
     * Register the stylesheets for the admin area.
     *
     * @since    3.0.1
     */
    public function enqueue_styles()
    {
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
        
        if ( isset( $_GET['page'] ) && $_GET['page'] === 'apvc-dashboard-page' ) {
            wp_enqueue_style(
                'apvc_material_icons',
                plugin_dir_url( __FILE__ ) . 'css/mdi/css/materialdesignicons.min.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                'apvc_base',
                plugin_dir_url( __FILE__ ) . 'css/vendor.bundle.base.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                'apvc_base',
                plugin_dir_url( __FILE__ ) . 'css/vendor.bundle.base.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                'apvc_dataTables_bootstrap4',
                plugin_dir_url( __FILE__ ) . 'assets/datatables/dataTables.bootstrap4.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                'apvc_icheck',
                plugin_dir_url( __FILE__ ) . 'css/icheck/all.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                'apvc_select',
                plugin_dir_url( __FILE__ ) . 'css/select2.min.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                'apvc_tags',
                plugin_dir_url( __FILE__ ) . 'css/jquery.tagsinput.min.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                'apvc_colorPicker',
                plugin_dir_url( __FILE__ ) . 'css/asColorPicker.min.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                'apvc_style_base',
                plugin_dir_url( __FILE__ ) . 'css/style.css',
                array(),
                filemtime( plugin_dir_path( __FILE__ ) . 'css/style.css' ),
                'all'
            );
            wp_enqueue_style(
                'apvc_style_main',
                plugin_dir_url( __FILE__ ) . 'css/main/style.css',
                array(),
                filemtime( plugin_dir_path( __FILE__ ) . 'css/main/style.css' ),
                'all'
            );
            wp_enqueue_style(
                $this->plugin_name,
                plugin_dir_url( __FILE__ ) . 'css/advanced-page-visit-counter-admin.css',
                array(),
                filemtime( plugin_dir_path( __FILE__ ) . 'css/advanced-page-visit-counter-admin.css' ),
                'all'
            );
        }
    
    }
    
    /**
     * Register the JavaScript for the admin area.
     *
     * @since    3.0.1
     */
    public function enqueue_scripts()
    {
        global  $wpdb ;
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
        
        if ( isset( $_GET['page'] ) && $_GET['page'] === 'apvc-dashboard-page' ) {
            wp_enqueue_script(
                'apvc_js_base',
                plugin_dir_url( __FILE__ ) . 'js/vendor.bundle.base.js',
                array( 'jquery' ),
                $this->version,
                false
            );
            wp_enqueue_script(
                'apvc_chart_js',
                plugin_dir_url( __FILE__ ) . 'js/Chart.min.js',
                array( 'jquery' ),
                $this->version,
                false
            );
            wp_enqueue_script(
                'apvc_datatables_js',
                plugin_dir_url( __FILE__ ) . 'js/jquery.dataTables.js',
                array( 'jquery' ),
                $this->version,
                false
            );
            wp_enqueue_script(
                'apvc_datatables4_js',
                plugin_dir_url( __FILE__ ) . 'assets/datatables/dataTables.bootstrap4.js',
                array( 'jquery' ),
                $this->version,
                false
            );
            wp_enqueue_script(
                'apvc_hover_js',
                plugin_dir_url( __FILE__ ) . 'js/hoverable-collapse.js',
                array( 'jquery' ),
                $this->version,
                false
            );
            wp_enqueue_script(
                'apvc_misc_js',
                plugin_dir_url( __FILE__ ) . 'js/misc.js',
                array( 'jquery' ),
                $this->version,
                false
            );
            wp_enqueue_script(
                'apvc_settings_js',
                plugin_dir_url( __FILE__ ) . 'js/settings.js',
                array( 'jquery' ),
                $this->version,
                false
            );
            wp_enqueue_script(
                'apvc_icheck_js',
                plugin_dir_url( __FILE__ ) . 'js/icheck.min.js',
                array( 'jquery' ),
                $this->version,
                false
            );
            wp_enqueue_script(
                'apvc_select_js',
                plugin_dir_url( __FILE__ ) . 'js/select2.min.js',
                array( 'jquery' ),
                $this->version,
                false
            );
            wp_enqueue_script(
                'apvc_alert_js',
                plugin_dir_url( __FILE__ ) . 'js/sweetalert.min.js',
                array( 'jquery' ),
                $this->version,
                false
            );
            wp_enqueue_script(
                'apvc_asColor_js',
                plugin_dir_url( __FILE__ ) . 'js/jquery-asColor.min.js',
                array( 'jquery' ),
                $this->version,
                false
            );
            wp_enqueue_script(
                'apvc_color_picker_js',
                plugin_dir_url( __FILE__ ) . 'js/jquery-asColorPicker.min.js',
                array( 'jquery' ),
                $this->version,
                false
            );
            wp_enqueue_script(
                'apvc_tags_js',
                plugin_dir_url( __FILE__ ) . 'js/jquery.tagsinput.min.js',
                array( 'jquery' ),
                $this->version,
                false
            );
            wp_enqueue_script(
                'apvc_dashboard_js',
                plugin_dir_url( __FILE__ ) . 'js/dashboard.js',
                array( 'jquery' ),
                filemtime( plugin_dir_path( __FILE__ ) . 'js/dashboard.js' ),
                false
            );
            wp_enqueue_script(
                'apvc_script_js',
                plugin_dir_url( __FILE__ ) . 'js/script.js',
                array( 'jquery' ),
                filemtime( plugin_dir_path( __FILE__ ) . 'js/script.js' ),
                false
            );
            wp_enqueue_script(
                $this->plugin_name,
                plugin_dir_url( __FILE__ ) . 'js/advanced-page-visit-counter-admin.js',
                array( 'jquery' ),
                filemtime( plugin_dir_path( __FILE__ ) . 'js/advanced-page-visit-counter-admin.js' ),
                true
            );
            $translations = array(
                "search_lable"      => __( "Search By :", "apvc" ),
                "shortcode_copied"  => __( "Shortcode Copied to clipboard.", "apvc" ),
                "import_completed"  => __( "Data Imported successfully.", "apvc" ),
                "import_failed"     => __( "File format is not supported.", "apvc" ),
                "shortcode_delete"  => __( "Shortcode Deleted successfully.", "apvc" ),
                "file_delete"       => __( "File Deleted successfully.", "apvc" ),
                "success"           => __( "Success", "apvc" ),
                "failed"            => __( "Failed", "apvc" ),
                "are_you_sure"      => __( "Are you sure?", "apvc" ),
                "are_you_sure_text" => __( "You won't be able to revert this!", "apvc" ),
                "cancel_btn"        => __( "Cancel", "apvc" ),
                "okay_btn"          => __( "OK", "apvc" ),
                "confirm_btn"       => __( "Great ", "apvc" ),
                "valid_date"        => __( "Please select valid date range.", "apvc" ),
                "valid_file"        => __( "Please upload valid file. (xls,xlsx,csv)", "apvc" ),
                "date_warning"      => __( "Please enter valid date.", "apvc" ),
                "data_warning"      => __( "Please enter valid data.", "apvc" ),
                "open"              => __( "Open", "apvc" ),
                "export_completed"  => __( "File Export Completed", "apvc" ),
                "shortcode_save"    => __( "Please Enter Shortcode Name", "apvc" ),
                "cleanup_completed" => __( "Clean Up Process Completed", "apvc" ),
                "refresh_dashboard" => __( "Dashboard is reloading now...", "apvc" ),
            );
            $table = APVC_DATA_TABLE;
            $sYear = $wpdb->get_var( "SELECT YEAR(date) FROM {$table} ORDER BY date ASC LIMIT 1" );
            $eYear = date( 'Y' );
            wp_localize_script( $this->plugin_name, 'apvc_ajax', array(
                'ajax_url'     => admin_url( 'admin-ajax.php' ),
                'apvc_url'     => 'https://pagevisitcounter.com/',
                "search_lable" => __( "Search By :", "apvc" ),
                'admin_d_url'  => admin_url( 'admin.php?page=apvc-dashboard-page' ),
                'post_url'     => get_home_url() . "/?p=",
            ) );
            wp_localize_script( 'apvc_script_js', 'apvc_translation', $translations );
            wp_localize_script( $this->plugin_name, 'apvc_translation', $translations );
        }
    
    }
    
    /**
     * Advanced Page Visit Counter Settings Page Init
     *
     * @since    3.0.1
     */
    public function avc_settings_page_init()
    {
        add_menu_page(
            __( 'Advanced Page Visit Counter', 'apvc' ),
            __( 'Advanced Page Visit Counter', 'apvc' ),
            'manage_options',
            'apvc-dashboard-page',
            array( $this, 'apvc_dashboard_page' ),
            plugin_dir_url( __FILE__ ) . "images/a-logo-1.png"
        );
    }
    
    /**
     * Advanced Page Visit Counter Get Browsers Logos to list on reports pages.
     *
     * @since    3.0.1
     */
    public function get_browsers_logos()
    {
        $logos = array(
            'Firefox' => 'firefox.png',
            'Chrome'  => 'chrome.png',
            'Safari'  => 'Safari.png',
            'MSIE'    => 'Internet-Explorer.png',
            'Opera'   => 'opera.png',
            'Vivaldi' => 'vivaldi.png',
            'default' => 'default-browser.png',
        );
        return wp_json_encode( $logos );
    }
    
    /**
     * Advanced Page Visit Counter Get Country names to list on reports pages.
     *
     * @since    3.0.1
     */
    public function get_country_names()
    {
        $allCountries = [
            "Afghanistan"                                  => "AF",
            "land Islands"                                 => "AX",
            "Albania"                                      => "AL",
            "Algeria"                                      => "DZ",
            "American Samoa"                               => "AS",
            "AndorrA"                                      => "AD",
            "Angola"                                       => "AO",
            "Anguilla"                                     => "AI",
            "Antarctica"                                   => "AQ",
            "Antigua and Barbuda"                          => "AG",
            "Argentina"                                    => "AR",
            "Armenia"                                      => "AM",
            "Aruba"                                        => "AW",
            "Australia"                                    => "AU",
            "Austria"                                      => "AT",
            "Azerbaijan"                                   => "AZ",
            "Bahamas"                                      => "BS",
            "Bahrain"                                      => "BH",
            "Bangladesh"                                   => "BD",
            "Barbados"                                     => "BB",
            "Belarus"                                      => "BY",
            "Belgium"                                      => "BE",
            "Belize"                                       => "BZ",
            "Benin"                                        => "BJ",
            "Bermuda"                                      => "BM",
            "Bhutan"                                       => "BT",
            "Bolivia"                                      => "BO",
            "Bosnia and Herzegovina"                       => "BA",
            "Botswana"                                     => "BW",
            "Bouvet Island"                                => "BV",
            "Brazil"                                       => "BR",
            "British Indian Ocean Territory"               => "IO",
            "Brunei Darussalam"                            => "BN",
            "Bulgaria"                                     => "BG",
            "Burkina Faso"                                 => "BF",
            "Burundi"                                      => "BI",
            "Cambodia"                                     => "KH",
            "Cameroon"                                     => "CM",
            "Canada"                                       => "CA",
            "Cape Verde"                                   => "CV",
            "Cayman Islands"                               => "KY",
            "Central African Republic"                     => "CF",
            "Chad"                                         => "TD",
            "Chile"                                        => "CL",
            "China"                                        => "CN",
            "Christmas Island"                             => "CX",
            "Cocos (Keeling) Islands"                      => "CC",
            "Colombia"                                     => "CO",
            "Comoros"                                      => "KM",
            "Congo"                                        => "CG",
            "Congo, The Democratic Republic of the"        => "CD",
            "Cook Islands"                                 => "CK",
            "Costa Rica"                                   => "CR",
            "Cote D'Ivoire"                                => "CI",
            "Croatia"                                      => "HR",
            "Cuba"                                         => "CU",
            "Cyprus"                                       => "CY",
            "Czechia"                                      => "CZ",
            "Denmark"                                      => "DK",
            "Djibouti"                                     => "DJ",
            "Dominica"                                     => "DM",
            "Dominican Republic"                           => "DO",
            "Ecuador"                                      => "EC",
            "Egypt"                                        => "EG",
            "El Salvador"                                  => "SV",
            "Equatorial Guinea"                            => "GQ",
            "Eritrea"                                      => "ER",
            "Estonia"                                      => "EE",
            "Ethiopia"                                     => "ET",
            "Falkland Islands (Malvinas)"                  => "FK",
            "Faroe Islands"                                => "FO",
            "Fiji"                                         => "FJ",
            "Finland"                                      => "FI",
            "France"                                       => "FR",
            "French Guiana"                                => "GF",
            "French Polynesia"                             => "PF",
            "French Southern Territories"                  => "TF",
            "Gabon"                                        => "GA",
            "Gambia"                                       => "GM",
            "Georgia"                                      => "GE",
            "Germany"                                      => "DE",
            "Ghana"                                        => "GH",
            "Gibraltar"                                    => "GI",
            "Greece"                                       => "GR",
            "Greenland"                                    => "GL",
            "Grenada"                                      => "GD",
            "Guadeloupe"                                   => "GP",
            "Guam"                                         => "GU",
            "Guatemala"                                    => "GT",
            "Guernsey"                                     => "GG",
            "Guinea"                                       => "GN",
            "Guinea-Bissau"                                => "GW",
            "Guyana"                                       => "GY",
            "Haiti"                                        => "HT",
            "Heard Island and Mcdonald Islands"            => "HM",
            "Vatican City"                                 => "VA",
            "Honduras"                                     => "HN",
            "Hong Kong"                                    => "HK",
            "Hungary"                                      => "HU",
            "Iceland"                                      => "IS",
            "India"                                        => "IN",
            "Indonesia"                                    => "ID",
            "Iran"                                         => "IR",
            "Iraq"                                         => "IQ",
            "Ireland"                                      => "IE",
            "Isle of Man"                                  => "IM",
            "Israel"                                       => "IL",
            "Italy"                                        => "IT",
            "Jamaica"                                      => "JM",
            "Japan"                                        => "JP",
            "Jersey"                                       => "JE",
            "Hashemite Kingdom of Jordan"                  => "JO",
            "Kazakhstan"                                   => "KZ",
            "Kenya"                                        => "KE",
            "Kiribati"                                     => "KI",
            "Korea, Democratic People'S Republic of"       => "KP",
            "Republic of Korea"                            => "KR",
            "South Korea"                                  => "KR",
            "Kuwait"                                       => "KW",
            "Kyrgyzstan"                                   => "KG",
            "Laos"                                         => "LA",
            "Latvia"                                       => "LV",
            "Lebanon"                                      => "LB",
            "Lesotho"                                      => "LS",
            "Liberia"                                      => "LR",
            "Libyan Arab Jamahiriya"                       => "LY",
            "Liechtenstein"                                => "LI",
            "Republic of Lithuania"                        => "LT",
            "Luxembourg"                                   => "LU",
            "Macao"                                        => "MO",
            "Macedonia, The Former Yugoslav Republic of"   => "MK",
            "Madagascar"                                   => "MG",
            "Malawi"                                       => "MW",
            "Malaysia"                                     => "MY",
            "Maldives"                                     => "MV",
            "Mali"                                         => "ML",
            "Malta"                                        => "MT",
            "Marshall Islands"                             => "MH",
            "Martinique"                                   => "MQ",
            "Mauritania"                                   => "MR",
            "Mauritius"                                    => "MU",
            "Mayotte"                                      => "YT",
            "Mexico"                                       => "MX",
            "Micronesia, Federated States of"              => "FM",
            "Republic of Moldova"                          => "MD",
            "Monaco"                                       => "MC",
            "Mongolia"                                     => "MN",
            "Montenegro"                                   => "ME",
            "Montserrat"                                   => "MS",
            "Morocco"                                      => "MA",
            "Mozambique"                                   => "MZ",
            "Myanmar"                                      => "MM",
            "Namibia"                                      => "NA",
            "Nauru"                                        => "NR",
            "Nepal"                                        => "NP",
            "Netherlands"                                  => "NL",
            "Netherlands Antilles"                         => "AN",
            "New Caledonia"                                => "NC",
            "New Zealand"                                  => "NZ",
            "Nicaragua"                                    => "NI",
            "Niger"                                        => "NE",
            "Nigeria"                                      => "NG",
            "Niue"                                         => "NU",
            "Norfolk Island"                               => "NF",
            "Northern Mariana Islands"                     => "MP",
            "Norway"                                       => "NO",
            "Oman"                                         => "OM",
            "Pakistan"                                     => "PK",
            "Palau"                                        => "PW",
            "Palestine"                                    => "PS",
            "Panama"                                       => "PA",
            "Papua New Guinea"                             => "PG",
            "Paraguay"                                     => "PY",
            "Peru"                                         => "PE",
            "Philippines"                                  => "PH",
            "Pitcairn"                                     => "PN",
            "Poland"                                       => "PL",
            "Portugal"                                     => "PT",
            "Puerto Rico"                                  => "PR",
            "Qatar"                                        => "QA",
            "Reunion"                                      => "RE",
            "Romania"                                      => "RO",
            "Russia"                                       => "RU",
            "RWANDA"                                       => "RW",
            "Saint Helena"                                 => "SH",
            "Saint Kitts and Nevis"                        => "KN",
            "Saint Lucia"                                  => "LC",
            "Saint Pierre and Miquelon"                    => "PM",
            "Saint Vincent and the Grenadines"             => "VC",
            "Samoa"                                        => "WS",
            "San Marino"                                   => "SM",
            "Sao Tome and Principe"                        => "ST",
            "Saudi Arabia"                                 => "SA",
            "Senegal"                                      => "SN",
            "Serbia"                                       => "RS",
            "Seychelles"                                   => "SC",
            "Sierra Leone"                                 => "SL",
            "Singapore"                                    => "SG",
            "Slovakia"                                     => "SK",
            "Slovenia"                                     => "SI",
            "Solomon Islands"                              => "SB",
            "Somalia"                                      => "SO",
            "South Africa"                                 => "ZA",
            "South Georgia and the South Sandwich Islands" => "GS",
            "Spain"                                        => "ES",
            "Sri Lanka"                                    => "LK",
            "Sudan"                                        => "SD",
            "Suriname"                                     => "SR",
            "Svalbard and Jan Mayen"                       => "SJ",
            "Swaziland"                                    => "SZ",
            "Sweden"                                       => "SE",
            "Switzerland"                                  => "CH",
            "Syrian Arab Republic"                         => "SY",
            "Taiwan"                                       => "TW",
            "Tajikistan"                                   => "TJ",
            "Tanzania"                                     => "TZ",
            "Thailand"                                     => "TH",
            "Timor-Leste"                                  => "TL",
            "Togo"                                         => "TG",
            "Tokelau"                                      => "TK",
            "Tonga"                                        => "TO",
            "Trinidad and Tobago"                          => "TT",
            "Tunisia"                                      => "TN",
            "Turkey"                                       => "TR",
            "Turkmenistan"                                 => "TM",
            "Turks and Caicos Islands"                     => "TC",
            "Tuvalu"                                       => "TV",
            "Uganda"                                       => "UG",
            "Ukraine"                                      => "UA",
            "United Arab Emirates"                         => "AE",
            "United Kingdom"                               => "GB",
            "United States"                                => "US",
            "United States Minor Outlying Islands"         => "UM",
            "Uruguay"                                      => "UY",
            "Uzbekistan"                                   => "UZ",
            "Vanuatu"                                      => "VU",
            "Venezuela"                                    => "VE",
            "Vietnam"                                      => "VN",
            "Virgin Islands, British"                      => "VG",
            "Virgin Islands, U.S."                         => "VI",
            "Wallis and Futuna"                            => "WF",
            "Western Sahara"                               => "EH",
            "Yemen"                                        => "YE",
            "Zambia"                                       => "ZM",
            "Zimbabwe"                                     => "ZW",
        ];
        return wp_json_encode( $allCountries );
    }
    
    /**
     * Advanced Page Visit Counter Get short country name from full country name to list on reports pages.
     *
     * @since    3.0.1
     */
    public function get_country_name( $name )
    {
        $allCountries = json_decode( $this->get_country_names() );
        return $allCountries->{$name};
    }
    
    /**
     * Advanced Page Visit Counter Get total counts of the last year.
     *
     * @since    3.0.1
     */
    public function get_total_counts_of_the_year()
    {
        global  $wpdb ;
        $table = APVC_DATA_TABLE;
        $currentDate = date( 'Y-m-d H:i:s', strtotime( date( 'Y-m-d 0:0:0' ) . ' -1 year' ) );
        $monthWise = $wpdb->get_results( "SELECT COUNT(*) as total_count, MONTH(date) as month, YEAR(date) as year FROM {$table} WHERE date >= '{$currentDate}' GROUP BY MONTH(date) order by year ASC", ARRAY_N );
        $totalCounts = $wpdb->get_var( "SELECT COUNT(*) as total_count FROM {$table} WHERE date >= '" . $currentDate . "'" );
        $monthArray = array();
        foreach ( $monthWise as $value ) {
            array_push( $monthArray, $value[0] );
        }
        return wp_json_encode( array(
            "months_wise"  => $monthArray,
            "total_counts" => $totalCounts,
        ) );
    }
    
    /**
     * Advanced Page Visit Counter Get total counts of the last month.
     *
     * @since    3.0.1
     */
    public function get_total_counts_of_last_month()
    {
        global  $wpdb ;
        $table = APVC_DATA_TABLE;
        $currentDate = date( 'Y-m-d H:i:s', strtotime( date( 'Y-m-d 0:0:0' ) . ' -1 month' ) );
        $prevMonthDate = date( 'Y-m-d H:i:s', strtotime( date( 'Y-m-d 0:0:0' ) . ' -2 month' ) );
        $prevPrevMonthDate = date( 'Y-m-d H:i:s', strtotime( date( 'Y-m-d 0:0:0' ) . ' -3 month' ) );
        $lastMonthCounts = $wpdb->get_var( "SELECT COUNT(*) as total_count FROM {$table} WHERE date >= '" . $currentDate . "'" );
        $prevMonthCounts = $wpdb->get_var( "SELECT COUNT(*) as total_count FROM {$table} WHERE date >= '" . $prevMonthDate . "' AND date <= '" . $currentDate . "'" );
        $prevPrevMonthCounts = $wpdb->get_var( "SELECT COUNT(*) as total_count FROM {$table} WHERE date >= '" . $prevPrevMonthDate . "' AND date <= '" . $prevMonthDate . "'" );
        $diff = $lastMonthCounts - $prevMonthCounts;
        $diff = ( $diff >= 0 ? "+" . $diff : $diff );
        $class = ( $diff >= 0 ? "text-success" : "text-danger" );
        return wp_json_encode( array(
            "lastMonth"   => $lastMonthCounts,
            "months_wise" => [ $prevPrevMonthCounts, $prevMonthCounts, $lastMonthCounts ],
            "countDiff"   => $diff,
            "class"       => $class,
        ) );
    }
    
    /**
     * Advanced Page Visit Counter Get total counts of the last week.
     *
     * @since    3.0.1
     */
    public function get_total_counts_of_last_week()
    {
        global  $wpdb ;
        $table = APVC_DATA_TABLE;
        $currentDate = date( 'Y-m-d H:i:s', strtotime( date( 'Y-m-d 0:0:0' ) . ' -1 week' ) );
        $prevWeekDate = date( 'Y-m-d H:i:s', strtotime( date( 'Y-m-d 0:0:0' ) . ' -2 weeks' ) );
        $prevPrevWeekDate = date( 'Y-m-d H:i:s', strtotime( date( 'Y-m-d 0:0:0' ) . ' -3 weeks' ) );
        $lastWeekCounts = $wpdb->get_var( "SELECT COUNT(*) as total_count FROM {$table} WHERE date >= '" . $currentDate . "'" );
        $prevWeekCounts = $wpdb->get_var( "SELECT COUNT(*) as total_count FROM {$table} WHERE date >= '" . $prevWeekDate . "' AND date <= '" . $currentDate . "'" );
        $prevPrevWeekCounts = $wpdb->get_var( "SELECT COUNT(*) as total_count FROM {$table} WHERE date >= '" . $prevPrevWeekDate . "' AND date <= '" . $prevWeekDate . "'" );
        $diff = $lastWeekCounts - $prevWeekCounts;
        $diff = ( $diff >= 0 ? "+" . $diff : $diff );
        $class = ( $diff >= 0 ? "text-success" : "text-danger" );
        return wp_json_encode( array(
            "lastWeek"   => $lastWeekCounts,
            "weeks_wise" => [ $prevPrevWeekCounts, $prevWeekCounts, $lastWeekCounts ],
            "countDiff"  => $diff,
            "class"      => $class,
        ) );
    }
    
    /**
     * Advanced Page Visit Counter Get total counts of daily.
     *
     * @since    3.0.1
     */
    public function get_total_counts_of_last_daily()
    {
        global  $wpdb ;
        $table = APVC_DATA_TABLE;
        $currentDate = date( 'Y-m-d H:i:s', strtotime( date( 'Y-m-d 0:0:0' ) ) );
        $yesterdayDate = date( 'Y-m-d H:i:s', strtotime( date( 'Y-m-d 0:0:0' ) . ' -2 day' ) );
        $prevDate = date( 'Y-m-d H:i:s', strtotime( date( 'Y-m-d 0:0:0' ) . ' -3 day' ) );
        $todaysCounts = $wpdb->get_var( "SELECT COUNT(*) as total_count FROM {$table} WHERE date >= '" . $currentDate . "'" );
        $yesterdayCounts = $wpdb->get_var( "SELECT COUNT(*) as total_count FROM {$table} WHERE date >= '" . $yesterdayDate . "' AND date <= '" . $currentDate . "'" );
        $prevDate = $wpdb->get_var( "SELECT COUNT(*) as total_count FROM {$table} WHERE date >= '" . $prevDate . "' AND date <= '" . $yesterdayDate . "'" );
        $diff = $todaysCounts - $yesterdayCounts;
        $diff = ( $diff >= 0 ? "+" . $diff : $diff );
        $class = ( $diff >= 0 ? "text-success" : "text-danger" );
        return wp_json_encode( array(
            "todaysCounts" => $todaysCounts,
            "day_wise"     => [ $prevDate, $yesterdayCounts, $todaysCounts ],
            "countDiff"    => $diff,
            "class"        => $class,
        ) );
    }
    
    /**
     * Advanced Page Visit Counter Get total counts.
     *
     * @since    3.0.1
     */
    public function get_total_counts()
    {
        global  $wpdb ;
        $table = APVC_DATA_TABLE;
        $total_count = $wpdb->get_var( "SELECT COUNT(*) FROM {$table}" );
        return $total_count;
        wp_die();
    }
    
    /**
     * Advanced Page Visit Counter Get browser traffic stats.
     *
     * @since    3.0.1
     */
    public function get_browser_traffic_stats()
    {
        global  $wpdb ;
        $table = APVC_DATA_TABLE;
        $browserStats = $wpdb->get_results( "SELECT COUNT(*) as total_count, device_type, COUNT(*)*100/(SELECT COUNT(*) FROM {$table}) as percentage  FROM {$table} GROUP BY device_type" );
        return wp_json_encode( $browserStats );
    }
    
    /**
     * Advanced Page Visit Counter Get browser traffic stats list.
     *
     * @since    3.0.1
     */
    public function get_browser_traffic_stats_list()
    {
        global  $wpdb ;
        $table = APVC_DATA_TABLE;
        $currentDate = date( 'Y-m-d H:i:s', strtotime( date( 'Y-m-d 0:0:0' ) . ' -1 day' ) );
        $browserStatsList = $wpdb->get_results( "SELECT COUNT(*) as total_count, browser_short_name, browser_full_name FROM {$table} WHERE date >= '{$currentDate}' GROUP BY browser_short_name order by total_count DESC LIMIT 5" );
        return wp_json_encode( $browserStatsList );
    }
    
    /**
     * Advanced Page Visit Counter Get referrel websites traffic stats.
     *
     * @since    3.0.1
     */
    public function get_referral_websites_stats()
    {
        global  $wpdb ;
        $table = APVC_DATA_TABLE;
        $referralStats = $wpdb->get_results( "SELECT COUNT(*) as total_count, SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(REPLACE(LOWER(http_referer), 'https://', ''), 'http://', ''), '/', 1), '?', 1) as http_referer, http_referer as htp_ref, COUNT(*)*100/(SELECT COUNT(*) FROM {$table}) as percentage FROM {$table} GROUP BY http_referer ORDER BY total_count DESC LIMIT 0,5 " );
        return wp_json_encode( $referralStats );
    }
    
    /**
     * Advanced Page Visit Counter Get stats by Operation Systems.
     *
     * @since    3.0.1
     */
    public function get_stats_by_operating_systems()
    {
        global  $wpdb ;
        $table = APVC_DATA_TABLE;
        $OsStats = $wpdb->get_results( "SELECT COUNT(*) as total_count, operating_system, COUNT(*)*100/(SELECT COUNT(*) FROM {$table}) as percentage FROM {$table} GROUP BY operating_system ORDER BY total_count DESC LIMIT 0,5" );
        return wp_json_encode( $OsStats );
    }
    
    /**
     * Advanced Page Visit Counter Get recent visit stats.
     *
     * @since    3.0.1
     */
    public function get_recent_visit( $article_id, $type = '' )
    {
        global  $wpdb ;
        $table = APVC_DATA_TABLE;
        
        if ( $type == 'ip_address' ) {
            $recentVisit = $wpdb->get_var( "SELECT date FROM {$table} WHERE ip_address = '{$article_id}' ORDER BY date DESC" );
        } else {
            $recentVisit = $wpdb->get_var( "SELECT date FROM {$table} WHERE article_id = {$article_id} ORDER BY date DESC" );
        }
        
        $recentVisit = human_time_diff( strtotime( $recentVisit ), strtotime( date( "Y-m-d 0:0:0" ) ) ) . __( ' ago', "apvc" );
        return $recentVisit;
    }
    
    /**
     * Advanced Page Visit Counter Get total reports.
     *
     * @since    3.0.1
     */
    public function get_the_reports( $offset, $no_of_records_per_page )
    {
        global  $wpdb ;
        $table = APVC_DATA_TABLE;
        $where = '';
        $where = " ";
        $totalCount = count( $wpdb->get_results( "SELECT article_id FROM {$table} " . $where . " GROUP BY article_id" ) );
        $apvcReports = $wpdb->get_results( "SELECT COUNT(*) as count, article_id, ( SELECT post_title FROM {$wpdb->prefix}posts WHERE ID=article_id ) as title FROM {$table} " . $where . " GROUP BY article_id ORDER BY count DESC LIMIT {$offset}, {$no_of_records_per_page}" );
        return wp_json_encode( array(
            "totalCount" => $totalCount,
            "list"       => $apvcReports,
        ) );
    }
    
    /**
     * Advanced Page Visit Counter Get detailed report of any article.
     *
     * @since    3.0.1
     */
    public function get_the_detailed_reports( $article_id, $offset, $no_of_records_per_page )
    {
        global  $wpdb ;
        $table = APVC_DATA_TABLE;
        $where = '';
        $where = " ";
        $totalCount = count( $wpdb->get_results( "SELECT article_id FROM {$table} WHERE article_id={$article_id} " . $where . " " ) );
        $apvcReports = $wpdb->get_results( "SELECT *, (SELECT post_title FROM {$wpdb->prefix}posts WHERE ID={$article_id}) as title,  SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(REPLACE(LOWER(http_referer), 'https://', ''), 'http://', ''), '/', 1), '?', 1) as http_referer_clean FROM {$table} WHERE article_id={$article_id} " . $where . " ORDER BY date DESC LIMIT {$offset}, {$no_of_records_per_page}" );
        return wp_json_encode( array(
            "totalCount" => $totalCount,
            "list"       => $apvcReports,
        ) );
    }
    
    /**
     * Advanced Page Visit Counter Get total counts of the year.
     *
     * @since    3.0.1
     */
    public function apvc_get_total_counts_of_the_year_data()
    {
        global  $wpdb ;
        $yearTotalCounts = get_transient( "apvc_yearly_data" );
        
        if ( empty($yearTotalCounts) ) {
            $yearTotalCounts = json_decode( $this->get_total_counts_of_the_year() );
            set_transient( "apvc_yearly_data", $yearTotalCounts, HOURLY_REFRESH );
        }
        
        ?>
		<div class="card-body pb-0">
			<p class="text-muted"><?php 
        echo  __( "Total Visits (Last 1 Year)", "apvc" ) ;
        ?></p>
			<div class="d-flex align-items-center">
				<h4 class="font-weight-semibold"><?php 
        echo  $yearTotalCounts->total_counts ;
        ?></h4>
			</div>
			
		</div>
		<canvas class="mt-2" height="60" months="<?php 
        echo  implode( ",", $yearTotalCounts->months_wise ) ;
        ?>" id="apvc_total_visits_yearly"></canvas>
		<?php 
        wp_die();
    }
    
    /**
     * Advanced Page Visit Counter Get total counts of the month.
     *
     * @since    3.0.1
     */
    public function apvc_get_total_counts_of_the_month_data()
    {
        global  $wpdb ;
        $monthTotalCounts = get_transient( "apvc_monthly_data" );
        
        if ( empty($monthTotalCounts) ) {
            $monthTotalCounts = json_decode( $this->get_total_counts_of_last_month() );
            set_transient( "apvc_monthly_data", $monthTotalCounts, HOURLY_REFRESH );
        }
        
        ?>
		<div class="card-body pb-0">
			<p class="text-muted"><?php 
        echo  __( "Total Visits (Month)", "apvc" ) ;
        ?></p>
			<div class="d-flex align-items-center">
				<h4 class="font-weight-semibold"><?php 
        echo  $monthTotalCounts->lastMonth ;
        ?></h4>
				<h6 class="<?php 
        echo  $monthTotalCounts->class ;
        ?> font-weight-semibold ml-2"><?php 
        echo  $monthTotalCounts->countDiff ;
        ?></h6>
			</div>
		</div>
		<canvas class="mt-2" month="<?php 
        echo  implode( ",", $monthTotalCounts->months_wise ) ;
        ?>" height="60" id="apvc_total_visits_monthly"></canvas>
		<?php 
        wp_die();
    }
    
    /**
     * Advanced Page Visit Counter Get total counts of the week.
     *
     * @since    3.0.1
     */
    public function apvc_get_total_counts_of_the_week_data()
    {
        global  $wpdb ;
        $weeksTotalCounts = get_transient( "apvc_weekly_data" );
        
        if ( empty($weeksTotalCounts) ) {
            $weeksTotalCounts = json_decode( $this->get_total_counts_of_last_week() );
            set_transient( "apvc_weekly_data", $weeksTotalCounts, HOURLY_REFRESH );
        }
        
        ?>
		<div class="card-body pb-0">
			<p class="text-muted"><?php 
        echo  __( "Total Visits (Week)", "apvc" ) ;
        ?></p>
			<div class="d-flex align-items-center">
				<h4 class="font-weight-semibold"><?php 
        echo  $weeksTotalCounts->lastWeek ;
        ?></h4>
				<h6 class="<?php 
        echo  $weeksTotalCounts->class ;
        ?> font-weight-semibold ml-2"><?php 
        echo  $weeksTotalCounts->countDiff ;
        ?></h6>
			</div>
		</div>
		<canvas class="mt-2" height="60" weeks="<?php 
        echo  implode( ",", $weeksTotalCounts->weeks_wise ) ;
        ?>" id="apvc_total_visits_weekly"></canvas>
		<?php 
        wp_die();
    }
    
    /**
     * Advanced Page Visit Counter Get total counts of the day.
     *
     * @since    3.0.1
     */
    public function apvc_get_total_counts_daily_data()
    {
        global  $wpdb ;
        $dailyTotalCounts = get_transient( "apvc_daily_data" );
        
        if ( empty($dailyTotalCounts) ) {
            $dailyTotalCounts = json_decode( $this->get_total_counts_of_last_daily() );
            set_transient( "apvc_daily_data", $dailyTotalCounts, HOURLY_REFRESH );
        }
        
        ?>
		<div class="card-body pb-0">
			<p class="text-muted"><?php 
        echo  __( "Total Visits (Today)", "apvc" ) ;
        ?></p>
			<div class="d-flex align-items-center">
				<h4 class="font-weight-semibold"><?php 
        echo  $dailyTotalCounts->todaysCounts ;
        ?></h4>
				<h6 class="<?php 
        echo  $dailyTotalCounts->class ;
        ?> font-weight-semibold ml-2"><?php 
        echo  $dailyTotalCounts->countDiff ;
        ?></h6>
			</div>
		</div>
		<canvas class="mt-2" height="60" days="<?php 
        echo  implode( ",", $dailyTotalCounts->day_wise ) ;
        ?>" id="apvc_total_visits_daily"></canvas>
		<?php 
        wp_die();
    }
    
    /**
     * Advanced Page Visit Counter Get stats by browser.
     *
     * @since    3.0.1
     */
    public function apvc_get_browsers_stats_data()
    {
        global  $wpdb ;
        $browserTrafficStatsList = get_transient( "apvc_browser_traffic_stats_data" );
        
        if ( empty($browserTrafficStatsList) ) {
            $browserTrafficStatsList = json_decode( $this->get_browser_traffic_stats_list() );
            set_transient( "apvc_browser_traffic_stats_data", $browserTrafficStatsList, HOURLY_REFRESH );
        }
        
        $browserTrafficStats = get_transient( "apvc_browser_traffic_data" );
        
        if ( empty($browserTrafficStats) ) {
            $browserTrafficStats = json_decode( $this->get_browser_traffic_stats() );
            set_transient( "apvc_browser_traffic_data", $browserTrafficStats, HOURLY_REFRESH );
        }
        
        $browserLogos = (array) json_decode( $this->get_browsers_logos() );
        $browsersChartDataV = array();
        $browsersChartDataK = array();
        foreach ( $browserTrafficStatsList as $bChartList ) {
            array_push( $browsersChartDataV, $bChartList->total_count );
            array_push( $browsersChartDataK, $bChartList->browser_full_name );
        }
        ?>
		<div class="d-flex align-items-center mb-0 mb-lg-5">
	      <ul class="nav nav-tabs tab-solid tab-solid-primary mb-0" role="tablist">
	        <li class="nav-item">
	          <a class="nav-link active" id="daily-traffic-tab" data-toggle="tab" href="#daily-traffic" role="tab" aria-controls="daily-traffic" aria-selected="true"><?php 
        echo  __( "Daily", "apvc" ) ;
        ?></a>
	        </li>
	      </ul>
	      <ul class="ml-auto d-none d-lg-block" id="sourceLineChartLegend">
	      	<?php 
        $classColors = array(
            'bg-primary',
            'bg-success',
            'bg-secondary',
            'bg-danger',
            'bg-warning',
            'bg-pink'
        );
        $bsCnt = 0;
        foreach ( $browserTrafficStats as $bStats ) {
            echo  '<li>
				          <span class="chart-color ' . $classColors[$bsCnt] . '"></span>
				          <span class="chart-label">' . __( " " . $bStats->device_type . " ", "apvc" ) . number_format_i18n( $bStats->percentage, 2 ) . '%</span>
				        </li>' ;
            $bsCnt++;
        }
        ?>
	      </ul>
	    </div>
	    <div class="tab-content tab-content-solid">
	      <div class="tab-pane fade show active" id="daily-traffic" role="tabpanel" aria-labelledby="daily-traffic-tab">
	        <div class="row">
	          <div class="col-lg-4 d-none d-lg-flex align-items-center justify-content-center order-lg-last">
	            <div class="wrapper">
	              <canvas id="apvcBrowsersStatsChart" ch_value="<?php 
        echo  implode( ",", $browsersChartDataV ) ;
        ?>" ch_keys="<?php 
        echo  implode( ",", $browsersChartDataK ) ;
        ?>" height="140"></canvas>
	              <p class="text-muted text-center mt-4"><?php 
        echo  __( "Updated at ", "apvc" ) ;
        echo  current_time( 'H:i:a' ) ;
        ?><br><?php 
        echo  current_time( 'M d Y' ) ;
        ?></p>
	            </div>
	          </div>
	          <div class="col-lg-8 order-lg-first">
	            <div class="data-list">
				<?php 
        foreach ( $browserTrafficStatsList as $statsList ) {
            ?>
	              <div class="list-item row">
	                <div class="thumb col">
	                  <img class="rounded-circle img-xs" src="<?php 
            echo  ( $browserLogos[$statsList->browser_short_name] != '' ? plugin_dir_url( __FILE__ ) . "/images/" . $browserLogos[$statsList->browser_short_name] : plugin_dir_url( __FILE__ ) . "/images/" . $browserLogos['default'] ) ;
            ?>" alt="thumb"> </div>
	                <div class="browser col"><?php 
            echo  __( $statsList->browser_full_name, "apvc" ) ;
            ?></div>
	                <div class="visits col"><?php 
            echo  $statsList->total_count ;
            ?></div>
	              </div>
	            <?php 
        }
        ?>
				</div>
	          </div>
	        </div>
	      </div>
	    </div>
		<?php 
        wp_die();
    }
    
    /**
     * Advanced Page Visit Counter Get total counts by referrers.
     *
     * @since    3.0.1
     */
    public function apvc_get_referral_stats_data()
    {
        global  $wpdb ;
        $referralTrafficStats = get_transient( "apvc_ref_traffic_data" );
        
        if ( empty($referralTrafficStats) ) {
            $referralTrafficStats = json_decode( $this->get_referral_websites_stats() );
            set_transient( "apvc_ref_traffic_data", $referralTrafficStats, HOURLY_REFRESH );
        }
        
        $refChartDataV = array();
        $refChartDataK = array();
        foreach ( $referralTrafficStats as $refChartList ) {
            array_push( $refChartDataV, $refChartList->total_count );
            array_push( $refChartDataK, ucfirst( $refChartList->http_referer ) );
        }
        ?>
		<div class="col-md-6 aligner-wrapper mb-4 mb-md-0">
	        <canvas class="my-auto myref-chart" id="trafficReferralChart" height="250" ref_value="<?php 
        echo  implode( ",", $refChartDataV ) ;
        ?>" ref_keys="<?php 
        echo  implode( ",", $refChartDataK ) ;
        ?>"></canvas>
	        <div class="wrapper d-flex flex-column justify-content-center absolute absolute-center">
	        </div>
	      </div>
		<div class="col-md-6 legend-wrapper">
			<?php 
        $classColors = array(
            'bg-primary',
            'bg-success',
            'bg-secondary',
            'bg-danger',
            'bg-warning',
            'bg-pink'
        );
        $bsCnt = 0;
        foreach ( $referralTrafficStats as $refStats ) {
            echo  '<div class="d-flex mb-3">
			          <div class="dot-indicator ' . $classColors[$bsCnt] . ' mt-1 mr-2"></div>
			          <div class="d-flex flex-column justify-content-center">
			            <p class="mb-0">' . __( ucfirst( $refStats->http_referer ), 'apvc' ) . '</p><small class="text-muted"><strong>' . $refStats->total_count . ' (' . number_format_i18n( $refStats->percentage, 2 ) . '%)</strong></small><a href="' . $refStats->htp_ref . '" target="_blank"><small class="text-muted" style="word-break: break-word;">' . __( $refStats->htp_ref, 'apvc' ) . '</small></a>
			            
			          </div>
			        </div>' ;
            $bsCnt++;
        }
        ?>
		</div>
		<?php 
        wp_die();
    }
    
    /**
     * Advanced Page Visit Counter Get stats by Operating Systems.
     *
     * @since    3.0.1
     */
    public function apvc_get_os_stats_data()
    {
        global  $wpdb ;
        $osTrafficStats = get_transient( "apvc_os_data" );
        
        if ( empty($osTrafficStats) ) {
            $osTrafficStats = json_decode( $this->get_stats_by_operating_systems() );
            set_transient( "apvc_os_data", $osTrafficStats, HOURLY_REFRESH );
            update_option( "avpc_recent_execution", date( "Y-m-d H:i:s" ) );
        }
        
        $osChartDataV = array();
        $osChartDataK = array();
        foreach ( $osTrafficStats as $osChartList ) {
            array_push( $osChartDataV, $osChartList->total_count );
            array_push( $osChartDataK, ucfirst( $osChartList->operating_system ) );
        }
        ?>
		<div class="col-md-6 aligner-wrapper mb-4 mb-md-0">
		    <canvas class="my-auto myos-chart" id="osSourceChart" height="250" os_value="<?php 
        echo  implode( ",", $osChartDataV ) ;
        ?>" os_keys="<?php 
        echo  implode( ",", $osChartDataK ) ;
        ?>"></canvas>
		    <div class="wrapper d-flex flex-column justify-content-center absolute absolute-center">
		    </div>
		</div>
		<div class="col-md-6 legend-wrapper">
		<?php 
        $classColors = array(
            'bg-primary',
            'bg-success',
            'bg-secondary',
            'bg-danger',
            'bg-warning',
            'bg-pink'
        );
        $bsCnt = 0;
        foreach ( $osTrafficStats as $osStats ) {
            echo  '<div class="d-flex mb-3">
			          <div class="dot-indicator ' . $classColors[$bsCnt] . ' mt-1 mr-2"></div>
			          <div class="d-flex flex-column justify-content-center">
			            <p class="mb-0">' . __( ucfirst( $osStats->operating_system ), 'apvc' ) . '</p>
			            <small class="text-muted">' . $osStats->total_count . ' (' . number_format_i18n( $osStats->percentage, 2 ) . '%)</small>
			          </div>
			        </div>' ;
            $bsCnt++;
        }
        ?>
		</div>
		<?php 
        wp_die();
    }
    
    /**
     * Advanced Page Visit Counter Get Most visited article.
     *
     * @since    3.0.1
     */
    public function apvc_most_visited_article()
    {
        global  $wpdb ;
        $table = APVC_DATA_TABLE;
        $sdate = date( 'Y-m-d 00:00:00' );
        $pedate = date( 'Y-m-d H:i:s', strtotime( date( 'Y-m-d 0:0:0' ) . ' -31 day' ) );
        
        if ( isset( $_REQUEST['day'] ) && !empty($_REQUEST['day']) ) {
            $visits = get_transient( "apvc_mvp_month_data" );
            
            if ( empty($visits) ) {
                $visits = $wpdb->get_results( "SELECT COUNT(*) as ar_count, article_id, (SELECT post_title FROM {$wpdb->posts} WHERE ID = article_id ) as title FROM " . APVC_DATA_TABLE . "  WHERE article_id != '' AND `date` > '{$pedate}' GROUP BY article_id ORDER BY ar_count DESC LIMIT 1" );
                set_transient( "apvc_mvp_month_data", $visits, HOURLY_REFRESH );
            }
        
        } else {
            $visits = get_transient( "apvc_mvp_daily_data" );
            
            if ( empty($visits) ) {
                $visits = $wpdb->get_results( "SELECT COUNT(*) as ar_count, article_id, (SELECT post_title FROM {$wpdb->posts} WHERE ID = article_id ) as title FROM " . APVC_DATA_TABLE . "  WHERE article_id != '' AND `date` > '{$sdate}' GROUP BY article_id ORDER BY ar_count DESC LIMIT 1" );
                set_transient( "apvc_mvp_daily_data", $visits, HOURLY_REFRESH );
            }
        
        }
        
        ?>
		<div class="card-body">
		    <div class="d-flex justify-content-center">
		      <i class="mdi mdi-clock icon-lg text-primary d-flex align-items-center"></i>
		      <div class="d-flex flex-column ml-4">
		        <span class="d-flex flex-column">
		          <p class="mb-0"><?php 
        _e( "Most Visited Article", "apvc" );
        ?></p>
		          <h5 class="font-weight-bold"><?php 
        echo  $visits[0]->title ;
        ?>
		          <span class="text-muted"><a style="font-weight: normal; font-size: 14px !important;" href="<?php 
        echo  get_the_permalink( $visits[0]->article_id ) ;
        ?>" target="_blank"><?php 
        _e( "Link", "apvc" );
        ?></a></span></h5>
		        </span>
		      </div>
		    </div>
		</div>
		<?php 
        wp_die();
    }
    
    /**
     * Advanced Page Visit Counter Get first time visitors.
     *
     * @since    3.0.1
     */
    public function apvc_get_first_time_visitors()
    {
        global  $wpdb ;
        $table = APVC_DATA_TABLE;
        $sdate = date( 'Y-m-d 00:00:00' );
        $edate = date( 'Y-m-d 23:59:59' );
        $pedate = date( 'Y-m-d 00:00:00', strtotime( date( 'Y-m-d 0:0:0' ) . ' -30 day' ) );
        // echo "SELECT ip_address FROM ".APVC_DATA_TABLE." WHERE article_id != '' AND `date` >= '$sdate' GROUP BY ip_address";
        // echo '<Br />';
        // echo "SELECT ip_address FROM ".APVC_DATA_TABLE." WHERE article_id != '' AND `date` >= '$pedate' AND `date` < '$sdate' GROUP BY ip_address";
        
        if ( isset( $_REQUEST['day'] ) && !empty($_REQUEST['day']) ) {
            $ipsToday = get_transient( "apvc_fv_30_td" );
            
            if ( empty($ipsToday) ) {
                $ipsToday = $wpdb->get_results( "SELECT ip_address FROM " . APVC_DATA_TABLE . " WHERE article_id != '' AND `date` >= '{$sdate}' GROUP BY ip_address", ARRAY_N );
                set_transient( "apvc_fv_30_td", $ipsToday, HOURLY_REFRESH );
            }
            
            $ipsPast = get_transient( "apvc_fv_30_past" );
            
            if ( empty($ipsPast) ) {
                $ipsPast = $wpdb->get_results( "SELECT ip_address FROM " . APVC_DATA_TABLE . " WHERE article_id != '' AND `date` >= '{$pedate}' AND `date` < '{$sdate}' GROUP BY ip_address", ARRAY_N );
                set_transient( "apvc_fv_30_past", $ipsPast, HOURLY_REFRESH );
            }
        
        } else {
            $ipsToday = get_transient( "apvc_fv_td" );
            
            if ( empty($ipsToday) ) {
                $ipsToday = $wpdb->get_results( "SELECT ip_address FROM " . APVC_DATA_TABLE . " WHERE article_id != '' AND `date` >= '{$sdate}' AND `date` <= '{$edate}' GROUP BY ip_address", ARRAY_N );
                set_transient( "apvc_fv_td", $ipsToday, HOURLY_REFRESH );
            }
            
            $ipsPast = get_transient( "apvc_fv_past" );
            
            if ( empty($ipsPast) ) {
                $ipsPast = $wpdb->get_results( "SELECT ip_address FROM " . APVC_DATA_TABLE . " WHERE article_id != '' AND `date` >= '{$pedate}' AND `date` <= '{$sdate}'\t GROUP BY ip_address", ARRAY_N );
                set_transient( "apvc_fv_past", $ipsPast, HOURLY_REFRESH );
            }
        
        }
        
        $ipsToday = call_user_func_array( 'array_merge', $ipsToday );
        $ipsPast = call_user_func_array( 'array_merge', $ipsPast );
        
        if ( count( $ipsPast ) <= 0 ) {
            $fnCount = count( $ipsToday );
        } else {
            $fnCount = count( array_diff( $ipsToday, $ipsPast ) );
        }
        
        ?>
		<div class="card-body">
            <div class="d-flex justify-content-center">
              <i class="mdi mdi-human-greeting icon-lg text-success d-flex align-items-center"></i>
              <div class="d-flex flex-column ml-4">
                <span class="d-flex flex-column">
                  <p class="mb-0"><?php 
        _e( "First Time Visitors", "apvc" );
        ?></p>
                  <h4 class="font-weight-bold"><?php 
        echo  $fnCount ;
        ?></h4>
                </span>
              </div>
            </div>
          </div>
		<?php 
        wp_die();
    }
    
    /**
     * Advanced Page Visit Counter Get total visitors.
     *
     * @since    3.0.1
     */
    public function apvc_get_visitors()
    {
        global  $wpdb ;
        $table = APVC_DATA_TABLE;
        $sdate = date( 'Y-m-d 00:00:00' );
        $pedate = date( 'Y-m-d H:i:s', strtotime( date( 'Y-m-d 0:0:0' ) . ' -30 day' ) );
        
        if ( isset( $_REQUEST['day'] ) && !empty($_REQUEST['day']) ) {
            $q = " AND `date` >= '{$pedate}' AND `date` <= '{$sdate}' ";
            $visitors = get_transient( "apvc_get_visitors_mn_data" );
            
            if ( empty($visitors) ) {
                $visitors = count( $wpdb->get_results( "SELECT DISTINCT ip_address FROM " . APVC_DATA_TABLE . " WHERE article_id != '' " . $q ) );
                set_transient( "apvc_get_visitors_mn_data", $visitors, HOURLY_REFRESH );
            }
        
        } else {
            $q = " AND `date` >= '{$sdate}' ";
            $visitors = get_transient( "apvc_get_visitors_data" );
            
            if ( empty($visitors) ) {
                $visitors = count( $wpdb->get_results( "SELECT DISTINCT ip_address FROM " . APVC_DATA_TABLE . " WHERE article_id != '' " . $q ) );
                set_transient( "apvc_get_visitors_data", $visitors, HOURLY_REFRESH );
            }
        
        }
        
        ?>
		<div class="card-body">
	        <div class="d-flex justify-content-center">
	          <i class="mdi mdi-laptop icon-lg text-warning d-flex align-items-center"></i>
	          <div class="d-flex flex-column ml-4">
	            <span class="d-flex flex-column">
	              <p class="mb-0"><?php 
        _e( "Total Visitors", "apvc" );
        ?></p>
	              <h4 class="font-weight-bold"><?php 
        echo  $visitors ;
        ?></h4>
	            </span>
	          </div>
	        </div>
	      </div>
		<?php 
        wp_die();
    }
    
    /**
     * Advanced Page Visit Counter Get page views per visitor.
     *
     * @since    3.0.1
     */
    public function apvc_get_page_views_per_visitor()
    {
        global  $wpdb ;
        $table = APVC_DATA_TABLE;
        $today = date( 'Y-m-d 00:00:01' );
        $lstDate = date( 'Y-m-d 00:00:01', strtotime( date( 'Y-m-d 00:00:01' ) . ' -30 days' ) );
        
        if ( isset( $_REQUEST['day'] ) && !empty($_REQUEST['day']) ) {
            $q = " AND `date` >= '{$lstDate}' AND `date` <= '{$today}' ";
            $totalCounts = get_transient( "apvc_pvp_30_data" );
            
            if ( empty($totalCounts) ) {
                $totalCounts = count( $wpdb->get_results( "SELECT * FROM " . APVC_DATA_TABLE . " WHERE article_id != '' " . $q . " " ) );
                set_transient( "apvc_pvp_30_data", $totalCounts, HOURLY_REFRESH );
            }
            
            $ipCounts = get_transient( "apvc_pvp_ip_30_data" );
            
            if ( empty($ipCounts) ) {
                $ipCounts = count( $wpdb->get_results( "SELECT * FROM " . APVC_DATA_TABLE . " WHERE article_id != '' " . $q . "  GROUP BY ip_address" ) );
                set_transient( "apvc_pvp_ip_30_data", $ipCounts, HOURLY_REFRESH );
            }
        
        } else {
            $q = " AND `date` >= '{$today}' ";
            $totalCounts = get_transient( "apvc_pvp_daily_data" );
            
            if ( empty($totalCounts) ) {
                $totalCounts = count( $wpdb->get_results( "SELECT * FROM " . APVC_DATA_TABLE . " WHERE article_id != '' " . $q . " " ) );
                set_transient( "apvc_pvp_daily_data", $totalCounts, HOURLY_REFRESH );
            }
            
            $ipCounts = get_transient( "apvc_pvp_ip_daily_data" );
            
            if ( empty($ipCounts) ) {
                $ipCounts = count( $wpdb->get_results( "SELECT * FROM " . APVC_DATA_TABLE . " WHERE article_id != '' " . $q . "  GROUP BY ip_address" ) );
                set_transient( "apvc_pvp_ip_daily_data", $ipCounts, HOURLY_REFRESH );
            }
        
        }
        
        
        if ( $totalCounts > 0 && $ipCounts > 0 ) {
            $count = ( ceil( $totalCounts / $ipCounts ) !== 'NAN' ? ceil( $totalCounts / $ipCounts ) : "0" );
        } else {
            $count = 0;
        }
        
        ?>
		 <div class="card-body">
            <div class="d-flex justify-content-center">
              <i class="mdi mdi-earth icon-lg text-danger d-flex align-items-center"></i>
              <div class="d-flex flex-column ml-4">
                <span class="d-flex flex-column">
                  <p class="mb-0"><?php 
        _e( "Page Views Per Visitor", "apvc" );
        ?></p>
                  <h4 class="font-weight-bold"><?php 
        echo  $count ;
        ?></h4>
                </span>
              </div>
            </div>
          </div>
		<?php 
        wp_die();
    }
    
    /*
     * Advanced Page Visit Counter update the dashboard data.
     *
     * @since    3.0.6
     */
    public function apvc_dashboard_updated()
    {
        $recentUpdated = get_option( "avpc_recent_execution", true );
        echo  $this->apvc_get_human_time_diff( $recentUpdated ) ;
        wp_die();
    }
    
    /*
     * Advanced Page Visit Counter Refresh the dashboard with latest data.
     *
     * @since    3.0.6
     */
    public function apvc_refresh_dashboard()
    {
        foreach ( $this->transients as $transient ) {
            delete_transient( $transient );
        }
        $this->apvc_get_total_counts_of_the_year_data();
        $this->apvc_get_total_counts_of_the_month_data();
        $this->apvc_get_total_counts_of_the_week_data();
        $this->apvc_get_total_counts_daily_data();
        $this->apvc_get_browsers_stats_data();
        $this->apvc_get_referral_stats_data();
        $this->apvc_get_os_stats_data();
        $this->apvc_most_visited_article();
        $this->apvc_get_first_time_visitors();
        $this->apvc_get_visitors();
        $this->apvc_get_page_views_per_visitor();
    }
    
    /**
     * Advanced Page Visit Counter Get settings page data.
     *
     * @since    3.0.1
     */
    public function apvc_settings_page_content()
    {
        global  $wpdb ;
        $recentUpdated = get_option( "avpc_recent_execution", true );
        ?>
		<input type="hidden" id="current_page" value="dashboard">
	    <div class="container-fluid page-body-wrapper">
		    <div class="main-panel container">
			      <div class="content-wrapper">
			        <?php 
        $this->apvc_get_version_info_block();
        ?>
			        <div class="row">
			        	<div class="col-lg-12">
							<div class="hm_dash_heading">
								<h5 class="text-right"><?php 
        _e( "Dashboard Updated: <span id='apvc_dash_updated'>" . $this->apvc_get_human_time_diff( $recentUpdated ) . '</span>', "apvc" );
        ?><button type="button" id="apvc_update_dash" class="btn btn-primary btn-fw"><i class="mdi mdi-dna"></i><?php 
        echo  _e( "Update Now", "apvc" ) ;
        ?></button></h5>

							</div>
						</div>	
			          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 stretch-card">
			            <div class="card card-statistics" id="total_counts_year_data">
			             <?php 
        $this->apvc_loader_control();
        ?>
			            </div>
			          </div>
			          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 stretch-card">
			            <div class="card card-statistics" id="total_counts_month_data">
			            	<?php 
        $this->apvc_loader_control();
        ?>
			            </div>
			          </div>
			          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 stretch-card">
			            <div class="card card-statistics" id="total_counts_weeks_data">
			            	<?php 
        $this->apvc_loader_control();
        ?>
			            </div>
			          </div>
			          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 stretch-card">
			            <div class="card card-statistics" id="total_counts_daily_data">
			            	<?php 
        $this->apvc_loader_control();
        ?>
			            </div>
			          </div>

					<div class="col-lg-12">
						<div class="hm_heading">
							<h4 class="font-weight-semibold"><?php 
        _e( "Today", "apvc" );
        ?></h4>
						</div>
					</div>	
					<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 stretch-card adv_sts">
						<div class="card" id="apvc_visit_length">
						  	<?php 
        $this->apvc_loader_control();
        ?>
						</div>
					</div>

					<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 stretch-card adv_sts">
						<div class="card" id="apvc_total_visitors">
		                  	<?php 
        $this->apvc_loader_control();
        ?>
		                </div>
		            </div>

		            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 stretch-card adv_sts">
			            <div class="card" id="apvc_first_time_visitors">
		                 	<?php 
        $this->apvc_loader_control();
        ?>
		                </div>
		            </div>

		            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 stretch-card adv_sts">
			            <div class="card" id="apvc_post_views_per_user">
		                 	<?php 
        $this->apvc_loader_control();
        ?>
		                </div>
		            </div>

		            <div class="col-lg-12">
						<div class="hm_heading">
							<h4 class="font-weight-semibold"><?php 
        _e( "Last 30 Days", "apvc" );
        ?></h4>
						</div>
					</div>	
					<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 stretch-card adv_sts">
						<div class="card" id="apvc_visit_length_t">
						  	<?php 
        $this->apvc_loader_control();
        ?>
						</div>
					</div>

					<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 stretch-card adv_sts">
						<div class="card" id="apvc_total_visitors_t">
		                  	<?php 
        $this->apvc_loader_control();
        ?>
		                </div>
		            </div>

		            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 stretch-card adv_sts">
			            <div class="card" id="apvc_first_time_visitors_t">
		                 	<?php 
        $this->apvc_loader_control();
        ?>
		                </div>
		            </div>

		            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 stretch-card adv_sts">
			            <div class="card" id="apvc_post_views_per_user_t">
		                 	<?php 
        $this->apvc_loader_control();
        ?>
		                </div>
		            </div>

					<?php 
        ?>
					
					<div class="col-md-12 stretch-card">
						<div class="card">
						  <div class="card-header header-sm">
						    <div class="d-flex align-items-center">
						      <h4 class="card-title mb-0"><?php 
        echo  __( "Browser Traffic", "apvc" ) ;
        ?></h4>
						    </div>
						  </div>
						  <div class="card-body" id="apvc_browser_stats_data">
						  	<?php 
        $this->apvc_loader_control();
        ?>
						  </div>
						</div>
					</div>

					<div class="col-md-6 grid-margin stretch-card">
						<div class="card">
						  <div class="card-body">
						    <h4 class="card-title"><?php 
        echo  __( "Traffic source (Referral Websites)", "apvc" ) ;
        ?></h4>
						    <div class="row" id="apvc_referral_stats_data">
						    	<?php 
        $this->apvc_loader_control();
        ?>	
						    </div>
						  </div>
						</div>
					</div>
					<div class="col-md-6 grid-margin stretch-card">
						<div class="card">
						  <div class="card-body">
						    <h4 class="card-title"><?php 
        echo  __( "Traffic by Operating Systems", "apvc" ) ;
        ?></h4>
						    <div class="row" id="apvc_os_stats_data">
						      <?php 
        $this->apvc_loader_control();
        ?>
						    </div>
						  </div>
						</div>
					</div>
			      </div>
			    </div>
		  	</div>
    	</div>
		<?php 
    }
    
    /**
     * Advanced Page Visit Counter Get version info block.
     *
     * @since    3.0.1
     */
    public function apvc_get_version_info_block()
    {
        global  $wpdb ;
        $current_user = wp_get_current_user();
        if ( isset( $_GET['apvc_page'] ) ) {
            return;
        }
        ?>
		<div class="row add-block grid-margin">
          <div class="col-12 d-none d-lg-block">
            <div class="intro-banner">
              <div class="content-area">
                <h3 class="mb-0"><?php 
        echo  __( "Welcome back, " . $current_user->display_name . "!", "apvc" ) ;
        ?></h3>
                <?php 
        
        if ( apvc_fs()->is_not_paying() ) {
            ?>
                <p class="mb-0"><?php 
            _e( "Checkout our website for special promo offers and discounts. <a href='https://pagevisitcounter.com' target='_blank'>Visit</a>", "apvc" );
            ?></p>
            	<?php 
        }
        
        ?>
              </div>
              	<?php 
        echo  '<a target="_blank" href="' . apvc_fs()->get_upgrade_url() . '" class="btn btn-light">' . __( 'Upgrade Now!', 'apvc' ) . '</a>' ;
        echo  '<h6 class="mb-0 apvc_version">' . __( "Free Version " . $this->version, "apvc" ) . '</h6>' ;
        ?>

            </div>
          </div>
        </div>
		<?php 
    }
    
    /**
     * Advanced Page Visit Counter Get date is valid or not.
     *
     * @since    3.0.1
     */
    public function apvc_is_date( $str )
    {
        $str = str_replace( '/', '-', $str );
        //see explanation below for this replacement
        return is_numeric( strtotime( $str ) );
    }
    
    /**
     * Advanced Page Visit Counter Get top 10 pages data.
     *
     * @since    3.0.1
     */
    public function apvc_get_top_10_page_data()
    {
        global  $wpdb ;
        $table = APVC_DATA_TABLE;
        $where = '';
        $where = "  WHERE article_id != '' AND article_type = 'page' ";
        $top10Pages = $wpdb->get_results( "SELECT article_id, count(*) as count, ( SELECT post_title FROM {$wpdb->prefix}posts WHERE ID=article_id ) as title FROM {$table} " . $where . " GROUP BY article_id ORDER BY count DESC LIMIT 10" );
        return wp_json_encode( $top10Pages );
    }
    
    /**
     * Advanced Page Visit Counter Get top 10 posts data.
     *
     * @since    3.0.1
     */
    public function apvc_get_top_10_posts_data()
    {
        global  $wpdb ;
        $table = APVC_DATA_TABLE;
        $where = '';
        $where = " WHERE article_id != '' AND article_type NOT IN ('page','cart') ";
        $top10Posts = $wpdb->get_results( "SELECT article_id, count(*) as count, ( SELECT post_title FROM {$wpdb->prefix}posts WHERE ID=article_id ) as title FROM {$table} " . $where . " GROUP BY article_id ORDER BY count DESC LIMIT 10" );
        return wp_json_encode( $top10Posts );
    }
    
    /**
     * Advanced Page Visit Counter Get top 10 countries data.
     *
     * @since    3.0.1
     */
    public function apvc_get_top_10_contries_data()
    {
        global  $wpdb ;
        $table = APVC_DATA_TABLE;
        $where = '';
        $where = " WHERE country != '' ";
        $top10Country = $wpdb->get_results( "SELECT article_id, country, count(*) as count FROM {$table} " . $where . "  GROUP BY country ORDER BY count DESC LIMIT 10" );
        return wp_json_encode( $top10Country );
    }
    
    /**
     * Advanced Page Visit Counter Get top 10 ip address data.
     *
     * @since    3.0.1
     */
    public function apvc_get_top_10_ip_address_data()
    {
        global  $wpdb ;
        $table = APVC_DATA_TABLE;
        $where = '';
        $where = " WHERE ip_address != '' ";
        $top10iPAddress = $wpdb->get_results( "SELECT article_id, ip_address, country, count(*) as count FROM {$table} " . $where . " GROUP BY ip_address ORDER BY count DESC LIMIT 10" );
        return wp_json_encode( $top10iPAddress );
    }
    
    /**
     * Advanced Page Visit Counter Get human time difference data.
     *
     * @since    3.0.1
     */
    public function apvc_get_human_time_diff( $recentVisit )
    {
        $recentVisit = human_time_diff( strtotime( $recentVisit ), strtotime( date( "Y-m-d H:i:s" ) ) ) . __( ' ago', "apvc" );
        return $recentVisit;
    }
    
    /**
     * Advanced Page Visit Counter Get loader.
     *
     * @since    3.0.1
     */
    public function apvc_loader_control()
    {
        ?>
		<div class="loader-demo-box" style="border: none !important;">
          <div class="square-box-loader">
            <div class="square-box-loader-container">
              <div class="square-box-loader-corner-top"></div>
              <div class="square-box-loader-corner-bottom"></div>
            </div>
            <div class="square-box-loader-square"></div>
          </div>
        </div>
		<?php 
    }
    
    /**
     * Advanced Page Visit Counter Get top pages data.
     *
     * @since    3.0.1
     */
    public function apvc_get_top_pages_data()
    {
        global  $wpdb ;
        $top10Pages = json_decode( $this->apvc_get_top_10_page_data() );
        ?>
		  <div class="d-flex justify-content-between">
              <h4 class="card-title"><?php 
        echo  __( 'Top 10 Pages', 'apvc' ) ;
        ?></h4>
          </div>
            <?php 
        $count = 1;
        $count = 1;
        
        if ( count( $top10Pages ) <= 0 ) {
            echo  '<h5 class="text-center">' . __( "No Pages Found", "apvc" ) . '</h5>' ;
        } else {
            foreach ( $top10Pages as $pages ) {
                ?>
            <div class="list d-flex align-items-center border-bottom py-3">
              <div class="wrapper w-100 ml-3">
                <p class="mb-0"><b><?php 
                echo  $count++ ;
                ?>.</b> <?php 
                echo  __( $pages->title, "apvc" ) ;
                ?></p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center">
                    <i class="mdi mdi-clock text-muted mr-1"></i>
                  	<small class="text-muted ml-auto"><?php 
                echo  __( 'Recent Visit:', "apvc" ) ;
                ?> <b><?php 
                echo  $this->get_recent_visit( $pages->article_id ) ;
                ?></b></small>&nbsp;
                  	<small class="text-muted ml-auto"> <?php 
                echo  __( 'Total Visits:', 'apvc' ) ;
                ?> <b><?php 
                echo  __( $pages->count, "apvc" ) ;
                ?></b></small>
                  	<small class="text-muted ml-auto"><a href="<?php 
                echo  get_permalink( $pages->article_id ) ;
                ?>" target="_blank"><b>&nbsp;&nbsp;<?php 
                echo  __( 'Link', 'apvc' ) ;
                ?></b></a></small>

                  </div>
                </div>
              </div>
            </div>
       	<?php 
            }
        }
        
        wp_die();
    }
    
    /**
     * Advanced Page Visit Counter Get top posts data.
     *
     * @since    3.0.1
     */
    public function apvc_get_top_posts_data()
    {
        global  $wpdb ;
        $top10Posts = json_decode( $this->apvc_get_top_10_posts_data() );
        ?>
		<div class="d-flex justify-content-between">
          <h4 class="card-title"><?php 
        echo  __( 'Top 10 Posts', 'apvc' ) ;
        ?></h4>
        </div>
        <?php 
        $count = 1;
        
        if ( count( $top10Posts ) <= 0 ) {
            echo  '<h5 class="text-center">' . __( "No Posts Found", "apvc" ) . '</h5>' ;
        } else {
            foreach ( $top10Posts as $posts ) {
                ?>
        <div class="list d-flex align-items-center border-bottom py-3">
          <div class="wrapper w-100 ml-3">
            <p class="mb-0"><b><?php 
                echo  $count++ ;
                ?>.</b> <?php 
                echo  __( $posts->title, "apvc" ) ;
                ?></p>
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <i class="mdi mdi-clock text-muted mr-1"></i>
              	<small class="text-muted ml-auto"><?php 
                echo  __( 'Recent Visit:', "apvc" ) ;
                ?> <b><?php 
                echo  $this->get_recent_visit( $posts->article_id ) ;
                ?></b></small>&nbsp;
              	<small class="text-muted ml-auto"> <?php 
                echo  __( 'Total Visits:', 'apvc' ) ;
                ?> <b><?php 
                echo  __( $posts->count, "apvc" ) ;
                ?></b></small>
              	<small class="text-muted ml-auto"><a href="<?php 
                echo  get_permalink( $posts->article_id ) ;
                ?>" target="_blank"><b>&nbsp;&nbsp;<?php 
                echo  __( 'Link', 'apvc' ) ;
                ?></b></a></small>

              </div>
            </div>
          </div>
        </div>
    	<?php 
            }
        }
        
        wp_die();
    }
    
    /**
     * Advanced Page Visit Counter Get top countries data.
     *
     * @since    3.0.1
     */
    public function apvc_get_top_countries_data()
    {
        global  $wpdb ;
        $top10Country = json_decode( $this->apvc_get_top_10_contries_data() );
        ?>
		<div class="d-flex justify-content-between">
          <h4 class="card-title"><?php 
        echo  __( 'Top 10 Country', 'apvc' ) ;
        ?></h4>
        </div>
        <?php 
        $count = 1;
        
        if ( count( $top10Country ) <= 0 ) {
            echo  '<h5 class="text-center">' . __( "No Countries Found", "apvc" ) . '</h5>' ;
        } else {
            foreach ( $top10Country as $country ) {
                ?>
        <div class="list d-flex align-items-center border-bottom py-3">
          <div class="wrapper w-100 ml-3">
            <p class="mb-0"><b><?php 
                echo  $count++ ;
                ?>.</b> <?php 
                echo  __( $country->country, "apvc" ) ;
                ?>
            	
            <img width="20px" src="<?php 
                echo  plugin_dir_url( __FILE__ ) . "/images/flags/" . strtolower( $this->get_country_name( $country->country ) ) ;
                ?>.svg" alt="<?php 
                echo  $country->country ;
                ?>" title="<?php 
                echo  $country->country ;
                ?>">
        	</p>
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <i class="mdi mdi-clock text-muted mr-1"></i>
              	<small class="text-muted ml-auto"><?php 
                echo  __( 'Recent Visit:', "apvc" ) ;
                ?> <b><?php 
                echo  $this->get_recent_visit( $country->article_id ) ;
                ?></b></small>&nbsp;
              	<small class="text-muted ml-auto"> <?php 
                echo  __( 'Total Visits:', 'apvc' ) ;
                ?> <b><?php 
                echo  __( $country->count, "apvc" ) ;
                ?></b></small>
              	<small class="text-muted ml-auto"><a href="<?php 
                echo  get_permalink( $country->article_id ) ;
                ?>" target="_blank"><b>&nbsp;&nbsp;<?php 
                echo  __( 'Link', 'apvc' ) ;
                ?></b></a></small>

              </div>
            </div>
          </div>
        </div>
    	<?php 
            }
        }
        
        wp_die();
    }
    
    /**
     * Advanced Page Visit Counter Get top ip address data.
     *
     * @since    3.0.1
     */
    public function apvc_get_top_ip_address_data()
    {
        global  $wpdb ;
        $top10IPAddress = json_decode( $this->apvc_get_top_10_ip_address_data() );
        ?>
		<div class="d-flex justify-content-between">
          <h4 class="card-title"><?php 
        echo  __( 'Top 10 IP Addresses', 'apvc' ) ;
        ?></h4>
        </div>
        <?php 
        $count = 1;
        
        if ( count( $top10IPAddress ) <= 0 ) {
            echo  '<h5 class="text-center">' . __( "No IP Address Data Found", "apvc" ) . '</h5>' ;
        } else {
            foreach ( $top10IPAddress as $ip_address ) {
                ?>
        <div class="list d-flex align-items-center border-bottom py-3">
          <div class="wrapper w-100 ml-3">
            <p class="mb-0"><b><?php 
                echo  $count++ ;
                ?>.</b> <?php 
                echo  __( $ip_address->ip_address, "apvc" ) ;
                ?>
            <img width="20px" src="<?php 
                echo  plugin_dir_url( __FILE__ ) . "/images/flags/" . strtolower( $this->get_country_name( $ip_address->country ) ) ;
                ?>.svg" alt="<?php 
                echo  $this->get_country_name( $ip_address->country ) ;
                ?>" title="<?php 
                echo  $this->get_country_name( $ip_address->country ) ;
                ?>">
            </p>
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <i class="mdi mdi-clock text-muted mr-1"></i>
              	<small class="text-muted ml-auto"><?php 
                echo  __( 'Recent Visit:', "apvc" ) ;
                ?> <b><?php 
                echo  $this->get_recent_visit( $ip_address->ip_address, "ip_address" ) ;
                ?></b></small>&nbsp;
              	<small class="text-muted ml-auto"> <?php 
                echo  __( 'Total Visits:', 'apvc' ) ;
                ?> <b><?php 
                echo  __( $ip_address->count, "apvc" ) ;
                ?></b></small>
              	<small class="text-muted ml-auto"><a href="<?php 
                echo  get_permalink( $ip_address->article_id ) ;
                ?>" target="_blank"><b>&nbsp;&nbsp;<?php 
                echo  __( 'Link', 'apvc' ) ;
                ?></b></a></small>
              	
              </div>
            </div>
          </div>
        </div>
    	<?php 
            }
        }
        
        wp_die();
    }
    
    /**
     * Advanced Page Visit Counter Get trending pages data.
     *
     * @since    3.0.1
     */
    public function apvc_trending_page_content()
    {
        global  $wpdb ;
        ?>
		<input type="hidden" id="current_page" value="trending">
		<div class="container-fluid page-body-wrapper trending">
			<div class="main-panel container">
				<div class="content-wrapper">
					<?php 
        $this->apvc_get_version_info_block();
        ?>
					<div class="row">
						<?php 
        ?>
						
						<div class="col-12 col-md-12 col-lg-6 grid-margin stretch-card">
							<div class="card">
					          <div class="card-body" id="apvc_top_pages_data">
					          	<?php 
        $this->apvc_loader_control();
        ?>
					          </div>
       						</div>
				        </div>
				        <div class="col-12 col-md-12 col-lg-6 grid-margin stretch-card">
				            <div class="card">
				              <div class="card-body" id="apvc_top_posts_data">
				                <?php 
        $this->apvc_loader_control();
        ?>
				              </div>
				            </div>
				        </div>
				        <div class="col-12 col-md-12 col-lg-6 grid-margin stretch-card">
				            <div class="card">
				              <div class="card-body" id="apvc_top_countries_data">
				              	<?php 
        $this->apvc_loader_control();
        ?>
				              </div>
				            </div>
				        </div>
				        <div class="col-12 col-md-12 col-lg-6 grid-margin stretch-card">
				            <div class="card">
				              <div class="card-body" id="apvc_top_ip_address_data">
				                <?php 
        $this->apvc_loader_control();
        ?>
				              </div>
				            </div>
				        </div>
          			</div>
          		</div>
          	</div>
          </div>
		<?php 
    }
    
    /**
     * Advanced Page Visit Counter Get reports page data.
     *
     * @since    3.0.0
     */
    public function apvc_reports_page_content()
    {
        global  $wpdb ;
        
        if ( isset( $_GET['pageno'] ) ) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        
        $per_page = ( $_GET['per_page'] ? $_GET['per_page'] : 10 );
        $offset = ($pageno - 1) * $per_page;
        $apvcReports = json_decode( $this->get_the_reports( $offset, $per_page ) );
        $total_pages = ceil( $apvcReports->totalCount / $per_page );
        $dropDown = "";
        
        if ( $pageno == 0 ) {
            $rCnt = 1;
        } else {
            $rCnt = intval( $per_page ) * intval( $pageno - 1 ) + 1;
        }
        
        ?>
		<div class="container-fluid page-body-wrapper general-reports">
			<div class="main-panel container">
			  <div class="content-wrapper">
			  	<?php 
        $this->apvc_get_version_info_block();
        ?>
			  	<div class="row grid-margin">
			  		<?php 
        ?>
			  	</div>
			    <div class="card report_card col-md-12">
			      <div class="card-body">
			        <div class="row">
			          <div class=" table-responsive">
			          	<div class="apvc-detailed-filters">
				        	<div class="dropdown">
		                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php 
        echo  __( 'Articles Per Page - ' . $per_page, "apvc" ) ;
        ?></button>
		                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 35px, 0px);">
		                          <a class="dropdown-item" href="?page=apvc-dashboard-page&apvc_page=reports&pageno=<?php 
        echo  $pageno ;
        ?>&per_page=10<?php 
        echo  $dropDown ;
        ?>"><?php 
        echo  __( "10", "apvc" ) ;
        ?></a>
		                          <a class="dropdown-item" href="?page=apvc-dashboard-page&apvc_page=reports&pageno=<?php 
        echo  $pageno ;
        ?>&per_page=20<?php 
        echo  $dropDown ;
        ?>"><?php 
        echo  __( "20", "apvc" ) ;
        ?></a>
		                          <a class="dropdown-item" href="?page=apvc-dashboard-page&apvc_page=reports&pageno=<?php 
        echo  $pageno ;
        ?>&per_page=50<?php 
        echo  $dropDown ;
        ?>"><?php 
        echo  __( "50", "apvc" ) ;
        ?></a>
		                          <a class="dropdown-item" href="?page=apvc-dashboard-page&apvc_page=reports&pageno=<?php 
        echo  $pageno ;
        ?>&per_page=100<?php 
        echo  $dropDown ;
        ?>"><?php 
        echo  __( "100", "apvc" ) ;
        ?></a>
		                          <div class="dropdown-divider"></div>
		                          <a class="dropdown-item" href="?page=apvc-dashboard-page&apvc_page=reports&pageno=<?php 
        echo  $pageno ;
        ?>&per_page=500<?php 
        echo  $dropDown ;
        ?>"><?php 
        echo  __( "500", "apvc" ) ;
        ?></a>
		                        </div>
		                    </div>
	                    </div>
			            <table id="reports-listinga" class="table">
			              <thead>
			                <tr>
			                  <th><?php 
        echo  __( "No.", "apvc" ) ;
        ?></th>
			                  <th><?php 
        echo  __( "Article ID", "apvc" ) ;
        ?></th>
			                  <th><?php 
        echo  __( "Article Title", "apvc" ) ;
        ?></th>
			                  <th><?php 
        echo  __( "Total Visits Count", "apvc" ) ;
        ?></th>
			                  <th><?php 
        echo  __( "Recent Visit", "apvc" ) ;
        ?></th>
			                  <th><?php 
        echo  __( "Detailed Report", "apvc" ) ;
        ?></th>
			                </tr>
			              </thead>
			              <tbody>
			              	<?php 
        foreach ( $apvcReports->list as $reports ) {
            echo  '<tr>
			              				  <td>' . $rCnt++ . '</td>
						                  <td>' . $reports->article_id . '</td>
						                  <td><div class="apvc_title">' . __( $reports->title, "apvc" ) . '</div></td>
						                  <td>' . $reports->count . '</td>
						                  <td><i class="mdi mdi-clock"></i> ' . $this->get_recent_visit( $reports->article_id ) . '</td>
						                  <td>
						                    <a href="' . get_admin_url( get_current_blog_id(), "admin.php?page=apvc-dashboard-page&apvc_page=detailed-reports&article_id=" . $reports->article_id . $dropDown . "" ) . '" class="btn btn-outline-primary">' . __( 'Detailed Report', "apvc" ) . '</a>
						                  </td>
						                </tr>' ;
        }
        ?>
			                
			              </tbody>
			            </table>

			            <nav>
							<ul class="pagination d-flex justify-content-center">
								<li class="page-item"><a class="page-link" href="?page=apvc-dashboard-page&apvc_page=reports&pageno=1<?php 
        echo  $per_page_var ;
        ?>"><?php 
        echo  __( 'First', "apvc" ) ;
        ?></a></li>
								<li class="page-item <?php 
        if ( $pageno <= 1 ) {
            echo  'disabled' ;
        }
        ?>">
								    <a class="page-link" href="<?php 
        
        if ( $pageno <= 1 ) {
            echo  '#' ;
        } else {
            echo  "?page=apvc-dashboard-page&apvc_page=reports&pageno=" . ($pageno - 1) ;
        }
        
        echo  $per_page_var ;
        ?>"><?php 
        echo  __( 'Prev', "apvc" ) ;
        ?></a>
								</li>
								<li class="page-item <?php 
        if ( $pageno >= $total_pages ) {
            echo  'disabled' ;
        }
        ?>">
								    <a class="page-link" href="<?php 
        
        if ( $pageno >= $total_pages ) {
            echo  '#' ;
        } else {
            echo  "?page=apvc-dashboard-page&apvc_page=reports&pageno=" . ($pageno + 1) ;
        }
        
        echo  $per_page_var ;
        ?>"><?php 
        echo  __( 'Next', "apvc" ) ;
        ?></a>
								</li>
								<li class="page-item"><a class="page-link" href="?page=apvc-dashboard-page&apvc_page=reports&pageno=<?php 
        echo  $total_pages ;
        echo  $per_page_var ;
        ?>"><?php 
        echo  __( 'Last', "apvc" ) ;
        ?> (<?php 
        echo  $total_pages ;
        ?>)</a></li>
							</ul>
                    	</nav>
			          </div>
			        </div>
			      </div>
			    </div>
			  </div>
			</div>
		</div>
		<?php 
    }
    
    /**
     * Advanced Page Visit Counter Get total reports.
     *
     * @since    3.0.1
     */
    public function get_the_reports_for_countries( $offset, $no_of_records_per_page, $country )
    {
        global  $wpdb ;
        $table = APVC_DATA_TABLE;
        $where = '';
        $d = $_REQUEST['d'];
        $e = $_REQUEST['e'];
        
        if ( $d != 0 && !$this->apvc_is_date( $d ) ) {
            $days_ago = date( 'Y-m-d', time() - $d * SECONDS_PER_DAY );
            $where = " WHERE date >= '{$days_ago}' AND country = '{$country}' ";
        } else {
            
            if ( $this->apvc_is_date( $d ) && $this->apvc_is_date( $e ) ) {
                $where = " WHERE date >= '{$d}' AND date <= '{$e}' AND country = '{$country}' ";
            } else {
                $where = " WHERE country = '{$country}' ";
            }
        
        }
        
        $totalCount = count( $wpdb->get_results( "SELECT article_id FROM {$table} " . $where . " GROUP BY article_id" ) );
        $apvcReports = $wpdb->get_results( "SELECT COUNT(*) as count, article_id, ( SELECT post_title FROM {$wpdb->prefix}posts WHERE ID=article_id ) as title FROM {$table} " . $where . " GROUP BY article_id ORDER BY count DESC LIMIT {$offset}, {$no_of_records_per_page}" );
        return wp_json_encode( array(
            "totalCount" => $totalCount,
            "list"       => $apvcReports,
        ) );
    }
    
    /**
     * Advanced Page Visit Counter Get detailed reports.
     *
     * @since    3.0.1
     */
    public function apvc_detailed_reports_page_content()
    {
        global  $wpdb ;
        $tbl_history = APVC_DATA_TABLE;
        $dropDown = "";
        $g_checked = ( $_REQUEST['u_g'] == 'on' ? "checked" : "" );
        $rg_checked = ( $_REQUEST['u_r'] == 'on' ? "checked" : "" );
        
        if ( isset( $_GET['pageno'] ) ) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        
        $per_page = ( $_GET['per_page'] ? $_GET['per_page'] : 20 );
        $offset = ($pageno - 1) * $per_page;
        $article_id = ( $_GET['article_id'] ? $_GET['article_id'] : "" );
        $apvcDetailed = json_decode( $this->get_the_detailed_reports( $article_id, $offset, $per_page ) );
        $total_pages = ceil( $apvcDetailed->totalCount / $per_page );
        
        if ( $pageno == 0 ) {
            $cnt = 1;
        } else {
            $cnt = intval( $per_page ) * intval( $pageno - 1 ) + 1;
        }
        
        ?>
		<input type="hidden" id="current_page" value="detailed-reports">
		<div class="container-fluid page-body-wrapper">
			<div class="main-panel container">
			  <div class="content-wrapper">
			  	<?php 
        $this->apvc_get_version_info_block();
        ?>
			  	
			  	<?php 
        ?>
				
			    <div class="card report_card col-md-12">
			      <div class="card-body">
			        <div class="row">
			        	<div class="apvc-detailed-filters">
				        	<div class="dropdown">
		                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php 
        echo  __( 'Articles Per Page - ' . $per_page, "apvc" ) ;
        ?></button>
		                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1" x-placement="bottom-start">
		                          <a class="dropdown-item" href="?page=apvc-dashboard-page&apvc_page=detailed-reports&article_id=<?php 
        echo  $article_id ;
        ?>&pageno=<?php 
        echo  $pageno ;
        ?>&per_page=10<?php 
        echo  $dropDown ;
        ?>"><?php 
        echo  __( "10", "apvc" ) ;
        ?></a>
		                          <a class="dropdown-item" href="?page=apvc-dashboard-page&apvc_page=detailed-reports&article_id=<?php 
        echo  $article_id ;
        ?>&pageno=<?php 
        echo  $pageno ;
        ?>&per_page=20<?php 
        echo  $dropDown ;
        ?>"><?php 
        echo  __( "20", "apvc" ) ;
        ?></a>
		                          <a class="dropdown-item" href="?page=apvc-dashboard-page&apvc_page=detailed-reports&article_id=<?php 
        echo  $article_id ;
        ?>&pageno=<?php 
        echo  $pageno ;
        ?>&per_page=50<?php 
        echo  $dropDown ;
        ?>"><?php 
        echo  __( "50", "apvc" ) ;
        ?></a>
		                          <a class="dropdown-item" href="?page=apvc-dashboard-page&apvc_page=detailed-reports&article_id=<?php 
        echo  $article_id ;
        ?>&pageno=<?php 
        echo  $pageno ;
        ?>&per_page=100<?php 
        echo  $dropDown ;
        ?>"><?php 
        echo  __( "100", "apvc" ) ;
        ?></a>
		                          <div class="dropdown-divider"></div>
		                          <a class="dropdown-item" href="?page=apvc-dashboard-page&apvc_page=detailed-reports&article_id=<?php 
        echo  $article_id ;
        ?>&pageno=<?php 
        echo  $pageno ;
        ?>&per_page=500<?php 
        echo  $dropDown ;
        ?>"><?php 
        echo  __( "500", "apvc" ) ;
        ?></a>
		                        </div>
		                    </div>
		                     <a type="button" href="?page=apvc-dashboard-page&apvc_page=reports" class="btn btn-primary btn-fw buttona"><i class="mdi mdi-arrow-left-bold-circle"></i><?php 
        echo  __( "Back To Reports", "apvc" ) ;
        ?></a>
	                    </div>
			          <div class=" table-responsive">
			            <table id="reports-listing-detailed" class="table">
			              <thead>
			                <tr>
			                  <th><?php 
        _e( "No.", "apvc" );
        ?></th>
			                  <th><?php 
        _e( "Article Title", "apvc" );
        ?></th>
			                  <th><?php 
        _e( "Article Type", "apvc" );
        ?></th>
			                  <th><?php 
        _e( "User Type", "apvc" );
        ?></th>
			                  <th><?php 
        _e( "Visited Date", "apvc" );
        ?></th>
			                  <th><?php 
        _e( "IP Address", "apvc" );
        ?></th>
			                  <th><?php 
        _e( "Browser Info", "apvc" );
        ?></th>
			                  <th><?php 
        _e( "Referrer URL", "apvc" );
        ?></th>
			                </tr>
			              </thead>
			              <tbody>
			              	<?php 
        
        if ( count( $apvcDetailed->list ) > 0 ) {
            foreach ( $apvcDetailed->list as $reports ) {
                echo  '<tr>
						                  <td>' . $cnt++ . '</td>
						                  <td><div class="ap_width">' . __( $reports->title, "apvc" ) . '</div></td>
						                  <td>' . ucfirst( __( $reports->article_type, "apvc" ) ) . '</td>
						                  <td>' . __( $reports->user_type, "apvc" ) . '</td>
						                  <td>' . __( $reports->date, "apvc" ) . '</td>
						                  <td><div class="ap_width">' . __( $reports->ip_address, "apvc" ) . '</div></td>
						                  <td class="apvc_geo_stats"><span style="color:#007bff;">' . __( "Browser: ", "apvc" ) . '</span>' . ucwords( $reports->browser_short_name ) . '<br /><span style="color:#d84545;">' . __( "OS: ", "apvc" ) . '</span>' . ucwords( $reports->operating_system ) . '<br /><span style="color:#b93db5;">' . __( "Device: ", "apvc" ) . '</span>' . ucwords( $reports->device_type ) . '<br /><span style="color:#d84545;">' . __( "Country: ", "apvc" ) . '</span>' . ucwords( $reports->country ) . ' <br /><img style="border-radius: 0px; width: 20px; height: 20px; margin-top: 5px; min-width:20px;" src="' . plugin_dir_url( __FILE__ ) . "/images/flags/" . strtolower( $this->get_country_name( $reports->country ) ) . '.svg" alt="' . $reports->country . '" title="' . $reports->country . '"></td>
						                  <td><div class="ap_width">' . __( $reports->http_referer_clean, "apvc" ) . '<br/><a href="' . $reports->http_referer . '" target="_blank"><small class="text-muted" styword-break: break-word;">' . __( $reports->http_referer, "apvc" ) . '</small></a></div></td>
						                </tr>' ;
            }
        } else {
            echo  '<tr><td colspan="8" class="text-center">No Records Found</td></tr>' ;
        }
        
        ?>
			                
			              </tbody>
			            </table>

			            <nav>
							<ul class="pagination d-flex justify-content-center">
								<li class="page-item"><a class="page-link" href="?page=apvc-dashboard-page&apvc_page=detailed-reports&article_id=<?php 
        echo  $article_id ;
        ?>&pageno=1<?php 
        echo  $per_page_var ;
        ?>"><?php 
        echo  __( 'First', "apvc" ) ;
        ?></a></li>
								<li class="page-item <?php 
        if ( $pageno <= 1 ) {
            echo  'disabled' ;
        }
        ?>">
								    <a class="page-link" href="<?php 
        
        if ( $pageno <= 1 ) {
            echo  '#' ;
        } else {
            echo  "?page=apvc-dashboard-page&apvc_page=detailed-reports&article_id=" . $article_id . "&pageno=" . ($pageno - 1) ;
        }
        
        echo  $per_page_var ;
        ?>"><?php 
        echo  __( 'Prev', "apvc" ) ;
        ?></a>
								</li>
								<li class="page-item <?php 
        if ( $pageno >= $total_pages ) {
            echo  'disabled' ;
        }
        ?>">
								    <a class="page-link" href="<?php 
        
        if ( $pageno >= $total_pages ) {
            echo  '#' ;
        } else {
            echo  "?page=apvc-dashboard-page&apvc_page=detailed-reports&article_id=" . $article_id . "&pageno=" . ($pageno + 1) ;
        }
        
        echo  $per_page_var ;
        ?>"><?php 
        echo  __( 'Next', "apvc" ) ;
        ?></a>
								</li>
								<li class="page-item"><a class="page-link" href="?page=apvc-dashboard-page&apvc_page=detailed-reports&article_id=<?php 
        echo  $article_id ;
        ?>&pageno=<?php 
        echo  $total_pages ;
        echo  $per_page_var ;
        ?>"><?php 
        echo  __( 'Last', "apvc" ) ;
        ?> (<?php 
        echo  $total_pages ;
        ?>)</a></li>
							</ul>
	                    </nav>
			          </div>
			        </div>
			      </div>
			    </div>
			  </div>
			</div>
		</div>
		<?php 
    }
    
    /**
     * Advanced Page Visit Counter Get dashboard page.
     *
     * @since    3.0.1
     */
    public function apvc_dashboard_page()
    {
        global  $wpdb ;
        ?>
		<div class="container-scroller hidden-xs">
			<nav class="navbar horizontal-layout col-lg-12 col-12 p-0">
		        <div class="container d-flex flex-row nav-top">
		          <div class="text-center navbar-brand-wrapper d-flex align-items-top">
		            <a class="navbar-brand brand-logo" href="admin.php?page=apvc-dashboard-page">
		              <img src="<?php 
        echo  plugin_dir_url( __FILE__ ) . "/images/apvc-logo-large.png" ;
        ?>" alt="logo"> </a>
		          </div>
		        </div>
		        <div class="nav-bottom">
		          <div class="container">
		            <ul class="nav page-navigation">
		              <li class="nav-item <?php 
        echo  ( $_GET['page'] == 'apvc-dashboard-page' && $_GET['apvc_page'] == '' ? "menu-active" : "" ) ;
        ?>">
		                <a href="<?php 
        echo  get_admin_url( get_current_blog_id(), "admin.php?page=apvc-dashboard-page" ) ;
        ?>" class="nav-link">
		                  <i class="link-icon mdi mdi-airplay"></i>
		                  <span class="menu-title"><?php 
        echo  __( "Dashboard", "apvc" ) ;
        ?></span>
		                </a>
		              </li>
		              <li class="nav-item <?php 
        echo  ( $_GET['page'] == 'apvc-dashboard-page' && $_GET['apvc_page'] == 'trending' ? "menu-active" : "" ) ;
        ?>">
		                <a href="<?php 
        echo  get_admin_url( get_current_blog_id(), "admin.php?page=apvc-dashboard-page&apvc_page=trending" ) ;
        ?>" class="nav-link">
		                  <i class="link-icon mdi mdi-chart-line"></i>
		                  <span class="menu-title"><?php 
        echo  __( "Trending", "apvc" ) ;
        ?></span>
		                </a>
		              </li>
		              <li class="nav-item <?php 
        echo  ( $_GET['page'] == 'apvc-dashboard-page' && $_GET['apvc_page'] == 'reports' || $_GET['apvc_page'] == 'detailed-reports' ? "menu-active" : "" ) ;
        ?>">
		                <a href="<?php 
        echo  get_admin_url( get_current_blog_id(), "admin.php?page=apvc-dashboard-page&apvc_page=reports" ) ;
        ?>" class="nav-link">
		                  <i class="link-icon mdi mdi-content-copy"></i>
		                  <span class="menu-title"><?php 
        echo  __( "Reports", "apvc" ) ;
        ?></span>
		                </a>
		                <?php 
        ?>
		              </li>
		              <li class="nav-item <?php 
        echo  ( $_GET['page'] == 'apvc-dashboard-page' && $_GET['apvc_page'] == 'shortcode_generator' || $_GET['apvc_page'] == 'shortcode_library' ? "menu-active" : "" ) ;
        ?>">
		                <a href="<?php 
        echo  get_admin_url( get_current_blog_id(), "admin.php?page=apvc-dashboard-page&apvc_page=shortcode_generator" ) ;
        ?>" class="nav-link">
		                  <i class="link-icon mdi mdi-palette"></i>
		                  <span class="menu-title"><?php 
        echo  __( "Shortcode Generator", "apvc" ) ;
        ?></span>
		                </a>
		                <div class="submenu ">
		                  <ul class="submenu-item ">
		                    <li class="nav-item ">
		                      <a href="<?php 
        echo  get_admin_url( get_current_blog_id(), "admin.php?page=apvc-dashboard-page&apvc_page=shortcode_library" ) ;
        ?>" class="nav-link">
			                  <?php 
        echo  __( "Shortcode Library", "apvc" ) ;
        ?>
			                </a>
		                    </li>
		                  </ul>
		                </div>
		              </li>
		              <li class="nav-item <?php 
        echo  ( $_GET['page'] == 'apvc-dashboard-page' && $_GET['apvc_page'] == 'settings' ? "menu-active" : "" ) ;
        ?>">
		                <a href="<?php 
        echo  get_admin_url( get_current_blog_id(), "admin.php?page=apvc-dashboard-page&apvc_page=settings" ) ;
        ?>" class="nav-link">
		                  <i class="link-icon mdi mdi-settings-box"></i>
		                  <span class="menu-title"><?php 
        echo  __( "Settings", "apvc" ) ;
        ?></span>
		                </a>
		              </li>
		              <?php 
        ?>
		            </ul>
		          </div>
		        </div>
		      </nav>
		</div>
		<?php 
        
        if ( isset( $_GET['apvc_page'] ) && $_GET['apvc_page'] === 'trending' ) {
            $this->apvc_trending_page_content();
        } else {
            
            if ( isset( $_GET['apvc_page'] ) && $_GET['apvc_page'] === 'reports' && !isset( $_GET['article_id'] ) ) {
                $this->apvc_reports_page_content();
            } else {
                
                if ( isset( $_GET['apvc_page'] ) && isset( $_GET['article_id'] ) && $_GET['apvc_page'] === 'detailed-reports' && $_GET['article_id'] != '' ) {
                    $this->apvc_detailed_reports_page_content();
                } else {
                    
                    if ( isset( $_GET['apvc_page'] ) && isset( $_GET['article_id'] ) && $_GET['apvc_page'] === 'country_reports-detailed' && $_GET['article_id'] != '' ) {
                        $this->apvc_detailed_reports_for_the_country_content__premium_only();
                    } else {
                        
                        if ( isset( $_GET['apvc_page'] ) && isset( $_GET['country'] ) && $_GET['apvc_page'] === 'country_reports-list' && $_GET['country'] != '' ) {
                            $this->country_reports_in_detailed__premium_only();
                        } else {
                            
                            if ( isset( $_GET['apvc_page'] ) && $_GET['apvc_page'] === 'settings' ) {
                                $this->apvc_reports_settings_page();
                            } else {
                                
                                if ( isset( $_GET['apvc_page'] ) && $_GET['apvc_page'] === 'country_reports' ) {
                                    $this->country_reports__premium_only();
                                } else {
                                    
                                    if ( isset( $_GET['apvc_page'] ) && $_GET['apvc_page'] === 'shortcode_generator' ) {
                                        $this->apvc_shortcode_generator_page();
                                    } else {
                                        
                                        if ( isset( $_GET['apvc_page'] ) && $_GET['apvc_page'] === 'export_data' ) {
                                            $this->apvc_export_data_page__premium_only();
                                        } else {
                                            
                                            if ( isset( $_GET['apvc_page'] ) && $_GET['apvc_page'] === 'import_data' ) {
                                                $this->apvc_import_data_page__premium_only();
                                            } else {
                                                
                                                if ( isset( $_GET['apvc_page'] ) && $_GET['apvc_page'] === 'cleanup_data' ) {
                                                    $this->apvc_cleanup_data_page__premium_only();
                                                } else {
                                                    
                                                    if ( isset( $_GET['apvc_page'] ) && $_GET['apvc_page'] === 'shortcode_library' ) {
                                                        $this->apvc_shortcode_library();
                                                    } else {
                                                        $this->apvc_settings_page_content();
                                                    }
                                                
                                                }
                                            
                                            }
                                        
                                        }
                                    
                                    }
                                
                                }
                            
                            }
                        
                        }
                    
                    }
                
                }
            
            }
        
        }
        
        ?>
		<footer class="footer">
	        <div class="container clearfix">
	          <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"><?php 
        echo  __( "Hand-crafted & made with", "apvc" ) ;
        ?> <i class="mdi mdi-heart text-danger"></i>&nbsp; <a class="text-danger" href="https://pagevisitcounter.com" target="_blank"><?php 
        echo  __( "Page Visit Counter", "apvc" ) ;
        ?></a>
	          </span>
	        </div>
	    </footer>
		<?php 
    }
    
    /**
     * Advanced Page Visit Counter Get Premier Features.
     *
     * @since    3.0.1
     */
    public function apvc_get_premium_features_block()
    {
        echo  '<div class="row">
			<div class="col-lg-12 grid-margin stretch-card">
				<div class="card">
					<div class="card-body"><h4 class="text-center">' . __( 'OUR GREAT PLUGINS', 'apvc' ) . '</h4>' ;
        ?>
					<ul>
						<li>
							<strong>1.</strong> <a href="https://wordpress.org/plugins/hide-admin-bar-based-on-user-roles/" target="_blank"><?php 
        _e( "Hide Admin Bar Based on User Roles", "apvc" );
        ?></a><br /><p class="text-muted">This plugin is very useful to hide admin bar based on selected user roles and user capabilities.</p>
						</li>
						<li>
							<strong>2.</strong> <a href="https://wordpress.org/plugins/disable-block-editor-fullscreen-mode/" target="_blank"><?php 
        _e( "Disable Block Editor FullScreen mode", "apvc" );
        ?></a><br /><p class="text-muted">This plugin is useful to Disable Block Editor default FullScreen mode in Latest WordPress 5.4+</p>
						</li>
						<li>
							<strong>3.</strong> <a href="https://wordpress.org/plugins/blog-security-auditor/" target="_blank"><?php 
        _e( "Blog Security Auditor", "apvc" );
        ?></a><br /><p class="text-muted">This plugin audits your site for specific security related checkpoints.</p>
						</li>
					</ul>
					<div class="text-center">
						<h5 class="text-center">Checkout our website for special promo offers and discounts.</h5>
						<a href="https://pagevisitcounter.com" target="_blank" class="btn btn-primary btn-fw"><i class="mdi mdi-heart-outline"></i>Visit Now</a>
					</div>
					<?php 
        echo  '
	    			</div>
				</div>
			</div>' ;
    }
    
    /**
     * Advanced Page Visit Counter Get reports settings data.
     *
     * @since    3.0.1
     */
    public function apvc_reports_settings_page()
    {
        global  $wpdb, $post ;
        $avc_config = (object) get_option( "apvc_configurations", true );
        ?>
		<div class="container-fluid page-body-wrapper avpc-settings-page">
		    <div class="main-panel container">
		      <div class="content-wrapper">
		        <?php 
        $this->apvc_get_version_info_block();
        ?>
		        <div class="row">

			        <div class="col-lg-8 grid-margin stretch-card">
		                <div class="card">
		                  <div class="card-body">
		                  	
		                  	<?php 
        
        if ( isset( $_GET['m'] ) && $_GET['m'] === 'success' && !isset( $_GET['t'] ) ) {
            echo  '<div class="alert alert-success" role="alert">' . __( "Settings have been saved successfully", "apvc" ) . '</div>' ;
        } else {
            if ( isset( $_GET['m'] ) && $_GET['m'] === 'success' && isset( $_GET['t'] ) && $_GET['t'] === 'reset' ) {
                echo  '<div class="alert alert-success" role="alert">' . __( "Settings reset successfully.", "apvc" ) . '</div>' ;
            }
        }
        
        ?>

		                    <h4 class="card-title"><?php 
        echo  __( "Settings", "apvc" ) ;
        ?></h4>
		                    <form class="form-sample" id="apvc_settings_form">
		                      <div class="row">
		                        <div class="col-md-12">
		                          <div class="form-group card-body">
			                          <label><?php 
        echo  __( "Post Types", "apvc" ) ;
        ?></label>
			                          <select id="apvc_post_types" name="apvc_post_types" class="apvc-post-types-select" multiple="multiple" style="width:100%">
			                          <?php 
        $avc_post_types = get_post_types();
        foreach ( $avc_post_types as $avc_pt ) {
            
            if ( in_array( $avc_pt, $avc_config->apvc_post_types ) ) {
                $selected = 'selected="selected"';
            } else {
                $selected = "";
            }
            
            echo  '<option value="' . esc_html( $avc_pt ) . '" ' . $selected . '>' . esc_html( $avc_pt ) . '</option>' ;
        }
        ?>
			                          </select>
			                        </div>
		                        </div>
		                        <div class="col-md-12">
		                        	<div class="form-group">
			                          <div class="card-body">
			                          	<label><?php 
        echo  __( "Exclude IP Addresses", "apvc" ) ;
        ?></label>
				                        <input name="apvc_ip_address" id="apvc_ip_address" value="<?php 
        echo  ( !empty($avc_config->apvc_ip_address) ? implode( ",", $avc_config->apvc_ip_address ) : '' ) ;
        ?>" />
				                      </div>
				                  </div>
		                        </div>
		                        <div class="col-md-12">
		                        	<div class="form-group">
			                          <div class="card-body">
			                          	<label><?php 
        echo  __( "Exclude Post/Pages Counts", "apvc" ) ;
        ?></label>
				                        <input name="apvc_exclude_counts" id="apvc_exclude_counts" value="<?php 
        echo  ( !empty($avc_config->apvc_exclude_counts) ? implode( ",", $avc_config->apvc_exclude_counts ) : '' ) ;
        ?>" />

				                      </div>
				                  </div>
		                        </div>
		                        <div class="col-md-12">
		                        	<div class="form-group">
			                          <div class="card-body">
			                          	<label><?php 
        echo  __( "Exclude Showing Counter Widget on Pages/Posts", "apvc" ) ;
        ?></label>
				                        <input name="apvc_exclude_show_counter" id="apvc_exclude_show_counter" value="<?php 
        echo  ( !empty($avc_config->apvc_exclude_show_counter) ? implode( ",", $avc_config->apvc_exclude_show_counter ) : '' ) ;
        ?>" />
				                      </div>
				                  </div>
		                        </div>
		                        <div class="col-md-12">
		                        	<div class="form-group">
			                          <div class="card-body">
			                          	<label><?php 
        echo  __( "Exclude User", "apvc" ) ;
        ?></label>
				                         <select id="apvc_exclude_users" name="apvc_exclude_users" class="apvc-post-types-select" multiple="multiple" style="width:100%">
			                          <?php 
        $avc_users = get_users();
        foreach ( $avc_users as $avc_usr ) {
            
            if ( in_array( $avc_usr->ID, $avc_config->apvc_exclude_users ) ) {
                $selected = 'selected="selected"';
            } else {
                $selected = "";
            }
            
            echo  '<option value="' . esc_html( $avc_usr->ID ) . '" ' . $selected . '>' . esc_html( $avc_usr->display_name ) . '</option>' ;
        }
        ?>
			                          </select>
				                      </div>
				                  </div>
		                        </div>
		                        <div class="col-md-12">
		                        	<div class="form-group">
			                          <div class="card-body">
				                        <div class="icheck-square">
				                          <input tabindex="6" type="checkbox" id="apvc_spam_controller" name="apvc_spam_controller" <?php 
        if ( $avc_config->apvc_spam_controller[0] == "on" ) {
            echo  "checked" ;
        }
        ?>><label for="square-checkbox-2"><?php 
        echo  __( "Spam Controller", "apvc" ) ;
        ?></label>
				                          <br />
				                          <small class="text-muted"><?php 
        echo  __( "*This setting will ignore visit counts comes from spammers or continues refresh browser windows. ( by enabling this settings we count 1 visit in every 5 minutes from each ip address )", "apvc" ) ;
        ?></small>
				                        </div>
				                      </div>
				                	</div>
				            	</div>
		                      </div>
		                      <hr />
		                      <h4 class="card-title"><?php 
        echo  __( "Widget Styling", "apvc" ) ;
        ?></h4>
		                      <div class="row">
		                      	<div class="col-md-6">
			                      	<div class="card-body">
										<div class="form-group">
					                      <label for="show_conter_on_front_side">
					                      	<?php 
        echo  __( "Show Counter on Front End", "apvc" ) ;
        ?>
					                      	</label><Br />
					                      <select class="form-control" id="apvc_show_conter_on_front_side" name="apvc_show_conter_on_front_side">
									      	<option value="" disabled selected><?php 
        echo  __( "Choose your option", "apvc" ) ;
        ?></option>
											<option value="disable" selected=""><?php 
        echo  __( "Hide", "apvc" ) ;
        ?></option>
									        <option value="above_the_content" <?php 
        if ( $avc_config->apvc_show_conter_on_front_side[0] == "above_the_content" ) {
            echo  "selected" ;
        }
        ?>><?php 
        echo  __( "Above the content", "apvc" ) ;
        ?></option>
									        <option value="below_the_content" <?php 
        if ( $avc_config->apvc_show_conter_on_front_side[0] == "below_the_content" ) {
            echo  "selected" ;
        }
        ?>><?php 
        echo  __( "Below the content", "apvc" ) ;
        ?></option>
									    </select>
					                    </div>
				                    </div>
				                </div>
				                <div class="col-md-6">
			                      	<div class="card-body">
										<div class="form-group">
					                      <label for="apvc_default_text_color"><?php 
        echo  __( "Default Counter Text Color", "apvc" ) ;
        ?></label>
                        					<input type='text' class="color-picker" id="apvc_default_text_color" name="apvc_default_text_color" value="<?php 
        echo  $avc_config->apvc_default_text_color[0] ;
        ?>" />
					                    </div>
				                    </div>
				                </div>
				                <div class="col-md-6">
			                      	<div class="card-body">
										<div class="form-group">
					                      <label><?php 
        echo  __( "Default Counter Border Color", "apvc" ) ;
        ?></label>
                        					<input id="apvc_default_border_color" name="apvc_default_border_color" type='text' class="color-picker" value="<?php 
        echo  $avc_config->apvc_default_border_color[0] ;
        ?>" id="apvc_default_border_color" />
					                    </div>
				                    </div>
				                </div>
				                <div class="col-md-6">
			                      	<div class="card-body">
										<div class="form-group">
					                      <label><?php 
        echo  __( "Default Background Color", "apvc" ) ;
        ?></label>
					                      <input id="apvc_default_background_color" name="apvc_default_background_color" value="<?php 
        echo  $avc_config->apvc_default_background_color[0] ;
        ?>" type="text" class="color-picker">
					                    </div>
				                    </div>
				                </div>
				                <div class="col-md-6">
			                      	<div class="card-body">
										<div class="form-group">
					                      <label><?php 
        echo  __( "Default Border Radius", "apvc" ) ;
        ?></label>
					                      <input id="apvc_default_border_radius" name="apvc_default_border_radius" value="<?php 
        echo  $avc_config->apvc_default_border_radius[0] ;
        ?>" min="0" value="0" type="number" class="form-control">
					                    </div>
				                    </div>
				                </div>
				                <div class="col-md-6">
			                      	<div class="card-body">
										<div class="form-group">
					                      <label><?php 
        echo  __( "Default Border Width", "apvc" ) ;
        ?></label>
					                      <input id="apvc_default_border_width" name="apvc_default_border_width" min="0" value="<?php 
        echo  $avc_config->apvc_default_border_width[0] ;
        ?>" value="2" type="number" class="form-control">
					                    </div>
				                    </div>
				                </div>
				                <div class="col-md-6">
			                      	<div class="card-body">
										<div class="form-group">
					                      <label><?php 
        echo  __( "Widget Alignment", "apvc" ) ;
        ?></label>
					                      <Br />
					                      <select name="apvc_wid_alignment" class="form-control" id="apvc_wid_alignment">
										      <option value="" disabled><?php 
        echo  __( "Choose your option", "apvc" ) ;
        ?></option>
												<option value="left" <?php 
        if ( $avc_config->apvc_wid_alignment[0] == "left" ) {
            echo  "selected" ;
        }
        ?> selected=""><?php 
        echo  __( "Left - Default", "apvc" ) ;
        ?></option>
										        <option value="right" <?php 
        if ( $avc_config->apvc_wid_alignment[0] == "right" ) {
            echo  "selected" ;
        }
        ?>><?php 
        echo  __( "Right", "apvc" ) ;
        ?></option>
										        <option value="center" <?php 
        if ( $avc_config->apvc_wid_alignment[0] == "center" ) {
            echo  "selected" ;
        }
        ?>><?php 
        echo  __( "Center", "apvc" ) ;
        ?></option>
										  </select>
					                    </div>
				                    </div>
				                </div>
				                <div class="col-md-6">
			                      	<div class="card-body">
										<div class="form-group">
										<?php 
        $width = 0;
        
        if ( !empty($avc_config->apvc_widget_width[0]) ) {
            $width = $avc_config->apvc_widget_width[0];
        } else {
            $width = 300;
        }
        
        ?>
					                      <label><?php 
        echo  __( "Width of the Widget (In Pixels)", "apvc" ) ;
        ?></label>
					                      <input id="apvc_widget_width" name="apvc_widget_width" value="<?php 
        echo  $width ;
        ?>" placeholder="Width:" type="number" min="100" step="10" class="form-control">
					                    </div>
				                    </div>
				                </div>
				                <div class="col-md-6">
			                      	<div class="card-body">
										<div class="form-group">
										<?php 
        $padding = 0;
        
        if ( !empty($avc_config->apvc_widget_padding[0]) ) {
            $padding = $avc_config->apvc_widget_padding[0];
        } else {
            $padding = 10;
        }
        
        ?>
					                      <label><?php 
        echo  __( "Padding of the Widget (In Pixels)", "apvc" ) ;
        ?></label>
					                      <input id="apvc_widget_padding" name="apvc_widget_padding" value="<?php 
        echo  $padding ;
        ?>" placeholder="Padding:" type="number" min="1" step="1" class="form-control">
					                    </div>
				                    </div>
				                </div>
				                <div class="col-md-6">
			                      	<div class="card-body">
										<div class="form-group">
					                      <label><?php 
        echo  __( "Default Label (Total Visits of Current Page)", "apvc" ) ;
        ?></label>
					                      <input id="apvc_default_label" name="apvc_default_label" value="<?php 
        echo  $avc_config->apvc_default_label[0] ;
        ?>" placeholder="<?php 
        echo  __( "Visits:", "apvc" ) ;
        ?>" type="text" value="Visits:" class="form-control">
					                    </div>
				                    </div>
				                </div>	
				                <div class="col-md-6">
			                      	<div class="card-body">
										<div class="form-group">
					                      <label><?php 
        echo  __( "Today's Count Label", "apvc" ) ;
        ?></label>
					                      <input id="apvc_todays_label" name="apvc_todays_label" value="<?php 
        echo  $avc_config->apvc_todays_label[0] ;
        ?>" placeholder="<?php 
        echo  __( "Today's Visits:", "apvc" ) ;
        ?>" type="text" value="Today:" class="form-control">
					                    </div>
				                    </div>
				                </div>
				                <div class="col-md-6">
			                      	<div class="card-body">
										<div class="form-group">
					                      <label><?php 
        echo  __( "Total Counts Label (Global)", "apvc" ) ;
        ?></label>
					                      <input id="apvc_global_label" name="apvc_global_label" value="<?php 
        echo  $avc_config->apvc_global_label[0] ;
        ?>" placeholder="<?php 
        echo  __( "Total Visits:", "apvc" ) ;
        ?>" type="text" value="Total:" class="form-control">
					                    </div>
				                    </div>
				                </div>	
				            </div>
				            <hr />

				            <div class="row">
				                <div class="col-md-6">
		                        	<div class="form-group">
			                          <div class="card-body">
				                        <div class="icheck-square">
				                          <input tabindex="6" type="checkbox" id="apvc_atc_page_count" name="apvc_atc_page_count" <?php 
        if ( $avc_config->apvc_atc_page_count[0] == "on" ) {
            echo  "checked" ;
        }
        ?>><label for="square-checkbox-2"><?php 
        echo  __( "Total Visits of Current Page", "apvc" ) ;
        ?></label>
				                          <br />
				                          <small class="text-muted"><?php 
        echo  __( "*This will show total counts the current page.", "apvc" ) ;
        ?></small>
				                        </div>
				                      </div>
				                	</div>
				            	</div>
				            	<div class="col-md-6">
		                        	<div class="form-group">
			                          <div class="card-body">
				                        <div class="icheck-square">
				                          <input tabindex="6" type="checkbox" id="apvc_show_global_count" name="apvc_show_global_count" <?php 
        if ( $avc_config->apvc_show_global_count[0] == "on" ) {
            echo  "checked" ;
        }
        ?>><label><?php 
        echo  __( "Show Global Total Counts", "apvc" ) ;
        ?></label>
				                          <br />
				                          <small class="text-muted"><?php 
        echo  __( "*This will show total counts for whole website.", "apvc" ) ;
        ?></small>
				                        </div>
				                      </div>
				                	</div>
				            	</div>
				            	<div class="col-md-6">
		                        	<div class="form-group">
			                          <div class="card-body">
				                        <div class="icheck-square">
				                          <input tabindex="6" type="checkbox" id="apvc_show_today_count" name="apvc_show_today_count" <?php 
        if ( $avc_config->apvc_show_today_count[0] == "on" ) {
            echo  "checked" ;
        }
        ?>><label><?php 
        echo  __( "Show Today's Counts", "apvc" ) ;
        ?></label>
				                          <br />
				                          <small class="text-muted"><?php 
        echo  __( "*This will show total counts for whole website.", "apvc" ) ;
        ?></small>
				                        </div>
				                      </div>
				                	</div>
				            	</div>
				            </div>

			            	<?php 
        ?>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group card-body">
			                          <label><?php 
        echo  __( "Widget Templates", "apvc" ) ;
        ?></label>
			                          <select id="apvc_widget_template" name="apvc_widget_template" class="apvc-counter-icon" style="width:100%">
			                          <?php 
        $shortcodes = json_decode( $this->apvc_get_shortcodes() );
        echo  '<option value="">' . __( "None", "apvc" ) . '</option>' ;
        foreach ( $shortcodes as $key => $value ) {
            
            if ( in_array( $key, $avc_config->apvc_widget_template ) ) {
                $selected = 'selected="selected"';
            } else {
                $selected = "";
            }
            
            echo  '<option value="' . esc_html( $key ) . '" ' . $selected . '> ' . ucfirst( str_replace( "_", " ", $key ) ) . '</option>' ;
        }
        ?>
			                          </select>
			                          <br />
				                      <small class="text-muted"><?php 
        echo  __( "*Check the Shortcode Library page to check the demo of all the shortcodes.<Br />*All color properties ignored if any template selected.<Br />*More than 40 templates available in the Premium version of the plugin.", "apvc" ) ;
        ?></small>
			                        </div>
								</div>
							</div>
							<div class="row">
				            	<div class="apvc-save-btns">
					            	<button type="button" id="apvc_save_settings" class="btn btn-primary btn-fw"><i class="mdi mdi-heart-outline"></i><?php 
        echo  __( "Save Changes", "apvc" ) ;
        ?></button>
					            	<button type="button" id="apvc_reset_button" class="btn btn-outline-danger btn-fw"><i class="mdi mdi-refresh"></i><?php 
        echo  __( "Reset Settings", "apvc" ) ;
        ?></button>
					            	<button type="button" id="apvc_reset_data_button" class="btn btn-danger btn-fw"><i class="mdi mdi-alert-outline"></i><?php 
        echo  __( "Reset All Data/Counters", "apvc" ) ;
        ?></button>
					            </div>
				            </div>
	                      </div><!-- card-body -->
	                    </form>
	                  </div>
	              </div>
	              <div class="col-lg-4 grid-margin stretch-card">
		              	<?php 
        $this->apvc_get_premium_features_block();
        ?>
			      </div>
		      </div>
		    </div>
    	</div>
		<?php 
    }
    
    /**
     * Advanced Page Visit Counter Get icons.
     *
     * @since    3.0.1
     */
    public function apvc_get_icons()
    {
        $icons = array(
            'None',
            'icon-eye',
            'icon-user',
            'icon-people',
            'icon-user-female',
            'icon-user-follow',
            'icon-user-following',
            'icon-emotsmile',
            'icon-location-pin',
            'icon-list',
            'icon-options',
            'icon-clock',
            'icon-plus',
            'icon-trophy',
            'icon-screen-desktop',
            'icon-plane',
            'icon-mouse',
            'icon-mustache',
            'icon-cursor-move',
            'icon-cursor',
            'icon-energy',
            'icon-screen-tablet',
            'icon-shield',
            'icon-speedometer',
            'icon-chemistry',
            'icon-magic-wand',
            'icon-disc',
            'icon-graduation',
            'icon-ghost',
            'icon-eyeglass',
            'icon-fire',
            'icon-bell',
            'icon-game-controller',
            'icon-speech',
            'icon-badge',
            'icon-pin',
            'icon-playlist',
            'icon-present',
            'icon-picture',
            'icon-globe',
            'icon-diamond',
            'icon-basket-loaded',
            'icon-cup',
            'icon-rocket',
            'icon-home',
            'icon-music-tone-alt',
            'icon-music-tone',
            'icon-earphones-alt',
            'icon-graph',
            'icon-microphone',
            'icon-control-play',
            'icon-calendar',
            'icon-bulb',
            'icon-chart',
            'icon-camera',
            'icon-cloud-download',
            'icon-bubble',
            'icon-heart',
            'icon-star'
        );
        return wp_json_encode( $icons );
    }
    
    /**
     * Advanced Page Visit Counter Save settings method.
     *
     * @since    3.0.1
     */
    public function apvc_save_settings()
    {
        global  $wpdb ;
        $formData = $_POST['formData'];
        $formData = explode( "&", $formData );
        $finalFormData = array();
        foreach ( $formData as $key => $value ) {
            $rawFormData = explode( "=", $value );
            if ( isset( $rawFormData[0] ) ) {
                $finalFormData[$rawFormData[0]][] = urldecode( trim( $rawFormData[1] ) );
            }
        }
        update_option( "apvc_configurations", $finalFormData );
        echo  "success" ;
        wp_die();
    }
    
    /**
     * Advanced Page Visit Counter Reset settings method.
     *
     * @since    3.0.1
     */
    public function apvc_reset_settings()
    {
        global  $wpdb ;
        $finalFormData = array();
        $finalFormData['apvc_post_types'] = array( 'post', 'page' );
        $finalFormData['apvc_widget_width'] = array( 300 );
        $finalFormData['apvc_default_label'] = array( 'Visits' );
        $finalFormData['apvc_wid_alignment'] = array( 'center' );
        $finalFormData['apvc_default_text_color'] = array( '#000000' );
        $finalFormData['apvc_default_background_color'] = array( '#fffffff' );
        $finalFormData['apvc_default_border_color'] = array( '#000000' );
        $finalFormData['apvc_default_border_radius'] = array( 5 );
        $finalFormData['apvc_default_border_width'] = array( 2 );
        update_option( "apvc_configurations", $finalFormData );
        echo  "success" ;
        wp_die();
    }
    
    /**
     * Advanced Page Visit Counter Reset data method.
     *
     * @since    3.0.1
     */
    public function apvc_reset_data()
    {
        global  $wpdb ;
        $tbl_history = APVC_DATA_TABLE;
        $wpdb->query( "TRUNCATE TABLE {$tbl_history}" );
        $wpdb->query( "DELETE FROM {$wpdb->postmeta} WHERE meta_key='count_start_from'" );
        echo  "success" ;
        wp_die();
    }
    
    /**
     * Advanced Page Visit Counter Shortcode Generator Form.
     *
     * @since    3.0.1
     */
    public function apvc_shortcode_generator_page()
    {
        global  $wpdb ;
        ?>
		<input type="hidden" id="current_page" value="shortcode">
		<div class="container-fluid page-body-wrapper avpc-settings-page">
			<div class="main-panel container">
				<div class="content-wrapper">
					<?php 
        $this->apvc_get_version_info_block();
        ?>
					<div class="row">
						<div class="col-lg-5 grid-margin stretch-card">
							<div class="card">
			                  <div class="card-body">
			                    <h4 class="card-title text-center text-black"><?php 
        echo  __( "Shortcode Preview", "apvc" ) ;
        ?></h4>
									<div id="shortcode_output">
										<div class="col-md-12 shLoader col-sm-12 grid-margin stretch-card">
											<div class="loader-demo-box" style="border:none !important;">
												<div class="square-box-loader">
													<div class="square-box-loader-container">
														<div class="square-box-loader-corner-top"></div>
														<div class="square-box-loader-corner-bottom"></div>
													</div>
													<div class="square-box-loader-square"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-7 grid-margin stretch-card">
							<div class="card">
								<div class="card-body">
									<h4 class="card-title text-black text-center"><?php 
        echo  __( "Shortcode Generator", "apvc" ) ;
        ?></h4>
									<form class="form-sample" id="apvc_generate_shortcode">
										<div class="apvc-save-btns text-right">
							            	<button type="button" class="apvc_generate_shortcode btn btn-primary btn-rounded  btn-fw"><i class="mdi mdi-format-paint"></i><?php 
        echo  __( "Generate Shortcode", "apvc" ) ;
        ?></button>
							            </div>

										<div class="row">
											<div class="col-md-6">
												<div class="card-body">
													<div class="form-group">
								                      <label><?php 
        echo  __( "Border Size (in pixels)", "apvc" ) ;
        ?></label>
								                      <Br />
								                      <input type="number" class="form-control" name="border_size" value="2">
								                    </div>
								                </div>
											</div>	
											<div class="col-md-6">
												<div class="card-body">
													<div class="form-group">
								                      <label><?php 
        echo  __( "Border Radius (in pixels)", "apvc" ) ;
        ?></label>
								                      <Br />
								                      <input type="number" class="form-control" name="border_radius" value="5">
								                    </div>
								                </div>
											</div>	
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="card-body">
													<div class="form-group">
								                      <label><?php 
        echo  __( "Border Style", "apvc" ) ;
        ?></label>
								                      <Br />
								                      <select name="border_style" class="form-control">
													    <option value="" disabled selected><?php 
        echo  __( "Choose your option", "apvc" ) ;
        ?></option>
														<option value="none"><?php 
        echo  __( "None", "apvc" ) ;
        ?></option>
														<option value="dotted"><?php 
        echo  __( "Dotted", "apvc" ) ;
        ?></option>
														<option value="dashed"><?php 
        echo  __( "Dashed", "apvc" ) ;
        ?></option>
														<option value="solid" selected=""><?php 
        echo  __( "Solid", "apvc" ) ;
        ?></option>
														<option value="double"><?php 
        echo  __( "Double", "apvc" ) ;
        ?></option>
													  </select>
								                    </div>
								                </div>
											</div>
											<div class="col-md-6">
						                      	<div class="card-body">
													<div class="form-group">
								                      <label><?php 
        echo  __( "Border Color", "apvc" ) ;
        ?></label>
								                      <input name="border_color" type="text" class="color-picker">
								                    </div>
							                    </div>
							                </div>
										</div>
										<div class="row">
											<div class="col-md-6">
						                      	<div class="card-body">
													<div class="form-group">
								                      <label><?php 
        echo  __( "Font Color", "apvc" ) ;
        ?></label>
								                      <input name="font_color" type="text" class="color-picker">
								                    </div>
							                    </div>
							                </div>
							                <div class="col-md-6">
						                      	<div class="card-body">
													<div class="form-group">
								                      <label><?php 
        echo  __( "Background Color", "apvc" ) ;
        ?></label>
								                      <input name="background_color" type="text" class="color-picker">
								                    </div>
							                    </div>
							                </div>
										</div>
										<div class="row">
											<div class="col-md-6">
						                      	<div class="card-body">
													<div class="form-group">
								                      <label><?php 
        echo  __( "Font Size", "apvc" ) ;
        ?></label>
								                      <input name="font_size" type="number" class="form-control" value="14" min="7">
								                    </div>
							                    </div>
							                </div>
							                <div class="col-md-6">
												<div class="card-body">
													<div class="form-group">
								                      <label><?php 
        echo  __( "Font Style", "apvc" ) ;
        ?></label>
								                      <Br />
								                      <select name="font_style" class="form-control" name="font_style">
													    <option value="" disabled selected><?php 
        echo  __( "Choose your option", "apvc" ) ;
        ?></option>
														<option value=""><?php 
        echo  __( "Please Select", "apvc" ) ;
        ?></option>
														<option value="normal"><?php 
        echo  __( "Normal", "apvc" ) ;
        ?></option>
														<option value="bold"><?php 
        echo  __( "Bold", "apvc" ) ;
        ?></option>
														<option value="italic"><?php 
        echo  __( "Italic", "apvc" ) ;
        ?></option>
													  </select>
								                    </div>
								                </div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
						                      	<div class="card-body">
													<div class="form-group">
								                      <label><?php 
        echo  __( "Padding", "apvc" ) ;
        ?></label>
								                      <input class="form-control" value="5" name="padding" type="number" min="0">
								                    </div>
							                    </div>
							                </div>
							                <div class="col-md-6">
						                      	<div class="card-body">
													<div class="form-group">
								                      <label><?php 
        echo  __( "Width", "apvc" ) ;
        ?></label>
								                      <input class="form-control" placeholder="Width in pixels" value="200" name="width" type="number" min="100">
								                    </div>
							                    </div>
							                </div>
							            </div>
							            <div class="row">
							            	<div class="col-md-6">
					                        	<div class="form-group">
						                          <div class="card-body">
							                        <div class="icheck-square">
							                          <input tabindex="6" type="checkbox" name="show_today_count"><label><?php 
        echo  __( "Show Today's Visit Counts", "apvc" ) ;
        ?></label>
							                          <br />
							                          <small class="text-muted"><?php 
        echo  __( "*This will show today's count for individual post/page.", "apvc" ) ;
        ?></small>
							                        </div>
							                      </div>
							                	</div>
							            	</div>
							            	<div class="col-md-6">
					                        	<div class="form-group">
						                          <div class="card-body">
							                        <div class="icheck-square">
							                          <input tabindex="6" type="checkbox" name="show_global_count"><label><?php 
        echo  __( "Show Global Total Counts", "apvc" ) ;
        ?></label>
							                          <br />
							                          <small class="text-muted"><?php 
        echo  __( "*This will show total counts for whole website.", "apvc" ) ;
        ?></small>
							                        </div>
							                      </div>
							                	</div>
							            	</div>
							            	<div class="col-md-6">
					                        	<div class="form-group">
						                          <div class="card-body">
							                        <div class="icheck-square">
							                          <input tabindex="6" checked="checked" type="checkbox" name="show_cr_pg_count"><label><?php 
        echo  __( "Show Current Page Total", "apvc" ) ;
        ?></label>
							                          <br />
							                          <small class="text-muted"><?php 
        echo  __( "*This will show total counts the current page.", "apvc" ) ;
        ?></small>
							                        </div>
							                      </div>
							                	</div>
							            	</div>
							            </div>
							            <div class="row">
							            	<div class="col-md-6">
					                        	<div class="form-group">
						                          <div class="card-body">
						                          	<label><?php 
        echo  __( "Counter Label", "apvc" ) ;
        ?></label>
								                      <input class="form-control" value="Visits:" name="counter_label" type="text">
						                          </div>
						                        </div>
						                    </div>
						                    <div class="col-md-6">
					                        	<div class="form-group">
						                          <div class="card-body">
						                          	<label><?php 
        echo  __( "Today's Counter Label", "apvc" ) ;
        ?></label>
								                      <input class="form-control" value="Today:" name="today_counter_label" type="text">
						                          </div>
						                        </div>
						                    </div>
						                    <div class="col-md-6">
					                        	<div class="form-group">
						                          <div class="card-body">
						                          	<label><?php 
        echo  __( "Global Counter Label", "apvc" ) ;
        ?></label>
								                      <input class="form-control" value="Total:" name="global_counter_label" type="text">
						                          </div>
						                        </div>
						                    </div>
						                    <div class="col-md-6">
							            		<div class="form-group">
						                          <div class="card-body">
						                          	<label><?php 
        echo  __( "Shortcode Type", "apvc" ) ;
        ?></label>
						                          	<select name="shortcode_type" id="shortcode_type" class="form-control">
												      <option value="" disabled selected><?php 
        echo  __( "Choose your option", "apvc" ) ;
        ?></option>
														<option value="customized" selected><?php 
        echo  __( "Customized", "apvc" ) ;
        ?></option>
														<option value="individual"><?php 
        echo  __( "For Specific Post/Page", "apvc" ) ;
        ?></option>
												    </select>
						                          </div>
						                        </div>
							            	</div>
							            </div>

							            <div class="row shArticles">
							            	<div class="col-md-12">
							            		<div class="form-group">
							            			<div class="card-body">
							                          <label><?php 
        echo  __( "Articles", "apvc" ) ;
        ?></label>
							                          <select class="apvc_articles_list" name="apvc_articles_list" style="width:100%">
							                            
							                          </select>
							                        </div>
						                        </div>
						                    </div>
							            </div>

							            <?php 
        ?>
										<div class="col-md-12">
											<div class="form-group">
					                          <label><?php 
        echo  __( "Widget Templates", "apvc" ) ;
        ?></label>
					                          <select id="apvc_widget_template" name="apvc_widget_template" class="apvc-counter-icon" style="width:100%">
					                          <?php 
        $shortcodes = json_decode( $this->apvc_get_shortcodes() );
        echo  '<option>' . __( "None", "apvc" ) . '</option>' ;
        foreach ( $shortcodes as $key => $value ) {
            echo  '<option value="' . esc_html( $key ) . '"> ' . ucfirst( str_replace( "_", " ", $key ) ) . '</option>' ;
        }
        ?>
					                          </select>
					                          <br />
						                      <small class="text-muted"><?php 
        echo  __( "*Check the Shortcode Library page to check the demo of all the shortcodes.<Br />*All color properties ignored if any template selected.<Br />*More than 40 templates available in the Premium version of the plugin.", "apvc" ) ;
        ?></small>
					                        </div>
										</div>

							            <div class="apvc-save-btns">
							            	<button type="button" class="apvc_generate_shortcode btn btn-primary btn-rounded btn-fw"><i class="mdi mdi-format-paint"></i><?php 
        echo  __( "Generate Shortcode", "apvc" ) ;
        ?></button>
							            </div>
									</form>
								</div>
							</div>
						</div>
						<?php 
        ?>
					</div>
				</div>
			</div>
		</div>
		<?php 
    }
    
    /**
     * Advanced Page Visit Counter Shortcode Generator Method.
     *
     * @since    3.0.1
     */
    public function apvc_generate_shortcode()
    {
        global  $wpdb ;
        ob_start();
        $formData = $_POST['formData'];
        $formData = explode( "&", $formData );
        $finalFormData = array();
        foreach ( $formData as $key => $value ) {
            $rawFormData = explode( "=", $value );
            if ( isset( $rawFormData[0] ) ) {
                $finalFormData[$rawFormData[0]][] = urldecode( trim( $rawFormData[1] ) );
            }
        }
        $border_size = $finalFormData['border_size'][0];
        $border_radius = $finalFormData['border_radius'][0];
        $bg_color = $finalFormData['background_color'][0];
        $font_size = $finalFormData['font_size'][0];
        $font_style = $finalFormData['font_style'][0];
        $font_color = $finalFormData['font_color'][0];
        $border_style = $finalFormData['border_style'][0];
        $border_color = $finalFormData['border_color'][0];
        $counter_label = $finalFormData['counter_label'][0];
        $today_counter_label = $finalFormData['today_counter_label'][0];
        $global_counter_label = $finalFormData['global_counter_label'][0];
        $padding = $finalFormData['padding'][0];
        $width = $finalFormData['width'][0];
        $shType = $finalFormData['shortcode_type'][0];
        $shArticleID = $finalFormData['apvc_articles_list'][0];
        $show_global_count = $finalFormData['show_global_count'][0];
        $show_today_count = $finalFormData['show_today_count'][0];
        $show_cr_pg_count = $finalFormData['show_cr_pg_count'][0];
        $widget_template = $finalFormData['apvc_widget_template'][0];
        if ( empty($shArticleID) ) {
            $shArticleID = 1;
        }
        
        if ( $show_global_count == 'on' ) {
            $show_global_countVar = ' global="true" ';
        } else {
            $show_global_countVar = ' global="false" ';
        }
        
        
        if ( $show_today_count == 'on' ) {
            $show_today_countVar = ' today="true" ';
        } else {
            $show_today_countVar = ' today="false" ';
        }
        
        
        if ( $show_cr_pg_count == 'on' ) {
            $show_cr_pg_countVar = ' current="true" ';
        } else {
            $show_cr_pg_countVar = ' current="false" ';
        }
        
        $shArgs = "";
        
        if ( $shType == 'individual' && !empty($shArticleID) ) {
            $shArgs = 'type="individual" article_id="' . $shArticleID . '"';
        } else {
            
            if ( $shType == 'global' ) {
                $shArgs = 'type="global"';
            } else {
                $shArgs = 'type="customized"';
            }
        
        }
        
        $counter_label = ( !empty($counter_label) ? $counter_label : "Visits: " );
        $today_counter_label = ( !empty($today_counter_label) ? $today_counter_label : $counter_label );
        $global_counter_label = ( !empty($global_counter_label) ? $global_counter_label : $counter_label );
        $shortcode = '[apvc_embed ' . $shArgs . ' border_size="' . $border_size . '" border_radius="' . $border_radius . '" background_color="' . $bg_color . '" font_size="' . $font_size . '" font_style="' . $font_style . '" font_color="' . $font_color . '" counter_label="' . $counter_label . '" today_cnt_label="' . $today_counter_label . '" global_cnt_label="' . $global_counter_label . '" border_color="' . $border_color . '" border_style="' . $border_style . '" padding="' . $padding . '" width="' . $width . '" ' . $show_global_countVar . ' ' . $show_today_countVar . ' ' . $show_cr_pg_countVar . ' ' . $iconCR . ' ' . $iconGL . ' ' . $iconTD . ' icon_position="' . $apvc_icon_position . '" widget_template="' . $widget_template . '" ]';
        ?>
		<style>
			 .avc_visit_counter_front{
			 	width: <?php 
        echo  $width ;
        ?>px;
			 	max-width: <?php 
        echo  $width ;
        ?>px;
			    padding: <?php 
        echo  $padding ;
        ?>px;
			    text-align: center;	
			    margin: 15px 0px 15px 0px;
			    margin: 20px auto;
			 }
			 .shortcode_copy{ text-align: center; } .shortcode_copy a{ color: #fff !important; cursor: pointer; }
		</style>
        <div class="shortcodeBlock col-md-12">
			<div class="shortcode_text grid-margin" id="shortcode_text">
				<?php 
        echo  $shortcode ;
        ?>
			</div>
			<div class="col-md-12 shortcode_output center-align" id="shortcode_output">
				<?php 
        echo  do_shortcode( $shortcode ) ;
        ?>
			</div>
			<div class="col-md-12 shortcode_copy grid-margin">
				<a class="btn btn-primary btn-rounded btn-fw text-center" id="shortcode_copy"><?php 
        echo  __( "Copy Shortcode", "apvc" ) ;
        ?></a>
			</div>

			<?php 
        ?>
		</div>
		<?php 
        echo  ob_get_clean() ;
        wp_die();
    }
    
    /**
     * Advanced Page Visit Counter Get All Articles.
     *
     * @since    3.0.1
     */
    public function apvc_get_all_articles_sh()
    {
        global  $wpdb ;
        $tbl_history = APVC_DATA_TABLE;
        $allArticles = $wpdb->get_results( "SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type NOT IN('attachment','revision','nav_menu_item') AND post_status='publish'" );
        $array = array();
        $html = '';
        foreach ( $allArticles as $article ) {
            $html .= '<option value="' . $article->ID . '">' . $article->post_title . '</option>';
        }
        echo  $html ;
        wp_die();
    }
    
    /**
     * Get column head title in wordpress admin
     *
     * @since    1.0.0
     *
     * @return  string
     */
    public function apvc_columns_label( $defaults )
    {
        $defaults['views'] = esc_html__( 'Views', "apvc" );
        return $defaults;
    }
    
    /**
     * Get column head content in wordpress admin
     *
     * @param  string $column_id
     * @param  int $article_id
     *
     * @since    3.0.6
     *
     */
    public function apvc_columns_counts( $column_id, $article_id )
    {
        global  $wpdb ;
        $tbl_history = APVC_DATA_TABLE;
        
        if ( $column_id == 'views' ) {
            global  $wpdb ;
            $post_result = get_post( $article_id );
            
            if ( 'post' === $post_result->post_type ) {
                $type = 'post';
            } else {
                $type = 'page';
            }
            
            $totalVisits = $wpdb->get_var( "SELECT count(*) FROM " . APVC_DATA_TABLE . " WHERE article_id = {$article_id}" );
            
            if ( $totalVisits ) {
                echo  '<a href="' . esc_url( site_url( '/wp-admin/admin.php?page=apvc-dashboard-page&apvc_page=detailed-reports&article_id=' . esc_attr( $article_id ) ) ) . '">' . esc_html( $totalVisits ) . '</a>' ;
            } else {
                echo  "0" ;
            }
        
        }
    
    }
    
    /**
     * Advanced Page Visit Counter Save posts meta for counter.
     *
     * @since    3.0.1
     */
    public function apvc_advanced_save_metaboxes( $post_id )
    {
        global  $wpdb ;
        $tbl_history = APVC_DATA_TABLE;
        $active_count = sanitize_text_field( $_POST["apvc_active_counter"] );
        $reset_count = sanitize_text_field( $_POST["apvc_reset_cnt"] );
        $start_count = sanitize_text_field( $_POST["count_start_from"] );
        $widget_label = sanitize_text_field( $_POST["widget_label"] );
        if ( empty($active_count) ) {
            $active_count = "Yes";
        }
        update_post_meta( $post_id, "apvc_active_counter", $active_count );
        update_post_meta( $post_id, "count_start_from", $start_count );
        update_post_meta( $post_id, "widget_label", $widget_label );
        if ( $reset_count == "Yes" ) {
            $wpdb->query( "DELETE FROM {$tbl_history} WHERE article_id={$post_id}" );
        }
    }
    
    /**
     * Advanced Page Visit Counter Upgrade process method.
     *
     * @since    3.0.1
     */
    public function apvc_upgrader_process_complete()
    {
        $current_version = get_option( "apvc_version" );
        // $this->apvc_migrate_from_old_version($current_version);
        update_option( "apvc_version", ADVANCED_PAGE_VISIT_COUNTER );
        update_option( "apvc_newsletter", "show" );
    }
    
    public function apvc_get_html_with_icon( $class )
    {
        return '<div class="' . $class . '"><div><i class="icon-graph icons"></i> Visits: <span>999</span></div><div><i class="icon-eyeglass icons"></i> Today: <span>123</span></div><div><i class="icon-chart icons"></i> Total: <span>123</span></div></div>';
    }
    
    public function apvc_get_html_without_icon( $class )
    {
        return '<div class="' . $class . '"><div>Visits: <span>999</span></div><div>Today: <span>123</span></div><div>Total: <span>123</span></div></div>';
    }
    
    public function apvc_shortcode_library()
    {
        global  $wpdb ;
        $shortcodes = json_decode( $this->apvc_get_shortcodes() );
        ?>
		<div class="container-fluid page-body-wrapper">
			<div class="main-panel container">
				<div class="content-wrapper">
					<?php 
        $this->apvc_get_version_info_block();
        ?>
					<div class="row">
						<div class="col-lg-12 grid-margin stretch-card">
							<div class="card">
								<div class="card-body">
								<h5 class="text-center grid-margin"><b><?php 
        echo  __( "Shortcodes Library", "apvc" ) ;
        ?></b></h5>
									<div class="row">
									<?php 
        foreach ( $shortcodes as $key => $value ) {
            $addClass = ( $value->class != '' ? $value->class : '' );
            ?>
										<div class="col-lg-4 grid-margin">
											<h4 class="card-title text-center">
												<?php 
            echo  str_replace( "_", " ", $key ) ;
            ?>
											</h4>
											<style type="text/css">
												<?php 
            echo  $value->css ;
            ?>
											</style>
											<?php 
            echo  ( $value->icon == 'yes' ? $this->apvc_get_html_with_icon( $key . " " . $addClass ) : $this->apvc_get_html_without_icon( $key . " " . $addClass ) ) ;
            ?>
										</div>
									<?php 
        }
        ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php 
    }
    
    /**
     * Advanced Page Visit Counter Shortcode Library.
     *
     * @since    3.0.1
     */
    public function apvc_get_shortcodes( $shortcode = '' )
    {
        $shortcodes = array();
        $shortcodes['template_3']['icon'] = 'yes';
        $shortcodes['template_3']['css'] = '.template_3{background:#1c8394;padding:15px;margin:15px;border-radius:50px;border:2px solid #1c8394;-webkit-box-shadow:3px 4px 12px -2px rgba(0,0,0,.68);-moz-box-shadow:3px 4px 12px -2px rgba(0,0,0,.68);box-shadow:3px 4px 12px -2px rgba(0,0,0,.68);font-family:calibri;font-size:13pt;text-align:center}.template_3>div{color:#fff;display:inline-block;margin:0 30px}.template_3>div>span{font-weight:700;margin-left:10px}.template_3 .icons{color:#fff;margin-right:5px;font-weight:700}@media (max-width:644px){.template_3>div{margin:0 10px}}@media (max-width:525px){.template_3>div{color:#fff;display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_3>div:last-child{border-bottom:none}}';
        $shortcodes['template_6']['icon'] = 'yes';
        $shortcodes['template_6']['class'] = 'effect2';
        $shortcodes['template_6']['css'] = '.template_6{background:#764ba2;background:linear-gradient(90deg,#667eea 0,#764ba2 100%);padding:15px;margin:15px;border-radius:40px;border:2px solid #764ba2;font-family:calibri;font-size:13pt;text-align:center}.effect2{position:relative}.effect2:after{z-index:-1;position:absolute;content:"";bottom:15px;right:10px;left:auto;width:50%;top:50%;max-width:300px;background:#777;-webkit-box-shadow:0 15px 10px #777;-moz-box-shadow:0 15px 10px #777;box-shadow:0 15px 10px #777;-webkit-transform:rotate(4deg);-moz-transform:rotate(4deg);-o-transform:rotate(4deg);-ms-transform:rotate(4deg);transform:rotate(4deg)}.template_6>div{color:#fff;display:inline-block;margin:0 30px}.template_6>div>span{font-weight:700;margin-left:10px}.template_6 .icons{color:#fff;margin-right:5px;font-weight:700}@media (max-width:644px){.template_6>div{margin:0 10px}}@media (max-width:525px){.template_6>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fcb8a1}.template_6>div:last-child{border-bottom:none}}';
        $shortcodes['template_7']['icon'] = 'yes';
        $shortcodes['template_7']['class'] = 'effect2';
        $shortcodes['template_7']['css'] = '.template_7{background:#dfa579;background:linear-gradient(90deg,#c79081 0,#dfa579 100%);padding:15px;margin:15px;border-radius:40px;border:2px solid #dfa579;font-family:calibri;font-size:13pt;text-align:center}.effect2{position:relative}.effect2:after,.effect2:before{z-index:-1;position:absolute;content:"";bottom:25px;left:10px;width:50%;top:35%;max-width:300px;background:#000;-webkit-box-shadow:0 35px 20px #000;-moz-box-shadow:0 35px 20px #000;box-shadow:0 35px 20px #000;-webkit-transform:rotate(-7deg);-moz-transform:rotate(-7deg);-o-transform:rotate(-7deg);-ms-transform:rotate(-7deg);transform:rotate(-7deg)}.effect2:after{-webkit-transform:rotate(7deg);-moz-transform:rotate(7deg);-o-transform:rotate(7deg);-ms-transform:rotate(7deg);transform:rotate(7deg);right:10px;left:auto}.template_7>div{color:#fff;display:inline-block;margin:0 30px}.template_7>div>span{font-weight:700;margin-left:10px}.template_7 .icons{color:#fff;margin-right:5px;font-weight:700}@media (max-width:644px){.template_7>div{margin:0 10px}}@media (max-width:525px){.template_7>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fcb8a1}.template_7>div:last-child{border-bottom:none}}';
        $shortcodes['template_8']['icon'] = 'yes';
        $shortcodes['template_8']['class'] = 'effect2';
        $shortcodes['template_8']['css'] = '.template_8{background:#5fc3e4;background:linear-gradient(90deg,#e55d87 0,#5fc3e4 100%);padding:15px;margin:15px;border:2px solid #5fc3e4;font-family:calibri;font-size:13pt;text-align:center}.effect2{position:relative;-webkit-box-shadow:0 1px 4px rgba(0,0,0,.3),0 0 40px rgba(0,0,0,.1) inset;-moz-box-shadow:0 1px 4px rgba(0,0,0,.3),0 0 40px rgba(0,0,0,.1) inset;box-shadow:0 1px 4px rgba(0,0,0,.3),0 0 40px rgba(0,0,0,.1) inset}.effect2:after,.effect2:before{content:"";position:absolute;z-index:-1;-webkit-box-shadow:0 0 20px rgba(0,0,0,.8);-moz-box-shadow:0 0 20px rgba(0,0,0,.8);box-shadow:0 0 20px rgba(0,0,0,.8);top:0;bottom:0;left:10px;right:10px;-moz-border-radius:100px/10px;border-radius:100px/10px}.effect2:after{right:10px;left:auto;-webkit-transform:skew(8deg) rotate(3deg);-moz-transform:skew(8deg) rotate(3deg);-ms-transform:skew(8deg) rotate(3deg);-o-transform:skew(8deg) rotate(3deg);transform:skew(8deg) rotate(3deg)}.template_8>div{color:#fff;display:inline-block;margin:0 30px}.template_8>div>span{font-weight:700;margin-left:10px}.template_8 .icons{color:#fff;margin-right:5px;font-weight:700}@media (max-width:644px){.template_8>div{margin:0 10px}}@media (max-width:525px){.template_8>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_8>div:last-child{border-bottom:none}}';
        $shortcodes['template_11']['icon'] = 'yes';
        $shortcodes['template_11']['css'] = '.template_11{background:#2980b9;background:linear-gradient(225deg,#2980b9 0,#6dd5fa 50%,#fff 100%);padding:15px;margin:15px;border-radius:40px;border:2px solid #2980b9;font-family:calibri;font-size:13pt;text-align:center}.template_11>div{color:#1a1a1a;display:inline-block;margin:0 30px}.template_11>div>span{font-weight:700;margin-left:10px}.template_11 .icons{color:#1a1a1a;margin-right:5px;font-weight:700}@media (max-width:644px){.template_11>div{margin:0 10px}}@media (max-width:525px){.template_11>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #2980b9}.template_11>div:last-child{border-bottom:none}}';
        $shortcodes['template_22']['icon'] = 'no';
        $shortcodes['template_22']['css'] = '.template_22{background:#355c7d;background:linear-gradient(90deg,#355c7d 0,#6c5b7b 50%,#c06c84 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);box-shadow:0 10px 14px 0 rgba(0,0,0,.1)}.template_22>div{color:#fff;display:inline-block;margin:0 30px}.template_22>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_22>div{margin:0 10px}}@media (max-width:525px){.template_22>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #c06c84}.template_22>div:last-child{border-bottom:none}}';
        $shortcodes['template_23']['icon'] = 'no';
        $shortcodes['template_23']['css'] = '.template_23{background:#fc5c7d;background:linear-gradient(90deg,#fc5c7d 0,#6c5b7b 50%,#6a82fb 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);box-shadow:0 10px 14px 0 rgba(0,0,0,.1)}.template_23>div{color:#fff;display:inline-block;margin:0 30px}.template_23>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_23>div{margin:0 10px}}@media (max-width:525px){.template_23>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #c06c84}.template_23>div:last-child{border-bottom:none}}';
        $shortcodes['template_24']['icon'] = 'no';
        $shortcodes['template_24']['css'] = '.template_24{background:#fffbd5;background:linear-gradient(90deg,#fffbd5 0,#b20a2c 50%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);box-shadow:0 10px 14px 0 rgba(0,0,0,.1)}.template_24>div{color:#fff;display:inline-block;margin:0 30px}.template_24>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_24>div{margin:0 10px}}@media (max-width:525px){.template_24>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fffbd5}.template_24>div:last-child{border-bottom:none}}';
        $shortcodes['template_25']['icon'] = 'no';
        $shortcodes['template_25']['css'] = '.template_25{background:#302b63;background:linear-gradient(90deg,#0f0c29 0,#7365ff 50%,#24243e 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);box-shadow:0 10px 14px 0 rgba(0,0,0,.1)}.template_25>div{color:#fff;display:inline-block;margin:0 30px}.template_25>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_25>div{margin:0 10px}}@media (max-width:525px){.template_25>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #0f0c29}.template_25>div:last-child{border-bottom:none}}';
        $shortcodes['template_26']['icon'] = 'no';
        $shortcodes['template_26']['css'] = '.template_26{background:#d3cce3;background:linear-gradient(90deg,#d3cce3 0,#e9e4f0 50%,#d3cce3 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.1);box-shadow:0 10px 14px 0 rgba(0,0,0,.1)}.template_26>div{color:#6a6279;display:inline-block;margin:0 30px}.template_26>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_26>div{margin:0 10px}}@media (max-width:525px){.template_26>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #7f7a8a}.template_26>div:last-child{border-bottom:none}}';
        $shortcodes['template_29']['icon'] = 'no';
        $shortcodes['template_29']['css'] = '.template_29{background:#6d6027;background:linear-gradient(90deg,#6d6027 0,#d3cbb8 80%,#3c3b3f 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);box-shadow:0 10px 14px 0 rgba(0,0,0,.2)}.template_29>div{color:#fff;display:inline-block;margin:0 30px}.template_29>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_29>div{margin:0 10px}}@media (max-width:525px){.template_29>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #00f260}.template_29>div:last-child{border-bottom:none}}';
        $shortcodes['template_31']['icon'] = 'no';
        $shortcodes['template_31']['css'] = '.template_31{background:#3a1c71;background:linear-gradient(90deg,#3a1c71 0,#d76d77 25%,#ffaf7b 50%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);box-shadow:0 10px 14px 0 rgba(0,0,0,.2)}.template_31>div{color:#1a1a1a;display:inline-block;margin:0 30px}.template_31>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_31>div{margin:0 10px}}@media (max-width:525px){.template_31>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_31>div:last-child{border-bottom:none}}';
        $shortcodes['template_34']['icon'] = 'no';
        $shortcodes['template_34']['css'] = '.template_34{background:#f7971e;background:linear-gradient(90deg,#f7971e 0,#ffd200 50%,#f7971e 1%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);box-shadow:0 10px 14px 0 rgba(0,0,0,.2)}.template_34>div{color:#1a1a1a;display:inline-block;margin:0 30px}.template_34>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_34>div{margin:0 10px}}@media (max-width:525px){.template_34>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_34>div:last-child{border-bottom:none}}';
        $shortcodes['template_39']['icon'] = 'no';
        $shortcodes['template_39']['css'] = '.template_39{background:#000;background:linear-gradient(90deg,#000 0,#b3cc2c 50%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);box-shadow:0 10px 14px 0 rgba(0,0,0,.2)}.template_39>div{color:#fff;display:inline-block;margin:0 30px}.template_39>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_39>div{margin:0 10px}}@media (max-width:525px){.template_39>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_39>div:last-child{border-bottom:none}}';
        $shortcodes['template_40']['icon'] = 'no';
        $shortcodes['template_40']['css'] = '.template_40{background:#ba8b02;background:linear-gradient(90deg,#ba8b02 0,#ffd65d 80%,#ba8b02 100%);padding:15px;margin:15px;font-family:calibri;font-size:13pt;text-align:center;-webkit-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);-moz-box-shadow:0 10px 14px 0 rgba(0,0,0,.2);box-shadow:0 10px 14px 0 rgba(0,0,0,.2)}.template_40>div{color:#1a1a1a;display:inline-block;margin:0 30px}.template_40>div>span{font-weight:700;margin-left:10px}@media (max-width:644px){.template_40>div{margin:0 10px}}@media (max-width:525px){.template_40>div{display:block;margin:0;padding:10px 0;border-bottom:1px solid #fff}.template_40>div:last-child{border-bottom:none}}';
        
        if ( !empty($shortcode) ) {
            return wp_json_encode( $shortcodes[$shortcode] );
        } else {
            return wp_json_encode( $shortcodes );
        }
    
    }
    
    /**
     * Advanced Page Visit Counter Migrate from older version.
     *
     * @since    3.0.1
     */
    public function apvc_migrate_from_old_version( $version )
    {
        global  $wpdb ;
        $version = get_option( "apvc_version" );
        
        if ( $version != '3.0.0' && $version != '3.0.1' && $version != '3.0.2' && $version != '3.0.3' && $version != '3.0.4' && $version != '3.0.5' && $version != '3.0.6' ) {
            $newConfArray = array();
            $avc_configNew = (object) get_option( "apvc_configurations", true );
            $avc_config = json_decode( get_option( "avc_config", true ) );
            foreach ( $avc_config as $key => $value ) {
                
                if ( $key == 'post_types' ) {
                    $newConfArray['apvc_post_types'] = $value;
                } else {
                    
                    if ( $key == 'ip_address' ) {
                        $ips = json_decode( $value );
                        foreach ( $ips as $ip ) {
                            $newConfArray['apvc_ip_address'][] = $ip->tag;
                        }
                    } else {
                        
                        if ( $key == 'exclude_counts' ) {
                            $exCounts = json_decode( $value );
                            foreach ( $exCounts as $exCount ) {
                                $newConfArray['apvc_exclude_counts'][] = $exCount->tag;
                            }
                        } else {
                            
                            if ( $key == 'exclude_users' ) {
                                $users = json_decode( $value );
                                foreach ( $users as $user ) {
                                    $newConfArray['apvc_exclude_users'][] = $user->tag;
                                }
                            } else {
                                
                                if ( $key == 'exclude_show_counter' ) {
                                    $exSCounts = json_decode( $value );
                                    foreach ( $exSCounts as $exSCount ) {
                                        $newConfArray['apvc_exclude_show_counter'][] = $exSCount->tag;
                                    }
                                } else {
                                    
                                    if ( $key == 'spam_controller' ) {
                                        $newConfArray['apvc_spam_controller'][0] = ( $value == "true" ? "on" : "" );
                                    } else {
                                        
                                        if ( $key == 'show_conter_on_fron_side' ) {
                                            $newConfArray['apvc_show_conter_on_front_side'][0] = $value;
                                        } else {
                                            
                                            if ( $key == 'avc_default_text_color_of_counter' ) {
                                                $newConfArray['apvc_default_text_color'][0] = $value;
                                            } else {
                                                
                                                if ( $key == 'apv_default_label' ) {
                                                    $newConfArray['apvc_default_label'][0] = $value;
                                                } else {
                                                    
                                                    if ( $key == 'apv_default_border_radius' ) {
                                                        $newConfArray['apvc_default_border_radius'][0] = $value;
                                                    } else {
                                                        
                                                        if ( $key == 'apv_default_background_color' ) {
                                                            $newConfArray['apvc_default_background_color'][0] = $value;
                                                        } else {
                                                            
                                                            if ( $key == 'apv_default_border_color' ) {
                                                                $newConfArray['apvc_default_border_color'][0] = $value;
                                                            } else {
                                                                
                                                                if ( $key == 'apv_default_border_width' ) {
                                                                    $newConfArray['apvc_default_border_width'][0] = $value;
                                                                } else {
                                                                    
                                                                    if ( $key == 'wid_alignment' ) {
                                                                        $newConfArray['apvc_wid_alignment'][0] = $value;
                                                                    } else {
                                                                        
                                                                        if ( $key == 'show_today_count' ) {
                                                                            $newConfArray['apvc_show_today_count'][0] = ( $value == "true" ? "on" : "" );
                                                                        } else {
                                                                            
                                                                            if ( $key == 'show_global_count' ) {
                                                                                $newConfArray['apvc_show_global_count'][0] = ( $value == "true" ? "on" : "" );
                                                                            } else {
                                                                                if ( $key == 'widget_width' ) {
                                                                                    $newConfArray['apvc_widget_width'][0] = $value;
                                                                                }
                                                                            }
                                                                        
                                                                        }
                                                                    
                                                                    }
                                                                
                                                                }
                                                            
                                                            }
                                                        
                                                        }
                                                    
                                                    }
                                                
                                                }
                                            
                                            }
                                        
                                        }
                                    
                                    }
                                
                                }
                            
                            }
                        
                        }
                    
                    }
                
                }
            
            }
            update_option( "apvc_configurations", $newConfArray );
        }
    
    }

}