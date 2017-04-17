/* when document ready register all basic listener for base functionality.
	Load base Content into the content field.
*/


//Default submitHandler stub. Has to be overidden to submit a form wrapped in the content Div
function submitHandler( event ){
	// for debugging alert if not overriden
	alert("unregistered Submit");
}

//Handler to run if the new Button been clicked
function newButtonHandler() {
	alert("unregistered new Button Event");
}
function navigationHandler( event ) {
	// swap the focus onto the selected item
	$("#selection_tabs > span").removeClass("active");
	$(event).addClass("active");
	$("#footer").html("");
	clearInterval(timeWalker);
	switch($(event).attr('name')){
		case 'notes':
			$("#buttonNeu").parent().parent().show();
			notes();
		break;
		case 'contacts':
			$("#buttonNeu").parent().parent().show();
			contacts();
		break;
		case 'calendar':
			$("#buttonNeu").parent().parent().show();
			calendar();
		break;
		case 'appointments':
			$("#buttonNeu").parent().parent().show();
			appointments();
			timeWalker = setInterval(dateWalking,1000);
		break;
		default:
			$("#buttonNeu").parent().parent().hide();
			overview();
	}
	
	
	
}



function message( msg, isOK ,target) {
	
	result = "<div class=\"jumbotron alert alert-{{type}}\"><h3>{{msg}}</h3></div>";
	result = result.replace("{{msg}}" , msg);
	if (isOK) {
		result = result.replace("{{type}}", "success");
	} else {
		result = result.replace("{{type}}", "danger");
	}
	
	$( target ).html( result );
}



function portletClickHandler( event ) {
	alert("unregistered portlet Click");
}
function itemClickHandler( event ) {
	
	alert("unregistered Item Click");
}

function attachDatePicker( item ) {
	
	//$( item ).css("background","red");
	//item.css("background","red");
	item.datepicker({
		"altFormat":"yy-mm-dd 00:00:00",
		"dateFormat":"DD, d MM, yy",
		"altField": "#alt" + item.attr("name")
	});
}


function fillItemList( data ){
	$("#items > ul li").remove();
	// add the items
	$.each(data,function(key,value){
		//console.info(value);
		createItem(value.id,value.title);
	});
}

function swapActiveItem( item ) {
	// set the selected list item to active
	$("#items > ul > li").removeClass("active");
	$(item).addClass("active");
}
function createItem( id, title , teaser) {
	$("#items > ul").append("<li id = " +  id + " ><a> "  + title + "</a></li>");
	//$("#items > ul [id='" + id + "']").click(itemClickHandler);
}

