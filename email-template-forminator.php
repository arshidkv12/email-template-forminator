<?php 
/**
 * Plugin Name: Email Template for Forminator
 */

new EmailTemplate4Forminator;
class EmailTemplate4Forminator{

    public $msg;

    public function __construct()
    {
        add_filter('forminator_custom_form_mail_admin_message', array( $this, 'msg'), 10, 5);
        add_filter('forminator_quiz_mail_admin_message', array( $this, 'msg' ), 10, 5);
        add_filter('forminator_email_message', array( $this, 'email4frm_clean'));
    }


    public function msg( $message, $custom_form, $data, $entry, $mail ){
        $this->msg = $message;
        return $message;
    }

    public function email4frm_clean( $body ){
        $template = file_get_contents( plugin_dir_path(__FILE__) .'/template.php' );
        $body = str_replace( '{msg}', $this->msg, $template);
        return $body;
    }
}