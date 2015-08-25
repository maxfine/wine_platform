<?php namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Events\ThingWasDone;
use App\Handlers\Events\SendMailInSomeParticularContext;

class EventServiceProvider extends ServiceProvider {

	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
        ThingWasDone::class => [
            SendMailInSomeParticularContext::class
        ],
        ThingWasDone::class => [
            SendMailInSomeParticularContext::class
        ],
	];

    protected $subscribe = [
        'App\Handlers\Events\UserEventHandler',
    ];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events)
	{
		parent::boot($events);

		//
	}

}
