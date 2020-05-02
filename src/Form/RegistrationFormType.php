<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => 'Nom'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un nom'
                    ])
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Prénom'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un prénom'
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Courriel',
                'help' => 'Un mail de confirmation sera envoyé à ce courriel.',
                'attr' => [
                    'placeholder' => 'Courriel'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un courriel'
                    ]),
                    new Email([
                        'message' => 'Veuillez saisir un courriel valide'
                    ])
                ]
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Numéro de téléphone',
                'attr' => [
                    'placeholder' => 'xx.xx.xx.xx.xx'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un numéro de téléphone'
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Veuillez saisir un numéro de téléphone valide',
                        'max' => 10,
                        'maxMessage' => 'Veuillez saisir un numéro de téléphone valide'
                    ])
                ]
            ])
            ->add('idGenre', EntityType::class, [
                'class' => Genre::class,
                'label' => 'Genre',
                'placeholder' => '',
                'attr' => [
                    'class' => 'custom-select d-block'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner un genre'
                    ])
                ]
            ])
            ->add('dateNaissance', DateType::class, [
                'label' => 'Date de naissance',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'js-datepicker',
                    'placeholder' => 'jj/mm/aaaa'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une date de naissance'
                    ])
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'options' => [
                    'attr' => [
                        'placeholder' => '********'
                    ]
                ],
                'first_options' => [
                    'label' => 'Mot de passe'
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un mot de passe'
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096
                    ])
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'En créant un compte, vous acceptez les Conditions générales de vente de Game Market. 
                Veuillez consulter notre Notice Protection de vos Informations Personnelles, notre Notice Cookies 
                et notre Notice Annonces publicitaires basées sur vos centres d’intérêt',
                'mapped' => false,
                'attr' => [
                    'class' => 'custom-control-input'
                ],
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions générales.'
                    ])
                ],
                'label_attr' => [
                    'class' => 'custom-control-label'
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
            'data_class' => Utilisateur::class,
        ]);
    }
}
