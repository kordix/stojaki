<template>
    <v-container fluid>
        <v-row>
            <v-col cols="5">
                <span>Otwórz stojak</span>
                <v-text-field @keyup.enter="addStand" v-model="stand" dark rounded autocomplete="off" filled single-line dense></v-text-field>
                <span>Dodaj okna do stojaka</span>
                <v-text-field v-for="idx of indices" v-model="windows[idx]" :key="idx" ref="idx" dark rounded autocomplete="off" filled single-line dense @keyup.enter="addInput"></v-text-field>
                <span>Lokalizacja Stojaka</span>
                <v-select :items="sites" v-model="site" dark rounded autocomplete="off" filled single-line dense></v-select>
                <v-btn @click="dialog=true">Wybierz lokalizację</v-btn>
                <v-dialog v-model="dialog" max-width="80%">
                    <v-card class="gradient" dark width="100%">
                        <v-container fluid>
                            <v-row>
                                <v-col cols="5">
                                    <div class="d-flex">
                                        <div v-for="(val,name) in polaW" :key="name" class="maingrid">
                                            <div style=" height:50px; width:50px; border:green 1px solid" v-for="el of val" :key="el" @click="assignSite(name+ '-'+ el)">{{name}} - {{el}}</div>
                                        </div>
                                    </div>
                                </v-col>
                                <v-col cols="5">
                                    <div class="d-flex">
                                        <div v-for="(val,name) in polaS" :key="name" class="maingridS">
                                            <div style=" height:50px; width:50px; border:red 1px solid" v-for="el of val" :key="el" @click="assignSite(name+ '-'+ el)">{{name}} - {{el}}</div>
                                        </div>
                                    </div>
                                </v-col>
                                <v-col cols="2">
                                    <div style="height:100%; width:100%; border:white 1px solid" @click="assignSite('T1')">
                                        <span style="color:black">T1</span>
                                    </div>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card>
                </v-dialog>
            <v-col><v-btn small dark>Zamknij Stojak</v-btn></v-col>
            </v-col>
            <v-col>
                <v-data-table fixed-header class="overflow-y-auto" dark :headers="standHeaders" :items="allWindows" disable-pagination hide-default-footer height="400px"></v-data-table>
            </v-col>
        </v-row>

    </v-container>
</template>
<script>
import locations from './Locations'
import EventBus from '../event-bus'
export default {
    props:{allWindows:Array},
    components:{'locations':locations},
    data(){
        return {
            dialog:false,
            standHeaders:[
                {text:'window', value:'barcode'},
                {text:'order', value:'commande'},
                {text:'post', value:'order_pos'},
                {text:'item', value:'order_item'},
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
            stand:'',
            standData:null,
            windows: [''],
            indices: [0],
            sites:['A1', 'A2', 'B1', 'B2', 'C1', 'C2'],
            site: '',
            today: new Date().toISOString().slice(0,10),
            stands:null,
            standList:null,
            standWindows:null,
            wyjazdowe:['W1', 'W2', 'W3'],
            standard:['P1', 'P2','P3', 'P4', 'P5', 'P6'],
            tyl:{'T':1}

        }
        
    },
    computed:{
        polaW(){
            let res = {}
            for(let el of this.wyjazdowe){
                let arr = []
                for(let i = 1; i<=18; i++){
                    arr.push(i)
                }
                res[el]= arr
            }
            return res
        },
        polaS(){
            let res = {}
            for(let el of this.standard){
                let arr = []
                for(let i = 1; i<=9; i++){
                    arr.push(i)
                }
                res[el]= arr
            }
            return res
        },
    },
    methods:{
        async addInput(){
            let val = this.indices[this.indices.length-1]
            if(this.windows[val]==this.stand){

                console.log('zamknij Stojak');
            } else {

                this.indices.push(val+1)
                let window = this.windows[val].slice(0,5)
                let res = await axios.get('getwindow?barcode='+ '\'' + window + '\'')
                let form = res.data[0]
                form.stand = this.stand
                let order = form.commande
                delete form.commande
                form.order = order
                console.log(form, 'form');
                await axios.post('window', form)
                form.site = ''
                this.allWindows.push(form)
                this.$nextTick(()=>{
                this.$refs.idx[val+1].focus()
                });
            }
        },
        async addStand(){
            if(!this.standList.includes(this.stand)){
                let form = {
                    barcode: this.stand,
                    site: this.site,
                    data_start: this.today
                }
                await axios.post('stand', form)
                await this.getStandList()
            }
                let res = await axios.get('findstand?barcode='+this.stand)
                this.standData = res.data
                this.stand = res.data.barcode
                this.$refs.idx[0].focus()
        },
        async getStandList(){
            let res = await axios.get("stand")
            this.stands = res.data
            this.standList = res.data.map((el)=>{return el.barcode})
        },
        assignSite(site){
            this.site = site
        }
    },
    mounted(){

    },
    async created(){
        await this.getStandList()
    }
}
</script>
<style scoped>
.maingrid{

    display: grid;
    grid-template-columns: repeat(2, 1fr);
 /*    //grid-template-rows: 61px 480px; */
    grid-gap: 5px;
    margin: 0 25px 0 0;
}
.maingridS{
    display: grid;
    grid-template-columns: repeat(1, 1fr);
 /*    //grid-template-rows: 61px 480px; */
    grid-gap: 5px;
    margin: 0 25px 0 0;
}
</style>