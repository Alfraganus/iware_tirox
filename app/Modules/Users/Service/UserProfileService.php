<?php

namespace App\Modules\Users\Service;

use App\Models\Setting;
use App\Models\UserDailyActiveness;
use App\Modules\Roadmap\roadmap\service\UserRoadmapLevelService;
use App\Modules\Roadmap\roadmapLesson\models\RoadmapLesson;
use App\Modules\Roadmap\roadmapLesson\models\UserLesssonHistory;
use App\Modules\Roadmap\test\models\RoadmapUserTestHistory;
use App\Modules\Roadmap\test\repository\RoadmapUserTestHistoryRepository;
use App\Modules\Users\repository\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserProfileService
{
    private $userRepository;
    private $roadmapUserTestHistoryRepository;
    protected $userRoadmapLevelService;


    public function __construct(
        UserRepository $userRepository,
        RoadmapUserTestHistoryRepository $roadmapUserTestHistoryRepository,
        UserRoadmapLevelService $userRoadmapLevelService,
        SettingsService $settingsService
    )
    {
        $this->userRepository = $userRepository;
        $this->roadmapUserTestHistoryRepository = $roadmapUserTestHistoryRepository;
        $this->userRoadmapLevelService = $userRoadmapLevelService;
        $this->settingsService = $settingsService;
    }


    public function roadmapProfile()
    {
        $currentRoadmap = $this->currentRoadmap();
        return [
            'currentRoadmap'=>$currentRoadmap,
            'finishedLessons' => $this->getCompletedLessons(),
            'daysInLearning' => $this->getDaysInLearning($currentRoadmap['roadmap_id']),
            'finishedLessonIds' => $this->usersFinishedLessonsId($currentRoadmap['roadmap_id'],$currentRoadmap['lesson_id']),
            'usersProgresss'=>$this->getUserOverallProgressPercentage(),
            'usersTestAveragePercentage'=>$this->getUsersTestAvarage($currentRoadmap['roadmap_id']),
            'chosen_quran_reciter' => $this->settingsService->getSettings('recitation_key')['value']??null
        ];
    }

    private function getUsersTestAvarage($roadmap_id)
    {
        $avaragePercentage = RoadmapUserTestHistory::query()
            ->where('user_id',Auth::id())
            ->where('roadmap_id',$roadmap_id)
            ->avg('percentage');

        return (double) number_format($avaragePercentage,2);
    }

    private function usersFinishedLessonsId($roadmap_id,$lesson_id)
    {
        return UserLesssonHistory::query()
            ->where('roadmap_id',$roadmap_id)
            ->where('lesson_id',$lesson_id)
            ->pluck('lesson_id')
            ->toArray();
    }

    private function getUserAvarageScore($roadmap_id)
    {
        $usersPassedTestCount = RoadmapUserTestHistory::query()
            ->where('user_id',Auth::id())
            ->where('roadmap_id',$roadmap_id)
            ->avg('test_result');

        $userTestHistory = $this->userRoadmapLevelService->getUserScore($roadmap_id);

        $percentage = ($usersPassedTestCount / $userTestHistory['overall_score']) * 100;

        return (int) $percentage;
    }

    private function getUserOverallProgressPercentage()
    {
        $usersPassedTestCount = RoadmapUserTestHistory::query()
            ->where('user_id',Auth::id())
            ->where('is_passed',1)
            ->count();

        $overallLessonsCount = RoadmapLesson::query()->count();

        if ($usersPassedTestCount > 0) {
            $progressPercentage = ($usersPassedTestCount / $overallLessonsCount) * 100;
        } else {
            $progressPercentage = 0;
        }

        return $progressPercentage;
    }

    public function currentRoadmap()
    {
        return $this->userRoadmapLevelService->getUserCurrentRoadmap();
    }

    private function getCompletedLessons()
    {
       return $this->roadmapUserTestHistoryRepository->countByUserId();
    }

    private function getDaysInLearning($roadmap_id)
    {
      return UserDailyActiveness::where('user_id',Auth::id())
          ->where('roadmap_id',$roadmap_id)
          ->count();
    }
}
