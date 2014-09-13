<?php
/*
 * API Usage Demonstration
 */

/**
* Include API helper class
*/
include("api.php");

/**
 * API Key associated with your account.
 * You can generate one from your account if you don't have one yet by naviagting to Account Settings -> API Key
 */
//$api_key = "xxxxxxxxxxxxxxxxxxxxx";
//
//$sms_api = new SMS_API($api_key);

/**
 * Send a bulk SMS to an array of phone numbers. Message will be scheduled if date and time is passed.
 */
//$message = "another test Testing bulk SMS from API"; //message to be sent
//$phone_numbers = array('0247258228', '0234727178'); //array of phone numbers
//$sms_api->send_bulk_sms($message, $phone_numbers, 'mNotify');


$api_key = "WXHXYi3BlJ6wavIG1jdz0ns8J";
$sms_api = new SMS_API($api_key);
$sms_api->contact_list();
//$sms_api->view_group_members('Rick');
//$sms_api->send_bulk_sms($api_key, '0201264289', 'Try');
/**
 * Remove comment to use
 * Send SMS to a group of Contacts
 *
$message = "Tesing Group SMS from API"; //message to be sent
$group = array('test'); //array of group names, as they appear on system
$sms_api->send_group_sms($message, $group, 'mNotify');
*/

/**
 * Remove comment to use
 * Obtaning SMS balance
echo $sms_api->check_balance();
*/
?>
