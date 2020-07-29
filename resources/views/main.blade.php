@extends('layouts.app')

@section('content')


<v-app>
   <v-main  dark hieght="">
      <router-view></router-view>
   </v-main>
</v-app>

<!-- <div class="container">
<select name="" id="" v-model="activetab">
    <option value="main">Okna</option>
    <option value="stojaki">Stojaki</option>

</select>
 <div v-if="activetab=='main'">
    <read :key="'1'" :modelname="'Window'"></read>
 </div>


 <div v-if="activetab=='stojaki'">
    <readstojak :key="'1'" :modelname="'Stojak'"></readstojak>
 </div>

    
</div> -->



@endsection
