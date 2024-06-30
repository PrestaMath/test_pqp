<?php

namespace App\Livewire;

use Livewire\Component;

class Moviedb extends Component
{

    public $moviedb = "Base de données movieDb";

    public function render()
    {
        $this->update();
        return view('livewire.moviedb');
    }
    
    public function update(){
        
        $apiKey = env('API_KEY_THEMOVIEDB');
        $this->moviedb= $apiKey;

      
// L'URL de l'API
$url = 'https://api.themoviedb.org/3/movie/11';
//$url = 'https://developers.themoviedb.org/3/trending/get-trending'; // ne fonctionne pas 301

// trending
 $url= "https://api.themoviedb.org/3/trending/movie/day";
// Le token d'accès


// Initialiser une session cURL
$ch = curl_init();

// Configurer les options de cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $apiKey, 
    'accept: application/json'
    
));

// Désactiver la vérification SSL
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

// Exécuter la requête
$response = curl_exec($ch);

// Vérifier s'il y a une erreur
if (curl_errno($ch)) {
    //echo 'Erreur cURL : ' . curl_error($ch);
} else {
    // Afficher la réponse
    //echo $response;
}

// Fermer la session cURL
curl_close($ch);

$this->moviedb= $response;

    }
}
