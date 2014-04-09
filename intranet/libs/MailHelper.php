<?php

class MailHelper extends Model {

    public $_from = 'jag@jagmodels.com';
    public $_admin = 'jag@jagmodels.com';

    public function __construct() {
        parent::__construct();
        $this->loadLang();
        include 'Mail.php';
        include 'Mail/mime.php';
    }

    public function sendMail($html, $list, $subject, $Bcc = false, $from = null) {
        $from = ($from) ? $from : $this->_from;
        foreach ($list as $para) {
            $text = '';
            $crlf = "\n";
            $hdrs = array(
                'From' => strip_tags($from),
                'Reply-To' => strip_tags($from),
                'Subject' => $subject
            );
            $hdrs['bcc'] = ($Bcc) ? $Bcc : '';
            $mime = new Mail_mime(array('eol' => $crlf));

            $mime->setTXTBody($text);
            $mime->setHTMLBody($html);

            $body = $mime->get();
            $headers = $mime->headers($hdrs);

            $mail = & Mail::factory('mail');
            $mail->send($para, $headers, $body);
        }
    }

    public function sendPackage($package,$images,$deliver_id, $dest) {
        $tpl = file_get_contents(ROOT . '../views/templates/packageTemplate.html');

        $subject = ($_POST['subject'] == '') ? 'Jag Models' : 'Jag Models: ' . $_POST['subject'];
        $mensaje = ($_POST['comment'] != '') ? stripslashes($_POST['comment']) : 'This package was sent to you by Jag Models';
       
        $pakLink = PACKAGE . urlencode(str_replace('&', 'and', $package[0]['id'] . ' ' . $deliver_id . ' ' . $_POST['name']));
        $ping = URL . 'packages/ping/'.$deliver_id;
        $data = array(
            'content' => $mensaje,
            'link' => $pakLink,
            'ping' => $ping,
            'name' => $_POST['name'],
            'images' => $images
        );
        foreach ($data as $key => $string) {
            $tpl = str_replace('{{' . $key . '}}', $string, $tpl);
        }
        $this->sendMail($tpl, array($dest), $subject);
    }

    public function sendContact() {
        $tpl = file_get_contents(ROOT . 'views/templates/info-mail.html');
        $content.='<table>';
        $content.='<tr><td>COMPANY CONTACT</td><td></td></tr>';
        $content.='<tr><td>Company:</td><td>' . $_POST['company'] . '</td></tr>';
        $content.='<tr><td>Name:</td><td>' . $_POST['name'] . '</td></tr>';
        $content.='<tr><td>Email:</td><td>' . $_POST['email'] . '</td></tr>';
        $content.='<tr><td>Phone:</td><td>' . $_POST['phone'] . '</td></tr>';
        $content.='<tr><td>Country:</td><td>' . $_POST['country'] . '</td></tr>';
        $content.='<tr><td>City:</td><td>' . $_POST['city'] . '</td></tr>';
        $content.='<tr><td>Request:</td><td>' . $_POST['request'] . '</td></tr>';
        $content.='</table>';
        $data = array(
            'content' => $content,
            'link' => '',
            'name' => '',
        );
        foreach ($data as $key => $string) {
            $tpl = str_replace('{{' . $key . '}}', $string, $tpl);
        }
        $this->sendMail($tpl, array($this->_admin), 'Terrae: Company Contact');
    }

    public function getRememberMail($user) {
        $hash = Hash::create('sha256', $user['id'], HASH_PASSWORD_KEY);
        $link = URL . 'user/resetpassword?id=' . $user[id] . '&hash=' . $hash;
        $mensaje = 'Has solicitado restablecer tu contraseña, por favor haz click en el siguiente enlace.';
        $tpl = file_get_contents(ROOT . 'views/templates/confirmation-mail.html');
        $tpl = str_replace('{{content}}', $mensaje, $tpl);
        $tpl = str_replace('{{link}}', $link, $tpl);
        $tpl = str_replace('{{name}}', $user['name'], $tpl);
        $this->sendMail($tpl, array($user['email']), 'Terrae: Reset password');
    }

