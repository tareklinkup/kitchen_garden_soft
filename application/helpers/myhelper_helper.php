<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function My_StringCutter($data, $length){
   return substr(mysql_real_escape_string(strip_tags($data)), 0, $length);
}
function SubscribdType($data){
    if($data == l) return "Subscribe Comment & Post";
    else if($data == 2) return "Subscribe Only Comment";
    else if($data == 3) return "Subscribe Only Post";
    else if($data == 4) return "No Subscribe";
}
function UserType($data){
    if($data == 'l') return "Learner";
    else if($data == 's') return "Student";
    else if($data == 't') return "Trader";
    else if($data == 'p') return "Professional";
    else if($data == 'tr') return "Trainer";
    else if($data == 'b') return "Broker Staff";
    else if($data == 'm') return "Master";
    else if($data == 'a') return "Admin";
}
function Replace($data){
    $data = str_replace("'", "", $data); 	
    $data = str_replace("!", "", $data); 
    $data = str_replace("@", "", $data); 
    $data = str_replace("#", "", $data); 
    $data = str_replace("$", "", $data); 
    $data = str_replace("%", "", $data); 
    $data = str_replace("^", "", $data); 
    $data = str_replace("&", "", $data); 
    $data = str_replace("*", "", $data); 
    $data = str_replace("(", "", $data); 
    $data = str_replace(")", "", $data);     
    $data = str_replace("+", "", $data); 
    $data = str_replace("=", "", $data); 
    $data = str_replace(",", "", $data); 
    $data = str_replace(":", "", $data); 
    $data = str_replace(";", "", $data); 
    $data = str_replace("|", "", $data); 
    $data = str_replace("'", "", $data); 
    $data = str_replace('"', "", $data); 
    $data = str_replace("?", "", $data); 
    $data = str_replace("  ", "_", $data); 
    $data = str_replace("'", "", $data);
    return strtolower(str_replace(" ", "_", $data));     
}

function My_Description($file){
   $data = read_file($file);
   //$data = str_replace("<a href=\"", "<a href=\"" . base_url(), $data);  
   $data = str_replace("../../images/", base_url() . "images/", $data); 
   $data = str_replace("../../", base_url(), $data);
   return $data;
}

function My_URL_Converter($data){
   $data = str_replace("<a href=\"", "<a href=\"" . base_url(), $data); 
   $data = str_replace("<a href=\"" . base_url() . "http", "<a href=\"" ."http", $data);
   $data = str_replace("<a href=\"" ."http", "<a href=\"" ."https", $data); 
   $data = str_replace("../../images/", base_url() . "images/", $data); 
   $data = str_replace("../../", base_url(), $data);
   return $data;
}

function ImageConfig($url){
    $config['upload_path'] = $url;
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size']	= '10000';
    $config['max_width']  = '5044';
    $config['max_height']  = '5048';
    return $config;
}

function YesNo($data) {
	if($data != "") {
		echo "Yes";	
	}else{
		echo "No";	
	}
}

function Table($r, $edit, $delete)
{
	if($r =="")
	{
		print '<tr><td>No Data Found</td></tr>';
	}
	else
	{		
		$f = 0;
		for($i = 0; $i < count($r); $i++)
		{
			if($f % 2 == 0)	{
				print "<tr bgcolor='#E3E1FD' style='font-size:14px; line-height:25px;'>";
			}else{
				print "<tr bgcolor='#FFE6E6' style='font-size:14px; line-height:25px;'>";
			}
			$f++;			
			for($j = 1; $j < count($r[$i]); $j++)
			{
				print '<td>';
				if(substr($r[$i][$j], -4) == ".txt") {					
					WordCount(Strip(ReadFiles($r[$i][$j], "All")), 10);					
				}
				else if((substr($r[$i][$j], -4) == ".jpg") || (substr($r[$i][$j], -4) == "jpeg") || 
						(substr($r[$i][$j], -4) == ".png") || (substr($r[$i][$j], -4) == ".gif")) {
					Image("images/" . $r[$i][$j], "200px");	
				}
				else{
					print $r[$i][$j];
				}	
				print '</td>';
			}
			if($edit != "" && $delete != "") {
				print '<td><a href="?o='.$edit.'&eid='.$r[$i][0].'">Edit</a></td>';
		?>		
				<td><a href="javascript:confirmCon('?o=<?php echo $delete ?>&did=<?php echo $r[$i][0]; ?>')">Delete</a></td>
		<?php		
				
			}
			else if($edit != "" && $delete == "") {
				print '<td><a href="?o='.$edit.'&eid='.$r[$i][0].'">Edit</a></td>';
			}
			else if($e == "" && $d != "") {
		?>		
				<td><a href="javascript:confirmCon('?o=<?php echo $delete ?>&did=<?php echo $r[$i][0]; ?>')">Delete</a></td>
		<?php		
			}
			print '</tr>';
		}
	}
}

