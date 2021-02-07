<?php

namespace VirtualCard\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VirtualCard\Entity\Currency;
use VirtualCard\Entity\Vendor;

class ListVirtualCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'currency',
                EntityType::class,
                [
                    'choice_value' => 'code',
                    'choice_label' => 'code',
                    'class' => Currency::class,
                ]
            )
            ->add(
                'vendor',
                EntityType::class,
                [
                    'choice_value' => 'id',
                    'choice_label' => 'slug',
                    'class' => Vendor::class,
                ]
            )
            ->add(
                'activationDateFrom',
                DateTimeType::class,
                [
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                ]
            )
            ->add(
                'activationDateTo',
                DateTimeType::class,
                [
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'method' => Request::METHOD_GET,
                'csrf_protection' => false,
                'allow_extra_fields' => true,
            ]
        );
    }

    public function getBlockPrefix()
    {
        return null;
    }
}
