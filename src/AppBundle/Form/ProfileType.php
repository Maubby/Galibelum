<?php
/**
 * ProfileType File Doc Comment
 *
 * PHP version 7.1
 *
 * @category ProfileType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
/**
 * Profile type.
 *
 * @category ProfileType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class ProfileType extends AbstractType
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
                'firstName', TextType::class, array(
                    'label' => 'Prénom * :',
                    'attr' => array('class' => 'form-control'))
            )
            ->add(
                'lastName', TextType::class, array(
                    'label' => "Nom * :",
                    'attr' => array('class' => 'form-control'))
            )
            ->add(
                'phoneNumber', TelType::class, array(
                    'label' => "Numéro de téléphone * :",
                    'attr' => array('class' => 'form-control')
                )
            )
            ->add(
                'email', EmailType::class, array(
                'label' => 'form.email', 'translation_domain' => 'FOSUserBundle')
            )

            ->remove('username') //we use email as login
            ->remove('current_password');
    }

    /**
     * GetParent profileFormType.
     *
     * @return null|string
     */
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    /**
     * GetBlockPrefix app_user_profile.
     *
     * @return null|string
     */
    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }

    /**
     * GetName profile type.
     *
     * @return null|string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
