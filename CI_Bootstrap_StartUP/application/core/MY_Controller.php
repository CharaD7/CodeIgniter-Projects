<?php

class MY_Controller extends MX_Controller
{

    protected $gallery_path;

    public function __construct()
    {
        parent::__construct();
        $this->gallery_path = GALLERY_PATH;
    }

    public function render($view, $head, $data = null, $footer = null)
    {
        $this->loadValueStores();
        $this->load->view('_parts/header', $head);
        $this->load->view($view, $data);
        $this->load->view('_parts/footer', $footer);
    }

    private function loadValueStores()
    {
        $valueStores = $this->Admin_model->getValueStores();
        $vars = array();
        if (!empty($valueStores)) {
            foreach ($valueStores as $valueStore) {
                $vars[$valueStore['my_key']] = $valueStore['value'];
            }
        }
        $this->load->vars($vars);
    }

    protected function replaceGalleryImages($textWithImages)
    {
        preg_match_all("|\[.*\]|", $textWithImages, $out);
        $html_images = [];
        foreach ($out[0] as $folder) {
            $folder = str_replace('[', '', $folder);
            $folder = str_replace(']', '', $folder);
            $folder = strip_tags($folder);
            $f_imgs = '';
            $f_imgs = glob($this->gallery_path . $folder . '/' . "*.{jpg,png,gif,JPG,PNG,GIF,jpeg}", GLOB_BRACE);
            $html_images[$folder] = '<div class="row gallery">';
            foreach ($f_imgs as $fimg) {
                $html_images[$folder] .= '<div class="col-xs-6 col-sm-4"><img src="' . base_url($fimg) . '" alt="" class="img-responsive"></div>';
            }
            $html_images[$folder] .= '</div>';
        }
        foreach ($html_images as $folder_name => $fimages) {
            $textWithImages = str_replace('[' . $folder_name . ']', $fimages, $textWithImages);
        }
        return $textWithImages;
    }

    protected function getKeyword($keyword)
    {
        $remove_less_words = preg_replace('/\b\w{1,2}\b/u', '', $keyword);
        $remove_spaces = str_replace(' ', ',', $remove_less_words);
        $keyword = str_replace(',,', ',', $remove_spaces);
        return $keyword;
    }

    protected function getDescription($description)
    {
        $description = character_limiter(strip_tags($description), 300);
        $description = trim(preg_replace('/\s\s+/', ' ', $description));
        return $description;
    }

}
