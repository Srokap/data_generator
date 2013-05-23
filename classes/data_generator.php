<?php
class data_generator {
	
	/**
	 * Fired on system init
	 */
	static function init() {
		
		elgg_register_event_handler('pagesetup', 'system', array(__CLASS__, 'pagesetup'));
		
		elgg_register_action('data_generator/run', 
			elgg_get_plugins_path() . __CLASS__ . '/actions/data_generator/run.php', 
			'admin');

	}
	
	/**
	 * Fired on system pagesetup
	 */
	static function pagesetup() {
	
		elgg_register_menu_item('page', array(
			'name' => 'data_generator',
			'href' => 'admin/data_generator',
			'text' => elgg_echo('admin:data_generator'),
			'context' => 'admin',
			'section' => 'develop',
		));
	}
	
	/**
	 * @param string $locale
	 * @return \Faker\Generator
	 */
	static function getGenerator($locale = 'en_US') {
		$generator = Faker\Factory::create($locale);
		$generator->addProvider(new ProviderUserEntity($generator));
		return $generator;
	}
	
	/**
	 * @return string[]
	 */
	static function getElggProviderMethods() {
		return array(
			'newUserEntity',
			'usersRelationshipFriend',
			
		);
	}
	
	/**
	 * @return string[]
	 */
	static function getLocales() {
		$dirPath = dirname(dirname(__FILE__)) . '/vendors/Faker/Provider/';
		$files = scandir($dirPath);
		foreach ($files as $key => $file) {
			if ($file[0] == '.' || !is_dir($dirPath . $file)) {
				unset($files[$key]);
			}
		}
		return $files;
	}
	
}