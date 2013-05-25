<?php
elgg_make_sticky_form('data_generator/run');

$amount = get_input('amount');
$profile = get_input('profile');
$locale = get_input('locale');

try {
	$mt = microtime(true);
	$success = data_generator::generate($amount, $profile, $locale);
	$total = microtime(true) - $mt;
	
	system_message(elgg_echo('data_generator:action:run:success', array($success, $total)));
	elgg_clear_sticky_form('data_generator/run');
} catch (Exception $e) {
	register_error($e->getMessage());
}
