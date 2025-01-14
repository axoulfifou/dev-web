<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## démarche pour visualiser travail extérieur

1. Vérifier l’accès au repo git distant puis cloner ce dernier :

```bash
git clone <url_repo_git>
```

1. Copier le fichier .env de notre environnement Laravel dans le dossier cloné si il n’y est pas :

```bash
cp .env.example <chemin_vers_le_dossier_cloné/.env>
```

1. Lancer le gestionnaire **Composer** pour installer les dépendances dans le répertoire `vendor` de votre projet local 

```bash
docker run --rm --interactive --tty --volume $PWD:/app composer install
```

1. Lancer cette commande pour démarrer l’environnement Docker configuré spécialement pour  Laravel

```bash
./vendor/bin/sail up -d
```

1. On va ensuite faire la migration de donnée :

```bash
./vendor/bin/sail artisan migrate
```

1. On peut ensuite tester en tapant l'url suivante dans le navigateur :

```bash
http://127.0.0.1
```

⚠️ ATTENTION ! Il se peut qu’il y est une erreur du type :

```bash
Error response from daemon: driver failed programming external connectivity on endpoint blog_laravel-meilisearch-1 (118ec04adcb26925a699bf396931b2cbb553ec1b71ce5ee1d27cafa56b9e2085): Bind for 0.0.0.0:7700 failed: port is already allocated
```

Il faut aller dans le fichier .env et remplacer la variable APP_URL=http://localhost par APP_URL=http://127.0.0.1

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
# dev-web
