<?php namespace App\Handlers\Events;

use App\Events\ThingWasDone;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class SendMailInSomeParticularContext {

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  ThingWasDone  $event
	 * @return void
	 */
	public function handle(ThingWasDone $event)
	{
		//
       echo 'hello';
	}

}
