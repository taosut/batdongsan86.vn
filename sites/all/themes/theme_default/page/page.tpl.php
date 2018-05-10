<?php global $base_url ?>
<div id="wrapper">
	<?php if ($page['header']){ ?>
	<div id="header">
		<?php echo render($page['header']); ?>
	</div>
	<?php } ?>
	<div id="content">
		<div class="content-box">
			<?php if(!isset($messages)) $messages = ''; echo $messages; ?>
			<div class="wrapp">
				<?php if ($page['search_project']){ ?>
				<div class="search-project">
					<?php echo render($page['search_project']); ?>
				</div>
				<?php } ?>
				<?php if ($page['content']){ ?>
			    <div <?php if ($page['right']){ ?>id="site-content"<?php }else{ ?>id="site-full"<?php } ?>>
					<?php if ($page['content']){ ?>
						<?php unset($page['content']['system_main']['default_message']); ?>
			    		<?php echo render($page['content']); ?>
					<?php } ?>
				</div>
				<?php } ?>
			    <?php if ($page['right']){ ?>
			    <div id="site-right">
					<?php echo render($page['right']); ?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php if ($page['footer']){ ?>
	<div id="footer">
		<?php echo render($page['footer']); ?>
	</div>
	<?php } ?>	
</div>