<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Daniel
 * Date: 11-9-12
 * Time: 下午7:50
 * To change this template use File | Settings | File Templates.
 */
 
class ZombieKiller_Strategy_UserCreateTime implements ZombieKiller_Strategy_If {

    const THRESHOLD_DATE        = 15552000; //半年
    const THRESHOLD_REMARK      = 40; //半年
    const DECREASE_RATE         = 0.1;

    const SPECIAL_TIME          = 7;
    const SPECIAL_REMARK        = 90;


    public function get_name()
    {
        return '注册时间';
    }

    /**
     * 算法说明:根据用户注册时间来判断
     *         以半年为中点，此时打分值为THRESHOLD_REMARK
     *         注册时间每增加或减少一天，打分值减少或增加DECREASE_RATE
     *         另外加入特殊处理，最近SPECIAL_TIME天注册的，打分值恒定为SPECIAL_REMARK
     */
    public function test(ZombieKiller_Context $context)
    {
        $user = $context->get_current_user();
        $create_time = $user->create_time;
        $time_diff = (time() - $create_time);

        if($time_diff < (86400 * self::SPECIAL_TIME))    //最近一周注册打分值恒定为90
        {
            $remark = self::SPECIAL_REMARK;
        }
        else
        {
            $time_diff = self::THRESHOLD_DATE - $time_diff;

            $remark = ($time_diff/86400) * self::DECREASE_RATE;
            $remark = self::THRESHOLD_REMARK + $remark;

            $remark = $remark < 0 ? 0 : $remark;
            $remark = $remark > 100 ? 100 : $remark;
        }

		$remark = round($remark);
        return $remark;
    }

}
