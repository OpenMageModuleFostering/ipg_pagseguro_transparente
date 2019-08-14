<?php

/*
 * ***********************************************************************
  Copyright [2011] [Ipagare_PagSeguroDireto_ Internet Ltda.]

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License.
 * ***********************************************************************
 */

/**
 * Class Ipagare_PagSeguroDireto_Parser_PaymentParser
 */
class Ipagare_PagSeguroDireto_Parser_PaymentParser extends Ipagare_PagSeguroDireto_Parser_ServiceParser {

    /**
     * @param $payment Ipagare_PagSeguroDireto_Domain_PaymentRequest
     * @return mixed
     */
    public static function getData(Ipagare_PagSeguroDireto_Domain_PaymentRequest $payment) {
        $data = null;

        // reference
        if ($payment->getReference() != null) {
            $data["reference"] = $payment->getReference();
        }

        // paymentMode
        if ($payment->getPaymentMode() != null) {
            $data["paymentMode"] = $payment->getPaymentMode();
        }

        // paymentMethod
        if ($payment->getPaymentMethod() != null) {
            $data["paymentMethod"] = $payment->getPaymentMethod();
        }

        // receiverEmail
        if ($payment->getReceiverEmail() != null) {
            $data["receiverEmail"] = $payment->getReceiverEmail();
        }

        // currency
        if ($payment->getCurrency() != null) {
            $data['currency'] = $payment->getCurrency();
        }

        // creditCardToken
        if ($payment->getCreditCardToken() != null) {
            $data["creditCardToken"] = $payment->getCreditCardToken();
        }

        // installment
        if ($payment->getInstallment() != null) {
            if ($payment->getInstallment()->getQuantity() != null) {
                $data["installmentQuantity"] = $payment->getInstallment()->getQuantity();
            }

            if ($payment->getInstallment()->getValue() != null) {
                $data["installmentValue"] = $payment->getInstallment()->getValue();
            }
        }

        // bank
        $bank = $payment->getBank();
        if ($bank != null) {
            if ($bank->getName() != null) {
                $data['bankName'] = $bank->getName();
            }
        }

        // creditCardHolder
        $creditCardHolder = $payment->getCreditCardHolder();
        if ($creditCardHolder != null) {
            if ($creditCardHolder->getName() != null) {
                $data['creditCardHolderName'] = $creditCardHolder->getName();
            }
            if ($creditCardHolder->getCpf() != null) {
                $data['creditCardHolderCPF'] = $creditCardHolder->getCpf();
            }
            if ($creditCardHolder->getBirthDate() != null) {
                $data['creditCardHolderBirthDate'] = $creditCardHolder->getBirthDate();
            }
            if ($creditCardHolder->getAreaCode() != null) {
                $data['creditCardHolderAreaCode'] = $creditCardHolder->getAreaCode();
            }
            if ($creditCardHolder->getPhone() != null) {
                $data['creditCardHolderPhone'] = $creditCardHolder->getPhone();
            }
        }

        // sender
        if ($payment->getSender() != null) {
            if ($payment->getSender()->getName() != null) {
                $data['senderName'] = $payment->getSender()->getName();
            }
            if ($payment->getSender()->getEmail() != null) {
                $data['senderEmail'] = $payment->getSender()->getEmail();
            }
            // senderHash
            if ($payment->getSender()->getHash() != null) {
                $data['senderHash'] = $payment->getSender()->getHash();
            }

            // phone
            if ($payment->getSender()->getPhone() != null) {
                if ($payment->getSender()->getPhone()->getAreaCode() != null) {
                    $data['senderAreaCode'] = $payment->getSender()->getPhone()->getAreaCode();
                }
                if ($payment->getSender()->getPhone()->getNumber() != null) {
                    $data['senderPhone'] = $payment->getSender()->getPhone()->getNumber();
                }
            }

            // documents
            /** @var $document Ipagare_PagSeguroDireto_Domain_Document */
            if ($payment->getSender()->getDocuments() != null) {
                $documents = $payment->getSender()->getDocuments();
                if (is_array($documents) && count($documents) == 1) {
                    foreach ($documents as $document) {
                        if (!is_null($document)) {

                            if ($document->getType() == 'CNPJ') {
                                $data['senderCNPJ'] = $document->getValue();
                            } else {
                                $data['senderCPF'] = $document->getValue();
                            }
                        }
                    }
                }
            }
        }

        // items
        $items = $payment->getItems();
        if (count($items) > 0) {
            $i = 0;

            foreach ($items as $key => $value) {
                $i++;
                if ($items[$key]->getId() != null) {
                    $data["itemId$i"] = $items[$key]->getId();
                }
                if ($items[$key]->getDescription() != null) {
                    $data["itemDescription$i"] = $items[$key]->getDescription();
                }
                if ($items[$key]->getQuantity() != null) {
                    $data["itemQuantity$i"] = $items[$key]->getQuantity();
                }
                if ($items[$key]->getAmount() != null) {
                    $amount = Ipagare_PagSeguroDireto_Helper_Helper::decimalFormat($items[$key]->getAmount());
                    $data["itemAmount$i"] = $amount;
                }
                if ($items[$key]->getWeight() != null) {
                    $data["itemWeight$i"] = $items[$key]->getWeight();
                }
                if ($items[$key]->getShippingCost() != null) {
                    $data["itemShippingCost$i"] = Ipagare_PagSeguroDireto_Helper_Helper::decimalFormat($items[$key]->getShippingCost());
                }
            }
        }

        // extraAmount
        if ($payment->getExtraAmount() != null) {
            $data['extraAmount'] = Ipagare_PagSeguroDireto_Helper_Helper::decimalFormat($payment->getExtraAmount());
        }

        // shipping
        if ($payment->getShipping() != null) {
            if ($payment->getShipping()->getType() != null && $payment->getShipping()->getType()->getValue() != null) {
                $data['shippingType'] = $payment->getShipping()->getType()->getValue();
            }

            if ($payment->getShipping()->getCost() != null && $payment->getShipping()->getCost() != null) {
                $data['shippingCost'] = $payment->getShipping()->getCost();
            }

            // shipping address
            $shippingAddress = $payment->getShipping()->getAddress();
            if ($shippingAddress != null) {
                if ($shippingAddress->getStreet() != null) {
                    $data['shippingAddressStreet'] = $shippingAddress->getStreet();
                }
                if ($shippingAddress->getNumber() != null) {
                    $data['shippingAddressNumber'] = $shippingAddress->getNumber();
                }
                if ($shippingAddress->getComplement() != null) {
                    $data['shippingAddressComplement'] = $shippingAddress->getComplement();
                }
                if ($shippingAddress->getCity() != null) {
                    $data['shippingAddressCity'] = $shippingAddress->getCity();
                }
                if ($shippingAddress->getState() != null) {
                    $data['shippingAddressState'] = $shippingAddress->getState();
                }
                if ($shippingAddress->getDistrict() != null) {
                    $data['shippingAddressDistrict'] = $shippingAddress->getDistrict();
                }
                if ($shippingAddress->getPostalCode() != null) {
                    $data['shippingAddressPostalCode'] = $shippingAddress->getPostalCode();
                }
                if ($shippingAddress->getCountry() != null) {
                    $data['shippingAddressCountry'] = $shippingAddress->getCountry();
                }
            }

            // billing address
            $billingAddress = $payment->getBilling()->getAddress();
            if ($billingAddress != null) {
                if ($billingAddress->getStreet() != null) {
                    $data['billingAddressStreet'] = $billingAddress->getStreet();
                }
                if ($billingAddress->getNumber() != null) {
                    $data['billingAddressNumber'] = $billingAddress->getNumber();
                }
                if ($billingAddress->getComplement() != null) {
                    $data['billingAddressComplement'] = $billingAddress->getComplement();
                }
                if ($billingAddress->getCity() != null) {
                    $data['billingAddressCity'] = $billingAddress->getCity();
                }
                if ($billingAddress->getState() != null) {
                    $data['billingAddressState'] = $billingAddress->getState();
                }
                if ($billingAddress->getDistrict() != null) {
                    $data['billingAddressDistrict'] = $billingAddress->getDistrict();
                }
                if ($billingAddress->getPostalCode() != null) {
                    $data['billingAddressPostalCode'] = $billingAddress->getPostalCode();
                }
                if ($billingAddress->getCountry() != null) {
                    $data['billingAddressCountry'] = $billingAddress->getCountry();
                }
            }
        }

        // redirectURL
        if ($payment->getRedirectURL() != null) {
            $data['redirectURL'] = $payment->getRedirectURL();
        }

        // notificationURL
        if ($payment->getNotificationURL() != null) {
            $data['notificationURL'] = $payment->getNotificationURL();
        }

        // parameter
        if (count($payment->getParameter()->getItems()) > 0) {
            foreach ($payment->getParameter()->getItems() as $item) {
                if ($item instanceof Ipagare_PagSeguroDireto_Domain_ParameterItem) {
                    if (!Ipagare_PagSeguroDireto_Helper_Helper::isEmpty($item->getKey()) && !Ipagare_PagSeguroDireto_Helper_Helper::isEmpty($item->getValue())) {
                        if (!Ipagare_PagSeguroDireto_Helper_Helper::isEmpty($item->getGroup())) {
                            $data[$item->getKey() . '' . $item->getGroup()] = $item->getValue();
                        } else {
                            $data[$item->getKey()] = $item->getValue();
                        }
                    }
                }
            }
        }

        return $data;
    }

    /**
     * @param $str_xml
     * @return Ipagare_PagSeguroDireto_Parser_PaymentParserData
     */
    public static function readSuccessXml($str_xml) {
        $parser = new Ipagare_PagSeguroDireto_Utils_XmlParser($str_xml);
        $paymentData = Ipagare_PagSeguroDireto_Parser_PaymentParserData::getInstance($parser->getResult('transaction'));
        $paymentData->setXmlReturn($str_xml);

        return $paymentData;
    }

}
