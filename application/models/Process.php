<?php
/**
 * Arquivo de modelo para o mapeamento da tabela Process 
 * @author guarient
 *
 */
class Application_Model_Process
{
    protected $id;
	protected $type;
    protected $package;
    protected $appcom;
    protected $flow;

 
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @return the $package
	 */
	public function getPackage() {
		$package = $this->package;
		$packageMapper = new Application_Model_PackageMapper();
		$this->package = new Application_Model_Package();
		$packageMapper->find($package, $this->package);		
		return $this->package;
	}

	/**
	 * @return the $appcom
	 */
	public function getAppcom() {
		return $this->appcom;
	}

	/**
	 * @return the $flow
	 */
	public function getFlow() {
		return $this->flow;		
	}

	/**
	 * @param $flow the $flow to set
	 */
	public function setFlow($flow) {
	    $this->flow = new Application_Model_Flow();
	    $mapper 	= new Application_Model_FlowMapper();
	    $mapper->find($flow, $this->flow);
	}	
	
	/**
	 * @param $id the $id to set
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @param $type the $type to set
	 */
	public function setType($type) {
		$typeMapper = new Application_Model_TypeMapper();
		$this->type = new Application_Model_Type();
		$typeMapper->find($type, $this->type);	
	}

	/**
	 * @param $package the $package to set
	 */
	public function setPackage($package) {
		$this->package = $package;		
	}

	/**
	 * @param $appcom the $appcom to set
	 */
	public function setAppcom($appcom) {
		$appcomMapper	= new Application_Model_ApplicationComponentMapper();
		$this->appcom	= new Application_Model_ApplicationComponent();
		$appcomMapper->find($appcom, $this->appcom);
	}

	/**
	 * @param $ambient the $ambient to set
	 */
	public function setAmbient($ambient) {
//		$ambient		= $this->ambient;
		$ambientMapper	= new Application_Model_AmbientMapper();
		$this->ambient	= new Application_Model_Ambient();
		$ambientMapper->find($ambient, $this->ambient);
	}
}