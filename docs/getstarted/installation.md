# Installation

::: warning
Create a database first.
:::

1. Extract your downloaded code and switch to the extracted path.
2. Setup your `database` and add the related keys to the `.env` file.
3. Run `composer install` if its the initial setup.
4. Setup other environment keys in `.env`
    - Run first `php artisan key:generate`
    - **Note**: If .env does not exist then copy `.env.example` as `.env`
5. Run `php artisan migrate` for initial tables setup. (use `--seed`, to setup initial or test data)
6. **Optional:** Run `php artisan db:seed --class=RoleTableSeeder` to set the initial
    roles and permissions, then follow `step 7` below to assign a user the initial permissions and roles.
    **Skip if you seeded the database when initially migrating**
7. **Optional:** To create a `root` admin;
    Run `php artisan role:assign youremail@example.org admin-root`.
    Substitute `youremail@example.org` with an existing user email. `admin-root` is the **default root Admin role**.

    **Note:** You must follow `step 5 and 6` above first to setup the root admin.
