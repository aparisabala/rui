<?php

function time_elapsed_string($datetime, $full = false)
{
    $now  = new DateTime;
    $ago  = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full) {
        $string = array_slice($string, 0, 1);
    }
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function getBase64($path)
{

    $type   = pathinfo($path, PATHINFO_EXTENSION);
    $data   = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $base64;
}

function getBase64AsString($path)
{
    $data   = file_get_contents($path);
    $base64 = base64_encode($data);
    return $base64;
}

function warp_svg_text ($text,$op=[]) {
        $width = isset($op['width']) ? $op['width'] : 0; 
        $font_size = isset($op['font_size']) ? $op['font_size'] : "12px"; 
        $ff = isset($op['ff']) ? $op['ff'] : 'tr'; 
        $y = isset($op['y']) ? $op['y'] : 0; 
        $x = isset($op['x']) ? $op['x'] : 0; 
        $l = isset($op['l']) ? $op['l'] : 0; 
        $words = explode(" ", $text);
        $line = [];
        $fina_lines = [];
        $line_number = 0;
        $to_check = "";
        $last = "";
        for ($i = 0; $i < count($words); $i++) {
            array_push($line, $words[$i]);
            $to_check = implode(" ", $line);
            if (text_width($to_check, $font_size, $ff) > $width) {
                array_push($fina_lines, $to_check);
                $line = [];
                $to_check = "";
                $last = "";
            } else {
                if ($i == count($words) - 1) {
                    $last .= $words[$i];
                } else {
                    $last .= $words[$i] . " ";
                }
            }
        }
        if ($last != "") {
            array_push($fina_lines, $last);
        }
        if (count($fina_lines) == 1) {
            return '<tspan x="'.$x.'" y="'.$y.'" style="text-anchor: middle;font-size:'.$font_size.'px" dy="0"> '.$fina_lines[0].'  </tspan>';
        }
        $final = [];
        foreach ($fina_lines as $k => $v) {
            $dy = ($k == 0) ? 0 : 1 . "em";
            $x = ($k <= $l) ? "".$x : "0";
            $g = '<tspan x="'.$x.'" style="text-anchor:middle;font-size:'.$font_size.'px" dy="'.$dy.'" > '.$v.'  </tspan>';
            array_push($final, $g);
        }
        return implode(" ",$final);
}

function text_height ($text,$font_size,$ff) {
    $box = get_bbox($text,$font_size,$ff);
    $height = $box[3] - $box[5];
    return $height;
}  
function text_width($text,$font_size,$ff) {
    $box = get_bbox($text,$font_size,$ff);
    $width = $box[4] - $box[6];
    return $width;
}
function get_bbox($text,$font_size,$ff){
    return imagettfbbox($font_size, 0, dirname(__FILE__) .'/cards/fonts/'.$ff.'.ttf' , $text);
}

function getDots($str,$t=1)
{
    $d = '-';
    $a = strlen($str)*$t;
    for ($i=0; $i < $a; $i++) { 
       $d .='-';
    }
    return $d;
}

function code128BarCode($code, $density = 1)
{
    define('CODE128A_START_BASE', 103);
    define('CODE128B_START_BASE', 104);
    define('CODE128C_START_BASE', 105);
    define('STOP', 106);
    $code128_bar_codes = array(
        212222, 222122, 222221, 121223, 121322, 131222, 122213, 122312, 132212, 221213, 221312, 231212, 112232, 122132, 122231, 113222, 123122, 123221, 223211, 221132, 221231,
        213212, 223112, 312131, 311222, 321122, 321221, 312212, 322112, 322211, 212123, 212321, 232121, 111323, 131123, 131321, 112313, 132113, 132311, 211313, 231113, 231311,
        112133, 112331, 132131, 113123, 113321, 133121, 313121, 211331, 231131, 213113, 213311, 213131, 311123, 311321, 331121, 312113, 312311, 332111, 314111, 221411, 431111,
        111224, 111422, 121124, 121421, 141122, 141221, 112214, 112412, 122114, 122411, 142112, 142211, 241211, 221114, 413111, 241112, 134111, 111242, 121142, 121241, 114212,
        124112, 124211, 411212, 421112, 421211, 212141, 214121, 412121, 111143, 111341, 131141, 114113, 114311, 411113, 411311, 113141, 114131, 311141, 411131, 211412, 211214,
        211232, 23311120,
    );
    $width  = (((11 * strlen($code)) + 35) * ($density / 72)); // density/72 determines bar width at image DPI of 72
    $height = ($width * .15 > .7) ? $width * .15 : .7;
    $px_width  = round($width * 72);
    $px_height = ($height * 72);
    $img   = imagecreatetruecolor($px_width, $px_height);
    $white = imagecolorallocate($img, 255, 255, 255);
    $black = imagecolorallocate($img, 0, 0, 0);
    imagefill($img, 0, 0, $white);
    imagesetthickness($img, $density);
    $checksum = CODE128B_START_BASE;
    $encoding = array($code128_bar_codes[CODE128B_START_BASE]);
    for ($i = 0; $i < strlen($code); $i++) {
        $checksum += (ord(substr($code, $i, 1)) - 32) * ($i + 1);
        array_push($encoding, $code128_bar_codes[(ord(substr($code, $i, 1))) - 32]);
    }
    array_push($encoding, $code128_bar_codes[$checksum % 103]);
    array_push($encoding, $code128_bar_codes[STOP]);
    $enc_str = implode($encoding);
    for ($i = 0, $x = 0, $inc = round(($density / 72) * 100); $i < strlen($enc_str); $i++) {
        $val = intval(substr($enc_str, $i, 1));
        for ($n = 0; $n < $val; $n++, $x += $inc) {
            if ($i % 2 == 0) {
                imageline($img, $x, 0, $x, $px_height, $black);
            }
        }
    }
    return $img;
}

function convert_to_file_name($str)
{
    $s = trim(strip_tags(stripslashes(implode("_", explode(" ", trim($str))))));
    return $s;
}