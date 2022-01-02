<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function right($value, $count)
{
    $value = substr($value, (strlen($value) - $count), strlen($value));
    return $value;
}

function left($string, $count)
{
    return substr($string, 0, $count);
}

//문자열 사이에 있는 문자를 추출하는 함수
function extraxtText($book, $text1, $text2, $n = 1, $m = 1)
{
    $temp1 = 1;
    $temp2 = 1;
    $result = '';
    for ($i = 0; $i <= $n - 1; $i++) {
        if (mb_strpos($book, $text1, $temp1 - 1) !== false) {
            $temp1 = mb_strpos($book, $text1, $temp1 - 1) + 1 + mb_strlen($text1); //찾았을경우
        } else {
            return ''; //찾지못했을경우
        }
    }
    $temp2 = mb_strpos($book, $text2, $temp1 - 1) + 1 + mb_strlen($text2);
    for ($j = 1; $j <= $m - 1; $j++) {
        $temp2 = mb_strpos($book, $text2, $temp2 - 1) + 1 + mb_strlen($text2);
    }

    if (mb_strpos($book, $text1, 0) + 1 == 0) {
        $result = '';
    } else {
        $result = mb_substr($book, $temp1 - 1, $temp2 - $temp1 - mb_strlen($text2));
    }
    return $result;
}

function getFileSize($size, $float = 0)
{
    $unit = array('Byte', 'KB', 'MB', 'GB', 'TB');
    for ($L = 0; intval($size / 1024) > 0; $L++, $size /= 1024);
    if (($float === 0) && (intval($size) != $size)) $float = 2;
    return number_format($size, $float, '.', ',') . ' ' . $unit[$L];
}

//외부 파일을 내부 서버에 저장하는 함수 성공시 1 실패시 false 반환
function copyByCurl($localpath, $outsideUrl)
{
    $fp = fopen($localpath, 'w');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $outsideUrl);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)');
    curl_setopt($ch, CURLOPT_FILE, $fp);

    $result = curl_exec($ch);
    fclose($fp);
    curl_close($ch);

    return $result;
}

/*
191003
get_header를 했을때 302가 연속적으로 나와서 찾은 방법
마지막 location이 200일때의 url을 찾아줌
*/
function getHttpStatus200($url = null)
{
    if ($url == null) {
        return array('code' => null, 'url' => null);
    }
    $result = array();
    $ch = curl_init();
    $options = array(
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER         => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING       => '',
        CURLOPT_AUTOREFERER    => true,
        CURLOPT_CONNECTTIMEOUT => 120,
        CURLOPT_TIMEOUT        => 120,
        CURLOPT_MAXREDIRS      => 10,
    );
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    $result['code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $result['url'] = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    if (substr($result['url'], 0, 4) == 'HTTP') {
        $result['url'] = 'http' . substr($result['url'], 4); //소문자변환
    }
    curl_close($ch);

    return $result;
}

//디렉토리 내 모든 하위 파일의 크기와 수
function dirsize($dir)
{
    static $size, $cnt = 0;
    if (!is_dir($dir)) {
        return false;
    }
    $fp = opendir($dir);
    while (false !== ($entry = readdir($fp))) {
        if (($entry != '.') && ($entry != '..')) {
            if (is_dir($dir . '/' . $entry)) {
                clearstatcache();
                dirsize($dir . '/' . $entry);
            } else if (is_file($dir . '/' . $entry)) {
                $size += filesize($dir . '/' . $entry);
                clearstatcache();
                $cnt++;
            }
        }
    }
    closedir($fp);
    $stat = array(
        'size' => $size,
        'cnt' => $cnt
    );
    return $stat;
}

// 그누보드에서 가져옴
// 변수 또는 배열의 이름과 값을 얻어냄. print_r() 함수의 변형
function print_r2($var)
{
    ob_start();
    print_r($var);
    $str = ob_get_contents();
    ob_end_clean();
    $str = str_replace(' ', '&nbsp;', $str);
    echo nl2br("<span style=\"font-family:Tahoma, 굴림; font-size:9pt;\">{$str}</span>");
}

//191125
//현재시간을 초를 소숫점아래 6자리까지 구함
function exactTime()
{
    $time = explode(' ', microtime());
    $time = explode('.', $time[0]);
    $time = substr(date('YmdHis') . $time[1], 0, 20);
    return $time;
}

/**
 * http_build_query와 비슷한 함수 &와 =문자열 대신 다른문자를 지정할수 있음 200111
 *
 * @param array $params
 * @param string $a '&' 문자를 대신할 문자열
 * @param string $b '=' 문자를 대신할 문자열
 * @return  string
 */
function http_build_query2($params, $a = '&', $b = '=')
{
    $result = http_build_query($params);
    $result = str_replace('&', $a, $result);
    $result = str_replace('=', $b, $result);
    return $result;
}

function onlyNumber($str)
{
    return preg_replace('/[^0-9]*/s', '', $str);
}

/**
 * 시간 차이를 간략하게 알려주는 함수
 *
 * @param string 대상 시간
 * @param string 비교 시간
 * @return string
 */
function elapsedTime($datetime, $time = null)
{
    if ($time == null) {
        $time = date('Y-m-d H:i:s');
    }
    if ($datetime == '0000-00-00 00:00:00') {
        $datetime = $time;
    }
    $strto_time = strtotime($time);
    $strto_datetime = strtotime($datetime);
    $aaa = $strto_time - $strto_datetime;

    $unit = '분';
    $bbb = ceil($aaa / 60);
    if ($bbb > 60) {
        $bbb = ceil($bbb / 60);
        $unit = '시간';
        if ($bbb > 24) {
            $bbb = ceil($bbb / 24);
            $unit = '일';
        }
    }
    $result = $bbb . $unit;
    return $result;
}

/**
 * 0으로 자릿수를 맞춰주는 함수
 *
 * @param int 바꿀 수
 * @param int 맞출 자릿수
 * @return string
 */
function zeroPad(int $value, int $digit = 10): string
{
    return str_pad($value, $digit, '0', STR_PAD_LEFT);
}
