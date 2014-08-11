
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script type="text/javascript" src="/thirdPartySoftware/js/highcharts.js"></script>
<script language="javascript" src="http://www.google.com/jsapi"></script>
<script> 
        
 //Creates the 1st tab Chart for Profiles

 function createChartProfile1(){
   
        
        var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'profileschoolgraph1big',
						 backgroundColor: '#D9F0F6'
                                                      
					},
					title: {
                                                          
						text:null ,
                                                       floating: true,
                                                       x:-310,
                                                       y:5
					},subtitle: {
						text: 'Jaar: '+ areaYear + '<br/>' + 'Totaal LL: '+total, 
                                                       floating: true,
                                                       x: 200,
                                                        y: 0
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +' %';
						}
					},
                                             credits: {
						enabled: false
					},
				         plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								color: '#000000',
								connectorColor: '#000000',
								formatter: function() {
									return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +' %';
								}
							}
						}
					},
				        series: [{
						type: 'pie',
						name: 'student',
						data: [
                                                                [transitionKeys[0],   graphValues[0]],
							[transitionKeys[1],    graphValues[1]],
							[transitionKeys[2],    graphValues[2]],
							[transitionKeys[3],   graphValues[3]],
							[transitionKeys[4],    graphValues[4]],
							{name: transitionKeys[5],    
								y: graphValues[5],
								sliced: true,
								selected: true
								
							}
						]
					}]
				});
			});
				
                    
               }
 function createChartProfile2(){
		
			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'profileschoolgraph1big',
						defaultSeriesType: 'line',
                                                 backgroundColor: '#D9F0F6'
					},
					title: {
						text: 'Groei & Prognose'
					},

					xAxis: {
						categories: [growthTotalYear10, growthTotalYear11, growthTotalYear12, growthTotalYear13, growthTotalYear14, growthProgTotalYear10, growthProgTotalYear11, growthProgTotalYear12, growthProgTotalYear13, growthProgTotalYear14]
					},
					yAxis: {
						title: {
							text: 'Leerlingen'
						}
					}, credits: {
						enabled: false
					},
					tooltip: {
						enabled: false,
						formatter: function() {
							return '<b>'+ this.series.name +'</b><br/>'+
								this.x +': '+ this.y +'Leerlingen';
						}
					},
					plotOptions: {
						line: {
							dataLabels: {
								enabled: true
							},
							enableMouseTracking: false
						}
					},
					series: [{
						name: 'Groei',
						data: [growthTotal10, growthTotal11, growthTotal12, growthTotal13, growthTotal14, null, null, null, null, null]
					}, {
						name: 'Prognose',
						data: [null, null, null, null, null, growthProgTotal10, growthProgTotal11, growthProgTotal12, growthProgTotal13, growthProgTotal14]
					}]
				});
				
				
			});
					
               }
 function createChartProfile3(){
             var chart3;
			$(document).ready(function() {
				chart3 = new Highcharts.Chart({
					chart: {
						renderTo: 'profileschoolgraph1big',
						defaultSeriesType: 'column',
                                                  backgroundColor: '#D9F0F6'
					},
					title: {
						text: "DLE/DL Rendement "+ DLEYear
					},
					subtitle: {
						text: ''
					},
                                         credits: {
						enabled: false
					},
					xAxis: {
                                            
						categories: [
							'Groep 3'+"<br />", 
							'Groep 4'+"<br />", 
							'Groep 5'+"<br />", 
							'Groep 6'+"<br />", 
							'Groep 7'+"<br />", 
							'Groep 8'+"<br />"							
						]
					},
					yAxis: {
						min: 40,
                                                        max: 140,
                                                        tickInterval: 20,
						title: {
							text: 'Gem. (DLE/DL)*100'
                                                                 
						}
					},
					legend: {
						enabled: true,
                                                          x: 30,
                                              y: 0
                                               
                                                
					},
					tooltip: {
						formatter: function() {
							return ''+
								this.x +': '+ Math.round(this.y) +' %';
						}
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0
						}
					},
				        series: [{
						name: type1,
						data: [type1Rend31, type1Rend41, type1Rend51, type1Rend61, type1Rend71, type1Rend81]
				
					}, {
						name: type2,
						data: [type2Rend31, type2Rend41, type2Rend51, type2Rend61, type2Rend71, type2Rend81]
				
					}, {
						name: type3,
						data: [type3Rend31, type3Rend41, type3Rend51, type3Rend61, type3Rend71, type3Rend81]
				
					},{type: 'spline',
						name: 'HAVO',
						data: [DLENorm, DLENorm, DLENorm, DLENorm, DLENorm, DLENorm]},
                                              {type: 'spline',
						name: 'TLW',
						data: [DLETLW, DLETLW, DLETLW, DLETLW, DLETLW, DLETLW]}
                                        
				
                                        ]
				});
				
				
			});
               }
               function createChartProfile4(){
               
			var chart4;
			$(document).ready(function() {
				chart4 = new Highcharts.Chart({
					chart: {
						renderTo: profileschoolgraph1big,
						defaultSeriesType: 'column',
                                                    backgroundColor: '#D9F0F6'
					},
                                               title: {
						text: 'Cito Eindtoets'
					},
					subtitle: {
						text: 'deelname: <br />' + deelname1 + ' leerlingen' , 
                                                       floating: true,
                                                       x: 175,
                                                        y: 0
					},
					
					 credits: {
						enabled: false
					},
                                                xAxis: {
                                                    labels: false,
                                                    min:1,
                                                    max:1
                                                },
					yAxis: {
						min: 520,
                                                max: 540,
						title: {
							text:  citojaar1
						}
					},
					legend: {
						enabled: true,
                                                          x: 30,
                                              y: 0
                                               
                                                
					},
					tooltip: {
						formatter: function() {
							return ''+
								this.y;
						}
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0,
                                                        dataLabels: {
								enabled: false,
								color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black'
							}
						}
					},
				        series: [{
                                                          type: 'column', 
						name: 'CitoScore',
                                                 
						data: [{y:null, color:'#819FF7'}, {y:score1, color:'#819FF7'}]
				
					}, {type: 'line',
                                                    name: 'Ondergrens',
                                                    
                                                    data: [{y:onderGrens1, color:'#a90c00'}, onderGrens1, onderGrens1 ]
                                                }, {type: 'line',
                                                    name: 'Gemiddelde',
                                                    data: [gem1, gem1, gem1 ]
                                                }]
                                            
				});
				
				
			});
                 }	
               function createChartProfile51(){
   
        
			
			var chart51;
			$(document).ready(function() {
				chart51 = new Highcharts.Chart({
					chart: {
						renderTo: 'profileschoolgraph1bigVO',
						defaultSeriesType: 'column',
                                                      backgroundColor: '#D9F0F6'
					},
					title: {
						text: 'Loopbaan VO'
					},subtitle: {
						text: 'getallen in %'+', aantal leerlingen: '+totalVOStudents1 + ", " + VOYear1,
                                                        floating: true,
                                                       x:-100,
                                                       y:0
					},
					xAxis: {
						categories: [level1, level2, level3, level4, level5]
					},
					yAxis: {
						min: 0,
                                                       max: 100,
						title: {
							text: ''
						},
						stackLabels: {
							enabled: false,
							style: {
								
								color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
							}
						}
					},
                                             credits: {
						enabled: false
					},
					legend: {
						align: 'right',
						x: -50,
						verticalAlign: 'top',
						y: 195,
						floating: true,
						backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
						borderColor: '#dfe3e6',
                                                backgroundColor: '#dfe3e6',
						borderWidth: 1,
						shadow: false
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.x +'</b><br/>'+
								 this.series.name +': '+ this.y +'<br/>';
								 
						}
					},
					plotOptions: {
						column: {
							stacking: 'normal',
							dataLabels: {
								enabled: false,
								color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
							}
						}
					},
				    series: [{
						name: 'Opstroom',
						data: [ILT1UpPerc1, ILT2UpPerc1, ILT3UpPerc1, ILT4UpPerc1, ILT5UpPerc1], color:'#5ec400'
					}, {
						name: 'Gelijk',
						data: [ILT1SamePerc1, ILT2SamePerc1, ILT3SamePerc1, ILT4SamePerc1, ILT5SamePerc1], color:'#64dc00'
					}, {
						name: 'Afstroom',
						data: [ILT1DownPerc1, ILT2DownPerc1, ILT3DownPerc1, ILT4DownPerc1, ILT5DownPerc1], color:'#FF8000'
					},
                                    {
						name: 'Blijven zitten',
						data: [ILT1HeldPerc1, ILT2HeldPerc1, ILT3HeldPerc1, ILT4HeldPerc1, ILT5HeldPerc1], color:'#a90c00'
					}]
				});
				
				
			});
				

				
                    
               }
                function createChartProfile52(){
  
        
			var chart52;
			$(document).ready(function() {
				chart52 = new Highcharts.Chart({
					chart: {
						renderTo: 'profileschoolgraph1bigadvice',
						defaultSeriesType: 'column',
                                                    backgroundColor: '#D9F0F6'
					},
                                               title: {
						text: ' Advies PO'
					},
					subtitle: {
						text: aantalgoed1,
                                                       floating: true,
                                                       x: 15,
                                                        y: 213
					},
					
					xAxis: {
                                            text: 'gem verschil',
						categories: [
							aantallaag1, 
							aantalhoog1
							
						]
					}, credits: {
						enabled: false
					},
					yAxis: {
						min: 0,
                                                       max: 3,
						title: {
							text: ''
						}
					},
					legend: {
						enabled: false
					},
					tooltip: {
						formatter: function() {
							return ''+
								this.x +': '+ this.y +' Gem. afwijking';
						}
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0,
                                                        dataLabels: {
								enabled: true,
								color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black'
							}
						}
					},
				        series: [{
						name: 'Advies',
						data: [laagafwijking1, hoogafwijking1]
				
					}]
				});
				
				
			});
				
                    
               }
              function createChartComparison11(){
   
        var chart1;
      
			$(document).ready(function() {
				chart1 = new Highcharts.Chart({
					chart: {
						renderTo: compareschoolgraph1big,
						 backgroundColor: '#D9F0F6',
                                                        spacingTop: 30,
                                                        spacingBottom: 30,
                                                        spacingLeft: 110,
                                                        spacingRight: 100
                                                      
					},
					title: {
                                                          
						text: null,
                                                       floating: true,
                                                       x:200,
                                                       y:5
					},subtitle: {
						text: 'Jaar: '+ areaYear + '<br/>' + 'Totaal LL: '+total1, 
                                                       floating: true,
                                                       x: 180,
                                                        y: -10
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +' %';
						}
					},
                                             credits: {
						enabled: false
					},
				         plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
                                                                        color:'#Fcffa2',
                                                                       
							dataLabels: {
								enabled: true,
								color: '#000000',
								connectorColor: '#000000',
								formatter: function() {
									return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +' %';
								}
							}
						}
					},
				        series: [{
						type: 'pie',
						name: 'student',
						data: [
							{name: name11,   y:percentages11, color:'#Dbdb01'},
							{name: name12,   y:percentages12, color:'#Eef502'},
							{name: name13,   y:percentages13, color:'#F7fe27'},
							{name: name14,  y:percentages14, color:'#F4fa4c'},
							{name: name15,   y:percentages15, color:'#F6fa7d'},
							{name: name16,    
								y: percentages16,
								sliced: true,
								selected: true,
                                                                                    color:'#Fcffa2'
								
							}
						]
					}]
				});
			});
				
                    
               }
                    function createChartComparison12(){
   
        var chart2;
      
			$(document).ready(function() {
				chart2 = new Highcharts.Chart({
					chart: {
						renderTo: compareschoolgraph2big ,
						 backgroundColor: '#D9F0F6',
                                                        spacingTop: 30,
                                                        spacingBottom: 30,
                                                        spacingLeft: 110,
                                                        spacingRight: 100
                                                      
					},
					title: {
                                                          
						text: null,
                                                       floating: true,
                                                       x:200,
                                                       y:5
					},subtitle: {
						text: 'Jaar: '+ areaYear + '<br/>' + 'Totaal LL: '+total2, 
                                                       floating: true,
                                                       x: 180,
                                                        y: -10
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +' %';
						}
					},
                                             credits: {
						enabled: false
					},
				         plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								color: '#000000',
								connectorColor: '#000000',
								formatter: function() {
									return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +' %';
								}
							}
						}
					},
				        series: [{
						type: 'pie',
						name: 'student',
						data: [
							{name: name21,   y:percentages21, color:'#5ec400'},
							{name: name22,   y:percentages22, color:'#64dc00'},
							{name: name23,   y:percentages23, color:'#77f510'},
							{name: name24,  y:percentages24, color:'#86ee34'},
							{name: name25,   y:percentages25, color:'#a0ea64'},
							{name: name26,    
								y: percentages26,
								sliced: true,
								selected: true,
                                                                                    color:'#b5eb87'
								
							}
						]
					}]
				});
			});
				
                    
               }
                function createChartComparison13(){
   
        var chart3;
      
			$(document).ready(function() {
				chart3 = new Highcharts.Chart({
					chart: {
						renderTo: compareschoolgraph3big ,
						 backgroundColor: '#D9F0F6',
                                                        spacingTop: 30,
                                                        spacingBottom: 30,
                                                        spacingLeft: 110,
                                                        spacingRight: 100
                                                      
					},
					title: {
                                                          
						text: null,
                                                       floating: true,
                                                       x:200,
                                                       y:5
					},subtitle: {
						text: 'Jaar: '+ areaYear + '<br/>' + 'Totaal LL: '+total3, 
                                                       floating: true,
                                                       x: 180,
                                                        y: -10
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +' %';
						}
					},
                                             credits: {
						enabled: false
					},
				         plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								color: '#000000',
								connectorColor: '#000000',
								formatter: function() {
									return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +' %';
								}
							}
						}
					},
				        series: [{
						type: 'pie',
						name: 'student',
						data: [
							{name: name31,   y:percentages31, color:'#a90c00'},
							{name: name32,   y:percentages32, color:'#be1300'},
							{name: name33,   y:percentages33, color:'#d51f0b'},
							{name: name34,  y:percentages34, color:'#cf3c2b'},
							{name: name35,   y:percentages35, color:'#cb6054'},
							{name: name36,    
								y: percentages36,
								sliced: true,
								selected: true,
                                                                                    color:'#cc7b73'
								
							}
						]
					}]
				});
			});
				
                    
               }
               function createChartComparison21(){
		
			var chart21;
			$(document).ready(function() {
				chart21 = new Highcharts.Chart({
					chart: {
						renderTo: compareschoolgraph1big,
						defaultSeriesType: 'line',
                                                 backgroundColor: '#D9F0F6'
					},
					title: {
						text: 'Groei & Prognose'
					},

					xAxis: {
						categories: [growthTotalYear10, growthTotalYear11, growthTotalYear12, growthTotalYear13, growthTotalYear14, growthProgTotalYear10, growthProgTotalYear11, growthProgTotalYear12, growthProgTotalYear13, growthProgTotalYear14]
					},
					yAxis: {
						title: {
							text: 'Leerlingen'
						}
					}, credits: {
						enabled: false
					},
					tooltip: {
						enabled: false,
						formatter: function() {
							return '<b>'+ this.series.name +'</b><br/>'+
								this.x +': '+ this.y +'Leerlingen';
						}
					},
					plotOptions: {
						line: {
							dataLabels: {
								enabled: true
							},
							enableMouseTracking: false
						}
					},
					series: [{
						name: 'Groei',
						data: [growthTotal10, growthTotal11, growthTotal12, growthTotal13, growthTotal14, null, null, null, null, null]
					}, {
						name: 'Prognose',
						data: [null, null, null, null, null, growthProgTotal10, growthProgTotal11, growthProgTotal12, growthProgTotal13, growthProgTotal14]
					}]
				});
				
				
			});
					
               }
                function createChartComparison22(){
		
			var chart22;
			$(document).ready(function() {
				chart22 = new Highcharts.Chart({
					chart: {
						renderTo: compareschoolgraph2big,
						defaultSeriesType: 'line',
                                                 backgroundColor: '#D9F0F6'
					},
					title: {
						text: 'Groei & Prognose'
					},

					xAxis: {
						categories: [growthTotalYear20, growthTotalYear21, growthTotalYear22, growthTotalYear23, growthTotalYear24, growthProgTotalYear20, growthProgTotalYear21, growthProgTotalYear22, growthProgTotalYear23, growthProgTotalYear24]
					},
					yAxis: {
						title: {
							text: 'Leerlingen'
						}
					}, credits: {
						enabled: false
					},
					tooltip: {
						enabled: false,
						formatter: function() {
							return '<b>'+ this.series.name +'</b><br/>'+
								this.x +': '+ this.y +'Leerlingen';
						}
					},
					plotOptions: {
						line: {
							dataLabels: {
								enabled: true
							},
							enableMouseTracking: false
						}
					},
					series: [{
						name: 'Groei',
						data: [growthTotal20, growthTotal21, growthTotal22, growthTotal23, growthTotal24, null, null, null, null, null]
					}, {
						name: 'Prognose',
						data: [null, null, null, null, null, growthProgTotal20, growthProgTotal21, growthProgTotal22, growthProgTotal23, growthProgTotal24]
					}]
				});
				
				
			});
					
               }
                function createChartComparison23(){
		
			var chart23;
			$(document).ready(function() {
				chart23 = new Highcharts.Chart({
					chart: {
						renderTo: compareschoolgraph3big,
						defaultSeriesType: 'line',
                                                 backgroundColor: '#D9F0F6'
					},
					title: {
						text: 'Groei & Prognose'
					},

					xAxis: {
						categories: [growthTotalYear30, growthTotalYear31, growthTotalYear32, growthTotalYear33, growthTotalYear34, growthProgTotalYear30, growthProgTotalYear31, growthProgTotalYear32, growthProgTotalYear33, growthProgTotalYear34]
					},
					yAxis: {
						title: {
							text: 'Leerlingen'
						}
					}, credits: {
						enabled: false
					},
					tooltip: {
						enabled: false,
						formatter: function() {
							return '<b>'+ this.series.name +'</b><br/>'+
								this.x +': '+ this.y +'Leerlingen';
						}
					},
					plotOptions: {
						line: {
							dataLabels: {
								enabled: true
							},
							enableMouseTracking: false
						}
					},
					series: [{
						name: 'Groei',
						data: [growthTotal30, growthTotal31, growthTotal32, growthTotal33, growthTotal34, null, null, null, null, null]
					}, {
						name: 'Prognose',
						data: [null, null, null, null, null, growthProgTotal30, growthProgTotal31, growthProgTotal32, growthProgTotal33, growthProgTotal34]
					}]
				});
				
				
			});
					
               }
                  function createChartComparison31(){
                  var chart31;
			$(document).ready(function() {
				chart31 = new Highcharts.Chart({
					chart: {
						renderTo: 'compareschoolgraph1big',
						defaultSeriesType: 'column',
                                                  backgroundColor: '#D9F0F6'
					},
					title: {
						text: "DLE/DL Rendement "+ DLEYear
					},
					subtitle: {
						text: ''
					},
                                         credits: {
						enabled: false
					},
					xAxis: {
                                            
						categories: [
							'Groep 3'+"<br />", 
							'Groep 4'+"<br />", 
							'Groep 5'+"<br />", 
							'Groep 6'+"<br />", 
							'Groep 7'+"<br />", 
							'Groep 8'+"<br />"							
						]
					},
					yAxis: {
						min: 40,
                                                        max: 140,
                                                        tickInterval: 20,
						title: {
							text: 'Gem. (DLE/DL)*100'
                                                                 
						}
					},
					legend: {
						enabled: true,
                                                          x: 30,
                                              y: 0
                                               
                                                
					},
					tooltip: {
						formatter: function() {
							return ''+
								this.x +': '+ Math.round(this.y) +' %';
						}
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0
						}
					},
				        series: [{
						name: type1,
						data: [type1Rend31, type1Rend41, type1Rend51, type1Rend61, type1Rend71, type1Rend81]
				
					}, {
						name: type2,
						data: [type2Rend31, type2Rend41, type2Rend51, type2Rend61, type2Rend71, type2Rend81]
				
					}, {
						name: type3,
						data: [type3Rend31, type3Rend41, type3Rend51, type3Rend61, type3Rend71, type3Rend81]
				
					},{type: 'spline',
						name: 'HAVO',
						data: [DLENorm, DLENorm, DLENorm, DLENorm, DLENorm, DLENorm]},
                                              {type: 'spline',
						name: 'TLW',
						data: [DLETLW, DLETLW, DLETLW, DLETLW, DLETLW, DLETLW]}
                                        ]
				});
				
				
			});
                  }
                  function createChartComparison32(){
                     var chart32;
			$(document).ready(function() {
				chart32 = new Highcharts.Chart({
					chart: {
						renderTo: 'compareschoolgraph2big',
						defaultSeriesType: 'column',
                                                  backgroundColor: '#D9F0F6'
					},
					title: {
						text: "DLE/DL Rendement "+ DLEYear
					},
					subtitle: {
						text: ''
					},
                                         credits: {
						enabled: false
					},
					xAxis: {
                                            
						categories: [
							'Groep 3'+"<br />", 
							'Groep 4'+"<br />", 
							'Groep 5'+"<br />", 
							'Groep 6'+"<br />", 
							'Groep 7'+"<br />", 
							'Groep 8'+"<br />"							
						]
					},
					yAxis: {
						min: 40,
                                                        max: 140,
                                                        tickInterval: 20,
						title: {
							text: 'Gem. (DLE/DL)*100'
                                                                 
						}
					},
					legend: {
						enabled: true,
                                                          x: 30,
                                              y: 0
                                               
                                                
					},
					tooltip: {
						formatter: function() {
							return ''+
								this.x +': '+ Math.round(this.y) +' %';
						}
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0
						}
					},
				        series: [{
						name: type1,
						data: [type1Rend32, type1Rend42, type1Rend52, type1Rend62, type1Rend72, type1Rend82]
				
					}, {
						name: type2,
						data: [type2Rend32, type2Rend42, type2Rend52, type2Rend62, type2Rend72, type2Rend82]
				
					}, {
						name: type3,
						data: [type3Rend32, type3Rend42, type3Rend52, type3Rend62, type3Rend72, type3Rend82]
				
					},{type: 'spline',
						name: 'HAVO',
						data: [DLENorm, DLENorm, DLENorm, DLENorm, DLENorm, DLENorm]},
                                              {type: 'spline',
						name: 'TLW',
						data: [DLETLW, DLETLW, DLETLW, DLETLW, DLETLW, DLETLW]}
                                        ]
				});
				
				
			});
                  }
                  function createChartComparison33(){
                var chart33;
			$(document).ready(function() {
				chart33 = new Highcharts.Chart({
					chart: {
						renderTo: 'compareschoolgraph3big',
						defaultSeriesType: 'column',
                                                  backgroundColor: '#D9F0F6'
					},
					title: {
						text: "DLE/DL Rendement "+ DLEYear
					},
					subtitle: {
						text: ''
					},
                                         credits: {
						enabled: false
					},
					xAxis: {
                                            
						categories: [
							'Groep 3'+"<br />", 
							'Groep 4'+"<br />", 
							'Groep 5'+"<br />", 
							'Groep 6'+"<br />", 
							'Groep 7'+"<br />", 
							'Groep 8'+"<br />"							
						]
					},
					yAxis: {
						min: 40,
                                                        max: 140,
                                                        tickInterval: 20,
						title: {
							text: 'Gem. (DLE/DL)*100'
                                                                 
						}
					},
					legend: {
						enabled: true,
                                                          x: 30,
                                              y: 0
                                               
                                                
					},
					tooltip: {
						formatter: function() {
							return ''+
								this.x +': '+ Math.round(this.y) +' %';
						}
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0
						}
					},
				        series: [{
						name: type1,
						data: [type1Rend33, type1Rend43, type1Rend53, type1Rend63, type1Rend73, type1Rend83]
				
					}, {
						name: type2,
						data: [type2Rend33, type2Rend43, type2Rend53, type2Rend63, type2Rend73, type2Rend83]
				
					}, {
						name: type3,
						data: [type3Rend33, type3Rend43, type3Rend53, type3Rend63, type3Rend73, type3Rend83]
				
					},{type: 'spline',
						name: 'HAVO',
						data: [DLENorm, DLENorm, DLENorm, DLENorm, DLENorm, DLENorm]},
                                              {type: 'spline',
						name: 'TLW',
						data: [DLETLW, DLETLW, DLETLW, DLETLW, DLETLW, DLETLW]}
                                        ]
				});
				
				
			});
                  }
                    function createChartComparison41(){
               
			var chart41;
			$(document).ready(function() {
				chart41 = new Highcharts.Chart({
					chart: {
						renderTo: compareschoolgraph1big,
						defaultSeriesType: 'column',
                                                    backgroundColor: '#D9F0F6'
					},
                                               title: {
						text: 'Cito Eindtoets'
					},
					subtitle: {
						text: 'deelname: <br />' + deelname1 + ' leerlingen' , 
                                                       floating: true,
                                                       x: 175,
                                                        y: 0
					},
					
					 credits: {
						enabled: false
					},
                                                xAxis: {
                                                    labels: false,
                                                    min:1,
                                                    max:1
                                                },
					yAxis: {
						min: 520,
                                                max: 540,
                                                 tickInterval: 5,
                                                
						title: {
							text:  citojaar1
						}
					},
					legend: {
						enabled: true,
                                                          x: 30,
                                              y: 0
                                               
                                                
					},
					tooltip: {
						formatter: function() {
							return ''+
								this.y;
						}
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0,
                                                        dataLabels: {
								enabled: false,
								color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black'
							}
						}
					},
				        series: [{
                                                          type: 'column', 
						name: 'CitoScore',
                                                 
						data: [{y:null, color:'#Dbdb01'}, {y:score1, color:'#Dbdb01'}]
				
					}, {type: 'line',
                                                    name: 'Ondergrens',
                                                    
                                                    data: [{y:onderGrens1, color:'#a90c00'}, onderGrens1, onderGrens1 ]
                                                }, {type: 'line',
                                                    name: 'Gemiddelde',
                                                    data: [gem1, gem1, gem1 ]
                                                }]
                                            
				});
				
				
			});
                 }	
                             function createChartComparison42(){
               
			var chart42;
			$(document).ready(function() {
				chart42 = new Highcharts.Chart({
					chart: {
						renderTo: compareschoolgraph2big,
						defaultSeriesType: 'column',
                                                    backgroundColor: '#D9F0F6'
					},
                                               title: {
						text: 'Cito Eindtoets'
					},
					subtitle: {
						text: 'deelname: <br />' + deelname2 + ' leerlingen' , 
                                                       floating: true,
                                                       x: 175,
                                                        y: 0
					},
					
					 credits: {
						enabled: false
					},
                                                xAxis: {
                                                    labels: false,
                                                    min:1,
                                                    max:1
                                                },
					yAxis: {
						min: 520,
                                                max: 540,
                                                 tickInterval: 5,
						title: {
							text:  citojaar2
						}
					},
					legend: {
						enabled: true,
                                                          x: 30,
                                              y: 0
                                               
                                                
					},
					tooltip: {
						formatter: function() {
							return ''+
								this.y;
						}
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0,
                                                        dataLabels: {
								enabled: false,
								color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black'
							}
						}
					},
				        series: [{
                                                          type: 'column', 
						name: 'CitoScore',
                                                 
						data: [{y:null, color:'#5ec400'}, {y:score2, color:'#5ec400'}]
				
					}, {type: 'line',
                                                    name: 'Ondergrens',
                                                    
                                                    data: [{y:onderGrens2, color:'#a90c00'}, onderGrens2, onderGrens2 ]
                                                }, {type: 'line',
                                                    name: 'Gemiddelde',
                                                    data: [gem2, gem2, gem2 ]
                                                }]
                                            
				});
				
				
			});
                 }	
                     function createChartComparison43(){
               
			var chart43;
			$(document).ready(function() {
				chart43 = new Highcharts.Chart({
					chart: {
						renderTo: compareschoolgraph3big,
						defaultSeriesType: 'column',
                                                    backgroundColor: '#D9F0F6'
					},
                                               title: {
						text: 'Cito Eindtoets'
					},
					subtitle: {
						text: 'deelname: <br />' + deelname3 + ' leerlingen' , 
                                                       floating: true,
                                                       x: 175,
                                                        y: 0
					},
					
					 credits: {
						enabled: false
					},
                                                xAxis: {
                                                    labels: false,
                                                    min:1,
                                                    max:1
                                                },
					yAxis: {
						min: 520,
                                                max: 540,
                                                 tickInterval: 5,
						title: {
							text:  citojaar3
						}
					},
					legend: {
						enabled: true,
                                                          x: 30,
                                              y: 0
                                               
                                                
					},
					tooltip: {
						formatter: function() {
							return ''+
								this.y;
						}
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0,
                                                        dataLabels: {
								enabled: false,
								color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black'
							}
						}
					},
				        series: [{
                                                          type: 'column', 
						name: 'CitoScore',
                                                 
						data: [{y:null, color:'#d51f0b'}, {y:score3, color:'#d51f0b'}]
				
					}, {type: 'line',
                                                    name: 'Ondergrens',
                                                    
                                                    data: [{y:onderGrens3, color:'#a90c00'}, onderGrens3, onderGrens3 ]
                                                }, {type: 'line',
                                                    name: 'Gemiddelde',
                                                    data: [gem3, gem3, gem3 ]
                                                }]
                                            
				});
				
				
			});
                 }	
                 
        function createChartComparison511(){
   
        
			
			var chart511;
			$(document).ready(function() {
				chart511 = new Highcharts.Chart({
					chart: {
						renderTo: compareschoolgraph1big,
						defaultSeriesType: 'column',
                                                      backgroundColor: '#D9F0F6'
					},
					title: {
						text: 'Loopbaan VO'
					},subtitle: {
						text: 'getallen in %'+', aantal leerlingen: '+totalVOStudents1+ " , "+ VOYear1,
                                                        floating: true,
                                                       x:-90,
                                                       y:0
					},
					xAxis: {
						categories: [level1, level2, level3, level4, level5]
					},
					yAxis: {
						min: 0,
                                                       max: 100,
						title: {
							text: ''
						},
						stackLabels: {
							enabled: false,
							style: {
								
								color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
							}
						}
					},
                                             credits: {
						enabled: false
					},
					legend: {
                                                       
						align: 'right',
						x: -50,
						verticalAlign: 'top',
						y: 150,
						floating: true,
						backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
						borderColor: '#dfe3e6',
                                                backgroundColor: '#dfe3e6',
						borderWidth: 1,
                                                
						shadow: false
                                                
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.x +'</b><br/>'+
								 this.series.name +': '+ this.y +'<br/>';
								 
						}
					},
					plotOptions: {
						column: {
							stacking: 'normal',
							dataLabels: {
								enabled: false,
								color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
							}
						}
					},
				    series: [{
						name: 'Opstroom',
						data: [ILT1UpPerc1, ILT2UpPerc1, ILT3UpPerc1, ILT4UpPerc1, ILT5UpPerc1], color:'#5ec400'
					}, {
						name: 'Gelijk',
						data: [ILT1SamePerc1, ILT2SamePerc1, ILT3SamePerc1, ILT4SamePerc1, ILT5SamePerc1], color:'#64dc00'
					}, {
						name: 'Afstroom',
						data: [ILT1DownPerc1, ILT2DownPerc1, ILT3DownPerc1, ILT4DownPerc1, ILT5DownPerc1], color:'#FF8000'
					},
                                    {
						name: 'Blijven zitten',
						data: [ILT1HeldPerc1, ILT2HeldPerc1, ILT3HeldPerc1, ILT4HeldPerc1, ILT5HeldPerc1], color:'#a90c00'
					}]
				});
				
				
			});
				

				
                    
               }             
               
                 function createChartComparison512(){
   
        
			
			var chart512;
			$(document).ready(function() {
				chart513 = new Highcharts.Chart({
					chart: {
						renderTo: compareschoolgraph2big,
						defaultSeriesType: 'column',
                                                      backgroundColor: '#D9F0F6'
					},
					title: {
						text: 'Loopbaan VO'
					},subtitle: {
						text: 'getallen in %'+', aantal leerlingen: '+totalVOStudents2+ " , "+ VOYear2,
                                                        floating: true,
                                                       x:-90,
                                                       y:0
					},
					xAxis: {
						categories: [level1, level2, level3, level4, level5]
					},
					yAxis: {
						min: 0,
                                                       max: 100,
						title: {
							text: ''
						},
						stackLabels: {
							enabled: false,
							style: {
								
								color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
							}
						}
					},
                                             credits: {
						enabled: false
					},
					legend: {
                                                       
						align: 'right',
						x: -50,
						verticalAlign: 'top',
						y: 150,
						floating: true,
						backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
						borderColor: '#dfe3e6',
                                                backgroundColor: '#dfe3e6',
						borderWidth: 1,
                                                
						shadow: false
                                                
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.x +'</b><br/>'+
								 this.series.name +': '+ this.y +'<br/>';
								 
						}
					},
					plotOptions: {
						column: {
							stacking: 'normal',
							dataLabels: {
								enabled: false,
								color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
							}
						}
					},
				    series: [{
						name: 'Opstroom',
						data: [ILT1UpPerc2, ILT2UpPerc2, ILT3UpPerc2, ILT4UpPerc2, ILT5UpPerc2], color:'#5ec400'
					}, {
						name: 'Gelijk',
						data: [ILT1SamePerc2, ILT2SamePerc2, ILT3SamePerc2, ILT4SamePerc2, ILT5SamePerc2], color:'#64dc00'
					}, {
						name: 'Afstroom',
						data: [ILT1DownPerc2, ILT2DownPerc2, ILT3DownPerc2, ILT4DownPerc2, ILT5DownPerc2], color:'#FF8000'
					},
                                    {
						name: 'Blijven zitten',
						data: [ILT1HeldPerc2, ILT2HeldPerc2, ILT3HeldPerc2, ILT4HeldPerc2, ILT5HeldPerc2], color:'#a90c00'
					}]
				});
				
				
			});
				

				
                    
               }             
                 function createChartComparison513(){
   
        
			
			var chart513;
			$(document).ready(function() {
				chart513 = new Highcharts.Chart({
					chart: {
						renderTo: compareschoolgraph3big,
						defaultSeriesType: 'column',
                                                      backgroundColor: '#D9F0F6'
					},
					title: {
						text: 'Loopbaan VO'
					},subtitle: {
						text: 'getallen in %'+', aantal leerlingen: '+totalVOStudents3+ " , "+ VOYear3,
                                                        floating: true,
                                                       x:-90,
                                                       y:0
					},     
					
					xAxis: {
						categories: [level1, level2, level3, level4, level5]
					},
					yAxis: {
						min: 0,
                                                       max: 100,
						title: {
							text: ''
						},
						stackLabels: {
							enabled: false,
							style: {
								
								color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
							}
						}
					},
                                             credits: {
						enabled: false
					},
					legend: {
                                                       
						align: 'right',
						x: -50,
						verticalAlign: 'top',
						y: 150,
						floating: true,
						backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
						borderColor: '#dfe3e6',
                                                backgroundColor: '#dfe3e6',
						borderWidth: 1,
                                                
						shadow: false
                                                
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.x +'</b><br/>'+
								 this.series.name +': '+ this.y +'<br/>';
								 
						}
					},
					plotOptions: {
						column: {
							stacking: 'normal',
							dataLabels: {
								enabled: false,
								color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
							}
						}
					},
				    series: [{
						name: 'Opstroom',
						data: [ILT1UpPerc3, ILT2UpPerc3, ILT3UpPerc3, ILT4UpPerc3, ILT5UpPerc3], color:'#5ec400'
					}, {
						name: 'Gelijk',
						data: [ILT1SamePerc3, ILT2SamePerc3, ILT3SamePerc3, ILT4SamePerc3, ILT5SamePerc3], color:'#64dc00'
					}, {
						name: 'Afstroom',
						data: [ILT1DownPerc3, ILT2DownPerc3, ILT3DownPerc3, ILT4DownPerc3, ILT5DownPerc3], color:'#FF8000'
					},
                                    {
						name: 'Blijven zitten',
						data: [ILT1HeldPerc3, ILT2HeldPerc3, ILT3HeldPerc3, ILT4HeldPerc3, ILT5HeldPerc3], color:'#a90c00'
					}]
				});
				
				
			});
				

				
                    
               }             
