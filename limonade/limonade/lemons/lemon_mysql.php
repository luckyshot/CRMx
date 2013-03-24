<?php
/**
 * A quick little function to interact with a MySQL database.
 * https://gist.github.com/AngeloR/919695
 * 
 * When working with Limonade-php a full-fledged MySQL wrapper seems like
 * overkill. This method instead accepts any mysql statement and if it works
 * returns either the result or the number of rows affected. If neither worked,
 * then it returns false
 *
 * @param   string      $sql    the sql statement you want to execute
 * @param   resource    $c      mysql connect link identifier, if multi-connect
 *                              otheriwse, you can leave it blank
 * @return  MIXED       array   the result set if the sql statement was a SELECT
 *                      integer if the sql statement was INSERT|UPDATE|DELETE
 *                      bool    if anything went wrong with executing your statement
 *
 * Usage:
 * 
 * $c = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
 * 
 * [update|insert|delete]
 * 
 * if(db('update mytable set myrow = 4 where someotherrow = 3') !== false) {
 *  // worked!
 * }
 *
 * [select]
 * $res = db('select * from mytable');
 */
function db($sql,$c = null) {
	$res = false;
	$q = ($c === null)?@mysqli_query($sql):@mysqli_query($c,$sql);

	if($q) {
		if(strpos(strtolower($sql),'select') === 0) {
			$res = array();
			while($r = mysqli_fetch_assoc($q)) {
				$res[] = $r;
			}
		} else {
			$res = ($c === null)?mysqli_affected_rows():mysqli_affected_rows($c);
		}
	}
	return $res;
}
