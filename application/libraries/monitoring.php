<?php

/**
    Este archivo se considera como una librería de desarrollo propio para facilitar la notificación de acciones en el sistema
    con el fin de desarrollar auditorías del sistema.

    MAS INFO: https://codeigniter.com/user_guide/general/creating_libraries.html

 */

defined('BASEPATH') OR exit('No direct script access allowed');

    class Monitoring {

        private $format_day;
        private $file_name;
        private $logs_basepath; 
        private $hour_format;

        public function __construct() {

            $this->CI =& get_instance();
            $this->CI->load->helper('date');
            
            $this->format_day = "%Y%m%d";
            $this->hour_format = "%H:%i:%s";
            $this->file_name = mdate($this->format_day) . ".txt";
            $this->logs_basepath = $_SERVER['DOCUMENT_ROOT'] . '/votuca/application/logs/';
            $file = fopen($this->logs_basepath . $this->file_name, "a");
            fwrite($file, "");
            fclose($file);
        }


        public function register_action_login($username, $flag = "")
        {
            
            $action_message = "[" . mdate($this->hour_format) . "] [LOGIN]" . " El usuario " . $username;

            if($flag == 'success')
            {
                $action_message .= " inició sesión exitosamente.";
            }
            else
            {
                $action_message .= " realizó un intento fallido.";
            }

            file_put_contents($this->logs_basepath . $this->file_name, $action_message . "\r", FILE_APPEND);
        }

        public function register_action_logout($username)
        {
            $action_message = "[" . mdate($this->hour_format) . "] [LOGOUT]" . " El usuario " . $username . " cerró sesión.";
            file_put_contents($this->logs_basepath . $this->file_name, $action_message . "\r", FILE_APPEND);
        }

}