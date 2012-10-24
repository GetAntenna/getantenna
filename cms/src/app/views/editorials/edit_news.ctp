<div id="contentWrapper" class="SF_left">
	<div id="contentHeader" class="SF_niceclear">
		<div id="contentHeaderMargin" class="SF_niceclear">
			<h1>News <span>(<a class="admin" href="<?php echo Router::url(array('action' => 'index', 'edition' => $selectedEdition)); ?>"><?php __('Cancel', false); ?></a>)</span></h1>
			<div id="sectionToolbar">
				<img src="<?php echo $this->webroot; ?>images/icon_mobile.png" height="16" />
				<img src="<?php echo $this->webroot; ?>images/icon_mail.png" height="16" />
				<img src="<?php echo $this->webroot; ?>images/icon_web.png" height="16" />
				<?php 
					if(!$readonly)
					{
				?>
				<button type="submit" class="draftButton" id="draftButtonTop" form="EditorialEditNewsForm"><span><?php __('Save as draft', false); ?></span></button>
				<button type="submit" class="readyButton" id="readyButtonTop" form="EditorialEditNewsForm"><span><?php __('Save as ready', false); ?></span></button>
				<?php
					}
				?>
			</div>
		</div>
	</div>
	<section id="content" class="SF_niceclear">

		<?php if(isset($shamrockFeedback)) { echo $shamrockFeedback; } ?>

		<?php if(isset($shamrockErrors) && $shamrockErrors == true) { ?><div class="feedback feedbackError"><?php __('<b>Oops, something wasn&#39;t right.</b> Can you review the data you entered?', false); ?></div><?php } ?>

		<?php echo $this->Form->create(null, array('url' => array('action' => 'edit_news', $this->data['Editorial']['id'], 'edition' => $selectedEdition))); ?>
			<?php echo $this->Form->input('EditorialsNews.id', array('type' => 'hidden',  'label' => false,  'error' => false, )); ?>
			<?php echo $this->Form->input('EditorialsNews.editorial_id', array('type' => 'hidden',  'label' => false,  'error' => false, )); ?>
			<?php echo $this->Form->input('EditorialsNews.draft', array('type' => 'hidden',  'label' => false,  'error' => false, 'id' => 'draftButtonField', )); ?>
			<div id="fieldsWrapper">

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsNewsTitle_1">News 1 - Title</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsNews.title1', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsNewsTitle_1', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsNewsDescription_1">News 1 - Description</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsNews.description1', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsNewsDescription_1', 
							)); ?>
						</div>
					</div>
				</fieldset>

				<hr />

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsNewsTitle_2">News 2 - Title</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsNews.title2', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsNewsTitle_2', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsNewsDescription_2">News 2 - Description</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsNews.description2', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsNewsDescription_2', 
							)); ?>
						</div>
					</div>
				</fieldset>

				<hr />

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsNewsTitle_3">News 3 - Title</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsNews.title3', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsNewsTitle_3', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsNewsDescription_3">News 3 - Description</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsNews.description3', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsNewsDescription_3', 
							)); ?>
						</div>
					</div>
				</fieldset>

				<hr />

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsNewsTitle_4">News 4 - Title</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsNews.title4', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsNewsTitle_4', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsNewsDescription_4">News 4 - Description</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsNews.description4', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsNewsDescription_4', 
							)); ?>
						</div>
					</div>
				</fieldset>

				<hr />

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsNewsTitle_5">News 5 - Title</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsNews.title5', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsNewsTitle_5', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsNewsDescription_5">News 5 - Description</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsNews.description5', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsNewsDescription_5', 
							)); ?>
						</div>
					</div>
				</fieldset>

				<hr />

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsNewsTitle_6">News 6 - Title</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsNews.title6', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsNewsTitle_6', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsNewsDescription_6">News 6 - Description</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsNews.description6', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsNewsDescription_6', 
							)); ?>
						</div>
					</div>
				</fieldset>

				<hr />

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsNewsAd">Advertisement - Newsletter ONLY - paste in HTML code below</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsNews.advertisement', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsNewsAd', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsNewsOpportunities">Opportunities - Newsletter ONLY</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsNews.opportunities', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsNewsOpportunities', 
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
		'elements' => 'EditorialsNewsDescription_1',
		'height' => Configure::read('Application.tinymce.heightshort'),
	));
	echo $tinyMce->init(array(
		'elements' => 'EditorialsNewsDescription_2',
		'height' => Configure::read('Application.tinymce.heightshort'),
	));
	echo $tinyMce->init(array(
		'elements' => 'EditorialsNewsDescription_3',
		'height' => Configure::read('Application.tinymce.heightshort'),
	));
	echo $tinyMce->init(array(
		'elements' => 'EditorialsNewsDescription_4',
		'height' => Configure::read('Application.tinymce.heightshort'),
	));
	echo $tinyMce->init(array(
		'elements' => 'EditorialsNewsDescription_5',
		'height' => Configure::read('Application.tinymce.heightshort'),
	));
	echo $tinyMce->init(array(
		'elements' => 'EditorialsNewsDescription_6',
		'height' => Configure::read('Application.tinymce.heightshort'),
	));
	echo $tinyMce->init(array(
		'elements' => 'EditorialsNewsOpportunities',
		'height' => Configure::read('Application.tinymce.heightshort'),
	));