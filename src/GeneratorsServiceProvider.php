<?php

namespace HelloPeterlee\Scaffold;

use Illuminate\Support\ServiceProvider;

class GeneratorsServiceProvider extends ServiceProvider
{

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerScaffoldGenerator();
	}

	/**
	 * Register the make:scaffold generator.
	 *
	 * @return void
	 */
	private function registerScaffoldGenerator()
	{
		$this->app->singleton('command.larascaf.scaffold', function ($app) {
			return $app['HelloPeterlee\Scaffold\Commands\ScaffoldMakeCommand'];
		});

		$this->commands('command.larascaf.scaffold');
	}
}