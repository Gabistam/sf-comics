<?php

namespace App\Controller;

use App\Entity\Editor;
use App\Repository\EditorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminEditorController extends AbstractController
{
    /**
     * @Route("/admin/editor", name="admin_editor")
     */
    public function editorList(EditorRepository $editorRepository)
    {
        $editors = $editorRepository->findAll();

        return $this->render("admin/adminEditors.html.twig", ['editors' => $editors]);
    }

    /**
     * @Route("/admin/editor/{id}", name="admin_editor_show")
     */
    public function editorShow($id, EditorRepository $editorRepository)
    {
        $editor = $editorRepository->find($id);

        return $this->render("admin/adminEditor.html.twig", ['editor' => $editor]);
    }

    /**
     * @Route("admin/update/editor/{id}", name="admin_update_editor")
     */
    public function adminUpdateEditor(
        $id,
        EditorRepository $editorRepository,
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        SluggerInterface $sluggerInterface
    ) {

        $editor = $editorRepository->find($id);

        $editorForm = $this->createForm(EditorType::class, $editor);

        $editorForm->handleRequest($request);

        if ($editorForm->isSubmitted() && $editorForm->isValid()) {

            $mediaFile = $editorForm->get('media')->getData();

            if ($mediaFile) {

                $originalFilename = pathinfo($mediaFile->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = $sluggerInterface->slug($originalFilename);

                $newFilename = $safeFilename . '-' . uniqid() . '.' . $mediaFile->guessExtension();

                $mediaFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $editor->setMedia($newFilename);
            }

            $entityManagerInterface->persist($editor);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_editor_list");
        }


        return $this->render("admin/editorform.html.twig", ['editorForm' => $editorForm->createView()]);
    }

    /**
     * @Route("admin/create/editor/", name="admin_editor_create")
     */
    public function adminEditorCreate(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        SluggerInterface $sluggerInterface
    ) {
        $editor = new Editor();

        $editorForm = $this->createForm(EditorType::class, $editor);

        $editorForm->handleRequest($request);

        if ($editorForm->isSubmitted() && $editorForm->isValid()) {


            $mediaFile = $editorForm->get('media')->getData();

            if ($mediaFile) {

                $originalFilename = pathinfo($mediaFile->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = $sluggerInterface->slug($originalFilename);

                $newFilename = $safeFilename . '-' . uniqid() . '.' . $mediaFile->guessExtension();

                $mediaFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $editor->setMedia($newFilename);
            }

            $entityManagerInterface->persist($editor);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_editor_list");
        }


        return $this->render("admin/adminEditorform.html.twig", ['editorForm' => $editorForm->createView()]);
    }

    /**
     * @Route("admin/delete/editor/{id}", name="admin_delete_editor")
     */
    public function adminDeleteEditor(
        $id,
        EditorRepository $editorRepository,
        EntityManagerInterface $entityManagerInterface
    ) {

        $editor = $editorRepository->find($id);

        $entityManagerInterface->remove($editor);

        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_editor_list");
    }
}
