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
            ->add('name', TextType::class, array(
                'attr' => array(
                    'minlength' => 2,
                    'maxlength' => 32,
                    'placeholder' =>'Exemple : Lyon eSport'
                )
            ))
            ->add('type', ChoiceType::class, array(
                'choices' => array(
                    'Activité de streaming' => 'Activité de streaming',
                    'Equipe eSport' => 'Equipe eSport',
                    'Évènement eSport' => 'Évènement eSport',
                )
            ))
            ->add('description', TextareaType::class, array(
                'attr' => array(
                    'minlenght' => 32,
                    'maxlenght' => 250,
                    'placeholder' => 'Maximum 250 caractères'
                )
            ))
            ->add('date', TextType::class, array(
                'attr' => array(
                    'maxlenght' => 16,
                )
            ))
            ->add('address', TextType::class, array(
                'attr' => array(
                    'maxlenght' => 64,
                )
            ))
            ->add('mainGame', TextareaType::class)
            ->add('urlVideo', UrlType::class)
            ->add('achievement', TextareaType::class, array(
                'attr' => array(
                    'maxlenght' => 128,
                    'placeholder' => 'Exemple : 1ère place aux IEM Katowice de CS:GO 2018',
                )
            ))
            ->add('socialLink', UrlType::class, array(
                'attr' => array(
                    'placeholder' => 'Exemple : https://www.twitch.tv/gallibellum'
                )
            ))
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
