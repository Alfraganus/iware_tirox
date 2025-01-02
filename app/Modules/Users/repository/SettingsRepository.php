<?php

namespace App\Modules\Users\repository;

use App\Models\Setting;
use App\Models\User;

class SettingsRepository
{
    protected $model;

    public function __construct(Setting $model)
    {
        $this->model = $model::query();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
    public function findByUserIdAndKey($userId, $key)
    {
        return $this->model
            ->select(['key','value'])
            ->where('user_id', $userId)
            ->where('key', $key)
            ->first();
    }
    public function updateByUserIdAndKey($userId, $key, array $data)
    {
        return $this->model
            ->where('user_id', $userId)
            ->where('key', $key)
            ->update($data);
    }
    public function update($id, array $data)
    {
        $setting = $this->model->findOrFail($id);
        $setting->update($data);
        return $setting;
    }

    public function delete($id)
    {
        $setting = $this->model->findOrFail($id);
        $setting->delete();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function all()
    {
        return $this->model->get();
    }
}
