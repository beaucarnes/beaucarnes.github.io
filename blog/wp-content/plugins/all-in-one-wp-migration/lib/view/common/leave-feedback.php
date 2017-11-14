<div class="ai1wm-feedback">
	<ul class="ai1wm-feedback-types">
		<li>
			<input type="radio" class="ai1wm-flat-radio-button ai1wm-feedback-type" id="ai1wm-feedback-type-1" name="ai1wm_feedback_type" value="review" />
			<a id="ai1wm-feedback-type-link-1" href="https://wordpress.org/support/view/plugin-reviews/all-in-one-wp-migration?rate=5#postform" target="_blank">
				<i></i>
				<span><?php _e( 'I would like to review this plugin', AI1WM_PLUGIN_NAME ); ?></span>
			</a>
		</li>
		<li>
			<input type="radio" class="ai1wm-flat-radio-button ai1wm-feedback-type" id="ai1wm-feedback-type-2" name="ai1wm_feedback_type" value="suggestions" />
			<label for="ai1wm-feedback-type-2">
				<i></i>
				<span><?php _e( 'I have ideas to improve this plugin', AI1WM_PLUGIN_NAME ); ?></span>
			</label>
		</li>
		<li>
			<input type="radio" class="ai1wm-flat-radio-button ai1wm-feedback-type" id="ai1wm-feedback-type-3" name="ai1wm_feedback_type" value="help-needed" />
			<label for="ai1wm-feedback-type-3">
				<i></i>
				<span><?php _e( 'I need help with this plugin', AI1WM_PLUGIN_NAME ); ?></span>
			</label>
		</li>
	</ul>

	<div class="ai1wm-feedback-form">
		<div class="ai1wm-field">
			<input placeholder="<?php _e( 'Enter your email address..', AI1WM_PLUGIN_NAME ); ?>" type="text" id="ai1wm-feedback-email" class="ai1wm-feedback-email" />
		</div>
		<div class="ai1wm-field">
			<textarea rows="3" id="ai1wm-feedback-message" class="ai1wm-feedback-message" placeholder="<?php _e( 'Leave plugin developers any feedback here..', AI1WM_PLUGIN_NAME ); ?>"></textarea>
		</div>
		<div class="ai1wm-field ai1wm-feedback-terms-segment">
			<label for="ai1wm-feedback-terms">
				<input type="checkbox" class="ai1wm-feedback-terms" id="ai1wm-feedback-terms" />
				<?php _e( 'I agree that by clicking the send button below my email address and comments will be send to a ServMask server.', AI1WM_PLUGIN_NAME ); ?>
			</label>
		</div>
		<div class="ai1wm-field">
			<div class="ai1wm-buttons">
				<button type="submit" id="ai1wm-feedback-submit" class="ai1wm-button-blue">
					<i class="ai1wm-icon-paperplane"></i>
					<?php _e( 'Send', AI1WM_PLUGIN_NAME ); ?>
				</button>
				<a class="ai1wm-feedback-cancel" id="ai1wm-feedback-cancel" href="#"><?php _e( 'Cancel', AI1WM_PLUGIN_NAME ); ?></a>
			</div>
		</div>
	</div>
</div>
