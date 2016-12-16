<?PHP
require_once 'leadsettings-init.php';
global $seocheck_leadsettings, $seocheck_leadsettings_saved, $erroragent, $msgerror;
?>

<script type="text/javascript">

    function removeagent(divclass) {
        var r = confirm("You make sure that you want remove the agent?");
        if (r == true) {
            jQuery('.' + divclass).remove();
        } else {
            return false;
        }
    }


    function addagents() {
        var countdiv = jQuery(".addagent").length;
        var total = countdiv + 1;
        var stringdiv = "adicionalagent-" + total;
        var stringout = '<tr class="row_even seocheck_bglgray addagent adicionalagent-' + total + '"><td class="row_multi seocheck_nobg" style="width:250px">Additional Agent:</td><td class="seocheck_nobg" style="padding: 0;"><table class="seochecker_agent_table" width="100%" ><tr><td>Name:</td><td><input type="text" size="40" id="seocheck_defaultagent_name" name="seocheck_additional_agents_name[]" value="" /></td><td><span id="removeagent" onclick="removeagent(&#039;' + stringdiv + '&#039;)" class="button-danger" title="Remove Agent"> Remove</span></td></tr><tr><td>Position:</td><td colspan="2"><input type="text" size="40" id="seocheck_defaultagent_position" name="seocheck_additional_agents_position[]" value="" /></td></tr><tr><td>Image:</td><td colspan="2"><input type="text" size="40" id="seocheck_defaultagent_image" name="seocheck_additional_agents_image[]" value="" /></td></tr><tr><td>Text:</td><td colspan="2"><input type="text" size="40" id="seocheck_defaultagent_text" name="seocheck_additional_agents_text[]" value="" /></td></tr><tr><td>Text Button:</td><td><input type="text" size="40" id="seocheck_defaultagent_text" name="seocheck_defaultagent_text_button" value="" /></td></tr><tr><td>Logo URL:</td><td colspan="2"><input type="text" size="40" id="seocheck_defaultagent_logo" name="seocheck_additional_agents_logo[]" value="" /></td></tr><tr><td>Referer:</td><td colspan="2"><input type="text" size="40" id="seocheck_defaultagent_referer" name="seocheck_additional_agents_referer[]" value="" /></td></tr></table></td></tr>';
        jQuery('#addagentstable').append(stringout);
    }