//createUnavailable functions are temporary untill we fit an image when theres no graph available.          
  function createUnavailableProfile1(){
   
        var chart7;
      
			$(document).ready(function() {
				chart4 = new Highcharts.Chart({
					chart: {
						renderTo: profileschoolgraph1big ,
						 backgroundColor: '#D9F0F6',
                                                        spacingTop: 30,
                                                        spacingBottom: 30,
                                                        spacingLeft: 110,
                                                        spacingRight: 100
                                                      
					},
					title: {
                                                          
						text:"Geen grafiek beschikbaar" ,
                                                       floating: true,
                                                       x:0,
                                                       y:5
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +'';
						}
					},
                                             credits: {
						enabled: false
					}
				         
				   
				});
			});
				
                    
               }
                function createSchoolUnavailable2(){
   
        var chart29;
      
			$(document).ready(function() {
				chart29 = new Highcharts.Chart({
					chart: {
						renderTo: profileschoolgraph2big ,
						 backgroundColor: '#D9F0F6',
                                                        spacingTop: 30,
                                                        spacingBottom: 30,
                                                        spacingLeft: 110,
                                                        spacingRight: 100
                                                      
					},
					title: {
                                                          
						text:"Geen grafiek beschikbaar" ,
                                                       floating: true,
                                                       x:0,
                                                       y:5
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +'';
						}
					},
                                             credits: {
						enabled: false
					}
				         
				   
				});
			});
				
                    
               }
                function createSchoolUnavailable3(){
   
        var chart39;
      
			$(document).ready(function() {
				chart39 = new Highcharts.Chart({
					chart: {
						renderTo: profileschoolgraph3big ,
						 backgroundColor: '#D9F0F6',
                                                        spacingTop: 30,
                                                        spacingBottom: 30,
                                                        spacingLeft: 110,
                                                        spacingRight: 100
                                                      
					},
					title: {
                                                          
						text:"Geen grafiek beschikbaar" ,
                                                       floating: true,
                                                       x:0,
                                                       y:5
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +'';
						}
					},
                                             credits: {
						enabled: false
					}
				         
				   
				});
			});
				
                    
               }
                function createSchoolUnavailable4(){
   
        var chart49;
      
			$(document).ready(function() {
				chart49 = new Highcharts.Chart({
					chart: {
						renderTo: profileschoolgraph4big ,
						 backgroundColor: '#D9F0F6',
                                                        spacingTop: 30,
                                                        spacingBottom: 30,
                                                        spacingLeft: 110,
                                                        spacingRight: 100
                                                      
					},
					title: {
                                                          
						text:"Geen grafiek beschikbaar" ,
                                                       floating: true,
                                                       x:0,
                                                       y:5
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +'';
						}
					},
                                             credits: {
						enabled: false
					}
				         
				   
				});
			});
				
                    
               }function createSchoolUnavailable5(){
   
        var chart59;
      
			$(document).ready(function() {
				chart59 = new Highcharts.Chart({
					chart: {
						renderTo: profileschoolgraph5bigVO ,
						 backgroundColor: '#D9F0F6',
                                                        spacingTop: 30,
                                                        spacingBottom: 30,
                                                        spacingLeft: 110,
                                                        spacingRight: 100
                                                      
					},
					title: {
                                                          
						text:"Geen grafiek beschikbaar" ,
                                                       floating: true,
                                                       x:0,
                                                       y:5
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +'';
						}
					},
                                             credits: {
						enabled: false
					}
				         
				   
				});
			});
				
                    
               }
                  function createProfileUnavailable1(){
   
        var chart1;
      
			$(document).ready(function() {
				chart1 = new Highcharts.Chart({
					chart: {
						renderTo: profileschoolgraph1big,
						 backgroundColor: '#D9F0F6',
                                                        spacingTop: 30,
                                                        spacingBottom: 30,
                                                        spacingLeft: 110,
                                                        spacingRight: 100
                                                      
					},
					title: {
                                                          
						text:"Geen grafiek beschikbaar" ,
                                                       floating: true,
                                                       x:0,
                                                       y:5
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +'';
						}
					},
                                             credits: {
						enabled: false
					}
				         
				   
				});
			});
				
                    
               }
                    function createProfileUnavailable2(){
   
        var chart1;
      
			$(document).ready(function() {
				chart1 = new Highcharts.Chart({
					chart: {
						renderTo: profileschoolgraph1bigVO ,
						 backgroundColor: '#D9F0F6',
                                                        spacingTop: 30,
                                                        spacingBottom: 30,
                                                        spacingLeft: 110,
                                                        spacingRight: 100
                                                      
					},
					title: {
                                                          
						text:"Geen grafiek beschikbaar" ,
                                                       floating: true,
                                                       x:115,
                                                       y:5
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +'';
						}
					},
                                             credits: {
						enabled: false
					}
				         
				   
				});
			});
				
                    
               }
               function createUnavailable1(){
   
        var chart4;
      
			$(document).ready(function() {
				chart4 = new Highcharts.Chart({
					chart: {
						renderTo: compareschoolgraph1big ,
						 backgroundColor: '#D9F0F6',
                                                        spacingTop: 30,
                                                        spacingBottom: 30,
                                                        spacingLeft: 110,
                                                        spacingRight: 100
                                                      
					},
					title: {
                                                          
						text:"Geen grafiek beschikbaar" ,
                                                       floating: true,
                                                       x:0,
                                                       y:5
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +'';
						}
					},
                                             credits: {
						enabled: false
					}
				         
				   
				});
			});
				
                    
               }
               function createUnavailable2(){
   
        var chart5;
      
			$(document).ready(function() {
				chart5 = new Highcharts.Chart({
					chart: {
						renderTo: compareschoolgraph2big ,
						 backgroundColor: '#D9F0F6',
                                                        spacingTop: 30,
                                                        spacingBottom: 30,
                                                        spacingLeft: 110,
                                                        spacingRight: 100
                                                      
					},
					title: {
                                                          
						text:"Geen grafiek beschikbaar" ,
                                                       floating: true,
                                                       x:0,
                                                       y:5
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +'';
						}
					},
                                             credits: {
						enabled: false
					}
				         
				   
				});
			});
				
                    
               }
               function createUnavailable3(){
   
        var chart6;
      
			$(document).ready(function() {
				chart6 = new Highcharts.Chart({
					chart: {
						renderTo: compareschoolgraph3big ,
						 backgroundColor: '#D9F0F6',
                                                        spacingTop: 30,
                                                        spacingBottom: 30,
                                                        spacingLeft: 110,
                                                        spacingRight: 100
                                                      
					},
					title: {
                                                          
						text:"Geen grafiek beschikbaar" ,
                                                       floating: true,
                                                       x:0,
                                                       y:5
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +'';
						}
					},
                                             credits: {
						enabled: false
					}
				         
				   
				});
			});
				
                    
               }
