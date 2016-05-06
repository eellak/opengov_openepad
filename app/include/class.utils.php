<?php
class openPadUtils {
   public static $diavgeiaServiceUrl = 'http://83.212.121.173/drasi3/diavgeia_data/get_dict.php'; /* config path */

   public static function DownloadUrl($Url)
   {
      if(!function_exists('curl_init'))
      {
         die('CURL is not installed!');
      }
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $Url);
      curl_setopt($ch, CURLOPT_REFERER, "http://dev.gov.gr/");
      curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
      curl_setopt($ch, CURLOPT_HEADER, 0);
	  curl_setopt($ch, CURLOPT_USERPWD, "if:if"); 
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, 120);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      $output = curl_exec($ch);
      curl_close($ch);
      return $output;
   }
   public static function getNameFrompb_id($pb_id) {
        if ($pb_id==0)
		{
		return "Δεν έχει δηλωθεί Δήμος";
		}
		else
		{
         $content=json_decode(openPadUtils::DownloadUrl(openPadUtils::$diavgeiaServiceUrl.'?codelevel1=getmunname&codelevel2='.$pb_id),true);
		 return $content[0]['name']; 
		}
   }
   public static function getTranslation($type,$in) {
         switch ($type)
		 {
		   case "status":	
			$translationArray=array
			(
				"open"=>"Ανοιχτό",
				"overdue"=>"Εκπρόθεσμο",
				"closed"=>"Κλειστό"
			);  
			break;
		   case "status_plural":	
			$translationArray=array
			(
				"open"=>"Ανοιχτά",
				"overdue"=>"Εκπρόθεσμα",
				"closed"=>"Κλειστά"
			);  
			break;
			
		   case "other":	
			$translationArray=array
			(
				"open"=>"Ανοιχτό2"
			);
			break; 
         } 		 
        return $translationArray[strtolower($in)];
   }


 public static function getDescription($type,$in) {
         switch ($type)
		 {
		   case "publish":	
			$translationArray=array
			(
				"0"=>"Μη Δημοσιεύσιμο",
				"1"=>"Δημοσιεύσιμο (Απαιτείται Έγκριση)",
				"2"=>"Δημοσιεύσιμο (Εγκεκριμένο)",
				"3"=>"Δημοσιεύσιμο (Αππορίφθηκε)"
			);  
			break;
		   
         } 		 
        return $translationArray[strtolower((string)$in)];
   }
}

//echo openPadUtils::getNameFrompb_id('6010');
//echo openPadUtils::getTranslation("other","open");

?>
