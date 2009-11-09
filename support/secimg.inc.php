<?php
/*******************************************************************************
*  Title: Helpdesk software Hesk
*  Version: 2.0 from 24th January 2009
*  Author: Klemen Stirn
*  Website: http://www.phpjunkyard.com
********************************************************************************
*  COPYRIGHT NOTICE
*  Copyright 2005-2009 Klemen Stirn. All Rights Reserved.

*  The Hesk may be used and modified free of charge by anyone
*  AS LONG AS COPYRIGHT NOTICES AND ALL THE COMMENTS REMAIN INTACT.
*  By using this code you agree to indemnify Klemen Stirn from any
*  liability that might arise from it's use.

*  Selling the code for this program, in part or full, without prior
*  written consent is expressly forbidden.

*  Using this code, in part or full, to create derivate work,
*  new scripts or products is expressly forbidden. Obtain permission
*  before redistributing this software over the Internet or in
*  any other medium. In all cases copyright and header must remain intact.
*  This Copyright is in full effect in any country that has International
*  Trade Agreements with the United States of America or
*  with the European Union.

*  Removing any of the copyright notices without purchasing a license
*  is illegal! To remove PHPJunkyard copyright notice you must purchase
*  a license for this script. For more information on how to obtain
*  a license please visit the site below:
*  http://www.phpjunkyard.com/copyright-removal.php
*******************************************************************************/

class PJ_SecurityImage
{

        function PJ_SecurityImage($key)
        {
                $this->code = '';
                $this->key = $key;
        } // End PJ_SecurityImage

        function encrypt($plain_text)
        {
            $this->code = trim(crypt($plain_text,$this->key));
        } // End encrypt

        function checkCode($mystring,$checksum)
        {
            $this->encrypt($mystring);
            if ($this->code == $checksum)
                return true;
            else
                return false;
        } // End checkCode

        function printImage($random_number)
        {
            header("Content-type: image/jpeg");
            $im = @imagecreate(150, 40) or die("Cannot Initialize new GD image stream");
            $background_color = imagecolorallocate($im, 255, 255, mt_rand(204,255));
            $text_color = imagecolorallocate($im, 0, mt_rand(0,102), 0);

			for ($i=0;$i<strlen($random_number);$i++)
			{
				$display = substr($random_number,$i,1);
				$x = ($i*30) + mt_rand(3,16);
				$y = mt_rand(3,26);
				imagestring($im, 5, $x, $y, $display, $text_color);
			}

			for ($i=1;$i<100;$i++)
			{
				imagesetpixel($im,mt_rand(1,150),mt_rand(1,40),$text_color);
			}

            imagejpeg($im);
            imagedestroy($im);
        } // End printImage

        function get()
        {
            return $this->code;
        } // End get

} // End class PJ_SecurityImage

?>
