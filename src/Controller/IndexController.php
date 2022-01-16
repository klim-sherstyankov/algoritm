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
        $array  = [11, 2, 3, 4, 9, 1, 8, 66, 55, 22, 4];
        $bubble = $this->bubble($array);

        $array2       = [11, 2, 3, 4, 9, 1, 8, 66, 55, 22, 4];
        $bubbleSecond = $this->bubbleSecond($array);

        $arraySheyk   = [11, 2, 3, 4, 9, 1, 8, 66, 55, 22, 4];
        $bubbleSecond = $this->sheyk($array);

        return $this->render('index/index.html.twig', [
            'bubbleTime'         => $bubble['time'],
            'bubbleMemory'       => $bubble['memory'],
            'bubbleArray'        => $bubble['array'],
            'bubbleSecondTime'   => $bubbleSecond['time'],
            'bubbleSecondMemory' => $bubbleSecond['memory'],
            'bubbleSecondArray'  => $bubbleSecond['array'],
            'sheykTime'          => $bubbleSecond['time'],
            'sheykMemory'        => $bubbleSecond['memory'],
            'sheykArray'         => $bubbleSecond['array'],
            'path'               => $request->getRequestUri(),
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
        $time   = microtime(true) - $startScript;
        $memory = memory_get_peak_usage();

        return ['time' => $time, 'memory' => $memory, 'array' => $array];
    }

    public function bubbleSecond(array $array)
    {
        $startScript = microtime(true);

        $stop = true;
        while ($stop) {
            $stop = false;
            for ($i = 0; $i < count($array) - 1; $i++) {
                if ($array[$i] > $array[$i + 1]) {
                    $temp          = $array[$i + 1];
                    $array[$i + 1] = $array[$i];
                    $array[$i]     = $temp;
                    $stop          = true;
                }
            }
        }

        $time   = microtime(true) - $startScript;
        $memory = memory_get_peak_usage();

        return ['time' => $time, 'memory' => $memory, 'array' => $array];
    }

    public function sheyk(array $array)
    {
        $startScript = microtime(true);

        $left  = 0;
        $right = count($array) - 1;
        while ($left <= $right) {
            for ($i = $left; $i < $right; ++$i) {
                if ($array[$i + 1] < $array[$i]) {
                    $tmp           = $array[$i + 1];
                    $array[$i + 1] = $array[$i];
                    $array[$i]     = $tmp;
                }
            }
            --$right;
            for ($i = $right; $i > $left; --$i) {
                if ($array[$i - 1] > $array[$i]) {
                    $tmp           = $array[$i - 1];
                    $array[$i - 1] = $array[$i];
                    $array[$i]     = $tmp;
                }
            }
            ++$left;
        }

        $time   = microtime(true) - $startScript;
        $memory = memory_get_peak_usage();

        return ['time' => $time, 'memory' => $memory, 'array' => $array];
    }
}
