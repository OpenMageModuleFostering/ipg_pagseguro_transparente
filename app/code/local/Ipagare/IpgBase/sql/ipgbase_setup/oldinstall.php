<?php

/**
* 
* iPAGARE para Magento
* 
* @category     Ipagare
* @packages     IpgBase
* @copyright    Copyright (c) 2012 iPAGARE (http://www.ipagare.com.br)
* @version      1.16.4
* @license      http://www.ipagare.com.br/magento/licenca
*
*/

$installer = $this;
$installer->startSetup();

$conn = $installer->getConnection();
$table_core_email_template = $installer->getTable('core_email_template');
$templateName = 'IpgBoletoPorVencer';
$templateId = Mage::getModel('ipgbase/emailService')->getIdTemplateEmail();
$order = '$order';

$varTeste= '{"store url=\\\"\\\"":"Store Url",';
$varTeste.= '"skin url=\\\"images/logo_email.gif\\\" _area=\'\'frontend\'\'":"Email Logo Image",';
$varTeste.= '"htmlescape var=$order.getCustomerName()":"Customer Name",';
$varTeste.= '"var order.increment_id":"Order Id",';
$varTeste.= '"var order.getStatusLabel()":"Order Status",';
$varTeste.= '"store url=\\\"customer/account/\\\"":"Customer Account Url",';
$varTeste.= '"var comment":"Order Comment",';
$varTeste.= '"var store.getFrontendName()":"Store Name"}';


    $installer->run("INSERT INTO `$table_core_email_template`
                    (`template_code`,
                     `template_text`,
                     `template_styles`,
                     `template_type`,
                     `template_subject`,
                     `template_sender_name`, 
                     `template_sender_email`,
                     `added_at`,
                     `modified_at`, 
                     `orig_template_code`,
                     `orig_template_variables`)
                    SELECT '$templateName',
                     '<body style=\"background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;\">
                     \r\n<div style=\"background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;\">
                     \r\n<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" height=\"100%\" width=\"100%\">
                     \r\n <tr>
                     \r\n <td align=\"center\" valign=\"top\" style=\"padding:20px 0 20px 0\">
                     \r\n <!-- [ header starts here] -->
                     \r\n <table bgcolor=\"#FFFFFF\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\" width=\"650\" style=\"border:1px solid #E0E0E0;\">
                     \r\n <tr>
                     \r\n <td valign=\"top\">
                            <a href=\"{{store url=\"\"}}\">
                                <img src=\"{{skin url=\"images/logo_email.gif\" _area=\'frontend\'}}\" alt=\"{{var store.getFrontendName()}}\"  style=\"margin-bottom:10px;\" border=\"0\"/>
                            </a>
                        </td>
                     \r\n
                         </tr>
                     \r\n <!-- [ middle starts here] -->
                     \r\n <tr>
                     \r\n <td valign=\"top\">
                     \r\n  <h1 style=\"font-size:22px; font-weight:normal; line-height:22px; margin:0 0 11px 0;\">Prezado(a) {{htmlescape var=$order.getCustomerName()}},</h1>
                     \r\n   <p style=\"font-size:12px; line-height:16px; margin:0 0 10px 0;\">
                     \r\n   Seu Pedido # {{var order.increment_id}} está <br/>
                     \r\n   <strong>{{var order.getStatusLabel()}}</strong>.
                     \r\n   </p>
                     \r\n   <p style=\"font-size:12px; line-height:16px; margin:0 0 10px 0;\">Você pode checar o status do pedido 
                            <a href=\"{{store url=\"customer/account/\"}}\" style=\"color:#1E7EC8;\">Logando em sua conta</a>.
                            </p>
                     \r\n   <p style=\"font-size:12px; line-height:16px; margin:0 0 10px 0;\">Caso queira pagar o boleto diretamente: {{var comment}}</p>
                     \r\n   <p style=\"font-size:12px; line-height:16px; margin:0;\">
                     \r\n   Para qualquer outra dúvida, entre em contato através do e-mail:
                     \r\n   <a href=\"mailto:{{config path=\'trans_email/ident_support/email\'}}\" style=\"color:#1E7EC8;\">{{config path=\'trans_email/ident_support/email\'}}</a>.
                     \r\n   </p>
                     \r\n   </td>
                     \r\n   </tr>
                     \r\n   <tr>
                     \r\n   <td bgcolor=\"#EAEAEA\" align=\"center\" style=\"background:#EAEAEA; text-align:center;\">
                                <center>
                            <p style=\"font-size:12px; margin:0;\">Muito obrigado, <strong>{{var store.getFrontendName()}}</strong>
                            </p></center></td>
                     \r\n   </tr>
                     \r\n   </table>
                     \r\n    </td>
                     \r\n   </tr>
                     \r\n </table>
                     \r\n </div>
                     \r\n </body>' ,
                     
                     'body,td { color:#2f2f2f; font:11px/1.35em Verdana, Arial, Helvetica, sans-serif; }' ,
                     
                     '2' ,
                    
                     '{{var store.getFrontendName()}}: Boleto vencendo para pedido {{var order.increment_id}}',
                     
                     NULL , 
                     
                     NULL , 
                    
                    '2012-07-31 14:18:21' ,
            
                    '2012-08-07 13:12:42' ,
            
                    'sales_email_order_comment_template' ,
                    
                    '$varTeste'
                     
					
                    FROM DUAL WHERE NOT EXISTS
                                    (SELECT `template_code` FROM $table_core_email_template c 
                                                            WHERE c.template_code = '$templateName') ;");

    
    
    
$installer->endSetup();