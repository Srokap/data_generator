<?php
class ProviderUserEntity extends ProviderEntity {
	
	/**
	 * @return ElggUser unsaved ElggUser entity 
	 */
	function newUserEntity($full = true) {
		
		$user = new ElggUser();
		
		$user->access_id = ACCESS_PUBLIC;
		
		$user->time_created = $this->generator->unixTime;		//fails
		
		$user->name = $this->generator->name;
		$user->username = $this->generator->userName;			//unsafe includes ', cyrylic chars
		$user->email = $this->generator->safeEmail;
		$user->password = $this->generator->md5;
		$user->language = $this->generator->languageCode;
		
		$user->last_action = $this->generator->unixTime;		//fails
		$user->prev_last_action = $this->generator->unixTime;	//fails
		$user->last_login = $this->generator->unixTime;			//fails
		$user->prev_last_login = $this->generator->unixTime;	//fails
		
		if($full || $this->generator->boolean(50)) {
			$user->description = $this->generator->text(600);
		}
		if($full || $this->generator->boolean(70)) {
			$user->briefdescription = $this->generator->text(80);
		}
		if($full || $this->generator->boolean(60)) {
			if ($this->generator->boolean(30)) {
				$user->location = $this->generator->address;
			} else {
				$user->location = $this->generator->parse('{{city}}, {{country}}');
			}
		}
		if($full || $this->generator->boolean(60)) {
			$user->contactemail = $this->generator->safeEmail;
		}
		
		if($full || $this->generator->boolean(50)) {
			$user->phone = $this->generator->phoneNumber;
		}
		if($full || $this->generator->boolean(50)) {
			$user->mobile = $this->generator->phoneNumber;
		}
		
		if($full || $this->generator->boolean(50)) {
			$user->website = $this->generator->url;
		}
		if($full || $this->generator->boolean(40)) {
			$user->twitter = $this->generator->userName;
		}
		
		if($full || $this->generator->boolean(70)) {
			$user->interests = $this->generator->text(100);
		}
		if($full || $this->generator->boolean(60)) {
			$user->skills = $this->generator->catchPhrase;
		}
		
		return $user;
	}
	
	/**
	 * @return UserEntity
	 */
	function existingUserEntity() {
		return parent::existingEntity('user');
	}
	
	/**
	 * @return ElggRelationship
	 */
	function usersRelationshipFriend() {
		$userOne = $this->existingUserEntity();
		$cnt = 10;
		while ($cnt-- > 0) {
			$userTwo = $this->existingUserEntity();
			if ($userOne->guid != $userTwo->guid) {
				$rel = new ElggRelationship();
				$rel->relationship = 'friend';
				$rel->guid_one = $userOne->guid;
				$rel->guid_two = $userTwo->guid;
				return $rel;
			}
		}
	}
	
}