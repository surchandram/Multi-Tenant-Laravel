<?php

namespace SAAS\Http\Middleware;

use Closure;
use Illuminate\Contracts\Filesystem\Factory;

class UserFilesystemMiddleware
{
    /**
     * Filesystem instance.
     *
     * @var \Illuminate\Contracts\Filesystem\Factory
     */
    public $filesystem;

    /**
     * UserFilesystemMiddleware constructor.
     *
     * @param \Illuminate\Contracts\Filesystem\Factory $filesystem
     * @return void
     */
    public function __construct(Factory $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            return $next($request);
        }

        $this->setFilesystemRoot();

        return $next($request);
    }

    /**
     * Setup user filesystem.
     *
     * @return void
     */
    protected function setFilesystemRoot()
    {
        $this->filesystem->set(
            'user',
            $this->createDriver($this->getFilesystemConfig())
        );
    }

    /**
     * Create user's driver.
     *
     * @param $config
     * @return mixed
     */
    protected function createDriver($config)
    {
        $method = $this->getCreationMethod();

        return $this->filesystem->{$method}($config);
    }

    /**
     * Get and set user specific filesystem config.
     *
     * @return string
     */
    protected function getFilesystemConfig()
    {
        $config = config('filesystems.disks.' . config('filesystems.default'));

        $config['root'] = storage_path('app/user/') . auth()->id();

        return $config;
    }

    /**
     * Get the driver to be created based on default filesystems driver.
     *
     * @return string
     */
    protected function getCreationMethod()
    {
        return "create" . ucfirst(config('filesystems.default')) . "Driver";
    }
}