</script>
<!--<pre>
<?php // print_r($seocheck_leadsettings) ?>
</pre>-->
<div class="wrap">   
    <div class="er_plugin seocheck_page_settings">
        <a  href="http://www.eranker.com" target="blank" rel="nofollow" class="seocheck_floatrigth seocheck_marigin5bottom seocheck_mariginleft" title="<?php _e('Visit eRanker.com Website!', 'er'); ?>" >
            <img src="<?PHP echo plugins_url(SEOCHECK_FOLDERNAME . '/images/eranker-logo-big.png') ?>" height="42" alt="eRanker" />
        </a>
        <h2><?php _e('Lead Generator Settings', 'er'); ?></h2>

        <?php
        if (isset($_POST) && isset($_POST['seocheck_leadgeneratorsettings']) && !empty($_POST['seocheck_leadgeneratorsettings']) && is_admin() && current_user_can('manage_options')) {
            if ($seocheck_leadsettings_saved && !empty($seocheck_leadsettings) && $erroragent !== TRUE) {
                echo '<div class="seocheck_box" id="seocheck_box_updated">';
                echo __('Your modifications have been saved successfully!', 'er');
                echo '</div>';
            } else {
                echo '<div class="seocheck_box" id="seocheck_box_updatederror">';
                echo $msgerror;
                echo '</div>';
            }
        }
        ?>
        <div class="widget seocheck_widget" style="margin-top: 20px;">
            <div class="widget-top seocheck_nomovecursor">
                <div class="widget-title">
                    <h4><?php _e('Lead Generator Settings', 'er'); ?> <span class="in-widget-title"></span></h4>
                </div>
            </div>
            <div class="widget-inside seocheck_nopadding" style="display: block;">
                <form id="form-leadgeneratoredit" method="post" action="admin.php?page=seocheck_page_leadgenerator">
                    <table class="form-table seocheck_table seocheck_noborder seocheck_nomargin">
                        <tr class="row_even seocheck_bglgray">
                            <td class="row_multi seocheck_nobg" style="width:250px">
                                <label for="seocheck_useleadgenerator"><?php _e('Show the lead generator form to non-loggedin users', 'er'); ?>:</label>
                            </td>
                            <td class="seocheck_nobg">
                                <input type="checkbox" id="seocheck_useleadgenerator" name="seocheck_useleadgenerator" value="1" <?php echo ($seocheck_leadsettings['useleadgenerator'] == 1) ? 'checked=checked' : ''; ?> />
                            </td>
                        </tr>
                        <tr class="row_even seocheck_bglgray">
                            <td class="row_multi seocheck_nobg" style="width:250px">
                                <label for="seocheck_layout"><?php _e('Layout', 'er'); ?>:</label>
                            </td>
                            <td class="seocheck_nobg">
                                <select id="seocheck_layout" name="seocheck_layout">
                                    <option value="POPUP" <?php echo (!isset($seocheck_leadsettings['layout']) || strcasecmp('POPUP', trim($seocheck_leadsettings['layout'])) === 0 ) ? 'selected="selected"' : ''; ?> >POPUP</option>
                                    <option value="FOOTER" <?php echo (isset($seocheck_leadsettings['layout']) && strcasecmp('FOOTER', trim($seocheck_leadsettings['layout'])) === 0 ) ? 'selected="selected"' : ''; ?> >FOOTER</option>
                                </select>
                            </td>
                        </tr>   
                        <tr class="row_even seocheck_bglgray">
                            <td class="row_multi seocheck_nobg" style="width:250px">
                                <label for="seocheck_howshowthemodal"><?php _e('How show the popup', 'er'); ?>:</label>
                            </td>
                            <td class="seocheck_nobg">
                                <select id="seocheck_howshowthemodal" name="seocheck_howshowthemodal">
                                    <option value="report20" <?php echo (!isset($seocheck_leadsettings['howshowthemodal']) || strcasecmp('report20', trim($seocheck_leadsettings['howshowthemodal'])) === 0 ) ? 'selected="selected"' : ''; ?> >20% of report</option>
                                    <option value="instantly" <?php echo (isset($seocheck_leadsettings['howshowthemodal']) && strcasecmp('instantly', trim($seocheck_leadsettings['howshowthemodal'])) === 0 ) ? 'selected="selected"' : ''; ?>> Instantly </option>
                                </select>
                            </td>
                        </tr>   
                        <tr class="row_even seocheck_bglgray">
                            <td class="row_multi seocheck_nobg" style="width:250px">
                                <label for="seocheck_adminemail"><?php _e('Send emails to', 'er'); ?>:</label>
                            </td>
                            <td class="seocheck_nobg">
                                <input type="text" size="50" id="seocheck_adminemail" name="seocheck_adminemail" value="<?php echo (isset($seocheck_leadsettings['adminemail']) && !empty($seocheck_leadsettings['adminemail']) ? htmlspecialchars($seocheck_leadsettings['adminemail']) : get_option('admin_email')); ?>" />
                            </td>
                        </tr>
