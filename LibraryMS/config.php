<?php
// ============================================
// Library Management System - Frontend Configuration
// ============================================

// API Configuration
define('API_BASE_URL', 'http://localhost:8080/api'); // Matches server.servlet.context-path in application.properties

// API Endpoints
define('API_BOOKS', API_BASE_URL . '/books');
define('API_MEMBERS', API_BASE_URL . '/members');
define('API_TRANSACTIONS', API_BASE_URL . '/transactions');

// Session Configuration
session_start();

// Helper function to make API calls
function apiCall($endpoint, $method = 'GET', $data = null) {
    $url = $endpoint;

    $options = array(
        'http' => array(
            'method'        => $method,
            'header'        => "Content-Type: application/json\r\nAccept: application/json\r\n",
            'timeout'       => 10,
            'ignore_errors' => true,  // FIX: capture 4xx/5xx responses instead of returning false
        )
    );

    if ($method !== 'GET' && $data !== null) {
        $options['http']['content'] = json_encode($data);
    }

    // FIX: DELETE requests must not carry a body
    if ($method === 'DELETE') {
        unset($options['http']['content']);
    }

    $context  = stream_context_create($options);
    $response = @file_get_contents($url, false, $context);

    // FIX: false means a network-level failure (host unreachable / backend not started)
    if ($response === false) {
        return array('error' => 'Unable to connect to API. Make sure the Java backend is running on http://localhost:8080');
    }

    // FIX: DELETE / 204 No-Content responses return an empty body – treat as success
    if (trim($response) === '') {
        return array('success' => true);
    }

    $decoded = json_decode($response, true);

    // FIX: surface JSON parse errors instead of silently returning null
    if ($decoded === null && json_last_error() !== JSON_ERROR_NONE) {
        return array('error' => 'Invalid JSON from API: ' . htmlspecialchars($response));
    }

    return $decoded;
}

// Helper function to format date
function formatDate($date) {
    if (empty($date)) return 'N/A';
    return date('d/m/Y', strtotime($date));
}

// Helper function to format datetime
function formatDateTime($datetime) {
    if (empty($datetime)) return 'N/A';
    return date('d/m/Y H:i', strtotime($datetime));
}
?>
