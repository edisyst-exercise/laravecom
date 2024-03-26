Video: https://www.youtube.com/playlist?list=PLX4adOBVJXavo3HAHhmf-g2sohn07xXkl


Template: https://github.com/dropways/deskapp


Mail: https://mailtrap.io/


composer dump-autoload


composer require livewire/livewire
php artisan make:livewire counte

`$this->emit` non si usa più per emettere gli eventi, si usa invece:

```php
$this->dispatch('updateAdminInfo', [
    "adminName"   => $this->name,
    "adminEmail"  => $this->email,
]);
```


https://github.com/mberecall/ijaboCropTool
