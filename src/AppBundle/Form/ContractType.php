<?php
/**
 * ActivityType File Doc Comment
 *
 * PHP version 7.2
 *
 * @category ContractType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */

namespace AppBundle\Form;

use AppBundle\Entity\Contracts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Activity type.
 *
 * @category ContractType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class ContractType extends AbstractType
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
                'uploadPdf', FileType::class,
                [
                'multiple' => true,
                'required' => false
                ]
            )
            ->add(
                'finalDeal', IntegerType::class,
                [
                'required' => false,
                'attr' =>
                    [
                        'minlength' => 2,
                        'maxlength' => 32,
                    ]
                ]
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
            ['error_bubbling' => true]
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return null
     */
    public function getBlockPrefix()
    {
        return 'appbundle_contract';
    }
}
