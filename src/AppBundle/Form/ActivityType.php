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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            ->add('name', TextareaType::class)
            ->add('type', TextareaType::class)
            ->add('description', TextareaType::class)
            ->add('date', TextareaType::class)
            ->add('address', TextareaType::class)
            ->add('mainGame', TextareaType::class)
            ->add('urlVideo', TextareaType::class)
            ->add('achievement', TextareaType::class)
            ->add('socialLink', TextareaType::class);
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
