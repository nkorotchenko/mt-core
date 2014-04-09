<?php

class Sql {

	private $connection = false;
	private $connectionParams = false;

	/*
	* pconnect = 1 or 0, server = localhost, name = db name, user = root, password = ""
	*/
	public function Open($params)
	{
		if (!is_array($params))
			return false;
			
		if ($this->connection)
			return $this->connection;
			
		$this->connectionParams = $params;
			
		if ($params["pconnect"] != 0)
			$this->connection = mysql_pconnect($params["server"], $params["user"], $params["password"] );
		else
			$this->connection = mysql_connect($params["server"], $params["user"], $params["password"] );

		if ( !$this->connection )
			return false;
			
		$res = mysql_select_db( $params["name"] ) ;

		if ( !$res )
			return false;

		mysql_query('set character_set_client="utf8"');
		mysql_query('set character_set_results="utf8"');
		mysql_query('set collation_connection="utf8_general_ci"');

		return $this->connection;
			
	}
	
	public function Close()
	{
		if ($this->connection && $this->connectionParams["pconnect"] == 0)
		{
			mysql_close($this->connection);
			$this->connection = false;
		}
	}
	
	public function SetAutoCommit($value)
	{
		return mysql_query( "SET AUTOCOMMIT=$value" );
	}
	
	public function Begin()
	{
		return mysql_query( "START TRANSACTION;" );
	}
	
	public function Commit()
	{
		return mysql_query( "COMMIT" );
	}
	
	public function Rollback()
	{
		return mysql_query( "ROLLBACK" );
	}
	
	public function RowsCount($result)
	{
		return mysql_num_rows($result);
	}
	
	public function FieldsCount($result)
	{
		return mysql_num_rows($result);
	}
	
	public function InsertId($connectHandle=null)
	{
		return mysql_insert_id($connectHandle);
	}
	
	public function Fetch($result)
	{
		return mysql_fetch_array( $result );
	}
	
	public function Query($query_text)
	{
		if ( $this->connection )
		{
			$result = mysql_query( $query_text );
			if ( $result )
			{
				if ( mysql_num_rows( $result ) == 0 )
					return false;
					
				return $result;
			}
			else return false;
		}
		return false;
	}
	
	public function Exec($string)
	{
		if ( $system["db"] )
		{
			return mysql_query( $query_text );
		}
	}
	
	public function Free($result)
	{
		mysql_free_result( $result );
	}
}
?>