    public function getBookingMail($booking, $user) {
        $tpl = file_get_contents(ROOT . 'views/templates/booking-mail.html');
        $total = 0;
        foreach ($booking as $key => $book) {
            $total+=$book['price'];
            $data = array(
                'name' => $book['name'] . ' - ' . $book['room_type'],
                'checkin_date' => $book['checkin_date'],
                'checkout_date' => $book['checkout_date'],
                'places' => $book['max_adults'] . ' Adults ' . $book['max_children'] . ' children ',
                'request' => $book['request'],
                'price' => $book['price'] . '  €',
            );
            $concept.= '<table bgcolor="fffefd" align="center" width="680" style="padding:20px;margin-bottom: 2px;">
                <tr>
                    <td>CONCEPT:</td>
                    <td>' . $data['name'] . '</td>
                </tr>
                 <tr>
                    <td>CHECK IN:</td>
                    <td>' . $this->lang[date('l', strtotime($data['checkin_date']))] . ', ' . Model::getTime($data['checkin_date']) . '</td>
                </tr>
                <tr>
                    <td>CHECK OUT:</td>
                    <td>' . $this->lang[date('l', strtotime($data['checkout_date']))] . ', ' . Model::getTime($data['checkout_date']) . '</td>
                </tr>
                <tr>
                    <td>Nº PLACES:</td>
                    <td>' . $data['places'] . '</td>
                </tr>
                <tr>
                    <td>Request:</td>
                    <td>' . $data['request'] . '</td>
                </tr>
                <tr>
                    <td>AMOUNT:</td>
                    <td>' . $data['price'] . '</td>
                </tr>
               
            </table>';
        }
        unset($data);
        $data = array(
            'first_name' => $user['fist_name'],
            'last_name' => $user['last_name'],
            'phone' => $user['phone'],
            'city' => $user['city'],
            'country' => $user['country'],
            'email' => $user['email'],
            'concept' => $concept,
            'total' => $total . ' €',
            'subject' => 'Terrae: Reservation complete'
        );
        foreach ($data as $key => $string) {
            $tpl = str_replace('{{' . $key . '}}', $string, $tpl);
        }

        $this->sendMail($tpl, array($user['email']), $data['subject'], $this->_admin);
    }

    public function getGiftMail($attr) {
        $tpl = file_get_contents(ROOT . 'views/templates/booking-mail.html');
        $total = $attr['price'];
        $data = array(
            'name' => $attr['name'],
            'price' => $attr['price'] . '  €',
        );
        $concept.= '<table bgcolor="fffefd" align="center" width="680" style="padding:20px;margin-bottom: 2px;">
                <tr>
                    <td>CONCEPT:</td>
                    <td>' . $data['name'] . '</td>
                </tr>
                 <tr>
                    <td>CHECK IN:</td>
                    <td> - </td>
                </tr>
                <tr>
                    <td>CHECK OUT:</td>
                    <td> - </td>
                </tr>
                <tr>
                    <td>Nº PLACES:</td>
                    <td> - </td>
                </tr>
                <tr>
                    <td>AMOUNT:</td>
                    <td>' . $data['price'] . '</td>
                </tr>
               
            </table>';

        unset($data);
        $data = array(
            'first_name' => $attr['first_name'],
            'last_name' => $attr['last_name'],
            'phone' => $attr['phone'],
            'city' => $attr['city'],
            'country' => $attr['country'],
            'email' => $attr['email'],
            'concept' => $concept,
            'total' => $total . ' €',
            'subject' => 'Terrae: Reservation complete'
        );
        foreach ($data as $key => $string) {
            $tpl = str_replace('{{' . $key . '}}', $string, $tpl);
        }
        $this->sendMail($tpl, array($data['email']), $data['subject'], $this->_admin);


        $tpl = file_get_contents(ROOT . 'views/templates/booking-mail.html');
        unset($data);
        $concept = '<table bgcolor="fffefd" align="center" width="680" style="padding:20px;margin-bottom: 2px;">
                <tr>
                    <td>CONCEPT:</td>
                    <td>' . $attr['name'] . '</td>
                </tr>
                <tr>
                  <td>YOUR GIFT CODE:</td>
               <td>' . $attr['code'] . '</td>
                </tr>
               <td> GET YOUR GIFT:</td>
               <td><a href="http://terrae.com.mialias.net/gift/chose-a-gift">http://terrae.com.mialias.net/gift/chose-a-gift</a></td>
                </tr>
            </table>';
        $data = array(
            'first_name' => $attr['rec_first_name'],
            'last_name' => $attr['rec_last_name'],
            'phone' => $attr['rec_phone'],
            'city' => $attr['rec_city'],
            'country' => $attr['rec_country'],
            'email' => $attr['rec_email'],
            'concept' => $concept,
            'total' => 'FREE!!',
            'subject' => 'Terrae: You recived a gift from ' . $attr['first_name'] . ' ' . $attr['last_name']
        );

        foreach ($data as $key => $string) {
            $tpl = str_replace('{{' . $key . '}}', $string, $tpl);
        }
        $this->sendMail($tpl, array($data['email']), $data['subject'], false, $attr['email']);
    }

}
