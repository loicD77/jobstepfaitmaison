<?php

namespace App\Form;

use App\Entity\Etape;
use App\Entity\Parcours;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtapeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('descriptif', TextareaType::class, [
                'label' => 'Descriptif',
                'attr' => ['class' => 'form-control']
            ])
            ->add('consignes', TextareaType::class, [
                'label' => 'Consignes',
                'attr' => ['class' => 'form-control']
            ])
            ->add('position', IntegerType::class, [
                'label' => 'Position',
                'attr' => ['class' => 'form-control']
            ])
            ->add('parcours', EntityType::class, [
                'class' => Parcours::class,
                'choice_label' => 'objet',
                'label' => 'Parcours associé',
                'attr' => ['class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etape::class,
        ]);
    }
}
