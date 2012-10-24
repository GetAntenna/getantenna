<div id="contentWrapper" class="SF_left">
	<div id="contentHeader" class="SF_niceclear">
		<div id="contentHeaderMargin" class="SF_niceclear">
			<h1>Edition <?php echo $editionNumber; ?> <span>(<?php echo $editionDate; ?>)</span></h1>
		</div>
	</div>
	<section id="content" class="SF_niceclear">

		<?php if(isset($shamrockFeedback)) { echo $shamrockFeedback; } ?>
		
		<div id="contentList" class="fadeArea noIcons">
			<table class="dataTable">
				<colgroup>
					<col style="width: 7%;" />
					<col style="width: 32%;" />
					<col style="width: 6%;" />
					<col style="width: 55%;" />
				</colgroup>
				<tbody>
				   
				 	
				
					<?php
					    
						$sections = array(
							array(
								"title" => 'Newsletter introduction',
								"data" => $editorialData['EditorialsNewsletter'],
								"mobile" => false,
								"edit_action" => 'edit_newsletter'
							),
							array(
								"title" => 'Content section 1',
								"data" => $editorialData['EditorialsCs1'],
								"mobile" => true,
								"edit_action" => 'edit_cs1'
							),
							array(
								"title" => 'Email content 1',
								"data" => $editorialData['EditorialsEc1'],
								"mobile" => false,
								"edit_action" => 'edit_ec1'
							),
							array(
								"title" => 'Highlights',
								"data" => $editorialData['EditorialsHighlight'],
								"mobile" => false,
								"edit_action" => 'edit_highlight'
							),
							array(
								"title" => 'Competitions',
								"data" => $editorialData['EditorialsCompetition'],
								"mobile" => true,
								"edit_action" => 'edit_competitions'
							),
							array(
								"title" => 'News',
								"data" => $editorialData['EditorialsNews'],
								"mobile" => true,
								"edit_action" => 'edit_news'
							),
							array(
								"title" => 'Events Coming Up',
								"data" => $editorialData['EditorialsEvent'],
								"mobile" => true,
								"edit_action" => 'edit_events'
							),
							array(
								"title" => 'Content section 2',
								"data" => $editorialData['EditorialsCs2'],
								"mobile" => true,
								"edit_action" => 'edit_cs2'
							),
							array(
								"title" => 'Newsletter outro',
								"data" => $editorialData['EditorialsOutro'],
								"mobile" => true,
								"edit_action" => 'edit_outro'
							)
							
							
						);
						
						foreach ($sections as $section) {
							echo $this->element('editorial_index_section',
								array(
									"title" => $section['title'],
									"data" => $section['data'],
									"mobile" => $section['mobile'],
									"edit_action" => $section['edit_action'],
									"editorial_id" => $editorialData['Editorial']['id'],
									"edition_id" => $selectedEdition
									));
						}
				 	?>
					
				   
				</tbody>
			</table>
		</div>

	</section>
</div>
<?php echo $this->element('aside_editorials'); ?>