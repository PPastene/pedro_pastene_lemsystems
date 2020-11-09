<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <h1>Las 10 canciones mas escuchadas</h1>
            </div>
        </div>
        <div class="container">
            <div id="chartdiv" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
    }),
    created(){
    },
    mounted() {
        this.getData()
    },
    methods:{
        getData: function() {
            axios
                .get(`https://cors-anywhere.herokuapp.com/https://api.deezer.com/chart/0/tracks`)
                .then(response => {
                    this.getArrayofSongs(response.data)
                })
                .catch(e => { console.log(e) }
            )
        },
        getArrayofSongs: function(data){
            var array = []
            data.data.forEach (function(valor, index){
                array.push({
                    rank: data.data[index].rank,
                    title: data.data[index].title_short,
                    artist: data.data[index].artist.name
                })
            })
            this.generateGraphs(array)
        },
        generateGraphs: function(data){
            AmCharts.addInitHandler( function( chart ) {

            // Check if `orderByField` is set
            if ( chart.orderByField === undefined ) {
                // Nope - do nothing
                return;
            }

            // Re-order the data provider
            chart.dataProvider.sort( function( a, b ) {
                if ( a[ chart.orderByField ] > b[ chart.orderByField ] ) {
                return -1;
                } else if ( a[ chart.orderByField ] == b[ chart.orderByField ] ) {
                return 0;
                }
                return 1;
            } );

            }, [ "serial" ] );

            var chart = AmCharts.makeChart( "chartdiv", {
                "type": "serial",
                "orderByField": "rank",
                "dataProvider": data,
                "categoryField": "title",
                "startDuration": 1,
                "graphs": [{
                    "balloonText": "Artist: <b>[[artist]]</b><br>Deezer Rank: <b>[[value]]</b>",
                    "valueField": "rank",
                    "type": "column",
                    "fillAlphas": 0.8,
                }],
                "categoryAxis": {
                    "gridCount": data.length,
                    //"autoGridCount": false,
                    //"gridPosition": "start",
                    "labelRotation": 45
                }
            });
        }
    }
}

</script>
