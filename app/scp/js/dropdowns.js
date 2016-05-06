//<!-- Javascript methods for citizenform -->	
		
	function prepareform(topicId,topicId2) {

			//1. Load dropdowns

			
			load_dropdown('#topicId','reasons_level1','',topicId); //Λόγος Επικοινωνίας Επίπεδο 2
			load_dropdown('#topicId2','reasons_level2',topicId,topicId2); //Λόγος Επικοινωνίας Επίπεδο 2
			
			//2. Attach change event to dropdowns
					


				
				//2.3 idiotita change event handler		
				//adjust display data based on idiotita
				$('#topicId').change(function() {

					var selected_topicid_lelvel1=$("#topicId").val().toString();
					
					load_dropdown('#topicId2','reasons_level2',selected_topicid_lelvel1,''); //Λόγος Επικοινωνίας Επίπεδο 2
	    		
				});
				
				
			//3. Style static dropdowns using selectmenu plugin

			$('#topicId,#topicId2').selectmenu({style:'dropdown',menuWidth: 250});





	          	
		} //function prepareForm();


	function load_dropdown(elementselector,codelevel1 , codelevel2,selectedItem) {

           var element=$(elementselector);

           var baseurl="http://83.212.121.173/drasi3/diavgeia_data/get_dict.php"; /* config path */
		   var serviceurl=baseurl+"?codelevel1="+codelevel1+"&codelevel2="+codelevel2+"&callback=?";
         
           $.getJSON(serviceurl,
        		    function(data){

        			           	element.empty();
	           	
					       		for(var i=0; i < data.length; i++) {
								
					           		if (data[i].id==selectedItem)
									{
					           		element.append("<option value=\"" +data[i].id  +"\" selected >" + data[i].name + "</option>"); 
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

