<?php
/* This code is updated as answer for question 1 for BID13 employment requirement
* I have not made a lot of changes as the question specifically indicated to update only as necessary
* I treat this as updating existing code scenario similar to what I do on my previous role
*
* Updated by 
* 
* Mervin Separa
* Winnipeg MB Canada
* 204 479 5461
* mervsepara@hotmail.com
* www.linkedin.com/in/mervinsepara
*/


function isValidPhoneNumber($phone_number, $customer_id, $api_key) {
    $api_url = "https://rest-ww.telesign.com/v1/phoneid/$phone_number";
    
    $headers = [
        'Accept: application/json', // curl sample indicated that these headers are required
        'Content-Type: application/json'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1); // curl sample indicated that these options are required
	curl_setopt($ch, CURLOPT_POSTFIELDS, "{}"); // curl sample indicated that these options are required
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_USERPWD, "$customer_id:$api_key"); //this was added as per the CURL sample where the user password option is used
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
	
	var_dump($response); //this was added for debugging. trial accounts can only use verified phone number. any other numbers regardless whether they are valid or not will be considered as 'Unverified phone number requested for trial account'
	
    if ($http_code !== 200) {
        return false; // API request failed
    }
    
    $data = json_decode($response, true);
    if (!isset($data['phone_type'])) { // this was adjusted as the API results shows JSON header for "phone type"
        return false; // Unexpected API response
    }
    
    $valid_types = ["FIXED_LINE", "MOBILE", "VALID"];
    return in_array(strtoupper($data['phone_type']['description']), $valid_types); // this was adjusted as the API results shows JSON header for "phone type" and "description"
}

// Usage example
$phone_number = "12044795461"; // this is using my personal phone number as this is the number used for my trial account
$customer_id = "0D363EC6-A834-44E5-8EE6-EE801F7505AD"; // this is my real customer id for my trial account
$api_key = "EpQwgbJtj6iuZZgwPgDi7AgyQY8/3goTqQFhjoomPeTgT91kLlqgGtVI9LZ57ZavNllVsndQHD4iCFRGtAFxSg=="; // this is my real customer id for my trial account
$result = isValidPhoneNumber($phone_number, $customer_id, $api_key);
var_dump($result);