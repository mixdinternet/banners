## Banners

[![Total Downloads](https://poser.pugx.org/mixdinternet/banners/d/total.svg)](https://packagist.org/packages/mixdinternet/banners)
[![Latest Stable Version](https://poser.pugx.org/mixdinternet/banners/v/stable.svg)](https://packagist.org/packages/mixdinternet/banners)
[![License](https://poser.pugx.org/mixdinternet/banners/license.svg)](https://packagist.org/packages/mixdinternet/banners)

![Área administrativa](http://www.mixd.com.br/github/1aaa774722af7e42241b4ed49fd2ebe5.png "Área administrativa")

Pacote de banners.

## Instalação

Adicione no seu composer.json

```js
  "require": {
    "mixdinternet/banners": "0.2.*"
  }
```

ou

```js
  composer require mixdinternet/banners
```

## Service Provider

Abra o arquivo `config/app.php` e adicione

`Mixdinternet\Banners\Providers\BannersServiceProvider::class`

## Migrations

```
  php artisan vendor:publish --provider="Mixdinternet\Banners\Providers\BannersServiceProvider" --tag="migrations"`
  php artisan migrate
```

## Configurações

É possivel a troca de icone e nomenclatura do pacote em `config/mbanners.php`

```
  php artisan vendor:publish --provider="Mixdinternet\Banners\Providers\BannersServiceProvider" --tag="config"`
```