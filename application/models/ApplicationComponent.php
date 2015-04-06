<?php
/**
 * Arquivo de modelo para o mapeamento da tabela Application 
 * @author guarient
 *
 */
class Application_Model_ApplicationComponent
{
    protected $application;
    protected $component;
    protected $ambient;

	/**
	 * @return the $ambient
	 */
	public function getAmbient() {
		return $this->ambient;
	}

	/**
	 * @param $ambient the $ambient to set
	 */
	public function setAmbient($ambient) {
		$this->ambient = new Application_Model_Ambient();
		$mapper = new Application_Model_AmbientMapper();
		$mapper->find($ambient, $this->ambient);	
	}

	/**
	 * @return the $application
	 */
	public function getApplication() {
		return $this->application;
	}

	/**
	 * @return the $component
	 */
	public function getComponent() {
		return $this->component;
	}

	/**
	 * @param $application the $application to set
	 */
	public function setApplication($application_id) {
		$this->application = new Application_Model_Application();
		$applicationMapper = new Application_Model_ApplicationMapper();
		$applicationMapper->find($application_id, $this->application);	
	}

	/**
	 * @param $component the $component to set
	 */
	public function setComponent($component) {
		$this->component = new Application_Model_Component();
		$componentMapper = new Application_Model_ComponentMapper();
		$componentMapper->find($component, $this->component);
	}

}