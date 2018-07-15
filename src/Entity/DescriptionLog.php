<?php 

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class DescriptionLog extends Log
{
	/**
	 * @ORM\Column(name="old_description", type="string", nullable=true)
	 */
	private $oldDescription;

	/**
	 * @ORM\Column(name="new_description", type="string", nullable=true)
	 */
	private $newDescription;

	public function getOldDescription()
	{
		return $this->oldDescription;
	}

	public function setOldDescription($oldDescription)
	{
		$this->oldDescription = $oldDescription;

		return $this;
	}

	public function getNewDescription()
	{
		return $this->newDescription;
	}

	public function setNewDescription($newDescription)
	{
		$this->newDescription = $newDescription;

		return $this;
	}
}