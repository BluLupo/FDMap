<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity;
 */
class FDUser implements UserInterface, \Serializable
{
	/**
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(name="nickname", type="string")
	 */
	private $nickname;

	/**
	 * @ORM\Column(name="password", type="string")
	 */
	private $password;

	/**
	 * @ORM\Column(name="latitude", type="string")
	 */
	private $latitude;

	/**
	 * @ORM\Column(name="longitude", type="string")
	 */
	private $longitude;

	public function getSalt()
	{
		return null;
	}

	public function getUsername()
    {
        return $this->password;
    }

	public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized, ['allowed_classes' => false]);
    }
}