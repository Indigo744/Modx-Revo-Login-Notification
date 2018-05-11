<?php
/**
 * Login Notification Plugin
 * https://github.com/Indigo744/Modx-Revo-Login-Notification
 *
 * Events: OnManagerLogin
 * 
 * @package LoginNotification
 *
 * @var array $scriptProperties
 */

/** Package information (set at build) **/
$pluginName = "__PKG_NAME__";
$pluginVersion = '__PKG_VERSION__-__PKG_RELEASE__';

/* Get user profile */
$profile = $user->getOne('Profile');

/** Get properties **/
$mailHTML = $modx->getoption('mailHTML', $scriptProperties, $modx->getOption($pluginName . '.mailHTML', null, false));
$mailFromName = $modx->getoption('mailFromName', $scriptProperties, $modx->getOption($pluginName . '.mailFromName', null, ''));
$mailFromEmail = $modx->getoption('mailFromEmail', $scriptProperties, $modx->getOption($pluginName . '.mailFromEmail', null, ''));
$mailReplyToEmail = $modx->getoption('mailReplyToEmail', $scriptProperties, $modx->getOption($pluginName . '.mailReplyToEmail', null, ''));
$mailsTo = array_filter(explode(',', $modx->getoption('mailsTo', $scriptProperties, $modx->getOption($pluginName . '.mailsTo', null, ''))));
$mailsToCC = array_filter(explode(',', $modx->getoption('mailsToCC', $scriptProperties, $modx->getOption($pluginName . '.mailsToCC', null, ''))));
$mailsToBCC = array_filter(explode(',', $modx->getoption('mailsToBCC', $scriptProperties, $modx->getOption($pluginName . '.mailsToBCC', null, ''))));
$mailSubject = $modx->getoption('mailSubject', $scriptProperties, $modx->getOption($pluginName . '.mailSubject', null, "[[++site_name]] - Successful login notification"));
$mailBody = $modx->getoption('mailBody', $scriptProperties, $modx->getOption($pluginName . '.mailBody', null, <<<MESSAGE

A successful login was detected on the website [[++site_name]].

Account: [[+fullname]] ([[+username]] - [[+email]]) 
IP: [[+IP]]
Location: [[+geoip_city]] - [[+geoip_country_name]]
Date: [[+date]]
User Agent: [[+user_agent]]

-------
This message was sent automatically, please do not reply.
MESSAGE
));

/* Define default value if empty */
if (empty($mailFromName)) $mailFromName = $modx->getOption('site_name');
if (empty($mailFromEmail)) $mailFromEmail = $modx->getOption('emailsender');
if (empty($mailsTo)) $mailsTo = array($profile->get('email'));

/* Set custom placeholders */
$modx->setPlaceholders(
    array(
        'fullname' => $profile->get('fullname'),
        'email' => $profile->get('email'),
        'username' => $user->get('username'),
        'sudo' => (bool)$user->get('sudo'),
        'date' => date($modx->getOption('manager_date_format').' '.$modx->getOption('manager_time_format')),
        'IP' => $_SERVER['REMOTE_ADDR'],
        'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        'geoip_city' => isset($_SERVER["GEOIP_CITY"]) ? $_SERVER['GEOIP_CITY'] : 'Unknown city',
        'geoip_country_name' => isset($_SERVER["GEOIP_COUNTRY_NAME"]) ? $_SERVER['GEOIP_COUNTRY_NAME'] : 'Unknown country',
    )
);

/* Try to get chunk if there is not newline */
$mailBodyProcessed = '';
if (strpos($mailBody, "\n") === FALSE) {
    $mailBodyProcessed = $modx->getChunk($mailBody);
}
if (empty($mailBodyProcessed)) {
    /* Process body in temporary chunk */
    $tempChunk = $modx->newObject('modChunk', array('name' => "tmp_" . uniqid()));
    $mailBodyProcessed = $tempChunk->process(null, $mailBody);
    unset($tempChunk);
}

/* Process subject in temporary chunk */
$tempChunk = $modx->newObject('modChunk', array('name' => "tmp_" . uniqid()));
$mailSubjectProcessed = $tempChunk->process(null, $mailSubject);
unset($tempChunk);

/* Init mail modx class */
$modx->getService('mail', 'mail.modPHPMailer');
$modx->mail->set(modMail::MAIL_FROM, $mailFromEmail);
$modx->mail->set(modMail::MAIL_FROM_NAME, $mailFromName);
$modx->mail->set(modMail::MAIL_SUBJECT, $mailSubjectProcessed);
$modx->mail->set(modMail::MAIL_BODY, $mailBodyProcessed);
$modx->mail->setHTML((bool)$mailHTML);

// Set Reply-To if needed
if (!empty($mailReplyToEmail)) $modx->mail->address('reply-to', $mailReplyToEmail);

// Set To
foreach($mailsTo as $mailTo) {
    $modx->mail->address('to', $mailTo);
}

// Set To CC
foreach($mailsToCC as $mailToCC) {
    $modx->mail->address('cc', $mailToCC);
}

// Set To BCC
foreach($mailsToBCC as $mailToBCC) {
    $modx->mail->address('bcc', $mailToBCC);
}

// Send the mail!
if (!$modx->mail->send()) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'LoginNotification - An error occurred while trying to send the email: '. $modx->mail->mailer->ErrorInfo);
}

$modx->mail->reset();
