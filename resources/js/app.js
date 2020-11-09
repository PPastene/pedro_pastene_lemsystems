require('./bootstrap');
import AmCharts from 'amcharts3'
import AmSerial from 'amcharts3/amcharts/serial'

window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('artist-best-songs', require('./components/ArtistBestSongsController.vue').default);
Vue.component('song-ranking', require('./components/SongRankingComponent.vue').default);
Vue.component('generate-excel', require('./components/GenerateExcelComponent.vue').default);

const app = new Vue({
    el: '#app'
});
