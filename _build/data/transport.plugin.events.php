<?php
/**
 * Default plugin events
 *
 * @package LoginNotification
 * @subpackage build
 */
$events = array();

$events['OnManagerLogin'] = $modx->newObject('modPluginEvent');
$events['OnManagerLogin']->fromArray(array(
    'event' => 'OnManagerLogin'
),'',true,true);

return $events;