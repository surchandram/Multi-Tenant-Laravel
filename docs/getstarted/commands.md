# Commands

Since the `app` directory structure has changed, we have listed a set of commands below 
to mitigate some of the frustrations that come along with the changes.

::: warning
The `app` folder namespace and the project in general have been 
setup to use `SAAS` as default namespace.
:::

## Generating different files in app folder

### Controller Make Command

`make:controller`, has been setup to put a `Controller` file in `Http` not `Controllers` directory.

The example below will put the controller under `app/Http/Posts/Controllers/PostController.php`.

```bash
php artisan make:controller Posts\Controllers\PostController
```

### Request Make Command

Same as controller make command but file should be pointed to output in `app/Http/{FeatureNamespace}/Requests/{RequestFile.php}`.

```bash
php artisan make:request Posts\Requests\PostStoreRequest
```

### Resource Make Command

Same as request make command but file should be pointed to output in `app/Http/{FeatureNamespace}/Resources/{ResourceFile.php}`.

```bash
php artisan make:resource Posts\Resources\PostResource
```

### Policy Make Command

The command outputs the file in `app/Domain/{FeatureNamespace}/Policies/{PolicyFile.php}`.

```bash
php artisan make:policy {FeatureNamespace}\Policies\{Policy}
```

You can override this by specifying a full namespace as below:

```bash
php artisan make:policy \SAAS\Http\{namespace}\Policies\{Name}
```

### Provider Make Command

The provider make command has been setup to output file at `app/App/Providers/{Provider.php}`.

```bash
php artisan make:provider {Name}
```

### Channel Make Command

```bash
php artisan make:channel \SAAS\App\Broadcasting\{Name}
```

### Console Make Command

```bash
php artisan make:console \SAAS\App\Console\Commands\{Name}
```

### Exception Make Command

```bash
php artisan make:exception \SAAS\App\Exceptions\{Name}
```

### Job Make Command

```bash
php artisan make:job \SAAS\Domain\{namespace}\Jobs\{Name}
```

### Event Make Command

```bash
php artisan make:event \SAAS\Domain\{namespace}\Events\{Name}
```

### Listener Make Command

```bash
php artisan make:listener \SAAS\Domain\{namespace}\Listeners\{Name}
```

### Mail Make Command

```bash
php artisan make:mail \SAAS\Domain\{namespace}\Mail\{Name}
```

### Model Make Command

```bash
php artisan make:model \SAAS\Domain\{namespace}\Models\{Name}
```

### Notification Make Command

```bash
php artisan make:notification \SAAS\Domain\{namespace}\Notifications\{Name}
```

### Rule Make Command

```bash
php artisan make:rule \SAAS\Domain\{namespace}\Rules\{Name}
```
## Generating files to be place in `app/App` folder

If some files are intended to be used globally, that is in the `app/App`, 
use command as below as hinted below.

```bash
php artisan make:{command} \SAAS\App\{namespace}\{Name}
```

::: tip
The default laravel make commands, ie `make:{command}` accept a full namespace 
to place a generated file in the desired path.
:::

## Custom Commands

### Admin: ***Assign user a role***

```bash
php artisan role:assign <email> <role-slug>`
```
- `<email>` is the user's email
- `<role-slug>` is the ***slug of the role*** you wish to assign the user.
