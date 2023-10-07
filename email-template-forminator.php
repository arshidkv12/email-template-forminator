<?php 
/**
 * Plugin Name: Email Template for Forminator
 * Description: Custom email template
 * Version: 1.0.0
 * Author: Arshid
 */

new EmailTemplate4Forminator;
class EmailTemplate4Forminator{

    public $msg;
    public $tags;
    public $values;

    public function __construct()
    {
        add_filter('forminator_custom_form_mail_admin_message', array( $this, 'msg'), 10, 5);
        add_filter('forminator_quiz_mail_admin_message', array( $this, 'msg' ), 10, 5);
        add_filter('forminator_email_message', array( $this, 'email4frm_clean'));
    }


    public function msg( $message, $custom_form, $data, $entry, $mail ){
        $this->msg    = $message;
        $keys         = array_keys( $data );
        $this->values = array_values( $data );
        $this->tags   = array_map(function($item){
                            return '{'.$item.'}';
                        }, $keys);
                
        return $message;
    }

    public function email4frm_clean( $body ){
        $template = file_get_contents( plugin_dir_path(__FILE__) .'/template.php' );
        $body = str_replace( '{msg}', $this->msg, $template);
        $body = str_replace( $this->tags, $this->values, $body);
        return $body;
    }
}
