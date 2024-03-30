<?php

namespace App\Http\Controllers;

use App\Mail\Admin\ForgotPasswordMail;
use App\Mail\Admin\ResetPasswordMail;
use App\Models\Admin;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use ConstDefaults;
use ConstGuards;

class AdminController extends Controller
{
    public function loginHandler(Request $request)
    {
        $fieldType = filter_var($request->login_id,FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if ($fieldType == 'email')
        {
            $request->validate([
                'login_id' => 'required|email|exists:admins,email',
                'password' => 'required|min:5|max:45'
            ], [
                'login_id.required' => 'Email o Username obbligatorio',
                'login_id.email'    => 'Indirizzo email non valido',
                'login_id.exists'   => 'Indirizzo email non presente nel sistema',
                'password.required' => 'Password obbligatoria'
            ]);
        }
        else {
            $request->validate([
                'login_id' => 'required|exists:admins,username',
                'password' => 'required|min:5|max:45'
            ], [
                'login_id.required' => 'Email o Username obbligatorio',
                'login_id.exists'   => 'Username non presente nel sistema',
                'password.required' => 'Password obbligatoria'
            ]);
        }

        $creds = array(
            $fieldType => $request->login_id,
            'password' => $request->password,
        );

        if (Auth::guard('admin')->attempt($creds))
        {
            return redirect()->route('admin.home');
        }
        else {
            session()->flash('fail', 'Credenziali errate');
            return redirect()->route('admin.login');
        }
    }

    public function logoutHandler(Request $request)
    {
        Auth::guard('admin')->logout();
        session()->flash('fail', 'Hai fatto logout!');
        return redirect()->route('admin.login');
    }

    public function sendPasswordResetLink(Request $request)
    {
        $request->validate([
           "email" => "required|email|exists:admins,email"
        ],[
            "email.required" => "Campo :attribute obbligatorio",
            "email.email"    => "Campo :attribute deve essere nel formato email",
            "email.exists"   => "Campo :attribute non esiste nel sistema",
        ]);

        // Get admin details
        $admin = Admin::where('email', $request->email)->first();

        // Generate new token
        $token = base64_encode(Str::random(64));

        // Check if there is an existing reset password token
        $oldToken = DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'guard' => ConstGuards::ADMIN
            ])
            ->first();

