<?php

namespace AppBundle\Controller;

use AppBundle\Model\IndexDocument\Log;
use AppBundle\Model\IndexDocument\Stock;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/api", name="api")
     */
    public function apiAction(Request $request)
    {
        $repository = $this->get('stock_importer.repository.log');

        $log = new Log();
        $log->setMessage('event logged');

        $repository->addDocument($log);

        return new JsonResponse($repository->getDocument('uXpODHAB2FxnKapGkQLo')->getBody());
    }
}
