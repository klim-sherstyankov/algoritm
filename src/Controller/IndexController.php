<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     * @return Response
     */
    public function index(Request $request)
    {
        $array = [11, 2, 3, 4, 9, 1, 8, 66, 55, 22, 4];

        for ($i = 0; $i < count($array) - 1; $i++) {
            for ($j = 0; $j < count($array) - 1; $j++) {
                if ($array[$j] > $array[$j + 1]) {
                    $newItem       = $array[$j + 1];
                    $array[$j + 1] = $array[$j];
                    $array[$j]     = $newItem;
                }
            }
        }

        return $this->render('index/index.html.twig', [
            'array' => $array,
            'path'  => $request->getRequestUri(),
        ]);
    }
}