function createChartSchoolupdate1(){
   
        
        var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'profileschoolgraph1big',
						 backgroundColor: '#dfe3e6'
                                                      
					},
					title: {
                                                          
						text:null ,
                                     
                                     floating: true,
                                                       x:-310,
                                                       y:5
					},subtitle: {
						text: 'Jaar: '+ areaYear + '<br/>' + 'Totaal LL: '+total, 
                                                       floating: true,
                                                       x: 200,
                                                        y: 0
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +' %';
						}
					},
                                             credits: {
						enabled: false
					},
				         plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								color: '#000000',
								connectorColor: '#000000',
								formatter: function() {
									return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +' %';
								}
							}
						}
					},
				        series: [{
						type: 'pie',
						name: 'student',
						data: [
							[transitionKeys[0],   graphValues[0]],
							[transitionKeys[1],    graphValues[1]],
							[transitionKeys[2],    graphValues[2]],
							[transitionKeys[3],   graphValues[3]],
							[transitionKeys[4],    graphValues[4]],
							{name: transitionKeys[5],    
								y: graphValues[5],
								sliced: true,
								selected: true
								
							}
						]
					}]
				});
			});
				
                    
               }
 function createChartSchoolupdate2(){
		
			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'profileschoolgraph2big',
						defaultSeriesType: 'line',
                                                 backgroundColor: '#dfe3e6'
					},
					title: {
						text: 'Groei & Prognose'
					},

					xAxis: {
						categories: [growthTotalYear10, growthTotalYear11, growthTotalYear12, growthTotalYear13, growthTotalYear14, growthProgTotalYear10, growthProgTotalYear11, growthProgTotalYear12, growthProgTotalYear13, growthProgTotalYear14]
					},
					yAxis: {
						title: {
							text: 'Leerlingen'
						}
					}, credits: {
						enabled: false
					},
					tooltip: {
						enabled: false,
						formatter: function() {
							return '<b>'+ this.series.name +'</b><br/>'+
								this.x +': '+ this.y +'Leerlingen';
						}
					},
					plotOptions: {
						line: {
							dataLabels: {
								enabled: true
							},
							enableMouseTracking: false
						}
					},
					series: [{
						name: 'Groei',
						data: [growthTotal10, growthTotal11, growthTotal12, growthTotal13, growthTotal14, null, null, null, null, null]
					}, {
						name: 'Prognose',
						data: [null, null, null, null, null, growthProgTotal10, growthProgTotal11, growthProgTotal12, growthProgTotal13, growthProgTotal14]
					}]
				});
				
				
			});
					
               }
 function createChartSchoolupdate3(){
             var chart3;
			$(document).ready(function() {
				chart3 = new Highcharts.Chart({
					chart: {
						renderTo: 'profileschoolgraph3big',
						defaultSeriesType: 'column',
                                                  backgroundColor: '#dfe3e6'
					},
					title: {
						text: "DLE/DL Rendement "+ DLEYear
					},
					subtitle: {
						text: ''
					},
                                         credits: {
						enabled: false
					},
					xAxis: {
                                            
						categories: [
							'Groep 3'+"<br />", 
							'Groep 4'+"<br />", 
							'Groep 5'+"<br />", 
							'Groep 6'+"<br />", 
							'Groep 7'+"<br />", 
							'Groep 8'+"<br />"							
						]
					},
					yAxis: {
						min: 40,
                                                        max: 140,
                                                        tickInterval: 20,
						title: {
							text: 'Gem. (DLE/DL)*100'
                                                                 
						}
					},
					legend: {
						enabled: true,
                                                          x: 30,
                                              y: 0
                                               
                                                
					},
					tooltip: {
						formatter: function() {
							return ''+
								this.x +': '+ Math.round(this.y) +' %';
						}
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0
						}
					},
				        series: [{
						name: type1,
						data: [type1Rend31, type1Rend41, type1Rend51, type1Rend61, type1Rend71, type1Rend81]
				
					}, {
						name: type2,
						data: [type2Rend31, type2Rend41, type2Rend51, type2Rend61, type2Rend71, type2Rend81]
				
					}, {
						name: type3,
						data: [type3Rend31, type3Rend41, type3Rend51, type3Rend61, type3Rend71, type3Rend81]
				
					},{type: 'spline',
						name: 'HAVO',
						data: [DLENorm, DLENorm, DLENorm, DLENorm, DLENorm, DLENorm]},
                                              {type: 'spline',
						name: 'TLW',
						data: [DLETLW, DLETLW, DLETLW, DLETLW, DLETLW, DLETLW]}
                                        ]
				});
				
				
			});
               }
               function createChartSchoolupdate4(){
               
			var chart4;
			$(document).ready(function() {
				chart4 = new Highcharts.Chart({
					chart: {
						renderTo: profileschoolgraph4big,
						defaultSeriesType: 'column',
                                                    backgroundColor: '#dfe3e6'
					},
                                               title: {
						text: 'Cito Eindtoets'
					},
					subtitle: {
						text: 'deelname: <br />' + deelname1 + ' leerlingen' , 
                                                       floating: true,
                                                       x: 175,
                                                        y: 0
					},
					
					 credits: {
						enabled: false
					},
                                                xAxis: {
                                                    labels: false,
                                                    min:1,
                                                    max:1
                                                },
					yAxis: {
						min: 520,
                                                max: 540,
						title: {
							text:  citojaar1
						}
					},
					legend: {
						enabled: true,
                                                          x: 30,
                                              y: 0
                                               
                                                
					},
					tooltip: {
						formatter: function() {
							return ''+
								this.y;
						}
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0,
                                                        dataLabels: {
								enabled: false,
								color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black'
							}
						}
					},
				        series: [{
                                                          type: 'column', 
						name: 'CitoScore',
                                                 
						data: [{y:null, color:'#819FF7'}, {y:score1, color:'#819FF7'}]
				
					}, {type: 'line',
                                                    name: 'Ondergrens',
                                                    
                                                    data: [{y:onderGrens1, color:'#a90c00'}, onderGrens1, onderGrens1 ]
                                                }, {type: 'line',
                                                    name: 'Gemiddelde',
                                                    data: [gem1, gem1, gem1 ]
                                                }]
                                            
				});
				
				
			});
                    
               }
               function createChartSchoolupdate51(){
			var chart51;
			$(document).ready(function() {
				chart51 = new Highcharts.Chart({
					chart: {
						renderTo: 'profileschoolgraph5bigVO',
						defaultSeriesType: 'column',
                                                backgroundColor: '#dfe3e6'
					},
					title: {
						text: 'Loopbaan VO'
					},subtitle: {
						text: 'getallen in %'+', aantal leerlingen: '+totalVOStudents1,
                                                        floating: true,
                                                       x:-75,
                                                       y:0
					},
					xAxis: {
						categories: [level1, level2, level3, level4, level5]
					},
					yAxis: {
						min: 0,
                                                       max: 100,
						title: {
							text: ''
						},
						stackLabels: {
							enabled: false,
							style: {
								
								color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
							}
						}
					},
                                             credits: {
						enabled: false
					},
					legend: {
						align: 'right',
						x: -20,
						verticalAlign: 'top',
						y: 165,
						floating: true,
						backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
						borderColor: '#dfe3e6',
                                                backgroundColor: '#dfe3e6',
						borderWidth: 1,
						shadow: false
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.x +'</b><br/>'+
								 this.series.name +': '+ this.y +'<br/>';
								 
						}
					},
					plotOptions: {
						column: {
							stacking: 'normal',
							dataLabels: {
								enabled: true,
								color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
							}
						}
					},
				    series: [{
						name: 'Opstroom',
						data: [ILT1UpPerc1, ILT2UpPerc1, ILT3UpPerc1, ILT4UpPerc1, ILT5UpPerc1], color:'#5ec400'
					}, {
						name: 'Gelijk',
						data: [ILT1SamePerc1, ILT2SamePerc1, ILT3SamePerc1, ILT4SamePerc1, ILT5SamePerc1], color:'#64dc00'
					}, {
						name: 'Afstroom',
						data: [ILT1DownPerc1, ILT2DownPerc1, ILT3DownPerc1, ILT4DownPerc1, ILT5DownPerc1], color:'#d51f0b'
					},
                                    {
						name: 'Blijven zitten',
						data: [ILT1HeldPerc1, ILT2HeldPerc1, ILT3HeldPerc1, ILT4HeldPerc1, ILT5HeldPerc1], color:'#a90c00'
					}]
				});
				
				
			});
				

				
                    
               }
                function createChartSchoolupdate52(){
  
        
			var chart52;
			$(document).ready(function() {
				chart52 = new Highcharts.Chart({
					chart: {
						renderTo: 'profileschoolgraph5bigAdvice',
						defaultSeriesType: 'column',
                                                    backgroundColor: '#dfe3e6'
					},
                                               title: {
						text: ' Advies PO'
					},
					subtitle: {
						text: aantalgoed1,
                                                       floating: true,
                                                       x: 15,
                                                        y: 185
					},
					
					xAxis: {
                                            text: 'gem verschil',
						categories: [
							aantallaag1, 
							aantalhoog1
							
						]
					}, credits: {
						enabled: false
					},
					yAxis: {
						min: 0,
                                                       max: 3,
						title: {
							text: ''
						}
					},
					legend: {
						enabled: false
					},
					tooltip: {
						formatter: function() {
							return ''+
								this.x +': '+ this.y +' Gem. afwijking';
						}
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0,
                                                        dataLabels: {
								enabled: true,
								color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black'
							}
						}
					},
				        series: [{
						name: 'Advies',
						data: [laagafwijking1, hoogafwijking1]
				
					}]
				});
				
				
			});
				
                    
               }
               
               
                    </script>

