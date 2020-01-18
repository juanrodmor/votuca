<?php

/**
    Este archivo se considera como una librería de desarrollo propio para facilitar y centralizar las tareas de comunicación vía correo electrónico con los
    diferentes miembros de la plataforma.
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Mailing
{
    private $config = array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'smtp_user' => 'votvotuca@gmail.com',
        'smtp_pass' => 'cadizvotuca19',
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'wordwrap' => TRUE
      );

      public function __construct()
      {
        $this->CI =& get_instance();
        $this->CI->load->library('email');
        $this->CI->load->model('usuario_model');

        $this->CI->email->initialize($this->config);
      }

      public function sendEmail($username, $asunto, $mensaje)
      {
        $email = $this->CI->usuario_model->getEmail($username);
        $this->CI->email->from($this->config['smtp_user'], 'VOTUCA');
        $this->CI->email->to($email);
        $this->CI->email->subject($asunto);
        $this->CI->email->message($mensaje);

        $this->CI->email->set_newline("\r\n");

        if($this->CI->email->send())
        {
            return "success";
        }
        else
        {
            //echo $this->email->print_debugger();
            return "failure";
        }

      }


}
