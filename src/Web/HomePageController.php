<?php
declare(strict_types=1);
namespace App\Web;

use App\Responder\HomepageResponder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 */
class HomePageController extends AbstractController
{

    #[Route('/', name: 'homepage', methods: 'GET')]
    public function index(HomepageResponder $responder): Response
    {
        return $responder();
    }
}
