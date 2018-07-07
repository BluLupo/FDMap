<?php 

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder
    		->add('nickname', Type\TextType::class, array(
				'required' => false, 
				'attr' => array(
                    'placeholder' => "Nickname"                
                )
			))
			->add('description', Type\TextType::class, array(
				'required' => false,
				'attr' => array(
					'placeholder' => "Descrizione (max. 255 caratteri)"
				)
			))
			->add('submit', Type\SubmitType::class);
	}
}