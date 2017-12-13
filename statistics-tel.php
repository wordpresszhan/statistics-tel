<?php
/*
Plugin Name: satistics tel
Plugin URI: https://www.wordpresszhan.com
Description: 统计电话的点击量, 当用户通过手机端点击通话的时候，通过ajax后台更新数据
Version: 0.0.1
Author: wordpresszhan
Author URI: https://www.wordpresszhan.com
License: GPLv2 or later
Text Domain: wordpresszhan
*/


/**
 * 使用方法
 *
 $("#tel").click(function () {
     jQuery.post("<?php echo admin_url( 'admin-ajax.php' ); ?>", {
         "action" : "statistics_tel"
     }, function (response) {
         console.log(response);
     })   
 });
 * 
 */

date_default_timezone_set('PRC');
include_once __DIR__ . '/my_functions.php';



add_action( 'admin_print_scripts', function () {
    //wp_register_style('statistics-tel', plugin_dir_url('css.css'));
    //wp_enqueue_style('statistics-tel', plugin_dir_url('css.css'));
    wp_enqueue_style('statistics-tel', plugin_dir_url(__FILE__) . 'css.css');
} );


// 加载一个样式


add_action('admin_menu', function () {
    add_theme_page(
        "产看统计",
        "产看统计",
        "administrator",
        "statistics-tel",
        function () {
            show_statistics_tel_table();
        }
    );

});





// 非登陆用户
add_action('wp_ajax_nopriv_statistics_tel', function () {
    my_add_tel_log();    
});


// 登陆用户
add_action('wp_ajax_statistics_tel', function () {
    my_add_tel_log();    
});








