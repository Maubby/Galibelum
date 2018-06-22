<?php
/**
 * ManagementFees Service File Doc Comment
 *
 * PHP version 7.1
 *
 * @category ManagementFeesService
 * @package  Service
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */

namespace AppBundle\Service;

/**
 * ManagementFees Service.
 *
 * @Route("organization")
 *
 * @category OrganizationController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class ManagementFeesService
{
    /**
     * Fees calculation between Total Amount of Transaction and Fees % for Galibelum
     *
     * @param int $amount    Total Amount of Transaction
     * @param int $finalDeal Final Amount set by AccountManager
     *
     * @return int
     */
    public function getFees($amount,$finalDeal) 
    {

        $fees =0;
        if (empty($finalDeal)) {
            if ($amount >= 200 && $amount < 10000) {
                $fees = $amount * 0.15;
            }
            if ($amount >= 10000 && $amount < 50000) {
                $fees = $amount * 0.1;
            }
            if ($amount >= 50000) {
                $fees = $amount * 0.07;
            }
        } else {
            $fees = $amount - $finalDeal;
        }
        return $fees;
    }
}