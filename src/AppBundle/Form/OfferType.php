<?php
/**
 * OfferType File Doc Comment
 *
 * PHP version 7.1
 *
 * @category OfferType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
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
                'name', TextareaType::class, array(
                    'attr' => array(
                        'minlength' => 2, 'maxlength' => 32,
                        'label' => 'name',
                        'class' => 'form-control'))
            )
            ->add(
                'description', TextareaType::class, array(
                    'attr' => array('maxlength' => 250,
                        'label' => 'description',
                        'class' => 'form-control'))
            )
            ->add('date', DateType::class, array('data' => new \DateTime('now')))
            ->add(
                'amount', IntegerType::class,
                array('attr' => array('min' => 1,
                    'label' => 'amount',
                    'class' => 'form-control'))
            )
            ->add(
                'partnershipNumber', IntegerType::class,
                array('attr' => array(
                    'min' => 0,
                    'label' => 'partnershipNumber',
                    'class' => 'form-control'))
            )
            ->add(
                'activity', TextareaType::class, array(
                    'label' => "activity :",
                    'attr' => array('class' => 'form-control'))
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
