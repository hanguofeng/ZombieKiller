<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Daniel
 * Date: 11-9-12
 * Time: 下午6:30
 * To change this template use File | Settings | File Templates.
 */


class ZombieKiller {
    const THRESHOLD = 60;
    private $_strategy_manager = null;
    private $_detail=null;

    public function __construct()
    {
        $this->_strategy_manager = new ZombieKiller_StrategyManager();
    }

    public function detect($root_user,array $users)
    {
        $this->_detail = null;
        
        $remarks = array();
        foreach($users as $user)
        {
            $context = new ZombieKiller_Context($root_user,$user,$users);
            $remark = $this->_remark_user($context);
            $remarks[] = array(
                'userid'    =>  $user->id,
                'userinfo'  =>  $user,
                'result'    =>  new ZombieKiller_Result(
                    $remark[0],
                    $remark[1],
                    $this->_judge_zombies($remark[0])
                ),
            );
        }

        return $remarks;
    }

    private function _remark_user(ZombieKiller_Context $context)
    {
        $strategies = $this->_strategy_manager->get_strategies();
        $detail = array();
        $total_remark = 0;
        foreach($strategies as $strategy)
        {
            $strategy_weight    = $strategy[0];
            $strategy_machine   = $strategy[1];
            $remark  = $strategy_machine->test($context);

            $detail[] = new ZombieKiller_ResultDetail($strategy_machine->get_name(),$strategy_weight,$remark);
            $total_remark += ($strategy_weight * $remark);
        }

        $remark = $total_remark / count($strategies);
		$remark = round($remark);
        return array($remark,$detail);
    }

    private function _judge_zombies($remark)
    {
        return ($remark >= self::THRESHOLD);
    }
}
