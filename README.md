# SaaS Boilerplate Pro

This is a SaaS boilerplate built on top of the Laravel framework with TailwindCSS.

Its built to provide developers with a template to kickoff their SaaS application,
without the hustle for repetitive tasks such as user account management,
teams setup (with multi-tenancy), subscriptions (separate for users and teams)
and role management.

## Folder structure

Inspired by domain-driven approach.

The main `app` folder is restructured to: `App`, `Domain` and `Http`.

### Outline of app folder

- App
  - Console
  - Controllers
  - Exceptions
  - Providers
  - Traits
  - TwoFactor
- Domain
  - Account
  - Auth
    - Events
    - Listeners
    - Mail
    - Rules
  - Projects
  - Subscriptions
  - Teams
  - Users
    - Models
    - Filters
    - Observers
- Http
  - Account
    - Controllers
    - Requests
  - Auth
    - Controllers
    - Requests
  - Middleware
  - Subscriptions
  - Teams
  - Users
    - Policies
    - Resources
- Views
  - Components
  - Composers

## Features

- Authentication
  - Login / Registration
  - Email Activation
  - Two Factor Login (only when enabled)
- Subscription with Stripe
  - User plans
  - Team plans
- Account (User Account)
  - Profile Update
  - Change Password
  - Two Factor Authentication
  - Subscriptions
    - Cancel Subscription
    - Resume Subscription
    - Swap Plan
    - Update Card
  - API Tokens
- Teams
  - Multi Database Multi-tenancy
  - Roles Management
  - Users Management
- Admin
  - User Management
    - Create Users (and assign role)
    - Manage User Roles
  - Role & Permissions Management
- Subscriptions
  - Cancel Subscription
  - Resume Subscription
  - Swap Plan
  - Update Card
- Developer Panel
  - Manage OAuth Clients
  - Manage Personal Access Tokens
- Other features
  - Filtering (extendable)
  - API access (starter template)

*Note: Some features may be subjected to change. Other features may not be listed
since they are under development or do not qualify as a standard / main SaaS feature.
Some common features will not be listed as well.*

## Installation

1. Fork, clone or download this repository.
2. Run `composer install` if its the initial setup or `composer update`.
3. Setup your environment keys in .env
    Run first `php artisan key:generate`
    **Note**: **If .env does not exist then copy / rename .env.example as .env**
4. Run `php artisan migrate` for initial tables setup. (use `--seed`, to setup initial or test data)
5. **Optional:** Run `php artisan db:seed --class=RoleTableSeeder` to set the initial
    roles and permissions, then follow `step 6` below to assign a user the initial permissions and roles.
    **Skip if you seeded the database when initially migrating**
6. **Optional:** To create a `root` admin;
    Run `php artisan role:assign youremail@example.org admin-root`.
    Substitute `youremail@example.org` with an existing user email. `admin-root` is the **default root Admin role**.

    **Note:** You must follow `step 4 and 5` above first to setup the root admin.

## Usage

### Generating different files in app folder

#### Channel Make Command

php artisan make:channel \SAAS\App\Broadcasting\{name}

#### Console Make Command

php artisan make:console \SAAS\App\Console\Commands\{name}

#### Exception Make Command

php artisan make:exception \SAAS\App\Exceptions\{name}

#### Job Make Command

php artisan make:job \SAAS\Domain\{namespace}\Jobs\{name}

#### Event Make Command

php artisan make:event \SAAS\Domain\{namespace}\Events\{name}

#### Listener Make Command

php artisan make:listener \SAAS\Domain\{namespace}\Listeners\{name}

#### Mail Make Command

php artisan make:mail \SAAS\Domain\{namespace}\Mail\{name}

#### Model Make Command

php artisan make:model \SAAS\Domain\{namespace}\Models\{name}

#### Notification Make Command

php artisan make:notification \SAAS\Domain\{namespace}\Notifications\{name}

#### Policy Make Command

php artisan make:policy \SAAS\Http\{namespace}\Policies\{name}

#### Rule Make Command

php artisan make:rule \SAAS\Domain\{namespace}\Rules\{name}

**Note**: Some files can be placed in the `app/App` folder if they are intended to be used globally

```cli
php artisan make:{command} \SAAS\App\{namespace}\{name}
```

### Custom Commands

1. __Admin: *Assign user a role*__
  Use `php artisan role:assign <email> <role-slug>`:
    `<email>` is the user's email and `<role-slug>` is the *slug of the role* you wish to assign the user.

### Force HTTPS

When pushing the project to a platform or production environment,
assets or urls may be broken if the platform enforces HTTPS.

*To enable urls to use HTTPS:*

Set `FORCE_HTTPS` variable in `.env` file to `true`.

By default `FORCE_HTTPS` is `false`.

```Note:``` If `FORCE_HTTPS` does not exist in your `.env`,
just add it as a new variable and assign a boolean value `true` or `false`.

This dynamically tells Laravel to force urls to use HTTPS which is especially
handy in fixing or preventing  broken assets urls.

### Multi Database Multi-tenancy

See [miracuthbert/laravel-multi-tenancy](https://github.com/miracuthbert/laravel-multi-tenancy)

#### Model setup

To start using multi databse multi-tenancy call `ForTenants` trait on a model

```php
use Miracuthbert\Multitenancy\Traits\ForTenants;

class Project extends Model
{
    use ForTenants;
}
```

#### Tenants CRUD Operations

Once you have setup the model as show above. `Just call CRUD operations directly`.
`Tenant` relationships are handled automatically.

```php
$projects = Project::create([
    'name' => 'Project 1'
]);
$projects = Project::get();
```

#### Normal CRUD Operations

To perform CRUD operations on models with `ForTenants` trait can be done by
adding `withoutForTenants` scope when fetching records associated with that model.

```php
$projects = Project::withoutForTenants()->get();
```

***This comes in handy for example in: admin or moderation operations***

#### Routing

All `tenant` routes are under the routes folder in the `tenant.php` file.

Note: ***Tenant routes follow the same structure as other routes***

`The main reason we place all tenant routes separately is to handle route binding and
its much easier to know which routes are for tenants.`

## Security Vulnerabilities

If you discover a security vulnerability within the project, please send an e-mail to Cuthbert Mirambo via [miracuthbert@gmail.com](mailto:miracuthbert@gmail.com). All security vulnerabilities will be promptly addressed.

## License

SaaS Boilerplate Pro is open-sourced software licensed under the is licensed under GPL-3.0. Please see the license file for more information.
