<?php

// URLs
$PagSeguroDiretoResources['environment'] = array();
$PagSeguroDiretoResources['environment']['production'] = array('webserviceUrl' => 'https://ws.pagseguro.uol.com.br', 
                                                               'transactionUrl' => 'https://stc.pagseguro.uol.com.br');

$PagSeguroDiretoResources['environment']['sandbox'] = array('webserviceUrl' => 'https://ws.sandbox.pagseguro.uol.com.br', 
                                                            'transactionUrl' => 'https://stc.sandbox.pagseguro.uol.com.br');

// Session service
$PagSeguroDiretoResources['sessionService'] = array();
$PagSeguroDiretoResources['sessionService']['servicePath'] = "/v2/sessions";
$PagSeguroDiretoResources['sessionService']['serviceTimeout'] = 20;

// Payment service
$PagSeguroDiretoResources['paymentService'] = array();
$PagSeguroDiretoResources['paymentService']['servicePath'] = "/v2/transactions";
$PagSeguroDiretoResources['paymentService']['serviceTimeout'] = 20;

// Notification service
$PagSeguroDiretoResources['notificationService'] = array();
$PagSeguroDiretoResources['notificationService']['servicePath'] = "/v2/transactions/notifications";
$PagSeguroDiretoResources['notificationService']['serviceTimeout'] = 20;

// Transaction search service
$PagSeguroDiretoResources['transactionSearchService'] = array();
$PagSeguroDiretoResources['transactionSearchService']['servicePath'] = "/v2/transactions";
$PagSeguroDiretoResources['transactionSearchService']['serviceTimeout'] = 20;
