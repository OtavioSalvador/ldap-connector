<?php

namespace Dsdevbe\LdapConnector;

use Auth;
use Dsdevbe\LdapConnector\Adapter\Adldap;
use Illuminate\Support\ServiceProvider;

class LdapConnectorServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        Auth::provider('ldap', function ($app, array $config) {
            $ldap = new Adldap(
                $this->getLdapAdapterConfig('adldap')
            );

            return new LdapUserProvider($ldap);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $ldapConfig = __DIR__ . '/Config/ldap.php';
        $this->publishConfig($ldapConfig);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['auth'];
    }

    protected function publishConfig($configPath)
    {
        $this->publishes([
            $configPath => config_path('ldap.php'),
        ]);
    }

    /**
     * Get ldap configuration.
     *
     * @return array
     */
    public function getLdapConfig()
    {
        return $this->app['config']->get('ldap');
    }

    /**
     * @param $pluginName
     *
     * @return array
     */
    public function getLdapAdapterConfig($pluginName)
    {
        $pluginsConfig = $this->app['config']->get('ldap.plugins');

        return $pluginsConfig[$pluginName];
    }
}
