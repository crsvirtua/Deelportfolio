
//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.


////the following functions count the number of selected 
//list items, min. 2, max 3 to go to the next page
//sets the count to 0 by default:
    globalVar = 0;
    var BRIN = new Array();
//sets the count to +1 when an item is checked:
//    sets the count to +1 when an item is checked:
    function upNumChecks(functionSchoolBRIN) {
       globalVar = globalVar +1;
       functionSchoolBRIN = functionSchoolBRIN.replace(/,/g,'');
       sendBRIN(functionSchoolBRIN);
    }
//    sets the count to -1 when an item is unchecked:
     function downNumChecks(functionSchoolBRIN) {
       globalVar = globalVar -1;
       functionSchoolBRIN = functionSchoolBRIN.replace(/,/g,'');
       sendBRIN(functionSchoolBRIN);
    }
    function sendBRIN(functionSchoolBRIN) {
        BRIN[globalVar] = functionSchoolBRIN;
        displayVergelijkKnop();
    }
//  shows the 'vergelijken' knop when 2 or 3 items are
//selected, if not it shows the grey button:

    function displayVergelijkKnop() {
        if(globalVar > '1' && globalVar < '4') {
            if(globalVar == '2') {
                document.getElementById("p1").innerHTML='<a href="http://schoolinzichtalmere.nl/selection/'+BRIN[1]+'&'+BRIN[2]+'"><img src="../../_include/imgFrontend/vergelijken.png" alt="" class="image" /></a>'; 
            }
            if(globalVar == '3') {
                document.getElementById("p1").innerHTML='<a href="http://schoolinzichtalmere.nl/selection/'+BRIN[1]+'&'+BRIN[2]+'&'+BRIN[3]+'"><img src="../../_include/imgFrontend/vergelijken.png" alt="" class="image" /></a>'; 
            }
        }
        else {
            document.getElementById("p1").innerHTML='<a><img src="../../_include/imgFrontend/vergelijkengrey.png" alt="" class="image" /></a>';
        }
    }
//sets the GLOBAL variables needed for the map:
    var map;
    var icon = "http://schoolinzichtalmere.nl/_include/imgFrontend/school_icon_map.png";
    var iconClicked = "http://schoolinzichtalmere.nl/_include/imgFrontend/school_icon_map_clicked.png";
    
//set the standard zoomLevel of the map, will later be changed if needed:
    var zoomLevel = 12;
    
//starts loading the map:
function initialize() {
//sets the options for the map:
        myOptions = {         
            center: new google.maps.LatLng(52.3699667, 5.224), 
            disableDefaultUI: true,
            zoom: zoomLevel,                
            panControl: false,
            zoomControl: true,
            mapTypeControl: true,
            scaleControl: false,
            streetViewControl: true,
            overviewMapControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP  
        };    

//sets what the variable 'map' is:
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    
//send a request to Google to geocode the postalcode:
    var geocoder = new google.maps.Geocoder(); 
    geocoder.geocode({
        'address': mapCenterPostcode
    }, 
//place a marker on the location of the postalcode (mapcenter marker):
    function(results, status) {
        if(status == google.maps.GeocoderStatus.OK) {
            marker3 = new google.maps.Marker({
                position: results[0].geometry.location,
                title: '',
                map: map,
                draggable: false,
                clickable: false,
                animation: false
            });
            
        } else {}   
    });

//set the variables needed for the interval:
//start with the number 0:
    numberCount = '0';
//set the maxLength to the number of results:
    maxLength = schoolName.length;
//set the interval (at which the function should be repeated, 0 for 0.0 seconds):
    setInterval(placeMarkers, 10)
//repeat the placeMarkers function at the given interval:
        function placeMarkers() {
//if you have reached the maxLength do nothing (this prevents the markers from being replaced over and over):
            if(numberCount == maxLength) {}
//if the maxLength has not been reached:
            else { 
//set the name of each marker to the desired schoolName, shift will start with the first result and end with the last:
                var functionSchoolName = schoolName.shift();
                var functionSchoolBRIN = schoolBRIN.shift();
                var functionSchoolAdres = schoolAdres.shift();
                var functionShoolLeerlingen = schoolLeerlingen.shift();
//make a new item out of every marker that has to be placed:
                var marker = new Array;
                marker[1] = new google.maps.Marker({
                    position: new google.maps.LatLng(schoolLat.shift(), schoolLong.shift()),
                    title: functionSchoolName,
                    map: map,
                    draggable: false,
                    clickable: true,
                    animation: google.maps.Animation.DROP,
                    icon: icon
                });
//make a new item out of every contentString (text displayed in the infowindows):
                var contentString = new Array();
                contentString[1] = 
                    '<b>'+functionSchoolName+'</b>'+
                    '<p>'+functionSchoolAdres+'</p>'+
                    '<p> Aantal leerlingen:   <b>'+functionShoolLeerlingen+'</b></p>'+
                    '<p class="extraInfoWindow">U heeft deze school geselecteerd,'+
                    ' klik nogmaals op het icoontje om deze '+
                    'school te deselecteren</p>';
//make a new item out of every infowindow that has to be displayed, these are 
//called upon later:
                var infowindow = new Array();
                infowindow[1] = new google.maps.InfoWindow({
                    content: contentString[1],
                    maxWidth: 300
                });
//add the ONCLICK event for each individual marker:
                google.maps.event.addListener(marker[1], "click", function() {  
//if the marker has already been selected and gets selected again:
                    if (marker[1].getAnimation() != null) {
//set the normal marker icon again (blue):
                        marker[1].setIcon(icon);
//stop any animations that have been set to the marker:
                        marker[1].setAnimation(null);
//close all open infowindows???:
                        infowindow[1].close();
//remove '1' from the number of selected items (needed for the blue 'vergelijken' button):
                        downNumChecks(functionSchoolBRIN);
                    }
//if the marker has not been selected yet:
                    else {
//replace the normal (blue) icon with the new (green) icon:
                        marker[1].setIcon(iconClicked);
//make the green marker BOUNCE:
                        marker[1].setAnimation(google.maps.Animation.BOUNCE);
//close all open infowindows???:
                        infowindow[1].close();
//open the infowindow attached to the clicked marker:
                        infowindow[1].open(map, marker[1]);
//add '1' to the number of selected items (needed for the blue 'vergelijken' button):
                        upNumChecks(functionSchoolBRIN);
                    }
                });
//add '1' to the number of times this function has been repeated,
//needed for the max. time the function may be repeated:
                numberCount++;
            }
        }
}