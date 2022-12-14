<!doctype html>
<html lang = "en">
  <head>
		<meta http-equiv="content-type" content="text/html" charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    

    
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">  
    
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/knockout@3.3.0/build/output/knockout-latest.debug.min.js"></script>

		<style>	
			/*Make slider thumb black in all browsers*/
			input[type=range]::-webkit-slider-thumb {background: #000000;}
			input[type=range]::-moz-range-thumb {background: #000000;}
			input[type=range]::-ms-thumb {background: #000000;}
	
		</style>
  </head>
  
  
  <body>
  
	<nav class="navbar navbar-l bg-white">			
			<span class="navbar-text">
				<h4 class="text-black"><bdi data-bind="text:Name"></bdi> Thermostat</h4>
			</span>
		
		 <div class="custom-control custom-switch">
			<input type="checkbox" data-bind="checked: ControlUI, click: save" class="custom-control-input" checkedValue="1" id="switch1" name="example">
			<label class="custom-control-label" for="switch1">Control</label>
		</div>
	</nav>
		
	<div data-bind="visible: refresh()"> </div>	
	
	<div class="container-fluid">
		<div class="row">
			<div class="col m-2 bg-primary text-white">
				<h5 class="text-left" > Temperature </h5>
				<h4 class="text-right"><bdi data-bind="text: Math.round(Temp()*10)/10"></bdi></h4>
			</div>
  
			<div class="col m-2 bg-primary text-white">
				<h5 class="text-left">Humidity</h5>
				<h4 class="text-right"><bdi data-bind="text: Math.round(RelH())"></bdi> % </h4>
			</div>
		</div>
	
		<div class="row" data-bind="visible: ControlUI">
			<div class="col  m-2 bg-primary text-white">
				<h4> Set point </h4>				
				<span style="display:inline-block">40</span> 
				<span style="float: right;">100</span>
				
				<input type="range" class="custom-range" data-bind=" value: Tset, valueUpdate: 'input'" min="40" max="100" >
				
				 
				<span style="float: right;">
					<h4 class="text-right"><bdi data-bind="text: Math.round(Tset()*10)/10"></bdi>
					<i class="fas fa-burn" data-bind="visible: Heater()&gt;0 ? 1 : 0 " ></i> </h4>
				</span>									
			</div>
		</div>
			
		<button type="button" class="btn btn-primary btn-sm" data-bind="click: refresh">   <i class="fas fa-redo-alt"></i> </button> 
	
	</div>  
	  
    <footer class="container-fluid">
		<h6 class="text-right text-muted small">Start Time: <bdi data-bind="text: StartDate().toUTCString()"></bdi></h6>
		<h6 class="text-right text-muted small">Current Time: <bdi data-bind="text: CurrentDate().toUTCString()"></bdi></h6>
		<h6 class="text-right text-muted small">WiFi dbm= <bdi data-bind="text: Wifi_ssi"></bdi></h6>
    </footer>
	
    <script>
     

	 
    function status(response) {
		if (response.status >= 200 && response.status < 300) {
		return Promise.resolve(response)
		} else {
		return Promise.reject(new Error(response.statusText))
		}
	};

   
    // This is a simple *viewmodel*
	function AppViewModel() {
    //data
	var self = this;
  	self.Name = ko.observable("");
    self.Temp = ko.observable("");
    self.RelH = ko.observable("");
    self.Tset = ko.observable("");
  	self.Heater = ko.observable("");   
    self.CurrentTime = ko.observable("");
    self.StartTime = ko.observable("");
	self.ControlUI = ko.observable("");
	self.Wifi_ssi = ko.observable("");
	
	self.TsetDelayed = ko.pureComputed(self.Tset)
        .extend({ rateLimit: { method: "notifyWhenChangesStop", timeout: 400 } });
	
	self.RefreshDelayed =ko.pureComputed(self.TsetDelayed).extend({ rateLimit: { method: "notifyWhenChangesStop", timeout: 400 } });
		
	self.Control = ko.computed({
	read: function(){return this.ControlUI() ? 1 : 0},
	write: function(value){
	var r=(value>0);
	this.ControlUI(r);
	
	},
	owner: this
	});
	
	
	
		
	self.StartDate = ko.computed(function() {
		var event = new Date(self.StartTime()*1000);   
		return event;
    });
  
	self.CurrentDate = ko.computed(function() {
		var event = new Date(self.CurrentTime()*1000);   
		return event;
    });
 
  
  
	self.refresh =function(){
		fetch("http://192.168.0.222/ajax_inputs").then (status)
		.then(function(response) {
		return response.json();
		}).then(function(myJson) {
		console.log('Get request succeeded with resp ',myJson);
		self.Name(myJson.Name); 
		self.Temp(myJson.Temp);
		self.RelH(myJson.RelH);
		self.Tset(myJson.Tset);
		self.Heater(myJson.Heater);
		self.Control(myJson.Control);
		self.CurrentTime(myJson.CurrentTime);
		self.StartTime(myJson.StartTime);
		self.Wifi_ssi(myJson.Wifi_ssi);
		}).catch(function(error){
		console.log('Request Failed',error);
		})
	};

	self.save = function(){
		var plainJs = ko.toJS(self); 
		console.log('Testing, Testing',plainJs.Tset);  
		fetch('http://192.168.0.222', {
		method: 'POST',
		headers: {
		'Accept': 'application/json',
		'Access-Control-Allow-Origin': '*',
		'Content-Type': 'application/json'
		},
		credentials: 'same-origin',
		body: JSON.stringify({"Tset":plainJs.TsetDelayed, "Control":plainJs.Control})
		}).then (status).catch(function(error){
		console.log('Request Failed',error);  
		});
	return true};  
  
    
	
  
	self.TsetDelayed.subscribe(function(newValue) {self.save()});
	self.RefreshDelayed.subscribe(function(newValue) {self.refresh()});
  
};
    
// Activates knockout.js
ko.applyBindings(new AppViewModel());    
   
</script>
</body>
</html>