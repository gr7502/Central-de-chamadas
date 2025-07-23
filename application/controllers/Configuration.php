<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuration extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Configuration_model');
        $this->load->model('Chamada_model');
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
    }
    
    public function index(){
        $data['config'] = $this->Configuration_model->get_config();
        $this->load->view('configuration_view', $data);
    }
    
    public function update(){
    
    $valid_views = ['painel', 'painel_2', 'painel_3', 'painel_4'];
    $panel_view = $this->input->post('panel_view');
    if (! in_array($panel_view, $valid_views)) {
        redirect('configuration?error=invalid_panel_view');
        return;
    }

    $data = [
        'primary_color' => $this->input->post('primary_color'),
        'image_url'     => $this->input->post('image_url'),
        'panel_view'    => $panel_view,
    ];

   
    if (!empty($_FILES['image_file']['name'])) {
        $this->load->library('upload', [
            'upload_path'   => './uploads/',
            'allowed_types' => 'gif|jpg|png|jpeg|webp|mp4|mp3',
            'max_size'      => 65535,
        ]);
        if ($this->upload->do_upload('image_file')) {
            $up = $this->upload->data();
            $data['image_url'] = base_url("uploads/{$up['file_name']}");
        } else {
            $error = $this->upload->display_errors();
            redirect('configuration?error=' . urlencode($error));
            return;
        }
    }

    if ($this->Configuration_model->update_settings($data)) {
        redirect('configuration?success=1');
    } else {
        redirect('configuration?error=1');
    }
}

    public function panel(){
        $config = $this->Configuration_model->get_config();
        $valid_views = ['painel', 'painel_2', 'painel_3', 'painel_4'];
        
       
        $view = in_array($config->panel_view, $valid_views)
              ? $config->panel_view
              : 'painel';
        
        $data = [
            'config'           => $config,
            'ultimasChamadas'  => $this->Chamada_model->get_ultimas_chamadas(5),
        ];
        
        $this->load->view($view, $data);
    }


    public function painel(){
        $config = $this->Configuration_model->get_config();
        $valid_views = ['painel', 'painel_2', 'painel_3', 'painel_4'];
        
        $view = in_array($config->panel_view, $valid_views)
            ? $config->panel_view
            : 'painel';
        
        $data = [
            'config'           => $config,
            'ultimasChamadas'  => $this->Chamada_model->get_ultimas_chamadas(4),
        ];
        
        $this->load->view($view, $data);
    }


    public function painel_2(){
        $config = $this->Configuration_model->get_config();
        $valid_views = ['painel', 'painel_2', 'painel_3', 'painel_4'];
        
    
        $view = in_array($config->panel_view, $valid_views)
            ? $config->panel_view
            : 'painel_2';
        
        $data = [
            'config'           => $config,
            'ultimasChamadas'  => $this->Chamada_model->get_ultimas_chamadas(6),
        ];
        
        $this->load->view($view, $data);
    }

    public function painel_3(){
        $config = $this->Configuration_model->get_config();
        $valid_views = ['painel', 'painel_2', 'painel_3', 'painel_4'];
        
        $view = in_array($config->panel_view, $valid_views)
            ? $config->panel_view
            : 'painel_3';
        
        $data = [
            'config'           => $config,
            'ultimasChamadas'  => $this->Chamada_model->get_ultimas_chamadas(5),
        ];
        
        $this->load->view($view, $data);
    }

    public function painel_4(){
        $config = $this->Configuration_model->get_config();
        $valid_views = ['painel', 'painel_2', 'painel_3', 'painel_4'];
        
        $view = in_array($config->panel_view, $valid_views)
            ? $config->panel_view
            : 'painel_4';
        
        $data = [
            'config'           => $config,
            'ultimasChamadas'  => $this->Chamada_model->get_ultimas_chamadas(5),
        ];
        
        $this->load->view($view, $data);
    }
}