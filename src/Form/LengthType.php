<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LengthType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ) {
        $builder
            ->add('length', TextType::class, [
                'label'    => 'Длина массива',
                'required' => true,
                'attr' => ['maxlength' => 4],
            ])
            ->add('send', SubmitType::class,[
                'label'    => 'Установить',
            ]);

    }
}
