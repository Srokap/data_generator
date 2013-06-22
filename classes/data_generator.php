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
	 * @return boolean tells if we're running script from CLI or not
	 */
	static function is_cli() {
		return PHP_SAPI == 'cli';
	}
	
	/**
	 * @var int in seconds
	 */
	static $cli_info_interval = 5;
	
	/**
	 * @param int $amount
	 * @param string $profile
	 * @param string $locale
	 * @throws InvalidArgumentException
	 * @return int
	 */
	static function generate($amount, $profile, $locale) {
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
		
		$totalAmount = $amount;
		
		$mt = microtime(true);
		$time = null;
		
		$generator = self::getGenerator($locale);
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
			if (self::is_cli()) {
				if ($time === null || time() > $time + self::$cli_info_interval) {
					$time = time();
					echo sprintf("%.2f%% - %d items generated in %.2fs\r", 
						($totalAmount - $amount) * 100 / $totalAmount, $success, microtime(true) - $mt);
				}
			}
		}
		if (self::is_cli()) {
			//clear line
			echo "\t\t\t\t\t\t\t\t\t\r";
		}
		return $success;
	}
	
	/**
	 * @param string $locale
	 * @return \Faker\Generator
	 */
	static function getGenerator($locale = 'en_US') {
		$generator = Faker\Factory::create($locale);
		$generator->addProvider(new ProviderUserEntity($generator));
		$generator->addProvider(new ProviderBlogEntity($generator));
		return $generator;
	}
	
	/**
	 * @return string[]
	 */
	static function getElggProviderMethods() {
		return array(
			'newUserEntity',
			'usersRelationshipFriend',
			'newBlogEntity',
			'blogAnnotationRevision',
			'blogAnnotationComment',
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