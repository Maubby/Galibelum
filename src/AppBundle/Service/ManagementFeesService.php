<?php
/**
 * ManagementFees Service File Doc Comment
 *
 * PHP version 7.2
 *
 * @category ManagementFeesService
 * @package  Service
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */

namespace AppBundle\Service;


use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * FileUploader class service.
 *
 * @category ManagementFeesService
 * @package  Service
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class ManagementFeesService
{
    private $_container;

    /**
     * ManagementFeesService constructor.
     *
     * @param ContainerInterface $container To use a global constant
     */
    public function __construct(ContainerInterface $container)
    {
        $this->_container = $container;
    }

    /**
     * Fees calculation between Total Amount of Transaction and Fees % for Galibelum
     *
     * @param int $amount    Total Amount of Transaction
     * @param int $finalDeal Final Amount set by AccountManager
     *
     * @return int
     */
    public function getFees($amount, $finalDeal = null)
    {
        $fees = 0;
        if (empty($finalDeal)) {
            if ($amount >= 200 && $amount < 10000) {
                $fees = $amount * $this->_container->getParameter('fee15');
            }
            if ($amount >= 10000 && $amount < 50000) {
                $fees = $amount * $this->_container->getParameter('fee10');
            }
            if ($amount >= 50000) {
                $fees = $amount * $this->_container->getParameter('fee7');
            }
        } else {
            $fees = $amount - $finalDeal;
        }
        return $fees;
    }
}
