<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('num_c', TextareaType::class,[
                'attr' => [ 'placeholder'=>"num_c",
            'class' => 'form-control', ]])
            ->add('date_c')
            ->add('payement')
            ->add('payement',ChoiceType::class, [
        'choices' => [
            '' => [
                'Avec Livraison' => true,
                'Sans Livraison' => false
            ]]])
            ->add('payement', TextareaType::class,[
                'attr' => [ 'placeholder'=>"payement",
                    'class' => 'form-control', ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}

