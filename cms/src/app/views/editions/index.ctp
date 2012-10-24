<div id="contentWrapper" class="SF_left">
	<section id="content" class="SF_niceclear">

		<?php if(isset($shamrockFeedback)) { echo $shamrockFeedback; } ?>

		<div id="contentList" class="fadeArea">

			<div class="itemsGroup">
				<div class="itemsGroupTitle"><h1>Live edition <span>Changes here will be seen immediately by mobile users. Only changes to future events can be saved, changes to past events can't be saved.</span></h1></div>
				<?php
					if(isset($publishedEdition) && !empty($publishedEdition))
					{
				?>
						<div class="item SF_clear">
							<div class="itemImage"><img src="<?php echo $this->webroot; ?>images/edition-live.png" height="56" /></div>
							<div class="itemDetails">
								<h3>Edition <?php echo $publishedEdition['Edition']['issue']; ?> <span>(<?php echo date("l d.m.y", strtotime($publishedEdition['Edition']['start'])); ?> - <?php echo date("l d.m.y", strtotime($publishedEdition['Edition']['end'])); ?>)</span></h3>
								<h4>Timestamp: <?php echo $publishedEdition['Edition']['stamp']; ?></h4>
								<p>
									<a href="<?php echo Router::url(array('controller' => 'events', 'edition' => $publishedEdition['Edition']['id'])); ?>"><?php __('Manage edition events', false); ?></a> | 
									<a href="<?php echo Router::url(array('controller' => 'editorials', 'edition' => $publishedEdition['Edition']['id'])); ?>"><?php __('Manage editorial &amp; content', false); ?></a> | 
									<a href="<?php echo Router::url(array('controller' => 'dashboard', 'edition' => $publishedEdition['Edition']['id'])); ?>"><?php __('Edit this edition', false); ?></a>
								</p>
							</div>
						</div>
				<?php
					}
					else
					{
				?>
						<div class="feedback feedbackError">There isn't a current edition</div>
				<?php
					}
				?>
			</div>

			<div class="itemsGroup">
				<div class="itemsGroupTitle">
					<h1>Draft editions <span>Recurring events are copied to draft edition, edit these first. Copied events are copied to ALL draft editions.</span></h1>
					<div id="sectionToolbar">
						<a class="button readyButton" href="<?php echo Router::url(array('controller' => 'editions', 'action' => 'add')); ?>">Add a draft edition</a> 
					</div>
				</div>
			<?php
				if(isset($draftEditions) && !empty($draftEditions))
				{
					$counter = 1;
					foreach($draftEditions as $draft)
					{
						$start = date('l d.m.y', strtotime($draft['Edition']['start']));
						$end = date('l d.m.y', strtotime($draft['Edition']['end']));
			?>
						<div class="item SF_clear">
							<div class="itemImage"><img src="<?php echo $this->webroot; ?>images/edition-draft.png" height="56" /></div>
							<div class="itemDetails">
								<h3>Edition <?php echo $draft['Edition']['issue']; ?> <span>(<?php echo $start; ?> - <?php echo $end; ?>)</span></h3>
								<p>
									<a href="<?php echo Router::url(array('controller' => 'events', 'edition' => $draft['Edition']['id'])); ?>"><?php __('Manage edition events', false); ?></a> | 
									<a href="<?php echo Router::url(array('controller' => 'editorials', 'edition' => $draft['Edition']['id'])); ?>"><?php __('Manage editorial &amp; content', false); ?></a> | 
									<a href="<?php echo Router::url(array('controller' => 'dashboard', 'edition' => $draft['Edition']['id'])); ?>"><?php __('Edit edition details', false); ?></a> | 
									<a href="#draftDelete<?php echo $counter; ?>" rel="shadowbox;height=236" class="admin"><span>Delete this draft edition</span></a>
								</p>
							</div>
						</div>

						<div id="draftDelete<?php echo $counter; ?>" class="SF_hidden">
							<div class="SBContent">
									<?php echo $this->Form->create("removeItem", array('url' => array('controller' => 'editions', 'action' => 'delete'), "id" => false)); ?>
									<?php echo $this->Form->input('id', array('label' => false, 'error' => false, 'type' => 'hidden', 'value' => $draft['Edition']['id'], "id" => false)); ?>
									<h1>Delete this draft edition?</h1>

									<div class="separator"></div>

									<p>If you do, you will lose all associated events &amp; editorial content. </p>
									<p><strong>Please note this operation can't be undone</strong></p>

									<div class="separator"></div>

									<div class="actions SF_niceclear">
										<div class="actionsPrimary">
											<button type="submit"><span><?php __('Delete this draft edition', false); ?></span></button>
										</div>
										<div class="actionsSecondary">
											<a class="admin" href="javascript:Shadowbox.close()"><?php __('Cancel', false); ?></a>
										</div>
									</div>
								<?php echo $this->Form->end(); ?>
							</div>
						</div>
			<?php
						$counter++;
					}
				}
				else
				{
			?>
					<div class="feedback feedbackNotice">There aren't draft editions</div>
			<?php
				}
			?>
			</div>

			<div class="itemsGroup">
				<div class="itemsGroupTitle"><h1>Previous editions <span>Events &amp; editorial from the past cannot be saved. Past events can be copied to the scrapbook.</span></h1></div>
			<?php
				if(isset($previousEditions) && !empty($previousEditions))
				{
					foreach($previousEditions as $draft)
					{
						$start = date('l d.m.y', strtotime($draft['Edition']['start']));
						$end = date('l d.m.y', strtotime($draft['Edition']['end']));
			?>
						<div class="item SF_clear">
							<div class="itemImage"><img src="<?php echo $this->webroot; ?>images/edition-draft.png" height="56" /></div>
							<div class="itemDetails">
								<h3>Edition <?php echo $draft['Edition']['issue']; ?> (<span>(<?php echo $start; ?> - <?php echo $end; ?>)</span>)</h3>
								<p>
									<a href="<?php echo Router::url(array('controller' => 'events', 'edition' => $draft['Edition']['id'])); ?>"><?php __('View edition events', false); ?></a> | 
									<a href="<?php echo Router::url(array('controller' => 'editorials', 'edition' => $draft['Edition']['id'])); ?>"><?php __('View editorial &amp; content', false); ?></a>
								</p>
							</div>
						</div>
			<?php
					}
				}
				else
				{
			?>
					<div class="feedback feedbackNotice">There aren't previous editions</div>
			<?php
				}
			?>
			</div>

		</div>

	</section>
</div>