<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Livraison;
use App\Entity\Personnel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_h_l')
            ->add('adresse', TextareaType::class,[
                'attr' => [ 'placeholder'=>"adresse",
                    'class' => 'form-control', ]])
            ->add('num_tel', TextareaType::class,[
                'attr' => [ 'placeholder'=>"num_tel",
                    'class' => 'form-control', ]])
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'Etat' => [
                        'En cours' => false,
                        'Livré' => true,
                    ]]])
            ->add('personnel',EntityType::class,[
                'class'=>Personnel::class,
                'choice_label'=>'id',
                'expanded'=>false,
                'multiple'=>false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livraison::class,
        ]);
    }
}
