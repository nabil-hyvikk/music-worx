<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'vendor/autoload.php';

class Redis_lib {
    protected $CI;
    protected $redis;
    protected $cred;
    public function __construct($params = array()){
        $this->CI =& get_instance();
        $this->cred=$this->CI->config->item('redis');
        $this->redis = new Predis\Client([
		    'scheme' => 'tcp',
		    'host'   => $this->cred['host'],
		    'port'   => $this->cred['port'],
		    'password' => $this->cred['pass'],
		    'database' => $this->cred['database']
		]);
    }

	public function set($name, $value, $expire=null){
		if(is_null($expire)){
			$this->redis->set($this->cred['prefix'].$name, $value);
		}else{
			$this->redis->set($this->cred['prefix'].$name, $value, 'EX', $expire);
		}
	}

	public function get($name){
		return $this->redis->get($this->cred['prefix'].$name);
	}

	public function remove_key($name){
		return $this->redis->del($this->cred['prefix'].$name);
	}

	public function get_all_keys(){
		return $this->redis->keys('*');
	}

	public function remove_all_keys(){
		$this->redis->flushAll();
	}

	public function remove_prefix_keys($prefix){
		$keys=$this->redis->keys($this->cred['prefix'].$prefix.'*');
		if(!empty($keys)){
			$this->redis->del($keys);
		}
	}

}