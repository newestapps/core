<?php

if (!function_exists('str_onlyASCII')) {

    /**
     * @param $input
     * @return string
     */
    function str_onlyASCII($input)
    {
        return iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $input);
    }

}

if (!function_exists('str_onlyDigits')) {

    /**
     * @param $input
     * @return string
     */
    function str_onlyDigits($input)
    {
        preg_match_all('/\d+/', $input, $matches);

        return implode('', $matches[0]);
    }

}

if (!function_exists('str_searchable')) {

    /**
     * @param $input
     * @return string
     */
    function str_searchable($input)
    {
        return str_onlyASCII($input);
    }

}


function GerarSeed()
{
}

if (!function_exists('randomSeed')) {

    /**
     * @param $input
     * @return string
     */
    function randomSeed()
    {
        list($usec, $sec) = explode(' ', microtime());

        return (float)$sec + ((float)$usec * 10000);
    }

}

if (!function_exists('createProtocolNumber')) {

    /**
     * @param $input
     * @return string
     */
    function createProtocolNumber()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $data = date('dmY').'.';
        mt_srand(randomSeed());
        $randval = mt_rand(111, 999);
        $randval2 = mt_rand(111, 999);
        $hr = date('s');
        $cod = "$data"."$randval"."$randval2"."$hr";

        return $cod;
    }

}


if (!function_exists('appv')) {
    function appv($v = 0)
    {
        $appVersion = (int)env('APP_VERSION', 0);

        return $appVersion >= $v;
    }
}

if (!function_exists('prettyPhoneNumber')) {
    function prettyPhoneNumber($n)
    {
        if (!is_string($n) || empty($n)) {
            return '';
        }

        $phoneNumberUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $parsed = $phoneNumberUtil->parse($n);
        $phoneNumber = $phoneNumberUtil->format($parsed, \libphonenumber\PhoneNumberType::PERSONAL_NUMBER);

        return $phoneNumber;
    }
}

if (!function_exists('moneyMask')) {
    function moneyMask($value)
    {
        $value /= 100;

        return 'R$ '.number_format($value, 2, ',', '.');
    }
}

if (!function_exists('ownId')) {
    function ownId($id, $namespace = \App\Enum\OwnId::NAMESPACE_CUSTOMER)
    {
        $key = env('OWN_ID_KEY', 'NW');

        return $key.':'.$namespace.':'.$id;
    }
}

if (!function_exists('cleanOwnId')) {

    /**
     * @param $ownId
     * @return array|mixed
     */
    function cleanOwnId($ownId)
    {
        $e = explode(':', $ownId);
        $e = end($e);

        return $e;
    }
}

if (!function_exists('str_replace_first')) {

    /**
     * @param $from
     * @param $to
     * @param $content
     * @return null|string|string[]
     */
    function str_replace_first($from, $to, $content)
    {
        $from = '/'.preg_quote($from, '/').'/';

        return preg_replace($from, $to, $content, 1);
    }
}

if (!function_exists('lc_date')) {

    /**
     * @param DateTime $dateTime
     * @param string $format
     * @return string
     */
    function lc_date(DateTime $dateTime, $format = '%d %B, %Y')
    {
        return strftime($format, strtotime($dateTime->format('Y-m-d H:i:s')));
    }
}


if (!function_exists('colorRGBToHex')) {

    /**
     * @param array $rgb
     * @return string
     */
    function colorDecimalToHex(array $rgb = [])
    {
        return sprintf("#%02x%02x%02x", $rgb[0], $rgb[1], $rgb[2]);
    }
}

if (!function_exists('taxDocumentMask')) {

    /**
     * @param $taxDocument
     * @return string
     */
    function taxDocumentMask($taxDocument)
    {
        if (strlen($taxDocument) === 11) {
            return nw_mask($taxDocument, "###.###.###-##");
        }

        return nw_mask($taxDocument, "##.###.###/####-##");
    }
}

if (!function_exists('getContrastColor')) {

    /**
     * @param $hexColor
     * @return string
     */
    function getContrastColor($hexColor)
    {

        //////////// hexColor RGB
        $R1 = hexdec(substr($hexColor, 0, 2));
        $G1 = hexdec(substr($hexColor, 2, 2));
        $B1 = hexdec(substr($hexColor, 4, 2));

        //////////// Black RGB
        $blackColor = "#000000";
        $R2BlackColor = hexdec(substr($blackColor, 0, 2));
        $G2BlackColor = hexdec(substr($blackColor, 2, 2));
        $B2BlackColor = hexdec(substr($blackColor, 4, 2));

        //////////// Calc contrast ratio
        $L1 = 0.2126 * pow($R1 / 255, 2.2) +
            0.7152 * pow($G1 / 255, 2.2) +
            0.0722 * pow($B1 / 255, 2.2);

        $L2 = 0.2126 * pow($R2BlackColor / 255, 2.2) +
            0.7152 * pow($G2BlackColor / 255, 2.2) +
            0.0722 * pow($B2BlackColor / 255, 2.2);

        $contrastRatio = 0;
        if ($L1 > $L2) {
            $contrastRatio = (int)(($L1 + 0.05) / ($L2 + 0.05));
        } else {
            $contrastRatio = (int)(($L2 + 0.05) / ($L1 + 0.05));
        }

        //////////// If contrast is more than 5, return black color
        if ($contrastRatio > 5) {
            return '#000000';
        } else { //////////// if not, return white color.
            return '#FFFFFF';
        }
    }
}
