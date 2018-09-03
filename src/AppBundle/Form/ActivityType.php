<?php
/**
 * ActivityType File Doc Comment
 *
 * PHP version 7.2
 *
 * @category ActivityType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\Form;

use AppBundle\Entity\Activity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Activity type.
 *
 * @category ActivityType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class ActivityType extends AbstractType
{
    /**
     * {@inheritdoc}
     *
     * @param FormBuilderInterface $builder The formBuilderInterface form
     * @param array                $options The attribute array
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name', TextType::class,
                [
                    'required' => true,
                    'attr' =>
                        [
                            'minlength' => 2,
                            'maxlength' => 32,
                        ]
                ]
            )
            ->add(
                'type', ChoiceType::class,
                [
                    'choices' =>
                        [
                            "Choisissez un type d'activité" => '',
                            'Activité de streaming' => 'Activité de streaming',
                            'Equipe eSport' => 'Equipe eSport',
                            'Évènement eSport' => 'Évènement eSport',
                            'Editeur de jeux' => 'Editeur de jeux',
                            'Formations gaming' => 'Formations gaming'
                        ]
                ]
            )
            ->add(
                'description', TextareaType::class,
                [
                    'required' => true,
                    'attr' =>
                        [
                            'minlength' => 32,
                            'maxlength' => 768,
                        ]
                ]
            )
            ->add(
                'dateStart', DateType::class,
                [
                    'required' => true,
                    'widget' => 'single_text',
                    'html5' => false,
                ]
            )
            ->add(
                'dateEnd', DateType::class,
                [
                    'required' => true,
                    'widget' => 'single_text',
                    'html5' => false,
                ]
            )
            ->add(
                'address', TextType::class,
                [
                    'required' => true,
                    'attr' =>
                        [
                            'minlength' => 2,
                            'maxlength' => 128,
                        ]
                ]
            )
            ->add(
                'urlVideo', UrlType::class,
                [
                    'required' => false,
                    'attr' =>
                        [
                            'maxlength' => 128,
                        ]
                ]
            )
            ->add(
                'achievement', TextareaType::class,
                [
                    'required' => false,
                    'attr' =>
                        [
                            'minlength' => 2,
                            'maxlength' => 128,
                        ]
                ]
            )
            -> add(
                'socialLink', CollectionType::class,
                [
                    'required' => false,
                    'entry_type' => UrlType::class,
                    'allow_add' => true,
                    'prototype' => true,
                    'label' => false,
                ]
            )
            ->add(
                'uploadPdf', FileType::class,
                [
                    'required' => false,
                    'data_class' => null,
                ]
            );
    }

    /**
     * {@inheritdoc}
     *
     * @param OptionsResolver $resolver The optionResolver class
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => Activity::class,]
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return null
     */
    public function getBlockPrefix()
    {
        return 'appbundle_activity';
    }
}
