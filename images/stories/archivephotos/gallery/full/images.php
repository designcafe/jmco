<?php
if ($handle = opendir(getcwd())) {
	$files = array();
    while (false !== ($file = readdir($handle))) {
    	if (strrpos($file,".") !== false && $file != "xml_dir_parse.php") {
    		$ext = strtolower(trim(substr($file,strrpos($file,"."))));
    		if (strlen($ext) >= 3) {array_push($files,$file);}
    	}
    }
    closedir($handle);
    if (count($files) > 0) {
    	$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?><photos path=\"images/gallery/\">";
    	for ($i=0;$i<count($files);$i++) {
    		$xml .= "<photo name=\"Photo\" url=\"".$files[$i]."\">This is the optional description for photo 1</photo>";
    	}
    	$xml .= "</photos>";
    }
    echo $xml;
}

/*
----------------------------------------------------------------------------------------
TO USE AS A METHOD:
----------------------------------------------------------------------------------------

function getDirListing() {
	$xml = "";
	if ($handle = opendir(getcwd())) {
		$files = array();
	    while (false !== ($file = readdir($handle))) {
	    	if (strrpos($file,".") !== false && $file != "xml_dir_parse.php") {
	    		$ext = strtolower(trim(substr($file,strrpos($file,"."))));
	    		if (strlen($ext) >= 3) {array_push($files,$file);}
	    	}
	    }
	    closedir($handle);
	    if (count($files) > 0) {
	    	$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?><photos path=\"images/gallery/\">";
	    	for ($i=0;$i<count($files);$i++) {
	    		$xml .= "<photo name=\"Photo\" url=\"".$files[$i]."\">This is the optional description for photo 1</photo>";
	    	}
	    	$xml .= "</photos>";
	    }
	}
	
	return $xml;
}

// To use in a class simply wrap in a class. i.e. class xmlDirListing { // function }

----------------------------------------------------------------------------------------
XML FORMAT RETURNED:
----------------------------------------------------------------------------------------
<?xml version="1.0" encoding="utf-8"?>
<photos path="images/gallery/">
    <photo name="Photo" url="1.jpg">This is the optional description for photo 1</photo>    
    <photo name="Photo" url="2.jpg">This is the optional description for photo 2</photo>    
    <photo name="Photo" url="3.jpg">This is the optional description for photo 3</photo>    
    <photo name="Photo" url="4.jpg">This is the optional description for photo 4</photo>    
    <photo name="Photo" url="5.jpg">This is the optional description for photo 5</photo>
    <photo name="Photo" url="6.jpg">This is the optional description for photo 6</photo>
    <photo name="Photo" url="7.jpg">This is the optional description for photo 7</photo>
    <photo name="Photo" url="8.jpg">This is the optional description for photo 8</photo>
    <photo name="Photo" url="9.jpg">This is the optional description for photo 9</photo>    
</photos> 
----------------------------------------------------------------------------------------
*/
?>