function Select($r)
{
    for($i = 0; $i < count($r); $i++)
    {
            print "<option value=".$r[$i][0].">".$r[$i][1] . "</option>";		
    }
}

function Selected($r, $sel)
{
	for($i = 0; $i < count($r); $i++)
	{
		if($r[$i][0] == $sel) 
		{
			print "<option selected='selected' value=".$r[$i][0].">".$r[$i][1] . "</option>";		
		}else{
			print "<option value=".$r[$i][0].">".$r[$i][1] . "</option>";		
		}	
	}
}

function SelectTwo($all, $sel){
   if($sel){
      for($i = 0; $i < count($all); $i++)
	{
         $temp = 0;
         for($j = 0; $j < count($sel); $j++) {
		if($sel[$j][0] == $all[$i][0]){
               $temp++;
               break;
            }            
         }
         if($temp > 0){
            print "<option selected='selected' value=".$all[$i][0].">".$all[$i][1] . "</option>";		
         }else{
            print "<option value=".$all[$i][0].">".$all[$i][1] . "</option>";		
         }
	}
   }else{
      for($i = 0; $i < count($all); $i++)
	{
		print "<option value=".$all[$i][0].">".$all[$i][1] . "</option>";		
	}
   }   
}

function Escape($data) {
	return mysql_real_escape_string($data);
}
	
function MS($data) {
	return mysql_real_escape_string(strip_tags($data));
}
function Strip($data) {
	return strip_tags($data);
}

function CreateFile($file, $data) {
		$fh = fopen($file, "w"); //create file with write mode
		fwrite($fh, $data . " "); //write data into that file
		fclose($fh); //close that file	
}

function ReadFiles($nm, $ln)	{	
	$fh = fopen($nm, "r");
	$dataa = fread($fh, filesize($nm));
	fclose($fh);
	if($ln == "All") {
		return str_replace('\"', '"', $dataa);
	}
	else {
		return substr(Strip($dataa), 0, $ln);
	}	
}

function Extension($data) {
    $tmp = "";
    if($data['name'] != "") {
             $x = pathinfo($data['name']);
             $x = strtolower($x['extension']);
             if($x == 'jpg' || $x == 'jpeg' || $x == 'png' || $x == 'gif') {
                    $tmp = $x;	 
             }
    }
    return $tmp;
}

function UploadPicture($nm, $org) {			
	if(Extension($org) != "") {
		$nm = $nm . "." . Extension($org);
		copy($org['tmp_name'], $nm); 	
	}
}

function UpdatePicture($nm, $org, $prv) {
	if(Extension($org) != "") {
		if($prv != "") {
			$tmp = $nm . "." . $prv;
			unlink($tmp);	
		}	
		UploadPicture($nm, $org);	
		return Extension($org);	
	}else{
		return $prv;	
	}
}


function Image($data, $width)
{
	if($data != "")
	{
		echo "<img src='{$data}' width='{$width}' />";
	}
	else {
		echo "<img src='image/no_image.png' width='{$width}' />";
	}
}

function ImageEdit($ext, $url, $width)
{
	if($ext != "")
	{
		echo "<img src='{$url}.{$ext}' width='{$width}' />";
	}
	else {
		echo "No Image";
	}
}

