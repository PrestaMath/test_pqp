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

    public function render(){
        return view('livewire.moviedb');
    }
    
    public function update_day_trending(){
        $this->update_trending("day");
    }

    public function update_week_trending(){
        $this->update_trending("week");
    }

    public function get_movie_detail($id){

        $cache =  DB::select('SELECT data FROM movie_detail WHERE id_movie = ?', [$id]);

        if ($cache && isset($cache[0]) ){
            $json = $cache[0]->data;
            $this->moviedb= "utilisation du cache";
        } else {
            $url= "https://api.themoviedb.org/3/movie/$id";
            $json = $this->api_moviedb($url);
            $this->cache_movie_detail($id, $json);
            $this->moviedb= "appel api";
        }

        $detail = json_decode($json, true);
          
        $this->movie_detail = $detail;

    }

    public function cache_movie_detail($id, $json){
        DB::statement('INSERT INTO movie_detail (id_movie,data) VALUES (?, ?)', [ $id, $json]);
    }

    public function update_trending($period){

        $cache =  DB::select('SELECT data FROM trending WHERE period = ? and date = ?', [$period , date('Ymd')]);

        if ($cache && isset($cache[0]) ){
            $json = $cache[0]->data;
            $this->movie_db = "utilisation du cache";
        } else {
            $this->moviedb= "appel api";
            $url= "https://api.themoviedb.org/3/trending/movie/$period";    // ou "month"
            
            $json = $this->api_moviedb($url);

            $this->cache_trending($period, $json);
        }
        $movies = json_decode($json, true);

        $this->movies = $movies['results'];    
     
    }

    public function cache_trending($period, $json){

        DB::statement('INSERT INTO trending (date, period,data) VALUES (?, ?, ?)', 
        [date('Ymd'), $period, $json]);
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

        
        if (curl_errno($ch)) {
          $this->erreur_curl=curl_error($ch);
        } 

        curl_close($ch);

        return $response;
    }
}
