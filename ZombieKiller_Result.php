<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Daniel
 * Date: 11-9-12
 * Time: 下午9:53
 * To change this template use File | Settings | File Templates.
 */
 
class ZombieKiller_Result {
    private $_score;
    private $_detail;
    private $_is_zombie;

    public function __construct($score,$detail,$is_zombie)
    {
        $this->_score       = $score;
        $this->_detail      = $detail;
        $this->_is_zombie   = $is_zombie;
    }

    public function get_score()
    {
        return $this->_score;
    }

    public function get_detail()
    {
        return $this->_detail;
    }

    public function get_is_zombie()
    {
        return $this->_is_zombie;
    }
}

class ZombieKiller_ResultDetail
{
    private $_strategy_name;
    private $_weight;
    private $_score;

    public function __construct($strategy_name,$weight,$score)
    {
        $this->_strategy_name   = $strategy_name;
        $this->_weight          = $weight;
        $this->_score           = $score;
    }


    public function get_score()
    {
        return $this->_score;
    }

    public function get_weight()
    {
        return $this->_weight;
    }

     public function get_strategy_name()
    {
        return $this->_strategy_name;
    }
}
