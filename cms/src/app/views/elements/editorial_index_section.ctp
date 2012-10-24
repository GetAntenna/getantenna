<tr<?php if($data['draft'] == 1) { echo ' class="draft"'; } ?>>
	<td style="text-align: right;">              
		<?php if ($mobile) { ?>
		<img src="<?php echo $this->webroot; ?>images/icon_mobile.png" height="16" />
		<?php } ?>
		<img src="<?php echo $this->webroot; ?>images/icon_mail.png" height="16" />
		<img src="<?php echo $this->webroot; ?>images/icon_web.png" height="16" />
	</td>
	<td>
		(Last updated: 
		<?php 
			if($data['created'] ==  $data['modified'])
			{
				echo 'Never';
			}
			else
			{
				echo date("H:i l d.m.y", strtotime($data['modified']));
			}
		?>)
	</td>
	<td>
		<?php 
			if($data['draft'] == 1) 
			{ 
				echo "Draft"; 
			} 
			else 
			{ 
				echo "&nbsp;"; 
			} 
		?>
	</td>
	<td><b><a href="<?php echo Router::url(array('action' => $edit_action, $editorial_id, 'edition' => $edition_id, '_ts' => time())); ?>"><?php echo $title; ?></a><b></td>
</tr>