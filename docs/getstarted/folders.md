# Folder Structure

Inspired by domain-driven approach.

The main `app` folder is restructured to: `App`, `Domain`, `Http`, plus `Views`.

## Outline of app folder

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

## Migrations folder structure

The `database/migrations` folder has been structured to include a `tenant` folder for
all tenant related migrations.

::: tip
You can group migrations in sub-directories under tenant folder based on app features and register them in the `saas` config file.
:::
