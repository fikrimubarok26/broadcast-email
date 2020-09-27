<?php

use PHPMailer\PHPMailer\PHPMailer;

class Request extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->uploadTypes = array(
            'doc' => ['allowed_types' => 'pdf|docx|doc'],
            'img' => ['allowed_types' => 'jpg|jpeg|png'],
        );
    }

    public function id($id)
    {
        return array('md5(sha1(md5(sha1(sha1(md5(md5(sha1(md5(md5(id))))))))))' => $id);
    }

    public function encKey($key)
    {
        return "md5(sha1(md5(sha1(sha1(md5(md5(sha1(md5(md5($key))))))))))";
    }

    public function acak($text)
    {
        return md5(sha1(md5(sha1(sha1(md5(md5(sha1(md5(md5($text))))))))));
    }

    function print($array)
    {
        ob_clean();
        echo "<pre>";
        echo print_r($array);
        echo "</pre>";
        exit(0);
    }

    public function json($array)
    {
        echo "<pre>";
        echo json_encode($array);
        echo "</pre>";
    }

    public function query()
    {
        echo $this->db->last_query();
    }

    public function input($input)
    {
        return htmlspecialchars(ltrim(rtrim($_POST[$input])));
    }

    public function all($guarded = null)
    {
        $request = $_POST;
        foreach ($request as $key => $value) {
            $result[$key] = $this->input($key);
        }
        if ($guarded != null) {
            foreach ($guarded as $guard_ => $value) {
                if ($value == false) {
                    unset($request[$guard_]);
                } else {
                    unset($request[$guard_]);
                    $request[$guard_] = $value;
                }
            }
        }
        return $request;
    }

    public function upload($data)
    {
        $config = array(
            'upload_path' => './uploads/' . $data['path'],
            // 'allowed_types' = 'pdf|doc|docx|jpg|jpeg|';
            'encrypt_name' => $data['encrypt'],
        );
        $config = array_merge($config, $this->uploadTypes[$data['type']]);
        $this->load->library('upload', $config);
        $uploading = $this->upload->do_upload($data['file']) ? true : false;
        if (!$uploading) {
            return array(
                'message' => 'error',
                'data' => $this->upload->display_errors(),
            );
        } else {
            return array(
                'message' => 'success',
                'data' => $this->upload->data(),
            );
        }
    }

    public function upload_form($data)
    {
        $encrypt = (isset($data['encrypt']) == true) ? true : false;
        $fileName = (isset($data['fileName']) != '') ? $data['fileName'] : null;
        $customInput = (isset($data['customInput']) != '') ? $data['customInput'] : null;
        if ($fileName) {
            $config = array(
                'upload_path' => './uploads/' . $data['path'],
                'file_name' => $data['fileName'],
            );
        } else {
            $config = array(
                'upload_path' => './uploads/' . $data['path'],
                'encrypt_name' => $encrypt,
            );
        }
        // echo count($_FILES['lampiran']['name']);
        // $this->print($data['file']);
        $config = array_merge($config, $this->uploadTypes[$data['type']]);
        $this->load->library('upload', $config);
        $uploading = $this->upload->do_upload($data['file']) ? true : false;
        if (!$uploading) {
            return $data_ = $this->all($customInput);
        } else {
            $data_ = $this->all($customInput);
            $upload_data = $this->upload->data();
            $result = array_merge($data_, [$data['file'] => $upload_data['file_name']]);
            // print_r($result);
            return $result;
        }
    }

    public function upload_form_multi($data)
    {
        $fileName = "";
        $result = [];
        $customInput = (isset($data['customInput']) != '') ? $data['customInput'] : null;
        // $this->print($_FILES[$data['file']]['name']);
        $countfiles = count($_FILES[$data['file']]['name']);
        $success = 0;
        for ($i = 0; $i < $countfiles; $i++) {
            if (!empty($_FILES[$data['file']]['name'][$i])) {

                $fileNameNa = str_replace(["'", "`", ";", "^"], "", $_FILES[$data['file']]['name'][$i]);

                $_FILES['file']['name'] = $fileNameNa;
                $_FILES['file']['type'] = $_FILES[$data['file']]['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES[$data['file']]['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES[$data['file']]['error'][$i];
                $_FILES['file']['size'] = $_FILES[$data['file']]['size'][$i];

                if ($data['encrypt'] != false) {
                    $config = array(
                        'upload_path' => './uploads/' . $data['path'],
                        'encrypt_name' => true,
                    );
                } else {
                    $config = array(
                        'upload_path' => './uploads/' . $data['path'],
                        'encrypt_name' => false,
                        'file_name' => time() . "-" . $fileNameNa,
                    );
                }

                $config = array_merge($config, $this->uploadTypes[$data['type']]);

                $this->load->library('upload', $config);

                // File upload
                $uploading = $this->upload->do_upload('file') ? true : false;
                if ($uploading) {
                    // Get data about the file
                    $success++;
                    $uploadData = $this->upload->data();
                    $fileName .= $uploadData['file_name'] . ",";
                } else {
                    return $this->upload->display_errors();
                }
            }
        }
        $fileName = substr($fileName, 0, strlen($fileName) - 1);
        return $result = [
            'total' => $countfiles,
            'success' => $success,
            'data' => array_merge($this->all($data['customInput']), ['lampiran' => $fileName]),
        ];
    }

    public function sendMail($dataNa)
    {

        require APPPATH . 'libraries/phpmailer/src/Exception.php';
        require APPPATH . 'libraries/phpmailer/src/PHPMailer.php';
        require APPPATH . 'libraries/phpmailer/src/SMTP.php';

        // PHPMailer object
        $response = false;
        $mail = new PHPMailer();

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; //sesuaikan sesuai nama domain hosting/server yang digunakan
        $mail->SMTPAuth = true;
        $mail->Username = 'suksesdianglobaltech@gmail.com'; // user email
        $mail->Password = 'suksespasti123'; // password email
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('suksesdianglobaltech@gmail.com', ''); // user email
        // $mail->addReplyTo('xxx@hostdomain.com', ''); //user email

        // $mail->addAddress('titilestiasriwahyuni@gmail.com'); //email tujuan pengiriman email

        if ($dataNa['emailPangkat'] != '') {
            foreach  ($dataNa['emailPangkat'] as $key) {
                $mail->addAddress($key); 
            }
        }

        if ($dataNa['emailPersonal'] != '') {
            foreach ($dataNa['emailPersonal'] as $key) {
                $mail->addAddress($key); 
            }
        }


        $mail->Subject = $dataNa['subjek']; //subject email
        $mail->isHTML(true);

        $mail->AddEmbeddedImage('assets/images/sesko.png', 'logo');
        $mail->AddEmbeddedImage('assets/images/bg.png', 'bg');
        $mailContent = $this->load->view('Email/tampilanEmail', $dataNa, TRUE);
        $mail->Body = $mailContent;

        // Send email
        return $mail;
    }
}
