function createRequest() {
	try {
		request = new XMLHttpRequest();
	}
	
	catch (trymicrosoft) {
		try {
			request = new ActiveXObject("Msxml2.XMLHTTP");
		}
		
		catch (othermicrosoft) {
			try {
				request = new ActiveXObject("Microsoft.XMLHTTP");
			}
			
			catch (failed) {
				request = false;
			}
		}
	}

	if (!request)
		alert("Error initializing XMLHttpRequest!");
}

function updatePage() {
	if (request.readyState == 4) {
		
		if (request.status == 200) {
			elInfo.style.display = 'none';

			if (isEdit())
				dat.value = request.responseText;
			else
				elMain.innerHTML = '<div class="view">'+request.responseText+'</div>';
		}
		
	}
}

function putText() {
	elInfo.innerHTML = 'Saving...';
	elInfo.style.display = 'block';
	
	request.open('POST', 'parse.php?PUT,' + now.getTime(), true);
	request.onreadystatechange = updatePage;
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8"); 
	request.send('data=' + dat.value);
}

function getText() {
	elInfo.innerHTML = 'Loading...';
	elInfo.style.display = 'block';
	
	if (isEdit())
		request.open('GET', 'parse.php?GET,' + now.getTime(), true);
	else
		request.open('GET', 'parse.php?VIEW,' + now.getTime(), true);
	
	request.onreadystatechange = updatePage;
	request.send(null);
}

function sortText(type) {
	elInfo.innerHTML = 'Sorting...';
	elInfo.style.display = 'block';
	
	request.open('GET', 'parse.php?SORT,' + type + ',' + now.getTime(), true);
	request.onreadystatechange = updatePage;
	request.send(null);
}

function onResize() {
	if (document.layers || (document.getElementById && !document.all)) { 
		browseWidth  = window.outerWidth;
		browseHeight = window.outerHeight - 158;
	}
	
	else if (document.all) {
		browseWidth  = document.body.clientWidth;
		browseHeight = document.body.clientHeight - 24;
	}
	
	if (isEdit())
		dat.style.height = browseHeight;
}

function onKeyUp() {
	var keyID = (window.event) ? event.keyCode : e.keyCode;
	
	if (keyID == 13)
			putText();

}

var delay;

function delayPutText() {
	window.clearTimeout(delay);
	delay = window.setTimeout('putText()', 5000);
}

function makeEdit() {
	if (!isEdit()) {
		elMain.innerHTML = '<textarea id="divData" onChange="putText()" onKeyUp="delayPutText()" onClick="delayPutText()" tabindex="3"></textarea>';
		elToolbar.innerHTML = '<a href="#" onClick="getText()">load</a>	<a href="#" onClick="putText()">save</a> | edit <a href="#" onClick="makeView()">view</a>	| sort by	<a href="#" onClick="sortText(\'PI\')">priority</a>	<a href="#" onClick="sortText(\'CN\')">context</a>	<a href="#" onClick="sortText(\'PR\')">project</a>';

		dat = document.getElementById('divData');
		onResize();
		getText();
	}
}

function makeView() {
	if (isEdit()) {
		elMain.innerHTML = '';
		elToolbar.innerHTML = 'load save | <a href="#" onClick="makeEdit()">edit</a> view</a>	| sort by priority context project';
		getText();
	}
}

function showSummary() {
}

function onLoad() {
	now = new Date();
	elInfo = document.getElementById('divInfo');
	elMain = document.getElementById('divMain');
	elToolbar = document.getElementById('divToolbar');
	
	createRequest();
	makeEdit();
}

function isEdit() {
	if (document.getElementById('divData'))
		return true;
	
	else
		return false;
}

window.onload = onLoad;
document.onkeyup = onKeyUp;
document.onresize = onResize;
document.ondblclick = makeEdit;
