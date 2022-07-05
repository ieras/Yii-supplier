<?php

namespace app\utils;


class ExcelUtil extends BaseUtil
{
    /**
     * 导出文件.
     * @param $file
     * @param $title
     * @param $data
     */
    public function export($file, $title, $data)
    {
        header("Content-Disposition:attachment;filename=".$file);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        ob_start();
        $wrstr = $title;//表头
        $wrstr .= $data;//内容
        $wrstr = iconv("utf-8", "GBK//ignore", $wrstr);
        ob_end_clean();
        echo $wrstr;die;
    }
}
