<?php

namespace App\Form;

use App\Entity\Ressource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RessourceForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intitule', TextType::class, [
                'label' => 'Intitulé',
                'attr' => ['class' => 'form-control']
            ])
            ->add('presentation', TextareaType::class, [
                'label' => 'Présentation',
                'attr' => ['class' => 'form-control', 'rows' => 4]
            ])
            ->add('support', TextType::class, [
                'label' => 'Support (PDF, vidéo, HTML...)',
                'attr' => ['class' => 'form-control']
            ])
            ->add('nature', TextType::class, [
                'label' => 'Nature (guide, QCM, formulaire...)',
                'attr' => ['class' => 'form-control']
            ])
            ->add('url', TextType::class, [
                'label' => 'Lien vers le document',
                'attr' => ['class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ressource::class,
        ]);
    }
}
