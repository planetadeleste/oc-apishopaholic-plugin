<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Cms\Classes\ComponentManager;
use Kharanenka\Helper\Result;
use Lovata\Buddies\Models\User;
use Lovata\OrdersShopaholic\Components\UserAddress;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\User\ItemResource;

class Profile extends Base
{
    public function getModelClass()
    {
        return User::class;
    }

    /**
     * @return \PlanetaDelEste\ApiShopaholic\Classes\Resource\User\ItemResource
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function index()
    {
        return ItemResource::make($this->currentUser());
    }

    /**
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function avatar()
    {
        $this->currentUser();
        $sPath = $this->user->avatar ? $this->user->avatar->path : null;

        return Result::setData(['avatar' => $sPath])->get();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function addAddress()
    {
        return $this->component(UserAddress::class)->onAdd();
    }

    /**
     * @return array
     * @throws \SystemException
     */
    public function updateAddress()
    {
        return $this->component(UserAddress::class)->onUpdate();
    }

    /**
     * @return array
     * @throws \SystemException
     * @throws \Exception
     */
    public function removeAddress()
    {
        return $this->component(UserAddress::class)->onRemove();
    }

    /**
     * @param User  $model
     * @param array $data
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
