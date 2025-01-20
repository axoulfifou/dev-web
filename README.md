# documentation dev-web

## Principe

Laravel est un framework pour créer des applications web. On commence par le télécharger, puis on utilise Sail (qui repose sur Docker) pour exécuter des commandes Laravel. Ensuite, on migre les données pour configurer la base de données avant de pouvoir commencer à développer l'application.

## Créer un nouveau projet LARAVEL

1. Vérifier l’accès au repo git distant puis cloner ce dernier :

```bash
git clone <url_repo_git
```

1. Copier le fichier .env de notre environnement Laravel dans le dossier cloné si il n’y est pas :

```bash
cp .env <chemin_vers_le_dossier_cloné>
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

⚠️ ATTENTION ! Il se peut qu’il y est une erreur du type :

```bash
Error response from daemon: driver failed programming external connectivity on endpoint blog_laravel-meilisearch-1 (118ec04adcb26925a699bf396931b2cbb553ec1b71ce5ee1d27cafa56b9e2085): Bind for 0.0.0.0:7700 failed: port is already allocated
```

Il faut aller dans le fichier .env et remplacer la variable APP_URL=http://localhost par APP_URL=http://127.0.0.1

## **2 - Models, migrations et controllers**

Avant toute chose pour faciliter les futurs commandes nous allons créer un alias qui permettra d’utiliser **sail** plus facilement 

Placez-vous dans le répertoire de travail :

```bash
cd /home/avignaud/dev-web/minimalist-blog-laravel 
```

Créer l’allias pour lancer l’application sail avec la simple commande ‘sail’ :

```bash
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

On peut ensuite le lancer simplement avec la commande :

```bash
sail up -d
```

On va ensuite créer nos premier modèle qui sont l’équivalent des tables dans les bases de données:

Création du modèle post :

```bash
sail php artisan make:model Post -mc

```

-m permet  créer  une **migration** associée au modèle. Cela génère un fichier de migration dans le dossier `database/migrations`, qui peut être utilisé pour créer ou modifier la table correspondante dans la base de données.

-c créé  un **contrôleur** pour le modèle. Cela génère un fichier contrôleur dans le dossier `app/Http/Controllers`, permettant de gérer la logique liée à ce modèle (ex : gestion des routes, traitements).

On peut ensuite faire cette commande pour les modèles Comment et Reply :

```bash
sail php artisan make:model Comment -mc
sail php artisan make:model Reply -mc
```

*infos: artisan est simplement  l'interface en ligne de commande  de Laravel*

On va ensuite ajouter des champs à nos tables , pour cela on va modifier les fichiers de migrations créer avec le ‘-m’ :

Pour `2025_01_20_075956_create_posts_table.php`, modifier la fonction up comme ceci :

```php
Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->string('title');
            $table->text('body');
            $table->timestamps();
```

Pour `2025_01_20_075956_create_comments_table.php`, modifier la fonction up comme ceci :

```php
Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id'); 
            $table->unsignedBigInteger('post_id'); 
            $table->text('body'); 
            $table->timestamps();
```

Pour `2025_01_20_075956_create_replies_table.php`, modifier la fonction up comme ceci :

```php
Schema::create('replies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id'); 
            $table->unsignedBigInteger('comment_id'); 
            $table->text('body'); 
            $table->timestamps();
```

On va ensuite établir les relations entres les tables, (équivalent des flèches sur le schéma) :

On commence par ajouter la relation **‘one-to_many’**, (la flèche qui va de la table user vers la table posts sur users_id) :

Dans le fichier `app/Models/User.php`, modifier la fonction up comme ceci :

*il faut ajouter la fonction dans la class User*

```php
public function posts() 
{
    return $this->hasMany(Post::class, 'user_id');
}
```

Pour  `app/Models/Post.php` :

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // table name to be used
    protected $table = 'posts';

    // columns to be allowed in mass-assingment 
    protected $fillable = ['user_id', 'title', 'body'];

    /* Relations */

    // One to many inverse relationship with User model
    public function owner() {
    	return $this->belongsTo(User::class, 'user_id');
    }

    // One to Many relationship with Comment model
    public function comments()
    {
    	return $this->hasMany(Comment::class, 'post_id');
    }

    /**
     * get show post route
     *
     * @return string
     */
    public function path()
    {
        return "/posts/{$this->id}";
    }
}

```

Pour  `app/Models/Comment.php` :

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    # table name to be used by model
    protected $table = 'comments';

    # columns to be allowed in mass-assingment
    protected $fillable = ['user_id', 'post_id', 'body'];

    /** Relations */

    # One-to-Many inverse relation with User model.
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    # One-to-Many inverse relation with Post model.
    public function post()
    {
    	return $this->belongsTo(Post::class, 'post_id');
    }

    # One-to-Many relation with Reply model.
    public function replies()
    {
    	return $this->hasMany(Reply::class, 'comment_id');
    }
}

```

Pour  `app/Models/Reply.php` :

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    // Table name to be used by the model.
    protected $table = 'replies';

    // Columns to be used in mass-assignment.
    protected $fillable = ['user_id', 'comment_id', 'body'];

    /** Relations */

    // One-to-Many inverse relation with User model.
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // One-to-Many inverse relation with Comment model.
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }
}

```

## Authentification :

Laravel propose des kits de démarrage pour vous aider à créer rapidement une application avec des fonctionnalités prêtes à l'emploi (authentification, enregistrement, etc.). Ces kits ne sont pas obligatoires, mais ils simplifient beaucoup le travail initial.

Laravel Breeze est l'un de ces kits. Il permet de mettre en place facilement l'authentification et les éléments de base d'une application Laravel.

Installation de Laravel BReeze avec sail :

```php
sail composer require laravel/breeze --dev
```

Scaffold de Breeze :

Le **scaffold de Breeze** automatise la création des composants nécessaires pour un système d'authentification complet (routes, contrôleurs, vues). Cela permet de démarrer rapidement sans avoir  besoin de tout configurer manuellement et  tout en ayant la flexibilité de personnaliser le code généré.

```php
sail php artisan breeze:install
```

Choisir ces options pour l’installation :

![image.png](images-doc/image.png)

Compiler les assets frontend (CSS et JavaScript) :

Cette étape prépare et optimise les fichiers CSS et JS pour qu'ils soient utilisables par notre application.

```php
sail npm install
sail npm run dev
```

Faire la migration des données :

```php
sail php artisan migrate 
```

On va ensuite tester si ça fonctionne en allant dans aux pages `/login`, `/register` on va essayer de créer un compte et de s’y connecter 

![image.png](images-doc/image%201.png)

![image.png](images-doc/image%202.png)