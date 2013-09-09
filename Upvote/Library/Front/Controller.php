<?php
namespace Upvote\Library\Front;

/**
 * Simple FrontController Class demonstrating the Front Controller Pattern.
 * 
 * @author ajmckee
 */
class Controller 
{
	/**
	 * Array of config values
	 * 
	 * @var array
	 */
	protected $_config;
	
	/**
	 * Class construction, requires config array. 
	 * 
	 * @param array $config
	 */
	public function __construct(array $config) 
	{
		$this->_setupConfig($config);
	}
	
	public function execute()
	{
		$call = $this->_determineControllers();
		$call_class = $call['call']['controller'];
		
		$class = '\\'. ucfirst($call_class);
		
		$method = $call['call']['action'];
		$controller = new $class($this->getConfig());
		if(method_exists($controller, $method))
		{
			return $controller->$method();
		}
		throw new \Exception('Controller Method ' . $method . ' does not exist.');
	}
	
	/**
	 * Determines which controller to call based on route matched after the first 
	 * @return Ambigous <multitype:, multitype:unknown >
	 */
	private function _determineControllers()
	{
		if (isset($_SERVER['REDIRECT_BASE'])) {
			$rb = $_SERVER['REDIRECT_BASE'];
		} else {
			$rb = '';
		}
		
		$ruri = $_SERVER['REQUEST_URI'];
		$path = str_replace($rb, '', $ruri);
		$return = array();
		
		foreach($this->config['routes'] as $k => $v) {
			
			$matches = array();
			$pattern = '$' . $k . '$';
			// Match on lower case only as we'll make URLS case insensitive. 
			if(preg_match(strtolower($pattern), strtolower($path)))
			{
				$controller_details = $v;
				$return = array('call' => $v);
			}
		}
		return $return;
	}
	
	/**
	 * Setup config array so its available 
	 * 
	 * @param array $config
	 */
	private function _setupConfig($config) {
		$this->config = $config;
	}
	
	/**
	 * Get the config array. 
	 * @return array
	 */
	public function getConfig()
	{
		return $this->config;
	}
}