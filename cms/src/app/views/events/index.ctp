<div id="contentWrapper" class="SF_left">
	<div id="contentHeader" class="SF_niceclear">
		<div id="contentHeaderMargin" class="SF_niceclear">
			<h1>Edition <?php echo $editionNumber; ?> <span>(<?php echo $editionDate; ?> | <?php echo count($listItems); ?> events)</span></h1>
			<div id="sectionToolbar">
				<div class="sectionSearch SF_right">
					<?php echo $this->Form->create(null, array('url' => array('action' => 'index', 'edition' => $selectedEdition), 'type' => 'get')); ?>
					<?php echo $this->Form->input('q', array(
							'type' => 'text', 
							'label'=>false, 
							'error' => false,
							'autocomplete' => 'off',
							'id'=>'toolbarSearch', 
							'value' => (stripslashes($searchKeyword)), 
							'class' => 'cTooltipEnabled', 
							'title' => __("<h4>Power search</h4><p><b>date:</b>dd-mm-yyyy</p><p><b>id:</b>event id</p><p><b>category:</b>category with underscores</p><p><b>highlight:</b>true/false</p><p><b>draft:</b>true/false</p>", true),
						)); ?>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
		</div>
	</div>
	<section id="content" class="SF_niceclear">

		<?php if(isset($shamrockFeedback)) { echo $shamrockFeedback; } ?>

		<div id="contentList" class="fadeArea noIcons">
			<table class="dataTable dataEventTable">
				<thead>
					<tr>
						<th>Day</th>
						<th>Date&nbsp;&amp;&nbsp;Time</th>
						<th>Status</th>
						<th>Event, Location</th>
						<th>Category</th>
						<th><img src="<?php echo $this->webroot; ?>images/icon_weekly.png" height="16" /></th>
						<th><img src="<?php echo $this->webroot; ?>images/icon_highlight.png" height="16" /></th>
						<th>ID&nbsp;&nbsp;&nbsp;</th>
					</tr>
				</thead>
				<tbody>
			<?php 
				foreach($listItems as $item)
				{
					$itemTitle = "<b>". $item['Event']['title'] ."</b>&nbsp;&nbsp;&nbsp;&nbsp;". $item['Event']['address'];
					$itemTitle = $this->Text->truncate($itemTitle, 65, array(
						'ending' => '&hellip;',
						'exact' => false, 
						'html' => true
					));
			?>
					<tr>
						<td><?php echo date("l", strtotime($item['Event']['start'])); ?></td>
						<td><?php echo date("d-m-y", strtotime($item['Event']['start'])); ?> <?php echo substr($item['Event']['stime'], 0, -3); ?></td>
						<td<?php if($item['Event']['draft'] == 1) { ?> class="draft"<?php } ?>><?php if($item['Event']['draft'] == 1) { echo "Draft"; } else { echo "Ready"; } ?></td>
						<td<?php if($item['Event']['draft'] == 1) { ?> class="draft"<?php } ?>>
							<a href="<?php echo Router::url(array('action' => 'edit', $item['Event']['id'], 'edition' => $selectedEdition)); ?>"><?php echo $itemTitle; ?></a>
						</td>
						<td><?php echo ucwords(str_replace("_", " ", $item['Event']['category'])); ?></td>
						<td><?php if($item['Event']['weekly'] == 1) { ?><img src="<?php echo $this->webroot; ?>images/icon_weekly.png" height="16" /><?php } ?></td>
						<td><?php if($item['Event']['highlight'] == 1) { ?><img src="<?php echo $this->webroot; ?>images/highlight_pick.png" height="16" /><?php } ?></td>
						<td><?php echo $item['Event']['id']; ?></td>
					</tr>
			<?php
				}
			?>
				</tbody>
			</table>

			<footer class="SF_niceclear" id="pagination">
				<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
				<?php echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled')); ?>
				<?php echo $this->Paginator->numbers(
					array(
						'modulus' => 10, 
						'separator' => ' ',
						'tag' => 'span', 
					)
				); ?>
				<?php echo $this->Paginator->next('Next »', null, null, array('class' => 'disabled')); ?> 
			</footer>
		</div>

	</section>
</div>
<?php echo $this->element('aside_events'); ?>