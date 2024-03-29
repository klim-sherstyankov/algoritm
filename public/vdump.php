<?php
date_default_timezone_set('Europe/Moscow');
defined('CLI') or define('CLI', php_sapi_name() === 'cli');
$zdev = (CLI ? true : true);
defined('ZDEV') or define('ZDEV', $zdev);
// define('ZDEV', false);

if (ZDEV) {
  // header("HTTP/1.0 404 Not Found");
  ini_set('display_errors', 1);
} else {
  ini_set('display_errors', 0);
}
error_reporting(E_ALL);

function vdump()
{
  $d = debug_backtrace();
  $d = $d[0];
  extract($d);
  $ffile = file($file, FILE_IGNORE_NEW_LINES);
  array_unshift($ffile, '');
  unset($ffile[0]);
  $c  = $line;
  $as = [];
  while (true) {
    $s   = $ffile[$c];
    $pos = strpos($s, $function);
    if (false === $pos) {
      --$c;
      array_unshift($as, trim($s));
      continue;
    }
    array_unshift($as, trim($s));
    break;
  }
  $s = implode($as);
  unset($ffile);
  preg_match('~'.$function."\((.*)\)~", $s, $sa);
  $_sa = function ($string) {
    $delimiter    = [','];
    $open_quotes  = ['\'', '"', '(', '['];
    $close_quotes = ['\'', '"', ')', ']'];
    $string       = preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

    $arr    = [];
    $quotes = 0;
    $str    = '';
    $count  = count($string);
    foreach ($string as $chars) {
      --$count;
      if ($quotes < 1) {
        if (in_array($chars, $open_quotes)) {
          $str .= $chars;
          ++$quotes;
          continue;
        }
        if (in_array($chars, $delimiter)) {
          $arr[] = $str;
          $str   = '';
          continue;
        }
        $str .= $chars;
        if (0 === $count) {
          $arr[] = $str;
          $str   = '';
          continue;
        }
      }
      if ($quotes > 0) {
        if (in_array($chars, $close_quotes)) {
          $str .= $chars;
          if (0 === $count) {
            $arr[] = $str;
            $str   = '';
            continue;
          }
          --$quotes;
          continue;
        }
        if (in_array($chars, $open_quotes)) {
          $str .= $chars;
          ++$quotes;
          continue;
        }
        $str .= $chars;
        continue;
      }

    }

    return $arr;
  };
  $sa = $_sa($sa[1]);
  ob_start();
  if (!ZDEV) {
    $pt = "\t";
    echo '['.date('Y.m.d').' '.date('H:i:s').'] File \''.$file.'\''.PHP_EOL;
    foreach ($args as $k => $v) {

      echo $pt.'Строка: '.$line.' > ['.trim($sa[$k]).'] >'.PHP_EOL;
      var_dump($v);
      echo '[- - - - - - - - - - - - - - - - - -]'.PHP_EOL;
    }

  } elseif (!CLI) {

    echo "<div style='width:auto;font-size:10pt;background-color:#323B44;padding:.3em;order:-100'>";
    echo '<style>body{margin:0;padding:0;}</style>';
    echo "<div style='width: auto;min-width: 50em;max-width: 120em;margin: 0 auto;padding: 0 3em;'>";
    echo "<div style='border-bottom: 1px dotted #000;color:#efdc3a;font-size:0.9em;line-height:1em;text-align:start;'>";

    if(function_exists('xdebug_break')) {
      echo '<style type="text/css">.xdebug-var-dump{margin:0}.xdebug-var-dump>small{display:block}</style>';
    }
    echo 'файл => '.$file.'<br>';
    echo 'строка => '.$line.'<br>';

    echo '</div>';

    foreach ($args as $k => $v) {

      echo "<div style='border-bottom: 1px dotted #000;'>";

      echo "  <div style='display:inline-block;width:25%;vertical-align:top;background:#89e6b8;font-size:1.3em;font-weight:bold;text-align:right;line-height:1.5em;color:#000'>";
      echo trim($sa[$k]).' => ';
      echo '  </div>';

      echo "  <div style='display:inline-block;width:70%;vertical-align:top;background: #d65b36;'>";
      echo "    <pre style='margin:0.2em;padding:.3em;overflow:auto;line-height:1em;color: #000;text-align:start;background:#d65b36'>";
      var_dump($v);
      // var_dump(htmlentities($v));
      echo '    </pre>';
      echo '  </div>';

      echo '</div>';
    }
    echo '</div>';
    echo '</div>';

  } else {
    echo "\n\033[0;36m".$file.":\033[0m";
    foreach ($args as $k => $v) {
      echo "\n\033[0;33mСтрока:".$line." >\033[0;32m ".trim($sa[$k])." > \033[0m";
      echo "\n";
      var_dump($v);
      echo "\033[0;32m- - - - - - - - - - - - \033[0m\n";
    }
  }
  $string = ob_get_clean();

  if (!ZDEV) {
    $_file = __DIR__.'/logs/vdump.log';
    file_put_contents($_file, $string, FILE_APPEND);
    chmod($_file, 0777);
  } else {
    echo $string;
  }
}