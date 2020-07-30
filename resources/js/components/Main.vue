<template>
    <v-sheet class="transparent fill-height">
        <v-container fluid class="fill-height dark">
            <v-row class="fill-height">
                <v-col class="fill-height">
                    <v-card class="gradient fill-height" dark max-width="1200px">
                        <v-tabs background-color="transparent">
                            <v-tab>Wyszukiwarka Okien</v-tab>
                            <v-tab>Skanowanie Okien</v-tab>
                            <v-tab-item background-color="transparent">
                                <v-card-title> Okna na Stojakach <v-spacer></v-spacer>
                                    <v-text-field  dark v-model="search" append-icon="mdi-magnify" label="Szukaj" single-line hide-details></v-text-field>
                                </v-card-title>
                                <v-data-table no-results-text="Brak pasujących wyników" fixed-header :search="search" class="overflow-y-auto" dark :headers="headers" :items="items" disable-pagination hide-default-footer height="200px"></v-data-table>
                            </v-tab-item>
                            <v-tab-item>
                                <v-container fluid>
                                    <v-row>
                                        <v-col cols="5">
                                            <span>Lokalizacja Stojaka</span>
                                            <v-select :items="sites" v-model="site" dark rounded autocomplete="off" filled single-line dense></v-select>
                                            <span>Otwórz stojak</span>
                                            <v-text-field @keyup.enter="addWindows" v-model="stand" dark rounded autocomplete="off" filled single-line dense></v-text-field>
                                            <span>Dodaj okna do stojaka</span>
                                            <v-text-field v-for="idx of indices" v-model="windows[idx]" :key="idx" ref="idx" dark rounded autocomplete="off" filled single-line dense @keyup.enter="addInput"></v-text-field>
                                        <v-col><v-btn small dark>Zamknij Stojak</v-btn></v-col>
                                        </v-col>
                                        <v-col>
                                            <v-data-table fixed-header class="overflow-y-auto" dark :headers="standHeaders" :items="standItems" disable-pagination hide-default-footer height="400px"></v-data-table>
                                        </v-col>
                                    </v-row>

                                </v-container>
                            </v-tab-item>
                        </v-tabs>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-sheet>
</template>
<script>
export default {
    data(){
        return {
            headers:[
                {text:'barcode', value:'barcode'},
                {text:'order', value:'order'},
                {text:'post', value:'post'},
                {text:'item', value:'item'},
                {text:'stand', value:'stand'},
                {text:'site', value:'site'},
            ],
            items:[
                {barcode:'346567', order:'ZAM-00-20020', post:'001', item:'#1', stand:'stand:1234', site:'F1'},
                {barcode:'43332', order:'ZAM-00-235554', post:'001', item:'#1', stand:'stand:653', site:'A3'},
                {barcode:'34234234', order:'ZAM-00-31515', post:'001', item:'#1', stand:'stand:63', site:'H1'},
                {barcode:'32423', order:'ZAM-00-645768', post:'001', item:'#1', stand:'stand:7327', site:'A6'},
                {barcode:'7865', order:'ZAM-00-8768', post:'001', item:'#1', stand:'stand:43', site:'B1'},
                {barcode:'67867876', order:'ZAM-00-876585', post:'001', item:'#1', stand:'stand:23', site:'A1'},
            ],
            standHeaders:[
                {text:'window', value:'window'},
                {text:'order', value:'order'},
                {text:'post', value:'post'},
                {text:'item', value:'item'},
                {text:'stand', value:'stand'},
                {text:'site', value:'site'},
            ],
            standItems:[
                {window:'346567', order:'ZAM-00-20020', post:'001', item:'#1', stand:'stand:1234', site:'F1'},
                {window:'43332', order:'ZAM-00-235554', post:'001', item:'#1', stand:'stand:653', site:'A3'},
                {window:'34234234', order:'ZAM-00-31515', post:'001', item:'#1', stand:'stand:63', site:'H1'},
                {window:'32423', order:'ZAM-00-645768', post:'001', item:'#1', stand:'stand:7327', site:'A6'},
                {window:'7865', order:'ZAM-00-8768', post:'001', item:'#1', stand:'stand:43', site:'B1'},
                {window:'67867876', order:'ZAM-00-876585', post:'001', item:'#1', stand:'stand:23', site:'A1'},
            ],
            search:'',
            stand:'',
            windows: [''],
            indices: [0],
            sites:['A1', 'A2', 'B1', 'B2', 'C1', 'C2'],
            site: ''
        }
    },
    methods:{
        addInput(){
            let val = this.indices[this.indices.length-1]
            this.indices.push(val+1)
            this.$nextTick(()=>{
            this.$refs.idx[val+1].focus()
            });
        },
        addWindows(){
            this.$refs.idx[0].focus()
        }
    }
    
}
</script>