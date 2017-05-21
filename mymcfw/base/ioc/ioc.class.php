<?php
    class ioc
    {
        private $_dependencies=array();
        private $_reflenctions=array();
        private $_definitions=array();
        public function get($class)
        {
            if(isset($this->_definitions[$class]))
            {
                return $this->_definitions[$class];
            }
            return  $this->_definitions[$class]=$this->bulid($class);
        }
        private function bulid($class)
        {
            list($dependencies,$reflenction)=$this->getDependencies($class);
            $obj=$reflenction->newInstanceArgs($dependencies);
            return $obj;
        }
        private function getDependencies($class)
        {
            if(isset($this->_reflenctions[$class]))
            {
                return array($this->_dependencies[$class],$this->_reflenctions[$class]);
            }
            $dependencies=array();
            $reflenction=new ReflectionClass($class);
            $constructor=$reflenction->getConstructor();
            if($constructor!=null)
            {
                foreach ($constructor->getParameters() as $param) 
                {
                    $temp=$param->getClass();
                    if($temp==null)
                    {
                        $temp=$param->getName();
                        global $config;
                        if(isset($config[$temp]))
                        {
                            $dependencies[]=$config[$temp];
                        }
                        else
                        {
                            $tdata=new tdata();
                            $tdata->setTData('error','can not find dependence '.$temp.'!');
                            $tdata->showInJson();
                            exit(1);
                        }
                    }
                    else
                    {
                        $temp=$param->getName();
                        $dependencies[]=$this->get($temp);
                    }                    
                }
            }
            $this->_dependencies[$class]=$dependencies;
            $this->_reflenctions[$class]=$reflenction;
            return array($dependencies,$reflenction);
        }
    }
?>