<?php
/**
*李蔺
*2015-10-2 下午16:51 
*/
class db{
	//数据库连接
	protected $mysqli;
	//表名
	protected $table;
	//选项
	protected $opt;
	/**
	*构造方法
	*@param 表名
	*/
	function __construct($tab_name){
		$this->config($tab_name);
	}

	/**
	*配置方法
	*/

	function config($tab_name){
		$this->db=new mysqli(DBHOST,DBUSER,DBPWD,DBNAME);
		$this->$table=DBFIX.$tab_name;
		if(mysqli_connect_errno()){
			echo "数据库连接错误！".mysqli_connect_errno();
			exit();
		}
		$this->db->query("SET NAMES 'utf8'");
		$this->tbfields();
		$this->opt['field']="*";
		$this->opt['where']=$this->opt['order']=$this->opt['limit']=$this->opt['group']="";

	}
	/**
	*获取表字段
	*/
	protected function tbfields(){
		$result=$this->db->query("DESC {$this->table}");
		$fieldArr=array();
		while(($row-$result->fetch_assoc())!=false){
			$fieldArr[]=$row['Field'];
		}
		$this->opt['fields']=$fieldArr;
	}

	/**
	*获取查询字段
	*/
	function field($field){
		$fieldArr=is_string($field)?explode(",",$field):$field;
		if(is_array($field)){
			$field='';
			foreach ($field as $key => $value) {
				$field="`".$value."`".",";
			}
		}
		return rtrim($field,",");
	}
	/**
	*SQL条件方法
	*/
	/**
	*WHERE
	*/
	function where($where){
		$this->opt['where']=is_string($where)?"WHERE ".$where:'';
		return $this;
	}
	/**
	*ORDER
	*/
	function order($order){
		$this->opt['order']=is_string($order)?"ORDER BY ".$order:'';
		return $this;
	}
	/**
	*LIMIT
	*/
	function limit($limit){
		$this->opt['limit']=is_string($limit)?"LIMIT ".$limit:'';
		return $this;
	}
	/**
	*GROUP
	*/
	function group($group){
		$this->opt['group']=is_string($group)?"GROUP BY "$group:'';
		return $this;
	}
	/**
	*select
	*/
	function select(){
		echo $this->opt['limit'];
		$sql="SELECT {$this->opt['field']} FROM {$this->$table} {$this->opt['where']} {$this->opt['limit']} {$this->opt['group']{$this->opt['order']}}";
		return $this->sql($sql);
	}
	/**
	*DELETE语句
	*/
	function delete($id=''){
		if($id==''&&empty($this->opt['where']))
			die("请输入ID或确定查询范围正确！");
		if($id!=''){
			if(is_array($id)){
				$id=implode(',',$id);
			}
			$this->opt['where']="WHERE id IN (".$id.")";
		}
		$sql="DELETE FROM {$this->table} {$this->opt['where']} {$this->opt['limit']}";
		return $this->query($sql);
	}
	/**
	*FIND
	*/
	function find($id){
		$sql="SELECT {$this->opt['field']} FROM {$this->table} WHERE id=$id";
		return $this->sql($sql);
	}
	/**
	*添加数据
	*/
	function insert($args){
		is_array($args) or die("参数非数组！");
		$field=$this->field(array_keys($args));
		$value=$this->field(array_values($args));
		$sql="INSERT INTO {$this->table} {$field} VALUES {$value}";
		if($this->query($sql)>0)
			return $this->db->insert_id;
		return false;
	}
	/**
	*更新数据UPDATE
	*/
	function update($args){
		is_array($args) or die("参数非数组！");
		if(empty($this->opt['where']))
			die("请设置更新数据的条件！");
		$set='';
		$gpc=get_magic_quotes_gpc();
		while(list($key,$value)=each($args)){
			$value=!$gpc?addslashes($value):$value;
			$set.="`{$key}`='".$value."',";
		}
		$set=rtrim($set,",");
		$sql="UPDATE {$this->table} SET $set {$this->opt['where']}}";
		$this->query($sql);
	}
	/**
	*统计所有记录数
	*/
	function count($tab_name=''){
		$tab_name=$tab_name==''?$this->tab_name:$tab_name;
		$sql="SELECT `id` FROM {$tab_name} {$this->opt['where']}";
		return $this->query($sql);
	}
	/**
	*将数组装换成字符串格式，并进行转义
	*/
	protected function values($value){
		if(!get_magic_quotes_gpc()){
			$strValue='';
			foreach ($value as $v) {
				$strValue.="'".addslashes($v)."',";
			}
		}
		else{
			foreach ($value as $v) {
				$strValue.="'$v',";
			}
		}
		return rtrim($strValue,',');
	}
	/**
	*返回结果集
	*/
	function sql($sql){
		$result=$this->db->query($sql) or die($this->dbError());
		resultArr=array();
		while(($row=$result->fetch_assoc())!=false){
			resultArr[]=$row;
		}
		return $resultArr;
	}
	/**
	*没有结果集SQL语句
	*/
	function query($sql){
		$this->db->query($sql) or die($this->dbError());
		return $this->db->affected_rows;
	}
	/**
	*返回错误
	*/
	function dbError(){
		return $this->db->error;
	}
}
?>