//<!-- Javascript methods for citizenform -->	
		
	function prepareform() {

			//1. Load dropdowns
			load_dropdown('#deptId','ministries',''); //Υπουργεία
			
			load_dropdown('#topicId','reasons_level1','','2'); //Λόγος Επικοινωνίας Επίπεδο 1
			load_dropdown('#topicId2','reasons_level2',"3"); //Λόγος Επικοινωνίας Επίπεδο 2
			
		
			//2. Attach change event to dropdowns
					
				//2.1 communication_type change event handler			
				$('#communication_type').change(function() {

					var ctype=$('#communication_type').val(); //communication type
					
					switch (ctype)
					{
					case "1":
						$('#pnl_phone').hide();
						$('#pnl_address').hide();
						  break;
						case "2":
							$('#pnl_phone').show();
							$('#pnl_address').hide();
							 break;
						case "3":
							$('#pnl_address').show();
							$('#pnl_phone').hide();
							 break;
					
						default:
						  
					}
					
					
					});
				
				//2.2 idiotita change event handler		
				//adjust display data based on idiotita
				$('#idiotita').change(function() {

					
	    		if ($("#idiotita").val()=="3")  //if Επιχείρηση 
	    		{$("#legalpersondata").show(); $("#physicalpersondata,#demographicdata").hide();  }
	    		else
	    		{$("#legalpersondata").hide(); $("#physicalpersondata,#demographicdata").show(); }
	    		
				});
				
				//2.3 idiotita change event handler		
				//adjust display data based on idiotita
				$('#topicId').change(function() {

					var selected_topicid_lelvel1=$("#topicId").val().toString();
					
					load_dropdown('#topicId2','reasons_level2',selected_topicid_lelvel1); //Λόγος Επικοινωνίας Επίπεδο 2
	    		
				});
				
				
			//3. Style static dropdowns using selectmenu plugin
			$('#sexId,#agerangeId,#educationId').selectmenu({style:'dropdown',menuWidth: 200});	
			$('#idiotita,#topicId,#topicId2').selectmenu({style:'dropdown',menuWidth: 250});
			$('#communication_type').selectmenu({style:'dropdown',menuWidth: 250,
				icons: [
						{find: '.email'},
						{find: '.mobile'},
						{find: '.phone'},
						{find: '.post'}
					]
				});

			
			 //4. Initiate Accordion
			$('a#namedata_toggle').click(function() {
				
		    	var el=$('#namedata_edit');
		    	var el_title=$('#namedata_toggle');
		    	
		    	if (!el.is(":visible")) 
		    		{
		    		el_title.text('Επιθυμώ Ανώνυμη Επικοινωνία');
		    		el_title.toggleClass('show-more');
		    		el_title.toggleClass('show-less');
		    		
		    		
		    		
		    		
		    		el.show(400);
		    		}
		    	else 
		    		{
		    			
		    		
		    		el_title.text('Επιθυμώ Επώνυμη Επικοινωνία');
		    		el_title.toggleClass('show-more');
		    		el_title.toggleClass('show-less');
		    		
		    		//clear filled values (if any)
		    		$("#name,#lastname,#dimos,#legalname").val("");
		    		$("#sexId option:first ,#agerangeId option:first,#educationId option:first").attr("selected", "selected");
		    		
		    		el.hide();
		    		}
		    	
				//$('#namedata_default').hide();
		    	return false;
			});
			   
			//5. set tooltip handler on input focus
			var allInputs = $(":input");
			allInputs.focus(function () {
				var title = $(this).attr("title");
				$('#current_tooltip').text(title);
		        
		    });

		    //6. set focus on first input element
			$(":input:first").focus();

			//7. publish checkbox change handler
	       $("#publish").change(function() {

	    		   if ($(this).attr("checked"))
		    		    $(this).val(1);
	    		   else
		    		   $(this).val(0);
	    		       
	    			    	   
	    	   });
    	   
			//8. Hide elements
			$('#pnl_phone').hide();
			$('#pnl_address').hide();
			$('#legalpersondata').hide();
			
			
			//10. AutoSuggest
  
  		 $("#yphresia,#yphresia_dimos,#dimos").autocomplete({
		            source: function (request, response) {

						var serviceurl;
						//var deptId_element=$("#deptId");
						var deptId_element=document.getElementById("deptId");
						var deptVal=deptId_element.options[deptId_element.selectedIndex].value;
						 if (this.element.context.id=='yphresia') 
							 serviceurl="http://app.diavgeia.gov.gr/diavgeia_data/get_dict.php?codelevel1=publicservices&codelevel2="+deptVal+"&callback=?&term="+request.term;
						 else
							 serviceurl="http://83.212.121.173/drasi3/diavgeia_data/get_dict.php?codelevel1=municipalities&callback=?&term="+request.term; /*config path*/

							
		                $.ajax({
		                    type: "GET",
		                    url: serviceurl,
		                    dataType: "json",
		                    contentType: "application/json; charset=utf-8",
		                    success: function (data) {
			                    
		                        response($.map(data, function (item) {
		                        	
		                            return {
		                            	 label: item.name,
		                                    value: item.id
		                            }
		                        }))
		                    },
		                   
		                    error: function (XMLHttpRequest, textStatus, errorThrown) {
		                        alert(textStatus);
		                    }
		                });
		            },
		            select: function(event, ui) {
			            var el=$("#"+this.id);
			            var el_hid=$("#"+this.id+"_id");
			            
                    	el_hid.val(ui.item.value);
                        el.val(ui.item.label);
                        return false;
                    },
                    keyup: function(event, ui) {
                    	 var el=$("#"+this.id);
 			            var el_hid=$("#"+this.id+"_id");
 			            
 			            
                    	el_hid.val(0);
                        return false;
                    },
		            minLength: 3
		        });
	          	
		} //function prepareForm();


	function load_dropdown(elementselector,codelevel1 , codelevel2, selectedindex) {
           selectedindex = selectedindex || '1';
           var element=$(elementselector);

           var baseurl="http://83.212.121.173/drasi3/diavgeia_data/get_dict.php"; /* config path */
		   var serviceurl=baseurl+"?codelevel1="+codelevel1+"&codelevel2="+codelevel2+"&callback=?";
         
           $.getJSON(serviceurl,
        		    function(data){

        			           	element.empty();
	           	
					       		for(var i=0; i < data.length; i++) {
					           		if (i==selectedindex)
									{
										element.append("<option value=\"" +data[i].id  +"\" selected>" + data[i].name + "</option>"); 
									}
									else
									{
										element.append("<option value=\"" +data[i].id  +"\">" + data[i].name + "</option>"); 
									}
					       			
					       		}
					
					       		element.selectmenu({style:'dropdown',menuWidth: 250});
		     
        		    });
		
        }

    function submitform()
    {
    	  //Do something (e.g validation)		
            form1.submit();
   		          
    }

