<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserFormReview\UserFormReviewInterface;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormReviewUserController extends Controller
{
    public $userForm;

    public function __construct(UserFormReviewInterface $userForm)
    {
        $this->userForm = $userForm;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->userForm->ListFormPending();
            return response()->json($data, 200);
        }
        return view('pages.admin.form.index');
    }

    public function indexAccepted(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->userForm->ListFormAccepted();
            return response()->json($data, 200);
        }
        return view('pages.admin.form.index-accepted');
    }

    public function indexRejected(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->userForm->ListFormRejected();
            return response()->json($data, 200);
        }
        return view('pages.admin.form.index-rejected');
    }

    public function detailForm(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = $this->userForm->DetailForm($id);
            return response()->json($data, 200);
        }
    }

    public function updateForm(Request $request, $id)
    {   
        DB::beginTransaction();
        try {
            $status = $request->get('status');
            $form = $this->userForm->DetailForm($id);
            $service = new CommonService();
            $service->sendNotifictionToUser($form->user_id, 'Status Konfirmasi Form', 'Pengajuan form Anda telah di '.FormReviewStatus($status));
            if ($status == FORM_REVIEW_ACCEPTED) {
                User::find($form->user_id)->update([
                    'form_status'   => FORM_REVIEW_WAITING_LIST,
                ]);
                $this->userForm->UpdateFormStatus(FORM_REVIEW_WAITING_LIST, $id);
            } else {
                User::find($form->user_id)->update([
                    'form_status'   => $status,
                ]);
                $this->userForm->UpdateFormStatus($status, $id);

            }
            
            DB::commit();
            return response()->json(TRUE, 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json(FALSE, 500);
        }
    }
}
