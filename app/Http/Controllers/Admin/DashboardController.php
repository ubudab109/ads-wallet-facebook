<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserFormReview\UserFormReviewInterface;
use App\Repositories\UserTopupBalance\UserTopupBalanceInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public $form, $topup;
    public function __construct(UserFormReviewInterface $form, UserTopupBalanceInterface $topup)
    {
        $this->form = $form;
        $this->topup = $topup;
    }


    public function index()
    {
        $userSaldo = User::sum('balance');
        $formPending = $this->form->CountFormPending();
        $topupPending = $this->topup->CountPendingTopup();
        $totalAkunAd = User::where('form_status',FORM_REVIEW_WAITING_LIST)->count();

        return view('pages.admin.dashboard',compact('userSaldo','formPending','topupPending','totalAkunAd'));
    }
}
