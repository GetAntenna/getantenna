<div id="contentWrapper" class="SF_left">
	<div id="contentHeader" class="SF_niceclear">
		<div id="contentHeaderMargin" class="SF_niceclear">
			<h1>Newsletter Introduction <span>(<a class="admin" href="<?php echo Router::url(array('action' => 'index', 'edition' => $selectedEdition)); ?>"><?php __('Cancel', false); ?></a>)</span></h1>
			<div id="sectionToolbar">
				<img src="<?php echo $this->webroot; ?>images/icon_mail.png" height="16" />
				<img src="<?php echo $this->webroot; ?>images/icon_web.png" height="16" />
				<?php 
					if(!$readonly)
					{
				?>
				<button type="submit" class="draftButton" id="draftButtonTop" form="EditorialEditNewsletterForm"><span><?php __('Save as draft', false); ?></span></button>
				<button type="submit" class="readyButton" id="readyButtonTop" form="EditorialEditNewsletterForm"><span><?php __('Save as ready', false); ?></span></button>
				<?php
					}
				?>
			</div>
		</div>
	</div>
	<section id="content" class="SF_niceclear">

		<?php if(isset($shamrockFeedback)) { echo $shamrockFeedback; } ?>

		<?php if(isset($shamrockErrors) && $shamrockErrors == true) { ?><div class="feedback feedbackError"><?php __('<b>Oops, something wasn&#39;t right.</b> Can you review the data you entered?', false); ?></div><?php } ?>

		<?php echo $this->Form->create(null, array('url' => array('action' => 'edit_newsletter', $this->data['Editorial']['id'], 'edition' => $selectedEdition))); ?>
			<?php echo $this->Form->input('EditorialsNewsletter.id', array('type' => 'hidden',  'label' => false,  'error' => false, )); ?>
			<?php echo $this->Form->input('EditorialsNewsletter.editorial_id', array('type' => 'hidden',  'label' => false,  'error' => false, )); ?>
			<?php echo $this->Form->input('EditorialsNewsletter.draft', array('type' => 'hidden',  'label' => false,  'error' => false, 'id' => 'draftButtonField', )); ?>
			<div id="fieldsWrapper">
				<fieldset>

					<div class="formRow">
						<div><label for="editorialNewsletterIntro">Newsletter introduction</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsNewsletter.intro', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'editorialNewsletterIntro', 
							)); ?>
						</div>
					</div>

					<div class="formRow">
						<div><label for="editorialNewsletterFB">Facebook like URL & description</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsNewsletter.facebook_like', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'editorialNewsletterFB', 
								'placeholder' => 'http://www.facebook.com/MyPageURL',
							)); ?>
						</div>
					</div>

					<div class="formRow">
						<div><?php 
							echo $this->Form->input('EditorialsNewsletter.facebook_description', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'editorialNewsletterFBDescription', 
							)); ?>
						</div>
					</div>

					<div class="formRow">
						<div><label for="editorialNewsletterAd">Advertisement - Newsletter ONLY - paste in HTML code below</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsNewsletter.advertisement', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'editorialNewsletterAd', 
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
		'elements' => 'editorialNewsletterIntro',
	));
	echo $tinyMce->init(array(
		'elements' => 'editorialNewsletterFBDescription', 
		'height' => Configure::read('Application.tinymce.heightshort'),
	));