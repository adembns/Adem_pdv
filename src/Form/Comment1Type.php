<?php

namespace App\Form;

use App\Entity\Comment1;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class Comment1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenu', TextType::class, [
                'attr' => ['placeholder' => 'Ecrire un commentaire..'],
                'constraints' => [
                    new NotBlank(['message' => 'empty field .']),
                    new Regex([
                        'pattern' => '/\d/', // Disallow numbers
                        'match' => false,
                        'message' => 'Numbers are not allowed in this field.',
                    ]),
                ],
            ])
            ->add('avatar', FileType::class,[
                'label'=> 'Avatar(image file)',
                'mapped'=> false,
                'required'=> false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment1::class,
        ]);
    }
}
