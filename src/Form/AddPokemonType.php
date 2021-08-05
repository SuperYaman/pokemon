<?php

namespace App\Form;

use App\Entity\Pokemon;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddPokemonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if($options['ajout'] == true){
            $builder
                ->add('nom', TextType::class,[
                    'required' => false,
                ])

                ->add('number', TextType::class, [
                    'required' => false,
                ])

                ->add('taille', TextType::class, [
                    'required' => false,
                ])

                ->add('poids', TextType::class, [
                    'required' => false,
                ])

                ->add('sexe', ChoiceType::class,[
                    'choices' =>[
                        'F'=>'F',
                        'M'=>'M'

                    ]
                ])
                ->add('types', EntityType::class, [
                    'class' => Type::class,
                    'multiple' => true,
                    'expanded' => true,
                    'choice_label' => 'type'

                ])

                ->add('image', FileType::class, [
                    "required"=>false
                ])
                ->add('Envoyer', SubmitType::class)
            ;
        }else{
            $builder
                ->add('nom', TextType::class,[
                    'required' => false,
                ])

                ->add('number', TextType::class, [
                    'required' => false,
                ])

                ->add('taille', TextType::class, [
                    'required' => false,
                ])

                ->add('poids', TextType::class, [
                    'required' => false,
                ])

                ->add('sexe', ChoiceType::class,[
                    'choices' =>[
                        'F'=>'F',
                        'M'=>'M'

                    ]
                ])
                ->add('types', EntityType::class, [
                    'class' => Type::class,
                    'multiple' => true,
                    'expanded' => true,
                    'choice_label' => 'type'

                ])

                ->add('editImage', FileType::class, [
                    "required"=>false
                ])
                ->add('Envoyer', SubmitType::class)
            ;
        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pokemon::class,
            'ajout'=>false
        ]);
    }
}
