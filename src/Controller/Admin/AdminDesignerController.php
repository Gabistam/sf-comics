<?php

namespace App\Controller;

use App\Entity\Designer;
use App\Form\DesignerType;
use App\Repository\DesignerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminDesignerController extends AbstractController
{
    /**
     * @Route("admin/designers", name="admin_designer_list")
     */
    public function adminListDesigner(DesignerRepository $designerRepository)
    {
        $designers = $designerRepository->findAll();

        return $this->render("admin/designers.html.twig", ['designers' => $designers]);
    }

    /**
     * @Route("admin/designer/{id}", name="admin_designer_show")
     */
    public function adminShowDesigner($id, DesignerRepository $designerRepository)
    {
        $designer = $designerRepository->find($id);

        return $this->render("admin/designer.html.twig", ['designer' => $designer]);
    }

    /**
     * @Route("admin/update/designer/{id}", name="admin_update_designer")
     */
    public function adminUpdateDesigner(
        $id,
        DesignerRepository $designerRepository,
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        SluggerInterface $sluggerInterface
    ) {

        $designer = $designerRepository->find($id);

        $designerForm = $this->createForm(DesignerType::class, $designer);

        $designerForm->handleRequest($request);

        if ($designerForm->isSubmitted() && $designerForm->isValid()) {

            $imageFile = $designerForm->get('image')->getData();

            if ($imageFile) {

                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = $sluggerInterface->slug($originalFilename);

                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $designer->setMedia($newFilename);
            }

            $entityManagerInterface->persist($designer);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_designer_list");
        }


        return $this->render("admin/designerform.html.twig", ['designerForm' => $designerForm->createView()]);
    }

    /**
     * @Route("admin/create/designer/", name="admin_designer_create")
     */
    public function adminDesignerCreate(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        SluggerInterface $sluggerInterface
    ) {
        $designer = new Designer();

        $designerForm = $this->createForm(DesignerType::class, $designer);

        $designerForm->handleRequest($request);

        if ($designerForm->isSubmitted() && $designerForm->isValid()) {


            $imageFile = $designerForm->get('image')->getData();

            if ($imageFile) {

                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = $sluggerInterface->slug($originalFilename);

                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $designer->setMedia($newFilename);
            }

            $entityManagerInterface->persist($designer);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_designer_list");
        }


        return $this->render("admin/designerform.html.twig", ['designerForm' => $designerForm->createView()]);
    }

    /**
     * @Route("admin/delete/designer/{id}", name="admin_delete_designer")
     */
    public function adminDeleteDesigner(
        $id,
        DesignerRepository $designerRepository,
        EntityManagerInterface $entityManagerInterface
    ) {

        $designer = $designerRepository->find($id);

        $entityManagerInterface->remove($designer);

        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_designer_list");
    }
}
