<?php

use Phalcon\Mvc\Controller;


class IndexController extends Controller
{
    public function indexAction()
    {
        // Redirect to view
    }
    public function searchAction()
    {
        $value = $_POST['search'];
        $value = str_replace(" ", "+", $value);
        $curl = curl_init();
        $url = "https://openlibrary.org/search.json?q=$value&mode=ebooks&has_fulltext=true";
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($data);
        foreach ($result->docs as $value) {
            $this->view->main .= '<div class="col-lg-3 col-md-6 col-sm-6 d-flex">
                  <div class="card w-100 my-2 shadow-2-strong">
                    <img src="//covers.openlibrary.org/b/id/'.$value->cover_i.
                    '-M.jpg" class="card-img-top" style="aspect-ratio: 1 / 1" />
                    <div class="card-body d-flex flex-column">
                      <h6 class="card-title">' . $value->title . '</h6>
                      <h6 class="card-title"><b>Author Name: </b>' . $value->author_name[0] . '</h6>
                      <p class="card-text"><b>published at</b> ' . $value->publish_date[0] . '</p>
                      <div class="card-footer d-flex align-items-end pt-3 px-0 pb-0 mt-auto">
                        <a href="/detail?isbn='.$value->isbn[1].
                        '&&id='.$value->cover_i.'" class="btn btn-primary shadow-0 me-1">Detail View</a>
                      </div>
                    </div>
                  </div>
                </div>';
          }
    }
}
