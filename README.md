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

**Riprendere da lez.18**

# Aggiornamenti 
## v0.1.1 
- Ho fatto le sezioni di update **general_settings+social_network** (sono similissimi) e **site_logo+site_favicon** (sono similissime). 
  - probabilmente si può accorciare il codice in tutte quelle: hanno un comportamento uguale a coppie diciamo
- Posso pulire un po' di JS, c'è roba ridondante: dovrei usare solo toastr ma c'è anche qualche alert/msg di altro tipo
- Nel corso si usa Livewire 2 mentre io ho Livewire 3: probabilmente molte opzioni che ho esplicitato si possono togliere perchè nella v.3 diventano di default

## v0.1.2
- Ho fatto la sezione social_network praticamente scopiazzando da general_settings
