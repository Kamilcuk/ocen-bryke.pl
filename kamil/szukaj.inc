<?php
require_once('db.inc');
function szukaj(array $args = array(), $sortuj = null) {
	$query = null;
	$where = null;
	$lastTable = null;
	foreach($args as $arg) {
		$pieces = explode(':', $arg);
		$thisTable = db::escape($pieces[0]);

		$idColumn = db::getFirstColumnName($thisTable);
		if ( $query == null ) {
			$query = "select ".$thisTable.".* from ".$thisTable;
		} else {
			$query = $query." INNER JOIN ".$thisTable.
			" ON `".$lastTable."`.`".$idColumn."` = `".$thisTable."`.`".$idColumn."` ";
		}
		
		array_shift($pieces);
		while ( sizeof($pieces) >= 2 ) {
			$addWhere = " `".$thisTable."`.`".db::escape($pieces[0])."` = '".db::escape($pieces[1])."' ";
			if ( $where != null ) {
				$where = $where." AND ".$addWhere;
			} else {
				$where = $addWhere;
			}
			array_shift($pieces);
			array_shift($pieces);
		}
		
		
		$lastTable = $thisTable;
	}
	if ( $where != null )
		$query .= " where ".$where;
	if ( $sortuj != null )
		$query .= " ORDER BY ".db::escape($sortuj).' ';
	return db::query($query);
}
?>