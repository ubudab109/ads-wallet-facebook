<?php

namespace App\Repositories\Admin;

interface AdminBankInterface
{
    public function ListBankAdmin();
    public function UpdateBankAdmin($id, array $data);
    public function GetDetailBankAdmin($id);
    public function CreateBankAdmin(array $data);
    public function DeleteBankAdmin($id);
}