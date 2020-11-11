<?php
session_start();
include 'db.php';

if(!isset($_SESSION['login_id'])) 
{
  header( "Location: index.php" );
}

$holiday_id = $_SESSION['holiday_chosen'];


?>
<html>
<head>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBWWOUKy2QnOoL7UcXQTAEeZ7__NOXoX7k"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
<style>
	#test
	{
		width: 100%; height: 10%; border: 0px; padding: 0px; 
		position:relative;
		top:0;
		
		 
		 background: #50a3a2;
		 background: -webkit-linear-gradient(top left, #50a3a2 0%, #53e3a6 100%);
		 background: linear-gradient(to bottom right, #50a3a2 0%, #53e3a6 100%);
		 
		
	}
	
	#info { width:20%; height:90%;float:right;bottom: 0;position:relative;}
	#map-holder { width: 80%; height: 90%; border: 0px; padding: 0px; position:absolute;bottom:0;}
	#bodyUI
	{
		background: #50a3a2;
		background: -webkit-linear-gradient(top left, #50a3a2 0%, #53e3a6 100%);
		background: linear-gradient(to bottom right, #50a3a2 0%, #53e3a6 100%);
	}
</style>
<script type="text/javascript">

var map;
var directionsDisplay = null;
var directionsService;
var polylinePath;
var currentPopup;
var nodes = [];
var prevNodes = [];
var markers = [];
var durations = [];



// Initialize google maps
function initializeMap(date) {
    // Map options
    var opts = {
        center: new google.maps.LatLng(54, -4.4),
        zoom: 6,
        streetViewControl: false,
        mapTypeControl: false,
    };
    map = new google.maps.Map(document.getElementById('map-canvas'), opts);
    // Create map click event
    clearDirections();
       
var holiday_id = document.getElementById("holidayid").value; 
console.log(date);
console.log(holiday_id);
	$.post('getCoordinatesTsp.php',{id:holiday_id, date:date}, function(data){
		for (var i = 0; i < data.length; i++) 
		{
			//console.log(data[i]['latitude']);
			addMarker(parseFloat(data[i]['latitude']), parseFloat(data[i]['longitude']),'<b>'+data[i]['attraction_name']+'</b><br><b>Address: </b>'+data[i]['address']);
		}
	},"json");


	// Add "my location" button
    var myLocationDiv = document.createElement('div');
    new getMyLocation(myLocationDiv, map);
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(myLocationDiv);
    
    function getMyLocation(myLocationDiv, map) {
        var myLocationBtn = document.createElement('button');
        myLocationBtn.innerHTML = 'My Location';
        myLocationBtn.className = 'large-btn';
        myLocationBtn.style.margin = '5px';
        myLocationBtn.style.opacity = '0.95';
        myLocationBtn.style.borderRadius = '3px';
        myLocationDiv.appendChild(myLocationBtn);
    
        google.maps.event.addDomListener(myLocationBtn, 'click', function() {
            navigator.geolocation.getCurrentPosition(function(success) {
                map.setCenter(new google.maps.LatLng(success.coords.latitude, success.coords.longitude));
                map.setZoom(12);
            });
        });
    }
}

function addMarker(lat,lng,info)
{
	 // Add a node to map
		var pt = new google.maps.LatLng(lat, lng);
        var marker = new google.maps.Marker({position: pt, map: map});
        var popup = new google.maps.InfoWindow({
		 content: info,
		 maxWidth: 300
		 });
		  google.maps.event.addListener(marker, "click", function() {
		 if (currentPopup != null) {
		 currentPopup.close();
		 currentPopup = null;
		 }
		 popup.open(map, marker);
		 currentPopup = popup;
		 });
		markers.push(marker);
        
        // Store node's lat and lng
        nodes.push(pt);
        
        // Update destination count
        $('#destinations-count').html(nodes.length);
		console.log(nodes.length);
}


// Get all durations depending on travel type
function getDurations(callback) {
    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix({
        origins: nodes,
        destinations: nodes,
        travelMode: google.maps.TravelMode[$('#travel-type').val()],
		transitOptions: {
		modes: [google.maps.TransitMode.SUBWAY],
		routingPreference: google.maps.TransitRoutePreference.FEWER_TRANSFERS
		},	
        avoidHighways: parseInt($('#avoid-highways').val()) > 0 ? true : false,
        avoidTolls: false,
    }, function(distanceData) {
        // Create duration data array
        var nodeDistanceData;
        for (originNodeIndex in distanceData.rows) {
            nodeDistanceData = distanceData.rows[originNodeIndex].elements;
            durations[originNodeIndex] = [];
            for (destinationNodeIndex in nodeDistanceData) {
                if (durations[originNodeIndex][destinationNodeIndex] = nodeDistanceData[destinationNodeIndex].duration == undefined) {
                    alert('Error: couldn\'t get a trip duration from API');
                    return;
                }
                durations[originNodeIndex][destinationNodeIndex] = nodeDistanceData[destinationNodeIndex].duration.value;
            }
        }
        if (callback != undefined) {
            callback();
        }
    });
}
// Removes markers and temporary paths
function clearMapMarkers() {
    for (index in markers) {
        markers[index].setMap(null);
    }
    prevNodes = nodes;
    nodes = [];
    if (polylinePath != undefined) {
        polylinePath.setMap(null);
    }
    
    markers = [];
    
    $('#ga-buttons').show();
}
// Removes map directions
function clearDirections() {
    // If there are directions being shown, clear them
    if (directionsDisplay != null) {
        directionsDisplay.setMap(null);
        directionsDisplay = null;
    }
}
// Completely clears map
function clearMap() {
    clearMapMarkers();
    clearDirections();
    
    $('#destinations-count').html('0');
}
// Initial Google Maps
//google.maps.event.addDomListener(window, 'load', initializeMap());




// Create listeners
$(document).ready(function() {
    $('#clear-map').click(clearMap);
    // Start GA
    $('#find-route').click(function() {    
        if (nodes.length < 2) {
            if (prevNodes.length >= 2) {
                nodes = prevNodes;
            } else {
                alert('There must be 3 or more attractions available for the algorithm to commence');
                return;
            }
        }
        if (directionsDisplay != null) {
            directionsDisplay.setMap(null);
            directionsDisplay = null;
        }
        
        $('#ga-buttons').hide();
        // Get route durations
        getDurations(function(){
            $('.ga-info').show();
            // Get config and create initial GA population
            ga.getConfig();
            var pop = new ga.population();
            pop.initialize(nodes.length);
            var route = pop.getFittest().chromosome;
            ga.evolvePopulation(pop, function(update) {
                $('#generations-passed').html(update.generation);
                $('#best-time').html((update.population.getFittest().getDistance() / 60).toFixed(2) + ' Mins');
            
                // Get route coordinates
                var route = update.population.getFittest().chromosome;
                var routeCoordinates = [];
                for (index in route) {
                    routeCoordinates[index] = nodes[route[index]];
                }
                routeCoordinates[route.length] = nodes[route[0]];
                // Display temp. route
                if (polylinePath != undefined) {
                    polylinePath.setMap(null);
                }
                polylinePath = new google.maps.Polyline({
                    path: routeCoordinates,
                    strokeColor: "#0066ff",
                    strokeOpacity: 0.75,
                    strokeWeight: 2,
                });
                polylinePath.setMap(map);
            }, function(result) {
                // Get route
                route = result.population.getFittest().chromosome;
				console.log(route);
				
                // Add route to map
                directionsService = new google.maps.DirectionsService();
                directionsDisplay = new google.maps.DirectionsRenderer();
                directionsDisplay.setMap(map);
                var waypts = [];
                for (var i = 1; i < route.length; i++) {
                    waypts.push({
                        location: nodes[route[i]],
                        stopover: true
                    });
				}
				
                
                // Add final route to map
                var request = {
                    origin: nodes[route[0]],
                    destination: nodes[route[0]],
                    waypoints: waypts,
                    travelMode: google.maps.TravelMode[$('#travel-type').val()],
                    avoidHighways: parseInt($('#avoid-highways').val()) > 0 ? true : false,
                    avoidTolls: false
                };
				console.log(request);
				
                directionsService.route(request, function(response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        directionsDisplay.setDirections(response);
                    }
                    clearMapMarkers();
                });
            });
        });
    });
});




// GA code
var ga = {
    // Default config
    "crossoverRate": 0.5,
    "mutationRate": 0.1,
    "populationSize": 50,
    "tournamentSize": 5,
    "elitism": true,
    "maxGenerations": 100,
    
    "tickerSpeed": 60,
    // Loads config from HTML inputs
    "getConfig": function() {
        ga.crossoverRate = parseFloat($('#crossover-rate').val());
        ga.mutationRate = parseFloat($('#mutation-rate').val());
        ga.populationSize = parseInt($('#population-size').val()) || 50;
        ga.elitism = parseInt($('#elitism').val()) || false;
        ga.maxGenerations = parseInt($('#maxGenerations').val()) || 100;
    },
    
    // Evolves given population
    "evolvePopulation": function(population, generationCallBack, completeCallBack) {        
        // Start evolution
        var generation = 1;
        var evolveInterval = setInterval(function() {
            if (generationCallBack != undefined) {
                generationCallBack({
                    population: population,
                    generation: generation,
                });
            }
            // Evolve population
            population = population.crossover();
            population.mutate();
            generation++;
            
            // If max generations passed
            if (generation > ga.maxGenerations) {
                // Stop looping
                clearInterval(evolveInterval);
                
                if (completeCallBack != undefined) {
                    completeCallBack({
                        population: population,
                        generation: generation,
                    });
                }
            }
        }, ga.tickerSpeed);
    },
    // Population class
    "population": function() {
        // Holds individuals of population
        this.individuals = [];
    
        // Initial population of random individuals with given chromosome length
        this.initialize = function(chromosomeLength) {
            this.individuals = [];
    
            for (var i = 0; i < ga.populationSize; i++) {
                var newIndividual = new ga.individual(chromosomeLength);
                newIndividual.initialize();
                this.individuals.push(newIndividual);
            }
        };
        
        // Mutates current population
        this.mutate = function() {
            var fittestIndex = this.getFittestIndex();
            for (index in this.individuals) {
                // Don't mutate if this is the elite individual and elitism is enabled 
                if (ga.elitism != true || index != fittestIndex) {
                    this.individuals[index].mutate();
                }
            }
        };
        // Applies crossover to current population and returns population of offspring
        this.crossover = function() {
            // Create offspring population
            var newPopulation = new ga.population();
            
            // Find fittest individual
            var fittestIndex = this.getFittestIndex();
            for (index in this.individuals) {
                // Add unchanged into next generation if this is the elite individual and elitism is enabled
                if (ga.elitism == true && index == fittestIndex) {
                    // Replicate individual
                    var eliteIndividual = new ga.individual(this.individuals[index].chromosomeLength);
                    eliteIndividual.setChromosome(this.individuals[index].chromosome.slice());
                    newPopulation.addIndividual(eliteIndividual);
                } else {
                    // Select mate
                    var parent = this.tournamentSelection();
                    // Apply crossover
                    this.individuals[index].crossover(parent, newPopulation);
                }
            }
            
            return newPopulation;
        };
        // Adds an individual to current population
        this.addIndividual = function(individual) {
            this.individuals.push(individual);
        };
        // Selects an individual with tournament selection
        this.tournamentSelection = function() {
            // Randomly order population
            for (var i = 0; i < this.individuals.length; i++) {
                var randomIndex = Math.floor(Math.random() * this.individuals.length);
                var tempIndividual = this.individuals[randomIndex];
                this.individuals[randomIndex] = this.individuals[i];
                this.individuals[i] = tempIndividual;
            }
            // Create tournament population and add individuals
            var tournamentPopulation = new ga.population();
            for (var i = 0; i < ga.tournamentSize; i++) {
                tournamentPopulation.addIndividual(this.individuals[i]);
            }
            return tournamentPopulation.getFittest();
        };
        
        // Return the fittest individual's population index
        this.getFittestIndex = function() {
            var fittestIndex = 0;
            // Loop over population looking for fittest
            for (var i = 1; i < this.individuals.length; i++) {
                if (this.individuals[i].calcFitness() > this.individuals[fittestIndex].calcFitness()) {
                    fittestIndex = i;
                }
            }
            return fittestIndex;
        };
        // Return fittest individual
        this.getFittest = function() {
            return this.individuals[this.getFittestIndex()];
        };
    },
    // Individual class
    "individual": function(chromosomeLength) {
        this.chromosomeLength = chromosomeLength;
        this.fitness = null;
        this.chromosome = [];
        // Initialize random individual
        this.initialize = function() {
            this.chromosome = [];
            // Generate random chromosome
            for (var i = 0; i < this.chromosomeLength; i++) {
                this.chromosome.push(i);
            }
            for (var i = 0; i < this.chromosomeLength; i++) {
                var randomIndex = Math.floor(Math.random() * this.chromosomeLength);
                var tempNode = this.chromosome[randomIndex];
                this.chromosome[randomIndex] = this.chromosome[i];
                this.chromosome[i] = tempNode;
            }
        };
        
        // Set individual's chromosome
        this.setChromosome = function(chromosome) {
            this.chromosome = chromosome;
        };
        
        // Mutate individual
        this.mutate = function() {
            this.fitness = null;
            
            // Loop over chromosome making random changes
            for (index in this.chromosome) {
                if (ga.mutationRate > Math.random()) {
                    var randomIndex = Math.floor(Math.random() * this.chromosomeLength);
                    var tempNode = this.chromosome[randomIndex];
                    this.chromosome[randomIndex] = this.chromosome[index];
                    this.chromosome[index] = tempNode;
                }
            }
        };
        
        // Returns individuals route distance
        this.getDistance = function() {
            var totalDistance = 0;
            for (index in this.chromosome) {
                var startNode = this.chromosome[index];
                var endNode = this.chromosome[0];
                if ((parseInt(index) + 1) < this.chromosome.length) {
                    endNode = this.chromosome[(parseInt(index) + 1)];
                }
                totalDistance += durations[startNode][endNode];
            }
            
            totalDistance += durations[startNode][endNode];
            //console.log(totalDistance);
            return totalDistance;
			
        };
        // Calculates individuals fitness value
        this.calcFitness = function() {
            if (this.fitness != null) {
                return this.fitness;
            }
        
            var totalDistance = this.getDistance();
            this.fitness = 1 / totalDistance;
            return this.fitness;
        };
        // Applies crossover to current individual and mate, then adds it's offspring to given population
        this.crossover = function(individual, offspringPopulation) {
            var offspringChromosome = [];
            // Add a random amount of this individual's genetic information to offspring
            var startPos = Math.floor(this.chromosome.length * Math.random());
            var endPos = Math.floor(this.chromosome.length * Math.random());
            var i = startPos;
            while (i != endPos) {
                offspringChromosome[i] = individual.chromosome[i];
                i++
                if (i >= this.chromosome.length) {
                    i = 0;
                }
            }
            // Add any remaining genetic information from individual's mate
            for (parentIndex in individual.chromosome) {
                var node = individual.chromosome[parentIndex];
                var nodeFound = false;
                for (offspringIndex in offspringChromosome) {
                    if (offspringChromosome[offspringIndex] == node) {
                        nodeFound = true;
                        break;
                    }
                }
                if (nodeFound == false) {
                    for (var offspringIndex = 0; offspringIndex < individual.chromosome.length; offspringIndex++) {
                        if (offspringChromosome[offspringIndex] == undefined) {
                            offspringChromosome[offspringIndex] = node;
                            break;
                        }
                    }
                }
            }
            // Add chromosome to offspring and add offspring to population
            var offspring = new ga.individual(this.chromosomeLength);
            offspring.setChromosome(offspringChromosome);
            offspringPopulation.addIndividual(offspring);
        };
    },
};
</script>
<title>TSP Mode - Holiday Planner</title>
</head>
<body id="bodyUI" style="margin:0px; border:0px; padding:0px;" onload="myFunction()" >
<div id="test"><h1 style="color:blue;">TSP Mode</h1><h2><a href='home1.php'>Back</a></h2></div>
	<div id="map-holder">
		<div id="map-canvas" style="width:100%; height:100%;"></div>
	</div>
<div id='info'>
  <div id="table">
    <table>
        <tr>
            <td colspan="2"><b>Configuration</b></td>
        </tr>
        
		<tr>
            <td>Holiday Date: </td>
            <td>
			    <select id="date" onchange="myFunction(this.value)">
					<option></option>
					<?php
					$queryDates = mysql_query("SELECT * FROM holiday_name WHERE holiday_id='$holiday_id'");
					while ($rowDates = mysql_fetch_array($queryDates))
					{
						$from = $rowDates['from_date'];
						$to = $rowDates['to_date'];
						
						$dates = getDatesFromRange($from,$to);
						
						foreach($dates as $value)
						{
						 echo "<option value='" . $value . "'>" . $value . "</option>";
					
						}
					}?>
				</select>
            </td>
        </tr>
		
		
		
		
		
		<tr>
            <td>Travel Mode: </td>
            <td>
                <select id="travel-type">
                    <option value="DRIVING">Car</option>
                    <option value="BICYCLING">Bicycle</option>
                    <option value="WALKING">Walking</option>
					<!--<option value="TRANSIT">Transit</option>-->
                </select>
            </td>
        </tr>
        <tr>
            <td>Avoid Highways: </td>
            <td>
                <select id="avoid-highways">
                    <option value="1">Enabled</option>
                    <option value="0" selected="selected">Disabled</option>
                </select>
            </td>
        </tr>
        
            <td colspan="2"><b>Debug Info</b></td>
        </tr>
        <tr>
            <td>Attraction Count: </td>
            <td id="destinations-count">0</td>
        </tr>
        <tr class="ga-info" style="display:none;">
            <td>Generations: </td><td id="generations-passed">0</td>
        </tr>
        <tr class="ga-info" style="display:none;">
            <td>Best Time: </td><td id="best-time">?</td>
        </tr>
        <tr id="ga-buttons">
            <td colspan="2"><button id="find-route">Start</button> <button id="clear-map">Clear</button></td>
        </tr>
    </table>
  </div>
  
  <input type="hidden" id="chosen_date"></input>
  <input type="hidden" id="holidayid" value="<?php echo $holiday_id; ?>" />

</div>

<table>
<tr>
            <td>Population Size: </td>
            <td>
                <select id="population-size">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50" selected="selected">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Mutation Rate: </td>
            <td>
                <select id="mutation-rate">
                    <option value="0.00">0.00</option>
                    <option value="0.05">0.01</option>
                    <option value="0.05">0.05</option>
                    <option value="0.1" selected="selected">0.1</option>
                    <option value="0.2">0.2</option>
                    <option value="0.4">0.4</option>
                    <option value="0.7">0.7</option>
                    <option value="1">1.0</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Crossover Rate: </td>
            <td>
                <select id="crossover-rate">
                    <option value="0.0">0.0</option>
                    <option value="0.1">0.1</option>
                    <option value="0.2">0.2</option>
                    <option value="0.3">0.3</option>
                    <option value="0.4">0.4</option>
                    <option value="0.5" selected="selected">0.5</option>
                    <option value="0.6">0.6</option>
                    <option value="0.7">0.7</option>
                    <option value="0.8">0.8</option>
                    <option value="0.9">0.9</option>
                    <option value="1">1.0</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Elitism: </td>
            <td>
                <select id="elitism">
                    <option value="1" selected="selected">Enabled</option>
                    <option value="0">Disabled</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Max Generations: </td>
            <td>
                <select id="generations">
                    <option value="20">20</option>
                    <option value="50" selected="selected">50</option>
                    <option value="100">100</option>
                </select>
            </td>
        </tr>
        <tr>
</table>

</body>
</html>

<script>
function myFunction(val)
{
	clearMap();
    //alert("The input value has changed. The new value is: " + val);
	document.getElementById("chosen_date").value = val;
	console.log('My Function Value'+val);
	initializeMap(val);
}

/*function loadData()
{	
	var loadedvalue = $("#date").val();
	document.getElementById("holidayid").value = loadedvalue;
	initializeMap(loadedvalue);
}	*/
</script>


<?php
function getDatesFromRange($start, $end) {
    $interval = new DateInterval('P1D');

    $realEnd = new DateTime($end);
    $realEnd->add($interval);

    $period = new DatePeriod(
         new DateTime($start),
         $interval,
         $realEnd
    );

    foreach($period as $date) { 
        $array[] = $date->format('Y-m-d'); 
    }

    return $array;
}
?>