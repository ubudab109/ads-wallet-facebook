<?php

namespace App\Repositories\Admin;

use App\Models\AdminBank;
use App\Repositories\BaseRepository;

class AdminBankRepository extends BaseRepository implements AdminBankInterface
{
    /**
    * @var ModelName
    */
    protected $model;

    public function __construct(AdminBank $model)
    {
      $this->model = $model;
    }

    public function ListBankAdmin()
    {
      return $this->model->get();
    }

    public function GetDetailBankAdmin($id)
    {
      return $this->model->find($id);
    }

    public function UpdateBankAdmin($id, array $data)
    {
      return $this->model->find($id)->update($data);
    }

    public function CreateBankAdmin(array $data)
    {
      return $this->model->create($data);
    }

    public function DeleteBankAdmin($id)
    {
      return $this->model->find($id)->delete();
    }
}