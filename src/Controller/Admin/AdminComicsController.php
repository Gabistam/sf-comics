<?php

namespace App\Controller;

use App\Entity\Comics;
use App\Repository\ComicsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminComicsController extends AbstractController
{
    // Pour les trois entités (Comics, Category, Brand): faire le CRUD complet dans
    // des AdminController

    // Modèle des routes @Route("/admin/create/comics/", name="admin_create_comics")
    // Bonus : trouver un moyen de pouvoir supprimer des catégories et des brands même
    // si elles sont liés à un comics

    /**
     * @Route("admin/comicses", name="admin_comics_list")
     */
    public function adminListComics(ComicsRepository $comicsRepository)
    {
        $comicses = $comicsRepository->findAll();

        return $this->render("admin/adminComicses.html.twig", ['comicses' => $comicses]);
    }

    /**
     * @Route("admin/comics/{id}", name="admin_comics_show")
     */
    public function adminShowComics($id, ComicsRepository $comicsRepository)
    {
        $comics = $comicsRepository->find($id);

        return $this->render("admin/adminComics.html.twig", ['comics' => $comics]);
    }

    /**
     * @Route("admin/update/comics/{id}", name="admin_update_comics")
     */
    public function adminUpdateComics(
        $id,
        ComicsRepository $comicsRepository,
        Request $request,
        EntityManagerInterface $entityManagerInterface
    ) {

        $comics = $comicsRepository->find($id);

        $comicsForm = $this->createForm(ComicsType::class, $comics);

        $comicsForm->handleRequest($request);

        if ($comicsForm->isSubmitted() && $comicsForm->isValid()) {
            $entityManagerInterface->persist($comics);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_comics_list");
        }


        return $this->render("admin/adminComicsform.html.twig", ['comicsForm' => $comicsForm->createView()]);
    }

    /**
     * @Route("admin/create/comics/", name="admin_comics_create")
     */
    public function adminComicsCreate(Request $request, EntityManagerInterface $entityManagerInterface)
    {
        $comics = new Comics();

        $comicsForm = $this->createForm(ComicsType::class, $comics);

        $comicsForm->handleRequest($request);

        if ($comicsForm->isSubmitted() && $comicsForm->isValid()) {
            $entityManagerInterface->persist($comics);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_comics_list");
        }


        return $this->render("admin/adminComicsform.html.twig", ['comicsForm' => $comicsForm->createView()]);
    }

    /**
     * @Route("admin/delete/comics/{id}", name="admin_delete_comics")
     */
    public function adminDeleteComics(
        $id,
        ComicsRepository $comicsRepository,
        EntityManagerInterface $entityManagerInterface
    ) {

        $comics = $comicsRepository->find($id);

        $entityManagerInterface->remove($comics);

        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_comics_list");
    }
}