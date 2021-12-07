<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormSubmitRequest;
use App\Models\User;
use App\Repositories\UserFormReview\UserFormReviewInterface;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FormReviewController extends Controller
{
    public $userForm;

    public function __construct(UserFormReviewInterface $userForm)
    {
        $this->userForm = $userForm;
    }

    public function index()
    {
        $statusForm = Auth::user()->form_status;
        if ($statusForm == FORM_REVIEW_NOT_APPLICANT) {
            $userForm = $this->userForm->GetFormReview(Auth::id());
        } else {
            $userForm = null;
        }
        return view('pages.user.form.form-review', compact('userForm','statusForm'));
    }


    public function submitForm(FormSubmitRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();

        DB::beginTransaction();
        try {
            $this->userForm->SubmitFormReview($input);
            $user = User::find(Auth::id());
            $user->update([
                'form_status'   => FORM_REVIEW_PENDING
            ]);
            $users = User::role('superadmin')->get();
            $notification = new CommonService();
            
            foreach ($users as $user) {
                $notification->sendNotifictionToUser($user->id, 'Pengajuan Form', 'User '. Auth::user()->email. ' telah melakukan pengajuan form');
            }
            DB::commit();
            return redirect()->back()->with('success','Form telah diajukan. Harap menunggu konfirmasi Admin');
        } catch (\Exception $err) {
            DB::rollBack();
            dd($err->getMessage());
        }
    }
}
