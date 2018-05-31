<?php
/**
 * OfferType File Doc Comment
 *
 * PHP version 7.1
 *
 * @category OfferType
 * @package  Type
 * @author   WildCodeSchool <www.wildcodeschool.fr>
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Offer type.
 *
 * @category Controller
 * @package  Controller
 * @author   WildCodeSchool <www.wildcodeschool.fr>
 */
class OfferType extends AbstractType
{
    /**
     * {@inheritdoc}
     *
     * @param FormBuilderInterface $builder The formBuilderInterface form
     * @param array                $options The attribute array
     *
     * @return null
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('date')
            ->add('amount')
            ->add('partnershipNumber')
            ->add('activity');
    }

    /**
     * {@inheritdoc}
     *
     * @param OptionsResolver $resolver The optionResolver class
     *
     * @return null
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
