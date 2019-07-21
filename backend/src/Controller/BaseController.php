<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @Route("/", name="base")
     */
    public function index()
    {
        return $this->json([
            'status_code' => 200,
            'msg' => 'the server is alive and ready to take action'
        ]);
    }
}
