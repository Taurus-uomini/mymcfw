<?php
    class db
    {
        private $dbinfo=array();
        private $dbh=null;
        private $result=null;
        private $tdata=null;
        function __construct($dbinfo, tdata $tdata)
        {
            $this->dbinfo=$dbinfo;
            $this->tdata=$tdata;
            $this->connect();
        }
        function connect()
        {
            try
            {
                $this->dbh=new PDO($this->dbinfo['sql'].':host='.$this->dbinfo['url'].';dbname='.$this->dbinfo['database'],$this->dbinfo['user'],$this->dbinfo['password'],array(PDO::ATTR_PERSISTENT=>true));
            }
            catch(PDOException $e)
            {
                $this->tdata->setTData('error','connect db fail!');
                $this->tdata->showInJson();
                exit(1);
            }
        }
        function close()
        {
            $this->dbh=null;
        }
        function sqlselect($sql)
        {
            if($this->result)
            {
                try
                {
                    $this->result->closeCursor();
                }
                catch(PDOException $e)
                {
                    $this->tdata->setTData('error','db fail!');
                    $this->tdata->showInJson();
                    exit(1);
                }
                $this->result=null;
            }
            try
            {
                $this->result=$this->dbh->query($sql);
            }
            catch(PDOException $e)
            {
                $this->tdata->setTData('error','db fail!');
                $this->tdata->showInJson();
                exit(1);
            }
            return $this->getresult();
        }
        function getresult()
        {
            if($this->result)
            {
                $data=array();
                try
                {
                    $data['count']=$this->result->columnCount();
                }
                catch(PDOException $e)
                {
                    $this->tdata->setTData('error','db fail!');
                    $this->tdata->showInJson();
                    exit(1);
                }
                if($data['count']>0)
                {
                    $result=array();
                    try
                    {
                        while($row=$this->result->fetch(PDO::FETCH_ASSOC))
                        {
                            array_push($result,$row);
                        }
                    }
                    catch(PDOException $e)
                    {
                        $this->tdata->setTData('error','db fail!');
                        $this->tdata->showInJson();
                        exit(1);
                    }
                    $data['result']=$result;
                }
                else
                {
                    $data['result']=null;
                }
                return $data;
            }
            else
            {
                return null;
            }
        }
    }
?>