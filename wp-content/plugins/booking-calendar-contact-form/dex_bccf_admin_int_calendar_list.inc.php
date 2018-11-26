<?php

if ( !is_admin() ) 
{
    echo 'Direct access not allowed.';
    exit;
}

$current_user = wp_get_current_user();

global $wpdb;
$message = "";

if (isset($_POST["bccf_fileimport"]) && $_POST["bccf_fileimport"] == 1)
{    
    $filename = $_FILES['cp_filename']['tmp_name'];
    $handle = fopen($filename, "r");
    $contents = fread($handle, filesize($filename));
    fclose($handle);
    $params = unserialize($contents);
    $wpdb->query( $wpdb->prepare( 'DELETE FROM `'.DEX_BCCF_CONFIG_TABLE_NAME.'` WHERE id=%d', $params['id'] ) );    
    unset($params["form_name"]);
    $wpdb->insert( DEX_BCCF_CONFIG_TABLE_NAME, $params);
    @unlink($filename);
    $message = "Backup loaded.";
}
else if (isset($_GET['u']) && $_GET['u'] != '')
{
    if (!wp_verify_nonce( $_REQUEST['_wpnonce'], 'uname_bccf' ))    
        $message = "Access verification error. Cannot update settings.";
    else
    {            
        $wpdb->query( $wpdb->prepare( 'UPDATE `'.DEX_BCCF_CONFIG_TABLE_NAME.'` SET conwer=%d,`'.TDE_BCCFCALDELETED_FIELD.'`=%d,`'.TDE_BCCFCONFIG_USER.'`=%s WHERE `'.TDE_BCCFCONFIG_ID.'`=%d', $_GET["owner"], $_GET["public"], $_GET["name"], $_GET['u'] ) );           
        $message = "Item updated";        
    }    
}
else if (isset($_GET['ac']) && $_GET['ac'] == 'st')
{   
    if (!wp_verify_nonce( $_REQUEST['_wpnonce'], 'uname_bccf' ))    
        $message = "Access verification error. Cannot update settings.";
    else
    {  
        update_option( 'CP_BCCF_LOAD_SCRIPTS', ($_GET["scr"]=="1"?"0":"1") );   
        if ($_GET["chs"] != '')
        {
            $target_charset = esc_sql($_GET["chs"]);
            $tables = array( $wpdb->prefix.DEX_BCCF_TABLE_NAME_NO_PREFIX, $wpdb->prefix.DEX_BCCF_CALENDARS_TABLE_NAME_NO_PREFIX, $wpdb->prefix.DEX_BCCF_CONFIG_TABLE_NAME_NO_PREFIX );                
            foreach ($tables as $tab)
            {  
                $myrows = $wpdb->get_results( "DESCRIBE {$tab}" );                                                                                 
                foreach ($myrows as $item)
	            {
	                $name = $item->Field;
	    	        $type = $item->Type;
	    	        if (preg_match("/^varchar\((\d+)\)$/i", $type, $mat) || !strcasecmp($type, "CHAR") || !strcasecmp($type, "TEXT") || !strcasecmp($type, "MEDIUMTEXT"))
	    	        {
	                    $wpdb->query("ALTER TABLE {$tab} CHANGE {$name} {$name} {$type} COLLATE {$target_charset}");	            
	                }
	            }
            }
        }
    }   
    $message = "Troubleshoot settings updated";
}

$nonce_un = wp_create_nonce( 'uname_bccf' );

if ($message) echo "<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>".$message."</strong></p></div>";

?>
<div class="wrap">
<h1>Booking Calendar Contact Form</h1>

