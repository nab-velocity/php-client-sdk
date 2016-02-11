<?php
/* 
 * include all helping and supporting classes and methods.
 */
 
require_once dirname(__FILE__) . '/sdk/Velocity.php';
 
/* 
 * received data from transparent redirect, check is available and decode then convert into array. 
 */
if (isset($_POST['TransactionToken']) && $_POST['TransactionToken'] != '') {
 
	// echo 'Message: Display response of transparent redirect! (JSON) <br>';
	// echo '<pre>'; echo base64_decode($_POST['TransactionToken']); echo '</pre>';
	
	// echo 'Message: Display response of transparent redirect! (CLASS) <br>';
	// echo '<pre>'; print_r(json_decode(base64_decode($_POST['TransactionToken']))); echo '</pre>';

	$tr_response = json_decode(base64_decode($_POST['TransactionToken']));
	$avsData = isset($tr_response->CardSecurityData->AVSData) ? $tr_response->CardSecurityData->AVSData : null;
	$paymentAccountDataToken = $tr_response->PaymentAccountDataToken;
	
	$identitytoken = "PHNhbWw6QXNzZXJ0aW9uIE1ham9yVmVyc2lvbj0iMSIgTWlub3JWZXJzaW9uPSIxIiBBc3NlcnRpb25JRD0iXzdlMDhiNzdjLTUzZWEtNDEwZC1hNmJiLTAyYjJmMTAzMzEwYyIgSXNzdWVyPSJJcGNBdXRoZW50aWNhdGlvbiIgSXNzdWVJbnN0YW50PSIyMDE0LTEwLTEwVDIwOjM2OjE4LjM3OVoiIHhtbG5zOnNhbWw9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOjEuMDphc3NlcnRpb24iPjxzYW1sOkNvbmRpdGlvbnMgTm90QmVmb3JlPSIyMDE0LTEwLTEwVDIwOjM2OjE4LjM3OVoiIE5vdE9uT3JBZnRlcj0iMjA0NC0xMC0xMFQyMDozNjoxOC4zNzlaIj48L3NhbWw6Q29uZGl0aW9ucz48c2FtbDpBZHZpY2U+PC9zYW1sOkFkdmljZT48c2FtbDpBdHRyaWJ1dGVTdGF0ZW1lbnQ+PHNhbWw6U3ViamVjdD48c2FtbDpOYW1lSWRlbnRpZmllcj5GRjNCQjZEQzU4MzAwMDAxPC9zYW1sOk5hbWVJZGVudGlmaWVyPjwvc2FtbDpTdWJqZWN0PjxzYW1sOkF0dHJpYnV0ZSBBdHRyaWJ1dGVOYW1lPSJTQUsiIEF0dHJpYnV0ZU5hbWVzcGFjZT0iaHR0cDovL3NjaGVtYXMuaXBjb21tZXJjZS5jb20vSWRlbnRpdHkiPjxzYW1sOkF0dHJpYnV0ZVZhbHVlPkZGM0JCNkRDNTgzMDAwMDE8L3NhbWw6QXR0cmlidXRlVmFsdWU+PC9zYW1sOkF0dHJpYnV0ZT48c2FtbDpBdHRyaWJ1dGUgQXR0cmlidXRlTmFtZT0iU2VyaWFsIiBBdHRyaWJ1dGVOYW1lc3BhY2U9Imh0dHA6Ly9zY2hlbWFzLmlwY29tbWVyY2UuY29tL0lkZW50aXR5Ij48c2FtbDpBdHRyaWJ1dGVWYWx1ZT5iMTVlMTA4MS00ZGY2LTQwMTYtODM3Mi02NzhkYzdmZDQzNTc8L3NhbWw6QXR0cmlidXRlVmFsdWU+PC9zYW1sOkF0dHJpYnV0ZT48c2FtbDpBdHRyaWJ1dGUgQXR0cmlidXRlTmFtZT0ibmFtZSIgQXR0cmlidXRlTmFtZXNwYWNlPSJodHRwOi8vc2NoZW1hcy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsYWltcyI+PHNhbWw6QXR0cmlidXRlVmFsdWU+RkYzQkI2REM1ODMwMDAwMTwvc2FtbDpBdHRyaWJ1dGVWYWx1ZT48L3NhbWw6QXR0cmlidXRlPjwvc2FtbDpBdHRyaWJ1dGVTdGF0ZW1lbnQ+PFNpZ25hdHVyZSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC8wOS94bWxkc2lnIyI+PFNpZ25lZEluZm8+PENhbm9uaWNhbGl6YXRpb25NZXRob2QgQWxnb3JpdGhtPSJodHRwOi8vd3d3LnczLm9yZy8yMDAxLzEwL3htbC1leGMtYzE0biMiPjwvQ2Fub25pY2FsaXphdGlvbk1ldGhvZD48U2lnbmF0dXJlTWV0aG9kIEFsZ29yaXRobT0iaHR0cDovL3d3dy53My5vcmcvMjAwMC8wOS94bWxkc2lnI3JzYS1zaGExIj48L1NpZ25hdHVyZU1ldGhvZD48UmVmZXJlbmNlIFVSST0iI183ZTA4Yjc3Yy01M2VhLTQxMGQtYTZiYi0wMmIyZjEwMzMxMGMiPjxUcmFuc2Zvcm1zPjxUcmFuc2Zvcm0gQWxnb3JpdGhtPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwLzA5L3htbGRzaWcjZW52ZWxvcGVkLXNpZ25hdHVyZSI+PC9UcmFuc2Zvcm0+PFRyYW5zZm9ybSBBbGdvcml0aG09Imh0dHA6Ly93d3cudzMub3JnLzIwMDEvMTAveG1sLWV4Yy1jMTRuIyI+PC9UcmFuc2Zvcm0+PC9UcmFuc2Zvcm1zPjxEaWdlc3RNZXRob2QgQWxnb3JpdGhtPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwLzA5L3htbGRzaWcjc2hhMSI+PC9EaWdlc3RNZXRob2Q+PERpZ2VzdFZhbHVlPnl3NVZxWHlUTUh5NUNjdmRXN01TV2RhMDZMTT08L0RpZ2VzdFZhbHVlPjwvUmVmZXJlbmNlPjwvU2lnbmVkSW5mbz48U2lnbmF0dXJlVmFsdWU+WG9ZcURQaUorYy9IMlRFRjNQMWpQdVBUZ0VDVHp1cFVlRXpESERwMlE2ZW92T2lhN0pkVjI1bzZjTk1vczBTTzRISStSUGRUR3hJUW9xa0paeEtoTzZHcWZ2WHFDa2NNb2JCemxYbW83NUFSWU5jMHdlZ1hiQUVVQVFCcVNmeGwxc3huSlc1ZHZjclpuUytkSThoc2lZZW4vT0VTOUdtZUpsZVd1WUR4U0xmQjZJZnd6dk5LQ0xlS0FXenBkTk9NYmpQTjJyNUJWQUhQZEJ6WmtiSGZwdUlablp1Q2l5OENvaEo1bHU3WGZDbXpHdW96VDVqVE0wU3F6bHlzeUpWWVNSbVFUQW5WMVVGMGovbEx6SU14MVJmdWltWHNXaVk4c2RvQ2IrZXpBcVJnbk5EVSs3NlVYOEZFSEN3Q2c5a0tLSzQwMXdYNXpLd2FPRGJJUFpEYitBPT08L1NpZ25hdHVyZVZhbHVlPjxLZXlJbmZvPjxvOlNlY3VyaXR5VG9rZW5SZWZlcmVuY2UgeG1sbnM6bz0iaHR0cDovL2RvY3Mub2FzaXMtb3Blbi5vcmcvd3NzLzIwMDQvMDEvb2FzaXMtMjAwNDAxLXdzcy13c3NlY3VyaXR5LXNlY2V4dC0xLjAueHNkIj48bzpLZXlJZGVudGlmaWVyIFZhbHVlVHlwZT0iaHR0cDovL2RvY3Mub2FzaXMtb3Blbi5vcmcvd3NzL29hc2lzLXdzcy1zb2FwLW1lc3NhZ2Utc2VjdXJpdHktMS4xI1RodW1icHJpbnRTSEExIj5ZREJlRFNGM0Z4R2dmd3pSLzBwck11OTZoQ2M9PC9vOktleUlkZW50aWZpZXI+PC9vOlNlY3VyaXR5VG9rZW5SZWZlcmVuY2U+PC9LZXlJbmZvPjwvU2lnbmF0dXJlPjwvc2FtbDpBc3NlcnRpb24+";
	$applicationprofileid = 14644;  
	$merchantprofileid = "PrestaShop Global HC"; 
	$workflowid = 2317000001;
	$isTestAccount = true;

       
	try {
		$velocityProcessor = new VelocityProcessor( $applicationprofileid, $merchantprofileid, $workflowid, $isTestAccount, $identitytoken );
	} catch (Exception $e) {
	    echo $e->getMessage();
	}
        
	/*
	 * carddata optional for use SDK only without transparent redirect. 
	 * Note: array key must be not change.  
	 */

	$cardDataKeyed = array('cardowner' => 'Jane Doe', 'cardtype' => 'Visa', 'pan' => '4012888812348882', 'expire' => '1215', 'cvv' => '123');
	$cardDataSwiped = array('track2data' => '4012000033330026=09041011000012345678', 'cardtype' => 'Visa');

	$cardData = array(
            'cardowner' => 'Jane Doe', 
            'cardtype' => 'Visa', 
            'pan' => '4012888812348882', 
            'expire' => '1215', 
            'cvv' => '123',
            'track1data' => '',
            'track2data' => ''
            );
	$trackData = array('track2data' => '4012000033330026=09041011000012345678', 'cardtype' => 'Visa');
	
	/* *****************************************************verify************************************************************************* */
	
	try {
	
		$response = $velocityProcessor->verify(array(  
			'avsdata' => $avsData, 
			'carddata' => $cardDataKeyed,			
			'entry_mode' => 'Keyed',
			'IndustryType' =>'Ecommerce',
			'Reference' => 'xyz',
			'EmployeeId' => '11'
		)); 
 
		if (isset($response['Status']) && $response['Status'] == 'Successful') {
			echo 'Verify Successful!</br>';
			echo 'PostalCodeResult: ' . $response['AVSResult']['PostalCodeResult'] . '</br>'; 
			echo 'CVResult: ' . $response['CVResult'] . '</br></br>'; 
		} else {
			// some error
			print_r($response);
		}
		
    	} catch(Exception $e) {
		echo $e->getMessage();
	}
	
	
	/* *****************************************************Authorizeandcapture with token ************************************************************************* */
	
	try {
			
		$response = $velocityProcessor->authorizeAndCapture(array(
			'amount' => 10.03, 
			'avsdata' => $avsData,
			'token' => $paymentAccountDataToken, 
			'order_id' => '629203',
                        'entry_mode' => 'Keyed',
                        'IndustryType' =>'Ecommerce',
                        'Reference' => 'xyz',
                        'EmployeeId' => '11'
		));
		
		if (isset($response['Status']) && $response['Status'] == 'Successful') {
			echo 'AuthorizeAndCapture with token Successful!</br>';
			echo 'Masked PAN: ' . $response['MaskedPAN'] . '</br>';
			echo 'Approval Code: ' . $response['ApprovalCode'] . '</br>';
			echo 'Amount: ' . $response['Amount'] . '</br>'; 
			echo 'TransactionId: ' . $response['TransactionId'] . '</br></br>'; 
		} else {
			// some error
			print_r($response);
		}
		
		$authCapTransactionid = isset($response['TransactionId']) ? $response['TransactionId'] : null;
    	
	} catch(Exception $e) {
		echo $e->getMessage(); 
	}
	
	/* *****************************************************Authorizeandcapture keyed ************************************************************************* */
	
	try {
			
		$response = $velocityProcessor->authorizeAndCapture(array(
			'amount' => 10.03, 
			'avsdata' => $avsData,
			'carddata' => $cardData,
			'order_id' => '629203',
		));
		
		if (isset($response['Status']) && $response['Status'] == 'Successful') {
			echo 'AuthorizeAndCapture keyed Successful!</br>';
			echo 'Masked PAN: ' . $response['MaskedPAN'] . '</br>';
			echo 'Approval Code: ' . $response['ApprovalCode'] . '</br>';
			echo 'Amount: ' . $response['Amount'] . '</br>'; 
			echo 'TransactionId: ' . $response['TransactionId'] . '</br></br>'; 
		} else {
			// some error
			print_r($response);
		}
		
	} catch(Exception $e) {
		echo $e->getMessage(); 
	} 

	/* *****************************************************Authorizeandcapture swiped ************************************************************************* */
	
	try {
			
		$response = $velocityProcessor->authorizeAndCapture(array(
			'amount' => 10.03, 
			'avsdata' => $avsData,
			'carddata' => $cardData,
			'order_id' => '629203',
		));
		
		if (isset($response['Status']) && $response['Status'] == 'Successful') {
			echo 'AuthorizeAndCapture swiped Successful!</br>';
			echo 'Masked PAN: ' . $response['MaskedPAN'] . '</br>';
			echo 'Approval Code: ' . $response['ApprovalCode'] . '</br>';
			echo 'Amount: ' . $response['Amount'] . '</br>'; 
			echo 'TransactionId: ' . $response['TransactionId'] . '</br></br>'; 
		} else {
			// some error
			print_r($response);
		}
		
	} catch(Exception $e) {
		echo $e->getMessage(); 
	}         
        
	/* *****************************************************Authorize***************************************************************************** */
	
	try {
	
		$response = $velocityProcessor->authorize(array(
			'amount' => 10,  
			'carddata' => $cardDataKeyed,
			'order_id' => '629203',
			'entry_mode' => 'Keyed',
			'IndustryType' =>'Ecommerce',
			'Reference' => 'xyz',
			'EmployeeId' => '11'
		)); 
 
		if (isset($response['Status']) && $response['Status'] == 'Successful') {
			echo 'Authorize Successful!</br>';
			echo 'Masked PAN: ' . $response['MaskedPAN'] . '</br>';
			echo 'Approval Code: ' . $response['ApprovalCode'] . '</br>';
			echo 'Amount: ' . $response['Amount'] . '</br>'; 
			echo 'TransactionId: ' . $response['TransactionId'] . '</br></br>'; 
		} else {
			// some error
			print_r($response);
		}
		
		$authTransactionid = $response['TransactionId'];
		
	} catch (Exception $e) {
		echo $e->getMessage();
	} 
        
        
	
        
	/* *****************************************************Capture******************************************************************************** */
	
	try {
	
		$response = $velocityProcessor->capture(array(
			'amount' => 6.03, 
			'TransactionId' => $authTransactionid
		));
		
		//print_r($response);
		if (isset($response['Status']) && $response['Status'] == 'Successful') {
			echo 'Capture Successful!</br>';
			echo 'Amount: ' . $response['TransactionSummaryData']['NetTotals']['NetAmount'] . '</br></br>'; 
		} else {
			// some error
			print_r($response);
		}
		
		$captxnid = $response['TransactionId'];
		
	} catch(Exception $e) {
		echo $e->getMessage();
	} 
	
	/* *****************************************************Adjust******************************************************************************** */
		
	try {
		
		$response = $velocityProcessor->adjust(array(
			'amount' => 3.01, 
			'TransactionId' => $captxnid
		));
		 
		if (isset($response['Status']) && $response['Status'] == 'Successful') {
			echo 'Adjust Successful!</br>';
			echo 'Amount: ' . $response['Amount'] . '</br></br>'; 
		} else {
			// some error
			print_r($response);
		}
		
	} catch (Exception $e) {
		echo $e->getMessage();
	}
	
	$adjusttxnid = $response['TransactionId'];
	
	/* *****************************************************Undo******************************************************************************** */
	
	try {
		$response = $velocityProcessor->undo(array(
			'TransactionId' => $adjusttxnid
		));
										   
		if (isset($response['Status']) && $response['Status'] == 'Successful') {
			echo 'Undo Successful!</br>';
			echo 'TransactionId: ' . $response['TransactionId'] . '</br></br>'; 
		} else {
			// some error
			print_r($response);
		}
		
	} catch (Exception $e) {
		echo $e->getMessage();
	}
	
	/* *****************************************************ReturnById************************************************************************* */
	
	try {
		
		$response = $velocityProcessor->returnById(array(
			'amount' => 5.03, 
			'TransactionId' => $authCapTransactionid
		));
		
		if (isset($response['Status']) && $response['Status'] == 'Successful') {
			echo 'ReturnById Successful!</br>';
			echo 'ApprovalCode: ' . $response['ApprovalCode'] . '</br></br>'; 
		} else {
			// some error
			print_r($response);
		}
		
    	} catch (Exception $e) {
		echo $e->getMessage();
	} 
	
	/* *****************************************************ReturnUnlinked************************************************************************* */
	
	try {
				
		$response = $velocityProcessor->returnUnlinked(array( 
			'amount'       => 1.03, 
			'avsdata'      => $avsData,
			'carddata'     => $cardData, 
			'order_id'     => '629203',
                        'entry_mode'   => 'Keyed',
                        'IndustryType' => 'Ecommerce',
                        'Reference'    => 'xyz',
                        'EmployeeId'   => '11'
		));
		
		 
		if (isset($response['Status']) && $response['Status'] == 'Successful') {
			echo 'ReturnUnlinked Successful!</br>';
			echo 'ApprovalCode: ' . $response['ApprovalCode'] . '</br></br>'; 
		} else {
			// some error
			print_r($response);
		}
		
    	} catch (Exception $e) {
		echo $e->getMessage();
	} 
        
        

        
        /* *****************************************************QueryTransactionsDetail******************************************************************************** */
	
	try {
            	
		$response = $velocityProcessor->queryTransactionsDetail(
                        array(
                                'querytransactionparam' => array(
                                    'Amounts' => array(10.00),
                                    'ApprovalCodes' => array('VI0000'),
                                    'BatchIds' => array('0539'),
                                    'CaptureDateRange' => array(
                                        'EndDateTime' => '2015-07-17 02:03:40',
                                        'StartDateTime' => '2015-07-13 02:03:40'
                                    ),
                                    'CaptureStates' => array('ReadyForCapture'),
                                    'CardTypes' => array('Visa'),
                                    'MerchantProfileIds' => array('PrestaShop Global HC'),
                                    'OrderNumbers' => array('629203'),
                                    'ServiceIds' => array('2317000001'),
                                    'ServiceKeys' => array('FF3BB6DC58300001'),
                                    'TransactionClassTypePairs' => array( array(
                                        'TransactionClass' => 'CREDIT',
                                        'TransactionType' => 'AUTHONLY'
                                        )
                                    ),
                                    'TransactionDateRange' => array(
                                        'EndDateTime' => '2015-07-17 02:03:40',
                                        'StartDateTime' => '2015-07-13 02:03:40'
                                    ),
                                    'TransactionIds' => array('9B935E96763F43C3866F603319BE7B52'),
                                    'TransactionStates' => array('Authorized')                        
                                ),
                                'PagingParameters' => array(
                                    'page' => '0',
                                    'pagesize' => '3'
                                ),
                                
                    ));
		echo 'Query Transaction Detail!</br>';
		echo '<pre>';  print_r($response); echo '</pre>';
		
	} catch(Exception $e) {
		echo $e->getMessage();
	} 
        
        
	//For P2PE transaction 
	$workflowid = 'BBBAAA0001';
	try {
		$velocityProcessor = new VelocityProcessor( $applicationprofileid, $merchantprofileid, $workflowid, $isTestAccount, $identitytoken );
	} catch (Exception $e) {
	    echo $e->getMessage();
	}
        
	/* *****************************************************Authorize P2PE***************************************************************************** */
	
	try {
	
		$response = $velocityProcessor->authorize(array(
			'amount' => 10,  
			'p2pedata' => array(
				'SecurePaymentAccountData' => '576F2E197D5804F2B6201FB2578DCD1DDDC7BAE692FE48E9C368E678914233561FB953DF47E29F88',
				'EncryptionKeyId' => '9010010B257DC7000084'
			),
			'order_id' => '629203',
			'entry_mode' => 'TrackDataFromMSR',
			'IndustryType' =>'Retail',
			'Reference' => 'xyz',
			'EmployeeId' => '11'
		)); 
 
		if (isset($response['Status']) && $response['Status'] == 'Successful') {
			echo 'P2PE Authorize Successful!</br>';
			echo 'Masked PAN: ' . $response['MaskedPAN'] . '</br>';
			echo 'Approval Code: ' . $response['ApprovalCode'] . '</br>';
			echo 'Amount: ' . $response['Amount'] . '</br>'; 
			echo 'TransactionId: ' . $response['TransactionId'] . '</br></br>'; 
		} else {
			// some error
			echo '<pre>'; print_r($response); echo '</pre>';
		}
		
	} catch (Exception $e) {
		echo $e->getMessage();
	}
        
        /* *****************************************************Authorizeandcapture P2PE******************************************** */
	
	try {
			
		$response = $velocityProcessor->authorizeAndCapture(array(
			'amount' => 10.03, 
			'avsdata' => $avsData,
                        'p2pedata' => array(
                            'SecurePaymentAccountData' => '576F2E197D5804F2B6201FB2578DCD1DDDC7BAE692FE48E9C368E678914233561FB953DF47E29F88',
                            'EncryptionKeyId' => '9010010B257DC7000084'
                             ),
			'order_id' => '629203',
                        'entry_mode' => 'TrackDataFromMSR',
                        'IndustryType' =>'Retail',
                        'Reference' => 'xyz',
                        'EmployeeId' => '11'
		));
		
		if (isset($response['Status']) && $response['Status'] == 'Successful') {
			echo 'P2PE AuthorizeAndCapture Successful!</br>';
			echo 'Masked PAN: ' . $response['MaskedPAN'] . '</br>';
			echo 'Approval Code: ' . $response['ApprovalCode'] . '</br>';
			echo 'Amount: ' . $response['Amount'] . '</br>'; 
			echo 'TransactionId: ' . $response['TransactionId'] . '</br></br>'; 
		} else {
			// some error
			echo '<pre>'; print_r($response); echo '</pre>';
		}
		
		
    	} catch(Exception $e) {
		echo $e->getMessage(); 
	}
        
        /* *****************************************************ReturnUnlinked P2PE************************************************* */
	
	try {
				
		$response = $velocityProcessor->returnUnlinked(array( 
			'amount' => 1.03, 
                        'p2pedata' => array(
                            'SecurePaymentAccountData' => '576F2E197D5804F2B6201FB2578DCD1DDDC7BAE692FE48E9C368E678914233561FB953DF47E29F88',
                            'EncryptionKeyId' => '9010010B257DC7000084'
                        ),
			'order_id' => '629203',
                        'entry_mode' => 'TrackDataFromMSR',
                        'IndustryType' =>'Retail',
                        'Reference' => 'xyz',
                        'EmployeeId' => '11'
		));
		
		 
		if (isset($response['Status']) && $response['Status'] == 'Successful') {
			echo 'P2PE ReturnUnlinked Successful!</br>';
			echo 'ApprovalCode: ' . $response['ApprovalCode'] . '</br>'; 
                        echo 'Amount: ' . $response['Amount'] . '</br>'; 
			echo 'TransactionId: ' . $response['TransactionId'] . '</br></br>';
		} else {
			// some error
			echo '<pre>'; print_r($response); echo '</pre>';
		}
		
    	} catch (Exception $e) {
		echo $e->getMessage();
	} 
        
        
    /* *****************************************************CaptureAll******************************************************************************** */
        
	$identitytoken = "PHNhbWw6QXNzZXJ0aW9uIE1ham9yVmVyc2lvbj0iMSIgTWlub3JWZXJzaW9uPSIxIiBBc3NlcnRpb25JRD0iXzQ2ZTdkZDAzLTIwYzctNGJlZS1hNTdhLWRiNmE4MTA5MDlkNiIgSXNzdWVyPSJJcGNBdXRoZW50aWNhdGlvbiIgSXNzdWVJbnN0YW50PSIyMDE0LTExLTA3VDIxOjQ5OjU2Ljg3N1oiIHhtbG5zOnNhbWw9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOjEuMDphc3NlcnRpb24iPjxzYW1sOkNvbmRpdGlvbnMgTm90QmVmb3JlPSIyMDE0LTExLTA3VDIxOjQ5OjU2Ljg3N1oiIE5vdE9uT3JBZnRlcj0iMjA0NC0xMS0wN1QyMTo0OTo1Ni44NzdaIj48L3NhbWw6Q29uZGl0aW9ucz48c2FtbDpBZHZpY2U+PC9zYW1sOkFkdmljZT48c2FtbDpBdHRyaWJ1dGVTdGF0ZW1lbnQ+PHNhbWw6U3ViamVjdD48c2FtbDpOYW1lSWRlbnRpZmllcj4xQzA4MTc1OEVFNzAwMDAxPC9zYW1sOk5hbWVJZGVudGlmaWVyPjwvc2FtbDpTdWJqZWN0PjxzYW1sOkF0dHJpYnV0ZSBBdHRyaWJ1dGVOYW1lPSJTQUsiIEF0dHJpYnV0ZU5hbWVzcGFjZT0iaHR0cDovL3NjaGVtYXMuaXBjb21tZXJjZS5jb20vSWRlbnRpdHkiPjxzYW1sOkF0dHJpYnV0ZVZhbHVlPjFDMDgxNzU4RUU3MDAwMDE8L3NhbWw6QXR0cmlidXRlVmFsdWU+PC9zYW1sOkF0dHJpYnV0ZT48c2FtbDpBdHRyaWJ1dGUgQXR0cmlidXRlTmFtZT0iU2VyaWFsIiBBdHRyaWJ1dGVOYW1lc3BhY2U9Imh0dHA6Ly9zY2hlbWFzLmlwY29tbWVyY2UuY29tL0lkZW50aXR5Ij48c2FtbDpBdHRyaWJ1dGVWYWx1ZT40OTJhNWU0Yi02NWE0LTRkOTktYjQ0MS1iMzJjOTdmODNkNzY8L3NhbWw6QXR0cmlidXRlVmFsdWU+PC9zYW1sOkF0dHJpYnV0ZT48c2FtbDpBdHRyaWJ1dGUgQXR0cmlidXRlTmFtZT0ibmFtZSIgQXR0cmlidXRlTmFtZXNwYWNlPSJodHRwOi8vc2NoZW1hcy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsYWltcyI+PHNhbWw6QXR0cmlidXRlVmFsdWU+MUMwODE3NThFRTcwMDAwMTwvc2FtbDpBdHRyaWJ1dGVWYWx1ZT48L3NhbWw6QXR0cmlidXRlPjwvc2FtbDpBdHRyaWJ1dGVTdGF0ZW1lbnQ+PFNpZ25hdHVyZSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC8wOS94bWxkc2lnIyI+PFNpZ25lZEluZm8+PENhbm9uaWNhbGl6YXRpb25NZXRob2QgQWxnb3JpdGhtPSJodHRwOi8vd3d3LnczLm9yZy8yMDAxLzEwL3htbC1leGMtYzE0biMiPjwvQ2Fub25pY2FsaXphdGlvbk1ldGhvZD48U2lnbmF0dXJlTWV0aG9kIEFsZ29yaXRobT0iaHR0cDovL3d3dy53My5vcmcvMjAwMC8wOS94bWxkc2lnI3JzYS1zaGExIj48L1NpZ25hdHVyZU1ldGhvZD48UmVmZXJlbmNlIFVSST0iI180NmU3ZGQwMy0yMGM3LTRiZWUtYTU3YS1kYjZhODEwOTA5ZDYiPjxUcmFuc2Zvcm1zPjxUcmFuc2Zvcm0gQWxnb3JpdGhtPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwLzA5L3htbGRzaWcjZW52ZWxvcGVkLXNpZ25hdHVyZSI+PC9UcmFuc2Zvcm0+PFRyYW5zZm9ybSBBbGdvcml0aG09Imh0dHA6Ly93d3cudzMub3JnLzIwMDEvMTAveG1sLWV4Yy1jMTRuIyI+PC9UcmFuc2Zvcm0+PC9UcmFuc2Zvcm1zPjxEaWdlc3RNZXRob2QgQWxnb3JpdGhtPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwLzA5L3htbGRzaWcjc2hhMSI+PC9EaWdlc3RNZXRob2Q+PERpZ2VzdFZhbHVlPlQ2QmZhUDB2bXgwRitsT3JrRDVja0h4U2lYRT08L0RpZ2VzdFZhbHVlPjwvUmVmZXJlbmNlPjwvU2lnbmVkSW5mbz48U2lnbmF0dXJlVmFsdWU+VHBOalhUNnFMejZ5K2RYVU5yQlRQV0hqVitWbmVkTlNNNTNqdzB5N1RxK1NndEI1OEcvWjdKTEFoNUVLRTBqRERpMHRuQ3cvdmF3bGZ6TjU3VVBxeERzZVpmb1FobmJpQzVxVm5CNmZyOVFZRTlYQ0d1OG01bXhLYno2djl3QzVkVlFEMmxXenRFT0trcnZWL1kwRFVOR2drOEZpdFhmbk1rMVpvakdnNzUvaVFHYW4vUFlWaTBNZDYvc3JLZ1IzdkVsTTlUMm5GWVNkSmlrZUFvM3cweUlEZDNPbG5PL2UyNE1GTzQxdlE3d3lIZDBZUkdDZ2I1YVU4K0ZYelJRbXlyK00rU1RpQVlHT3MwcGRPVE9RNlBleGRITndFS1YzVzJkSUExaElIR2EvUmY0WWc0d0p2aTNublJHd2Z2b1h3RlZYckNsd1d4SVV4ODR2eGtDNitnPT08L1NpZ25hdHVyZVZhbHVlPjxLZXlJbmZvPjxvOlNlY3VyaXR5VG9rZW5SZWZlcmVuY2UgeG1sbnM6bz0iaHR0cDovL2RvY3Mub2FzaXMtb3Blbi5vcmcvd3NzLzIwMDQvMDEvb2FzaXMtMjAwNDAxLXdzcy13c3NlY3VyaXR5LXNlY2V4dC0xLjAueHNkIj48bzpLZXlJZGVudGlmaWVyIFZhbHVlVHlwZT0iaHR0cDovL2RvY3Mub2FzaXMtb3Blbi5vcmcvd3NzL29hc2lzLXdzcy1zb2FwLW1lc3NhZ2Utc2VjdXJpdHktMS4xI1RodW1icHJpbnRTSEExIj5ZREJlRFNGM0Z4R2dmd3pSLzBwck11OTZoQ2M9PC9vOktleUlkZW50aWZpZXI+PC9vOlNlY3VyaXR5VG9rZW5SZWZlcmVuY2U+PC9LZXlJbmZvPjwvU2lnbmF0dXJlPjwvc2FtbDpBc3NlcnRpb24+";

    /* *****************************************************Authorizeandcapture P2PE******************************************** */
	
	try {
			
		$response = $VelocityProcessor->authorizeAndCapture(array(
			'amount' => 10.03, 
			'avsdata' => $avsData,
                        'p2pedata' => array(
                            'SecurePaymentAccountData' => '576F2E197D5804F2B6201FB2578DCD1DDDC7BAE692FE48E9C368E678914233561FB953DF47E29F88',
                            'EncryptionKeyId' => '9010010B257DC7000084'
                             ),
			'order_id' => '629203',
                        'entry_mode' => 'TrackDataFromMSR',
                        'IndustryType' =>'Retail',
                        'Reference' => 'xyz',
                        'EmployeeId' => '11'
		));
		
		if (isset($response['Status']) && $response['Status'] == 'Successful') {
			echo 'P2PE AuthorizeAndCapture Successful!</br>';
			echo 'Masked PAN: ' . $response['MaskedPAN'] . '</br>';
			echo 'Approval Code: ' . $response['ApprovalCode'] . '</br>';
			echo 'Amount: ' . $response['Amount'] . '</br>'; 
			echo 'TransactionId: ' . $response['TransactionId'] . '</br></br>'; 
		} else {
			// some error
			echo '<pre>'; print_r($response); echo '</pre>';
		}
		
		
    	} catch(Exception $e) {
		echo $e->getMessage(); 
	}
        
        /* *****************************************************ReturnUnlinked P2PE************************************************* */
	
	try {
				
		$response = $VelocityProcessor->returnUnlinked(array( 
			'amount' => 1.03, 
                        'p2pedata' => array(
                            'SecurePaymentAccountData' => '576F2E197D5804F2B6201FB2578DCD1DDDC7BAE692FE48E9C368E678914233561FB953DF47E29F88',
                            'EncryptionKeyId' => '9010010B257DC7000084'
                        ),
			'order_id' => '629203',
                        'entry_mode' => 'TrackDataFromMSR',
                        'IndustryType' =>'Retail',
                        'Reference' => 'xyz',
                        'EmployeeId' => '11'
		));
		
		 
		if (isset($response['Status']) && $response['Status'] == 'Successful') {
			echo 'P2PE ReturnUnlinked Successful!</br>';
			echo 'ApprovalCode: ' . $response['ApprovalCode'] . '</br>'; 
                        echo 'Amount: ' . $response['Amount'] . '</br>'; 
			echo 'TransactionId: ' . $response['TransactionId'] . '</br></br>';
		} else {
			// some error
			echo '<pre>'; print_r($response); echo '</pre>';
		}
		
    	} catch (Exception $e) {
		echo $e->getMessage();
	} 
        

	$applicationprofileid = 15464;  
	$merchantprofileid = "GlobalEastTCEBT"; 
	$workflowid = "A39DF00001";
	
	try {
		$velocityProcessorcap = new VelocityProcessor( $applicationprofileid, $merchantprofileid, $workflowid, $isTestAccount, $identitytoken );
	} catch (Exception $e) {
	    echo $e->getMessage();
	}
        
	try {
		
		$response = $velocityProcessorcap->captureAll();

		if (isset($response['ArrayOfResponse']['Response']['Status']) && $response['ArrayOfResponse']['Response']['Status'] == 'Successful') {
			echo 'CaptureAll Successful!</br>';
			echo 'TransactionState: ' . $response['ArrayOfResponse']['Response']['StatusMessage'] . '</br>';
			echo 'CaptureState: ' . $response['ArrayOfResponse']['Response']['CaptureState'] . '</br>'; 
            echo 'TransactionState: ' . $response['ArrayOfResponse']['Response']['TransactionState'] . '</br>'; 
			echo 'TransactionId: ' . $response['ArrayOfResponse']['Response']['TransactionId'] . '</br></br>';
		} else {
			// some error
			echo '<pre>'; print_r($response); echo '</pre>';
		}
		
	} catch(Exception $e) {
		echo $e->getMessage();
	} 

} else {
    echo Velocity_Message::$descriptions['errtransparentjs'];
}

?>