<?php
//每次导入4分50分钟 每隔5分钟执行一次导入
set_time_limit(0);
require './framework/bootstrap.inc.php';
$max_line = pdo_fetchcolumn("select line from ".tablename('tencent_qq')." order by line desc limit 1");
$handle = fopen("./8e.txt","r");
if ($handle) {
    $start_time = time();
    $end_time = time();
    $num = 0;
    while (($line = fgets($handle)) !== false && ($end_time-$start_time < 290)) {
        $num++;
        if($num > $max_line){
            list($qq,$mobile) = explode('----',$line);
            $data = ['qq'=>$qq,'mobile'=>$mobile,'line'=>$num];
            $result = pdo_insert('tencent_qq',$data);
            //echo "导入".($result>0?'成功':'失败')."第{$num}条数据，QQ号：{$qq}，手机号：{$mobile}";
            echo "<pre>";
            print_r("导入".($result>0?'成功':'失败')."第{$num}条数据，QQ号：{$qq}，手机号：{$mobile}");
            echo "<br/>";
        }
        $end_time = time();
    }
    //print_r("导入中断");
    fclose($handle);

    $end_time = time();

} else {
    // error opening the file.
    exit('文件读取失败');
}
