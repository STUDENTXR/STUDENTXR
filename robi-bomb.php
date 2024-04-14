<?php

$num = $_GET["msisdn"];

if (strlen($num) !== 11 || !ctype_digit($num)) {
    echo json_encode(["error" => "Invalid MSISDN"]);
    exit; // Stop execution if MSISDN is invalid
}

// Check if the MSISDN starts with "018" or "016"
if (substr($num, 0, 3) !== "018" && substr($num, 0, 3) !== "016") {
    echo json_encode(["error" => "Invalid Operator. Please use Robi/Airtel number."]);
    exit; // Stop execution if the operator is invalid
}

$numm = substr($num, 1);

$url = 'https://www.engagewinner.com/api/users/01860744898/registration_redirect/?amount=30&description=Engage+OnDemand&format=json&isSubscription=false&phone_number=01860744898&subscriptionDuration=11&subscriptionID=Engage+OnDemand&subscriptionName=Engage+OnDemand';

$headers = array(
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
    'Accept-Language: en-GB,en-US;q=0.9,en;q=0.8',
    'Cache-Control: max-age=0',
    'Connection: keep-alive',
    'Cookie: csrftoken=8a4RBEeAPcF6213ekUPjYkbcHo5ciYWO2Ctp48sQpQpYW0comXosqIFX4m8dZbhX',
    'Sec-Fetch-Dest: document',
    'Sec-Fetch-Mode: navigate',
    'Sec-Fetch-Site: none',
    'Sec-Fetch-User: ?1',
    'Upgrade-Insecure-Requests: 1',
    'User-Agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36',
    'sec-ch-ua: "Not_A Brand";v="8", "Chromium";v="120"',
    'sec-ch-ua-mobile: ?1',
    'sec-ch-ua-platform: "Android"'
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL certificate verification
$response = curl_exec($ch);
curl_close($ch);
$valid = json_decode($response, true);

$Token =  $valid["aocToken"];

$url = "https://robi.mife-aoc.com/api/robi/aoc/ask/$Token";

$headers = array(
    'authority: robi.mife-aoc.com',
    'content-type: application/x-www-form-urlencoded; charset=UTF-8',
    'user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36',
    'x-requested-with: XMLHttpRequest'
);

$data = array(
    'msisdn' => $numm
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Disable SSL verification
$response = curl_exec($ch);
curl_close($ch);

echo $response;

?>
