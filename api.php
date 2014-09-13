<?php

/**
 * mNotify
 *
 * A helper class for mNotify's API
 *
 * @package		mNotify
 * @author		mNotify Dev Team
 * @copyright	        Copyright (c) 2013, mNotify Company Ltd.
 * @link		http://mnotify.net
 * @since		Version 1.0
 */
class SMS_API {

    /**
     * Variable 
     */
    public $base_url = "http://bulk.mnotify.net/api/"; //API Url
    public $api_key; //Account API key

    /**
     * Class constructor
     *
     * @param   string  $api_key API key
     */

    public function __construct($api_key) {
        $this->api_key = $api_key;
    }

    /**
     * Handles URL calls using CURL
     * 
     * @param       array       $data        data to be posted
     * @param       string      $url         data will be posted to
     * @return      string      $resonse     received from server
     */
    private function curl($data, $url) {
        //create array with data encoded in json
        $bodyData = array(
            'json' => json_encode($data)
        );

        $bodyStr = http_build_query($bodyData);

        //initialize curl
        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $bodyStr,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Content-Length: ' . strlen($bodyStr)
            ),
            CURLOPT_RETURNTRANSFER => true
        ));

        //execute url
        $response = curl_exec($ch);

        //echo response
        echo $response;
    }

    /*
     * Validates a phone number
     *
     * @param string $phone phone number
     * @return boolean
     */

    public function validate_phone_number($phone) {
        return (strlen($phone) >= 9 && strlen($phone) <= 12) ? true : false;
    }

    /**
     * Sends bulk sms to a list of contacts
     * @param   string          $message        message to be sent
     * @param   string          $phone          phone number of receipient
     * @param   string          $sender_id      Sender Id for message
     * @param   date_time       $delay          When message should be sent for scheduled messages
     */
    public function send_bulk_sms($message, $phone, $sender_id, $delay = 0) {
        $number_string = "";

        for ($i = 0; $i < count($phone); $i++) {
            if ($this->validate_phone_number($phone[$i])) {
                $number_string .= $phone[$i] . ",";
            }
        }

        /*         * Extracts individual phone numbers and puts them into an array */

        $extracted_numbers = explode(",", $number_string);
        /* delimits the phone numbers by a comma */
        $numbers = array();

        for ($i = 0; $i < count($extracted_numbers) - 1; $i++) {
            $numbers[$i] = $extracted_numbers[$i];
        } /* pushing numbers into the array */

        //data to be posted
        $data = array(
            "message" => $message,
            "phone" => $numbers,
            "sender_id" => $sender_id,
            "api_key" => $this->api_key,
            "message_type" => 1,
            "delay" => $delay
        );

        $this->curl($data, $this->base_url . "bulk_sms");
    }

    /*
     * Send messages to a group
     * @param   string          $message        message to be sent
     * @param   string          $group          receipient group
     * @param   string          $sender_id      Sender Id for message
     * @param   date_time       $delay          When message should be sent for scheduled messages        
     */

    public function send_group_sms($message, $group, $sender_id, $delay = 0) {

        $data = array(
            "message" => $message,
            "group" => $group,
            "sender_id" => $sender_id,
            "api_key" => $this->api_key,
            "message_type" => 2,
            "delay" => $delay
        );
        $this->curl($data, $this->base_url . "group_sms");
    }

    /*
     * Creates a message and save
     * @param    string    $message       message to be sent
     * @param    string    $title         message title     
     */

    public function create_message($message, $title) {

        $data = array(
            "message" => $message,
            "api_key" => $this->api_key,
            "title" => $title
        );
        //handles message saving
        $this->curl($data, $this->base_url . "save_message");
    }

    /*
     * Edit an existing message and save
     * @param    string    $message       message to be edited
     * @param    string    $title         title of message
     */

    public function edit_message($message, $title) {

        $data = array(
            "message" => $message,
            "api_key" => $this->api_key,
            "title" => $title
        );
        //handles message editing
        $this->curl($data, $this->base_url . "edit_message");
    }

    /*
     * Delete an existing message
     * @param    string    $title         title of message
     */

    public function delete_message($title) {

        $data = array(
            "title" => $title,
            "api_key" => $this->api_key
        );
        //handles message deletion
        $this->curl($data, $this->base_url . "delete_message");
    }

    /*
     * Views saved messages
     */

    public function view_message($title) {

        /*
         * @param    string    $title         title of message
         */
        $data = array(
            "title" => $title,
            "api_key" => $this->api_key
        );
        //handles messaging viewing
        $this->curl($data, $this->base_url . "view_message");
    }

    /*
     * Create a new group 
     * @param    string    $group_name    name of group
     */

    public function create_group($group_name) {

        $data = array(
            "api_key" => $this->api_key,
            "group_name" => $group_name
        );
        //handles group creating
        $this->curl($data, $this->base_url . "create_group");
    }

    /*
     * Deletes an existing group
     * @param    string    $group_name    name of the group
     */

    public function delete_group($group_name) {

        $data = array(
            "api_key" => $this->api_key,
            "group_name" => $group_name
        );
        //handles group deletion
        $this->curl($data, $this->base_url . "delete_group");
    }

    /*
     * View details existing groups
     * @param    string    $border        0
     */

    public function view_groups($border = 0) {

        $data = array(
            "api_key" => $this->api_key,
            "border" => $border,
        );
        //handles group viewing
        $this->curl($data, $this->base_url . "view_groups");
    }

    /*
     * View members in a group
     * @param    string    $border          0
     * @param    string    $group_name    the group name
     */

    public function view_group_members($group_name, $border = 0) {

        $data = array(
            "api_key" => $this->api_key,
            "border" => $border,
            "group_name" => $group_name
        );
        //handles group member views
        $this->curl($data, $this->base_url . "view_group_members");
    }

    /*
     * view contacts
     * @param    string       $border      0
     */

    public function contact_list($border = 0) {

        $data = array(
            "api_key" => $this->api_key,
            "border" => $border,
        );
        //handles contacts list
        $this->curl($data, $this->base_url . "contact_list");
    }

    /*
     * Export contacts
     */

    public function export_contacts() {

        $data = array(
            "api_key" => $this->api_key,
        );
        //handles export of contacts
        $this->curl($data, $this->base_url . "export_contacts");
    }

    /*
     * Create or add a new contact 
     * @param   string          $title          title of contact
     * @param   string          $firstname      contact's firstname
     * @param   string          $lastname       contact's lastname
     * @param   string          $phone          phone number        
     * @param   string          $email          contact's email
     * @param   date_time       $dob            date of birth        
     * @param   string          $group          contact's group  
     */

    public function add_new_contact($title, $firstname, $lastname, $phone, $email, $dob, $group) {

        $data = array(
            "group" => $group,
            "api_key" => $this->api_key,
            "title" => $title,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "phone" => $phone,
            "email" => $email,
            "dob" => $dob
        );
        //handles addition of new contact
        $this->curl($data, $this->base_url . "add_new_contact");
    }

    /*
     * Delete a sender Id
     * @param    string    $sender_id     sender id to be deleted
     */

    public function delete_sender_id($sender_id) {

        $data = array(
            "api_key" => $this->api_key,
            "sender_id" => $sender_id
        );
        //handles sender id deletion
        $this->curl($data, $this->base_url . "delete_sender_id");
    }

    /*
     * Change password
     * @param    string    $password        old password
     * @param    string    $new_password    new password
     */

    public function change_password($password, $new_password) {

        $data = array(
            "api_key" => $this->api_key,
            "password" => $password,
            "new_password" => $new_password
        );
        //handles password change
        $this->curl($data, $this->base_url . "change_password");
    }

    /*
     * Making modifications to account settings
     * @param    string    $firstname     first name of the account holder
     * @param    string    $email         email of account holder
     * @param    string    $lastname      lastname of the person
     * @param    string    $purpose       purpose of account whether personal or business    
     */

    public function account_settings($firstname, $lastname, $email, $purpose) {

        $data = array(
            "api_key" => $this->api_key,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "email" => $email,
            "purpose" => $purpose
        );
        //handles account settings
        $this->curl($data, $this->base_url . "account_settings");
    }

    /**
     * Retireve SMS credit balance
     */
    public function check_balance() {
        $url = $this->base_url . "balance/?key=" . $this->api_key;
        echo file_get_contents($url);
    }

    /*
     * Getting delivery report
     * @param    date    $from     date to get the delivery report from
     * @param    date    $to       date to get the delivery report up to
     */
    public function delivery_report($from = "", $to = "") {
        $data = array(
            "api_key" => $this->api_key,
            "from" => $from,
            "to" => $to,
        );
        //handles the retrieval of delivery report
        $this->curl($data, $this->base_url . "delivery_report");
    }

}

?>
