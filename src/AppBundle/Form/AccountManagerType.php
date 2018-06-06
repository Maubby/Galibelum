<?php
/**
 * OrganizationType File Doc Comment
 *
 * PHP version 7.1
 *
 * @category AccountManagerType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

/**
 * AccountManager type.
 *
 * @category AccountManagerType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class AccountManagerType extends AbstractType
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
                'firstName', TextareaType::class, array(
                    'attr' => array(
                        'minlenght'=>2, 'maxlength' => 32,
                        'label' => 'Prénom',
                        'class' => 'form-control'))
            )
            ->add(
                'lastName', TextareaType::class, array(
                    'attr' => array(
                        'minlenght'=>2, 'maxlength' => 32,
                        'label' => 'Nom',
                        'class' => 'form-control'))
            )
            ->add(
                'phoneNumber', TextType::class, array(
                    'label' => "Numéro de télephone :",
                    'attr' => array('class' => 'form-control'))
            )
            ->add(
                'email', EmailType::class, array(
                    'label' => "Adresse mail :",
                    'attr' => array('class' => 'form-control')
                )
            )
            ->add(
                'password', PasswordType::class, array(
                'label' => "Mot de passe :",
                'attr' => array('class' => 'form-control')
                )
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
                'data_class' => 'AppBundle\Entity\AccountManager'
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
        return 'appbundle_accountmanager';
    }
}
