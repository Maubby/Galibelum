<?php
/**
 * ContractController File Doc Comment
 *
 * PHP version 7.1
 *
 * @category ContractController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
/**
 * Contract controller.
 *
 * @Route("contract")
 *
 * @category ContractController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class ContractController extends Controller
{
    /**
     * Lists all contracts.
     *
     * @Route("/",    name="contract_index")
     * @Method("GET")
     *
     * @return Response A Response instance
     */
    public function contractAction()
    {
        $em = $this->getDoctrine()->getManager();
        $offers = $em
            ->getRepository('AppBundle:Offer')
            ->findAll();
        return $this->render(
            'contractualisation/index.html.twig', array(
                'offers' => $offers,
            )
        );
    }
}