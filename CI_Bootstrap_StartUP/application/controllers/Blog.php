<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MY_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
    }

    public function index($category = null)
    {
        $data = [];
        $head = [];
        $head['title'] = lang('blog_title');
        $head['description'] = lang('blog_description');
        $head['keywords'] = lang('blog_keywords');
        $rowscount = $this->Public_model->blogPostsCount($category);
        $data['blog_posts'] = $this->Public_model->getBlogPosts($this->num_rows, 0, $category);
        $data['blog_categories'] = $this->Public_model->getBlogCategories();
        $data['category'] = $category;
        $data['pagination'] = $rowscount > $this->num_rows ? true : false;
        $data['pagin_results'] = $this->num_rows;
        $this->load->vars(['show_masonry' => true]);
        $this->render('blog', $head, $data);
    }

    public function post($url = null)
    {
        $blog = $this->Public_model->getBlogPostByUrl($url);
        if (empty($blog) || $url == null) {
            show_404();
        }
        $data = [];
        $head = [];
        $head['title'] = $blog['title'] . ' &raquo; Zvezdev.com';
        $head['description'] = $this->getDescription($blog['description']);
        $head['keywords'] = $this->getKeyword($blog['title']);
        $head['use_h1_tag'] = false;
        $data['blog'] = $blog;
        $head['image'] = base_url(BLOG_IMAGE . $blog['image']);
        $data['lastFromCategory'] = $this->Public_model->getLastBlogPosts(3, $blog['category'], $blog['blog_id']);
        $this->render('blog_post', $head, $data);
    }

    /*
     * Ajax pagination
     */

    public function getMoreResults()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $result = $this->Public_model->getBlogPosts($this->num_rows, $_POST['loadFrom'], $_POST['category'] == 'false' ? null : $_POST['category']);
        if (!empty($result)) {
            foreach ($result as $post) {
                ?>
                <div class="col-sm-4 grid-item">
                    <div class="post">
                        <a href="<?= LANG_URL . '/блог/' . $post['url'] ?>">
                            <img src="<?= base_url(BLOG_IMAGE . $post['image']) ?>" alt="<?= $post['title'] ?>">
                        </a>
                        <div class="body">
                            <a href="<?= LANG_URL . '/блог/' . $post['url'] ?>">
                                <h3><?= $post['title'] ?></h3>
                            </a>
                            <p><?= word_limiter($post['description'], 20) ?></p>
                        </div>
                        <div class="footer">
                            <a href="<?= LANG_URL . '/блог/категория/' . $post['category_url'] ?>"><?= $post['blog_category'] ?></a>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo 0;
        }
    }

}
