/**
 * functions to get git branches and echo with json format
 *
 * @author     Zackexplosion <cstony0917@gmail.com>
 */
function get_branches(){
	// branches, bs
	$bs = shell_exec('git branch');
	$bs = explode(PHP_EOL, $bs);

	// output
	$o = array();

	foreach ($bs as $k => $b) {
		if( strlen($b) <= 0 ){
			unset($bs[$k]);
		}else{
			$b = trim($b);

			// contains * string is the current branch
			if( strpos($b, '*') !== false ){
				$o['current'] = explode(' ', $b)[1];
			}
			// with / string means it's a nested branch
			else if( strpos($b, '/') !== false){
				$exploded = explode('/', $b);
				$key = $exploded[0];
				$o[$key][] = $exploded[1];
			}
			else{
				$o[$b] = $b;
			}
		}
	}

	return $o;
}

function echo_branches(){
	echo json_encode( get_branches() );
}
