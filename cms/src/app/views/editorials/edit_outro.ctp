<div id="contentWrapper" class="SF_left">
	<div id="contentHeader" class="SF_niceclear">
		<div id="contentHeaderMargin" class="SF_niceclear">
			<h1>Newsletter outro <span>(<a class="admin" href="<?php echo Router::url(array('action' => 'index', 'edition' => $selectedEdition)); ?>"><?php __('Cancel', false); ?></a>)</span></h1>
			<div id="sectionToolbar">
				<img src="<?php echo $this->webroot; ?>images/icon_mail.png" height="16" />
				<img src="<?php echo $this->webroot; ?>images/icon_web.png" height="16" />
				<?php 
					if(!$readonly)
					{
				?>
				<button type="submit" class="draftButton" id="draftButtonTop" form="EditorialEditOutroForm"><span><?php __('Save as draft', false); ?></span></button>
				<button type="submit" class="readyButton" id="readyButtonTop" form="EditorialEditOutroForm"><span><?php __('Save as ready', false); ?></span></button>
				<?php
					}
				?>
			</div>
		</div>
	</div>
	<section id="content" class="SF_niceclear">

		<?php if(isset($shamrockFeedback)) { echo $shamrockFeedback; } ?>

		<?php if(isset($shamrockErrors) && $shamrockErrors == true) { ?><div class="feedback feedbackError"><?php __('<b>Oops, something wasn&#39;t right.</b> Can you review the data you entered?', false); ?></div><?php } ?>

		<?php echo $this->Form->create(null, array('url' => array('action' => 'edit_outro', $this->data['Editorial']['id'], 'edition' => $selectedEdition))); ?>
			<?php echo $this->Form->input('EditorialsOutro.id', array('type' => 'hidden',  'label' => false,  'error' => false, )); ?>
			<?php echo $this->Form->input('EditorialsOutro.editorial_id', array('type' => 'hidden',  'label' => false,  'error' => false, )); ?>
			<?php echo $this->Form->input('EditorialsOutro.draft', array('type' => 'hidden',  'label' => false,  'error' => false, 'id' => 'draftButtonField', )); ?>
			<div id="fieldsWrapper">
				<fieldset>

					<div class="formRow">
						<div><label for="editorialNewsletterOutro">Content</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsOutro.outro', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'editorialNewsletterOutro', 
							)); ?>
						</div>
					</div>

					<div class="formRow">
						<div><label for="editorialNewsletterFooter">Signature &amp; footer</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsOutro.footer', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'editorialNewsletterFooter', 
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
		'elements' => 'editorialNewsletterOutro',
		'height' => Configure::read('Application.tinymce.heightshort'),
	));
	echo $tinyMce->init(array(
		'elements' => 'editorialNewsletterFooter',
		'height' => Configure::read('Application.tinymce.heightshort'),
	));