<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Lovata\Buddies\Models\User;

class Profile extends Base
{
    public function getModelClass()
    {
        return User::class;
    }

    /**
     * @param User $model
     * @param array  $data
     *
     * @return mixed
     */
    protected function save($model, $data)
    {
        $model->rules['password'] = 'required:create|between:8,255|confirmed';
        $model->rules['password_confirmation'] = 'required_with:password|between:8,255';

        $model->fill($data);
        return $model->save();
    }
}
