<?php

namespace BM\Core\Common;

class Wpform
{

    public static function init()
    {
        static $init = null;

        if ($init === null) {
            $init = new self();
            $init->addAction();
            $init->setupFilter();
        }

        return $init;
    }

    private function setupFilter() 
    {
        add_filter( 'wpforms_frontend_strings', [$this, 'wpforms_frontend_strings'], 20, 1 );   
        add_filter( 'wpforms_fields_show_options_setting', '__return_true' );
        // Pardot
        add_filter( 'wpforms_builder_settings_sections', [$this, 'addPardotSettingSection'], 20, 2 );
        add_filter( 'wpforms_form_settings_panel_content', [$this, 'addPardotSettingSectionContent'], 20 );

        add_filter( 'wpforms_ajax_submit_success_response', [$this, 'submit_success_response'], 10, 3 );
    }

    private function addAction()
    {
        add_action( 'wpforms_process_complete', [$this, 'customWpformsProcessComplete'], 10, 4 );
        add_action( 'init', [$this, 'createTableLog'] );
        add_action( 'wpforms_entry_details_content', [ $this, 'addDetailsLog' ], 50, 2 );
    }

    function wpforms_frontend_strings( $strings ) {

        if(get_locale() == 'vi') {
            // Required field
            $strings[ 'val_required' ] = 'Trường này là bắt buộc.';

            // Valid Email
            $strings[ 'val_email' ] = 'Vui lòng nhập một địa chỉ email hợp lệ.';

            // All phone field - Smart, International and US
            $strings [ 'val_phone' ] = 'Xin vui lòng nhập một số điện thoại hợp lệ.';
        }

        return $strings;
    }

    // Add pardot section setting
    function addPardotSettingSection($sections, $form_data) 
    {
        if( isset($form_data['fields']) && is_array($form_data['fields']) && count($form_data['fields']) > 0 ) {
            $sections['rt_pardot'] = 'Pardot Settings';
        }
        
        return $sections;
    }

    // Add pardot section setting content
    function addPardotSettingSectionContent($instance)
    {
        $formData = $instance->form_data;        
        ?>
        <div class="wpforms-panel-content-section wpforms-panel-content-section-rt_pardot">
            <div class="wpforms-panel-content-section-title">Pardot Settings</div>

            <?php
                if( isset($formData['fields']) && is_array($formData['fields']) && count($formData['fields']) > 0 ) {

                    wpforms_panel_field(
                        'toggle',
                        'pardots',
                        'pardot_status',
                        $instance->form_data,
                        'Enable Pardot',
                        [
                            'default'    => '',
                            'parent'     => 'settings',
                            'placeholder' => 'Enable send data to pardot '
                        ]
                    );

                    wpforms_panel_field(
                        'text',
                        'pardots',
                        'pardot_url',
                        $instance->form_data,
                        'Pardot URL',
                        [
                            'default'    => '',
                            'parent'     => 'settings',
                            'placeholder' => 'Pardot url'
                        ]
                    );

                    ob_start();
                    foreach( $formData['fields'] as $key => $field ) {
                        if( $field['type'] != 'pagebreak' && $field['type'] != 'html') {
                           
                            wpforms_panel_field(
                                'text',
                                'pardots',
                                'pardot_field_' . $field['id'],
                                $instance->form_data,
                                $field['label'] . ' (ID: #'. $field['id'] .')',
                                [
                                    'default'    => '',
                                    'parent'     => 'settings',
                                    'placeholder' => 'Pardot field name'
                                ]
                            );
                        }
                    }

                    wpforms_panel_fields_group(
                        ob_get_clean(),
                        [
                            'unfoldable' => true,
                            'group'      => 'settings_pardot',
                            'title'      => esc_html__( 'Fields', 'wpforms-lite' ),
                        ],
                        true
                    );
                }
            ?>
        </div>
        <?php
    }

    function customWpformsProcessComplete($fields, $entry, $form_data, $entry_id) 
    {
        // Send data tp pardot
        if( 
            isset($form_data['settings']['pardots']) 
            && is_array($form_data['settings']['pardots']) 
            && count($form_data['settings']['pardots']) > 0 
            && isset($form_data['settings']['pardots']['pardot_status']) 
            && intval(isset($form_data['settings']['pardots']['pardot_status'])) == 1 
            && isset($form_data['settings']['pardots']['pardot_url']) 
            && !empty($form_data['settings']['pardots']['pardot_url'])
        ) {

            $data = [];

            foreach($fields as $key => $field) {
                if( isset($form_data['settings']['pardots']['pardot_field_' . $field['id']]) && !empty($form_data['settings']['pardots']['pardot_field_' . $field['id']]) ) {
                    if($field['value'] == 'date-time') {
                        $data[$form_data['settings']['pardots']['pardot_field_' . $field['id']]] = date('Y-m-d H:i:s', $field['unix']);
                    } else {
                        $data[$form_data['settings']['pardots']['pardot_field_' . $field['id']]] = isset($field['value_raw']) && !empty($field['value_raw']) ? $field['value_raw'] : $field['value'];
                    }
                    
                }
            }

            $options = [
                'body' => $data
            ];

            $response = wp_remote_post( $form_data['settings']['pardots']['pardot_url'], $options);

            if ( is_wp_error( $response ) ) {
                // Error
                $error_message = $response->get_error_message();
                self::addLog(
                    [
                        'message' => 'Error: ' . $error_message,
                        'data' => $data
                    ], 
                    'pardot',
                    $entry_id
                );
            } else {
                // Success
                self::addLog(
                    [
                        'message' => 'Send data to Pardot success',
                        'data' => $data
                    ], 
                    'pardot',
                    $entry_id
                );
            }
        }

        
    }

