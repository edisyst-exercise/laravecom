<?php

namespace App\Livewire;

use App\Mail\Admin\ResetPasswordMail;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class AdminProfileTabs extends Component
{
    public $tab = null;
    public $tabname = 'personal_details';
    protected $queryString = ['tab'];

    public $name, $email, $username, $admin_id;
    public $current_password, $new_password, $new_password_confirmation;

    public function selectTab($tab)
    {
        $this->tab = $tab;
    }

    public function mount()
    {
        $this->tab = request()->tab ? request()->tab : $this->tabname;

        if (Auth::guard('admin')->check()) {
            $admin = Admin::findOrFail(auth()->id());
            $this->admin_id = $admin->id;
            $this->name = $admin->name;
            $this->username = $admin->username;
            $this->email = $admin->email;
        }
    }

    public function updateAdminPersonalDetails()
    {
        $this->validate([
            "name"      => "required|min:5",
            "email"     => "required|email|unique:admins,email," . $this->admin_id,
            "username"  => "required|min:3|unique:admins,username," . $this->admin_id,
        ]);

        Admin::find($this->admin_id)->update([
            "name"      => $this->name,
            "email"     => $this->email,
            "username"  => $this->username,
        ]);

        $this->dispatch('updateAdminSellerHeaderProfileInfo');
        $this->dispatch('updateAdminInfo', [
            "adminName"   => $this->name,
            "adminEmail"  => $this->email,
        ]);

        $this->showToastr("success", "I tuoi dati personali sono stati aggiornati");
    }

    public function updatePassword()
    {
        $this->validate([
            "current_password" => [
                'required', function($attribute, $value, $fail){
                    if (!Hash::check($value, Admin::find(auth('admin')->id())->password)) {
                        return $fail(__('La password non è corretta'));
                    }
                }
            ],
            "new_password"     => "required|min:5|max:50|confirmed"
        ]);

        $query = Admin::findOrFail(auth('admin')->id())->update([
            'password' => Hash::make($this->new_password)
        ]);

        if ($query) {
            $this->current_password = $this->new_password = $this->new_password_confirmation = null;

            $admin = Admin::findOrFail(auth('admin')->id());
            Mail::to($this->email)->send(new ResetPasswordMail($admin, $this->new_password));

            $this->showToastr('success', 'Password aggiornata correttamente');
        } else {
            $this->showToastr('error', 'Password non aggiornata per via di un errore');
        }
    }

    public function showToastr($type, $message)
    {
        return $this->dispatch('showToastr', [
            "type"      => $type,
            "message"   => $message,
        ]);
    }

    public function render()
    {
        return view('livewire.admin-profile-tabs');
    }
}
