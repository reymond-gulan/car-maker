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
                            <input type="hidden" class="form-control" id="manufacturer_id" v-model="manufacturer_id" readonly />
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
                            <div class="form-group">
                                <button class="btn btn-primary" @click="createNew()">Create</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           <div class="col-sm-12">
                <div class="row">
                    <div class="col-md-4 p-1 uppercase" v-for="(data, index) in cars" v-bind:index="index">
                        <div class="col-sm-12 content border rounded bg-white p-2 text-right">
                            <center>
                                <h3>
                                    <b>{{data.car_name}}</b>
                                </h3>
                                <hr class="m-0">
                                <p class="m-0">{{data.manufacturers.manufacturer}}</p>
                                <p class="m-0">{{data.manufacturers.type}}</p>
                                <p class="m-0 p-3 border rounded" :style="{background:data.manufacturers.color}"></p>
                            </center>
                                <button class="btn btn-danger p-0 px-4 pull-right mt-2" @click="deleteRow(data.car_id, index)">
                                    <small><i class="fa fa-trash"></i></small>
                                </button>
                        </div>
                    </div>
                </div>
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
                manufacturers: {},
                cars: {}
            }
        },

        mounted () {
            this.getManufacturers();
            this.getCars();
            
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
             getCars () {
                this.cars = {};
                axios.get('/api/cars')
                    .then((response) => {
                        this.cars = response.data;
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

                this.clearFields();

                axios.post('/api/cars/save', data)
                    .then((response) => {
                        console.log(response);
                        if(response.data['success']) {
                            Swal.fire('SUCCESS',response.data['success'],'success');
                            this.clearFields();
                            this.getCars();
                        } else if(response.data['errors']) {
                            var message = "";
                            for(var i = 0; i < response.data['errors'].length; i++)
                            {
                                message += '<li>'+ response.data['errors'][i]+'</li>';
                            }

                            Swal.fire('ERROR',message,'error');
                        } else {
                            Swal.fire('ERROR',response.data['error'],'error');
                        }
                        
                    }).catch((error) => {
                        console.log(error);
                        Swal.fire(
                            'Oops...',
                            'Invalid / Unauthorized request. Please reload and try again',
                            'error'
                        );
                        console.debug(`Error while creating new record - ${JSON.stringify(error)}`);
                })
            },

            /**
             * Delete car record from database
             *
             * @param carId
             *
             * @returns {void}
             */

             deleteRow (carId, index) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Once deleted, it cannot be undone. Proceed anyway?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, proceed.'
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`/api/cars/${carId}`)
                            .then((response) => {

                                if(response.data['success']) {
                                    Swal.fire('SUCCESS',response.data['success'],'success');
                                    this.cars.splice(index,1);
                                } else {
                                    Swal.fire('ERROR',response.data['error'],'error');
                                }

                            })
                    }
                });
            },
            clearFields() {
                this.manufacturer_id = null;
                this.car_name = null;
                $('#manufacturer-info').html('Select manufacturer record first.');
            }
        }
    }
</script>