    function addDetailsLog( $entry, $form_data ) 
    {
        if( 
            isset($form_data['settings']['pardots']) 
            && is_array($form_data['settings']['pardots']) 
            && count($form_data['settings']['pardots']) > 0 
            && isset($form_data['settings']['pardots']['pardot_status']) 
            && intval(isset($form_data['settings']['pardots']['pardot_status'])) == 1 
            && isset($form_data['settings']['pardots']['pardot_url']) 
            && !empty($form_data['settings']['pardots']['pardot_url'])
        ) {
            $logs = self::getLogs('pardot', $entry->entry_id);
            ?>
            <!-- Entry Logs metabox -->
            <div id="wpforms-entry-logs" class="postbox">

                <div class="postbox-header">
                    <h2 class="hndle">
                        <span><?php esc_html_e( 'Pardot Log', 'wpforms' ); ?></span>
                    </h2>
                </div>

                <div class="inside">

                    <?php
                        if( isset($logs) && is_array($logs) && count($logs) > 0) {
                            echo '<div class="wpforms-entry-logs-list">';
                                foreach($logs as $log) {
                                    ?>
                                    <div class="wpforms-entry-logs-single odd">
                                        <div class="wpforms-entry-logs-byline">
                                            Added by server on <?= $log->time; ?>						
                                        </div>

                                        <?php
                                            $content = $log->content;
                                            if( !empty($content) ) {
                                                $content = unserialize($log->content);

                                                
                                                if( isset($content['message']) ) {
                                                    echo '<p style="margin-bottom: .5rem;"><strong>Message:</strong> '. $content['message'] .'</p>';
                                                }

                                                if( isset($content['data']) ) {
                                                    echo '
                                                    <details>
                                                        <summary><strong>Data Post</strong></summary>';
                                                        echo '<pre>';
                                                            print_r($content['data']);
                                                        echo '</pre>
                                                    </details>';
                                                }
                                            }
                                        ?>                                    
                                    </div>
                                    <?php
                                }
                            echo '</div>';
                        } else {
                            echo '<p class="no-logs">No logs.</p>';
                        }                    
                    ?>

                </div>

            </div>
		<?php
        }
	}

    public static function getLogs($type = 'common', $parent = 0) 
    {
        global $wpdb;
        $tableName = $wpdb->prefix . 'rt_wpforms_entry_logs';
        $results = $wpdb->get_results( "SELECT * FROM $tableName WHERE type = '$type' AND parent = $parent", OBJECT );

        return $results;
    }

    public static function addLog($content, $type = 'common', $parent = 0) 
    {
        global $wpdb;
        $tableName = $wpdb->prefix . 'rt_wpforms_entry_logs';

        $wpdb->insert( 
            $tableName, 
            array( 
                'content' => serialize($content), 
                'type' => $type, 
                'parent' => $parent, 
            ), 
            array( 
                '%s', 
                '%s', 
                '%d',
            ) 
        );
    }

    function createTableLog() 
    {
        if( empty(get_option( "rt_wpforms_entry_logs_version" )) ) {
            global $wpdb;

            $tableName = $wpdb->prefix . 'rt_wpforms_entry_logs';
            $charsetCollate = $wpdb->get_charset_collate();

            $sql = "CREATE TABLE $tableName (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                content text NOT NULL,
                type varchar(20) DEFAULT '' NOT NULL,
                parent mediumint(9) DEFAULT '0' NOT NULL,
                time datetime DEFAULT current_timestamp() NOT NULL ,
                PRIMARY KEY  (id)
            ) $charsetCollate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );

            add_option( 'rt_wpforms_entry_logs_version', '1.0' );
        }
    }

    public function submit_success_response($response, $form_id, $form_data)
    {
        $response['submit_class'] = isset($form_data['settings']['submit_class']) ? $form_data['settings']['submit_class'] : '';
        return $response;
    }

    
}