/********************  NOTES ***************/
function notes(){
	contentWindow = $("#content");
	// cleanOut old stuff
	$("#content > * ").unbind();
	contentWindow.html("");
	
	// define the actions for the new Button
	newButtonHandler = function() {
		
		$.ajax({
				url:"forms/notes",
				type: "GET",
				statusCode:{
					403:redirectLogin
				}
		})
		.success(function(data) {
			
			$("#content").html(data);
			// set the submitHandler 
		});
		submitHandler = function( event){
			event.preventDefault();
			title = $("#content").find("input[name='title']").val();
			$.ajax({
				url:'notes',
				data:{'title': title,
						'teaser' :$("#content").find("textarea[name='teaser']").val(),
						'note' :$("#content").find("textarea[name='note']").val()
					},
				statusCode:{
					403:redirectLogin
				}
			})
			// on success print it on the page
			.success(function(){
				message( "<strong>Erfolg!</strong><br/>Notiz erfolgreich erstellt.", true ,"#content");
				setTimeout(function() {
									$("span[name='notes']").trigger("click");
										
									},2500);
			})
			// on fail give a response
			.fail( function() {
				message( "Notiz konnte nicht erstellt werden.", false ,"#content");
			});
		}
	}
	$.ajax({
		url:"notes",
		dataType:"JSON",
		statusCode:{
			403:redirectLogin
		}
	})
	.success(function(data) {
			// load the note portletst into the content window
			for (var i = 0; i< 3 ;i++) {
				contentWindow.append("<div name = 'col" + i + "'  class = 'column'>");
				
			}
			
			contentWindow.find("div[class*='column']").sortable({
				   helper:"clone",
					cursor: "move",
				   dropOnEmpty: true,
				  grid : [50,50],
				  connectWith: ".column",
				  handle: ".portlet-header",
				  cancel: ".portlet-toggle",
				  placeholder: "portlet-placeholder ui-corner-all"
			});
			
			$.ajax({
				url:'forms/notes/portlet',
				statusCode:{
					403:redirectLogin
				}
			})
			.done(function( tmp ) {
					//dummy = Cookies.getJSON("portlets");
					dummy = new Array("1","2","2","1","0","0","1","0","1");//Cookies.getJSON("portlets");
					
					
					i = 0;
					$.each(data,function(key, value){
						
						portlet = tmp.replace("{{id}}",value.id).replace("{{title}}",value.title).replace("{{teaser}}",value.teaser);
						
						contentWindow.find( "div[name='col" + dummy[i++] + "']" ).append( portlet );
					});
					$( ".portlet" )
					  .addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
					  .find( ".portlet-header" )
						.addClass( "ui-widget-header ui-corner-all" )
						.prepend( "<span name = 'toggle' class='ui-icon ui-icon-minusthick portlet-toggle'></span>");
				 
					$( ".portlet-toggle" ).click(function() {
						  var icon = $( this );
						  icon.toggleClass( "ui-icon-minusthick ui-icon-plusthick" );
						  icon.closest( ".portlet" ).find( ".portlet-content" ).toggle();
					});
					/********************* REGISTER PORTLET CLICK HANDLER  ****************/
					$(".portlet-header,.portlet-content").click(function( event ){
						// if the toggle been hit kill the event trigger 
						if ($(event.target).attr('name') ==  'toggle') {
							return;
						}
						// retrieve the clicked portlet
						portletClickHandler($($(event.target).closest( ".portlet" ) ));
					});
				});
			/********************* REGISTER PORTLET CLICK HANDLER  ****************/
			return;
	});
	portletClickHandler = function( event ) {
		$.ajax({
			url:"notes/" + event.prop('id'),
			dataType:"JSON",
			statusCode:{
				403:redirectLogin
			}
		})
		.success(function(data) {
			$("#content").html(data[0]);
			// set the submithandler for the buttons Edit uand Delete
			submitHandler = function( event ) {
				// which action been selected?
				action = $("#formular").find("input[type=submit]:focus");
				if (action.prop('name') == 'edit') {
					// place the current Data into the input fields
					
					/************* EDIT *************/
					$.ajax({
							url:"forms/notes/" + $("#content").find("input[name='id']").val(),
							type: "GET",
							statusCode:{
								403:redirectLogin
							}
					})
					.done(function(data){
						$("#content").html(data);
					});
					// set the submitHandler 
					submitHandler = function( event){
						event.preventDefault();
						$.ajax({
							url:'notes/' + data[1].id,
							type:"PATCH",
							data:{'title':$("#content").find("input[name='title']").val(),
								  'teaser':$("#content").find("textarea[name='teaser']").val(),
								  'note' :$("#content").find("textarea[name='note']").val()} ,
							statusCode:{
								403:redirectLogin
							}
						})
						// on success print it on the page
						.success(function( result ){
							message("<strong>Erfolg!</strong><br/>Änderungen erfolgreich gespeichert.",true,"#content");
							
							
						})
						// on fail give a response
						.fail( function() {
							message("<strong>Die Änderungen konnten nicht gespeichert werden.",false,"#content");
						});
					}
					
					
					/************* EDIT *************/
					/************* DELETE *************/
				} else {
					// Delete the note from the Database
					$.ajax({
						url:'notes/' + data[1].id,
						type:'DELETE',
						statusCode:{
							403:redirectLogin
						}
					})
						// On success print it to the page
					.success(function(){
						message("<strong>Erfolg!</strong><br/>Notiz erfolgreich gelöscht.",true,"#content");
						
					})
					// something failed. Print notice to page.
					.fail( function() {
						message("<h3>Notiz konnte nicht gelöscht werden.</h3>",false,"#content");
					});
				}					
					/************* DELETE *************/
			}
			
		});
	}
	
}
/********************  NOTES ***************/


