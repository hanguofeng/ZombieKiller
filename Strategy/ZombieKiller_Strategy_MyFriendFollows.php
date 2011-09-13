<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Daniel
 * Date: 11-9-12
 * Time: 下午7:50
 * To change this template use File | Settings | File Templates.
 */
 
class ZombieKiller_Strategy_MyFriendFollows implements ZombieKiller_Strategy_If {

    const THRESHOLD_COUNT       = 8; 
    const THRESHOLD_REMARK      = 50; 
    const DECREASE_RATE         = 3;

    const SPECIAL_COUNT         = 20;
    const SPECIAL_REMARK        = 10;


    public function get_name()
    {
        return '我关注的人关注他';
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
        $followers_count = $user->followers_count;
		$root_user = $context->get_root_user();

		$my_friends = $this->_get_friends($root_user);
		$his_followers = $this->_get_followers($user->id);
		$same_people_count = count(array_intersect($my_friends,$his_followers));

        if($same_people_count >= self::SPECIAL_COUNT)    //我的好友里面有SPECIAL_COUNT以上都关注他，就不像僵尸粉了
        {
            $remark = self::SPECIAL_REMARK;
        }
        else
        {
            $diff   = $same_people_count - self::THRESHOLD_COUNT;

            $remark = $diff * self::DECREASE_RATE;
            $remark = self::THRESHOLD_REMARK - $remark;

            $remark = $remark < 0 ? 0 : $remark;
            $remark = $remark > 100 ? 100 : $remark;
        }

		$remark = round($remark);
        return $remark;
    }

	private function _get_followers($uid)
	{
		//$weiboclient = ZombieKiller_WeiboClientFactory::create();
		$weibocilent  = new SaeTClient( WB_AKEY , WB_SKEY , $_SESSION['last_key']['oauth_token'] , $_SESSION['last_key']['oauth_token_secret']  );
		$users = array();
		$result = $weibocilent->followers_ids(-1,200,$uid);
		$users = array_merge($users,$result['ids']);
		while($next_cursor=$result['next_cursor'])
		{
			break;
			$result = $weibocilent->followers_ids($next_cursor,200,$uid);
			$users = array_merge($users,$result['ids']);
		}

		return $users;

	}

	private function _get_friends($uid)
	{
		//$weiboclient = ZombieKiller_WeiboClientFactory::create();
		$weibocilent  = new SaeTClient( WB_AKEY , WB_SKEY , $_SESSION['last_key']['oauth_token'] , $_SESSION['last_key']['oauth_token_secret']  );
		$users = array();
		$result = $weibocilent->friends_ids(-1,200,$uid);
		$users = array_merge($users,$result['ids']);
		while($next_cursor=$result['next_cursor'])
		{
			break;
			$result = $weibocilent->friends_ids($next_cursor,200,$uid);
			$users = array_merge($users,$result['ids']);
		}
		$users = array_unique($users);
		return $users;
	}

}
