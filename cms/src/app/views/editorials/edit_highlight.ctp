<div id="contentWrapper" class="SF_left">
	<div id="contentHeader" class="SF_niceclear">
		<div id="contentHeaderMargin" class="SF_niceclear">
			<h1>Highlights<span>(<a class="admin" href="<?php echo Router::url(array('action' => 'index', 'edition' => $selectedEdition)); ?>"><?php __('Cancel', false); ?></a>)</span></h1>
			<div id="sectionToolbar">
				<img src="<?php echo $this->webroot; ?>images/icon_mail.png" height="16" />
				<img src="<?php echo $this->webroot; ?>images/icon_web.png" height="16" />
				<?php 
					if(!$readonly)
					{
				?>
				<button type="submit" class="draftButton" id="draftButtonTop" form="EditorialEditHighlightForm"><span><?php __('Save as draft', false); ?></span></button>
				<button type="submit" class="readyButton" id="readyButtonTop" form="EditorialEditHighlightForm"><span><?php __('Save as ready', false); ?></span></button>
				<?php
					}
				?>
			</div>
		</div>
	</div>
	<section id="content" class="SF_niceclear">

		<?php if(isset($shamrockFeedback)) { echo $shamrockFeedback; } ?>

		<?php if(isset($shamrockErrors) && $shamrockErrors == true) { ?><div class="feedback feedbackError"><?php __('<b>Oops, something wasn&#39;t right.</b> Can you review the data you entered?', false); ?></div><?php } ?>

		<?php echo $this->Form->create(null, array('url' => array('action' => 'edit_highlight', $this->data['Editorial']['id'], 'edition' => $selectedEdition))); ?>
			<?php echo $this->Form->input('EditorialsHighlight.id', array('type' => 'hidden',  'label' => false,  'error' => false, )); ?>
			<?php echo $this->Form->input('EditorialsHighlight.editorial_id', array('type' => 'hidden',  'label' => false,  'error' => false, )); ?>
			<?php echo $this->Form->input('EditorialsHighlight.draft', array('type' => 'hidden',  'label' => false,  'error' => false, 'id' => 'draftButtonField', )); ?>
			<div id="fieldsWrapper">
				<fieldset>

					<div class="formRow">
						<div><label for="EditorialsHighlightContent">Describe highlighted events (appears in email only)</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsHighlight.content', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsHighlightContent', 
							)); ?>
						</div>
					</div>

					<div class="formRow">
						<div><label for="EditorialsHighlightAd">Advertisement - Newsletter ONLY - paste in HTML code below</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsHighlight.advertisement', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsHighlightAd', 
							)); ?>
						</div>
					</div>

				</fieldset>
			</div>

			<div class="actions SF_niceclear">
				<div class="actionsPrimary">
					<?php 
						if(!$readonly)
						{
					?>
					<button type="submit" class="draftButton" id="draftButton"><span><?php __('Save as draft', false); ?></span></button>
					<button type="submit" class="readyButton" id="readyButton"><span><?php __('Save as ready', false); ?></span></button>
					<?php
						}
					?>
				</div>
				<div class="actionsSecondary">
					<a class="admin" href="<?php echo Router::url(array('action' => 'index', 'edition' => $selectedEdition)); ?>"><?php __('Cancel', false); ?></a>
				</div>
			</div>
		<?php echo $this->Form->end(); ?>

	</section>
</div>
<?php echo $this->element('aside_editorial'); ?>
<?php 
	echo $tinyMce->init(array(
		'elements' => 'EditorialsHighlightContent',
	));