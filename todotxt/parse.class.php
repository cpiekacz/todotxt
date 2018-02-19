<?
	/***
	
		TODO.TXT Web Manager Class
		version 0.2

		Author:       Cezary Piekacz :: Cezex
		Release date: 2006-08-25
		Last update:  2006-10-18
		License:      GPL, http://www.gnu.org/copyleft/gpl.html
		
		For more information visit: http://redfish.pl/programy/todotxt
		
	 ***/

	 Class todotxtWebManager {
	 
		// default file path to your todo file
		// remember to set permitions to 0666 (read/write user/group/all)

		var $file = './todo.txt';
	 
		// read todo file

		function fileRead() {
			if (!file_exists($this->file))
				return 'ERROR: file does not exist';
			
			if ($f = fopen($this->file, 'r')) {
				while(!feof($f))
					$str .= fgets($f,1024);
				fclose($f);
				
				return $str;
			}
			
			else
				return 'ERROR: cannot read from file';
		}
	
		// write todo file
		
		function fileSave($str) {
			if ($f = fopen($this->file, 'w')) {
				fputs($f, $str, strlen($str));
				fclose($f);
			}
			
			else
				return false;
		}

		// match project
		
		function matchPR($line) {
			preg_match('/(^p:| p:)([^ ]+)/', $line, $match);
			return $match[2];
		}
		
		// match priority
		
		function matchPI($line) {
			preg_match('/(^\(| \()([A-Z0-9]+)\)/i', $line, $match);
			return $match[2];
		}
		
		// match context
		
		function matchCN($line) {
			preg_match('/(^@ | @)([^ ]+)/', $line, $match);
			return $match[2];
		}
		
		// compare by priority
		
		function cmpPI($line1, $line2) {
			$priority1 = $this->matchPI($line1);
			$priority2 = $this->matchPI($line2);

			if ($priority1 == $priority2) {
				if ($line1 == $line2)
					return 0;
				
				return ($line1 < $line2) ? -1 : 1;
			}
			
			if ($priority1 != '' && $priority2 == '')
				return -1;
			
			if ($priority1 == '' && $priority2 != '')
				return 1;
			
	    return ($priority1 < $priority2) ? -1 : 1;
		}
		
		// compare by project

		function cmpPR($line1, $line2) {
			$project1 = $this->matchPR($line1);
			$project2 = $this->matchPR($line2);

			if ($project1 == $project2) {
				if ($line1 == $line2)
					return 0;
				
				return ($line1 < $line2) ? -1 : 1;
			}
			
			if ($project1 != '' && $project2 == '')
				return -1;
			
			if ($project1 == '' && $project2 != '')
				return 1;
			
	    return ($project1 < $project2) ? -1 : 1;
		}

		// compare by context

		function cmpCN($line1, $line2) {
			$context1 = $this->matchCN($line1);
			$context2 = $this->matchCN($line2);

			if ($context1 == $context2) {
				if ($line1 == $line2)
					return 0;
				
				return ($line1 < $line2) ? -1 : 1;
			}
			
			if ($context1 != '' && $context2 == '')
				return -1;
			
			if ($context1 == '' && $context2 != '')
				return 1;
			
	    return ($context1 < $context2) ? -1 : 1;
		}

		function getText() {
			return $this->fileRead();
		}
		
		function getView() {
		
			$lines = explode("\n", $this->fileRead());
			
			foreach ($lines as $line) {
				$priority = $this->matchPI($line);
				$project  = $this->matchPR($line);
				$context  = $this->matchCN($line);
					
				if (preg_match('/ln(#[A-F0-9]{6})/i', $line, $match))
					$line = '<span style="color:' . $match[1] . '">' . preg_replace('/ln' . $match[1] . '/', '', $line) . '</span>';

				elseif (preg_match('/pi(#[A-F0-9]{6})/i', $line, $match)) {
					$line = '<span style="color:' . $match[1] . '">' . preg_replace('/pi' . $match[1] . '/', '', $line) . '</span>';
					$color_priorities{$priority} = $match[1];
				}
				
				elseif (preg_match('/pr(#[A-F0-9]{6})/i', $line, $match)) {
					$line = '<span style="color:' . $match[1] . '">' . preg_replace('/pr' . $match[1] . '/', '', $line) . '</span>';
					$color_projects{$project} = $match[1];
				}
				
				elseif (preg_match('/cn(#[A-F0-9]{6})/i', $line, $match)) {
					$line = '<span style="color:' . $match[1] . '">' . preg_replace('/cn' . $match[1] . '/', '', $line) . '</span>';
					$color_contexts{$context} = $match[1];
				}
				
				elseif ($color_priorities{$priority} != '')
					$line = '<span style="color:' . $color_priorities{$priority} . '">' . $line . '</span>';
					
				elseif ($color_projects{$project} != '')
					$line = '<span style="color:' . $color_projects{$project} . '">' . $line . '</span>';

				$str .= $line . '<br />';
			}
			
			return $str;
		}

		// sort todo file

		function sort($type) {
			$str   = $this->fileRead();
			$str   = preg_replace('/[\n\r]*$/', '', $str);
			$lines = explode("\n", $str);
			
			usort($lines, array($this, "cmp$type"));
			
			$str   = implode("\n", $lines);
			$this->fileSave($str);

			return $str;
		}
		
	}
?>
