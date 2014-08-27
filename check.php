<?php
/*
    CheckDomain
    @author: Tom <tom@awaysoft.com>
    @license: Apache License V2.0
    @descript: A Domain Register Check tool, build by PHP.It can only used in Linux!
            一个使用PHP制作的简单的域名检测工具，它只能运行在Linux系统。
*/
    function exec_command($command) {
        $output = null;
        $result = exec($command, $output);
        if (!$result) {
            return false;
        } else {
            return implode("\n", $output);
        }
    }
    $str  = '0123456789abcdefghijklmnopqrstuvwxyz';
    $len  = 3;
    $exp  = '.com';
    $pre  = '';
    $last = '';

    $arr  = array();
    /* 初始化$arr */
    for ($i = 0; $i < $len; ++$i) {
        array_push($arr, 0);
    }
    $quit = false;

    $exists_domains = array();
    do {
        $domain = $pre;
        for ($i = 0; $i < count($arr); ++$i) {
            $domain .= $str[$arr[$i]];
        }
        $domain .= $last . $exp;
        echo "正在查找(Searching){$domain}：";
        $result = exec_command("whois -n {$domain}");
        if (strpos($result, 'No match for domain') !== false) {
            echo '未注册(No register)';
            array_push($exists_domains, $domain);
        } else {
            echo '已注册(Registerd)';
        }
        echo "\n";

        $arr[count($arr) - 1] ++;
        for ($i = count($arr) - 1; $i >= 0; --$i) {
            if ($arr[$i] >= strlen($str)) {
                if ($i == 0) {
                    $quit = true;
                } else {
                    $arr[$i - 1] ++;
                    $arr[$i] = 0;
                }
            }
        }
    }while(!$quit);

    echo "未注册列表(No Register List)：\n";
    echo implode("\n", $exists_domains);