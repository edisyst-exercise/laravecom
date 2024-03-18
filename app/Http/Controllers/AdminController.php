<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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


}
