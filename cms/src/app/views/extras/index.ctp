<div id="contentWrapper" class="SF_left">
	<div id="contentHeader" class="SF_niceclear">
		<div id="contentHeaderMargin" class="SF_niceclear">
			<h1>About &amp; Statistics</h1>
		</div>
	</div>
	<section id="content" class="SF_niceclear">

		<?php if(isset($shamrockFeedback)) { echo $shamrockFeedback; } ?>

		<?php echo $this->Form->create(null, array('url' => array('action' => 'index'), 'enctype' => 'multipart/form-data')); ?>
			<?php echo $this->Form->input('bannern', array('type' => 'hidden',  'label' => false,  'error' => false, 'id' => 'bannerName', )); ?>
			

			<div id="fieldsWrapper">
				<h3>Sponsorship</h3>
				<fieldset>
					<p class="formExplanation">The sponsor banner should be a 580 pixels wide x 180 pixels tall.</p>
					<div class="formRow">
						<div><?php 
							echo $this->Form->input('banner', array(
								'type' => 'file', 
								'label'=>false, 
								'error' => false,
								'id'=>'extraBanner', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="extraSponsor"><?php __('Sponsor content', false); ?>:</label></div>
						<div><?php 
							echo $this->Form->input('sponsor', array(
								'type' => 'textarea', 
								'label'=>false, 
								'error' => false,
								'id'=>'extraSponsor', 
							)); ?>
						</div>
					</div>
					
					<?php 
						if($this->data['Extra']['bannern'] != '')
						{
					?>
					<p class="formExplanation spacedTop" id="linkImageShow"><a href="#">Show current banner</a> | <a href="#" class="linkImageRemove">Remove banner</a></p>
					<div class="formRow SF_hidden" id="bannerCurrent">
						<p><img src="<?php echo Router::url(array('controller' => 'api', 'action' => 'show_banner')); ?>" class="eventImage"></p>
						<p class="formExplanation spacedTop" id="linkImageHide"><a href="#">Hide current banner</a> | <a href="#" class="linkImageRemove">Remove banner</a></p>
					</div>
					<script type="text/javascript">
						jQuery(document).ready(function()
							{
								jQuery('#linkImageShow').bind('click.clover', function()
									{
										jQuery('#bannerCurrent').slideDown();
										jQuery('#linkImageShow').hide();
										return false;
									});
								jQuery('#linkImageHide').bind('click.clover', function()
									{
										jQuery('#bannerCurrent').slideUp('400', function()
											{
												jQuery('#linkImageShow').show();
											});
										return false;
									});
								jQuery('.linkImageRemove').bind('click.clover', function()
									{
										jQuery('#linkImageShow').hide();
										jQuery('#bannerCurrent').hide();
										jQuery('#linkImageHide').hide();
										jQuery('#bannerName').val('');
										return false;
									});
							});
					</script>
					<?php
						}
					?>
				</fieldset>
			</div>

			<div id="fieldsWrapper">
				<h3>About content</h3>
				<fieldset>
					<div class="formRow">
						<div><label for="extraIntro"><?php __('About intro', false); ?>:</label></div>
						<div><?php 
							echo $this->Form->input('intro', array(
								'type' => 'textarea', 
								'label'=>false, 
								'error' => false,
								'id'=>'extraIntro', 
							)); ?>
						</div>
					</div>
				 </fieldset>
			 </div>                  
			
			 <div id="fieldsWrapper">      
					<h3>Statistics</h3> 
					<fieldset>
						<div class="formRow formRowInline">
							<div><label for="extraMobileStats"><?php __('Mobile subscribers', false); ?>:</label></div>
							<div><?php 
								echo $this->Form->input('mobile', array(
									'type' => 'text', 
									'label' => false, 
									'error' => false,
									'id'=>'extraMobileStats', 
								)); ?>
							</div>
						</div>
						<div class="formRow formRowInline">
							<div><label for="extraFacebookStats"><?php __('Facebook subscribers', false); ?>:</label></div>
							<div><?php 
								echo $this->Form->input('facebook', array(
									'type' => 'text', 
									'label' => false, 
									'error' => false,
									'id'=>'extraFacebookStats', 
								)); ?>
							</div>
						</div>
						<div class="formRow formRowInline">
							<div><label for="extraNewsletterStats"><?php __('Newsletter subscribers', false); ?>:</label></div>
							<div><?php 
								echo $this->Form->input('newsletter', array(
									'type' => 'text', 
									'label' => false, 
									'error' => false,
									'id'=>'extraNewsletterStats', 
								)); ?>
							</div>
						</div> 
						<div class="formRow">
							<div><label for="extraOutro"><?php __('About outro', false); ?>:</label></div>
							<div><?php 
								echo $this->Form->input('outro', array(
									'type' => 'textarea', 
									'label'=>false, 
									'error' => false,
									'id'=>'extraOutro', 
								)); ?>
							</div>
						</div> 
				</fieldset>
			</div>

			<div class="separator"></div>

			<div class="actions SF_niceclear">
				<div class="actionsPrimary">
					<button type="submit" class="readyButton"><span><?php __('Save your changes', false); ?></span></button>
				</div>
			</div>
		<?php echo $this->Form->end(); ?>

	</section>
</div>
<?php 
	echo $tinyMce->init(array(
		'elements' => 'extraSponsor',
		'height' => Configure::read('Application.tinymce.heightshort'),
	));
	echo $tinyMce->init(array(
		'elements' => 'extraIntro',
		'height' => Configure::read('Application.tinymce.heightshort'),
	));
	echo $tinyMce->init(array(
		'elements' => 'extraOutro',
		'height' => Configure::read('Application.tinymce.heightshort'),
	));