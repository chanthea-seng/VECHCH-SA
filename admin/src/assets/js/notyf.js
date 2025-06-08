import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';

const notyf = new Notyf({
	duration: 3000, // Notification duration
	position: { x: 'right', y: 'top' }, // Position on the screen
	dismissible: true,
});

export default {
	install: (app) => {
		app.config.globalProperties.$notyf = notyf;
	},
};
