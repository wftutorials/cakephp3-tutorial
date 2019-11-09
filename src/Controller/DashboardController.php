<?php


namespace App\Controller;

use Cake\ORM\TableRegistry;

use App\Model\Entity\Country;
use App\Model\Table\CountriesTable;
use Cake\View\Helper\FormHelper;

class DashboardController extends AppController
{

    public function home(){
        $this->autoRender = false;
        echo "hello world";
    }

    public function help(){
        $this->viewBuilder()->setLayout(false);
        echo "a help page";
    }

    public function faq(){
        $this->autoRender = false;
        echo "this is the faq";
    }

    public function logs( $id, $type ){
        $this->autoRender = false;
        echo "this is the logs" . $id . ' ' . $type;
    }

    public function users(){
       // $this->viewBuilder()->setLayout(false);
        $this->render("users_view");
    }

    public function members(){
        $this->viewBuilder()->setLayout('main');
        $data = [
            'name' => 'Wynton',
            'age' => '23',
            'dob' => 'neveruary',
        ];
        $this->set('pageTitle', "Page Title");
        $this->set($data);
        $this->render();
    }

    public function guide(){
        $this->viewBuilder()->setLayout('main');
        $this->render();
    }

    public function countries(){
        $articles = TableRegistry::getTableLocator()->get('Countries');
        $query = $articles->find();
        $this->set('countries', $query);
        $this->render();
    }

    public function create(){
        $this->autoRender = false;
        $countryTb = TableRegistry::getTableLocator()->get('Countries');
        $country = $countryTb->newEntity();
        $country->country_name = "Wynton Island";
        $countryTb->save($country);
        echo var_dump($country);

    }

    public function update(){
        $this->autoRender = false;
        $countryTb = TableRegistry::getTableLocator()->get('Countries');
        $country = $countryTb->get(1000);
        $country->country_name = "Wynton Updated Island";
        $countryTb->save($country);
        echo var_dump($country);
    }

    public function view(){
        $this->autoRender = false;
        $countryTb = TableRegistry::getTableLocator()->get('Countries');
        $countries = $countryTb->find("all",[
            'conditions' => 'Countries.country_name = "Trinidad ( T&T)"'
        ])->limit(100);
        $country = $countries->first();
        echo $country->country_name . "<br>";
    }

    public function form(){
        $this->autoRender = false;
        $countryTb = TableRegistry::getTableLocator()->get('Countries');
        if(isset($_POST['country_name'])){
            $model = $countryTb->newEntity();
            $model->country_name = $_POST['country_name'];
            $countryTb->save($model);
            echo "Country " . $model->country_name . " saved";
        }else{
            $model = $countryTb->newEntity();
            $this->set('model',$model);
            $this->render();
        }
    }
}
