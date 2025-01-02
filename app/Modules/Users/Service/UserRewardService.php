<?php

namespace App\Modules\Users\Service;

use App\Models\UserReward;
use App\Modules\Users\repository\UserRepository;

class UserRewardService
{
    private $model;

    public function __construct()
    {
        $this->model = app(UserReward::class);
    }

    public function addReward($user_id, $source)
    {
        $rewardSource = $this->rewardTypes[$source];
        if($rewardSource) {
            $existingReward = $this->model::where('user_id', $user_id)
                ->where('reward_source', $rewardSource)
                ->first();

            if ($existingReward) {
                $existingReward->increment('reward');
            } else {
                $this->model::create([
                    'user_id' => $user_id,
                    'reward' => 1,
                    'reward_source' => $rewardSource,
                ]);
            }
            return Response([
                'msg' =>'User has been rewarded!'
            ]);
        }

    }

    public array $rewardTypes = [
        'quran' => 1,
        'zikr' => 2,
    ];

}
