<?php 

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"description" = "DescriptionLog", "propic" = "PropicLog", "nickname" = "NicknameLog", "ban" = "BanLog"})
 */
abstract class Log
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id;
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="FDUser", inversedBy="sourceLogs")
     */
    private $source;

    public function getId() 
    {
        return $this->id;
    }

    public function getDate()
    {
        return $this->date;
    } 

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }  

    public function getSource()
    {
        return $this->source;
    }   

    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }
}