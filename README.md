Video: https://www.youtube.com/playlist?list=PLX4adOBVJXavo3HAHhmf-g2sohn07xXkl


Template BE: https://github.com/dropways/deskapp
Template FE: https://payhip.com/b/kneBq


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

Per gli asset del BE: https://github.com/mberecall/ijaboCropTool

Per gli slug: https://github.com/cviebrock/eloquent-sluggable

**Riprendere da lez.18**

# Aggiornamenti 
## v0.1.1 
- Ho fatto le sezioni di update **general_settings+social_network** (sono similissimi) e **site_logo+site_favicon** (sono similissime). 
  - probabilmente si può accorciare il codice in tutte quelle: hanno un comportamento uguale a coppie diciamo
- Posso pulire un po' di JS, c'è roba ridondante: dovrei usare solo toastr ma c'è anche qualche alert/msg di altro tipo
- Nel corso si usa Livewire 2 mentre io ho Livewire 3: probabilmente molte opzioni che ho esplicitato si possono togliere perchè nella v.3 diventano di default

## v0.1.2
- Ho fatto la sezione social_network praticamente scopiazzando da general_settings


Devo decidere quale è il content del FE, ma la struttura è pronta. Riprendi da Lez.20

php artisan make:migration add_address_to_general_settings_table --table=general_settings

Per le categorie dovrei rinominare un po' meglio i file, magari le view e anche alcune route: rendere il tutto più breve e leggibile

