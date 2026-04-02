<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $data = [];

    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $config = $this->db->get_where('configurations', ['id' => 1])->row();

        $primaryColor = isset($config->primary_color) && $config->primary_color
            ? $config->primary_color
            : '#4f46e5';

        $secondaryColor = $this->adjustBrightness($primaryColor, 30);
        $accentColor = $this->adjustBrightness($primaryColor, 50);

        $panelView = isset($config->panel_view) && $config->panel_view ? $config->panel_view : 'painel';

        $this->data = [
            'config' => $config,
            'panel_view' => $panelView,
            'primary_color' => $primaryColor,
            'secondary_color' => $secondaryColor,
            'accent_color' => $accentColor,
            'text_color' => '#1f2937',
            'light_bg' => '#f8fafc',
            'shadow_color' => 'rgba(0,0,0,0.1)',
        ];

        $this->data['montarMenu'] = $this->load->view('template/sidebar', $this->data, true);
    }

    protected function adjustBrightness($hex, $steps, $opacity = 1)
    {
        $hex = ltrim((string) $hex, '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        if (strlen($hex) !== 6 || !ctype_xdigit($hex)) {
            $hex = '4f46e5';
        }

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        $r = max(0, min(255, $r + $steps));
        $g = max(0, min(255, $g + $steps));
        $b = max(0, min(255, $b + $steps));

        if ($opacity < 1) {
            return sprintf('rgba(%d, %d, %d, %s)', $r, $g, $b, $opacity);
        }

        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }

    public function loadView($view, $data = [], $titulo = null)
    {
        $data = array_merge($this->data, $data);
        $data['titulo'] = $titulo ?: (isset($data['titulo']) ? $data['titulo'] : 'Painel');
        $data['conteudo'] = $this->load->view($view, $data, true);

        return $this->load->view('layouts/main', $data);
    }
}
