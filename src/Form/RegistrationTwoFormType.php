<?php

namespace App\Form;

use App\Entity\Propriete;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;
use Symfony\Component\Intl\Locales;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Country;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Type;

class RegistrationTwoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroRue', IntegerType::class, [
                'label' => 'Numéro de rue',
                'attr' => [
                    'min' => 1,
                    'pattern' => '0+\.[0-9]*[1-9][0-9]*$',
                    'onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57',
                    'placeholder' => 'Numéro de rue'
                ],
                'constraints' => [
                    new Type([
                        'type' => 'integer',
                        'message' => 'Veuillez saisir un numéro de rue valide'
                    ]),
                    new Positive([
                        'message' => 'Veuillez saisir un numéro de rue valide'
                    ])
                ]
            ])
            ->add('rue', TextType::class, [
                'label' => 'Rue',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Rue'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une rue'
                    ])
                ]
            ])
            ->add('codePostal', IntegerType::class, [
                'label' => 'Code postal',
                'mapped' => false,
                'attr' => [
                    'min' => 1,
                    'pattern' => '0+\.[0-9]*[1-9][0-9]*$',
                    'onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57',
                    'placeholder' => 'Code postal'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un code postal'
                    ]),
                    new Type([
                        'type' => 'integer',
                        'message' => 'Veuillez saisir un code postal valide'
                    ]),
                    new Positive([
                        'message' => 'Veuillez saisir un code postal valide'
                    ])
                ]
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Ville'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une ville'
                    ])
                ]
            ])
            ->add('region', TextType::class, [
                'label' => 'Région',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Région'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une région'
                    ])
                ]
            ])
            ->add('pays', CountryType::class, [
                'label' => 'Pays',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Pays'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un pays'
                    ]),
                    new Country([
                        'message' => 'Veuillez saisir un pays valide'
                    ])
                ]
            ])
            ->add('infoComp', TextareaType::class, [
                'label' => 'Information complémentaire (facultatif)',
                'attr' => [
                    'placeholder' => 'Information complémentaire',
                    'rows' => 3,
                    'style' => 'resize: none;'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description (facultatif)',
                'mapped' => false,
                'help' => 'Par exemple : Ma maison',
                'attr' => [
                    'placeholder' => 'Description',
                    'rows' => 3,
                    'style' => 'resize: none;'
                ]
            ])
            ->add('recaptcha', EWZRecaptchaType::class, [
                'mapped' => false,
                'language' => 'fr',
                'attr' => [
                    'options' => [
                        'theme' => 'light',
                        'type' => 'image',
                        'size' => 'invisible'
                    ]
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
                'attr' => [
                    'class' => 'btn btn-primary btn-block'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Propriete::class,
        ]);
    }
}
