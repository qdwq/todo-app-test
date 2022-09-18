<?php

/**
 * Photos controller.
 */

namespace App\Controller;

use App\Entity\Photos;
use App\Form\PhotosType;
use App\Service\PhotosService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PhotosController.
 *
 * @Route("/Photos")
 */
class PhotosController extends AbstractController
{
    private PhotosService $photosService;

    /**
     * PhotosController constructor.
     */
    public function __construct(PhotosService $photosService)
    {
        $this->photosService = $photosService;
    }

    /**
     * Index_action.
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="Photos_index",
     *
     * )
     */
    public function index(Request $request): Response
    {
        $pagination = $this->photosService->createPaginatedList($request->query->getInt('page', 1));

        return $this->render(
            'Photos\index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param int $id id
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="Photos_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     */
    public function show(int $id): Response
    {
        $photos = $this->photosService->getOneWithComments($id);

        return $this->render(
            'Photos/show.html.twig',
            ['Photos' => $photos]
        );
    }

    /**
     * Create action.
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="photos_create",
     * )
     * @IsGranted("ROLE_ADMIN")
     */
    public function create(Request $request): Response
    {
        $photos = new Photos();
        $this->denyAccessUnlessGranted('edit', $photos);
        $form = $this->createForm(PhotosType::class, $photos, ['required' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->photosService->save($photos, $form->get('file')->getData());

            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('Photos_index');
        }

        return $this->render(
            'Photos/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Photos  $photos  Photos entity
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="Photos_edit",
     * )
     *
     */
    public function edit(Request $request, Photos $photos): Response
    {
        $this->denyAccessUnlessGranted('edit', $photos);
        $form = $this->createForm(PhotosType::class, $photos, ['method' => 'PUT', 'required' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->photosService->save($photos, $form->get('file')->getData());

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('Photos_index');
        }

        return $this->render(
            'Photos/edit.html.twig',
            [
                'form' => $form->createView(),
                'Photos' => $photos,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Photos  $photos  Photos entity
     *
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="Photos_delete",
     * )
     */
    public function delete(Request $request, Photos $photos): Response
    {
        $this->denyAccessUnlessGranted('delete', $photos);
        $form = $this->createForm(FormType::class, $photos, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->photosService->delete($photos);

            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('Photos_index');
        }

        return $this->render(
            'Photos/delete.html.twig',
            [
                'form' => $form->createView(),
                'Photos' => $photos,
            ]
        );
    }
}
