<?php
/**
 * Default plugin properties
 *
 * @package LoginNotification
 * @subpackage build
 */
$properties = array(
    array(
        'name' => 'mailHTML',
        'desc' => "Enable HTML for mail body",
        'type' => 'combo-boolean',
        'value' => "0",
        'options' => '',
    ),
    array(
        'name' => 'mailFromName',
        'desc' => "Sender's name - If empty, the `site_name` system settings will be used",
        'type' => 'textfield',
        'value' => "",
        'options' => '',
    ),
    array(
        'name' => 'mailFromEmail',
        'desc' => "Sender's email - If empty, the `emailsender` system settings will be used",
        'type' => 'textfield',
        'value' => "",
        'options' => '',
    ),
    array(
        'name' => 'mailsTo',
        'desc' => "Email address to send to (comma-separated) - If empty, current user address will be used",
        'type' => 'textfield',
        'value' => "",
        'options' => '',
    ),
    array(
        'name' => 'mailsToCC',
        'desc' => "Email address to send to (comma-separated), as a Carbon Copy",
        'type' => 'textfield',
        'value' => "",
        'options' => '',
    ),
    array(
        'name' => 'mailsToBCC',
        'desc' => "Email address to send to (comma-separated), as a Blind Carbon Copy",
        'type' => 'textfield',
        'value' => "",
        'options' => '',
    ),
    array(
        'name' => 'mailSubject',
        'desc' => "Email subject - You can use Modx template tags (additional placeholders available, see documentation)",
        'type' => 'textfield',
        'value' => "[[++site_name]] - Successful login notification",
        'options' => '',
    ),
    array(
        'name' => 'mailBody',
        'desc' => "Email body - Either directly the content, or a chunk name - You can use Modx template tags (additional placeholders available, see documentation)",
        'type' => 'textarea',
        'options' => '',
        'value' => <<<MESSAGE

A successful login was detected on the website [[++site_name]].

Account: [[+fullname]] ([[+username]] - [[+email]]) 
IP: [[+IP]]
Location: [[+geoip_city]] - [[+geoip_country_name]]
Date: [[+date]]
User Agent: [[+user_agent]]

-------
This message was sent automatically, please do not reply.
MESSAGE
    ),
);
return $properties;