/********************  CONTACTS ***************/

function contacts() {
	contentWindow = $("#content");
	// cleanOut old stuff
	$("#content > * ").unbind();
	//contentWindow.html("");
	
	$("#buttonNeu").show();
	newButtonHandler = function() {
		// load the input form to enter a new contact
		$.ajax({
			url:'forms/contacts',
			type: 'GET',
			statusCode:{
				403:redirectLogin
			}
		}).done(function( data ){
			$("#content").html( data );
		});
		
		// set the submitHandler 
		submitHandler = function( event){
			event.preventDefault();
			first_name = $("#content").find("input[name='first_name']").val();
			last_name =  $("#content").find("input[name='last_name']").val();
			title = first_name + " " + last_name;
			$.ajax({
				url:'contacts',
				data:{ 'first_name':first_name,
						'last_name':last_name,
						'mail_adress':$("#content").find("input[name='mail_adress']").val(),
						'phone':$("#content").find("input[name='phone']").val(),
						'company':$("#content").find("input[name='company']").val(),
						'note' :$("#content").find("textarea[name='note']").val()
							},
				statusCode:{
					403:redirectLogin
				}
				
			})
			// on success print it on the page
			.success(function( result ){
				message("Kontakt erfolgreich erstellt.",true,"#content");
			})
			// on fail give a response
			.fail( function(data) {
				message("Kontakt konnte nicht erstellt werden.",false,"#content");
			});
		}
	}
	// Add frames for subcontent
	contentWindow.html("<div class = 'row'><div class = 'panel-body col-md-3' id = 'items'></div><div class = 'panel-body col-md-9' id = 'contacts'></div></div>");
	$("#items").append("<ul class='nav nav-pills nav-stacked' id= 'items'></ul>");
	// load the item list 
	$.ajax({
		url:'contacts',
		dataType:"JSON",
		statusCode:{
			403:redirectLogin
		}
	})
	.success(function(data) {
		fillItemList( data );		
	});
	
	// define the action to be done on click event on an item
	//itemClickHandler = 
	$("#items").click(function( event ) {
		//console.info($(event.target).closest("li").prop("id"));
		
		// set clicked item to active
		swapActiveItem($(event.target).closest("li"));
		
		// load data of the the selected note
		$.ajax({
			url:"contacts/" + $(event.target).closest("li").prop("id"),
			dataType:"JSON",
			statusCode:{
				403:redirectLogin
			}
		})
		.success(function(data,status) {
				$("#contacts").html(data[0]);
				// set the submithandler for the buttons Edit uand Delete
				submitHandler = function( event ) {
					// which action been selected?
					action = $("#formular").find("input[type=submit]:focus");
					// ************* EDIT ********************
					if (action.prop('name') == 'edit') {
						
						$.ajax({
							url:'forms/contacts/' + data[1].id,
							type: 'GET'
						}).done(function( data ){
							$("#contacts").html( data );
						});
						// set the submitHandler 
						submitHandler = function( event){
							event.preventDefault();
							
							$.ajax({
								url:'contacts/' + data[1].id,
								type:"PATCH",
								data:{'first_name':$("#content").find("input[name='first_name']").val(),
									  'last_name':$("#content").find("input[name='last_name']").val(),
									  'mail_adress':$("#content").find("input[name='mail_adress']").val(),
									  'phone':$("#content").find("input[name='phone']").val(),
									  'company':$("#content").find("input[name='company']").val(),
									  'notes' :$("#content").find("textarea[name='notes']").val()},
								statusCode:{
									403:redirectLogin
								}
							})
							// on success print it on the page
							.success(function( result ){
								// update the itemlist
								first_name = $("#content").find("input[name='first_name']").val();
								last_name =  $("#content").find("input[name='last_name']").val();
								$("#items [id='" + data[1].id + "'] > a").html(first_name + " " + last_name);
								message("<strong>Erfolg!</strong><br/>Änderungen erfolgreich gespeichert.",true,"#contacts");
							})
							// on fail give a response
							.fail( function() {
								message("Die Änderungen konnten nicht gespeichert werden.",false,"#contacts");
							});
						}
						// ************* EDIT ********************
						// ************* DELETE ********************
					} else {
						
						// Delete the contacts from the Database
						$.ajax({
							url:'contacts/' + data[1].id,
							type:'DELETE',
							statusCode:{
								403:redirectLogin
							}
						})
							// On success print it to the page
						.success(function(){
							$("#items > ul [id='" + data[1].id + "']").remove();
							message("<strong>Erfolg!</strong><br/>Kontakt erfolgreich gelöscht.",true,"#contacts");
						})
						// something failed. Print notice to page.
						.fail( function() {
							message("Kontakt konnte nicht gelöscht werden.",false,"#contacts");
						});
					}					
						// ************* DELETE ********************
				}
			
		});
	});

	// Default message when the contacts page is initialized
	message("Bitte wählen Sie einen Kontakt aus der Liste aus.",true,"#contacts");
	
	
	
	
}

