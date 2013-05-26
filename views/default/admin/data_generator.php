<?php

echo '<ul><li class="elgg-message elgg-state-notice">' . elgg_echo('admin:data_generator:disclaimer') . '</li></ul>';

echo elgg_view_module('main', elgg_echo('admin:data_generator:title'), 
	elgg_view_form('data_generator/run'));

echo elgg_view_module('main', elgg_echo('admin:data_generator:cli:warning'),
	elgg_echo('admin:data_generator:cli:disclaimer', array(elgg_get_plugins_path() . 'data_generator/cli_run.php')),
	array(
		'class' => 'mtm',
	)
);
