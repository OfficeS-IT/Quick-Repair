<?php


$this->item = intval($_GET["cal"]);

$current_user = wp_get_current_user();
$current_user_access = current_user_can('edit_pages');

if ( !is_admin() || (!$current_user_access && !@in_array($current_user->ID, unserialize($this->get_option("cp_user_access","")))))
{
    echo 'Direct access not allowed.';
    exit;
}


$message = "";


if (isset($_GET['lu']) && $_GET['lu'] != '')
{
    $this->verify_nonce ($_GET["anonce"], 'cpappb_actions_booking');
    $myrows = $wpdb->get_results( $wpdb->prepare("SELECT * FROM ".$wpdb->prefix.$this->table_messages." WHERE id=%d", $_GET['lu']) );
    $params = unserialize($myrows[0]->posted_data);
    $params["paid"] = $_GET["status"];
    $params["payment_type"] = __('Manually updated','cpappb');  
    $wpdb->query( $wpdb->prepare('UPDATE `'.$wpdb->prefix.$this->table_messages.'` SET posted_data=%s WHERE id=%d', serialize($params), $_GET['lu']) );
    $message = "Item updated";        
}
else if (isset($_GET['ld']) && $_GET['ld'] != '')
{
    $this->verify_nonce ($_GET["anonce"], 'cpappb_actions_booking');
    $wpdb->query( $wpdb->prepare('DELETE FROM `'.$wpdb->prefix.$this->table_messages.'` WHERE id=%d', $_GET['ld']) );
    $message = "Item deleted";
}

if ($this->item != 0)
    $myform = $wpdb->get_results( $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.$this->table_items .' WHERE id=%d' ,$this->item) );


$current_page = intval($_GET["p"]);
if (!$current_page) $current_page = 1;
$records_per_page = 50;                                                                                  

$cond = '';
if ($_GET["search"] != '') $cond .= " AND (data like '%".esc_sql($_GET["search"])."%' OR posted_data LIKE '%".esc_sql($_GET["search"])."%')";
if ($_GET["dfrom"] != '') $cond .= " AND (`time` >= '".esc_sql($_GET["dfrom"])."')";
if ($_GET["dto"] != '') $cond .= " AND (`time` <= '".esc_sql($_GET["dto"])." 23:59:59')";
if ($this->item != 0) $cond .= " AND formid=".$this->item;

$events_query = "SELECT * FROM ".$wpdb->prefix.$this->table_messages." WHERE 1=1 ".$cond." ORDER BY `time` DESC";
/**
 * Allows modify the query of messages, passing the query as parameter
 * returns the new query
 */
$events_query = apply_filters( 'cpappb_messages_query', $events_query );
$events = $wpdb->get_results( $events_query );
$total_pages = ceil(count($events) / $records_per_page);


if ($message) echo "<div id='setting-error-settings_updated' class='updated'><h2>".$message."</h2></div>";

$nonce = wp_create_nonce( 'cpappb_actions_booking' );

?>
<script type="text/javascript">

 function cp_updateMessageItem(id,status)
 {    
    document.location = 'admin.php?page=<?php echo $this->menu_parameter; ?>&anonce=<?php echo $nonce; ?>&cal=<?php echo $_GET["cal"]; ?>&list=1&status='+status+'&lu='+id+'&r='+Math.random( );   
 } 
 function cp_deleteMessageItem(id)
 {
    if (confirm('Are you sure that you want to delete this item?'))
    {        
        document.location = 'admin.php?page=<?php echo $this->menu_parameter; ?>&anonce=<?php echo $nonce; ?>&cal=<?php echo $_GET["cal"]; ?>&list=1&ld='+id+'&r='+Math.random();
    }
 }
</script>

<h1><?php _e('Booking Orders','cpappb'); ?> - <?php if ($this->item != 0) echo $myform[0]->form_name; else echo 'All forms'; ?></h1>

<div class="ahb-buttons-container">
	<a href="<?php print esc_attr(admin_url('admin.php?page='.$this->menu_parameter));?>" class="ahb-return-link">&larr;Return to the calendars list</a>
	<div class="clear"></div>
</div>

<div class="ahb-section-container">
	<div class="ahb-section">
      <form action="admin.php" method="get">
        <input type="hidden" name="page" value="<?php echo $this->menu_parameter; ?>" />
        <input type="hidden" name="cal" value="<?php echo $this->item; ?>" />
        <input type="hidden" name="list" value="1" />
		<nobr><label>Search for:</label> <input type="text" name="search" value="<?php echo esc_attr(@$_GET["search"]); ?>">&nbsp;&nbsp;</nobr>
		<nobr><label>From:</label> <input type="text" id="dfrom" name="dfrom" value="<?php echo esc_attr(@$_GET["dfrom"]); ?>" >&nbsp;&nbsp;</nobr>
		<nobr><label>To:</label> <input type="text" id="dto" name="dto" value="<?php echo esc_attr(@$_GET["dto"]); ?>" >&nbsp;&nbsp;</nobr>
		<nobr><label>Item:</label> <select id="cal" name="cal">
          <option value="0">[All Items]</option>
   <?php
    $myrows = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix.$this->table_items );                                                                     
    foreach ($myrows as $item)  
         echo '<option value="'.$item->id.'"'.(intval($item->id)==intval($this->item)?" selected":"").'>'.$item->form_name.'</option>'; 
   ?>
    </select></nobr>
		<nobr>
			<input type="submit" name="<?php echo $this->prefix; ?>_csv" value="<?php _e('Export to CSV','cpappb'); ?>" class="button" style="float:right;margin-left:10px;">
			<input type="submit" name="ds" value="<?php _e('Filter','cpappb'); ?>" class="button-primary button" style="float:right;">
		</nobr>
      </form>
	</div>
