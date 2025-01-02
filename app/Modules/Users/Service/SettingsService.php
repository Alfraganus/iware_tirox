<?php

namespace App\Modules\Users\Service;

use App\Modules\Users\dto\SettingsDTO;
use App\Modules\Users\repository\SettingsRepository;
use App\Modules\Users\Validations\SettingsValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SettingsService
{
    protected $settingRepository;

    public function __construct(SettingsRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    private function findSettingByUserIdAndKey($userId, $key)
    {
        return $this->settingRepository->findByUserIdAndKey($userId, $key);
    }

    private function getSettingsDTO($request)
    {
        return SettingsDTO::createFromArray($request);
    }

    public function upsertUserSettings(Request $request)
    {
        try {
            $validation = SettingsValidation::userSettings($request);

            if ($validation->fails()) {
                return ['errors' => $validation->errors()->toArray()];
            }

            $settingDTO = $this->getSettingsDTO($request->all());
            $existingSetting = $this->findSettingByUserIdAndKey(Auth::id(), $settingDTO->getKey());
            $message = "";
            if ($existingSetting) {
                $message = "updated";
                $this->settingRepository->updateByUserIdAndKey(Auth::id(), $settingDTO->getKey(), [
                    'value' => $settingDTO->getValue(),
                ]);
            } else {
                $message = "created";
                $this->settingRepository->create([
                    'user_id' =>Auth::id(),
                    'key' => $settingDTO->getKey(),
                    'value' => $settingDTO->getValue(),
                ]);
            }

            return response()->json([
                'message' => sprintf('User settings %s successfully',$message),
                'data' => $this->findSettingByUserIdAndKey(Auth::id(), $settingDTO->getKey())
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateSetting(Request $request)
    {
        try {
            $validation = SettingsValidation::userSettings($request);

            if ($validation->fails()) {
                return response()->json(['errors' => $validation->errors()->toArray()], 422);
            }

            $settingDTO = $this->getSettingsDTO($request->all());

            $existingSetting = $this->findSettingByUserIdAndKey(Auth::id(), $settingDTO->getKey());

            if (!$existingSetting) {
                return response()->json(['error' => 'User with requested setting not found!'], 404);
            }

            $this->settingRepository->updateByUserIdAndKey(Auth::id(), $settingDTO->getKey(), [
                'value' => $settingDTO->getValue(),
            ]);

            return response()->json([
                'message' => 'Setting updated successfully',
                'data' => $this->findSettingByUserIdAndKey(Auth::id(), $settingDTO->getKey())
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getSettings($key)
    {
      return $this->settingRepository->findByUserIdAndKey(Auth::id(),$key);
    }
}
