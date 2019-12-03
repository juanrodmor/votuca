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
                if($flag == 'blocked')
                {
                    $action_message .= " bloqueado o suspendido intentó acceder.";
                }
                else
                {
                    $action_message .= " realizó un intento fallido.";
                }
            }

            file_put_contents($this->logs_basepath . $this->file_name, $action_message . "\r\n", FILE_APPEND);
        }

        public function register_action_logout($username)
        {
            $action_message = "[" . mdate($this->hour_format) . "] [LOGOUT]" . " El usuario " . $username . " cerró sesión.";
            file_put_contents($this->logs_basepath . $this->file_name, $action_message . "\r\n", FILE_APPEND);
        }

        public function register_action_vote($username)
        {
            $action_message = "[" . mdate($this->hour_format) . "] [VOTE]" . " El usuario " . $username . " ha realizado su voto.";
            file_put_contents($this->logs_basepath . $this->file_name, $action_message . "\r\n", FILE_APPEND);
        }

        public function register_action_deleteUsuario($username)
        {
            $action_message = "[" . mdate($this->hour_format) . "] [DELETE USER]" . " El usuario " . $username . " ha sido dado de baja en la plataforma.";
            file_put_contents($this->logs_basepath . $this->file_name, $action_message . "\r\n", FILE_APPEND);
        }

        public function register_action_mElectoralConfirmed($username, $votacionName)
        {
            $action_message = "[" . mdate($this->hour_format) . "] [ME CONFIRMATION]" . " El miembro de mesa " . $username . " confirma la apertura en la votación " . $votacionName . ".";
            file_put_contents($this->logs_basepath . $this->file_name, $action_message . "\r\n", FILE_APPEND);
        }

        public function register_action_openBox($votacionName)
        {
            $action_message = "[" . mdate($this->hour_format) . "] [OPEN BOX]" . " La votación " . $votacionName . " procede a la apertura de urnas.";
            file_put_contents($this->logs_basepath . $this->file_name, $action_message . "\r\n", FILE_APPEND);
        }
		
		public function register_action_closeBox($votacionName)	//Muestra que una votación ha finalizado.
		{
			$action_message = "[" . mdate($this->hour_format) . "] [CLOSE BOX]" . " La votación " . $votacionName . " cierra sus urnas.";
            file_put_contents($this->logs_basepath . $this->file_name, $action_message . "\r\n", FILE_APPEND);
		}
		
		public function register_action_closeBoxInvalid($votacionName) //Muestra que una votación ha sido invalidada.
		{
			$action_message = "[" . mdate($this->hour_format) . "] [INVALID VOTATION]" . " La votación " . $votacionName . " no es válida y finaliza.";
            file_put_contents($this->logs_basepath . $this->file_name, $action_message . "\r\n", FILE_APPEND);
		}
		
		public function register_action_mElectoralConfirmedClose($username, $votacionName) //Muestra que un miembro quiere cerrar una votación.
		{
			$action_message = "[" . mdate($this->hour_format) . "] [ME CLOSING]" . " El miembro de mesa " . $username . " confirma el cierre de la votación " . $votacionName . ".";
            file_put_contents($this->logs_basepath . $this->file_name, $action_message . "\r\n", FILE_APPEND);
		}
}