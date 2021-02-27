<?php

namespace VirtualCard\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VirtualCard\Entity\Currency;

class VirtualCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('processId', TextType::class)
            ->add(
                'activationDate',
                DateTimeType::class,
                [
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                ]
            )
            ->add(
                'expireDate',
                DateTimeType::class,
                [
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                ]
            )
            ->add('balance', IntegerType::class)
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
                'notes',
                TextType::class,
                [
                    'required' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'method' => Request::METHOD_POST,
                'csrf_protection' => false,
            ]
        );
    }

    public function getBlockPrefix()
    {
        return null;
    }
}
