<?php

namespace App\Repositories\UserBank;

use App\Models\UserBank;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class UserBankReposotiry extends BaseRepository implements UserBankInterface
{
    /**
    * @var ModelName
    */
    protected $model;

    public function __construct(UserBank $model)
    {
      $this->model = $model;
    }

    public function ListBankUser()
    {
      return $this->model->where('user_id', Auth::id())->with('User')->get();
    }

    public function DetailBank($id)
    {
      return $this->model->find($id);
    }

    public function CreateBank(array $data)
    {
      return $this->model->create($data);
    }

    public function UpdateBank($id, array $data)
    {
      return $this->model->find($id)->update($data);
    }

    public function DeleteBank($id)
    {
      return $this->model->find($id)->delete();
    }
}