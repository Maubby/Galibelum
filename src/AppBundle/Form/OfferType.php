<?php
/**
 * OfferType File Doc Comment
 *
 * PHP version 7.2
 *
 * @category OfferType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

/**
 * Offer type.
 *
 * @category OfferType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class OfferType extends AbstractType
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
                        'minlength' => 2, 'maxlength' => 32))
            )
            ->add(
                'amount', IntegerType::class, array(
                    'attr' => array(
                        'min' => 200))
            )
            ->add(
                'partnershipNumber', IntegerType::class, array(
                    'attr' => array(
                        'min' => 1))
            )
            ->add(
                'date', DateType::class, array(
                    'widget' => 'single_text')
            )
            ->add(
                'description', TextareaType::class, array(
                    'attr' => array(
                        'minlength' => 16,
                        'maxlength' => 250))
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
            array(
                'data_class' => 'AppBundle\Entity\Offer'
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
        return 'appbundle_offer';
    }
}
