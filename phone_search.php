<?php
//search active ad standalone page by phone number
//function to be added to homepage 
//created by Angela Lee on Oct-08-2015
//Search for a listing by phone number
//returns the listing ID and append to end of url
//if url convention changes for standalone pages, must change the url redirect address to match
//will perform data validation so that user can enter (, ), -, spaces or other characters
//and search will still perform, as long as it is a 10 digit phone number and it exists in the 
//acerenting.listing database.



//check if form has been submitted, otherwise ask to submit a number
if(isset($_POST['submit'])){

	$phone_num = "";
	$url="";

	//Do validation to make sure it is a phone number entered
	//and will change format of phone number to match database record
	//is phone number has brackets, spaces, or dashes, will remove
	

	if($_SERVER["REQUEST_METHOD"] == "POST"){
	//set variable called phone_num to the value user entered
		$phone_num = preg_replace('/[^0-9]/','',$_POST["phone_num"]);
		if(strlen($phone_num) != 10) {
			echo "<p>Please enter a 10-digit phone number<p>";
			//should not continue if phone number is not 10 digits
		}
	//make sql query to find record with desired phone number
	require_once("cfg/global.inc.php");
	require_once("lib/db.inc.php");
	$db = new db();
	$sql = "SELECT *       
				FROM listing
				
				WHERE phone_number = ".$phone_num      
			;
	//what if it cannot be found?
	
	
	//$result stores result from the sql query
	if(!($result = mysql_query($sql))){
		echo mysql_error().$sql;
		return $result;
	}else{
	$row = mysql_fetch_assoc($result);
	$id = $row['id'];
	
	//select data from query into the new url
	//on submit, redirect to link
	
		$url='http://www.acerenting.com//view.php?listing_id='.$id;
	//redirect to the new page using url
		echo "<br>phone number searched: ".$phone_num;
		echo "<br>sql statement ".$sql;
		echo "<br>rid retrieved ".$id;
		echo "<br>new url ".$url;
		header('location: '.$url);
	//close connection when done
		
	}


	}

}


else{
echo "<p>Please enter a phone number to search</p>";
}

?>
