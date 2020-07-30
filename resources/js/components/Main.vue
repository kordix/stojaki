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
                                <v-data-table no-results-text="Brak pasujących wyników" fixed-header :search="search" class="overflow-y-auto" dark :headers="headers" :items="windows" disable-pagination hide-default-footer height="200px">
                                    <template v-slot:item.delete="{item}">
                                        <v-btn @click="deleteItem(item)">Delete</v-btn>
                                    </template>
                                </v-data-table>
                            </v-tab-item>
                            <v-tab-item>
                                <scan :allWindows="windows"></scan>
                            </v-tab-item>
                        </v-tabs>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-sheet>
</template>
<script>
import scan from './Scan'


export default {
    components:{'scan':scan},
    data(){
        return {
            tab: true,
            headers:[
                {text:'barcode', value:'barcode'},
                {text:'order', value:'order'},
                {text:'post', value:'order_pos'},
                {text:'item', value:'order_item'},
                {text:'stand', value:'stand'},
                {text:'site', value:'site'},
                {text:'delete', value:'delete'}
            ],
            search:'',
            windows:[]  
        }
    },
    methods:{
        async getWindows(){
            let res = await axios.get("window")
            this.windows = res.data
        },
        async deleteItem(item){
            if(confirm('Czy na pewno chesz usunąć okno?')){

                console.log('sdjfhsjkafhsjk');
                await axios.delete('window/'+ item.id)
                await this.getWindows()
            }
        }
    },
    created(){
        this.getWindows()
    }
    
}
</script>