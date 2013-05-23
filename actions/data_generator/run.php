<?php
elgg_make_sticky_form('data_generator/run');

$amount = get_input('amount');
$profile = get_input('profile');
$locale = get_input('locale');

try {
	$amount = (int)$amount;
	if ($amount <= 0) {
		throw new InvalidArgumentException("Amount must be positive integer.");
	}
	if (!in_array($profile, data_generator::getElggProviderMethods())) {
		throw new InvalidArgumentException("Invalid profile provided: $profile");
	}
	if (!in_array($locale, data_generator::getLocales())) {
		throw new InvalidArgumentException("Invalid locale provided: $locale");
	}
	
	$mt = microtime(true);
	$generator = data_generator::getGenerator($locale);
	$success = 0;
	while ($amount-- > 0) {
		$data = $generator->{$profile}();
		try {
			if ($data->save()) {
				$success++;
			}
		} catch (Exception $e) {
			//fail silently here - just count
		}
	}
	$total = microtime(true) - $mt;
	
	system_message(elgg_echo('data_generator:action:run:success', array($success, $total)));
	elgg_clear_sticky_form('data_generator/run');
} catch (Exception $e) {
	register_error($e->getMessage());
}
