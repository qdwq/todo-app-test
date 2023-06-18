<?php

/**
 * Photos controller.
 */

namespace App\Controller;

use App\Entity\Photos;
use App\Form\PhotosType;
use App\Service\PhotosService;
use App\Service\CommentsService;
use Doctrine\ORM\NonUniqueResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PhotosController.
 *
 * @property $commentsService
 *
 * @Route("/Photos")
 */
class PhotosController extends AbstractController
{
    private PhotosService $photosService;
    private CommentsService $commentsService;

    /**
     * PhotosController constructor.
     *
     * @param PhotosService   $photosService   Photos service
     * @param CommentsService $commentsService Comments service
     */
    public function __construct(PhotosService $photosService, CommentsService $commentsService)
    {
        $this->photosService = $photosService;
        $this->commentsService = $commentsService;
    }

    /**
     * Index_action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP Response
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
     * @return Response HTTP Response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="Photos_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     * @throws NonUniqueResultException
     */
    public function show(int $id): Response
    {
        $photos = $this->photosService->getOne($id);
        $comments = $this->commentsService->getByPhotoId($photos->getId());

        return $this->render(
            'Photos/show.html.twig',
            ['Photos' => $photos, 'Comments' => $comments]
        );
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="photos_create",
     * )
     */
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request): Response
    {
        $photos = new Photos();
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
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="Photos_edit",
     * )
     */
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Photos $photos): Response
    {
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
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="Photos_delete",
     * )
     */
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Photos $photos): Response
    {
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
