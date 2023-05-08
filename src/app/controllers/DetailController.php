<?php

use Phalcon\Mvc\Controller;


class DetailController extends Controller
{
    public function indexAction()
    {
        $val = $_GET['isbn'];
        $value = str_replace(" ", "+", $val);
        $curl = curl_init();
        $url = "https://openlibrary.org/api/books?bibkeys=ISBN:$val&jscmd=details&format=json";
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($data, true);
        foreach ($result['ISBN:'.$val] as $value) {
            $this->view->data = '<div class="row">
            <div class="col-md-6">
                <div class="images p-3">
                    <div class="text-center p-4"> <img src="//covers.openlibrary.org/b/id/'.$_GET['id'].
                    '-L.jpg" width="400" /> </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="product p-4">
                    <div class="mt-4 mb-3 m-3"> <span class="text-uppercase text-muted brand">'.$value['title'].'</span>
                        <h5 class="text-uppercase m-3">Author Name: '.$value['authors'][0]['name'].'</h5>
                        <div class="price m-3 d-flex flex-row align-items-center">Publisher: '.
                        $value['publishers'][0].'<span class="act-price"></span></div>
                        <div class="m-3"><span>Publish Date:  '.$value['publish_date'].'</span> </div>
                        <div class="m-3"><span>Total Pages:  '.$value['number_of_pages'].'</span> </div>
                    </div>
                    <div class="cart mt-4 ml-3 align-items-center"><'.
                    'a href="'.$result['ISBN:'.$val]['preview_url'].
                    '/mode/2up?view=theater" class="btn btn-danger text mr-2 px-4">Preview Now</a>
                    </div>
                </div>
            </div>
        </div>';
        }
    }
}