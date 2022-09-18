<?php

/**
 * Home controller.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="homepage_index",
     * )
     */
    public function index(): Response
    {
        return $this->render(
            'home/index.html.twig',
            []
        );
    }
}
