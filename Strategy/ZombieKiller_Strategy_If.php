<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Daniel
 * Date: 11-9-12
 * Time: 下午7:49
 * To change this template use File | Settings | File Templates.
 */
 
interface ZombieKiller_Strategy_If
{
    function get_name();
    function test(ZombieKiller_Context $context);
}