<!--                        <tr class="row_even seocheck_bglgray">
                            <td class="row_multi seocheck_nobg" style="width:250px">
                                <label for="seocheck_forcefillform"><?php _e('Lock the report until the user fill the form', 'er'); ?>:</label>
                            </td>
                            <td class="seocheck_nobg">
                                <input type="checkbox" id="seocheck_forcefillform" name="seocheck_forcefillform" value="1" <?php echo (!empty($seocheck_leadsettings['forcefillform']) ? 'checked=checked' : ''); ?> />
                            </td>
                        </tr>-->
                        <tr class="row_even seocheck_bglgray">
                            <td class="row_multi seocheck_nobg" style="width:250px">
                                <?php _e('Default Agent', 'er'); ?>:
                            </td>
                            <td class="seocheck_nobg" style="padding: 0;">
                                <table class="seochecker_agent_table" width="100%" >
                                    <tr>
                                        <td><?php _e('Name', 'er'); ?>:</td>
                                        <td><input type="text" size="40" id="seocheck_defaultagent_name" name="seocheck_defaultagent_name" value="<?php echo (isset($seocheck_leadsettings['agents']) && isset($seocheck_leadsettings['agents']['default']) && isset($seocheck_leadsettings['agents']['default']['name']) ) ? htmlspecialchars($seocheck_leadsettings['agents']['default']['name']) : 'Support'; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td><?php _e('Position', 'er'); ?>:</td>
                                        <td><input type="text" size="40" id="seocheck_defaultagent_position" name="seocheck_defaultagent_position" value="<?php echo (isset($seocheck_leadsettings['agents']) && isset($seocheck_leadsettings['agents']['default']) && isset($seocheck_leadsettings['agents']['default']['position']) ) ? htmlspecialchars($seocheck_leadsettings['agents']['default']['position']) : ''; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td><?php _e('Image', 'er'); ?>:</td>
                                        <td><input type="text" size="40" id="seocheck_defaultagent_image" name="seocheck_defaultagent_image" value="<?php echo (isset($seocheck_leadsettings['agents']) && isset($seocheck_leadsettings['agents']['default']) && isset($seocheck_leadsettings['agents']['default']['image']) ) ? htmlspecialchars($seocheck_leadsettings['agents']['default']['image']) : ''; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td><?php _e('Text', 'er'); ?>:</td>
                                        <td><input type="text" size="40" id="seocheck_defaultagent_text" name="seocheck_defaultagent_text" value="<?php echo (isset($seocheck_leadsettings['agents']) && isset($seocheck_leadsettings['agents']['default']) && isset($seocheck_leadsettings['agents']['default']['text']) ) ? htmlspecialchars($seocheck_leadsettings['agents']['default']['text']) : _e('Fill the form in order to view the full report', 'er'); ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td><?php _e('Text Button', 'er'); ?>:</td>
                                        <td><input type="text" size="40" id="seocheck_defaultagent_text" name="seocheck_defaultagent_text_button" value="<?php echo (isset($seocheck_leadsettings['agents']) && isset($seocheck_leadsettings['agents']['default']) && isset($seocheck_leadsettings['agents']['default']['text_button']) ) ? htmlspecialchars($seocheck_leadsettings['agents']['default']['text_button']) : _e('Unlock Report Data', 'er'); ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td><?php _e('Logo URL', 'er'); ?>:</td>
                                        <td><input type="text" size="40" id="seocheck_defaultagent_logo" name="seocheck_defaultagent_logo" value="<?php echo (isset($seocheck_leadsettings['agents']) && isset($seocheck_leadsettings['agents']['default']) && isset($seocheck_leadsettings['agents']['default']['logo']) ) ? htmlspecialchars($seocheck_leadsettings['agents']['default']['logo']) : ''; ?>" /></td>
                                    </tr>                                    
                                </table>                                  
                            </td> 
                        </tr>
                        <tr class="row_even seocheck_bglgray">
                            <td class="row_multi seocheck_nobg" style="width:250px">
                                <?php _e('Agents', 'er'); ?>:
                            </td>
                            <td class="seocheck_nobg" style="padding: 0;">
                                <span id="addagents" onclick='addagents()' class="button-primary" title="Add Agents"><i class="fa fa-plus"></i> Add</span>
                            </td>
                        </tr>

                    </table>
                    <table id="addagentstable" class="form-table seocheck_table seocheck_noborder seocheck_nomargin">
                        <?php
                        if (!empty($seocheck_leadsettings['agents']['additional_agents'])) {
                            $count = 0;
                            foreach ($seocheck_leadsettings['agents']['additional_agents'] as $value) {
                                ?>
                                <?php
                                if (!empty($value['name']) || !empty($value['position']) || !empty($value['image']) || !empty($value['text']) || !empty($value['logo'])) {
                                    $count++;
                                    ?>
                                    <tr class="row_even seocheck_bglgray addagent adicionalagent-<?= $count; ?>">
                                        <td class="row_multi seocheck_nobg" style="width:250px">
                                            <?php _e('Additional Agent', 'er'); ?>:
                                        </td>
                                        <td class="seocheck_nobg" style="    padding: 0;"> 
                                            <table class="seochecker_agent_table" width="100%" >
                                                <tr>
                                                    <td><?php _e('Name', 'er'); ?>:</td>
                                                    <td><input type="text" size="40" id="seocheck_defaultagent_name" name="seocheck_additional_agents_name[]" value="<?= $value['name'] ?>" /></td>
                                                    <td><span id="removeagent" onclick='removeagent("adicionalagent-<?= $count; ?>")' class="button-danger" title="Remove Agent"> Remove</span></td>
                                                </tr>
                                                <tr>
                                                    <td><?php _e('Position', 'er'); ?>:</td>
                                                    <td colspan="2"><input type="text" size="40" id="seocheck_defaultagent_position" name="seocheck_additional_agents_position[]" value="<?= $value['position'] ?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td><?php _e('Image', 'er'); ?>:</td>
                                                    <td colspan="2"><input type="text" size="40" id="seocheck_defaultagent_image" name="seocheck_additional_agents_image[]" value="<?= $value['image'] ?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td><?php _e('Text', 'er'); ?>:</td>
                                                    <td colspan="2"><input type="text" size="40" id="seocheck_defaultagent_text" name="seocheck_additional_agents_text[]" value="<?= $value['text'] ?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td><?php _e('Text button', 'er'); ?>:</td>
                                                    <td colspan="2"><input type="text" size="40" id="seocheck_defaultagent_text" name="seocheck_additional_agents_text_button[]" value="<?= $value['text_button'] ?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td><?php _e('Logo URL', 'er'); ?>:</td>
                                                    <td colspan="2"><input type="text" size="40" id="seocheck_defaultagent_logo" name="seocheck_additional_agents_logo[]" value="<?= $value['logo'] ?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td><?php _e('Referer', 'er'); ?>:</td>
                                                    <td colspan="2"><input type="text" size="40" id="seocheck_defaultagent_logo" name="seocheck_additional_agents_referer[]" value="<?= $value['referer'] ?>" /></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php
                            }
                        }
                        ?>

                    </table>
                    <div class="seocheck_padded">
                        <input type="hidden" name="seocheck_leadgeneratorsettings" value="1" />
                        <input type="submit" name="submit" class="button-primary" value="<?php _e('Save Settings', 'er') ?>" />
                    </div>
                </form> 
            </div>
        </div>

        <div class="seocheck_box" id="seocheck_box_help">
            <div class="seocheck_box_title">
                <?php _e('Help, Updates &amp; Documentation', 'er'); ?>
            </div>
            <ul>
                <li><?php printf(__('<a rel="nofollow" target="_blank" href="%s">Read the online documentation</a> and our <a target="_blank" href="%s">Blog</a> for more information about this plugin', 'er'), 'http://www.eRanker.com/wordpress-plugin/', 'http://www.eRanker.com/blog/'); ?>;</li>
                <li><?php printf(__('<a rel="nofollow" target="_blank" href="%s">Contact us</a> if you have feedback or need assistance', 'er'), 'http://www.eRanker.com/contact/'); ?>;   </li>   
                <li><?php printf(__('Do you want <strong>develop your own plugins</strong> using eRanker API? <a rel="nofollow" target="_blank" href="%s">See our API documentation</a>', 'er'), 'http://www.eRanker.com/api/'); ?>.</li>
            </ul>
        </div>
    </div>
</div>