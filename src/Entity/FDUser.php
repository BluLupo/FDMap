<?php

namespace App\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @UniqueEntity(fields= "nickname", message="Nickname già registrato")
 * @UniqueEntity(fields= "email", message="Email già registrata")
 * )
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
	 * @ORM\Column(unique=true, name="nickname", type="string")
	 */
	private $nickname;

    /**
     * @ORM\Column(unique=true, name="email", type="string")
     */
    private $email;

	/**
	 * @ORM\Column(name="password", type="string", length=64)
	 */
	private $password;

    private $password2;

	/**
	 * @ORM\OneToOne(targetEntity="Marker", mappedBy="user")
	 */
	private $marker;

	public function getSalt()
	{
		return null;
	}

	public function getUsername()
    {
        return $this->nickname;
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
            $this->nickname,
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
            $this->nickname,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword2()
    {
        return $this->password2;
    }

    public function setPassword2($password2)
    {
        $this->password2 = $password2;

        return $this;
    }

    /**
     * @Assert\IsTrue(message="Le password non corrispondono")
     */
    public function isPasswordEqual()
    {
        return $this->password === $this->password2;
    }

    public function setMarker($marker)
    {
        $this->marker = $marker;

        return $this;
    } 

    public function getMarker()
    {
        return $this->marker;
    }
}