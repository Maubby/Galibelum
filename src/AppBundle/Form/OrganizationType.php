<?php
/**
 * OrganizationType File Doc Comment
 *
 * PHP version 7.1
 *
 * @category OrganizationType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Organization type.
 *
 * @category OrganizationType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class OrganizationType extends AbstractType
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
                'label' => "Nom :",
                'attr' => array('class' => 'form-control')
            ))
            ->add('phoneNumber', TextType::class, array(
                'label' => "Numéro de télephone :",
                'attr' => array('class' => 'form-control')
            ))
            ->add('email', EmailType::class, array(
                'label' => "Adresse mail :",
                'attr' => array('class' => 'form-control')
            ))
            ->add('description', TextareaType::class, array(
                'label' => "Description :",
                'attr' => array(
                    'class' => 'form-control',
                    'cols' => '5', 'rows' => '5'
                )
            ))
            ->add('userRole', TextType::class, array(
                'label' => "userRole :",
                'attr' => array('class' => 'form-control')
            ))
            ->add('status', TextType::class, array(
                'label' => "Statut juridique :",
                'attr' => array('class' => 'form-control')
            ))
            ->add('address', TextType::class, array(
                'label' => "Adresse :",
                'attr' => array('class' => 'form-control')
            ))
            ->add('relationNumber', IntegerType::class, array(
                'label' => 'Nombre d\'emplyés :',
                'attr' => array('min' => 1, 'class' => 'form-control')
            ));
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
            'data_class' => 'AppBundle\Entity\Organization'
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
        return 'appbundle_organization';
    }


}
