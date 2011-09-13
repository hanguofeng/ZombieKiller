<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Daniel
 * Date: 11-9-12
 * Time: 下午7:49
 * To change this template use File | Settings | File Templates.
 */
 
class ZombieKiller_StrategyManager {

    private $_strategies = array();

    public function __construct()
    {
        $this->_strategies[]= array(0.5,new ZombieKiller_Strategy_UserCreateTime());
        $this->_strategies[]= array(1,new ZombieKiller_Strategy_FollowersCount());
        $this->_strategies[]= array(0.5,new ZombieKiller_Strategy_FollowersVsFriends());
		$this->_strategies[]= array(1,new ZombieKiller_Strategy_MyFriendFollows());
		$this->_strategies[]= array(1,new ZombieKiller_Strategy_UserInfo());
		$this->_strategies[]= array(1,new ZombieKiller_Strategy_FollowersHasVerify());
		
		
    }

    public function get_strategies()
    {
        return $this->_strategies;
    }
}
