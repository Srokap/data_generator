<?php

echo '<ul><li class="elgg-message elgg-state-notice">' . elgg_echo('admin:data_generator:disclaimer') . '</li></ul>';

echo elgg_view_module('main', elgg_echo('admin:data_generator:title'), 
	elgg_view_form('data_generator/run'));

