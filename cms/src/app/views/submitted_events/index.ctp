<div id="contentWrapper" class="SF_left">
	<div id="contentHeader" class="SF_niceclear">
		<div id="contentHeaderMargin" class="SF_niceclear">
			<h1>Submitted events</h1>
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
						)); ?>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
		</div>
	</div>
	<section id="content" class="SF_niceclear">

		<?php if(isset($shamrockFeedback)) { echo $shamrockFeedback; } ?>

		<div id="contentList" class="fadeArea noIcons">
			<table class="dataTable dataSubmittedTable">
				<thead>
					<tr>
						<th>Submitted</th>
						<th>Day</th>
						<th>Date&nbsp;&amp;&nbsp;Time</th>
						<th>Event, Location</th>
						<th>Email</th>
						<th>Phone</th>
					</tr>
				</thead>
				<tbody>
			<?php 
				foreach($listItems as $item)
				{
					$itemTitle = "<b>". $item['SubmittedEvent']['title'] ."</b>&nbsp;&nbsp;&nbsp;&nbsp;". $item['SubmittedEvent']['address'];
					$itemTitle = $this->Text->truncate($itemTitle, 45, array(
						'ending' => '&hellip;',
						'exact' => false, 
						'html' => true
					));
			?>
					<tr>
						<td><?php echo date("d-m-y", strtotime($item['SubmittedEvent']['created'])); ?></td>
						<td><?php echo date("l", strtotime($item['SubmittedEvent']['start'])); ?></td>
						<td><?php echo date("d-m-y", strtotime($item['SubmittedEvent']['start'])); ?> <?php echo substr($item['SubmittedEvent']['stime'], 0, -3); ?></td>
						<td>
							<a href="<?php echo Router::url(array('action' => 'details', $item['SubmittedEvent']['id'])); ?>"><?php echo $itemTitle; ?></a>
						</td>
						<td><a href="mailto:<?php echo $item['SubmittedEvent']['contact_email']; ?>"><?php echo $item['SubmittedEvent']['contact_email']; ?></a></td>
						<td><?php echo $item['SubmittedEvent']['contact_phone']; ?></td>
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
<?php echo $this->element('aside_submitted'); ?>