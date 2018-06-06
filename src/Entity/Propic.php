<?php 

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class Propic
{
    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Carica un'immagine profilo")
     * @Assert\File(
     *     maxSize = "1024k",
     *     mimeTypes = {"image/jpeg", "image/png"},
     *	   maxSizeMessage = "Immagine troppo grande(dimensione massima: 1MB)",
     *     mimeTypesMessage = "Formato file non valido"
     * )
     */
    private $propic;

    public function getPropic()
    {
        return $this->propic;
    }

    public function setPropic($propic)
    {
        $this->propic = $propic;

        return $this;
    }
}