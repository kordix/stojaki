<template>
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


</template>
    
<script>
import {EventBus} from '../event-bus.js'
export default {
    props:{
        site:String
    },
    data(){
        return{
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
        assignSite(site){
            EventBus.$emit('changeSite', site)
            //this.$parent.site = site
        }
    },
    created(){

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