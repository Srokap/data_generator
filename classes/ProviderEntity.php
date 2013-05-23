<?php
class ProviderEntity extends \Faker\Provider\Base {
	
	/**
	 * @return ElggEntity
	 */
	protected function existingEntity($type, $subtype = ELGG_ENTITIES_ANY_VALUE) {
		while (true) {
			$count = elgg_get_entities(array(
				'type' => $type,
				'subtype' => $subtype,
				'count' => true,
			));
			if ($count < 1) {
				break;
			}
			$entity = elgg_get_entities(array(
				'type' => $type,
				'subtype' => $subtype,
				'offset' => $this->randomNumber(0, $count-1),
				'limit' => 1,
			));
			if ($entity) {
				return array_shift($entity);
			}
		}
	}
}