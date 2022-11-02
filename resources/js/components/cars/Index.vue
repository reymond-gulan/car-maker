<template>
    <div class="row justify-content-center">
        <div class="col-sm-6 px-5">
            <p>
                <button class="btn btn-primary btn-add shadow" type="button" data-toggle="collapse" data-target="#new" aria-expanded="false" aria-controls="new">
                    <i class="fa fa-plus"></i>
                </button>
            </p>
            <div class="collapse mb-5" id="new">
                <div class="row">
                    <div class="col-sm-12 p-0">
                        <div class="container rounded-corner p-4 bg-white shadow border-top">
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
                                <button class="btn btn-primary submit" @click="createNew()">Create</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 manufacturers-container w3-animate-right">
            <div class="row">
                <div class="col-sm-12 bg-white shadow rounded-corner p-2 mb-1 pb-0" v-for="(data, index) in manufacturers" v-bind:index="index">
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
        <div class="col-sm-12 px-5">
            <div class="row">
                <div class="col-md-3 p-1 uppercase" v-for="(data, index) in cars" v-bind:index="index">
                    <div class="col-sm-12 content rounded-corner shadow bg-white p-2 text-right mb-3 pb-3 px-3">
                        <center>
                            <p class="m-0 color shadow border border-dark" :style="{background:data.manufacturers.color}"></p>
                            <h3>
                                <b>{{data.car_name}}</b>
                            </h3>
                            <hr class="m-0">
                            <small>
                                <p class="m-0">{{data.manufacturers.manufacturer}}</p>
                                <p class="m-0">{{data.manufacturers.type}}</p>
                            </small>
                        </center>
                            
                            <i @click="deleteRow(data.car_id, index)" class="fa fa-trash border rounded border-danger pointer text-danger p-2 px-3"></i>
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
            $('.btn-add').trigger('click');
            $(document).on('click','.form, .manufacturers-container .col-sm-12', function(){
                var container = $('.manufacturers-container');
                if(container.is(':hidden')){
                    container.removeClass('w3-hide').addClass("w3-show");
                } else {
                    container.removeClass('w3-show').addClass("w3-hide");
                }
            });
            $('#new').on('hidden.bs.collapse', function(){
                var container = $(this);
                if(container.is(':hidden')){
                    $('.manufacturers-container').addClass('w3-hide').removeClass('w3-show');
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

                axios.post('/api/cars/save', data)
                    .then((response) => {

                        if(response.data['success']) {
                            Swal.fire('SUCCESS',response.data['success'],'success');
                            this.clearFields();
                            this.getCars();
                            $('.btn-add').trigger('click');
                        } else {
                            Swal.fire('ERROR',response.data['error'],'error');
                        }
                        
                    }).catch((error) => {
                        var message = "";
                        $.each( error.response.data.errors, function(key, value) {
                            message += '<li>'+ value +'</li>';
                        });

                        Swal.fire('ERROR',message,'error');
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