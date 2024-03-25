<?php

namespace App\Livewire;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminProfileTabs extends Component
{
    public $tab = null;
    public $tabname = 'personal_details';
    protected $queryString = ['tab'];

    public $name, $email, $username, $admin_id;

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
