<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();;
		$this->load->model('Configuration_model');
    }

    public function index() {
        // Carrega os dados de configuração do banco de dados
        $data['config'] = $this->Configuration_model->get_config();

        $panel_view = $this->Configuration_model->get_panel_view();
        $valid_views = ['painel', 'painel_2', 'painel_3', 'painel_4'];
        if (!$panel_view || !in_array($panel_view, $valid_views)) {
            $panel_view = 'painel';
        }
        $data['panel_view'] = $panel_view;

        // Carrega a view
        $this->load->view('home', $data);
    }
}