/********************  CONTACTS ***************/
/********************  TASKS ***************/
function appointments() {
	
	//$("#content").html("Aufgaben-Manager Unser Office soll die Möglichkeit besitzen eine Aufgabe zu erstellen, welche bearbeitet werden muss. Für die Bearbeitung der Aufgabe steht ein Timer zur Verfügung. Beginnt man mit der Aufgabe, dann kann man die Uhr starten, am Ende der Aufgabe die Uhr stoppen und eine Notiz zur Aufgabe hinterlegen. Unser Aufgabenmanager soll daher die folgenden Möglichkeiten für den User zur Verfügung stellen:<ul><li>Aufgaben anlegen</li><li> Aufgaben löschen</li><li> Aufgaben bearbeiten</li><li> Timer für Aufgaben</li><li> Ein Beschreibungsfeld mit Details zur Aufgabe</li><li> Eine detaillierte Ansicht der Aufgabe</li><ul>");	$("#buttonNeu").show();
	

	
	/************************/
	$("#buttonNeu").show();
	// define the actions for the new Button
	newButtonHandler = function() {
		
		$.ajax({
				url:"forms/tasks",
				type: "GET",
				statusCode:{
					403:redirectLogin
				}
		})
		.success(function(data) {
			$("#content").html(data);
			attachDatePicker( $("#content").find("input[name='deadline']"));
			// set the submitHandler 
		});
		
		submitHandler = function( event){
			event.preventDefault();
			$.ajax({
				url:'tasks',
				data:{'title': $("#content").find("input[name='title']").val(),
							'description' :$("#content").find("textarea[name='description']").val(),
							'deadline' :$("#content").find("input[id='altdeadline']").val(),
							'isActive' :$("#content").find("input[name='isActive']").val()
							},
				statusCode:{
					403:redirectLogin
				}
			})		
			// on success print it on the page
			.success(function( result ){
				message( "<strong>Erfolg!</strong><br/>Aufgabe erfolgreich erstellt.", true ,"#content");
				
			})
			// on fail give a response
			.fail( function(data) {
				message( "Aufgabe konnte nicht erstellt werden.", false ,"#content");
			});
		}
	}
	$.ajax({
		url:"tasks",
		dataType:"JSON",
		statusCode:{
			403:redirectLogin
		}
	})
	.success(function(data,status) {
			$("#content").html("");
			// load the tasks into the content window
			$.each(data,function(key, value){
				//console.info(value);
				$("#content").append(value);
			});
			submitHandler = function( event){
				event.preventDefault();
				
				
				action = $("#formular").find("button[type=submit]:focus");
				task =  action.closest("div[class*=well]");
				id = task.attr("name");
				// start or stop the timer of the task
				console.info(" submitted " + action.prop('name'));
				if (action.prop('name') == 'play' || action.prop('name') == 'stop') {
					
					$.ajax({
						url:"tasks/" + id + "/status",
						type: "PATCH",
						dataType:"JSON",
						statusCode:{
							403:redirectLogin
						}
					})
					.success(function(data){
						// swap the status icon 
						if (action.prop('name') == 'play'){
							toAdd = "stop";
							toRemove = "play";
							titleBack  = "panel-warning";
						} else {
							toAdd = "play";
							toRemove = "stop";
							titleBack  = "panel-primary";
						}
						// add and remove classes to fit the status of the task
						action.removeClass("glyphicon-" + toRemove);
						action.addClass("glyphicon-" + toAdd);
						action.prop("name",toAdd);
						titlePanel = task.find("div[name='title']");
						titlePanel.removeClass("panel-primary panel-warning");
						titlePanel.addClass(titleBack);
						
						// set the time into the timer field to show it on the page
						action.closest("div").find('span').html(data['total']);

					});
					// open the edit window
				} else if (action.prop('name') == 'edit') {
					$.ajax({
						url:"forms/tasks/" + id ,
						type: "GET",
						dataType:"HTML",
						statusCode:{
							403:redirectLogin
						}
					})
					.done(function(data){
						$("#content").html(data);
						attachDatePicker( $("#content").find("input[name='deadline']"));
						submitHandler = function( event){
							event.preventDefault();
							$.ajax({
									url:"tasks/" + $("#content").find("input[name='id']").val(),
									type:"PATCH",
									data:{	'id': $("#content").find("input[name='id']").val(),
											'title': $("#content").find("input[name='title']").val(),
											'description' :$("#content").find("textarea[name='description']").val(),
											'deadline' :$("#content").find("input[id='altdeadline']").val(),
											'isActive' :$("#content").find("input[name='isActive']").val()
											},
									statusCode:{
										403:redirectLogin
									}		
											
							})
						
							// on success print it on the page
							.success(function(){
								message( "<strong>Erfolg!</strong><br/>Änderungen gespeichert.", true ,"#content");
								
							})
							// on fail give a response
							.fail( function() {
								message( "Änderungen konnten nicht gespeichert werden.", false ,"#content");
							});
						}
					});
					console.info( "edit clicked" );
					// delete the task
				} else if (action.prop('name') == 'trash') {
					$.ajax({
						url:"tasks/" + id,
						type: "DELETE",
						statusCode:{
							403:redirectLogin
						}
					})
					.done(function() {
						action.closest("div[class*=well]").remove();
					});
				}					
				//console.info( action );
			}
		
	});
	return;
	
}
/********************  TASKS ***************/
/********************  CALENDAR ***************/

