<?php

/**
  V4.64 20 June 2005  (c) 2000-2005 John Lim (jlim@natsoft.com.my). All rights reserved.
  Released under both BSD license and Lesser GPL library license.
  Whenever there is any discrepancy between the two licenses,
  the BSD license will take precedence.

  Set tabs to 4 for best viewing.

*/

// security - hide paths
if (!defined('ADODB_DIR')) die();

class ADODB2_sqlite extends ADODB_DataDict {

	public $databaseType = 'sqlite';
	public $seqField = false;


 	public function ActualType($meta)
	{
		switch($meta) {
		case 'C': return 'VARCHAR';
		case 'XL': return 'TEXT';
		case 'X': return 'TEXT';

		case 'C2': return 'VARCHAR';
		case 'X2': return 'TEXT';

		case 'B': return 'BLOB';

		case 'D': return 'DATE';
		case 'T': return 'DATETIME';

		case 'L': return 'BOOLEAN';
		case 'I': return 'INTEGER';
		case 'I1': return 'INTEGER';
		case 'I2': return 'INTEGER';
		case 'I4': return 'INTEGER';
		case 'I8': return 'INTEGER';

		case 'F': return 'FLOAT';
		case 'N': return 'DECIMAL';
		default:
			return $meta;
		}
	}

    public function MetaType($t,$len=-1,$fieldobj=false)
	{
        if (is_object($t)) {
            $fieldobj = $t;
            $t = $fieldobj->type;
            $len = $fieldobj->max_length;
        }
        switch (strtoupper($t)) {
            case 'TEXT':
                return 'X';
            case 'FLOAT':
            case 'DOUBLE':
                return 'F';
        }
        return parent::MetaType($t,$len,$fieldobj);
	}

	public function AlterColumnSQL($tabname, $flds, $tableflds='',$tableoptions='')
	{
		if ($this->debug) ADOConnection::outp("AlterColumnSQL not supported");
		return array();
	}


	public function DropColumnSQL($tabname, $flds, $tableflds='',$tableoptions='')
	{
		if ($this->debug) ADOConnection::outp("DropColumnSQL not supported");
		return array();
	}
}

