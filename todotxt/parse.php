<?
	/***
	
		TODO.TXT Web Manager
		version 0.2

		Author:       Cezary Piekacz :: Cezex
		Release date: 2006-08-25
		Last update:  2006-10-18
		License:      GPL, http://www.gnu.org/copyleft/gpl.html
		
		For more information visit: http://redfish.pl/programy/todotxt
		
	 ***/

	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0', false);

	require('./parse.class.php');
	$TWM = new todotxtWebManager();
	 
	// file path to your todo file
	// remember to set permitions to 0666 (read/write user/group/all)

	$TWM->file = './todo.txt';

	// read todo file

	if (preg_match('/^GET/', $_SERVER[QUERY_STRING])) {
		echo $TWM->getText();
	}

	// write todo file

	if (preg_match('/^PUT/', $_SERVER[QUERY_STRING])) {
		$_POST[data] = iconv("UTF-8", "iso-8859-2", $_POST[data]); 
		$TWM->fileSave($_POST[data]);
		
		echo $_POST[data];
	}

	// sort todo file

	if (preg_match('/^SORT,([^,]+)/', $_SERVER[QUERY_STRING], $type)) {
		echo $TWM->sort($type[1]);
	}

	// generate view

	if (preg_match('/^VIEW/', $_SERVER[QUERY_STRING])) {
		echo $TWM->getView();
	}

	// generate summary
	
	if (preg_match('/^SUMMARY/', $_SERVER[QUERY_STRING])) {
		$lines = explode("\n", fileRead());
		foreach ($lines as $line) {
			if (preg_match('/p:([^ ]+)/', $line, $match))
				$projects{$match[1]}++;
		}

		foreach ($projects as $name=>$tasks) {
			$count{projects}++;
			$count{tasks} += $tasks;
		}

		echo 'You have ' . $count{tasks} . ' uncompleted tasks in ' . $count{projects} . ' projects.';
	}
?>
