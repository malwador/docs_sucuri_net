<?php
    $heroic_actions = $this->recommended_actions;
    $heroic_actions_todo = get_option('heroic_recommended_actions', false);
?>
<div id="recommended_actions" class="heroic-tab-pane panel-close">
	<div class="action-list">
		<?php if ($heroic_actions): foreach ($heroic_actions as $key => $heroic_actionVal): ?>
		<div class="action" id="<?php echo esc_attr($heroic_actionVal['id']); ?>">
			<div class="action-watch">
			<?php if (!$heroic_actionVal['is_done']): ?>
				<?php if (!isset($heroic_actions_todo[$heroic_actionVal['id']]) || !$heroic_actions_todo[$heroic_actionVal['id']]): ?>
					<span class="dashicons dashicons-visibility"></span>
				<?php else: ?>
					<span class="dashicons dashicons-hidden"></span>
				<?php endif; ?>
			<?php else: ?>
				<span class="dashicons dashicons-yes"></span>
			<?php endif; ?>
			</div>
			<div class="action-inner">
				<h3 class="action-title"><?php echo esc_html($heroic_actionVal['title']); ?></h3>
				<div class="action-desc"><?php echo esc_html($heroic_actionVal['desc']); ?></div>
				<?php echo wp_kses_post($heroic_actionVal['link']); ?>
			</div>
		</div>
		<?php endforeach; endif; ?>
	</div>
</div>