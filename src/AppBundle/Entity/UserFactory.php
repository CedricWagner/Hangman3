<?php

namespace AppBundle\Entity;

/**
* 
*/
class UserFactory 
{
	public function createForRegistration()
	{
		$user = new User();

		$user->setIsAdmin(false);
		$user->setRegisteredAt(new \DateTime());

		return $user;
	}
}