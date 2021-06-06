/**
 * More hacky then I'd like, but my react-fu isn't up to speed.
 */
wp.data.subscribe(function () {
	// The buttons get 10 tries to load, bail after that.
	let recursive_protection = 10;

	if (wp.data.select('core/edit-post').isEditorPanelOpened('template')) {
		disable_fse_disable_buttons();
	}
});

function disable_fse_disable_buttons() {
	const el_buttons = document.querySelectorAll('.edit-post-template__actions button');

	if (0 === recursive_protection) {
		return; // stop when the button's still aren't loaded.
	}
	recursive_protection--;

	if (0 === el_buttons.length) {
		// Buttons not found, give it 20 miliseconds
		setTimeout(function () {
			disable_fse_disable_buttons();
		}, 20);
		return;
	}
	// Disable the buttons.
	el_buttons.forEach(function (el_button) {
		el_button.disabled = true;
	});

}
