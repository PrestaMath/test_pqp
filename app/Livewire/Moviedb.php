<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Moviedb extends Component
{
    public $erreur_curl='';
    public $moviedb = "";
    public $movies = [];
    public $movie_detail=[];

    public function render()
    {
       
        return view('livewire.moviedb');
    }
    
    public function update_day_trending(){
        $this->update_trending("day");
    }
    public function update_week_trending(){
        $this->update_trending("week");
    }

    public function get_movie_detail($id){

        $url= "https://api.themoviedb.org/3/movie/$id";    // ou "month"
        $detail = json_decode($this->api_moviedb($url), true);;
          
        $this->movie_detail = $detail;
        
    }
    public function update_trending($period){
        
        //$url = 'https://api.themoviedb.org/3/movie/11';
        // trending
        $url= "https://api.themoviedb.org/3/trending/movie/$period";    // ou "month"
        $movies = json_decode($this->api_moviedb($url), true);;

        $this->movies = $movies['results'];    
        $this->moviedb= "Aujourd'hui";
    }

    public function api_moviedb($url){
        
        $apiKey = env('API_KEY_THEMOVIEDB');
        $this->moviedb= $apiKey;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $apiKey, 
            'accept: application/json'
        ));

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);

        // Vérifier s'il y a une erreur
        if (curl_errno($ch)) {
          $this->erreur_curl=curl_error($ch);
        } 

        curl_close($ch);

        //$arr = json_decode($response, true);
        return $response;
    }
}
