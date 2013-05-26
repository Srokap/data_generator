<?php
class ProviderBlogEntity extends ProviderEntity {
	
	/**
	 * @return ElggBlog unsaved ElggBlog entity 
	 */
	function newBlogEntity($full = true) {
		
		$entity = new ElggBlog();
		
		$entity->access_id = $this->generator->randomElement(array(ACCESS_PUBLIC, ACCESS_PRIVATE, ACCESS_LOGGED_IN, ACCESS_FRIENDS));
		
		$entity->time_created = $this->generator->unixTime;		//fails
		
		$user = $this->generator->existingUserEntity;
		
		$entity->owner_guid = $user->guid;
		$entity->container_guid = $user->guid;
		
		$entity->title = $this->generator->text($this->generator->randomNumber(20, 80));
		$entity->excerpt = $this->generator->text($this->generator->randomNumber(50, 250));
		$entity->description = $this->generator->text($this->generator->randomNumber(1000, 4000));
		
		$entity->comments_on = $this->generator->randomElement(array('On', 'Off'));
		
		$entity->tags = $this->generator->words($this->generator->randomNumber(0, 6)); 
		
		if($this->generator->boolean(35)) {
			$entity->status = 'draft';
			$entity->future_access = ACCESS_PUBLIC;
		}
		else {
			$entity->status = 'published';
		}
		
		//revision annotiations!
		//like annotiations!
		
		return $entity;
	}
	
	/**
	 * @return ElggAnnotation
	 */
	function blogAnnotationRevision() {
		$blog = $this->existingBlogEntity();
		$user = $this->generator->existingUserEntity();
		
		if ($blog && $user) {
			$annotation = new ElggAnnotation();
			$annotation->entity_guid = $blog->guid;
			$annotation->name = 'blog_revision';
			$annotation->value = $this->generator->text($this->generator->randomNumber(1000, 4000));
			$annotation->value_type = 'text';
			$annotation->owner_guid = $user->guid;
			return $annotation;
		}
	}
	
	/**
	 * @return UserEntity
	 */
	function existingBlogEntity() {
		return parent::existingEntity('object', 'blog');
	}
	
}