<?php

//use DomPDF\Dompdf;
//use DomPDF\Options;

class CommonFunctions {

    public function __construct() {
//        require_once('DomPDF/autoload.inc.php');
//        require_once('DomPDF/src/Dompdf.php');
//        require_once('PHPMailer/PHPMailerAutoload.php');
    }

    public function getPriceInWords($number) {
        $no = round($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => '', '1' => 'one', '2' => 'two',
            '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
            '7' => 'seven', '8' => 'eight', '9' => 'nine',
            '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
            '13' => 'thirteen', '14' => 'fourteen',
            '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
            '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
            '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
            '60' => 'sixty', '70' => 'seventy',
            '80' => 'eighty', '90' => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] .
                        " " . $digits[$counter] . $plural . " " . $hundred :
                        $words[floor($number / 10) * 10]
                        . " " . $words[$number % 10] . " "
                        . $digits[$counter] . $plural . " " . $hundred;
            } else
                $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ?
                "." . $words[$point / 10] . " " .
                $words[$point = $point % 10] : '';
//        return $result . "Rupees  " . $points . " Paise"; //Uncomment if you want result with pasie
        return $result . "Rupees";
    }

    public function getTimeDifference($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full)
            $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) : 'just now';
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function exportData($html, $fileName) {
        $dompdf = new Dompdf();

        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $dompdf->setOptions($options);

        $dompdf->loadHtml($html);
        $dompdf->render();

        $download_date = mdate('%Y-%m-%d', time());
        $dompdf->stream($fileName, array('Attachment' => 0));
    }

    public function sendEmail($mail_subject, $mail_body, $mail_to) {
        $mail = new PHPMailer();
        $mail->IsSMTP(); // we are going to use SMTP
        $mail->SMTPAuth = TRUE; // enabled SMTP authentication
//            $mail->SMTPDebug = 1; // enabled SMTP authentication
//            $mail->SMTPAutoTLS = FALSE;  // prefix for secure protocol to connect to the server
        $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
        $mail->Host = "sg2plcpnl0195.prod.sin2.secureserver.net";      // setting GMail as our SMTP server
        $mail->Port = 465;                   // SMTP port to connect to GMail
        $mail->Username = "username";  // user email address
        $mail->Password = "password";            // password in GMail
        $mail->SetFrom('info.dhanlaxmibuilder@gmail.com', 'Dhanlaxmi Builder');  //Who is sending the email
        $mail->Subject = $mail_subject;
        $mail->Body = $mail_body;
        $mail->AltBody = "Plain text message";
        $mail->AddAddress($mail_to);
        return $mail->Send();
    }

    public function uploadFiles($allowed_file_types, $file_size, $upload_dir, $file) {
        $response = 1;

        $upload_errors = array();

        $allowed_file_types_string = implode("/", $allowed_file_types);

        $file_size_in_kb = $file_size / 1000;

        if (!in_array(strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION)), $allowed_file_types)) {
            array_push($upload_errors, 'Only ' . $allowed_file_types_string . ' files are allowed.');
            $response = 0;
        } elseif ($_FILES['file']['size'] > $file_size) {
            array_push($upload_errors, 'Photo size should be less than ' . $file_size_in_kb . 'KB');
            $response = 0;
        } elseif ($_FILES['file']['error'] > 0) {
            array_push($upload_errors, 'Something went wrong. Please try again later.');
            $response = 0;
        }


        if (!$response) {
            return $upload_errors;
        } else {
            if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_dir . $file)) {
                return TRUE;
            } else {
                array_push($upload_errors, 'Something went wrong. Please try again later.');
                return $upload_errors;
            }
        }
    }

}
