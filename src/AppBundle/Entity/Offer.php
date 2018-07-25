<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Offer
 *
 * @ORM\Table(name="offer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OfferRepository")
 */
class Offer
{
    /*
     * Relationship Mapping Metadata
     */

    /**
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Contracts", mappedBy="offer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contracts;

    /**
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Activity", inversedBy="activities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activity;

    /*
     * Personal variables
     */

    /**
     *
     * @var array
     *
     * @ORM\Column(name="partnershipNumber", type="array")
     *
     * @Assert\NotBlank()
     */
    private $partnershipNumber;


    /**
     *
     * @var /date
     *
     * @ORM\Column(name="creationDate", type="date", nullable=false)
     */
    private $creationDate;

    /*
     * Autogenerated variables
     */

    /**
     *
     * @var int
     *
     * @ORM\Column(name="id",               type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32)
     *
     * @Assert\NotBlank(
     *      message = "Veuillez saisir un nom"
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 32,
     *      minMessage = "Votre nom doit contenir au minimum {{ limit }} caractères",
     *      maxMessage = "Votre nom doit contenir au maximum {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="nameCanonical", type="string", length=32, nullable=true)
     */
    private $nameCanonical;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     *
     * @Assert\NotBlank(
     *     message= "Veuillez détailler votre offre"
     * )
     * @Assert\Length(
     *      min = 16,
     *      max = 768,
     *      minMessage = "Votre description doit contenir au minimum {{ limit }} caractères",
     *      maxMessage = "Votre description doit contenir au maximum {{ limit }} caractères"
     * )
     */
    private $description;

    /**
     *
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     *
     * @Assert\NotBlank(
     *     message="Veuillez saisir une date"
     * )
     * @Assert\Date()
     */
    private $date;

    /**
     *
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     *
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     *
     * @Assert\Range(
     *     min = 200,
     *     minMessage = "Veuillez saisir un montant minimal de 200€."
     * )
     */
    private $amount;

    /**
     *
     * @var int
     *
     * @ORM\Column(name="handlingFee", type="integer", nullable=true)
     */
    private $handlingFee;
    
    /**
     *
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /*
     * Add Personal Method
     */

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setCreationDate(new \DateTime());
        $this->setIsActive(true);
    }


    /**
     * Check the PACT !!!!!!!
     *
     * @return array
     */
    public function getPact()
    {
        $organization_id = [];
        $contracts = $this->getContracts();
        foreach ($contracts as $contract) {
            if (($id = $contract->getOrganization()->getId())) {
                $organization_id[] = $id;
            }
        }

        return $organization_id;
    }

    /**
     * Return true if status contract for compagny is expirate
     *
     * @return bool
     */
    public function getContractExpirate()
    {
        $contractExpirate = false;
        foreach ($this->getContracts() as $contract ) {
            if($contract->getStatus() === 4 || $contract->getStatus() === 5 )
                $contractExpirate = true;
        }
        return $contractExpirate;
    }


    /*
     * Autogenerated methods
     */

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Offer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set nameCanonical
     *
     * @param string $nameCanonical
     *
     * @return Offer
     */
    public function setNameCanonical($nameCanonical)
    {
        $this->nameCanonical = strtolower(
            str_replace(' ', '_', $nameCanonical)
        );

        return $this;
    }

    /**
     * Get nameCanonical
     *
     * @return string
     */
    public function getNameCanonical()
    {
        return $this->nameCanonical;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Offer
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Offer
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return Offer
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set handlingFee
     *
     * @param integer $handlingFee
     *
     * @return Offer
     */
    public function setHandlingFee($handlingFee)
    {
        $this->handlingFee = $handlingFee;

        return $this;
    }

    /**
     * Get handlingFee
     *
     * @return int
     */
    public function getHandlingFee()
    {
        return $this->handlingFee;
    }

    /**
     * Set activity
     *
     * @param \AppBundle\Entity\Activity $activity
     *
     * @return Offer
     */
    public function setActivity(Activity $activity)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * Get activity
     *
     * @return \AppBundle\Entity\Activity
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * Set creationDate.
     *
     * @param \DateTime $creationDate
     *
     * @return Offer
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate.
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set partnershipNumber.
     *
     * @param array|int $partnershipNumber
     *
     * @return Offer
     */
    public function setPartnershipNumber($partnershipNumber)
    {
        $this->partnershipNumber = $partnershipNumber;

        return $this;
    }

    /**
     * Get partnershipNumber.
     *
     * @return array
     */
    public function getPartnershipNumber()
    {
        return $this->partnershipNumber;
    }



    /**
     * Set partnershipNumber.
     *
     * @param int $partnershipNb
     *
     * @return Offer
     */
    public function setPartnershipNb($partnershipNb)
    {
        $partnershipNumber = [];

        for($i=0; $i < $partnershipNb; $i++) {
            array_push($partnershipNumber, 'null');
        }

        return $this->setPartnershipNumber($partnershipNumber);
    }

    /**
     * Add partnershipNumber.
     *
     * @return Offer
     */
    public function addPartnershipNumber()
    {
        return $this->setPartnershipNb($this->countPartnershipNumber() + 1);
    }

    /**
     * Remove partnershipNumber.
     *
     * @return Offer
     */
    public function removePartnershipNumber()
    {
        return $this->setPartnershipNb($this->countPartnershipNumber() - 1);
    }

    /**
     * Count partnershipNumber.
     *
     * @return int
     */
    public function countPartnershipNumber()
    {
        $partnershipNb = count($this->partnershipNumber);
        return $partnershipNb;
    }

    /**
     * Add contract.
     *
     * @param \AppBundle\Entity\Contracts $contract
     *
     * @return Offer
     */
    public function addContract(Contracts $contract)
    {
        $this->contracts[] = $contract;

        return $this;
    }

    /**
     * Remove contract.
     *
     * @param \AppBundle\Entity\Contracts $contract
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeContract(Contracts $contract)
    {
        return $this->contracts->removeElement($contract);
    }

    /**
     * Get contracts.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContracts()
    {
        return $this->contracts;
    }

    /**
     * Set isActive.
     *
     * @param bool $isActive
     *
     * @return Offer
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive.
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}
