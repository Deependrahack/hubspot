<?php

/*
 * push data to hubspot
 */

function push_data_hubspot($formdata) {
    $accesstoken = get_config('local_hubspot', 'hubspot_accesstoken');
    $endpointurl = get_config('local_hubspot', 'hubspot_endpointurl');
    if (!empty($accesstoken) && !empty($endpointurl)) {
        $data = [];
        $data ['properties'] = $formdata;
        $data_string = json_encode($data);
        $curl = new \curl();
        $curl->setHeader(array('Content-type: application/json'));
        $curl->setHeader(array('Accept: application/json', 'Expect:'));
        $curl->setHeader("Authorization: Bearer ". $accesstoken);
        $method = "POST";
        $response = call_user_func_array(array($curl, $method), array($endpointurl, $data_string));
        return json_decode($response);
    }
    return arrya();
}
