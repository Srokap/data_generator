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
		$entity = elgg_get_entities(array(
			'type' => $type,
			'subtype' => $subtype,
			'offset' => $offset,
			'limit' => 1,
		));
		if ($entity) {
			return array_shift($entity);
		} else {
			return false;
		}
	}
}