<?php
/**
 * 获取客户ip
 */

function get_ip() {
    if (getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if(getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if(getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");
    else $ip = "Unknow";
    return $ip; 
}


/**
 * 获取 referer
 */
function get_referer() {
    return isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : 'unknow';
}


/**
 * 向数据库写入一条记录
 */
function my_add_tel_log() {
    $option_name = "statistics-tel-" . date("Ym");

    $test = array(
        "date" => date("Y-m-d H:i:s"),
        "ip" => get_ip(),
        "referer" => get_referer(),
    );

    $ans = get_option($option_name);

    if(!$ans) {
       $tmp = array( $test ); 
       $ans  = add_option($option_name,$tmp, '', false );
       return true;
    }


    if( array_push($ans, $test) &&  update_option($option_name, $ans)) {
        return true;
    } else {
        return false;
    }

}


/**
 * 打印表格
 */ 
function show_statistics_tel_table() {
    // 加载一个样式


    if(!isset($_GET['show'])) {
        echo "暂无信息"; 
        return ;
    }

    //$date = $_GET['show'] ? $_GET['show'] :  date("Ym");

    // ?? 前面的变量不存在的时候，返回后者
    $date = $_GET['show'] ?? date("Ym");
    if(!$data) $date = date("Ym");

    $data = get_option("statistics-tel-$date");
    display_statistics_tel_table($data);

}



function display_statistics_tel_table($data) { ?>
<h1>点击电话拨号的统计</h1>
<table class="statistics-tel" cellspacing=0>
    <thead>
    </thead>

    <tfoot>
    </tfoot>

    <tbody>
        <tr><td>编号</td><td>点击时间</td><td>点击页面</td><td>访问ip</td></tr>
<?php foreach($data as $k => $v): ?> 
        <tr><td><?= $k+1; ?><td><?=$v['date']; ?></td><td><?= $v['referer']; ?></td><td><?= $v['ip']; ?></td></tr>
<?php endforeach ?>
    </tbody>
</table>
<?php }
