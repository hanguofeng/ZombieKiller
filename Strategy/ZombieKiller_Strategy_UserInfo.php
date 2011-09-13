<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Daniel
 * Date: 11-9-12
 * Time: 下午7:50
 * To change this template use File | Settings | File Templates.
 */
 
class ZombieKiller_Strategy_UserInfo implements ZombieKiller_Strategy_If {

    public function get_name()
    {
        return '个人资料';
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

		$remark = 50;

		if($user->verified)
		{
			$remark += 100000;
		}

		if(strlen($user->domain)>1)
		{
			$remark += 10;
		}

		if(strlen($user->description) > 100)
		{
			$remark += 10;
		}


		$remark = $remark < 0 ? 0 : $remark;
		$remark = $remark > 100 ? 100 : $remark;

		$remark = round($remark);
        return $remark;
    }

}
