<template>
    <v-sheet class="transparent fill-height">
        <v-container fluid class="fill-height dark">
            <v-row class="fill-height">
                <v-col class="fill-height">

                    <v-card class="gradient fill-height" dark max-width="1200px">
                        <v-card-title>
      Okna na Stojakach
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Szukaj"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>
                        <v-data-table fixed-header :search="search" class="overflow-y-auto" dark :headers="headers" :items="items" disable-pagination hide-default-footer height="200px"></v-data-table>
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
            search:''
        }
    }
    
}
</script>