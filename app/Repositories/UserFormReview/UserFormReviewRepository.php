<?php

namespace App\Repositories\UserFormReview;

use App\Models\FormReview;
use App\Repositories\BaseRepository;

class UserFormReviewRepository extends BaseRepository implements UserFormReviewInterface
{
    /**
    * @var ModelName
    */
    protected $model;

    public function __construct(FormReview $model)
    {
      $this->model = $model;
    }

    public function SubmitFormReview(array $data)
    {
      return $this->model->create($data);
    }

    public function UpdateFormReview(array $data, $id)
    {
      $form = $this->model->find($id);
      $form->update($data);
      return $form;
    }

    public function UpdateFormStatus($status, $id)
    {
      return $this->model->find($id)->update(['status' => $status]);
    }

    public function GetFormReview($userId)
    {
      return $this->model->where('user_id',$userId)->first();
    }

    public function DetailForm($id)
    {
      return $this->model->find($id);
    }

    public function ListFormPending()
    {
      return $this->model->with('user')->where('status', FORM_REVIEW_PENDING)->get();
    }

    public function ListFormAccepted()
    {
      return $this->model->with('user')->where('status', FORM_REVIEW_ACCEPTED)->orWHere('status', FORM_REVIEW_WAITING_LIST)->get();
    }

    public function ListFormRejected()
    {
      return $this->model->with('user')->where('status', FORM_REVIEW_REJECTED)->get();
      
    }

    public function CountFormPending()
    {
      return $this->model->where('status', FORM_REVIEW_PENDING)->count();
    }
}