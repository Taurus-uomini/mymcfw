<?php
    class db
    {
        private $dbinfo=array();
        private $mysqli=null;
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
            $this->mysqli=new mysqli($this->dbinfo['url'],$this->dbinfo['user'],$this->dbinfo['password'],$this->dbinfo['database']);
            if(mysqli_connect_errno())
            {
                $this->set('error','connect db fail!');
                $this->showInJson();
                exit(1);
            }
            $this->mysqli->set_charset("utf8");
        }
        function close()
        {
            $this->mysqli->close();
        }
        function sqlselect($sql)
        {
            if($this->result)
            {
                $this->result->close();
            }
            $this->result=$this->mysqli->query($sql);
            return $this->getresult();
        }
        function getresult()
        {
            if($this->result)
            {
                $data=array();
                $data['count']=$this->result->num_rows;
                if($data['count']>0)
                {
                    $result=array();
                    while($row=$this->result->fetch_array(MYSQLI_ASSOC))
                    {
                        array_push($result,$row);
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