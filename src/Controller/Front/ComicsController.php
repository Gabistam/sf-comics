<?php

namespace App\Controller;

use App\Repository\ComicsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ComicsController extends AbstractController
{
    /**
     * @Route("comicses", name="comics_list")
     */
    public function comicsList(ComicsRepository $comicsRepository)
    {
        $comicses = $comicsRepository->findAll(); // findAll() récupère tous les comicses de la bdd

        return $this->render('front/comicses.html.twig', ['comicses' => $comicses]);
    }

    /**
     * @Route("comics/{id}", name="comics_show")
     */
    public function comicsShow($id, ComicsRepository $comicsRepository)
    {
        $comics = $comicsRepository->find($id); // find() permet de récupérer un comicse grâce à son id.

        return $this->render('front/comics.html.twig', ['comics' => $comics]);
    }
}