        if ($oldToken) // update token
        {
            DB::table('password_reset_tokens')
                ->where([
                    'email' => $request->email,
                    'guard' => ConstGuards::ADMIN
                ])
                ->update([
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
        }
        else // add new token
        {
            DB::table('password_reset_tokens')
                ->insert([
                    'email' => $request->email,
                    'guard' => ConstGuards::ADMIN,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
        }

        // Create action link
        $actionLink = route('admin.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);

        // Send email
        if (Mail::to($admin->email)->send(new ForgotPasswordMail($admin->name, $actionLink)))
        {
            session()->flash('success', "Ti abbiamo mandato il link per il reset password");
            return redirect()->route('admin.forgot-password');
        }
        else
        {
            session()->flash('fail', "Qualcosa è andato storto");
            return redirect()->route('admin.forgot-password');
        }
    }

    public function resetPassword(Request $request, $token = null)
    {
        $check_token = DB::table('password_reset_tokens')
            ->where([
                'token' => $token,
                'guard' => ConstGuards::ADMIN,
                ])
            ->first();

        if ($check_token) {
            //check expired token
            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $check_token->created_at)->diffInMinutes(Carbon::now());

            if ($diffMins > ConstDefaults::tokenExpiredMinutes) {
                session()->flash('fail', "Token scaduto, fai il reset password");
                return redirect()->route('admin.forgot-password', ['token' => $token]);
            } else {
                return view('back.pages.admin.auth.reset-password', ['token' => $token]);
            }
        } else {
            session()->flash('fail', "Token non valido, fai il reset password");
            return redirect()->route('admin.forgot-password', ['token' => $token]);
        }
    }

    public function resetPasswordHandler(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:5|max:45|required_with:new_password_confirmation|same:new_password_confirmation',
            'new_password_confirmation' => 'required',
        ]);

        // Get token
        $token = DB::table('password_reset_tokens')
            ->where([
                'token' => $request->token,
                'guard' => ConstGuards::ADMIN,
            ])
            ->first();

        //Get Admin
        $admin = Admin::where('email', $token->email)->first();

        //Update Admin
        Admin::where('email', $admin->email)->update([
            'password' => Hash::make($request->new_password)
        ]);

        //Delete token
        DB::table('password_reset_tokens')
            ->where([
                'email' => $admin->email,
                'token' => $request->token,
                'guard' => ConstGuards::ADMIN,
            ])
            ->delete();

        //Send email to notify admin
        if (Mail::to($admin->email)->send(new ResetPasswordMail($admin, $request->new_password)))
        {
            return redirect()->route('admin.login')
                ->with('success', 'La tua password è stata modificata');
        }
        else
        {
            session()->flash('fail', "Qualcosa è andato storto");
            return redirect()->route('admin.forgot-password');
        }
    }

    public function profileView(Request $request)
    {
        $admin = null;

        if ( Auth::guard('admin')->check() ) {
            $admin = Admin::findOrFail(auth()->id());
        }

        return view('back.pages.admin.profile', compact('admin'));
    }

    public function changeProfilePicture(Request $request)
    {
        $admin = Admin::findOrFail(auth('admin')->id());
        $path = "images/users/admins/";
        $old_picture = $admin->getAttributes()['picture'];

        $file = $request->file('adminProfilePictureFile');
        $filename = "ADMIN_IMG_" . rand(2, 1000) . $admin->id . time() . uniqid() . ".jpg";
        $upload = $file->move(public_path($path), $filename);

        if ($upload) {
            if ($old_picture != null && File::exists(public_path($path . $old_picture))) {
                File::delete(public_path($path. $old_picture));
            }
            $admin->update(['picture' => $filename]);
            return response()->json(['status' => 1, 'msg' => 'Immagine aggiornata']);
            // FUNZIONA TUTTO PERO' QUESTA IMMAGINE NON LA AGGIORNA IN TEMPO REALE
        } else {
            return response()->json(['status' => 0, 'msg' => 'Qualcosa è andato storto']);
        }
    }

    public function changeLogo(Request $request)
    {
        $path = 'images/site/';
        $file = $request->file('site_logo');
        $settings = new GeneralSetting();
        $old_logo = $settings->first()->site_logo;
        $file_path = $path . $old_logo;
        $filename = 'LOGO_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $upload = $file->move(public_path($path), $filename);

        if ($upload) {
            if ($old_logo != null && File::exists(public_path($path), $old_logo)) {
                File::delete(public_path($path.$old_logo));
            }
            $settings = $settings->first();
            $settings->site_logo = $filename;
            $update = $settings->save();

            return response()->json([
                'status' => 1,
                'msg'    => 'Logo del sito modificato correttamente',
            ]);

        } else {
            return response()->json([
                'status' => 0,
                'msg'    => 'Logo non modificato, ci sono stati errori',
            ]);
        }
    }

    public function changeFavicon(Request $request)
    {
        $path = 'images/site/';
        $file = $request->file('site_favicon');
        $settings = new GeneralSetting();
        $old_favicon = $settings->first()->site_favicon;
//        $file_path = $path . $old_favicon; //lui questa volta non lo mette
        $filename = 'FAV_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $upload = $file->move(public_path($path), $filename);

        if ($upload) {
            if ( $old_favicon != null && File::exists(public_path($path.$old_favicon)) ) {
                File::delete(public_path($path.$old_favicon));
            }
            $settings = $settings->first();
            $settings->site_favicon = $filename;
            $update = $settings->save();

            return response()->json([
                'status' => 1,
                'msg'    => 'site_favicon del sito modificato correttamente',
            ]);

        } else {
            return response()->json([
                'status' => 0,
                'msg'    => 'site_favicon non modificato, ci sono stati errori',
            ]);
        }
    }


}



























