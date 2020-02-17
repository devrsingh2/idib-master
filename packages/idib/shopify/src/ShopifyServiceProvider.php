<?php

namespace Idib\Shopify;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Idib\Shopify\Console\WebhookJobMakeCommand;
use Idib\Shopify\Middleware\AuthProxy;
use Idib\Shopify\Middleware\AuthShop;
use Idib\Shopify\Middleware\AuthWebhook;
use Idib\Shopify\Middleware\Billable;
use Idib\Shopify\Observers\ShopObserver;

class ShopifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Routes
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        // Views
        $this->loadViewsFrom(__DIR__.'/resources/views', 'shopify-app');

        // Views publish
        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/shopify-app'),
        ], 'shopify-views');

        // Config publish
        $this->publishes([
            __DIR__.'/resources/config/shopify-app.php' => "{$this->app->configPath()}/shopify-app.php",
        ], 'shopify-config');

        // Database migrations
        // @codeCoverageIgnoreStart
        if (Config::get('shopify-app.manual_migrations')) {
            $this->publishes([
                __DIR__.'/resources/database/migrations' => "{$this->app->databasePath()}/migrations",
            ], 'shopify-migrations');
        } else {
            $this->loadMigrationsFrom(__DIR__.'/resources/database/migrations');
        }
        // @codeCoverageIgnoreEnd

        // Job publish
        $this->publishes([
            __DIR__.'/resources/jobs/AppUninstalledJob.php' => "{$this->app->path()}/Jobs/AppUninstalledJob.php",
        ], 'shopify-jobs');

        // Shop observer
        $shopModel = Config::get('shopify-app.shop_model');
        $shopModel::observe(ShopObserver::class);

        // Middlewares
        $this->app['router']->aliasMiddleware('auth.shop', AuthShop::class);
        $this->app['router']->aliasMiddleware('auth.webhook', AuthWebhook::class);
        $this->app['router']->aliasMiddleware('auth.proxy', AuthProxy::class);
        $this->app['router']->aliasMiddleware('billable', Billable::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Merge options with published config
        $this->mergeConfigFrom(__DIR__.'/resources/config/shopify-app.php', 'shopify-app');

        // ShopifyApp facade
        $this->app->bind('shopifyapp', function ($app) {
            return new ShopifyApp($app);
        });

        // Commands
        $this->commands([
            WebhookJobMakeCommand::class,
        ]);
    }
}
