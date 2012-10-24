<div id="contentWrapper" class="SF_left">
	<div id="contentHeader" class="SF_niceclear">
		<div id="contentHeaderMargin" class="SF_niceclear">
			<h1>Events Scrapbook</h1>
			<div id="sectionToolbar">
				<div class="sectionSearch SF_right">
					<?php echo $this->Form->create(null, array('url' => array('action' => 'index'), 'type' => 'get')); ?>
					<?php echo $this->Form->input('q', array(
							'type' => 'text', 
							'label'=>false, 
							'error' => false,
							'autocomplete' => 'off',
							'id'=>'toolbarSearch', 
							'value' => (stripslashes($searchKeyword)), 
							'class' => 'cTooltipEnabled', 
							'title' => __("<h4>Power search</h4><p><b>date:</b>dd-mm-yyyy</p><p><b>id:</b>event id</p><p><b>category:</b>category with underscores</p><p><b>highlight:</b>true/false</p>", true),
						)); ?>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
		</div>
	</div>
	<section id="content" class="SF_niceclear">

		<?php if(isset($shamrockFeedback)) { echo $shamrockFeedback; } ?>

		<div id="contentList" class="fadeArea noIcons">
			<table class="dataTable dataScrapbookTable">
				<thead>
					<tr>
						<th>Modified</th>
						<th>Day</th>
						<th>Date&nbsp;&amp;&nbsp;Time</th>
						<th>Event, Location</th>
						<th>Category</th>
						<th>ID&nbsp;&nbsp;&nbsp;</th>
					</tr>
				</thead>
				<tbody>
			<?php 
				foreach($listItems as $item)
				{
					$itemTitle = "<b>". $item['ScrapbookEvent']['title'] ."</b>&nbsp;&nbsp;&nbsp;&nbsp;". $item['ScrapbookEvent']['address'];
					$itemTitle = $this->Text->truncate($itemTitle, 65, array(
						'ending' => '&hellip;',
						'exact' => false, 
						'html' => true
					));
			?>
					<tr>
						<td><?php echo date("d-m-y", strtotime($item['ScrapbookEvent']['modified'])); ?></td>
						<td><?php echo date("l", strtotime($item['ScrapbookEvent']['start'])); ?></td>
						<td><?php echo date("d-m-y", strtotime($item['ScrapbookEvent']['start'])); ?> <?php echo substr($item['ScrapbookEvent']['stime'], 0, -3); ?></td>
						<td>
							<a href="<?php echo Router::url(array('action' => 'edit', $item['ScrapbookEvent']['id'])); ?>"><?php echo $itemTitle; ?></a>
						</td>
						<td><?php echo ucwords(str_replace("_", " ", $item['ScrapbookEvent']['category'])); ?></td>
						<td><?php echo $item['ScrapbookEvent']['id']; ?></td>
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
<?php echo $this->element('aside_scrapbook'); ?>