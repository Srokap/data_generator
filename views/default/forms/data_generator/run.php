<?php

echo '<p>';
echo '<label>' . elgg_echo('admin:data_generator:amount') . '</label>';
echo elgg_view('input/text', array(
	'name' => 'amount',
	'placeholder' => elgg_echo('admin:data_generator:amount:placeholder'),
	'value' => elgg_get_sticky_value('data_generator/run', 'amount'),
));
echo '</p>';

echo '<p>';
echo '<label>' . elgg_echo('admin:data_generator:profile') . '</label>';
echo elgg_view('input/dropdown', array(
	'name' => 'profile',
	'options' => data_generator::getElggProviderMethods(),
	'value' => elgg_get_sticky_value('data_generator/run', 'profile'),
));
echo '</p>';

echo '<p>';
echo '<label>' . elgg_echo('admin:data_generator:locale') . '</label>';
echo elgg_view('input/dropdown', array(
	'name' => 'locale',
	'options' => data_generator::getLocales(),
	'value' => elgg_get_sticky_value('data_generator/run', 'locale', 'en_US'),
));
echo '</p>';

echo elgg_view('input/submit', array(
	'name' => 'submit',
	'value' => elgg_echo('admin:data_generator:submit'),
));
