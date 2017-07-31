<?php
class Html extends Fuel\Core\Html
{
    public static function hsc($text, $charset='UTF-8')
    {
        return htmlspecialchars($text, ENT_QUOTES, $charset);
    }


    /**
     * バイト数をフォーマットする
     * @param integer $bytes
     * @param integer $precision
     * @param array $units
     */
    public static function formatBytes($bytes, $precision = 2, array $units = null)
    {
        if (abs($bytes) < 1024)
        {
            $precision = 0;
        }

        if (is_array($units) === false)
        {
            $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        }

        if ($bytes < 0)
        {
            $sign = '-';
            $bytes = abs($bytes);
        }
        else
        {
            $sign = '';
        }

        $exp   = floor(log($bytes) / log(1024));
        $unit  = $units[$exp];
        $bytes = $bytes / pow(1024, floor($exp));
        $bytes = sprintf('%.'.$precision.'f', $bytes);
        return $sign.$bytes.' '.$unit;
    }


    /**
     * YouTube の URL を分解してIDを抽出する
     * show how to use them.
     *
     * @access  public
     * @return  Response
     */
    public static function parseYoutubeUrl($str)
    {
        // 短縮形 URL
        if (preg_match('/http.*:\/\/youtu\.be/', $str))
        {
            return preg_replace('/http.*:\/\/youtu\.be\//', '', $str);
        }
        // 標準 URL
        else
        {
            $tmp = explode('?', $str);
            $tmp = explode('&', $tmp['1']);

            foreach ($tmp as $t)
            {
                $t = explode('=', $t);
                if ($t['0'] === 'v')
                {
                    return $t['1'];
                }
            }
            
        }
    }


}