function Image1($data, $url, $width, $height)
{
	if($data != "")
	{
		echo "<img src='{$url}{$data}' width='{$width}' height='{$height}' />";
	}
	else {
		echo "<img src='image/no_image.png' width='{$width}' height='{$height}' />";
	}
}

function Numeric($data){
	if(is_numeric($data)) {
    	return true;    	
	} else {
		return false;
    }	
}

function RandString($num){
	$str = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", 
				 "u", "v", "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", 
				 "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
	$data = "";				
	while($num > 0) {
		$data .= $str[rand(0, count($str)-1)];
		$num--;
	}
	return $data;
}

function WordCount($data, $count){
	$t=$data;
	$str = "";	
	for($i=0; $i < strlen($data); $i++) {
		if(substr($t, 0, 1) == " "){
			$str .= " ";
			$t = substr($t, 1);
			$count--;			
			if($count == 0){
				break;
			}
		}else{
			$str .= substr($t, 0, 1);
			$t = substr($t, 1);
		}
	}
	echo $str;
}


function isValidEmail($email) {
    	return filter_var($email, FILTER_VALIDATE_EMAIL) 
    	    && preg_match('/@.+\./', $email);
	}

function MsgError($data) {
	echo "<b style='color:#F90000; font-size:14px;'>{$data}</b>";	
}

function MsgSuccess($data) {
	echo "<b style='color:#00D535; font-size:14px;'>{$data}</b>";	
}

function Star1($data) {
	if($data > 4.5)	{
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
	}
	else if($data > 4)	{
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/half.png' width='30' />";	
	}
	else if($data > 3.5)	{
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/no.png' width='30' />";	
	}
	else if($data > 3)	{
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/half.png' width='30' />";	
		echo "<img src='".  base_url()."images/no.png' width='30' />";	
	}
	else if($data > 2.5)	{
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/no.png' width='30' />";	
		echo "<img src='".  base_url()."images/no.png' width='30' />";	
	}
	else if($data > 2)	{
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/full.png' width='30' />";			
		echo "<img src='".  base_url()."images/half.png' width='30' />";	
		echo "<img src='".  base_url()."images/no.png' width='30' />";	
		echo "<img src='".  base_url()."images/no.png' width='30' />";	
	}
	else if($data > 1.5)	{
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/no.png' width='30' />";	
		echo "<img src='".  base_url()."images/no.png' width='30' />";	
		echo "<img src='".  base_url()."images/no.png' width='30' />";	
	}
	else if($data > 1)	{
		echo "<img src='".  base_url()."images/full.png' width='30' />";			
		echo "<img src='".  base_url()."images/half.png' width='30' />";	
		echo "<img src='".  base_url()."images/no.png' width='30' />";	
		echo "<img src='".  base_url()."images/no.png' width='30' />";	
		echo "<img src='".  base_url()."images/no.png' width='30' />";	
	}
	else if($data > .5)	{
		echo "<img src='".  base_url()."images/full.png' width='30' />";	
		echo "<img src='".  base_url()."images/no.png' width='30' />";	
		echo "<img src='".  base_url()."images/no.png' width='30' />";	
		echo "<img src='".  base_url()."images/no.png' width='30' />";	
		echo "<img src='".  base_url()."images/no.png' width='30' />";	
	}
}
function Star($data) {
	if($data > 4.5)	{
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
	}
	else if($data > 4)	{
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/half.png' width='20' />";	
	}
	else if($data > 3.5)	{
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/no.png' width='20' />";	
	}
	else if($data > 3)	{
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/half.png' width='20' />";	
		echo "<img src='".  base_url()."images/no.png' width='20' />";	
	}
	else if($data > 2.5)	{
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/no.png' width='20' />";	
		echo "<img src='".  base_url()."images/no.png' width='20' />";	
	}
	else if($data > 2)	{
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/full.png' width='20' />";			
		echo "<img src='".  base_url()."images/half.png' width='20' />";	
		echo "<img src='".  base_url()."images/no.png' width='20' />";	
		echo "<img src='".  base_url()."images/no.png' width='20' />";	
	}
	else if($data > 1.5)	{
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/no.png' width='20' />";	
		echo "<img src='".  base_url()."images/no.png' width='20' />";	
		echo "<img src='".  base_url()."images/no.png' width='20' />";	
	}
	else if($data > 1)	{
		echo "<img src='".  base_url()."images/full.png' width='20' />";			
		echo "<img src='".  base_url()."images/half.png' width='20' />";	
		echo "<img src='".  base_url()."images/no.png' width='20' />";	
		echo "<img src='".  base_url()."images/no.png' width='20' />";	
		echo "<img src='".  base_url()."images/no.png' width='20' />";	
	}
	else if($data > .5)	{
		echo "<img src='".  base_url()."images/full.png' width='20' />";	
		echo "<img src='".  base_url()."images/no.png' width='20' />";	
		echo "<img src='".  base_url()."images/no.png' width='20' />";	
		echo "<img src='".  base_url()."images/no.png' width='20' />";	
		echo "<img src='".  base_url()."images/no.png' width='20' />";	
	}
}
function Point($data) {
	if($data >= 3.8) {
		echo "<img src='image/star_g_small.gif' />";			
		echo "&nbsp;&nbsp;Positive:";	
		echo $data . "points";
	}
	else if($data > 2) {
		echo "<img src='image/star_n_small.gif' />";			
		echo "&nbsp;&nbsp;Neutral:";	
		echo $data . "points";
	}else{
		echo "<img src='image/star_b_small.gif' />";			
		echo "&nbsp;&nbsp;Negative:";
		echo $data . "points";
	}
}

