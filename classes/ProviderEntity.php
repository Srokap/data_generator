<?php
class ProviderEntity extends \Faker\Provider\Base {
	
	/**
	 * @return ElggEntity
	 */
	protected function existingEntity($type, $subtype = ELGG_ENTITIES_ANY_VALUE) {
		$count = elgg_get_entities(array(
			'type' => $type,
			'subtype' => $subtype,
			'count' => true,
		));
		if ($count < 1) {
			return false;
		}
		$offset = $this->randomNumber() % $count;
		$options = array(
			'type' => $type,
			'subtype' => $subtype,
			'offset' => $offset,
			'limit' => 1,
		);
		$entity = elgg_get_entities($options);
		if ($entity) {
			return array_shift($entity);
		} else {
			if (data_generator::is_cli()) {
				echo "\nNo entities for ($type, $subtype) ($count, $offset)";
			}
			return false;
		}
	}
}