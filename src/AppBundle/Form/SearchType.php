<?php
/**
 * ActivityType File Doc Comment
 *
 * PHP version 7.1
 *
 * @category ActivityType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Activity type.
 *
 * @category SearchType
 * @package  Type
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class SearchType extends AbstractType
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
                'search', SearchType::class, array()
            )

            ->add(
                'type', ChoiceType::class, array(
                    'choices' => array(
                        "Choisissez un type d'activité" => '',
                        'Activité de streaming' => 'Activité de streaming',
                        'Equipe eSport' => 'Equipe eSport',
                        'Évènement eSport' => 'Évènement eSport'
                    )
                )
            );
    }
}
