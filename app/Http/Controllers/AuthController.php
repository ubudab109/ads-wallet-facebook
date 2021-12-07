<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserVerification;
use App\Repositories\UserVerification\UserVerificationInterface;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public $modelVerification;

    public function __construct(UserVerificationInterface $modelVerification)
    {
        $this->middleware('guest', ['except' => ['logout']]);
        $this->modelVerification = $modelVerification;
    }

    public function login()
    {
        return view('login.main');
    }

    public function registerView()
    {
        return view('auth.register');
    }

    public function forgotPasswordView()
    {
        return view('auth.request-forgot-password');
    }

    public function resenEmailView()
    {
        return view('auth.request-resend-verif');
    }

    /**
     * Login Process
     * @param \Illuminate\Http\Request
     * @return Route
     */
    public function loginProcess(Request $request) 
    {
        $rules = [
            'email'                 => ['required','email'],
            'password'              => ['required'],
        ];
        $message = [
            'email.required'                    => 'Harap mengisi email',
            'email.email'                       => 'Email tidak valid',
            'password.required'                 => 'Harap mengisi password',
        ];

        // if (env('APP_ENV') != 'local') {
        //     $rules['g-recaptcha-response'] = 'required';
        //     $messages['g-recaptcha-response.required'] = 'Harap validasi captcha';
        // }

        $request->validate($rules,$message);
        
        try {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    if ($user->email_verified_at == null) {
                        return redirect()->back()->with('errors', 'Email Anda Belum Terverifikasi. Harap Verifikasi Email Terlebih Dahulu');
                    }
                    $credentials = $request->only('email', 'password');
                    if (Auth::attempt($credentials)) {
                        $request->session()->regenerate();
                        if ($user->roles[0]->name == 'member') {
                            return redirect()->intended(route('dashboard'));
                        } else if ($user->roles[0]->name == 'superadmin') {
                            return redirect()->intended(route('dashboard.admin'));
                        }
                    }
                } else {
                    return redirect()->back()->with('errors', 'Password Salah');
                }
            } 
            
            return redirect()->back()->with('errors', 'Email Tidak Ditemukan');
            
        } catch (\Exception $err) {
            return redirect()->back()->with('errors', $err->getMessage());

        }
    }

    /**
     * Register Process
     * @param \Illuminate\Http\Request
     * @return Route
     */
    public function register(Request $request)
    {
        $rules = [
            'name'          => ['required'],
            'email'         => ['required','email'],
            'password'      =>  [
                'required',
                // 'strong_pass',
                'min:8',             // must be at least 8 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
            ],
            'c_password'    => ['required','min:8','same:password'],
        ];

        $message = [
            'name.required'                     => 'Harap mengisi nama lengkap Anda',
            'email.required'                    => 'Harap mengisi email Anda',
            'email.email'                       => 'Email tidak valid',
            'passowrd.regex'                    => 'Password memiliki setidaknya 1 huruf besar, 1 huruf kecil dan 1 angka',
            'password.min'                      => 'Password minimal 8',
            'c_password.required'               => 'Harap mengisi validasi password',
            'c_password.same'                   => 'Validasi password tidak sama',
        ];

        if (env('APP_ENV') != 'local') {
            $rules['g-recaptcha-response'] = 'required';
            $message['g-recaptcha-response.required'] = 'Harap validasi captcha';
        }
        
        $validator = Validator::make($request->all(), $rules , $message);

        if ($validator->fails()) {
            return redirect()->back()->with('errors',$validator->errors())->withInput($request->input());
        }

        DB::beginTransaction();
        try {
            $input = $request->all();
            $user = User::where('email',$input['email'])->first();
            $input['password'] = Hash::make($request->password);
            if ($user) {
                return redirect()->back()->withInput($request->input())->with('errors','Email telah terdaftar');
            }
            $user = User::create($input);
            $user->assignRole('member');
            $mailKey = $this->modelVerification->GenerateVerification($user->id, generate_email_verification_key());
            if(!empty($user)) {
                $this->sendVerifyemail($user, $mailKey->code);
            } else {
                return redirect()->back()->with('errors','Registrasi Gagal. Mohon untuk diulangi');
            }
            DB::commit();
            return redirect()->back()->with('success','Registrasi Berhasil. Silahkan Periksa Email Anda Untuk Verifikasi');
        } catch(\Exception $err) {
            DB::rollBack();
            return redirect()->back()->with('errors','Registrasi Gagal. Mohon untuk diulangi');
        }
    }

    /**
     * Resend Verification Link Process
     * @param \Illuminate\Http\Request
     * @return Route
     */
    public function resendVerification(Request $request)
    {
        $rules = [
            'email' => ['required','email'],
        ];
        $message = [
            'email.required'                    => 'Harap mengisi email Anda',
            'email.email'                       => 'Email tidak valid',
        ];

        $validator = Validator::make($request->all(), $rules , $message);

        if (env('APP_ENV') != 'local') {
            $rules['g-recaptcha-response'] = 'required';
            $message['g-recaptcha-response.required'] = 'Harap validasi captcha';
        }

        if ($validator->fails()) {
            return redirect()->back()->with('errors',$validator->errors())->withInput($request->input());
        }
        $user = User::where('email',$request->email)->first();
        if ($user) {
            $this->modelVerification->DeleteVerification($user->id);
            $mailKey = $this->modelVerification->GenerateVerification($user->id, generate_email_verification_key());
            $this->sendVerifyemail($user, $mailKey->code);
            return redirect()->back()->with('success','Link Verifikasi Telah Terkirim. Silahkan Periksa Email Anda Untuk Verifikasi');
        } else {
            return redirect()->back()->with('errors','Email Tidak Ditemukan');
        }
    }
    /**
     * Send Verifiy Email Process
     * @param \Illuminate\Http\Request
     * @return null
     */
    public function sendVerifyemail($user, $mail_key)
    {
        $mailService = new MailService();
        $userName = $user->name;
        $userEmail = $user->email;
        $companyName = isset(allsetting()['company_name']) && !empty(allsetting()['company_name']) ? allsetting()['company_name'] : __('Company Name');
        $subject = __('Email Verification | :companyName', ['companyName' => $companyName]);
        $data['data'] = $user;
        $data['key'] = $mail_key;
        $mailService->send('email.verifyWeb', $data, $userEmail, $userName, $subject);
    }

     /**
     * Send Forgot Password Process
     * @param \Illuminate\Http\Request
     * @return null
     */
    public function sendForgotPasswordEmail($user, $mail_key)
    {
        $mailService = new MailService();
        $userName = $user->name;
        $userEmail = $user->email;
        $companyName = isset(allsetting()['company_name']) && !empty(allsetting()['company_name']) ? allsetting()['company_name'] : __('Company Name');
        $subject = __('Forgot Password | :companyName', ['companyName' => $companyName]);
        $data['user'] = $user;
        $data['key'] = $mail_key;
        $mailService->send('email.password_reset', $data, $userEmail, $userName, $subject);

        $data['message'] = 'Mail sent successfully to ' . $user->email . ' with password reset code.';
        $data['success'] = true;
    }

    /**
     * Send Fogot Password Email Process
     * @param \Illuminate\Http\Request
     * @return null
     */
    public function sendForgotPassword(Request $request)
    {
        $rules = [
            'email' => ['required','email'],
        ];
        $message = [
            'email.required'                    => 'Harap mengisi email Anda',
            'email.email'                       => 'Email tidak valid',
        ];
        $validator = Validator::make($request->all(), $rules, $message);

        if (env('APP_ENV') != 'local') {
            $rules['g-recaptcha-response'] = 'required';
            $message['g-recaptcha-response.required'] = 'Harap validasi captcha';
        }

        if ($validator->fails()) {
            return redirect()->back()->with('errors',$validator->errors())->withInput($request->input());
        }
        $user = User::where('email',$request->email)->first();
        if ($user) {
            $getPasswordLink = $this->modelVerification->GetVerificationForgotPasswordUser($user->id);
            if ($getPasswordLink) {
                $this->modelVerification->DeleteVerificationForgotPassword($user->id);
            }
            $mailKey = $this->modelVerification->GenerateVerificationForgotPassword($user->id, generate_email_verification_key());
            $this->sendForgotPasswordEmail($user, $mailKey->code);
            return redirect()->back()->with('success','Link Verifikasi Lupa Password Telah Terkirim. Silahkan Periksa Email Anda Untuk Verifikasi');
        } else {
            return redirect()->back()->with('errors','Email Tidak Ditemukan');
        }
    }


    /**
     * Send Fogot Password Email Process
     * @param \Illuminate\Http\Request
     * @return null
     */
    public function getForgotPasswordLink(Request $request)
    {
        $link = $this->modelVerification->GetVerificationForgotPasswordCode($request->get('token'));
        if ($link) {
            return view('auth.forgot-password');
        } else {
            return redirect()->route('login.view')->with('errors','Link Telah Kadaluarsa');
        }
    }

    /**
     * Verify Link Email Process
     * @param \Illuminate\Http\Request
     * @return null
     */
    public function verifyEmailLink(Request $request)
    {
        $token = $request->get('token');
        $userVerification = $this->modelVerification->GetVerificationEmailCode($token);
        if ($userVerification) {
            $user = User::find($userVerification->user_id);
            $user->update([
                'email_verified_at' => Date::now(),
            ]);
            $this->modelVerification->UpdateStatusVerification($token, VERIFICATION_EMAIL_TYPE);

            return redirect()->route('login.view')->with('success',__('Verifikasi Sukses. Silahkan Login ke Dalam Aplikasi'));
        } else {
            return redirect()->route('login.view')->with('errors',__('Link Verifikasi Telah Kadaluarsa'));
        }
    }

    /**
     * Change Password After Got Verification
     * 
     */
    public function changePasswordNew(Request $request)
    {
        $rules = [
            'password'      =>  [
                'required',
                'min:8',             // must be at least 8 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
            ],
            'c_password'    => ['required','min:8','same:password'],
        ];
        $message = [
            'passowrd.regex'                    => 'Password memiliki setidaknya 1 huruf besar, 1 huruf kecil dan 1 angka',
            'password.min'                      => 'Password minimal 8',
            'c_password.required'               => 'Harap mengisi validasi password',
            'c_password.same'                   => 'Validasi password tidak sama',
        ];

        if (env('APP_ENV') != 'local') {
            $rules['g-recaptcha-response'] = 'required';
            $message['g-recaptcha-response.required'] = 'Harap validasi captcha';
        }

        $validator = Validator::make($request->all(),$rules, $message);
        if ($validator->fails()) {
            return redirect()->back()->with('errors',$validator->errors())->withInput($request->input());
        }

        $userVerification = $this->modelVerification->GetVerificationForgotPasswordCode($request->token_uuid);
        DB::beginTransaction();
        try {
            $user = User::find($userVerification->user_id);
            $user->update([
                'password'  => Hash::make($request->password)
            ]);
            $this->modelVerification->UpdateStatusVerification($request->token_uuid, VERIFICATION_FORGOT_PASSWORD_TYPE);
            // $this->modelVerification->DeleteVerificationForgotPassword($user->user_id);
            DB::commit();
            return redirect()->route('login.view')->with('success',__('Password Berhasil Diubah. Silahkan Login ke Dalam Aplikasi'));
        } catch (\Exception $err) {
            DB::rollBack();
            return redirect()->back()->with('errors',$err->getMessage());
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect()->route('login.view');
    } 
}
