<?php 

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class PropicLog extends Log
{
	/**
	 * @ORM\Column(name="old_propic", type="string", nullable=true)
	 */
	private $oldPropic;

	/**
	 * @ORM\Column(name="new_propic", type="string", nullable=true)
	 */
	private $newPropic;

	public function getOldPropic()
	{
		return $this->oldPropic;
	}

	public function setOldPropic($oldPropic)
	{
		$this->oldPropic = $oldPropic;
		
		return $this;
	}

	public function getNewPropic()
	{
		return $this->newPropic;
	}

	public function setNewPropic($newPropic)
	{
		$this->newPropic = $newPropic;
		
		return $this;
	}
}