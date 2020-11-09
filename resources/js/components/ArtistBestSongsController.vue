<template>
    <div>
        <div class="container">
            <div class="row justify-content-center mx-auto text-center">
                <h1>Busqueda de los 10 temas mas populares</h1>
            </div>
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto text-center form p-4">
                    <div class="justify-content-center">
                        <div class="form-group">
                            <input type="text" class="form-control" id="searchInput" v-model="artista" placeholder="Ej: Eminem">
                        </div>
                        <button id="searchButtton" v-on:click="searchByArtistName" class="btn btn-primary btn-lg">Buscar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" v-if="data.canciones !== null">
            <div class="row card-deck">
                <div v-for="(item, index) in data.canciones" v-bind:key="index" class="col md-4">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top img-responsive" v-bind:src="item.album.cover_big">
                        <div class="card-body">
                            <p class="card-text">Titulo: {{ item.title_short }}</p>
                            <p class="card-text">Album: {{ item.album.title }}</p>
                            <p class="card-text">Reproduccion:<br><audio controls preload="none"><source v-bind:src="item.preview" type="audio/mpeg">Your browser does not support the audio element.</audio></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            contador: 0,
            artista: '',
            data: {
                artista: {id: null, nombre: null},
                canciones: null
            }
        }),
        mounted() {

        },
        methods: {
            searchByArtistName: function(){
                this.data.artista.id = null
                this.data.artista.nombre = null
                this.data.canciones = null

                if(this.artista == null || this.artista == '')
                {
                    alert("Porfavor ingrese el nombre de un artista")
                    return
                }
                axios
                    .get(`https://cors-anywhere.herokuapp.com/https://api.deezer.com/search/artist?q=${this.artista}`)
                    .then(response => {
                        if (response.data.data.length == 0){
                            alert("El artista no existe en el sistema")
                            return
                        }
                        this.data.artista.id = response.data.data[0].id
                        this.data.artista.nombre = response.data.data[0].name
                        this.searchSongsByArtistId(this.data.artista.id)
                    });
            },
            searchSongsByArtistId: function(artistId){
                axios
                    .get(`https://cors-anywhere.herokuapp.com/https://api.deezer.com/artist/${artistId}/top?limit=10`)
                    .then(response => {
                        if(response.data.data.length == 0){
                            alert("El artista no tiene canciones en el sistema")
                            return
                        }
                        this.data.canciones = response.data.data
                    });
            }
        }
    }
</script>
