<?php 

namespace App\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\AbstractType;

class LogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', Type\ChoiceType::class, array(
            	"label" => "Categoria",
                "placeholder" => "Seleziona una categoria...",
            	"choices" => array(
            		"Descrizione" => "description",
            		"Nickname" => "nickname",
            		"Immagine profilo" => "propic",
            		"Ban" => "ban"
            	)
            ))
            ->add('submit', Type\SubmitType::class, array(
            	"label" => "Conferma"
            ))
        ;
    }
}