function calendar() {
	
	
	//$("#content").html("<div>Dem User soll ein Kalender zur Verfügung gestellt werden. Im Internet gibt es zahlreiche fertige Kalender, welche nur noch angepasst werden müssen. Beispielhaft soll hier http://fullcalendar.io genannt werden, wobei dieser Kalender nicht unbedingt genutzt werden muss. Im Kalender sollen Einträge erstellt, bearbeitet und gelöscht werden. Beim Klick auf einen Eintrag sollen Details angezeigt werden. Es wird nur eine Übersicht für den Monat benötigt!</div>");
	// load the calendar into the content frame
	$("#content").html("<div id = 'calendar'></div>");
	$("#buttonNeu").show();
	// define the action on new Button event
	newButtonHandler = function() {
		$.ajax({
			url:"forms/events",
			type:"GET",
			dataType:"html",
			statusCode:{
				403:redirectLogin
			}
		})
		.success(function( data ){
			$("#content").html( data );
			attachDatePicker( $("#content").find("input[name='startPicker']"));
			attachDatePicker( $("#content").find("input[name='endPicker']"));
		});
	}
	// define the submithandling 
	submitHandler = function( event ) {
		console.info("submit calendar");
		$.ajax({
			url:"events",
			type:"POST",
			data: {"title":$("#content").find("input[name='title']").val(),
					"description":$("#content").find("textarea[name='description']").val(),
					"start":$("#altstartPicker").val(),			
					"end":$("#altendPicker").val()},
			statusCode:{
				403:redirectLogin
			}					
		})
		.success(function(){
			$("span[name='calendar']").trigger("click");
		})
		.fail(function (data){
			console.info(data.responseText);
		});
	}
	
	$('#calendar').fullCalendar({
		
		// put your options and callbacks here
		dayClick: function() {
			console.info('a day has been clicked!');
		},
		
		height:550,
		lang: 'de',
		buttonIcons: false, // show the prev/next text
		weekNumbers: true,
		editable: true,
		eventLimit: true, // allow "more" link when too many events
		eventSources: [
			{
				url:"events",
				color: 'yellow',    
				textColor: 'black'  
				
			}
		],
		// when an event been clicked load the edit window
		eventClick: function(calEvent, jsEvent, view) {
			$.ajax({
				url:"events/" + calEvent.id,
				type:"GET",
				statusCode:{
					403:redirectLogin
				}
			})
			.success(function( data ){
				
				$("#content").html(data);				
				
				// set the submitHandler to PATCH
				submitHandler = function( event ) {
					
					
					// which action been selected?
					action = $("#formular").find("input[type=submit]:focus");
					// ************* EDIT ********************
					if (action.prop('name') == 'edit') {
						$.ajax({
							url:"forms/events/" + $("#content").find("input[name='id']").val(),
							type:"GET",
							data: {	"title":$("#content").find("input[name='title']").val(),
									"description":$("#content").find("textarea[name='description']").val(),
									"start":$("#altstartDate").val(),			
									"end":$("#altendDate").val()},
							statusCode:{
								403:redirectLogin
							},									
						})
						.success(function( data ){
							$("#content").html(data);
							// attach the datepicker to the date picker fields within the form
							attachDatePicker( $("#content").find("input[name='startPicker']"));
							attachDatePicker( $("#content").find("input[name='endPicker']"));
							console.info("load the edit window");
							
							// update the submitHandler
							submitHandler = function( event ) {
								$.ajax({
								url:"events/" + $("#content").find("input[name='id']").val(),
								type:"PATCH",
								data: {	"title":$("#content").find("input[name='title']").val(),
										"description":$("#content").find("textarea[name='description']").val(),
										"start":$("#altstartPicker").val(),			
										"end":$("#altendPicker").val()},
										statusCode:{
											403:redirectLogin
										}										
								})
								.success(function(){
									message("<strong>Erfolg!</strong><br>Änderungen gespeichert.",true,"#content");
									setTimeout(function() {
										$("span[name='calendar']").trigger("click");
										
									},500);
								})
								.fail(function() {
									message("<strong></strong><br>Änderungen konnten nicht gespeichert werden.",false,"#content");
								});
							}
						});
					// ************* DELETE ********************/
					} else {
						$.ajax({
							url:"events/" + $("#content").find("input[name='id']").val(),
							type:"DELETE",
							statusCode:{
								403:redirectLogin
							}
						})
						.success(function(){
							$("span[name='calendar']").trigger("click");
						});
					}
				}
				
			})
			.fail(function() {
					message( "Ereignis konnte nicht gefunden werden.", false ,"#content");
			});
		}
	});
	
}
/********************  CALENDAR ***************/
/********************  OVERVIEW ***************/
function overview() {
	
	//$("#content").html("Übersicht  Nach dem Login bekommt der User eine Übersicht angezeigt. In dieser Übersicht sollen die zuletzt erstellten Kontakt, Notizen und Aufgaben angezeigt werden. Zusätzlich sollen aus dem Kalender die Einträge angezeigt werden, welche bald fällig werden.");
	//load content for the overview
	$.ajax({
		url:"forms/overview",
		statusCode:{
			403:redirectLogin
		}
	})
	.success(function(data){
		$("#content").html( data );
	});
}
/********************  OVERVIEW ***************/
/********************  REGISTRATION ***********/
function registration() {
	
	$("#footer").html("");
	// load the registration form 
	$.ajax({
		url:'forms/users/register',
		type:"GET"
	})
	.success(function(data) {
		$("#content").html(data);
		// set the submithandler to registration
		submitHandler = function() {
			formular = $("#content");
			formData = formular.find("input[type!='radio'],select,input[type='radio']:checked");
			passwords = formular.find("input[type='password']");
			if ($(passwords[0]).val() == $(passwords[1]).val()) {
				password = $(passwords[0]).val();
				$.ajax({
					url:"users",
					type:"POST",
					data: formData
				})
				.success(function(data){
					$("#footer").html("");
					message( "Registrierung Erfolgreich abgeschlossen. Sie können sich nun mit Ihren Benutzerdaten einloggen.", true ,"#content");
					// redirect to the overview site
					setTimeout(function() {
						$("span[name='overview']").trigger("click");
					},500);
				})
				.fail(function(data){
					console.info(data.responseText);
					message( "Die Registrierung ist fehlgeschlagen. " + data.responseText, false ,"#footer");
				});
				return;
			}
			message( "Die eingegebenen Passwörter stimmen nicht überein.", false ,"#footer");
			
			
		}
		
	});
};

