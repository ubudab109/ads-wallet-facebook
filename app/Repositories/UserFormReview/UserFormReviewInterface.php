<?php

namespace App\Repositories\UserFormReview;

interface UserFormReviewInterface
{
    public function SubmitFormReview(array $data);
    public function UpdateFormReview(array $data, $id);
    public function UpdateFormStatus($status, $id);
    public function GetFormReview($userId);
    public function DetailForm($id);
    public function ListFormPending();
    public function ListFormAccepted();
    public function ListFormRejected();
    public function CountFormPending();
}