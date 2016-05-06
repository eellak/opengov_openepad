<?php

// MySQL Connection
include('global.php');
initialize();

if($_REQUEST['codelevel1'])
{

	
	$code1=$_REQUEST['codelevel1'];
	$code2=$_REQUEST['codelevel2'];
	$term=$_REQUEST['term'];
	$term= mb_convert_encoding($term, "UTF-8","UTF-8, ISO-8859-7" ); 

	$dataArray = array(); 
	$tempArray = array();
	
	//read config data
	$regions_parentid=$config[ 'regions_parentid' ] ;
	$ministries_firstid=$config[ 'ministries_firstid' ] ;
	$ministries_lastid=$config[ 'ministries_lastid' ] ;
	
	
	
	//choose sql query based on code1 
	switch ($code1) {
		case "reasons_level1":
			$sql_query="SELECT id,name  FROM dict_reasons_level1";
			break;
	    case "reasons_level2":
	    	$sql_query="SELECT id,name FROM dict_reasons_level2 where parentid=".$code2;
	        break;
	    case "ministries":
	        $sql_query="SELECT pb_id as id,name  FROM dict_foreis WHERE pb_id Between ".$ministries_firstid." and ".$ministries_lastid; 
	        break;
	    case "regions":
	    	$sql_query="SELECT pb_id as id,name FROM dict_foreis where pb_supervisor_id=".$regions_parentid;
	        break;

  case "getmunname":
            $sql_query="SELECT pb_id as id, concat( (select dict_foreis2.name from dict_foreis as dict_foreis2 where dict_foreis2.pb_id=dict_foreis.pb_supervisor_id),' - ',name) as name FROM dict_foreis WHERE pb_id=".$code2;
            break; 

  case "municipalities":
            $sql_query="SELECT pb_id as id,name from dict_foreis";
           
            if (isset($code2)) $sql_query.=" WHERE pb_id Between 6000 and 6500 AND pb_supervisor_id=".$code2;
            else $sql_query.=" WHERE pb_id Between 6000 and 6500";
           
            if (isset($term)) $sql_query.=" AND name LIKE '%".$term."%'";
            break;
     
	        
    case "publicservices": //Δημόσιες Υπηρεσίες
            $sql_query="SELECT code as id,description as name from dict_dhmosiakthria";
           
//            if (isset($code2)) 
//            {   
//            	$delimeter=" ";
//            	$pieces = explode($delimeter, $code2);
//            	
//            	$municipality=$pieces[1];
//            	
//            	$sql_query.=" WHERE municipality=".$code2;
//            }
//            else $sql_query.=" WHERE pb_id Between 6000 and 6500";
           
            if (isset($term)) $sql_query.=" WHERE description LIKE '%".$term."%'";
            break;
            
	}

	 	$res = mysqli_query($GLOBALS["___mysqli_ston"],  $sql_query );
		
		while  ( $row_array = mysqli_fetch_assoc( $res ) ) 
			   {
			   		$tempArray =$row_array;
		             array_push($dataArray, $tempArray);
		        } //end while

		$jsonData = json_encode($dataArray); //echo array in json format
		if (isset($_REQUEST['callback']))
		{
	      echo $_REQUEST['callback'] . '(' . $jsonData . ');';
        }
		else
		{
		  echo $jsonData;
		}
	   
} 
else
{
	echo json_encode('0'); //error 
}

?>