/********************  REGISTRATION ***********/
/********************  LOGOUT       ***********/
function logout() {
	
	$("#footer").html("logout");
	// load the login form 
	$.ajax({
		url:'users/session',
		type:"DELETE",
		statusCode:{
			403:redirectLogin
		}
	})
	.done(function(data) {
		message("Sie wurden vom System abgemeldet.",true,"#content");
		setTimeout(function() {
			login();
		},500);
		submitHandler = function() {
			
		}
	});
}
/********************  LOGOUT       ***********/
/********************  LOGIN        ***********/
function login() {
	$("#logout").hide();
	$("#buttonNeu").parent().parent().hide();
	$("#footer").html("");
	// load the login form 
	$.get('forms/users/login',function(data) {
			$("#content").html(data);
			submitHandler = function() {
				$.ajax({url:'users/session',
						type:"POST",
						data:{'username':$("#content").find("input[name='username']").val(),
						'password':$("#content").find("input[name='userPW']").val()},
						statusCode:{
							403:redirectLogin
						}
				})
				.success(function() {
					$("#logout").show();
					$("#lastLogin").html(Cookies.get("lastLogin"));
					Cookies.set("lastLogin",new Date());
					message( "Login erfolgreich. Sie werden in wenigen Sekunden auf die Übersicht weitergeleitet.", true ,"#content");
					// cleanup footer
					$("#footer").html("");
					setTimeout(function() {
						$("span[name='overview']").trigger("click");
					},500);
				})
				.fail(function(data){
					message( data.responseText, false ,"#footer");
				});
			};
		});
}
/********************  LOGIN        ***********/
/********************  FORBIDDEN EVENT ********/
function redirectLogin() {
		alert("redirect Login");
		login();
	
}


