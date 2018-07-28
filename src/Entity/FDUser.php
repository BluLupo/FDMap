<?php

namespace App\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @UniqueEntity(fields= "login", message="Nickname già registrato")
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
     * @ORM\Column(name="login", type="string", unique=true)
     */
    private $login;

    /**
     * @ORM\Column(name="email", type="string", nullable=true)
     */
    private $email;

	/**
	 * @ORM\Column(unique=true, name="nickname", type="string")
	 */
	private $nickname;

    /**
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "La descrizione non può superare i 255 caratteri",
     *      groups = {"profile"}
     * )
     */
    private $description;

    /**
     * @ORM\Column(name="propic", type="string", nullable=true)
     */
    private $propic;

	/**
	 * @ORM\Column(name="password", type="string", length=64)
	 */
	private $password;

    private $password2;

	/**
	 * @ORM\OneToOne(targetEntity="Marker", mappedBy="user")
	 */
	private $marker;

    /**
     * @ORM\Column(name="role", type="string")
     */
    private $role = "user";

    /**
     * @ORM\Column(name="banned", type="boolean", options={"default":false})
     */
    private $banned = false;

    /**
     * @ORM\Column(name="end_date", type="date", nullable=true)
     * @Assert\GreaterThan(
     *     value="today", 
     *     groups={"ban"},
     *     message="La data di fine ban non può essere nel passato"
     * )
     */
    private $endDate;

    /**
     * @ORM\Column(name="permanent_ban", type="boolean", options={"default":false})
     */
    private $permanentBan = false;

    /**
     * @ORM\Column(name="ban_reason", type="string", nullable=true)
     */
    private $banReason;

    /**
     * @ORM\OneToMany(targetEntity="Log", mappedBy="source")
     */
    private $sourceLogs;

    /**
     * @ORM\OneToMany(targetEntity="BanLog", mappedBy="target")
     */
    private $targetLogs;

    public function __construct()
    {
        $this->sourceLogs = new \ArrayCollection();
        $this->targetLogs = new \ArrayCollection();
    }

	public function getSalt()
	{
		return null;
	}

	public function getUsername()
    {
        return $this->nickname;
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

    public function getId()
    {
        return $this->id;
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

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;

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
     * @Assert\IsTrue(message="Le password non corrispondono", groups={"login"})
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

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    } 

    public function getDescription()
    {
        return $this->description;
    }

    public function setPropic($propic)
    {
        $this->propic = $propic;

        return $this;
    } 

    public function getPropic()
    {
        return $this->propic;
    }

    public function hasPropic() 
    {
        return $this->propic !== null;
    }

    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getRoles()
    {
        return array("ROLE_" . strtoupper($this->role));
    }
    
    public function getBanned()
    {
        return $this->banned;
    }

    public function setBanned($banned)
    {
        $this->banned = $banned;
        return $this;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getPermanentBan()
    {
        return $this->permanentBan;
    }

    public function setPermanentBan($permanentBan)
    {
        $this->permanentBan = $permanentBan;
        return $this;
    }

    public function getBanReason()
    {
        return $this->banReason;
    }

    public function setBanReason($banReason)
    {
        $this->banReason = $banReason;
        return $this;
    }

    public function addSourceLog($sourceLog)
    {
        $this->sourceLogs->add($sourceLog);
    }

    public function removeSourceLog($sourceLog)
    {
        $this->sourceLogs->remove($sourceLog);
    }

    public function getSourceLogs()
    {
        return $this->sourceLogs;
    }

    public function addTargetLog($targetLog)
    {
        $this->targetLogs->add($targetLog);
    }

    public function removeTargetLog($targetLog)
    {
        $this->targetLogs->remove($targetLog);
    }

    public function getTargetLogs()
    {
        return $this->targetLogs;
    }
}