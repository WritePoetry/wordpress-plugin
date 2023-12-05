const options = {
	name: {
		'Attention seekers': [
			'bounce',
			'flash',
			'pulse',
			'rubberBand',
			'shakeX',
			'shakeY',
			'headShake',
			'swing',
			'tada',
			'wobble',
			'jello',
			'heartBeat',
		],
		'Back entrances': [
			'backInDown',
			'backInLeft',
			'backInRight',
			'backInUp',
		],
		'Back exits': [
			'backOutDown',
			'backOutLeft',
			'backOutRight',
			'backOutUp',
		],
		'Bouncing entrances': [
			'bounceIn',
			'bounceInDown',
			'bounceInLeft',
			'bounceInRight',
			'bounceInUp',
		],
		'Bouncing exits': [
			'bounceOut',
			'bounceOutDown',
			'bounceOutLeft',
			'bounceOutRight',
			'bounceOutUp',
		],
		'Fading entrances': [
			'fadeIn',
			'fadeInDown',
			'fadeInDownBig',
			'fadeInLeft',
			'fadeInLeftBig',
			'fadeInRight',
			'fadeInRightBig',
			'fadeInUp',
			'fadeInUpBig',
			'fadeInTopLeft',
			'fadeInTopRight',
			'fadeInBottomLeft',
			'fadeInBottomRight',
		],
		'Fading exits': [
			'fadeOut',
			'fadeOutDown',
			'fadeOutDownBig',
			'fadeOutLeft',
			'fadeOutLeftBig',
			'fadeOutRight',
			'fadeOutRightBig',
			'fadeOutUp',
			'fadeOutUpBig',
			'fadeOutTopLeft',
			'fadeOutTopRight',
			'fadeOutBottomRight',
			'fadeOutBottomLeft',
		],
		Flippers: [ 'flip', 'flipInX', 'flipInY', 'flipOutX', 'flipOutY' ],
		Lightspeed: [
			'lightSpeedInRight',
			'lightSpeedInLeft',
			'lightSpeedOutRight',
			'lightSpeedOutLeft',
		],
		'Rotating entrances': [
			'rotateIn',
			'rotateInDownLeft',
			'rotateInDownRight',
			'rotateInUpLeft',
			'rotateInUpLeft',
		],
		'Rotating exits': [
			'rotateOut',
			'rotateOutDownLeft',
			'rotateOutDownRight',
			'rotateOutUpLeft',
			'rotateOutUpRight',
		],
		Specials: [ 'hinge', 'jackInTheBox', 'rollIn', 'rollOut' ],
		'Zooming entrances': [
			'zoomIn',
			'zoomInDown',
			'zoomInLeft',
			'zoomInRight',
			'zoomInUp',
		],
		'Zooming exits': [
			'zoomOut',
			'zoomOutDown',
			'zoomOutLeft',
			'zoomOutRight',
			'zoomOutUp',
		],
		'Sliding entrances': [
			'slideInDown',
			'slideInLeft',
			'slideInRight',
			'slideInUp',
		],
		'Sliding exits': [
			'slideOutDown',
			'slideOutLeft',
			'slideOutRight',
			'slideOutUp',
		],
	},
	speed: [
		{
			value: '',
			label: 'Select the speed of the animation:',
			disabled: true,
		},
		{ value: 'slow', label: 'slow' },
		{ value: 'slower', label: 'slower' },
		{ value: 'fast', label: 'fast' },
		{ value: 'faster', label: 'faster' },
	],
	delay: [
		{ value: '', label: 'Select a Delay', disabled: true },
		{ value: '2', label: '2s' },
		{ value: '3', label: '3s' },
		{ value: '4', label: '4s' },
		{ value: '5', label: '5s' },
	],
	repeat: [
		{
			value: '',
			label: 'Select the iteration count of the animation:',
			disabled: true,
		},
		{ value: 'repeat-1', label: '1' },
		{ value: 'repeat-2', label: '2' },
		{ value: 'repeat-3', label: '3' },
		{ value: 'infinite', label: 'infinite' },
	],
};

export default options;