/********************  FORBIDDEN EVENT ********/


$(document).ready(function(){
	$("#buttonNeu").parent().parent().hide();
	$("#logout").hide();
    $("#test").click(function() {
		//login();
		$.ajax({
			url:'notes',
			statusCode:{
				403:redirectLogin
			}
		});
			//Cookies.set('portlets',new Array("1","1","2","1","0","2","0"));
			//console.info(Cookies.get('portlets'));
	});
	login();
	/***************** SET DEFAULT FOR DATEPICKER ******************/
	$.datepicker.setDefaults( $.datepicker.regional[ "de" ] );
			
	/********************* REGISTER FORM SUBMIT HANDLER ****************/
	$("#formular").submit(function(event){
		console.info("form submit");
		event.preventDefault();
		submitHandler(event);
	});
	/********************* REGISTER FORM SUBMIT HANDLER ****************/
	/********************* REGISTER NEW BUTTON HANDLER  ****************/
	$("#buttonNeu").click(function() {
		newButtonHandler();
	});
	/********************* REGISTER NEW BUTTON HANDLER  ****************/
	/********************* REGISTER LOGOUT FUNCTION  ****************/
	$("#logout").find("span[class^='btn']").click(function() {
		console.info("logout");
		logout();
	});
	/********************* REGISTER LOGOUT FUNCTION  ****************/

	
	
	/********************* REGISTER NAVI BUTTON HANDLER  ****************/
	$("#selection_tabs > span").click(function( event ){
		navigationHandler( event.target  );
	});
	/********************* REGISTER NAVI BUTTON HANDLER  ****************/
	
});
