<template>
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <p>
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fa fa-plus"></i> NEW
                </button>
            </p>
            <div class="collapse mb-5" id="collapseExample">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="container border rounded p-2 bg-white">
                            <div class="form-group row my-3">
                                <h5>
                                    <b><i class="fa fa-plus"></i> ADD NEW</b>
                                </h5>
                            </div>
                            
                            <div class="form-floating mb-3 uppercase">
                                <button type="button" class="form btn btn-primary border">
                                    Select Manufacturer
                                </button>
                                <div class="my-1 border rounded p-3" id="manufacturer-info">
                                    Select manufacturer record first.
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="car_name" v-model="car_name" placeholder="Car Name" autocomplete="off" />
                                <label for="floatingInput">Car Name</label>
                            </div>
                            <input type="text" class="form-control" id="manufacturer_id" v-model="manufacturer_id" />
                            <div class="form-group">
                                <button class="btn btn-primary" @click="createNew()">Create</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           <div class="col-sm-12 border rounded bg-white">

           </div>
        </div>
        <div class="col-sm-3 manufacturers-container border rounded w3-animate-right">
            <div class="row">
                <div class="col-sm-12 bg-white border rounded p-2 mb-1 pb-0" v-for="(data, index) in manufacturers" v-bind:index="index">
                    <div class="contents" @click="selectData(data.manufacturer_id, data.manufacturer, data.type, data.color)">
                        <center>
                                <h6 class="my-0">Manufacturer: <b>{{data.manufacturer}}</b></h6>
                                <p class="my-0">Type: <b>{{data.type}}</b></p>
                                <hr class="m-0 p-0">
                                Color
                                <p class="p-3 rounded" :style="{background:data.color}"></p>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Swal from 'sweetalert2';

    export default {
        data () {
            return {
                manufacturer_id:null,
                car_name:null,
                manufacturers: {}
            }
        },

        mounted () {
            this.getManufacturers();
            
            $(document).on('click','.form, .manufacturers-container .col-sm-12', function(){
                var container = $('.manufacturers-container');
                if(container.is(':hidden')){
                    container.removeClass('w3-hide').addClass("w3-show");
                } else {
                    container.removeClass('w3-show').addClass("w3-hide");
                }
            });
        },

        methods: {

            /**
             * Fetch all rows
             *
             * @return void
             */

            getManufacturers () {
                this.manufacturers = {};
                axios.get('/api/manufacturers')
                    .then((response) => {
                        this.manufacturers = response.data;
                    }).catch((error) => {
                        console.debug(`Error while fetching manufacturers ${JSON.stringify(error)}`)
                    })
            },
            selectData(manufacturerId, manufacturer, type, color) {
                this.manufacturer_id = manufacturerId;
                let html = "";
                html += 'Manufacturer: <b>'+manufacturer+'</b> <br />';
                html += 'Type: <b>'+type+'</b> <br />';
                html += 'Color: <span class="p-1 px-4 w-25" style="background:'+color+'"></span>';
                $('#manufacturer-info').html(html);
            },
            createNew() {
                let data = {
                    manufacturer_id:this.manufacturer_id,
                    car_name:this.car_name
                };
            }
        }
    }
</script>