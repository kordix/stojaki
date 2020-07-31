<template>
    <v-container fluid>
        <v-row>
            <v-col cols="5">
                <span>Otwórz stojak</span>
                <v-text-field @keyup.enter="addStand" v-model="stand" dark rounded autocomplete="off" filled single-line dense></v-text-field>
                <span>Dodaj okna do stojaka</span>
                <v-text-field v-for="idx of indices" v-model="windows[idx]" :key="idx" ref="idx" dark rounded autocomplete="off" filled single-line dense @keyup.enter="addInput"></v-text-field>
                <span>Lokalizacja Stojaka</span>
                <v-text-field readonly dark rounded autocomplete="off" filled single-line dense :value="site"></v-text-field>
                <!-- <v-select :items="sites" v-model="site" dark rounded autocomplete="off" filled single-line dense></v-select> -->
                <v-btn @click="dialog=true">Wybierz lokalizację</v-btn>
                <v-dialog v-model="dialog" max-width="80%">
                    <v-card class="gradient" dark width="100%">
                        <v-container fluid>
                            <v-row>
                                <v-col cols="5">
                                    <div class="d-flex">
                                        <div v-for="(val,name) in polaW" :key="name" class="maingrid">
                                            <div style=" height:50px; width:50px; border:green 1px solid" v-for="el of val" :key="el" :class="getClass(name+ '-'+ el)" @click="assignSite(name+ '-'+ el)">{{name}} - {{el}}</div>
                                        </div>
                                    </div>
                                </v-col>
                                <v-col cols="5">
                                    <div class="d-flex">
                                        <div v-for="(val,name) in polaS" :key="name" class="maingridS">
                                            <div style=" height:50px; width:50px; border:red 1px solid" :class="getClass(name+ '-'+ el)" v-for="el of val" :key="el" @click="assignSite(name+ '-'+ el)">{{name}} - {{el}}</div>
                                        </div>
                                    </div>
                                </v-col>
                                <v-col cols="2">
                                    <div style="height:100%; width:100%; border:white 1px solid" :class="getClass('T1')" @click="assignSite('T1')">
                                        <span style="color:black">T1</span>
                                    </div>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card>
                </v-dialog>
            </v-col>
            <v-col>
                <v-data-table fixed-header class="overflow-y-auto" dark :headers="standHeaders" :items="standWindows" disable-pagination hide-default-footer height="400px"></v-data-table>
            </v-col>
        </v-row>

    </v-container>
</template>
<script>
export default {
    props:{allWindows:Array},
    data(){
        return {
            dialog:false,
            standHeaders:[
                {text:'window', value:'barcode'},
                {text:'order', value:'order'},
                {text:'post', value:'order_pos'},
                {text:'item', value:'order_item'},
                {text:'stand', value:'stand'},
            ],
            stand:'',
            standData:null,
            windows: [''],
            indices: [0],
            sites:['A1', 'A2', 'B1', 'B2', 'C1', 'C2'],
            site: '',
            today: new Date().toISOString().slice(0,10),
            stands:[],
            standList:null,
            standWindows:[],
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
        takenSites(){
            let res = this.stands
            if(this.standData){
                res = this.stands.filter((el)=>el.site != this.standData.site)
            }
            let taken = res.map((el)=>el.site)
            return taken
        }
    },
    methods:{
        async reset(){
            this.indices = [0]
            this.site = ''
            this.stand = ''
            this.standData = null
            this.standWindows = []
            this.today = new Date().toISOString().slice(0,10)
            this.windows = ['']
            await this.getStandList()
        },
        getClass(site){
            let taken = this.takenSites.includes(site)? true : false
            let current = this.site == site
            return current ? {current:true} : {taken: taken, vacant: !taken}
        },
        async addInput(){
            let val = this.indices[this.indices.length-1]
            let barcode = this.windows[val]
            let window = this.allWindows.find((el)=>el.barcode == barcode)
            let match = this.windows.filter((el)=>el == barcode)
            if(barcode==this.stand){
                console.log('zamknij Stojak');
                this.windows.pop()
                this.indices.pop()
            } else if(match.length>1 || window){
                this.windows.pop()
                console.log('the same');
            }
            else {
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
                form.site = this.site
                this.standWindows.push(form)
                this.$nextTick(()=>{
                this.$refs.idx[val+1].focus()
                });
            }
        },
        async addStand(){
            this.indices = [0]
            if(!this.standList.includes(this.stand)){
                let form = {
                    barcode: this.stand,
                    site: this.site,
                    data_start: this.today
                }
                await axios.post('stand', form)
                await this.getStandList()
            }
                this.standWindows = this.allWindows.filter((el)=>el.stand == this.stand)

                let res = await axios.get('findstand?barcode='+this.stand)
                this.standData = res.data
                this.stand = res.data.barcode
                this.site = res.data.site
                this.$refs.idx[0].focus()
        },
        async getStandList(){
            let res = await axios.get("stand")
            this.stands = res.data
            this.standList = res.data.map((el)=>{return el.barcode})
        },
        assignSite(site){
            if(this.takenSites.includes(site)){
                alert('Ta lokalizacja jest zajęta. Wybierz inną.')
            } else {
                this.site = site
                axios.patch('stand/'+this.standData.id, {site: this.site})
                this.dialog = false
            }
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
.taken{
    background-color: red;
}
.vacant{
    background-color: green;
}
.current{
    background-color: orange;
}
</style>