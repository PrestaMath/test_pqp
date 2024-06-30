
<div>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                TheMovieDb
            </h2>
        </div>
    </header>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    

                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    
                    <img src="https://files.readme.io/29c6fee-blue_short.svg" class="block h-12 w-auto" />
                    

                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            TheMovieDb
                    </h2>
                </div>

                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                
                    <x-button type="button" wire:click="update_day_trending">
                        Tendance journée
                    </x-button>
                    <x-button type="button" wire:click="update_week_trending">
                        Tendance semaine
                    </x-button>

                    @foreach ($movies as $movie)
                    
                        <p class="mt-6 text-gray-500 leading-relaxed">
                                {{ $movie['title'] }}  // Score {{ $movie['vote_average'] }} 

                            

                                <img src="https://image.tmdb.org/t/p/w300{{ $movie['backdrop_path'] }}">    
                                <button wire:click="get_movie_detail({{ $movie['id'] }})">Détail du film</button>

                        
                        </p>
                        @if (!empty($movie_detail)  && $movie_detail['id'] == $movie['id'] )
                            <p class="mt-6 text-white-500 leading-relaxed bg-indigo-500">
                                <a href="{{$movie_detail['homepage']}}" target="_blank">Site du film

                                </a>
                            </p>
                        @endif
                    @endforeach
                    
                    </div>              
            </div>
        </div>
    </div>
</div>