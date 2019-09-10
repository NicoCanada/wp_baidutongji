<?php 
/**
 * Plugin Name: VIPdaigou Baidu Tongji
 * Plugin URI: http://vipdaigou.cn
 * Description: Vippay Payment, Receive Chinese Yuan (CNY￥) get Canadian Dollar (CAD$) 
 * Version: 1.0
 * Author: http://vipdaigou.cn
 * Author URI: http://vipdaigou.cn
 * 
 */

class VIPdaigou_baidutongji{
    function __construct()
    {
        add_action( 'wp_head', array($this, 'vipdaigou_add_baidu_tongji_script'));
        register_activation_hook(__FILE__, array($this, 'vipdaigou_baidutongji_default_id'));
        add_action( 'admin_menu', array($this, 'vipdaigou_baidutongji_admin_menu'));
        add_action( 'admin_init', array($this, 'vipdaigou_baidutongji_admin_init'));
    }

    function vipdaigou_baidutongji_admin_init()
    {
        add_action('admin_post_save_baidutongji_options', array($this, 'process_baidutongji_id'));
    }

    function process_baidutongji_id()
    {
        if(!current_user_can('manage_options'))
        {
            wp_die('Not Allowed');
        }
        check_admin_referer('baidutongji_id');

        $option = get_option('baidutongji_id');

        if( isset($_POST['baidutongji_id']))
        {
            $option = sanitize_text_field($_POST['baidutongji_id']);
            update_option('baidutongji_id', $option);
        }

        wp_redirect(add_query_arg('page', 'vipdaigou_baidutongji', admin_url('options-general.php')));
        exit;
    }

    function vipdaigou_baidutongji_default_id()
    {
        if( false === get_option('baidutongji_id')){
            add_option( 'baidutongji_id', '0000');
        }
    }

    function vipdaigou_baidutongji_admin_menu()
    {
        add_menu_page('VIPdaigou BaiduTongji Configuration Page',
                      'Baidu Tongji', 'manage_options',
                      'vipdaigou_baidutongji',
                      array($this, 'vipdaigou_baidutongji_config_page') );
    }

    function vipdaigou_baidutongji_config_page()
    {
        $baidutongji_id = get_option('baidutongji_id');
        ?>
        <div>
            <h2>VIPDaigou Baidu Tongji Options</h2>
            <form action="admin-post.php" method="post">
                <input type="hidden" name="action" id="save_baidutongji_options" value="save_baidutongji_options">
                <?php wp_nonce_field('baidutongji_id'); ?>
                Baidu Tongji Id: <input type="text" name="baidutongji_id" id="baidutongji_id" value="<?php echo esc_html($baidutongji_id); ?>"/><br/>
                <input type="submit" value="Submit" class='button-primary'/>
            </form>
        </div>
        <?php
    }

    function vipdaigou_add_baidu_tongji_script()
    {
        ?>
        <script>
            var _hmt = _hmt || [];
            (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?<?php echo get_option('baidutongji_id') ?>";
            var s = document.getElementsByTagName("script")[0]; 
            s.parentNode.insertBefore(hm, s);
            })();
        </script>
        <?php 
    }
}

$baidutongji = new VIPdaigou_baidutongji();



