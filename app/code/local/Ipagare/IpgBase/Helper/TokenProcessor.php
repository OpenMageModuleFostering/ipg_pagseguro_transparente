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

class Ipagare_IpgBase_Helper_TokenProcessor extends Mage_Core_Helper_Abstract {

    /**
     * The timestamp used most recently to generate a token value.
     */
    private $previous;

    public function isTokenValid($request, $reset = false) {
        // Retrieve the current session for this request
        $saved = (string) Mage::getSingleton('ipgbase/session')->getIpagareTimestamp();

        if ($saved == null || $saved == '') {
            return false;
        }

        if ($reset) {
            $this->resetToken();
        }

        // Retrieve the transaction token included in this request
        $token = $request['ipagare_timestamp'];

        if (Mage::helper('ipgbase/stringUtils')->isEmpty($token)) {
            return false;
        }

        return ($saved == $token);
    }

    /**
     * Reset the saved transaction token in the user's session.  This
     * indicates that transactional token checking will not be needed on the
     * next request that is submitted.
     *
     * @param request The servlet request we are processing
     */
    public function resetToken() {
        Mage::getSingleton('ipgbase/session')->unsIpagareTimestamp();
    }

    /**
     * Save a new transaction token in the user's current session, creating a
     * new session if necessary.
     *
     * @param request The servlet request we are processing
     */
    public function saveToken() {
        $token = $this->generateToken();
        if ($token != null) {
            Mage::getSingleton('ipgbase/session')->setIpagareTimestamp($token);
        }
        return $token;
    }

    /**
     * Generate a new transaction token, to be used for enforcing a single
     * request for a particular transaction.
     *
     * @param id a unique Identifier for the session or other context in which
     *           this token is to be used.
     */
    public function generateToken() {
        $current = time();

        if ($current == $this->previous) {
            $current++;
        }

        $this->previous = $current;

        $now = md5($current);
        return $now;
    }

    /**
     * Convert a byte array to a String of hexadecimal digits and return it.
     *
     * @param buffer The byte array to be converted
     */
//    private String toHex(byte[] buffer) {
//        StringBuffer sb = new StringBuffer(buffer.length * 2);
//
//        for (int i = 0; i < buffer.length; i++) {
//            sb.append(Character.forDigit((buffer[i] & 0xf0) >> 4, 16));
//            sb.append(Character.forDigit(buffer[i] & 0x0f, 16));
//        }
//
//        return sb.toString();
//    }
}