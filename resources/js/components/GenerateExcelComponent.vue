<template>
    <div>
        <div class="container">
            <div class="row justify-content-center mx-auto text-center">
                <h1>Generar Excel con los temas mas populares del artista</h1>
            </div>
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto text-center form p-4">
                    <div class="justify-content-center">
                        <div class="form-group">
                            <input type="text" class="form-control" id="searchInput" v-model="artist" placeholder="Ej: Eminem">
                        </div>
                        <button id="searchButtton" v-on:click="searchByArtistName" class="btn btn-primary btn-lg">Buscar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container justify-content-center mx-auto text-center" v-if="excel.id !== null">
            <a class="btn btn-success btn-lg" v-bind:href="'/excel/download/'+ excel.id">Generar Excel</a>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            artist: '',
            data: {
                artist: {id: null, name: null},
                songs: null,
                search_date: null
            },
            excel: {
                id: null
            }
        }),
        mounted() {

        },
        methods: {
            searchByArtistName: function(){
                this.data.artist.id = null
                this.data.artist.name = null
                this.data.songs = null
                this.data.search_date = null
                this.excel.id = null

                if(this.artist == null || this.artist == '')
                {
                    alert("Porfavor ingrese el nombre de un artista")
                    return
                }
                axios
                    .get(`https://cors-anywhere.herokuapp.com/https://api.deezer.com/search/artist?q=${this.artist}`)
                    .then(response => {
                        if (response.data.data.length == 0){
                            alert("El artista no existe en el sistema")
                            return
                        }
                        this.data.artist.id = response.data.data[0].id
                        this.data.artist.name = response.data.data[0].name
                        this.searchSongsByArtistId(this.data.artist.id)
                    });
            },
            searchSongsByArtistId: function(artistId){
                axios
                    .get(`https://cors-anywhere.herokuapp.com/https://api.deezer.com/artist/${artistId}/top?limit=10`)
                    .then(response => {
                        this.data.songs = response.data.data
                        this.data.search_date = new Date().toLocaleString()
                        this.sendData()
                    });
            },
            sendData: function(){
                axios
                    .post('/excel/save', this.data)
                    .then(response => {
                        this.excel.id = response.data;
                    })
                    .catch(e => console.log(`Error: ${e}`))
            }
        }
    }
</script>
