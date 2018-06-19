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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add(
                'name', TextType::class, array(
                'attr' => array(
                    'minlength' => 2, 'maxlength' => 32,
                    'data-label' => 'Nom de votre',
                    'class' => 'form-control input-field',
                'placeholder' =>'Exemple : GBM eSport'))
            )
            ->add(
                'phoneNumber', TextType::class, array(
                    'attr' => array(
                        'minlength'=> 8, 'maxlength' => 32,
                        'data-label' =>'',
                        'class' => 'form-control input-field' ))
            )
            ->add(
                'email', TextType::class, array(
                'attr' => array(
                    'minlength'=>2, 'maxlength' => 64,
                    'data-label'=>'',
                    'class'=> 'form-control input-field' ))
            )
            ->add(
                'description', TextareaType::class, array(
                'attr'=> array(
                    'rows' => '3',
                    'minlength'=>32, 'maxlength' => 250,
                    'data-label'=>'',
                    'class'=> 'form-control input-field'))
            )
            ->add(
                'userRole', TextType::class, array(
                'attr'=> array(
                    'minlength'=>2, 'maxlength' => 32,
                    'data-label'=>'',
                    'class'=>'form-control input-field' )
                )
            )
            ->add(
                'status', TextType::class, array(
                'attr'=>array(
                    'minlength'=>2,'maxlength' => 32,
                    'data-label'=>'',
                    'class'=>'form-control input-field'))
            )
            ->add(
                'address', TextType::class, array(
                'attr'=>array(
                    'minlength'=>2, 'maxlength' => 64,
                    'data-label'=>'',
                    'class'=>'form-control input-field'))
            )
            ->add(
                'relationNumber', ChoiceType::class, array(
                    'attr'=> array(
                        'class'=> 'form-control input-field'),
                    'choices'  => array(
                        'Aucun autre membre' => 'Aucun autre membre',
                        '2-10 membres' => '2-10 membres',
                        '11-50 membres' => '11-50 membres',
                        '51-250 membres' => '51-250 membres',
                        'Plus de 251 membres'=> 'Plus de 251 membres',
                        ))
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
