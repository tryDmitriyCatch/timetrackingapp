<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WebController
 * @package App\Controller
 */
class WebController extends AbstractController {

    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function homepageAction(): Response
    {
        return $this->render('Home/Index.html.twig');
    }

    /**
     * @Route("/login", name="login")
     * @return Response
     */
    public function loginPageAction(): Response
    {
        return $this->render('Home/Login.html.twig');
    }

    /**
     * @Route("/workspace", name="workspace")
     * @return Response
     */
    public function userWorkspaceAction(): Response
    {
        return $this->render('Back/User/User.html.twig');
    }

    /**
     * @Route("/add_task", name="add-task")
     * @return Response
     */
    public function addTaskAction(): Response
    {
        return $this->render('Back/User/UserAddTask.html.twig');
    }

    /**
     * @Route("/export", name="export")
     * @return Response
     */
    public function exportAction(): Response
    {
        return $this->render('Back/User/Export.html.twig');
    }
}