<script type="text/javascript">
 
 function cp_updateItem(id)
 {
    var calname = document.getElementById("calname_"+id).value;
    var owner = document.getElementById("calowner_"+id).options[document.getElementById("calowner_"+id).options.selectedIndex].value;    
    if (owner == '')
        owner = 0;
    var is_public = "1";
    document.location = 'admin.php?page=dex_bccf.php&_wpnonce=<?php echo $nonce_un; ?>&u='+id+'&r='+Math.random()+'&public='+is_public+'&owner='+owner+'&name='+encodeURIComponent(calname);    
 }
 
 function cp_manageSettings(id)
 {
    document.location = 'admin.php?page=dex_bccf.php&cal='+id+'&r='+Math.random();
 }
 
 function cp_publish(id)
 {
     document.location = 'admin.php?page=dex_bccf.php&pwizard=1&cal='+id+'&r='+Math.random();
 } 
 
 function cp_BookingsList(id)
 {
    document.location = 'admin.php?page=dex_bccf.php&cal='+id+'&list=1&r='+Math.random();
 }
 
 function cp_updateConfig()
 {
    if (confirm('Are you sure that you want to update these settings?'))
    {        
        var scr = document.getElementById("ccscriptload").value;    
        var chs = document.getElementById("cccharsets").value;    
        document.location = 'admin.php?page=dex_bccf.php&_wpnonce=<?php echo $nonce_un; ?>&ac=st&scr='+scr+'&chs='+chs+'&r='+Math.random();
    }    
 }
  
 function cp_exportItem()
 {
    var calname = document.getElementById("exportid").options[document.getElementById("exportid").options.selectedIndex].value;
    document.location = 'admin.php?page=dex_bccf&bccf_export=1&r='+Math.random()+'&name='+encodeURIComponent(calname);       
 }
 
</script>


<div id="normal-sortables" class="meta-box-sortables">


 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Calendar List / Items List</span></h3>
  <div class="inside">
  
  
  <table cellspacing="10" cellpadding="6" class="ahb-calendars-list">  
   <tr>
    <th align="left">ID</th><th align="left">Item Name</th><th align="left">Owner</th><th align="left">Feed</th><th align="left">Options</th><th align="left">Shortcode for Pages &amp; Posts</th>    
   </tr> 
<?php  

  $users = $wpdb->get_results( "SELECT user_login,ID FROM ".$wpdb->users." ORDER BY ID DESC" );                                                                     

  $myrows = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix ."bccf_reservation_calendars" );                                                                     
  foreach ($myrows as $item)   
      if (cp_bccf_is_administrator() || ($current_user->ID == $item->conwer))
      {
?>
   <tr> 
    <td nowrap><?php echo $item->id; ?></td>
    <td nowrap><input type="text" style="width:100px;" <?php if (!cp_bccf_is_administrator()) echo ' readonly '; ?>name="calname_<?php echo $item->id; ?>" id="calname_<?php echo $item->id; ?>" value="<?php echo esc_attr($item->uname); ?>" /></td>
    
    <?php if (cp_bccf_is_administrator()) { ?>
    <td nowrap>
      <select name="calowner_<?php echo $item->id; ?>" id="calowner_<?php echo $item->id; ?>">
       <option value="0"<?php if (!$item->conwer) echo ' selected'; ?>></option>
       <?php foreach ($users as $user) { 
       ?>
          <option value="<?php echo $user->ID; ?>"<?php if ($user->ID."" == $item->conwer) echo ' selected'; ?>><?php echo $user->user_login; ?></option>
       <?php  } ?>
      </select>
    </td>    
    <?php } else { ?>
        <td nowrap>
        <?php echo $current_user->user_login; ?>
        </td>
    <?php } ?>
    
    <input type="hidden" name="calpublic_<?php echo $item->id; ?>" id="calpublic_<?php echo $item->id; ?>" value="1" />
    
    <td nowrap><a href="<?php echo get_site_url(); ?>?dex_bccf=calfeed&id=<?php echo $item->id; ?>&verify=<?php echo substr(md5($item->id.$_SERVER["DOCUMENT_ROOT"]),0,10); ?>">iCal</a></td>
    <td nowrap>&nbsp; &nbsp; 
                             <?php if (cp_bccf_is_administrator()) { ?> 
                               <input class="button" type="button" name="calupdate_<?php echo $item->id; ?>" value="Update Name &amp; Owner" onclick="cp_updateItem(<?php echo $item->id; ?>);" />  
                             <?php } ?>    
                             <input class="button-primary button" type="button" name="calmanage_<?php echo $item->id; ?>" value="Settings " onclick="cp_manageSettings(<?php echo $item->id; ?>);" /> 
                             <input class="button-primary button" type="button" name="calpublish_<?php echo $item->id; ?>" value="<?php _e('Publish','bccf'); ?>" onclick="cp_publish(<?php echo $item->id; ?>);" />   
                             <input class="button" type="button" name="calbookings_<?php echo $item->id; ?>" value="Bookings / Contacts" onclick="cp_BookingsList(<?php echo $item->id; ?>);" /> 
    </td>
    <td style="font-size:11px;" nowrap>[CP_BCCF_FORM calendar="<?php echo $item->id; ?>"]</td> 
   </tr>
<?php  
      } 
