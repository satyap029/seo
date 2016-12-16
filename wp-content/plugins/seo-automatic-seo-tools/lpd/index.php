<?php
class lpd {
function sc_lpd(){
	$sc_plugin_dir =  get_option('siteurl').'/wp-content/plugins/seo-automatic-seo-tools/lpd/';	
	echo '<script type="text/javascript" src="'.$sc_plugin_dir.'jquery.min.js"></script>';	
	echo '<script type="text/javascript" src="'.$sc_plugin_dir.'search.js"></script>';
	echo '<link href="'.$sc_plugin_dir.'search.css" type="text/css" rel="stylesheet" />';
?>
	<script type="text/javascript">
	var lpdparse = "<?php echo plugins_url(); ?>/seo-automatic-seo-tools/lpd/parse.php";
	</script>
        <div class="lpd">
<table class="form">
                <tr>
                    <th>Your domain:</th>
                    <td><input type="text" class="text domain"/></td>
                </tr>
                <tr>
                    <th>Keywords:</th>
                    <td><textarea class="text keywords" cols="20" rows="5"></textarea></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input type="button" value="Go!" class="go submitbutton" />
                        <input type="button" value="Stop" class="stop submitbutton" />
                        <input type="button" value="Clear results" class="clearlpd submitbutton" />
                    </td>
                </tr>
            </table>

            <div class="results">
                <div class="loader">
                    <img src="<?php echo plugins_url();?>/seo-automatic-seo-tools/lpd/ajax-loader.gif" alt="loading ...."/> <span>Loading results</span>
                </div>

                <div style="display: none;"><h1>Results CSV Data</h1>
                <textarea cols="20" rows="4"></textarea></div>

                <h3>Results</h3>
                <table>
                    <tr>
                        <th>Keyword</th>
                        <th>Best Choice</th>
						<th>2nd Best</th>
						<th>3rd Best</th>
                    </tr>
                </table>
				<form method="POST" action="<?php echo $sc_plugin_dir;?>export.php">
				<textarea cols="20" rows="4" id="csvresults" name="csvresults"></textarea>
				<input type="submit" value="Export CSV" name="button6">
				</form> 
            </div>
        </div>
<?php }} ?>