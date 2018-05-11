
# Modx Extra: Login Notification

This is a [MODX Revolution](https://modx.com) extra.

It provides an email notification on manager login. This is a security feature so an administrator can quickly detect a fraudulent connection.

It is available as a package in MODX Extra repository: https://modx.com/extras/package/loginnotification

__Current version__ (github): 1.0.0-pl

__Current version in Modx Extra repository__: 1.0.0-pl


## Features

 * Dead simple. Really.
 * Works out of the box with sensible default
 * Detects successful connection to the manager
 * Specify which address to send the notification to (and also CC/BCC).
 * Conveniently provides useful placeholders (IP, useragent, ...) to use in your email body
 
 
## Install

It is recommended to install from [MODX Extra repository](https://modx.com/extras/package/loginnotification).

You can also upload manually the transport package (found in `_dist` folder) to your MODX installation.


## Plugin properties

The plugin offers several useful properties.

Note that it is recommended to create a new Property Set instead of editing the default one.


**mailHTML**: Enable HTML for mail body

*default: `false`*


**mailFromName**: Sender's name - If empty, the `site_name` system settings will be used

*default: ` `*  (empty)


**mailFromEmail**: Sender's email - If empty, the `emailsender` system settings will be used

*default: ` `*  (empty)


**mailsTo**: Email addresses to send to (comma-separated) - If empty, current user address will be used

*default: ` `*  (empty)


**mailsToCC**: Email address to send to (comma-separated), as a Carbon Copy

*default: ` `*  (empty)


**mailsToBCC**: Email address to send to (comma-separated), as a Blind Carbon Copy

*default: ` `*  (empty)


**mailSubject**: Email subject - You can use Modx template tags (additional placeholders available, see documentation)

*default: `[[++site_name]] - Successful login notification`*


**mailBody**: Email body - Either directly the content, or a chunk name - You can use Modx template tags (additional placeholders available, see documentation)

*default:*
```

A successful login was detected on the website [[++site_name]].

Account: [[+fullname]] ([[+username]] - [[+email]]) 
IP: [[+IP]]
Location: [[+geoip_city]] - [[+geoip_country_name]]
Date: [[+date]]
User Agent: [[+user_agent]]

-------
This message was sent automatically, please do not reply.
```


## Template tags for subject and body

Usual [Modx template tags are of course available](https://docs.modx.com/revolution/2.x/making-sites-with-modx/commonly-used-template-tags).

But there are some additional placeholders available:

 - `username`: User's username
 - `fullname`: User's full name (as defined in profile)
 - `email`: User's email
 - `sudo`: If user has sudo capability
 - `date`: current date, formatted as specified in the system's settings
 - `IP`: User's IP address (_warning_: can be spoofed)
 - `user_agent`: User's user-agent string (_warning_: can be spoofed)
 - `geoip_city`: User's city (if GeoIP information available through `$_SERVER` global var)
 - `geoip_country_name`: User's country name (if GeoIP information available through `$_SERVER` global var)

You can use them as `[[+placeholder]]`, e.g. `[[+fullname]]`.


## Mail sending

Currently, this plugin only supports [modPHPMailer](https://docs.modx.com/revolution/2.x/developing-in-modx/advanced-development/modx-services/modmail).

SMTP is not supported as well.

But feel free to [open a new issue](https://github.com/Indigo744/Modx-Revo-Login-Notification/issues) to request it if needed.


## Connection detection

Currently, this plugin only detects successful connection to the manager context.

Failed connection attempts are harder to detect, since there is no specific event available from Modx.

But feel free to [open a new issue](https://github.com/Indigo744/Modx-Revo-Login-Notification/issues) to request other context if needed.


