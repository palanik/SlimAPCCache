<?php

class SlimCache extends \Slim\Middleware {

	protected $settings;

	public function __construct($settings = array()) {
		$this->settings = array_merge(array(
				'ttl' => 300,	// 5 minutes
				'caching_prefix' => 'SlimCache_'
				), $settings);
	}

	public function call() {
		
		$key_name = $this->settings['caching_prefix']. $this->app->request()->getResourceUri();
		$rsp = $this->app->response();
		
		// Check cache
		if (apc_exists($key_name)) {
	    	
			// Return content from cache
			$data = apc_fetch($key_name);
			foreach ($data['header'] as $key => $value) {
				$rsp->headers->set($key, $value);	
			}
			$rsp->body($data["body"]);
			return;
		}
		
		// Not in cache. Call controller
		$this->next->call();
		
		// Cache the content
		if (($rsp->status() == 200) && ($this->settings['ttl'] > 0)) {
			$header = $rsp->headers->all();
			$data = array(
					'header' => $header,
					'body' => $rsp->body()
					);
			apc_store($key_name, $data, $this->settings['ttl']);
		}
	}	
}

