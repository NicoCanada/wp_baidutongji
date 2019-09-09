<?php

if( !defined( 'WP_UNINSTALL_PLUGIN')){
    exit;
}

if (false != get_option('baidutongji_id')){
    delete_option('baidutongji_id');
}