<?php
/**
 * RegistrationType File Doc Comment
 *
 * PHP version 7.2
 *
 * @category RegistrationType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

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
            ->add(
                'firstName', TextType::class,
                [
                    'label' => 'Prénom',
                    'attr' =>
                        [
                            'minLength' => '2',
                            'maxLength' => '32',
                        ]
                ]
            )
            ->add(
                'lastName', TextType::class,
                [
                    'label' => 'Nom',
                    'attr' =>
                        [
                            'minLength' => '2',
                            'maxLength' => '32',
                        ]
                ]
            )
            ->add(
                'phoneNumber', TextType::class,
                ['label' => 'Numéro de téléphone']
            )
            ->add(
                'cgu', CheckboxType::class,
                ['required' => true]
            )
            ->remove('username');
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