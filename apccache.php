<?php

class SlimCache extends \Slim\Middleware {

	public function call() {
		
		$cache = $this->app->config('cache');
		$key_name = $cache['caching_prefix']. $this->app->request()->getResourceUri();
		$rsp = $this->app->response();
		
		// Check cache
		if (($cache['caching']===true) && (apc_exists($key_name))) {
	    	
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
		if (($rsp->status() == 200) && ($cache['caching']===true) && ($cache['ttl'] > 0)) {
			$header = $rsp->headers->all();
			$data = array(
					'header' => $header,
					'body' => $rsp->body()
					);
			apc_store($key_name, $data, $cache['ttl']);
		}
	}	
}

