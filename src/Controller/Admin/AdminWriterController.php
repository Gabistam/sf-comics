<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminWriterController extends AbstractController
{
    /**
     * @Route("/admin/writer", name="admin_writer")
     */
    public function index(): Response
    {
        return $this->render('admin_writer/index.html.twig', [
            'controller_name' => 'AdminWriterController',
        ]);
    }
}
