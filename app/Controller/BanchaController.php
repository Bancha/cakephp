<?php
/**
 * Bancha Controller 
 * 
 * This class exports the ExtJS API of all other Controllers for use in ExtJS Frontends
 * 
 * @author Andreas Kern
 *
 */
// TODO sauberen header einfuegen

class BanchaController extends AppController {

	//var $name = 'Banchas'; //turns html on again

	/**
	 *  CRUD mapping between cakephp and extjs 
	 * 	TODO check if the right 
	 * 
	 * @var array
	 */
	public $map = array(
			'index' => array('read', 0), //TODO read mit param(1) 
			'add' => array('create', 1), 
			'edit' => array('update', 1), 
			'delete' => array('destroy', 1)
	);


	/**
	 * index method, sets $API for use in the view
	 *
	 * @return void
	 */
	public function index() {
		/**
		 * holds the ExtJS API array which is returned
		 *
		 * @var array
		 */
		$API = array();

		/**
		 * array for the Controllers in the app/Controller directory
		 * 
		 * @var $controllers
		 */
		$controllers = array();
		//find all Controller files in app/Controller except Bancha
		if ($handle = opendir(APP . DS . 'Controller'))
		{
			while (false !== ($file = readdir($handle)))
			{
				if(strpos($file, 'Controller') == true) //TODO does not work
				{
					//don't recursively include ourselves
					if($file != 'BanchaController.php')
					{
						include($file);
						array_push($controllers, str_replace('.php', '', $file));
					}
				}
			}
			closedir($handle);
		}

		// push the interesting methods into the API array
		foreach($controllers as $cont) {
			$methods = get_class_methods($cont);
			$cont = str_replace('Controller','',$cont);
			$cont = Inflector::singularize($cont);
			foreach( $this->map as $key => $value) {
				if (array_search($key, $methods) !== false) {
					$API[$cont]['methods'][$value[0]]['len'] = $value[1];
				};
			}
		}

		/****** parse Models **********/
		
		
		// TODO implement autoloader (maybe via the schema file)
		$this->loadModel('User');
		$this->loadModel('Article');
		$this->loadModel('Tag');
		
		/**
		 * loop through all models and get their methods
		 */

		/*
		 foreach ($this->modelNames as $value) {
			$tmp = array();
			echo $value;
			//print_r($this->{$value});
			foreach($this->{$value}->methods as $method) {
			if($method = 'view') {
			$tmp[$method] = array( "len" => 0);
			}
			}
			array_push( $API, $value["methods"] = $tmp);
			}
		 */

		$this->set('API', $API);
		$this->render(null, 'ajax'); //removes the html
		
		//TODO add metaData
	}
}

?>
