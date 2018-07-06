<?php
/**
 * FakerFixtures File Doc Comment
 *
 * PHP version 7.1
 *
 * @category FakerFixtures
 * @package  DataFixtures
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Activity;
use AppBundle\Entity\Offer;
use AppBundle\Entity\Organization;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Faker Fixtures.
 *
 * @Route("faker")
 *
 * @category FakerFixtures
 * @package  DataFixtures
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */

class FakerFixtures extends AbstractFixture implements ContainerAwareInterface,
    FixtureInterface, OrderedFixtureInterface
{
    private $_container;

    /**
     * Setting container.
     *
     * @param ContainerInterface $_container |null
     *
     * @Route("/",    name="faker")
     * @Method("GET")
     *
     * @return void A Response instance
     */
    public function setContainer(ContainerInterface $_container = null)
    {
        $this->_container = $_container;
    }

    /**
     * Function Load
     *
     * @param ObjectManager $em Object Manager
     *
     * @Route("/",    name="faker_load")
     * @Method("GET")
     *
     * @return void A Response instance
     */
    public function load(ObjectManager $em)
    {
        /**
         * Initializing Faker object
         */

        $faker = Faker\Factory::create('fr_FR');

        /**
         * Creating the User, Organization, Activity and Offer
         */

        for ($p = 0; $p < 10; $p++) {
            $structure = new User();
            $structure
                ->setEmail($faker->email)
                ->setPlainPassword('galibelum1')
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setPhoneNumber($faker->phoneNumber)
                ->setCgu(true)
                ->setEnabled(1)
                ->setRoles(array('ROLE_STRUCTURE'));

            // Organization creation
            $organization = new Organization();
            $organization
                ->setName($faker->name)
                ->setStatus($faker->company)
                ->setAddress($faker->streetAddress)
                ->setPhoneNumber($faker->phoneNumber)
                ->setEmail($faker->email)
                ->setRelationNumber($faker->randomDigitNotNull)
                ->setUserRole($faker->jobTitle)
                ->setDescription($faker->text);

            // Activity creation
            $activity = new Activity();
            $activity
                ->setName($faker->name)
                ->setType($faker->jobTitle)
                ->setDescription($faker->text)
                ->setDateStart($faker->dateTimeAD($max = 'now', $timezone = null))
                ->setDateEnd($faker->dateTimeAD($max = 'now', $timezone = null))
                ->setAddress($faker->streetAddress)
                ->setMainGame($faker->word)
                ->setUrlVideo($faker->url)
                ->setAchievement($faker->word)
                ->setSocialLink(array($faker->url, $faker->url, $faker->url));

            // Offer creation
            $offer = new Offer();
            $offer
                ->setName($faker->firstName)
                ->setDescription($faker->text)
                ->setDate($faker->dateTimeAD($max = 'now', $timezone = null))
                ->setAmount($faker->randomNumber($nbDigits = null, $strict = false))
                ->setPartnershipNumber($faker->randomDigitNotNull);

            $em->persist($structure);
            $organization->setUser($structure);
            $em->persist($organization);

            $structure->setUsername($structure->getEmail())
                ->setOrganization($organization);
            $em->persist($structure);


            $activity->setOrganizationActivities($organization);
            $em->persist($activity);

            $offer->setActivity($activity);
            $em->persist($offer);
        }
        
        for ($p = 0; $p < 5; $p++) {
            $company = new User();
            $company
                ->setEmail($faker->email)
                ->setPlainPassword('galibelum1')
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setPhoneNumber($faker->phoneNumber)
                ->setCgu(true)
                ->setEnabled(1)
                ->setRoles(array('ROLE_COMPANY'));

            // Organization creation
            $organization = new Organization();
            $organization
                ->setName($faker->name)
                ->setStatus($faker->company)
                ->setAddress($faker->streetAddress)
                ->setPhoneNumber($faker->phoneNumber)
                ->setEmail($faker->email)
                ->setRelationNumber($faker->randomDigitNotNull)
                ->setUserRole($faker->jobTitle)
                ->setDescription($faker->text);

            $em->persist($company);
            $organization->setUser($company);
            $em->persist($organization);

            $company->setUsername($company->getEmail())
                ->setOrganization($organization);

            $em->persist($company);

            $em->flush();
        }

        $admin = new User();
        $admin
            ->setEmail('admin@galibelum.fr')
            ->setPlainPassword('galibelum1')
            ->setFirstName('admin')
            ->setLastName('admin')
            ->setPhoneNumber($faker->phoneNumber)
            ->setCgu(true)
            ->setEnabled(1)
            ->setRoles(array('ROLE_SUPER_ADMIN'));

        $em->persist($admin);

        $admin->setUsername($admin->getEmail());
        $em->persist($admin);

        $em->flush();
    }

    /**
     * Function getOrder
     *
     * @return        int A Response instance
     * @Route("/",    name="faker_getOrder")
     * @Method("GET")
     */
    public function getOrder()
    {
        return 1;
    }
}