/**
 * More hacky then I'd like, but my react-fu isn't up to speed.
 */
wp.data.subscribe(function () {
	if (wp.data.select("core/edit-post")?.isEditorPanelOpened("template")) {
		// The buttons get 10 tries to load, bail after that.
		disable_fse_disable_buttons(10);
	}
});

function disable_fse_disable_buttons(recursive_tries_left) {
	const el_buttons = document.querySelectorAll(
		".edit-post-template__actions button"
	);

	if (0 === recursive_tries_left) {
		return; // stop when the button's still aren't loaded.
	}
	recursive_tries_left--;

	if (0 === el_buttons.length) {
		// Buttons not found, give it 20 milliseconds.
		setTimeout(function () {
			disable_fse_disable_buttons(recursive_tries_left);
		}, 20);
		return;
	}
	// Disable the buttons.
	el_buttons.forEach(function (el_button) {
		el_button.disabled = true;
	});
}
