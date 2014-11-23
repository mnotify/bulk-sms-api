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

/**
 * Send a bulk SMS to an array of phone numbers. Message will be scheduled if date and time is passed.
 */
$api_key = "xxxxxxxxxxxxxxxxxxxxx";
$sms_api = new SMS_API($api_key);

$message = "another test Testing bulk SMS from API"; //message to be sent
$phone_numbers = array('0247XXXXXX', '0234XXXXXX'); //array of phone numbers
$sms_api->send_bulk_sms($message, $phone_numbers, 'SenderName');


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
