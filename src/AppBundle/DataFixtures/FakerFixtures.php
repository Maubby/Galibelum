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
     * @throws \Exception
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

        $relationNumber = [
            'Aucun autre membre',
            '2-10 membres',
            '11-50 membres',
            '51-250 membres',
            'Plus de 251 membres'
        ];
        $activities = [
            'Activité de streaming',
            'Equipe eSport',
            'Évènement eSport'
        ];
        $interval = [
            'P10Y',
            'P3M',
            'P20D',
            'P1Y'
        ];
        $video = [
            'https://www.youtube.com/watch?v=s5K1GSRY1GY',
            'https://www.youtube.com/watch?v=vDxG72QNRGA',
            'https://www.youtube.com/watch?v=tbfWnFxnvxc',
            'https://www.youtube.com/watch?v=cD3tWJyNiMw',
            'https://www.youtube.com/watch?v=k8JzDSanprY'
        ];
        $date = new \DateTime();

        for ($p = 0; $p < 10; $p++) {
            $user = new User();
            $user
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
                ->setRelationNumber($relationNumber[array_rand($relationNumber, 1)])
                ->setUserRole('manager')
                ->setDescription($faker->text);

            // Activity creation
            $activityType = array_rand($activities, 1);
            $intervalDate = new \DateInterval($interval[array_rand($interval)]);

            $activity = new Activity();
            $activity
                ->setName($faker->name)
                ->setType($activities[$activityType])
                ->setDescription($faker->text)
                ->setUrlVideo($video[array_rand($video, 1)])
                ->setSocialLink(array($faker->url, $faker->url, $faker->url))
                ->setAchievement('1ère place PUBG berlin, 2ème tournois LOL Corée')
                ->setDateStart($date)
                ->setDateEnd($date->add($intervalDate))
                ->setAddress($faker->streetAddress);

            // Offer creation
            $offer = new Offer();
            $offer
                ->setName($faker->firstName)
                ->setDescription($faker->text)
                ->setDate($date->add($intervalDate))
                ->setAmount($faker->randomNumber($nbDigits = null, $strict = false))
                ->setPartnershipNb(random_int(1, 10));

            $em->persist($user);
            $organization
                ->setNameCanonical($organization->getName())
                ->setUser($user);
            $em->persist($organization);

            $user->setUsername($user->getEmail())
                ->setOrganization($organization);
            $em->persist($user);

            $activity
                ->setNameCanonical($activity->getName())
                ->setOrganizationActivities($organization);
            $em->persist($activity);

            $offer
                ->setNameCanonical($offer->getName())
                ->setHandlingFee($offer->getAmount())
                ->setActivity($activity);
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
                ->setRelationNumber($relationNumber[array_rand($relationNumber, 1)])
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

        for ($p = 0; $p < 5; $p++) {
            $manager = new User();
            $manager
                ->setEmail($faker->email)
                ->setPlainPassword('galibelum1')
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setPhoneNumber($faker->phoneNumber)
                ->setCgu(true)
                ->setEnabled(1)
                ->setRoles(array('ROLE_MANAGER'));

            $em->persist($manager);
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