function My_DateConverter($data){
	if($data != "") {
		$data = substr($data, -4) . "-" . substr($data, 0, 2) . "-" . substr($data, 3, 2);
	}
	return $data;
}
function My_DateReverse($data){
	if($data != "") {
		$data =  substr($data, 5, 2) . "/" . substr($data, -2) . "/" . substr($data, 0, 4);
	}
	return $data;
}

function Bangla($data) {
	$x = $data;
	$msg = "";
	$count = 0;
	for($i = 0; $i < strlen($data); $i++) {
		if($count != 0) {
			$count++;	
		}		
		$p = substr($x , 0, 1);			
		if($p == 1) {
			$msg .= "à§§";	
		}
		else if($p == 2) {
			$msg .= "à§¨";	
		}
		else if($p == 3) {
			$msg .= "à§©";	
		}
		else if($p == 4) {
			$msg .= "à§ª";	
		}
		else if($p == 5) {
			$msg .= "à§«";	
		}
		else if($p == 6) {
			$msg .= "à§¬";	
		}
		else if($p == 7) {
			$msg .= "à§­";	
		}
		else if($p == 8) {
			$msg .= "à§®";	
		}
		else if($p == 9) {
			$msg .= "à§¯";	
		}
		else if($p == ".") {
			$msg .= ".";
			$count++;	
		}
		else if($p == "-") {
			$msg .= "-";
		}
		else if($p == " ") {
			$msg .= " ";
		}
		else if($p == ":") {
			$msg .= ":";	
		}
		else{			
			$msg .= "à§¦";	
		}
		$x = substr($x, 1);	
		
		if($count == 3) {
			break;	
		}
	}
	return $msg;	
}

function DateTimeDiffrence($start, $end){	
	$start = strtotime($start);
	$subTime = $end - $start;
	$y = ($subTime/(60*60*24*365));
	$d = ($subTime/(60*60*24))%365;
	$h = ($subTime/(60*60))%24;
	$m = ($subTime/60)%60;
	
	$str = "";
	if($d > 0) {
		$str .= $d . " days ";	
	}
	if($h > 0) {
		$str .= $d . " hours ";	
	}
	if($m > 0) {
		$str .= $m . " min ago";	
	}
	
	return $str;
}

function DateConverter($date){
   //$date=date_create($date);
   return date_format(date_create($date),"M d, Y h:i A");
}

function My_YearConverter($date){
   return date_format(date_create($date),"M d, Y");
}
function My_YearConverter_Blog($date){
   return date_format(date_create($date),"M Y");
}

?>