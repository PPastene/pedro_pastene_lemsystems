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
                            <input type="text" class="form-control" id="searchInput" v-model="artista" placeholder="Ej: Eminem">
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
            artista: '',
            data: {
                artista: {id: null, nombre: null},
                canciones: null,
                fecha_busqueda: null
            },
            excel: {
                id: null
            }
        }),
        mounted() {

        },
        methods: {
            searchByArtistName: function(){
                this.data.artista.id = null
                this.data.artista.nombre = null
                this.data.canciones = null
                this.data.fecha_busqueda = null
                this.excel.id = null

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
                        this.data.canciones = response.data.data
                        this.data.fecha_busqueda = new Date().toLocaleString()
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
