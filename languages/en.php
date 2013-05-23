<?php
$english = array(
	'admin:data_generator' => 'Data Generator',
	'admin:data_generator:disclaimer' => '<strong>Don\'t use on production site!</strong> 
This tool is meant for debug only, and generates a lot of fake data that may be 
hard to distinguish from the real one. It\'s meant to be used for more meaningful 
benchmarking development environments only.',
	'admin:data_generator:title' => 'Generate fake content',
	'admin:data_generator:locale' => 'Localization: ',
	'admin:data_generator:profile' => 'Content to generate: ',
	'admin:data_generator:amount' => 'Units of content: ',
	'admin:data_generator:amount:placeholder' => 'Integer number',
	'admin:data_generator:submit' => 'Generate',
	'data_generator:action:run:success' => 'Successfully generated %d items in %.2fs',
);
add_translation('en', $english);