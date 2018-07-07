<?php 

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class PunishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('endDate', Type\DateType::class, array(
            	"label" => "Fine ban",
                "widget" => "single_text"
            ))
            ->add('permanentBan', Type\CheckboxType::class, array(
            	"label" => "Ban permanente?",
                "required" => false
            ))
            ->add('banReason', Type\TextareaType::class, array(
                "label" => "Note"
            ))
            ->add('submit', Type\SubmitType::class, array(
            	"label" => "Conferma"
            ))
        ;
    }
}