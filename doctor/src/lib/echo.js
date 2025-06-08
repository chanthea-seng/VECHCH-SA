// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';

// window.Pusher = Pusher;

// const echo = new Echo({
// 	broadcaster: 'reverb',
// 	key: import.meta.env.VITE_REVERB_APP_KEY,
// 	wsHost: import.meta.env.VITE_REVERB_HOST,
// 	wsPort: import.meta.env.VITE_REVERB_PORT,
// 	wssPort: import.meta.env.VITE_REVERB_PORT,
// 	scheme: import.meta.env.VITE_REVERB_SCHEME,
// 	enabledTransports: ['ws', 'wss'],
// 	disableStats: true,
// 	forceTLS: import.meta.env.VITE_REVERB_SCHEME === 'https',
// 	authEndpoint: `${import.meta.env.VITE_API_HOST}/broadcasting/auth`,
// 	// authorizer: (channel) => {
// 	// 	return {
// 	// 		authorize: (socketId, callback) => {
// 	// 			axios.post('/api/broadcasting/auth', {
// 	// 				socket_id: socketId,
// 	// 				channel_name: channel.name,
// 	// 			})
// 	// 				.then((response) => {
// 	// 					callback(false, response.data);
// 	// 				})
// 	// 				.catch((error) => {
// 	// 					callback(true, error);
// 	// 				});
// 	// 		},
// 	// 	};
// 	// },
// 	auth: {
// 		headers: {
// 			Authorization: `Bearer ${localStorage.getItem('token')}`,
// 		},

// 	},
// });

// echo.connector.pusher.connection.bind('error', (err) => {
// 	console.error('Pusher error:', err);
// });

// echo.connector.pusher.connection.bind('connected', () => {
// 	console.log('Connected to Reverb WebSocket');
// });

// echo.connector.pusher.connection.bind('disconnected', () => {
// 	console.log('Disconnected from Reverb WebSocket');
// });

// export default echo;