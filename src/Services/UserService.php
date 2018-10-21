<?php

namespace App\Services;

use Doctrine\ORM\EntityManager;
use App\Entity\Socials;
use App\Entity\FDUser;

class UserService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    } 

    public function checkSocials(FDUser $user)
    {
        if(is_null($user->getSocials())) {
            $socials = new Socials();
            $user->setSocials($socials);
            $socials->setUser($user);

            $this->em->persist($socials);
            $this->em->flush();
        }
    }
}
