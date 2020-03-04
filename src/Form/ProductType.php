<?php

namespace App\Form;

use App\Entity\Currency;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductType extends AbstractType
{
    const DESCRIPTION_MINIMUM = 100;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 128])
                ]
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => static::DESCRIPTION_MINIMUM])
                ],
                'attr'        => [
                    'data-min-length' => static::DESCRIPTION_MINIMUM,
                    'class'           => 'lengthCounter'
                ],
            ])
            ->add('price', NumberType::class, [
                'constraints' => [
                    new NotBlank(),
                    new GreaterThan(['value' => 0])
                ]
            ])
            ->add('currency', EntityType::class, [
                'constraints'  => [
                    new NotBlank(),
                ],
                'class'        => Currency::class,
                'choice_label' => 'fullName'
            ])
            ->add('add', SubmitType::class);

        $builder->get('price')
            ->addModelTransformer(new CallbackTransformer(
                function ($priceInCents) {
                    return $priceInCents / 100;
                },
                function ($priceFull) {
                    return $priceFull * 100;
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
