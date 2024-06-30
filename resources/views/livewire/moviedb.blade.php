<div>
    <h1>{{ $moviedb }}</h1>
 
    <button wire:click="update_day_trending">Mettre à jour tendance journée</button>
    <button wire:click="update_week_trending">Mettre à jour tendance semaine</button>
    

    <h2>Tendances</h2>
    @foreach ($movies as $movie)
        <img src="https://image.tmdb.org/t/p/w300{{ $movie['backdrop_path'] }}">
        <p>
            {{ $movie['title'] }}  // Score {{ $movie['vote_average'] }} 

            @if (!empty($movie_detail)  && $movie_detail['id'] == $movie['id'] )
                <p><a href="{{$movie_detail['homepage']}}" target="_blank">Site du film</a></p>
            @else
                
            @endif

           
            <button wire:click="get_movie_detail({{ $movie['id'] }})">Détail du film</button>

        </p>
    @endforeach
</div>