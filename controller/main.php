<?php
/**
 * User Controller
 *
 * @author Serhii Shkrabak
 * @global object $CORE
 * @package Controller\Main
 */
namespace Controller;
class Main
{
	use \Library\Shared;

	private $model;

	public function exec():?array {
		$result = null;
		$url = $this->getVar('REQUEST_URI', 'e');
		$path = explode('/', $url);

		if (isset($path[2]) && !strpos($path[1], '.')) { // Disallow directory changing
			$file = ROOT . 'model/config/methods/' . $path[1] . '.php';
			if (file_exists($file)) {
				include $file;
				if (isset($methods[$path[2]])) {
					$details = $methods[$path[2]];
					$request = [];
					foreach ($details['params'] as $param) {
						$var = $this->getVar($param['name'], $param['source']);
						$patternFile = ROOT . 'model/config/patterns.php';
						include $patternFile;
						if (empty($var) && !$param['required']) { // Если значения нету и параметр не обязательный
							if (!isset($param['default'])) {
								throw new \Exception("INTERNAL_ERROR" . " ". $param['name']);
							}
							$request[$param['name']] = $param['default'];
						} else if (empty($var) && $param['required']) {
							throw new \Exception("REQUEST_INCOMPLETE" . " ". $param['name']);
						} else if (isset($var)) { // Есть значения и параметр обязательный
							if (!isset($param['pattern'])) {
								throw new \Exception("REQUEST_INCORRECT" . " ". $param['name']);
							} else if (!preg_match($patterns[$param['pattern']]['regex'], $var)) {
								throw new \Exception("REQUEST_INCORRECT" . " ". $param['name']);
							}
							if (isset($patterns[$param['pattern']]['callback'])) {
								$var = preg_replace_callback(
									$patterns[$param['pattern']]['replacement'],
									$patterns[$param['pattern']]['callback'], 
									$var
								);
							}
							$request[$param['name']] = $var;
						}
					}
					if (method_exists($this->model, $path[1] . $path[2])) {
						$method = [$this->model, $path[1] . $path[2]];
						$result = $method($request);
					} else {
						throw new \Exception("REQUEST_UNKNOWN");
					}

				} else {
					throw new \Exception("REQUEST_UNKNOWN");
				}
			}
		} 
		return $result;
	}

	public function __construct() {
		// CORS configuration
		$origin = $this -> getVar('HTTP_ORIGIN', 'e');
		$front = $this->getVar('FRONT', 'e');
		foreach ( [$front] as $allowed )
			if ( $origin == "https://$allowed") {
				header( "Access-Control-Allow-Origin: $origin" );
				header( 'Access-Control-Allow-Credentials: true' );
			}
		$this->model = new \Model\Main;
	}
}