</div>

                             
<?php


echo paginate_links(  array(
    'base'         => 'admin.php?page='.$this->menu_parameter.'&cal='.$this->item.'&list=1%_%&dfrom='.urlencode($_GET["dfrom"]).'&dto='.urlencode($_GET["dto"]).'&search='.urlencode($_GET["search"]),
    'format'       => '&p=%#%',
    'total'        => $total_pages,
    'current'      => $current_page,
    'show_all'     => False,
    'end_size'     => 1,
    'mid_size'     => 2,
    'prev_next'    => True,
    'prev_text'    => __('&laquo; Previous'),
    'next_text'    => __('Next &raquo;'),
    'type'         => 'plain',
    'add_args'     => False
    ) );

?>

<div id="dex_printable_contents">
<div class="ahb-orderssection-container" style="background:#f6f6f6;padding-bottom:20px;">
<table border="0" style="width:100%;" class="ahb-orders-list" cellpadding="10" cellspacing="10">
	<thead>
	<tr>
      <th width="30"><?php _e('ID','cpappb'); ?></th>
	  <th style="text-align:left" width="130"><?php _e('Submission Date','cpappb'); ?></th>
	  <th style="text-align:left"><?php _e('Email','cpappb'); ?></th>
	  <th style="text-align:left"><?php _e('Message','cpappb'); ?></th>
      <th width="130"><?php _e('Paid Status','cpappb'); ?></th>
	  <th  class="cpnopr"><?php _e('Options','cpappb'); ?></th>	
	</tr>
	</thead>
	<tbody id="the-list">
	 <?php for ($i=($current_page-1)*$records_per_page; $i<$current_page*$records_per_page; $i++) if (isset($events[$i])) { 
              $posted_data = unserialize($events[$i]->posted_data);	
              $cancelled = false;
              for($k=0; $k<count($posted_data["apps"]); $k++)
                  if ($posted_data["apps"][$i]["cancelled"] != '')
                      $cancelled = true;
     ?>
	  <tr class='<?php if ($cancelled) { ?>cpappb_cancelled <?php } ?><?php if (($i%2)) { ?>alternate <?php } ?>author-self status-draft format-default iedit' valign="top">
        <th><?php echo $events[$i]->id; ?></th>
		<td><?php echo substr($events[$i]->time,0,16); ?></td>
		<td><?php echo $events[$i]->notifyto; ?></td>
		<td><?php 
		        $data = str_replace("\n","<br />",str_replace('<','&lt;',$events[$i]->data));		        	        
		        foreach ($posted_data as $item => $value)
		            if (strpos($item,"_url") && $value != '')		         
		            {		                
		                $data = str_replace ($posted_data[str_replace("_url","",$item)],'<a href="'.$value[0].'" target="_blank">'.$posted_data[str_replace("_url","",$item)].'</a><br />',$data);  		                
		            }   
		        $data = str_replace("&lt;img ","<img ", $data);     
		        echo $data;                  
		    ?></td>
        <td align="center"><?php echo '<span style="color:#006799;font-weight:bold;">'.(@$posted_data["paid"]=='1'?__('Paid','cpappb').'</span><br /><em class="cpappsoft">'.$posted_data["payment_type"]:'').'</em>'; ?></td>    
		<td class="cpnopr" style="text-align:center;">
          <input class="button" type="button" name="caldelete_<?php echo $events[$i]->id; ?>" value="Toggle Payment" onclick="cp_updateMessageItem(<?php echo $events[$i]->id; ?>,<?php echo (@$posted_data["paid"]?'0':'1'); ?>);" />  
		  <input class="button" type="button" name="caldelete_<?php echo $events[$i]->id; ?>" value="Delete" onclick="cp_deleteMessageItem(<?php echo $events[$i]->id; ?>);" />     
          <?php if ($cancelled) echo '<div style="color:#ff0000;font-weight:bold;">* Contains cancelled dates</div>'; ?>          
		</td>
      </tr>
     <?php } ?>
	</tbody>
</table>
</div>
</div>

<div class="ahb-buttons-container">
    <input type="button" value="Print" class="button button-primary" onclick="do_dexapp_print();" />
	<a href="<?php print esc_attr(admin_url('admin.php?page='.$this->menu_parameter));?>" class="ahb-return-link">&larr;Return to the calendars list</a>
	<div class="clear"></div>
</div>



<script type="text/javascript">
 function do_dexapp_print()
 {
      w=window.open();
      w.document.write("<style>.cpnopr{display:none;};table{border:2px solid black;width:100%;}th{border-bottom:2px solid black;text-align:left}td{padding-left:10px;border-bottom:1px solid black;}</style>"+document.getElementById('dex_printable_contents').innerHTML);
      w.print();
      w.close();    
 }
 
 var $j = jQuery.noConflict();
 $j(function() {
 	$j("#dfrom").datepicker({     	                
                    dateFormat: 'yy-mm-dd'
                 });
 	$j("#dto").datepicker({     	                
                    dateFormat: 'yy-mm-dd'
                 });
 });
 
</script>














