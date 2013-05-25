<?php

if (PHP_SAPI !== 'cli') {
	echo "You must use the command line to run this script.";
	exit;
}

$mt = microtime(true);

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

echo "Data Generator plugin CLI interface.\n";
echo "Copyright (C) Pawel Sroka 2013\n\n";

/*
 * Provide help info
 */
$options = getopt('h', array('help'));
if (count($options)) {
	//TODO print help
	exit(0);
}

/*
 * Process input parameters
 */
//parse parameters
$options = getopt('a:p:l:', array(
	'amount:',
	'profile:',
	'locale:',
));
$amount = elgg_extract('amount', $options, elgg_extract('a', $options));
$profile = elgg_extract('profile', $options, elgg_extract('p', $options));
$locale = elgg_extract('locale', $options, elgg_extract('l', $options));
// var_dump($amount, $profile, $locale);

//fail on missing required
if (!in_array($profile, data_generator::getElggProviderMethods())) {
	echo "Invalid profile specified! Valid are: " . implode(', ', data_generator::getElggProviderMethods()) . "\n";
	exit(1);
}
if (!in_array($locale, data_generator::getLocales())) {
	echo "Invalid locale specified! Valid are: " . implode(', ', data_generator::getLocales()) . "\n";
	exit(2);
}
if ($amount <= 0) {
	echo "Invalid amount specified! It must be positive number\n";
	exit(3);
}

/*
 * Environment settings
 */
echo "Adjusting settings...\n";

if (ini_set('memory_limit', -1) === false) {
	echo "Failed to change memory limit!\n";
}
if (ini_get('max_execution_time') != 0 && ini_set('max_execution_time', 0) === false) {
	echo "Failed to change execution time limit!\n";
}

/*
 * Perform action
 */
echo "Generating content...\n";
// do the generation 
// TODO with iterated progress and memory status
$success = data_generator::generate($amount, $profile, $locale);

echo "Generated $success items";
echo sprintf(" in %.2fs", microtime(true) - $mt);
exit(0);