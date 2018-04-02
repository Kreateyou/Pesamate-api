<?php
namespace Pesamate\Laravel\Providers;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Pesamate\Pesamate;
use Pesamate\Models\Auth;
/**
* 
*/
class ServiceProvider extends BaseServiceProvider
{
	protected $namespace='Pesamate\\Laravel\\Controllers\\';
	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot()
	{
        $configPath = __DIR__.'/config/config.php';
	    $this->publishes([$configPath => config_path('pesamate.php')]);
         $this->mapApiRoutes();
	}
    protected function mapApiRoutes()
    {
      $this->app['router']->any('pesamate/callback', $this->namespace.'Callback@act');
    }

	 /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
    	$configPath =__DIR__.'/config/config.php';
        $this->mergeConfigFrom($configPath, 'pesamate');
        $auth =$session= null;
        $sessionClass = config("pesamate.token_session_model");
        if(class_exists($sessionClass)){
        	$session = new $sessionClass;
        }
       
    	
    	
        $this->app->singleton("pesamate", function ($app)use($auth,$session) {
        	
            if(!empty(array_filter(config("pesamate.credentials")))){
    		$auth  = Auth::withCredentials(config("pesamate.credentials.login"),config("pesamate.credentials.password"),$session);
	    	}elseif (!empty(array_filter(config("auth")))) {
	    		$auth  = Auth::setToken(config("pesamate.auth.token"),config("pesamate.auth.secret"));
	    	}else{
	    		throw new \Exception("Please supply authentication details for pesamate", 1);
	    		
	    	}
            return Pesamate::requestBuilder($auth);
        });
    }
}