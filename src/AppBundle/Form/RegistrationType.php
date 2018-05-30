<?php
/**
 * RegistrationType File Doc Comment
 *
 * PHP version 7.1
 *
 * @category RegistrationType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Registration type.
 *
 * @category RegistrationType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class RegistrationType extends AbstractType
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
            ->add('firstName')
            ->add('lastName')
            ->add('phoneNumber');
    }

    /**
     * GetParent registrationFormType.
     *
     * @return null|string
     */
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    /**
     * GetBlockPrefix app_user_registration.
     *
     * @return null|string
     */
    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    /**
     * GetName registration type.
     *
     * @return null|string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}