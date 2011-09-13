<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Daniel
 * Date: 11-9-12
 * Time: 下午7:50
 * To change this template use File | Settings | File Templates.
 */
 
class ZombieKiller_Strategy_FollowersHasVerify implements ZombieKiller_Strategy_If {

    const THRESHOLD_COUNT       = 2; 
    const THRESHOLD_REMARK      = 60; 
    const DECREASE_RATE         = 5;



    public function get_name()
    {
        return '粉丝中V用户数量';
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

		$his_followers = $this->_get_followers($user->id);
		$count = $this->_get_followers_verify_count($his_followers);

		$diff   = $count - self::THRESHOLD_COUNT;

		$remark = $diff * self::DECREASE_RATE;
		$remark = self::THRESHOLD_REMARK + $remark;

		$remark = $remark < 0 ? 0 : $remark;
		$remark = $remark > 100 ? 100 : $remark;


		$remark = round($remark);
        return $remark;
    }

	private function _get_followers($uid)
	{
		//$weiboclient = ZombieKiller_WeiboClientFactory::create();
		$weibocilent  = new SaeTClient( WB_AKEY , WB_SKEY , $_SESSION['last_key']['oauth_token'] , $_SESSION['last_key']['oauth_token_secret']  );
		$users = array();
		$result = $weibocilent->followers(-1,$uid);
		$users = array_merge($users,$result['users']);
		while($next_cursor=$result['next_cursor'])
		{
			break;
			$result = $weibocilent->followers($next_cursor,$uid);
			$users = array_merge($users,$result['users']);
		}

		return $users;

	}

	private function _get_followers_verify_count($users)
	{
		$cnt = 0;
		foreach($users as $user)
		{
			if($user['verified'])
			{
				$cnt++;
			}
		}
		return $cnt;
	}

}