?>   
     
  </table> 
    
    
   
  </div>    
 </div> 
 
<?php if (cp_bccf_is_administrator()) { ?> 
 
 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>New Calendar / Item</span></h3>
  <div class="inside"> 
   
    This version supports one calendar. For a version that supports unlimited calendars upgrade to one of the <a href="https://bccf.dwbooster.com/download">commercial versions</a>.

  </div>    
 </div>
 

 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Troubleshoot Area</span></h3>
  <div class="inside"> 
    <p><strong>Important!</strong>: Use this area <strong>only</strong> if you are experiencing conflicts with third party plugins, with the theme scripts or with the character encoding.</p>
    <form name="updatesettings">
      Script load method:<br />
       <select id="ccscriptload" name="ccscriptload">
        <option value="0" <?php if (get_option('CP_BCCF_LOAD_SCRIPTS',"0") == "1") echo 'selected'; ?>>Classic (Recommended)</option>
        <option value="1" <?php if (get_option('CP_BCCF_LOAD_SCRIPTS',"0") != "1") echo 'selected'; ?>>Direct</option>
       </select><br />
       <em>* Change the script load method if the form doesn't appear in the public website.</em>
      
      <br /><br />
      Character encoding:<br />
       <select id="cccharsets" name="cccharsets">
        <option value="">Keep current charset (Recommended)</option>
        <option value="utf8_general_ci">UTF-8 (try this first)</option>
        <option value="latin1_swedish_ci">latin1_swedish_ci</option>
        <option value="hebrew_general_ci">hebrew_general_ci</option>
        <option value="gb2312_chinese_ci">gb2312_chinese_ci</option>
       </select><br />
       <em>* Update the charset if you are getting problems displaying special/non-latin characters. After updated you need to edit the special characters again.</em>
       <br />
       <input type="button" onclick="cp_updateConfig();" name="gobtn" value="UPDATE" />
      <br /><br />      
    </form>

  </div>    
 </div> 
 
 
   <script type="text/javascript">
   function cp_editArea(id)
   {       
          document.location = 'admin.php?page=dex_bccf.php&edit=1&cal=1&item='+id+'&r='+Math.random();
   }
  </script>
  <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Customization Area</span></h3>
  <div class="inside"> 
      <p>Use this area to add custom CSS styles or custom scripts. These styles and scripts will be keep safe even after updating the plugin.</p>
      <input type="button" onclick="cp_editArea('css');" name="gobtn3" value="Add Custom Styles" />
      &nbsp; &nbsp; &nbsp;      
      <input type="button" onclick="cp_editArea('js');" name="gobtn2" value="Add Custom JavaScript" />
  </div>    
 </div> 
 

<?php } ?> 


 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Backup / Restore Area</span></h3>
  <div class="inside"> 
    <p>Use this area <strong>only</strong> to <strong>backup/restore calendar settings</strong>.</p>
    <hr />
    <form name="exportitem">
      Export this form structure and settings:<br />
      <select id="exportid" name="exportid">
       <?php  
          foreach ($myrows as $item)         
              echo '<option value="'.$item->id.'">'.$item->uname.'</option>';
       ?>   
      </select> 
      <input type="button" onclick="cp_exportItem();" name="gobtn" value="Export" />
      <br /><br />      
    </form>
    <hr />
    <form name="importitem" action="admin.php?page=dex_bccf" method="post" enctype="multipart/form-data">      
      <input type="hidden" name="bccf_fileimport" id="bccf_fileimport"  value="1" />
      Import a form structure and settings (will OVERWRITE the related form. Only <em>.bccf</em> files ):<br />
      <input type="file" name="cp_filename" id="cp_filename"  value="" /> <input type="submit" name="gobtn" value="Import" />
      <br /><br />
    </form>

  </div>    
 </div>

 
  <div id="metabox_basic_settings" class="postbox" <?php if (is_plugin_active('appointment-hour-booking/app-booking-plugin.php') && is_plugin_active('appointment-booking-calendar/cpabc_appointments.php')) echo 'style="display:none"'; ?>>
  <h3 class='hndle' style="padding:5px;"><span>Need a booking calendar for appointments?</span></h3>
  <div class="inside"> 
   
    <p>With the following plugins you can also have a form for booking appointments selecting specific times into the dates: </p>
    <div style="clear:both"></div>   
    
    <div class="plugin-card plugin-card-appointment-hour-booking" <?php if (is_plugin_active('appointment-hour-booking/app-booking-plugin.php')) echo 'style="display:none"'; ?> >
       <div class="plugin-card-top">
				<div class="name column-name">
					<h3>
						<a href="plugin-install.php?tab=plugin-information&amp;plugin=appointment-hour-booking&amp;" class="thickbox open-plugin-details-modal">
						Appointment Hour Booking						<img src="https://ps.w.org/appointment-hour-booking/assets/icon-256x256.png" class="plugin-icon" alt="">
						</a>
					</h3>
				</div>
				<div class="action-links">
					<ul class="plugin-action-buttons"><ul class="plugin-action-buttons"><li><a class="install-now button" data-slug="appointment-hour-booking" href="<?php echo wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=appointment-hour-booking'), 'install-plugin_appointment-hour-booking'); ?>" aria-label="Install Appointment Hour Booking" data-name="Appointment Hour Booking">Install Now</a></li><li><a href="plugin-install.php?tab=plugin-information&amp;plugin=appointment-hour-booking" class="thickbox open-plugin-details-modal" aria-label="More information about Appointment Hour Booking" data-title="Appointment Hour Booking">More Details</a></li></ul>				</div>
				<div class="desc column-description">
					<p>Booking forms for appointments/services with a start time and a defined duration over a schedule. The start time is visually selected by the end user from a set of start times (based in "open" hours and service duration).</p>
					
				</div>
			</div>
    </div>  
    
   <div class="plugin-card plugin-card-appointment-booking-calendar" <?php if (is_plugin_active('appointment-booking-calendar/cpabc_appointments.php')) echo 'style="display:none"'; ?>>
       <div class="plugin-card-top">
				<div class="name column-name">
					<h3>
						<a href="plugin-install.php?tab=plugin-information&amp;plugin=appointment-booking-calendar&amp;" class="thickbox open-plugin-details-modal">
						Appointment Booking Calendar						<img src="https://ps.w.org/appointment-booking-calendar/assets/icon-256x256.png" class="plugin-icon" alt="">
						</a>
					</h3>
				</div>
				<div class="action-links">
					<ul class="plugin-action-buttons"><ul class="plugin-action-buttons"><li><a class="install-now button" data-slug="appointment-booking-calendar" href="<?php echo wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=appointment-booking-calendar'), 'install-plugin_appointment-booking-calendar'); ?>" aria-label="Install  Appointment Booking Calendar" data-name="Appointment Booking Calendar">Install Now</a></li><li><a href="plugin-install.php?tab=plugin-information&amp;plugin=appointment-booking-calendar" class="thickbox open-plugin-details-modal" aria-label="More information about Appointment Booking Calendar" data-title="Appointment Booking Calendar">More Details</a></li></ul>				</div>
				<div class="desc column-description">
					<p>Appointment booking calendar for booking time-slots into dates from a set of available time-slots in a calendar. Includes PayPal payments integration for processing the bookings.</p>
					
				</div>
			</div>
    </div>  
    
    <div style="clear:both"></div>    

  </div>    
 </div>

  
</div> 


[<a href="https://wordpress.org/support/plugin/booking-calendar-contact-form#new-post" target="_blank">Support</a>] | [<a href="https://bccf.dwbooster.com/" target="_blank">Documentation</a>]
</form>
</div>














