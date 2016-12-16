<?php
$csvmergeroutput .= "Use txt and csv files only. Large and/or many files may take more time to process.<br /><br /><form method=post action='' enctype='multipart/form-data'><br />
Create merged result file in <input type='radio' name='csvext' value='csv' checked> CSV or <input type='radio' name='csvext' value='txt'> TXT<br />Select all files at one time.
 <input type='hidden' name='showdownloadbutton' value='true' />
 <input name='csvfiles[]' class='bginput' type='file' multiple='multiple' /> <input type=submit value='Process Files' onclick=\"setCSVVisibility('showhide', 'block');\"></form>";

$v = 1;
while(list($key,$value) = each($_FILES['csvfiles']['name']))
{
if(!empty($value)){   // this will check if any blank field is entered
$filename = 'file'.$v.'.csv';    // filename stores the value

$filename=str_replace(" ","_",$filename);// Add _ inplace of blank space in file name, you can remove this line

$add = $temp_folder.$filename;   // upload directory path is set
//echo $_FILES['csvfiles']['type'][$key];     // uncomment this line if you want to display the file type
//echo "<br>";                             // Display a line break
copy($_FILES['csvfiles']['tmp_name'][$key], $add); 

    //  upload the file to the server
chmod("$add",0777);                 // set permission to the file.
$v++;
}
}
?>