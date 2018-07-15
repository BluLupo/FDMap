<?php 

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class NicknameLog extends Log
{
	/**
	 * @ORM\Column(name="old_nickname", type="string", nullable=true)
	 */
	private $oldNickname;

	/**
	 * @ORM\Column(name="new_nickname", type="string", nullable=true)
	 */
	private $newNickname;

	public function getOldNickname()
	{
		return $this->oldNickname;
	}

	public function setOldNickname($oldNickname)
	{
		$this->oldNickname = $oldNickname;
		
		return $this;
	}

	public function getNewNickname()
	{
		return $this->newNickname;
	}

	public function setNewNickname($newNickname)
	{
		$this->newNickname = $newNickname;
		
		return $this;
	}
}