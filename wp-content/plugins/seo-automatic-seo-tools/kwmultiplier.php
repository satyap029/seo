<?php
//keyword marriage
class keywordmarriage {
function sc_keywordmarriage(){
	if ($_REQUEST['run'] == "yes") {
		
	$keywords = $_REQUEST['keywords'];
	$keywords = preg_replace('/\r\n|\r/', ",", $keywords);
	$keywords = str_replace(' ,', ',', $keywords);
	$keywords = str_replace(', ', ',', $keywords);
	$keywords = explode(',', $keywords);
	
	$addkeywords = $_REQUEST['addkeywords'];
	$addkeywords = preg_replace('/\r\n|\r/', ",", $addkeywords);
	$addkeywords = str_replace(' ,', ',', $addkeywords);
	$addkeywords = str_replace(', ', ',', $addkeywords);	
	$addkeywords = explode(',', $addkeywords);
	
	$addkeywords2 = $_REQUEST['addkeywords2'];
	$addkeywords2 = preg_replace('/\r\n|\r/', ",", $addkeywords2);
	$addkeywords2 = str_replace(' ,', ',', $addkeywords2);
	$addkeywords2 = str_replace(', ', ',', $addkeywords2);	
	$addkeywords2 = explode(',', $addkeywords2);
	
	$addkeywords3 = $_REQUEST['addkeywords3'];
	$addkeywords3 = preg_replace('/\r\n|\r/', ",", $addkeywords3);
	$addkeywords3 = str_replace(' ,', ',', $addkeywords3);
	$addkeywords3 = str_replace(', ', ',', $addkeywords3);	
	$addkeywords3 = explode(',', $addkeywords3);

	$space = " ";

	for ($i = 0; $i < count($keywords); $i++) { 
		if ($keywords[$i] == '*keep~going*') {
		} else {
			for ($j = 0; $j < count($addkeywords); $j++) {
				if ($addkeywords[$j] == '*keep~going*') {
				} else {
					for ($k = 0; $k < count($addkeywords2); $k++) {
						if ($addkeywords2[$k] == '*keep~going*') {
						} else {
							for ($l = 0; $l < count($addkeywords3); $l++) {
								if ($addkeywords3[$l] == '*keep~going*') {
									} else {
										if (($_REQUEST['addkeywords2'] != '') && ($_REQUEST['addkeywords3'] == '')) {
											if ($_REQUEST['retain'] == "ON") {
												$result = $result . $keywords[$i] . $space . $addkeywords[$j] . $space . $addkeywords2[$k] . "\n";
											}
											if ($_REQUEST['exact'] == "ON") {
												$result = $result . "[" . $keywords[$i] . $space . $addkeywords[$j] . $space . $addkeywords2[$k] . "]\n";
											}
											if ($_REQUEST['modbroad'] == "ON") {
												$result = $result . "+" . str_replace(' ', ' +', $keywords[$i]) . $space . "+" . str_replace(' ', ' +', $addkeywords[$j]) . $space . "+" . str_replace(' ', ' +', $addkeywords2[$k]) . "\n";
											}
											if ($_REQUEST['phrase'] == "ON") {
												$result = $result . "\"" . $keywords[$i] . $space . $addkeywords[$j] . $space . $addkeywords2[$k] . "\"\n";
											}
											if ($_REQUEST['negative'] == "ON") {
												$result = $result . "-" . $keywords[$i] . $space . "-" . $addkeywords[$j] . $space . "-" . $addkeywords2[$k] . "\n";
											}											
										} elseif (($_REQUEST['addkeywords2'] == '') && ($_REQUEST['addkeywords3'] != '')) {
											if ($_REQUEST['retain'] == "ON") {
												$result = $result . $keywords[$i] . $space . $addkeywords[$j] . $space . $addkeywords3[$l] . "\n";
											}
											if ($_REQUEST['exact'] == "ON") {
												$result = $result . "[". $keywords[$i] . $space . $addkeywords[$j] . $space . $addkeywords3[$l] . "]\n";
											}
											if ($_REQUEST['modbroad'] == "ON") {
												$result = $result . "+" . str_replace(' ', ' +', $keywords[$i]) . $space . "+" . str_replace(' ', ' +', $addkeywords[$j]) . $space . "+" . str_replace(' ', ' +', $addkeywords3[$l]) . "\n";
											}
											if ($_REQUEST['phrase'] == "ON") {
												$result = $result . "\"" . $keywords[$i] . $space . $addkeywords[$j] . $space . $addkeywords3[$l] . "\"\n";
											}
											if ($_REQUEST['negative'] == "ON") {
												$result = $result . "-". $keywords[$i] . $space . "-" . $addkeywords[$j] . $space . "-" . $addkeywords3[$l] . "\n";
											}											
										} elseif (($_REQUEST['addkeywords2'] == '') && ($_REQUEST['addkeywords3'] == '')) {
											if ($_REQUEST['retain'] == "ON") {
												$result = $result . $keywords[$i] . $space . $addkeywords[$j] . "\n";
											}
											if ($_REQUEST['exact'] == "ON") {
												$result = $result . "[" . $keywords[$i] . $space . $addkeywords[$j] . "]\n";
											}
											if ($_REQUEST['modbroad'] == "ON") {
												$result = $result . "+" . str_replace(' ', ' +', $keywords[$i]) . $space . "+" . str_replace(' ', ' +', $addkeywords[$j]) . "\n";
											}
											if ($_REQUEST['phrase'] == "ON") {
												$result = $result . "\"" . $keywords[$i] . $space . $addkeywords[$j] . "\"\n";
											}
											if ($_REQUEST['negative'] == "ON") {
												$result = $result . "-" . $keywords[$i] . $space . "-" . $addkeywords[$j] . "\n";
											}											
										} else {
										if ($_REQUEST['retain'] == "ON") {
											$result = $result . $keywords[$i] . $space . $addkeywords[$j] . $space . $addkeywords2[$k] . $space . $addkeywords3[$l] . "\n";
										}
										if ($_REQUEST['exact'] == "ON") {
											$result = $result . "[" . $keywords[$i] . $space . $addkeywords[$j] . $space . $addkeywords2[$k] . $space . $addkeywords3[$l] . "]\n";
										}
										if ($_REQUEST['modbroad'] == "ON") {
											$result = $result . "+" . str_replace(' ', ' +', $keywords[$i]) . $space . "+" . str_replace(' ', ' +', $addkeywords[$j]) . $space . "+" . str_replace(' ', ' +', $addkeywords2[$k]) . $space . "+" . str_replace(' ', ' +', $addkeywords3[$l]) . "\n";
										}
										if ($_REQUEST['phrase'] == "ON") {
											$result = $result . "\"" . $keywords[$i] . $space . $addkeywords[$j] . $space . $addkeywords2[$k] . $space . $addkeywords3[$l] . "\"\n";
										}
										if ($_REQUEST['negative'] == "ON") {
											$result = $result . "-" . $keywords[$i] . $space . "-" . $addkeywords[$j] . $space . "-" . $addkeywords2[$k] . $space . "-" . $addkeywords3[$l] . "\n";
										}										
										}
									}
								}
							}
						}
					}
				}
			}
		}
	$result .= "\n";
	$result = substr_replace($result,"",-1);
	$result = str_replace("\\","", $result); 
	$result = str_replace(' ]', ']', $result);
	$result = str_replace(" +\n", "\n", $result);
	$result = str_replace(" \"", "\"", $result);
	$result = str_replace(" -\n", "\n", $result);
	if ( $result{0} == " " ) { $result = substr($result, 1); }
						}
	?>
<script type="text/javascript">
function uncheck(){
	var x=document.forms.keywordmarriage
    var linkschecked = x['links'].checked;
    var hasBeenDisabled = x['phrase'].disabled || x['exact'].disabled || x['modbroad'].disabled;
    if (linkschecked) {
        if (!hasBeenDisabled) {
            x['phrase'].checked=x['exact'].checked=x['modbroad'].checked=x['negative'].checked=false;
            x['phrase'].disabled=x['exact'].disabled=x['modbroad'].disabled=x['negative'].disabled=true;
        }
        else {
            x['negative'].checked=false;
            x['negative'].disabled=true;
        }
    }
    else {
        x['phrase'].disabled=x['exact'].disabled=x['modbroad'].disabled=x['negative'].disabled=false;
    }
}
function uncheckthree(){
	var x=document.forms.keywordmarriage
    var negChecked = x['negative'].checked;
    if (negChecked){
        x['phrase'].checked=x['exact'].checked=x['modbroad'].checked=false;
        x['phrase'].disabled=x['exact'].disabled=x['modbroad'].disabled=true;        
    }
    else {
        x['phrase'].disabled=x['exact'].disabled=x['modbroad'].disabled=false;
    }
}
</script>
	<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" name="keywordmarriage">
	<input type="hidden" name="run" value="yes" />
	  <div align="center">
		
		<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="454" height="1017">
		  <tr>
			<td width="216" align="center" valign="top">Primary Keyword Phrases</td>
			<td width="24" align="center" valign="top">&nbsp;</td>
			<td width="213" align="center" valign="top">Desired Variables (city, state etc.)</td>
			<td width="4" align="center" valign="top">&nbsp;</td>
		 </tr>
		  <tr>
			<td width="216" align="center" valign="top" height="324">
			<textarea rows="20" id="keywords" name="keywords" cols="24"></textarea></td>
			<td width="24" align="center" valign="top" height="324">&nbsp;</td>
			<td width="213" align="center" valign="top" height="324">
			<textarea rows="20" name="addkeywords" cols="24"></textarea></td>
			<td width="4" align="center" valign="top" height="324">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="216" align="center" valign="top" height="34">
			&nbsp;</td>
			<td width="24" align="center" valign="top" height="34">&nbsp;</td>
			<td width="213" align="center" valign="top" height="34">
			&nbsp;</td>
			<td width="4" align="center" valign="top" height="34">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="216" align="center" valign="top">Desired Variables (city, state etc.)</td>
			<td width="24" align="center" valign="top">&nbsp;</td>
			<td width="213" align="center" valign="top">Desired Variables (city, state etc.)</td>
			<td width="4" align="center" valign="top">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="216" align="center" valign="top" height="324">
			<textarea rows="20" name="addkeywords2" cols="24"></textarea></td>
			<td width="24" align="center" valign="top" height="324">&nbsp;</td>
			<td width="213" align="center" valign="top" height="324">
			<textarea rows="20" name="addkeywords3" cols="24"></textarea></td>
			<td width="4" align="center" valign="top" height="324">&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="4" align="left" valign="top" height="221" width="457"><br />
<b>If you're using this for Google Ad Words, you likely want to leave these boxes checked.</b><br />
			<input type="checkbox" name="retain" value="ON" /> Retain Broad Match &nbsp;<input type="checkbox" name="exact" value="ON" checked /> Add Exact Match &nbsp;<input type="checkbox" name="modbroad" value="ON" checked /> Add Modified Broad Match<br /><input type="checkbox" name="phrase" value="ON" /> Add Phrase Match &nbsp;<input type="checkbox" name="negative" value="ON" /> Add Negative Match <br /><br />
			<input type="checkbox" name="links" value="ON" onclick="uncheck()"> &nbsp;Checking this box CHANGES this tool, so it will generate EXACTLY what you input. Do do not use with the Adwords match types. 
<br /><br />
This option KEEPS any spaces or other characters you may add, like pipes, spaces etc. and will NOT add its own spaces for use in Adwords. 
<br />
 <br /><input type="submit" value="Create List of Keywords" name="submit"> <input type="reset" value="Reset" name="B2"></td>
		  </tr>
		</table>
		
	  </div>
	  <p align="center"><textarea rows="23" id="newkeywords" name="newkeywords" cols="50"><?php print_r ($result);?></textarea></p>
	  <p>&nbsp;</p>
	</form>
<?php
}}
?>