<?php
function isValidPhoneNumber($phone_number, $customer_id, $api_key) {
    $api_url = "https://rest-ww.telesign.com/v1/phoneid/$phone_number";
    
    $headers = [
        'Accept: application/json',
        'Content-Type: application/json'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "{}");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_USERPWD, "$customer_id:$api_key");
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
	//var_dump($response);
    if ($http_code !== 200) {
        return false; // API request failed
    }
    
    $data = json_decode($response, true);
    if (!isset($data['phone_type'])) {
        return false; // Unexpected API response
    }
    
    $valid_types = ["FIXED_LINE", "MOBILE", "VALID"];
    return in_array(strtoupper($data['phone_type']['description']), $valid_types);
}

// Usage example
$phone_number = "12503728822"; // Replace with actual phone number
$customer_id = "0D363EC6-A834-44E5-8EE6-EE801F7505AD";
$api_key = "EpQwgbJtj6iuZZgwPgDi7AgyQY8/3goTqQFhjoomPeTgT91kLlqgGtVI9LZ57ZavNllVsndQHD4iCFRGtAFxSg==";
$result = isValidPhoneNumber($phone_number, $customer_id, $api_key);
var_dump($result);