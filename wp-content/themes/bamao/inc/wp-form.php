<?php
add_filter( 'wpforms_frontend_strings', 'wpforms_dev_frontend_strings', 20, 1 );
function wpforms_dev_frontend_strings( $strings ) {

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

add_filter( 'wpforms_entry_email_atts', 'rt_custom_wpforms_entry_email_atts', 10, 1 );
function rt_custom_wpforms_entry_email_atts($email) {
    if( isset($email['message']) && !empty($email['message']) ) {
        $email['message'] = preg_replace( "/\r|\n/", "", $email['message'] );
    }
    return $email;
}

add_filter( 'wpforms_emails_notifications_message', 'rt_custom_wpforms_emails_notifications_message', 10, 3 );
function rt_custom_wpforms_emails_notifications_message($message, $current_template, $object) {
    list( $before, $after ) = array_map( 'trim', explode( '<td class="field-name field-value" colspan="2">', $message, 2 ) );
    if(!empty($after)) {
        $message = substr($after, 0, -10);
    }
    return $message;
}