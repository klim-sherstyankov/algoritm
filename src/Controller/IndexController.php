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
        $bubble = $this->bubble($array);

        $array2 = [11, 2, 3, 4, 9, 1, 8, 66, 55, 22, 4];

        $t = true;
        while ($t) {
            $t = false;
            for ($i = 0; $i < count($array2) - 1; $i++) {
                if ($array2[$i] > $array2[$i + 1]) {
                    $temp = $array2[$i + 1];
                    $array2[$i + 1] = $array2[$i];
                    $array2[$i] = $temp;
                    $t = true;
                }
            }
        }

        $arraySheyk = [11, 2, 3, 4, 9, 1, 8, 66, 55, 22, 4];
        $left = 0;
        $right = count($arraySheyk) - 1;
        while ($left <= $right) {
            for ($i=$left; $i < $right ; ++$i) {
                if($arraySheyk[$i + 1] < $arraySheyk[$i]) {
                    $tmp = $arraySheyk[$i + 1];
                    $arraySheyk[$i + 1] = $arraySheyk[$i];
                    $arraySheyk[$i] = $tmp;
                }
            }
            --$right;
            for ($i=$right; $i > $left ; --$i) {
                if($arraySheyk[$i - 1] > $arraySheyk[$i]) {
                    $tmp = $arraySheyk[$i - 1];
                    $arraySheyk[$i - 1] = $arraySheyk[$i];
                    $arraySheyk[$i] = $tmp;
                }
            }
            ++$left;
        }

        return $this->render('index/index.html.twig', [
            'bubbleTime' => $bubble['time'],
            'bubbleMemory' => $bubble['memory'],
            'bubbleArray' => $bubble['array'],
            'array2' => $array2,
            'arraySheyk' => $arraySheyk,
            'path'  => $request->getRequestUri(),
        ]);
    }

    public function bubble(array $array)
    {
        $startScript = microtime(true);

        for ($i = 0; $i < count($array) - 1; $i++) {
            for ($j = 0; $j < count($array) - 1; $j++) {
                if ($array[$j] > $array[$j + 1]) {
                    $newItem       = $array[$j + 1];
                    $array[$j + 1] = $array[$j];
                    $array[$j]     = $newItem;
                }
            }
        }
        $time = microtime(true) - $startScript;
        $memory = memory_get_peak_usage();

        return ['time' => $time, 'memory' => $memory, 'array' => $array];
    }
}
