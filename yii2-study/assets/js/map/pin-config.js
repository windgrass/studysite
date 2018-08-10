var pin_config = {
	'default':{
		'pinShadow':'#000', //shadow color below the points
		'pinShadowOpacity':'50', //shadow opacity, value, 0-100
	},
	'points':[
	{
		'shape':'rectangle',//choose the shape of the pin circle or rectangle
		'hover': '<u><b>Washington DC, USA</b></u><br>This pin when clicked will open<br>the URL in a <span style="color:black; background-color:#a9f038;"><b>NEW</b></span> window.',//the content of the hover popup
		'pos_X':220,//location of the pin on X axis
		'pos_Y':153,//location of the pin on Y axis
		'width':8,//width of the rectangle
		'height':8,//height of the rectangle
		'outline':'#D2D2FF',//outline color of the pin
		'thickness':1,//thickness of the line (0 to hide the line)
		'upColor':'#0000FF',//color of the pin when map loads
		'overColor':'#3399ff',//color of the pin when mouse hover
		'downColor':'#00ffff',//color of the pin when clicked 
		//(trick, if you make this pin un-clickable > make the overColor and downColor the same)
		'url':'http://www.html5interactivemaps.com',//URL of this pin
		'target':'new_window',//'new_window' opens URL in new window//'same_window' opens URL in the same window //'none' pin is not clickable
		'enable':true,//true/false to enable/disable this pin
	},
	]
}
