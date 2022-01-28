<?php

namespace App\Controller;

use App\Form\LengthType;
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
        $form = $this->createForm(LengthType::class, null, ['csrf_protection' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $length = $form->getData()['length'];
            $array  = $this->generate($length);

            return $this->render('index/index.html.twig', [
                'bubble'       => $this->bubble($array),
                'bubbleSecond' => $this->bubbleSecond($array),
                'sheyk'        => $this->sheyk($array),
                'insert'       => $this->insertSort($array),
                'choice'       => $this->choiceSort($array),
                'comb'         => $this->combSort($array),
                'path'         => $request->getRequestUri(),
            ]);
        }

        return $this->render('index/index.html.twig', [
            'form' => $form->createView(),
            'path' => $request->getRequestUri(),
        ]);
    }

    public function generate(int $length)
    {
        for ($i = 0; $i < $length; $i++) {
            $array[] = rand(0, 600);
        }

        return $array;
    }

    public function bubble(array $array)
    {
        $startScript  = microtime(true);
        $memory_start = memory_get_usage();
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
        $memory = memory_get_usage() - $memory_start;

        return ['time' => $time, 'memory' => $memory, 'array' => $array];
    }

    public function bubbleSecond(array $array)
    {
        $startScript  = microtime(true);
        $memory_start = memory_get_usage();
        $stop         = true;
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
        $memory = memory_get_usage() - $memory_start;

        return ['time' => $time, 'memory' => $memory, 'array' => $array];
    }

    public function sheyk(array $array)
    {
        $startScript  = microtime(true);
        $memory_start = memory_get_usage();
        $left         = 0;
        $right        = count($array) - 1;
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
        $memory = memory_get_usage() - $memory_start;

        return ['time' => $time, 'memory' => $memory, 'array' => $array];
    }

    public function insertSort(array $array)
    {
        $startScript  = microtime(true);
        $memory_start = memory_get_usage();
        for ($i = 0; $i <= count($array) - 1; $i++) {
            if (0 == $i && $array[$i + 1] > $array[$i]) {
                $newItem       = $array[$i];
                $array[$i]     = $array[$i + 1];
                $array[$i + 1] = $newItem;
            }
            for ($j = $i; $j > 0; $j--) {
                if ($array[$j - 1] > $array[$j]) {
                    $newItem       = $array[$j - 1];
                    $array[$j - 1] = $array[$j];
                    $array[$j]     = $newItem;
                }
            }
        }
        $time   = microtime(true) - $startScript;
        $memory = memory_get_usage() - $memory_start;

        return ['time' => $time, 'memory' => $memory, 'array' => $array];
    }

    public function choiceSort(array $array)
    {
        $startScript  = microtime(true);
        $memory_start = memory_get_usage();
        for ($i = 0; $i <= count($array) - 1; $i++) {
            $min = $array[$i];
            for ($j = $i; $j <= count($array) - 1; $j++) {
                if ($min > $array[$j]) {
                    $min   = $array[$j];
                    $index = $j;
                }
            }
            if ($array[$i] > $min) {
                $newItem       = $array[$i];
                $array[$i]     = $min;
                $array[$index] = $newItem;
            }
        }
        $time   = microtime(true) - $startScript;
        $memory = memory_get_usage() - $memory_start;

        return ['time' => $time, 'memory' => $memory, 'array' => $array];
    }

    public function combSort(array $array)
    {
        $startScript  = microtime(true);
        $memory_start = memory_get_usage();
        $count        = count($array);
        $swap         = false;
        while ($count > 11 || !$swap) {
            if ($count > 1) {
                $count /= 1.27;
            }
            $swap = true;
            $i    = 0;
            while ($i + $count < count($array)) {
                if ($array[$i] > $array[$i + $count]) {
                    list($array[$i], $array[$i + $count]) = [$array[$i + $count], $array[$i]];
                    $swap                                 = false;
                }
                ++$i;
            }
        }
        $time   = microtime(true) - $startScript;
        $memory = memory_get_usage() - $memory_start;

        return ['time' => $time, 'memory' => $memory, 'array' => $array];
    }
}
