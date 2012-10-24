<table width="817" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4;font-family:Arial">
	<tr>
		<td>
			<?php // HEADER ?>
			<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#FC3B0F">
				<tr height="24">
					<td width="30"><a name="antenna_top"></a></td>
					<td width="105"></td>
					<td width="480"></td>
					<td width="175"></td>
					<td width="30"></td>
				</tr>
				<tr>
					<td></td>
					<td><img src="<?php echo Configure::read('Application.url.admin'); ?>/images/logo_email.png" width="89" height="88" alt="antenna_" /></td>
					<td>
						<img src="<?php echo Configure::read('Application.url.admin'); ?>/images/guideheader.png" width="445" height="25" alt="Dublin Event Guide (for free events)" />
						<p style="font-family:arial;font-size:14px;color:#FFF;padding: 5px;margin:0;">No. <strong><?php echo $dataEdition['issue']; ?></strong> | <?php echo date("d F Y", strtotime($dataEdition['start'])); ?></p>
					</td>
					<td>
						<div style="background-color:#FC3B0F;border: 1px solid #FFF;width:160px;height:75px;margin-left:8px">
							<p style="font-family:arial;font-size:15px;color:#fff;margin:0;padding:10px 0;text-align:center;">Subscribers: <?php echo $subscribers; ?>
							<br /><a href="<?php echo $dataNewsletter['facebook_like']; ?>"><img src="<?php echo Configure::read('Application.url.admin'); ?>/images/like.png" width="58" height="22" style="padding-top:10px;" /></a></p>
						</div>
					</td>
					<td></td>
				</tr>
				<tr height="24">
					<td colspan="5"></td>
				</tr>
			</table>
			<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#FC3B0F; border-top: 1px solid #FFF">
				<tr>
					<td>
						<p style="color:#fff;font-family:arial;font-size:13px;text-align:center;padding:0;line-height:24px">
							<?php
								if(
									($dataNews['title1'] != '') || 
									($dataNews['title2'] != '') || 
									($dataNews['title3'] != '') || 
									($dataNews['title4'] != '') || 
									($dataNews['title5'] != '') || 
									($dataNews['title6'] != '') ||
									($dataNews['opportunities'] != '')
								)
								{
									
									echo '<a href="#news" style="color:#fff;text-decoration:none">News</a> - ';
								}
								if(
									($dataCompetitions['title1'] != '') || 
									($dataCompetitions['title2'] != '') || 
									($dataCompetitions['title3'] != '') || 
									($dataCompetitions['title4'] != '') || 
									($dataCompetitions['title5'] != '') || 
									($dataCompetitions['title6'] != '')
								)
								{
									echo '<a href="#competitions" style="color:#fff;text-decoration:none">Competitions</a> - ';
								}
								if($dataEC1['content'] != '')
								{
									echo '<a href="#ec1" style="color:#fff;text-decoration:none">Email content 1</a> -  ';
								}
								if($dataHighlights['content'] != '')
								{
									echo '<a href="#highlights" style="color:#fff;text-decoration:none">Highlights</a> - ';
								}
								if($dataCS1['content'] != '')
								{
									echo '<a href="#cs1" style="color:#fff;text-decoration:none">Content section 1</a> - ';
								}
								if($dataCS2['content'] != '')
								{
									echo '<a href="#cs2" style="color:#fff;text-decoration:none">Content section 2</a>';
								}
									echo '<br>';
								foreach($eventsDates as $eventDate)
								{
									echo '<a href="#day_' . $eventDate .'" style="color:#fff;text-decoration:none">' . date('D', $eventDate) . '</a> - ';
								}
							   if(
									($dataComing['title1'] != '') || 
									($dataComing['title2'] != '') || 
									($dataComing['title3'] != '') || 
									($dataComing['title4'] != '') || 
									($dataComing['title5'] != '') || 
									($dataComing['title6'] != '')
								)
								{
									echo '<a href="#coming" style="color:#fff;text-decoration:none">Events Coming Up</a> - ';
								}
								
						?></p>
					</td>
				</tr>
			</table>
			<?php // END HEADER ?>



			<?php // TEXT CONTENT ?>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding:15px 30px">
						<div style="font-size:13px;color:#534438;line-height:20px;"><?php echo $this->Newsletter->styleHTML($dataNewsletter['intro']); ?></div>    
						
						<p><a href="<?php echo $dataNewsletter['facebook_like']; ?>"><img src="<?php echo Configure::read('Application.url.admin'); ?>/images/like.png" width="58" height="22" style="padding-top:10px;" /></a></p>  
						<div style="font-size:13px;color:#534438;line-height:20px;"><?php echo $this->Newsletter->styleHTML($dataNewsletter['facebook_description']); ?></div>
						<?php if($dataNewsletter['advertisement'] != '')
							{
						?>
						<p style="font-size:13px;color:#534438;line-height:20px;margin:10px 0">--Advertisement------------------------------------</p>
						<p style="font-size:13px;color:#534438;line-height:20px;margin:10px 0"><?php echo $this->Newsletter->styleHTML($dataNewsletter['advertisement']); ?></p>
						<?php
							}
						?>
					</td>
				</tr>
			</table>
			<?php // END TEXT CONTENT ?>



			<?php
				if($dataCS1['content'] != '')
				{
			?>
			<?php // IMAGE DIVIDER ?>
			<table width="100%" cellpadding="0" cellspacing="0" id="cs1">
				<tr>
					<td>
						<a name="cs1"></a><a href="#antenna_top" style="text-decoration:none"><img src="<?php echo Configure::read('Application.url.admin'); ?>/images/dividers/cs1.png" alt="Content Section 1" border="0" /></a>
					</td>
				</tr>
			</table>
			<?php // END IMAGE DIVIDER ?>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding: 0 30px 15px">
						<div style="font-size:13px;color:#534438;line-height:20px;"><?php echo $this->Newsletter->styleHTML($dataCS1['content']); ?></div>
						<?php if($dataCS1['advertisement'] != '')
							{
						?>
						<p style="font-size:13px;color:#534438;line-height:20px;margin:10px 0">--Advertisement------------------------------------</p>
						<p style="font-size:13px;color:#534438;line-height:20px;margin:10px 0"><?php echo $this->Newsletter->styleHTML($dataCS1['advertisement']); ?></p>
						<?php
							}
						?>
					</td>
				</tr>
			</table>
			<?php
				}
			?>



			<?php
				if($dataEC1['content'] != '')
				{
			?>
			<?php // IMAGE DIVIDER ?>
			<table width="100%" cellpadding="0" cellspacing="0" id="ec1">
				<tr>
					<td>
						<a name="ec1"></a><a href="#antenna_top" style="text-decoration:none"><img src="<?php echo Configure::read('Application.url.admin'); ?>/images/dividers/ec1.png" alt="Email content 1" border="0" /></a>
					</td>
				</tr>
			</table>
			<?php // END IMAGE DIVIDER ?>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding: 0 30px 15px">
						<div style="font-size:13px;color:#534438;line-height:20px;"><?php echo $this->Newsletter->styleHTML($dataEC1['content']); ?></div>
						<?php if($dataEC1['advertisement'] != '')
							{
						?>
						<p style="font-size:13px;color:#534438;line-height:20px;margin:10px 0">--Advertisement------------------------------------</p>
						<p style="font-size:13px;color:#534438;line-height:20px;margin:10px 0"><?php echo $this->Newsletter->styleHTML($dataEC1['advertisement']); ?></p>
						<?php
							}
						?>
					</td>
				</tr>
			</table>
			<?php
				}
			?>



			<?php
				if($dataHighlights['content'] != '')
				{
			?>
			<?php // IMAGE DIVIDER ?>
			<table width="100%" cellpadding="0" cellspacing="0" id="highlights">
				<tr>
					<td>
						<a name="highlights"></a><a href="#antenna_top" style="text-decoration:none"><img src="<?php echo Configure::read('Application.url.admin'); ?>/images/dividers/highlights.png" alt="Highlights" border="0" /></a>
					</td>
				</tr>
			</table>
			<?php // END IMAGE DIVIDER ?>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding: 0 30px 15px">
						<div style="font-size:13px;color:#534438;line-height:20px;"><?php echo $this->Newsletter->styleHTML($dataHighlights['content']); ?></div>
						<?php if($dataHighlights['advertisement'] != '')
							{
						?>
						<p style="font-size:13px;color:#534438;line-height:20px;margin:10px 0">--Advertisement------------------------------------</p>
						<p style="font-size:13px;color:#534438;line-height:20px;margin:10px 0"><?php echo $this->Newsletter->styleHTML($dataHighlights['advertisement']); ?></p>
						<?php
							}
						?>
					</td>
				</tr>
			</table>
			<?php
				}
				if(
					($dataCompetitions['title1'] != '') || 
					($dataCompetitions['title2'] != '') || 
					($dataCompetitions['title3'] != '') || 
					($dataCompetitions['title4'] != '') || 
					($dataCompetitions['title5'] != '') || 
					($dataCompetitions['title6'] != '')
				)
				{
			?>
			<?php // IMAGE DIVIDER ?>
			<table width="100%" cellpadding="0" cellspacing="0" id="competitions">
				<tr>
					<td>
						<a name="competitions"></a><a href="#antenna_top" style="text-decoration:none"><img src="<?php echo Configure::read('Application.url.admin'); ?>/images/dividers/competitions.png" alt="Competitions" border="0" /></a>
					</td>
				</tr>
			</table>
			<?php // END IMAGE DIVIDER ?>
			<table width="100%" cellpadding="0" cellspacing="0">
				<?php 
					for($index = 1; $index <= 6; $index += 1)
					{
						if($dataCompetitions["title$index"] != '')
						{
				?>
				<tr>
					<td style="padding: 0 30px; margin-bottom: 15px;">
						<h2 style="font-size:16px;color:#534438;margin:0 0 5px;font-weight:normal; margin-top: 15px;"><?php echo $dataCompetitions["title$index"]; ?></h2>
						<h3 style="font-size:13px;margin:0;padding:0;line-height:16px;color:#534438;"><?php echo $dataCompetitions["date$index"]; ?></h3>
						<div style="font-size:13px;color:#534438;line-height:20px;margin:0;padding-top:0;"><?php echo $this->Newsletter->styleHTML($dataCompetitions["description$index"]); ?></div>
					</td>
				</tr>
				<?php
						}
					}
				?>
				<?php if($dataCompetitions['advertisement'] != '')
					{
				?>
				<tr>
					<td style="padding: 0 30px 15px">
						<p style="font-size:13px;color:#534438;line-height:20px;margin:10px 0">--Advertisement------------------------------------</p>
						<p style="font-size:13px;color:#534438;line-height:20px;margin:10px 0"><?php echo $this->Newsletter->styleHTML($dataCompetitions['advertisement']); ?></p>
					</td>
				</tr>
				<?php
					}
				?>
			</table>
			<?php
				}
			
				if(
					($dataNews['title1'] != '') || 
					($dataNews['title2'] != '') || 
					($dataNews['title3'] != '') || 
					($dataNews['title4'] != '') || 
					($dataNews['title5'] != '') || 
					($dataNews['title6'] != '') || 
					($dataNews['opportunities'] != '') 
				)
				{
			?>
			<?php // IMAGE DIVIDER ?>
			
			<table width="100%" cellpadding="0" cellspacing="0" id="news" style="margin-top: 10px;">
				<tr>
					<td>
						<a name="news"></a><a href="#antenna_top" style="text-decoration:none"><img src="<?php echo Configure::read('Application.url.admin'); ?>/images/dividers/news.png" alt="Dublin news" border="0" /></a>
					</td>
				</tr>
			</table>
			<?php // END IMAGE DIVIDER ?>
			<table width="100%" cellpadding="0" cellspacing="0">
				<?php 
					for($index = 1; $index <= 6; $index += 1)
					{
						if($dataNews["title$index"] != '')
						{
				?>
				<tr>
					<td style="padding: 0 30px; margin-bottom: 15px;">
						<h2 style="font-size:16px;color:#534438;margin:0 0 5px;font-weight:normal; margin-top: 15px;"><?php echo $dataNews["title$index"]; ?></h2>
						<div style="font-size:13px;color:#534438;line-height:20px;margin:0;padding-top:0;"><?php echo $this->Newsletter->styleHTML($dataNews["description$index"]); ?></div>
					</td>
				</tr>
				<?php
						}
					}
				?>
			</table>
			<?php
				}

				if($dataNews['advertisement'] != '')
				{
			?>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding: 0 30px 15px">
						<p style="font-size:13px;color:#534438;line-height:20px;margin:10px 0"><?php echo $this->Newsletter->styleHTML($dataNews['advertisement']); ?></p>
					</td>
				</tr>
			</table>
			<?php
				}

				if($dataNews['opportunities'] != '')
				{
			?>
			<?php //IMAGE DIVIDER ?>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<a href="#antenna_top" style="text-decoration:none"><img src="<?php echo Configure::read('Application.url.admin'); ?>/images/dividers/opportunities.png" alt="Opportunities" border="0" /></a>
					</td>
				</tr>
			</table>
			<?php // END IMAGE DIVIDER ?>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding: 0 30px 15px">
						<div style="font-size:13px;color:#534438;line-height:20px;"><?php echo $this->Newsletter->styleHTML($dataNews['opportunities']); ?></div>
					</td>
				</tr>
			</table>
			<?php
				}
			?>
            

			<?php // CATEGORY DIVIDER ?>
			<?php
				foreach($eventsData as $eventData)
				{
			?>
			<table width="100%" cellpadding="0" cellspacing="0" id="day_<?php echo $eventData['dayID']; ?>" style="margin-top: 10px;">
				<tr height="34" style="background-color:#2b3a41;color:#fff">
					<td style="padding: 0; line-height: 1; height: 34px; overflow: hidden;">
						<p style="width:630px;padding-left:30px;margin: 0; height: 34px; overflow: hidden; line-height: 34px;">
							<a name="day_<?php echo $eventData['dayID']; ?>"></a><strong><?php echo $eventData['day']; ?>&nbsp;&nbsp;</strong> <?php echo $eventData['date']; ?>
						</p>
					</td>
					<td>
						<p style="margin:0;line-height:34px;padding:0;font-size:13px;">
							<a href="#antenna_top" style="color:#fff;text-decoration:none">back to top</a>
						</p>
					</td>
					<td>
						<p style="margin:0;padding:0;font-size:13px;">
							<a href="#antenna_top" style="color:#fff;text-decoration:none"><img src="<?php echo Configure::read('Application.url.admin'); ?>/images/dividers/date_toplink.png" width="38" height="34" alt="Back to top" />
							</a>
						</p>
					</td>
					<td width="50">
						&nbsp;
					</td>
				</tr>
			</table>
			<?php // END CATEGORY DIVIDER ?>
			<?php // LISTING ?><?php
					
						foreach($eventData['events'] as $event)
						{
					
			?><table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding:10px 30px">
						<table width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td width="52" valign="top">
								 	<img src="<?php echo Configure::read('Application.url.admin'); ?>/images/categories/<?php echo strtoupper($event['category']); ?>.png" width="32" height="32" />
								</td>
								<td>
									<h2 style="font-size:16px;color:#534438;margin:0 0 5px;font-weight:normal"><?php echo $event['title']; ?></h2>
									<h3 style="font-size:13px;margin:0;padding:0;line-height:16px;color:#534438;"><?php
											if(isset($event['weekly']) && ($event['weekly'] == '1')) {
											  echo  '<img src="' . Configure::read('Application.url.admin') . '/images/weekly.png" width="69" height="16" style="display:inline;float:left;" />&nbsp;';
											}
											echo $event['stime']; 
											if($event['etime'] != '') {
												echo ' - '. $event['etime'];
											}
											echo ', ';
											echo $event['start']; ?></h3>
									<p style="font-size:13px;color:#534438;line-height:20px;margin:0;padding-top:0;"><?php echo $event['address']; ?></p>
									
									<table width="100%" cellspacing="0" cellpadding="0">
										<tr>
											<td valign="top">
												<?php
													if($event['summary'] != '')
													{
												?>
												<div style="font-size:13px;color:#534438;line-height:20px;"><?php echo $this->Newsletter->styleHTML($event['summary']); ?></div>
												<?php
													}
												?>
												<div style="font-size:13px;color:#534438;line-height:20px;"><?php echo $this->Newsletter->styleHTML($event['description']); ?></div>
												<?php
													if($event['link'] != '')
													{
												?>
												<p style="font-size:13px;color:#534438;line-height:20px;"><a style="color:#cc2979;text-decoration:none" href="<?php echo $event['link']; ?>"><?php echo $event['link']; ?></a></p>
												<?php
													}
												?>
											</td>
											<td valign="top"<?php if($event['picturen'] != '') { ?>width="132" style="padding:16px 0 0 0;"<?php } ?>>
												<?php
													if($event['picturen'] != '')
													{
												?>
												<!-- EVENT PHOTO -->
												<img src="<?php echo Configure::read('Application.url.api'); ?>/show/<?php echo $event['id']; ?>" width="120" style="margin:0 10px 0 0" />
												<?php
													}
												?>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table><?php
						}
					
			?><?php // END LISTING ?><?php
				}
			?><table width="100%" cellpadding="0" cellspacing="0" style="height:40px;"><tr><td>&nbsp;</td></tr></table><?php
				if(
					($dataComing['title1'] != '') || 
					($dataComing['title2'] != '') || 
					($dataComing['title3'] != '') || 
					($dataComing['title4'] != '') || 
					($dataComing['title5'] != '') || 
					($dataComing['title6'] != '')
				)
				{
			?>
			<?php // IMAGE DIVIDER ?>
			<table width="100%" cellpadding="0" cellspacing="0" id="coming">
				<tr>
					<td>
						<a name="coming"></a><a href="#antenna_top" style="text-decoration:none"><img src="<?php echo Configure::read('Application.url.admin'); ?>/images/dividers/coming.png" alt="Events Coming Up" border="0" /></a>
					</td>
				</tr>
			</table>
			<?php // END IMAGE DIVIDER ?>
			<table width="100%" cellpadding="0" cellspacing="0">
				
					
				<?php 
					for($index = 1; $index <= 6; $index += 1)
					{
						if($dataComing["title$index"] != '')
						{
				?>       
				<tr>
					<td style="padding:10px 30px">
		<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="52" valign="top">
					 	<img src="<?php echo Configure::read('Application.url.admin'); ?>/images/upcoming_events.png" width="38" height="39" />
					</td>
					<td>
						<h2 style="font-size:16px;color:#534438;margin:0 0 5px;font-weight:normal"><?php echo $dataComing["title$index"]; ?></h2>
						<h3 style="font-size:13px;margin:0;padding:0;line-height:16px;color:#534438;"><?php echo $dataComing["date$index"]; ?></h3>
						<?php if($dataComing["location$index"] != '') { ?>
						<p style="font-size:13px;color:#534438;line-height:20px;margin:0;padding-top:0;"><?php echo $dataComing["location$index"]; ?></p>                  
						<?php } ?>
						<div style="font-size:13px;color:#534438;line-height:20px;margin:0;padding-top:0;"><?php echo $this->Newsletter->styleHTML($dataComing["description$index"]); ?></div>
					</td>
				</tr> 
				</table>
				</td>
				</tr>
				<?php
						}
					}
				?>
				<?php if($dataComing['advertisement'] != '')
					{
				?>
				<tr>
					<td style="padding: 0 30px 15px" colspan="2">
						<p style="font-size:13px;color:#534438;line-height:20px;">--Advertisement------------------------------------</p>
						<p style="font-size:13px;color:#534438;line-height:20px;"><?php echo $this->Newsletter->styleHTML($dataComing['advertisement']); ?></p>
					</td>
				</tr>
				<?php
					}
				?>
			
			</table>
			<?php
				}
			?>



			<?php
				if($dataCS2['content'] != '')
				{
			?>
			<?php // IMAGE DIVIDER ?>
			<table width="100%" cellpadding="0" cellspacing="0" id="cs2">
				<tr>
					<td>
						<a name="cs2"></a><a href="#antenna_top" style="text-decoration:none"><img src="<?php echo Configure::read('Application.url.admin'); ?>/images/dividers/cs2.png" alt="This is Content section 2" border="0" /></a>
					</td>
				</tr>
			</table>
			<?php // END IMAGE DIVIDER ?>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding: 0 30px 15px">
						<div style="font-size:13px;color:#534438;line-height:20px;"><?php echo $this->Newsletter->styleHTML($dataCS2['content']); ?></div>
						<?php if($dataCS2['advertisement'] != '')
							{
						?>
						<p style="font-size:13px;color:#534438;line-height:20px;margin:10px 0">--Advertisement------------------------------------</p>
						<p style="font-size:13px;color:#534438;line-height:20px;margin:10px 0"><?php echo $this->Newsletter->styleHTML($dataCS2['advertisement']); ?></p>
						<?php
							}
						?>
					</td>
				</tr>
			</table>
			<?php
				}
			?>
			
			<?php
				if($dataOutro['outro'] != '')
				{
			?>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding: 0 30px 15px">
						<div style="font-size:13px;color:#534438;line-height:20px;"><?php echo $this->Newsletter->styleHTML($dataOutro['outro']); ?></div>
					</td>
				</tr>
			</table>
			<?php
				}
			?>
			<?php
				if($dataOutro['footer'] != '')
				{
			?>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding: 0 30px 15px">
						<div style="font-size:13px;color:#534438;line-height:20px;"><?php echo $this->Newsletter->styleHTML($dataOutro['footer']); ?></div>
					</td>
				</tr>
			</table>
			<?php
				}
			?>


		</td>
	</tr>
</table>