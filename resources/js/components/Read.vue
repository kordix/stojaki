<template>
<div>
    <div v-if="modelname.length > 0">
        <p>
            <b>{{modelname}}</b>
        </p>
        <input v-model="filterKey" placeholder="szukaj" class="margin-bottom:20px">
        <table class="table table-bordered table-dark" style="width:500px">
            <thead>
                <tr>
                    <td>Barkod okna</td>
                    <td>Barkod stojaka</td>
                    <td>Lokalizacja</td>

                    <!-- <td>usuń</td>
                    <td>edytuj</td> -->
                </tr>
            </thead>
            <tbody>
                <tr v-for="elem in filteredDane">
                    <td>{{elem.barcode}}</td>
                    <td>{{elem.stand}}</td>
                  <td>{{elem.site}}</td>

                     <!-- <td><button @click="mydestroy(elem.id)" class="btn btn-sm btn-danger">Usuń</button></td>
                    <td><button @click="edit(elem.id)" class="btn btn-sm btn-danger">Edytuj</button></td> -->
  <!-- stojaki.find(el=>el.barcode == elem.stojak_id).lokalizacja} -->
                </tr>
            </tbody>
        </table>
    </div>
    <div v-else>Zapodaj nazwę modelu by użyć komponentu Read</div>

    <div id="edit">
        <div>
            <!-- <p v-if="mode=='edit'">
                <b>Edytuj rekord</b>
            </p>
            <p v-else>
                <b>Stwórz nowy rekord</b>
            </p> -->

            <div>
                <!-- <input type="hidden" class="form-control" :value="cruddata.id" name="id"> -->

                <!-- TU WSTAW HTML -->
                <div v-if="!stojakready">
                   <label>Otwórz stojak:</label><input v-model="cruddata.stand">
                   <button @click="stojakready = true">Gotowe</button>
                 </div>

                 <div v-if="stojakready">
                <p><b>Aktywny stojak: {{cruddata.stand}}</b></p>

                </div>

                <div v-if="stojakready"> 
                <label>Barkod okna</label><input v-model="cruddata.barcode">
                <button type="button" @click="add" v-if="mode=='create'">zapisz</button>
                </div>
               

                <!-- koniec html -->
               
                <!-- <button type="button" @click="update" v-if="mode=='edit'">Zmień</button> --> 

            </div>
        </div>
    </div>

<p></p>
<p></p>
<p></p>
    <ul id="todo">
         <li>przypisanie lokalizacji do stojaka</li>
      <li>Szukaj</li>
      <li>Stojaki z sumami, szczegóły stojaka</li>
     
    </ul>
</div>
</template>

<script>
import {
    EventBus
} from "../event-bus.js";

export default {
    props: ["modelname"],
    data() {
        return {
            dane: [],
            hidden: ["created_at", "updated_at", 'category_id'],
            mode: "create",
            editid: null,
            stojakready:false,
            stojaki:[],
            cruddata: {},
            filterKey:''
        };
    },
    methods: {
        getData() {
            let self = this;
            //axios.get("/category").then(res => console.log(res));
            axios.get("/" + self.modelname.toLowerCase()).then(res => (self.dane = res.data));
            axios.get('/stojak').then(res=>self.stojaki = res.data);
        },
        mydestroy(id) {
            let self = this;
            axios.delete('/' + self.modelname.toLowerCase() + '/' + id).then(res => self.getData())

        },
        edit(id) {
            this.editid = id;
            this.mode = "edit";
            let freshobject = {};
            freshobject = Object.create(this.dane.find((el) => el.id == id))
            this.cruddata = freshobject
        },
        update() {
            let self = this;
            axios.patch('/' + self.modelname.toLowerCase() + '/' + self.editid, this.cruddata).then((res) => self.getData())
        },
        add() {
            let self = this;
            
            axios
                .post("/" + this.modelname.toLowerCase(), this.cruddata)
                .then(res => self.getData()).then(res=>self.cruddata.barcode = '');

        },
        reset() {
            this.cruddata = {};
        }
    },
    mounted() {
        this.getData();
        EventBus.$on("reload", payload => {
            console.log('działa')
            this.getData();
        });
    },
    computed: {
        heads() {
            let self = this;
            // return typeof(this.dane[0])
            if (typeof this.dane[0] == "object") {
                return Object.keys(this.dane[0]).filter(
                    el => self.hidden.indexOf(el) == -1
                );
            } else {
                return [];
            }
        },
        filteredDane: function () {
            let self = this;

            let sortOrders = {
                barcode: 1
            };

            var filterKey = this.filterKey;
            var order = this.sortOrder;
            var dane = this.dane;

            let filtered = [];
            if (this.sortKey) {
                console.log('sortkey');
                filtered = dane.slice().sort(function (a, b) {
                    a = a[self.sortKey];
                    b = b[self.sortKey];
                    return (a === b ? 0 : a > b ? 1 : -1) * order;
                });
            }

            if (filterKey.length > 0) {
                console.log(filterKey);
                filtered = dane.filter(function (row) {
                    return Object.keys(row).some(function (key) {
                        return (
                            String(row[key])
                            //.toLowerCase()
                            .indexOf(filterKey) > -1
                        );
                    });
                });
            }

            if(this.sortKey || this.filterKey){
                return filtered
            }else{
                return dane
            }

        }
    }
};
</script>
