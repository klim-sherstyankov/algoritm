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
        $arr = [11, 2, 3, 4, 9, 1, 8, 66, 55, 22, 4];

        $t = true;
        while ($t) {
            $t = false;
            for ($i = 0; $i < count($arr) - 1; $i++) {
                if ($arr[$i] > $arr[$i + 1]) {
                    $temp = $arr[$i + 1];
                    $arr[$i + 1] = $arr[$i];
                    $arr[$i] = $temp;
                    $t = true;
                }
            }
        }

        $arraySheyk = [11, 2, 3, 4, 9, 1, 8, 66, 55, 22, 4];
        $left = 0;
        $right = count($arraySheyk) - 1;
        while ($left <= $right) {
            for ($i = $right; $i > $left; --$i) {
              if ($arraySheyk[$i - 1] > $arraySheyk[$i]) {
                $tmp = $arraySheyk[$i - 1];
                $arraySheyk[$i - 1] = $arraySheyk[$i];
                $arraySheyk[$i] = $tmp;
              }
            }
            ++$left;
            for ($i = $left; $i < $right; ++$i) {
              if ($arraySheyk[$i] > $arraySheyk[$i + 1]) {
                $tmp = $arraySheyk[$i - 1];
                $arraySheyk[$i - 1] = $arraySheyk[$i];
                $arraySheyk[$i] = $tmp;
              }
            }
            --$right;
          }

        return $this->render('index/index.html.twig', [
            'array' => $array,
            'arr' => $arr,
            'arraySheyk' => $arraySheyk,
            'path'  => $request->getRequestUri(),
        ]);
    }
}
