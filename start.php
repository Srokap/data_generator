<?php
require_once(dirname(__FILE__) . '/vendors/autoload.php');

elgg_register_event_handler('init', 'system', array('data_generator', 'init'));
