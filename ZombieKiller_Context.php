<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Daniel
 * Date: 11-9-12
 * Time: 下午6:42
 * To change this template use File | Settings | File Templates.
 */
 
class ZombieKiller_Context {
    private $_root_user = null;
    private $_current_user = null;
    private $_users = array();

    public function __construct($root_user,$user,$users)
    {
        $this->_root_user = $root_user;
        $this->_current_user = $user;
        $this->_users = $users;
    }

    public function get_current_user()
    {
        return $this->_current_user;
    }

     public function get_root_user()
    {
        return $this->_root_user;
    }

    public function get_users()
    {
        return $this->_users;
    }
}
