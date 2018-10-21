<?php 

namespace App\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\AbstractType;

class SocialsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fa', Type\TextType::class, array(
                "label" => "FurAffinity",
                "required" => false,
                "attr" => array(
                    "placeholder" => "www.furaffinity.net/user/",
                )
            ))
            ->add('facebook', Type\TextType::class, array(
                "label" => "Facebook",
                "required" => false,
                "attr" => array(
                    "placeholder" => "www.facebook.com/",
                )
            ))
            ->add('telegram', Type\TextType::class, array(
                "label" => "Telegram",
                "required" => false,
                "attr" => array(
                    "placeholder" => "t.me/",
                )
            ))
            ->add('submit', Type\SubmitType::class, array(
            	"label" => "Conferma"
            ))
        ;
    }
}