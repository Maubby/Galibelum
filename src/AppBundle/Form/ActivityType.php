<?php
/**
 * ActivityType File Doc Comment
 *
 * PHP version 7.1
 *
 * @category ActivityType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                'name', TextType::class, array(
                    'attr' => array(
                        'minlength' => 2,
                        'maxlength' => 32,
                    )
                )
            )
            ->add(
                'type', ChoiceType::class, array(
                    'choices' => array(
                        "Choisissez un type d'activité" => '',
                        'Activité de streaming' => 'Activité de streaming',
                        'Equipe eSport' => 'Equipe eSport',
                        'Évènement eSport' => 'Évènement eSport'
                    )
                )
            )
            ->add(
                'description', TextareaType::class, array(
                    'attr' => array(
                        'minlength' => 32,
                        'maxlength' => 250,
                    )
                )
            )
            ->add(
                'date', TextType::class, array(
                    'required' => false,
                    'attr' => array(
                        'maxlength' => 16,
                    )
                )
            )
            ->add(
                'address', TextType::class, array(
                    'required' => false,
                    'attr' => array(
                        'maxlength' => 64,
                    )
                )
            )
            ->add(
                'mainGame', TextareaType::class, array(
                    'required' => false,
                )
            )
            ->add(
                'urlVideo', UrlType::class, array(
                    'required' => false,
                    'attr' => array(
                        'maxlength' => 128,
                    )
                )
            )
            ->add(
                'achievement', TextareaType::class, array(
                    'required' => false,
                    'attr' => array(
                        'maxlength' => 128,
                    )
                )
            )
            ->add('socialLink', UrlType::class)

            ->remove('mainGame');
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
            array(
                'data_class' => 'AppBundle\Entity\Activity'
            )
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
