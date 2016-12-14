/**
 * HTML5 Canvas Clock
 * -----------------------------------------------------------------------------
 * Author: Jocelyn Stretton (@jsfwd)
 * Date: August 2012
 */

(function() {
	
	/**
	 * Global Settings
	 */
	var canvas = null,
		context = null,
		settings = {
			font: {
				family: '"Duru Sans", Helvetica, sans-serif',
				style: 'default' // default or shadow
			},
			timeFormat: '12hr'
		};
	
	// resize the canvas to fill browser window dynamically
	window.addEventListener('resize', resizeCanvas, false);
	
	// initialize...
	window.onload = function() {
		init();
	};
	
	/**
	 * Initialize Clock
	 */
	function init() {
		// Grab the canvas
		canvas = document.getElementById('clock');
		
	    // Check for canvas compatibility
		if (canvas.getContext('2d')) {
			// initialize 2d drawing context
			context = canvas.getContext('2d');
			
			// draw the clock
			resizeCanvas();
			
			// update the clock every 1 second
			setInterval(displayClock, 1000);
			
			// toggle between timeformats
			canvas.onclick = function() {
				if (settings.timeFormat == '12hr') {
					settings.timeFormat = '24hr';
				} else {
					settings.timeFormat = '12hr';
				}
				displayClock();
				return false;
			}
		} else {
			alert('Canvas not supported!');
		}
	}
	
	function resizeCanvas() {
		canvas.width = window.innerWidth * 0.8;
	    canvas.height = window.innerHeight * 0.8;
		
	    // elements need to be redrawn after resize
	    displayClock();
	}
	
	
	// add a leading zero to numbers less then 10
	function zeroPad(num) {
		return (num < 10 ? '0' : '') + num;
	}
	
	/**
	 * Set the clock time & date
	 */
	function displayClock() {
		// grab the current time
		var dateTime = new Date();
		//console.log(dateTime);
		
		// add text lookups for month and days
		var months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diviembre'];
		var days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
		
		// parse the separate elements out of the date/time
		var year = dateTime.getFullYear();
		var month = months[dateTime.getMonth()].toUpperCase();
		var day = dateTime.getDate();
		var dayOfWeek = days[dateTime.getDay()].toUpperCase();
		var hours = zeroPad(dateTime.getHours());
		if (dateTime.getHours() >= 13 && settings.timeFormat == '12hr') {
			hours = hours - 12;
		}
		var minutes = zeroPad(dateTime.getMinutes());
		var seconds = zeroPad(dateTime.getSeconds());
		var ampm = (dateTime.getHours() >= 12) ? 'PM' : 'AM';
		
		// set the time format (12 or 24 hour)
		var textTime;
		if (settings.timeFormat == '24hr') {
			textTime = hours + ':' + minutes + ':' + seconds;
		} else {
			textTime = hours + ':' + minutes + ':' + seconds + ' ' + ampm;
		}
		
		// clear canvas
		context.clearRect(0, 0, canvas.width, canvas.height);
		
		// render text to canvas
		// https://developer.mozilla.org/en-US/docs/Drawing_text_using_a_canvas
		context.font = 'bold 4em ' + settings.font.family;
		context.textBaseline = 'top';
		
		// set the font style according to the settings
		if (settings.font.style == 'shadow') {
			context.fillStyle = '#f6f5f1';
		    context.shadowColor = '#999';
		    context.shadowOffsetX = 0;
		    context.shadowOffsetY = 0;
		    context.shadowBlur = 5;
		} else {
			context.fillStyle = '#fff';
		}
		
		// render the time text
	    var x = (canvas.width - context.measureText(textTime).width) / 2;
	    var y = 0;
	    context.fillText(textTime, x, y);
	    
	    // render the date text
	    context.font = '3em' + settings.font.family;
	    var textDate = dayOfWeek + ' ' + month + ' ' + day + ', ' + year;
	    x = (canvas.width - context.measureText(textDate).width) / 2;
	    y = 65;
	    context.fillText(textDate, x, y);
	}

})();

