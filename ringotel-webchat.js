jQuery(document).ready(function() {

	if(!plugin_options || !plugin_options.wchat_page_id) {
		console.error('plugin_options is undefined');
		return;
	}

	console.log('plugin_options: ', plugin_options);

	var version = 'v1';
	var page_id = plugin_options.wchat_page_id;

	loadWidget();

	function loadWidget() {
	    window.WchatSettings = {
	    	pageid: page_id
	    };

	    (function(w,d,s,l,g,a,b,o){
    		w[a]=w[a]||{};
    		w[a].clientPath=w[a].clientPath||l;
    		if(w[g]) {w[g](w[a]||{})} 
    		else {
    			b=d.createElement(s), o=d.getElementsByTagName(s)[0];
    			b.async=1;
    			b.src=l+'wchat.min.js';
    			o.parentNode.insertBefore(b,o)
    		}
	    })(window,document,'script',('https://static.ringotel.co/wchat/'+version+'/'),'Wchat','WchatSettings');
	}

});