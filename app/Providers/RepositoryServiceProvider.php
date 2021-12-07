<?php

namespace App\Providers;

use App\Repositories\Admin\AdminBankInterface;
use App\Repositories\Admin\AdminBankRepository;
use App\Repositories\AdminSetting\AdminSettingInterface;
use App\Repositories\AdminSetting\AdminSettingRepository;
use App\Repositories\RefundUser\RefundUserInterface;
use App\Repositories\RefundUser\RefundUserRepository;
use App\Repositories\Ticket\OpenTicketInterface;
use App\Repositories\Ticket\OpenTicketRepistory;
use App\Repositories\UserBank\UserBankInterface;
use App\Repositories\UserBank\UserBankReposotiry;
use App\Repositories\UserFormReview\UserFormReviewInterface;
use App\Repositories\UserFormReview\UserFormReviewRepository;
use App\Repositories\UserTopupBalance\UserTopupBalanceInterface;
use App\Repositories\UserTopupBalance\UserTopupBalanceRepository;
use App\Repositories\UserVerification\UserVerificationInterface;
use App\Repositories\UserVerification\UserVerificationRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserVerificationInterface::class, UserVerificationRepository::class);
        $this->app->bind(UserFormReviewInterface::class, UserFormReviewRepository::class);
        $this->app->bind(UserTopupBalanceInterface::class, UserTopupBalanceRepository::class);
        $this->app->bind(AdminBankInterface::class, AdminBankRepository::class);
        $this->app->bind(AdminSettingInterface::class, AdminSettingRepository::class);
        $this->app->bind(RefundUserInterface::class, RefundUserRepository::class);
        $this->app->bind(UserBankInterface::class, UserBankReposotiry::class);
        $this->app->bind(OpenTicketInterface::class, OpenTicketRepistory::class);
        
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind(UserVerificationInterface::class, UserVerificationRepository::class);

    }
}
