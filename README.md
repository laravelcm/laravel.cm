<p align="center">
    <img src="./art/logo.svg" height="250" alt="Community logo" />
</p>

<p align="center">
    <a href="https://laravel.com">
        <img alt="Laravel v12.x" src="https://img.shields.io/badge/Laravel-v12.x-FF2D20">
    </a>
    <a href="https://github.com/laravelcm/laravel.cm/actions">
        <img src="https://github.com/laravelcm/laravel.cm/workflows/Tests/badge.svg" alt="Build Status" />
    </a>
    <a href="https://github.com/laravelcm/laravel.cm/actions/workflows/quality.yml">
        <img src="https://github.com/laravelcm/laravel.cm/actions/workflows/quality.yml/badge.svg" alt="Coding Standards" />
    </a>
    <a href="https://forge.laravel.com">
        <img src="https://img.shields.io/endpoint?url=https%3A%2F%2Fforge.laravel.com%2Fsite-badges%2Fb0b9e269-e85c-40eb-9b8d-cfa8197a1bb2&style=plastic" alt="Laravel Forge Site Deployment Status" />
    </a>
</p>

## Laravel.cm

Ce dépôt contient le code source du site de [Laravel.cm](https://laravel.cm). Laravel Cameroun est la plus grande communauté de 
développeurs PHP & Laravel résidant au Cameroun.

## Rejoindre la communauté

Vous pouvez rejoindre la communauté ou nous suivre via nos différentes plateformes

- [Discord](https://discord.gg/KNp6brbyVD)
- [Telegram](https://t.me/laravelcameroun)
- [Twitter](https://twitter.com/laravelcm)
- [Facebook](https://www.facebook.com/laravelcm)

## Sponsors 💰

Nous tenons à remercier ces **entreprises extraordinaires** pour leur parrainage. Si vous souhaitez devenir sponsor, veuillez visiter <a href="https://laravel.cm/sponsors">la page Laravel.cm de Sponsoring</a>.

- **[Laravel Shopper](https://laravelshopper.dev)**
- [GDG Douala](https://gdg.community.dev/gdg-douala) 
- [NotchPay](https://notchpay.co?utm_source=laravel.cm) 
- [LN UI](https://ui.lndev.me?utm_source=laravel.cm) 

## Caractéristiques Serveur 📝

Les dépendances suivantes sont nécessaires pour démarrer l'installation.

- [php](https://www.php.net/docs.php) version 8.4 minimum
- [Docker](https://docs.docker.com/get-docker/) et [Docker Compose](https://docs.docker.com/compose/install/)
- [Composer](https://getcomposer.org/download/)
- [Laravel server requirements](https://laravel.com/docs/deployment#server-requirements)

## Installation 🚀

> Notez que vous êtes libre d'ajuster l'emplacement `~/Sites/laravel.cm` à n'importe quel répertoire de votre choix sur votre machine. Ce faisant, assurez-vous d'exécuter la commande `valet link` (si vous utilisez Laravel Valet) dans le répertoire souhaité.

1. Clonez ce repo avec la commande `git clone git@github.com:laravelcm/laravel.cm.git ~/Sites/laravel.cm`
2. Exécuter `composer install` pour installer les dépendances PHP
3. Configurez une base de données locale (vous pouvez l'appeler `laravelcm`)
4. Exécutez `composer setup` pour configurer l'application
5. Configurer un pilote de messagerie fonctionnel comme [Mailtrap](https://mailtrap.io/) ou [Maildev](https://maildev.github.io/maildev/)
6. Configurez les fonctionnalités (facultatives) ci-dessous

Vous pouvez maintenant visiter l'application dans votre navigateur en visitant [https://laravelcm.local](https://laravelcm.local).
Si vous avez amorcé la base de données, vous pouvez vous connecter à un compte de test avec ** `johndoe` ** & **` password` **.

Une fois que vous avez installé et configuré, pour avoir des dummy data, vous devez exécuter la commande :

```shell
php artisan db:seed --class=DummyDatabaseSeeder
```

### GitHub Authentication (optionnel)

Pour que l'authentification Github fonctionne localement, vous devez [enregistrer une nouvelle application OAuth sur Github](https://github.com/settings/applications/new).
Utilisez `http://laravel.cm.test` pour l'URL de la page d'accueil et `http://laravel.cm.test/auth/github` pour l'URL de rappel.
Lorsque vous avez créé l'application, remplissez l'ID et le secret dans votre fichier `.env` dans les variables d'environnement ci-dessous.
Vous devriez maintenant pouvoir vous authentifier avec Github.

```shell
GITHUB_ID=
GITHUB_SECRET=
GITHUB_URL=http://laravel.cm.test/auth/github
```

### Twitter Sharing (optionnel)

Pour permettre le partage automatique des articles publiés sur Twitter, vous devez [créer une application Twitter](https://developer.twitter.com/apps/).
Une fois l'application créée, mettez à jour les variables ci-dessous dans votre fichier `.env`.
La clé et le secret du consommateur ainsi que le jeton et le secret d'accès se trouvent dans la section « Clés et jetons » de l'interface utilisateur des développeurs Twitter.

```shell
TWITTER_CONSUMER_KEY=
TWITTER_CONSUMER_SECRET=
TWITTER_ACCESS_TOKEN=
TWITTER_ACCESS_SECRET=
```

Les articles approuvés sont partagés dans l'ordre dans lequel ils ont été soumis pour approbation. Les articles sont partagés deux fois par jour à 14h00 et 18h00 UTC.
Une fois qu'un article a été partagé, il ne sera plus partagé.

### Notifications Telegram (optionnel)

Laravel Cameroun peut notifier les administrateurs des nouveaux articles soumis via Telegram. Pour que cela fonctionne, vous devez configurer un [bot Telegram](https://core.telegram.org/bots) et obtenir un token.
Ensuite, configurez le canal sur lequel vous souhaitez envoyer les messages relatifs aux nouveaux articles.

```shell
TELEGRAM_BOT_TOKEN=
TELEGRAM_CHANNEL=
```

## Commands
| Command                            | Description                                            |
|------------------------------------|--------------------------------------------------------|
| **`composer lint`**                | Appliquer le formatage de code avec `laravel/pint`     |
| **`composer types`**               | Appliquer l'analyse statique avec phpstan              |
| **`composer pest`**                | Exécuter les tests                                     |
| `php artisan migrate:fresh --seed` | Reset la base de données                               |
| `npm i && npm run dev`             | Surveillez les changements dans les fichiers CSS et JS |

## Maintainers

Le site Laravel.cm est actuellement maintenu par [Arthur Monney](https://github.com/mckenziearts). Si vous avez des questions, n'hésitez pas à créer une issue sur ce dépôt.

## Contribution

Veuillez lire [le guide de contribution](CONTRIBUTING.md) avant de créer une issue ou d'envoyer une demande d'extraction.

## Code de Conduite

Veuillez lire notre [Code de conduite](CODE_OF_CONDUCT.md) avant de contribuer ou d'engager des discussions.

## Vulnérabilités de sécurité

Si vous découvrez une faille de sécurité dans Laravel.cm, veuillez envoyer un e-mail immédiatement à [support@laravel.cm](mailto:support@laravel.cm). **Ne créez pas de problème pour la vulnérabilité.**

## License

La licence MIT. Veuillez consulter [le fichier de licence](LICENSE.md) pour plus d'informations.
