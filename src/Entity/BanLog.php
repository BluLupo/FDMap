<?php 

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class BanLog extends Log
{
	/**
	 * @ORM\ManyToOne(targetEntity="FDUser", inversedBy="targetLogs")
	 */
	private $target;

	/**
	 * @ORM\Column(name="permanent_ban", type="boolean", nullable=true)
	 */
	private $permanentBan;

	/**
	 * @ORM\Column(name="new_nickname", type="string", nullable=true)
	 */
	private $endBan;

	/**
	 * @ORM\Column(name="ban_notes", type="string", nullable=true)
	 */
	private $banNotes;

	public function setTarget($target)
	{
		$this->$target = $target;

		return $this;
	}

	public function getTarget()
	{
		return $this->$target;
	}

	public function setEndBan($endBan)
	{
		$this->endBan = $endBan;

		return $this;
	}

	public function getEndBan()
	{
		return $this->endBan;
	}

	public function setBanNotes($banNotes)
	{
		$this->banNotes = $banNotes;

		return $this;
	}

	public function getBanNotes()
	{
		return $this->banNotes;
	}
}