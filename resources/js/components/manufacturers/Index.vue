<template>
    <div class="container">
        <p>
            <button class="btn btn-primary btn-add shadow" type="button" data-toggle="collapse" data-target="#new" aria-expanded="false" aria-controls="new">
                <i class="fa fa-plus"></i>
            </button>
        </p>
        <div class="collapse mb-5 form-container" id="new">
            <div class="row justify-content-center">
                <div class="col-sm-6 rounded border-top rounded-corner p-4 shadow p-2 bg-white">
                    <div class="form-group row my-3">
                        <h5>
                            <b><i class="fa fa-plus"></i> ADD NEW</b>
                        </h5>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="manufacturer" name="manufacturer" v-model="manufacturer" placeholder="Manufacturer" autocomplete="off">
                        <label for="floatingInput">Manufacturer</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="type" name="type" v-model="type" placeholder="Type" autocomplete="off">
                        <label for="floatingPassword">Type</label>
                    </div>
                    <div class="form-group row">
                        <label for="color" class="col-sm-2 col-form-label">Color</label>
                        <div class="col-sm-10">
                        <input type="color" class="form-control" id="color" name="color" v-model="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary submit" @click="createNew()">Create</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="contents-container">
        <table class="shadow table w-100 bg-white table-sm table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Manufacturer</th>
                    <th>Type</th>
                    <th>Color</th>
                    <th>
                        <center>
                        <i class="fa fa-cog"></i>
                        </center>
                    </th>
                </tr>
            </thead>

            <tbody style="text-transform:uppercase;">
                <tr v-for="(data, index) in manufacturers" v-bind:index="index">
                    <td v-text="data.manufacturer"></td>
                    <td v-text="data.type"></td>
                    <td class="col-sm-1">
                        <center>
                            <input type="color" class="form-control p-0" v-model="data.color" disabled />
                        </center>
                    </td>
                    <td class="col-sm-1">
                        <center>
                        <button class="btn btn-danger p-0 px-3" @click="deleteRow(data.manufacturer_id, index)">
                            <i class="fa fa-trash"></i>
                        </button>
                        </center>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</template>

<script>
    import Swal from 'sweetalert2';

    export default {
        data () {
            return {
                manufacturer:null,
                type:null,
                color:'#000000',
                manufacturers: {}
            }
        },

        mounted () {
            this.getManufacturers()
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

            /**
             * Submit data
             *
             * @return void
             */

            createNew () {
                let data = {
                    manufacturer:this.manufacturer,
                    type:this.type,
                    color:this.color,
                };

                axios.post('/api/manufacturers/save', data)
                    .then((response) => {
                        if(response.data['success']) {
                            Swal.fire('SUCCESS',response.data['success'],'success');
                            this.clearFields();
                            this.getManufacturers();
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
             * Delete record from database
             *
             * @param manufacturerId
             *
             * @returns {void}
             */
             deleteRow (manufacturerId, index) {

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
                        axios.delete(`/api/manufacturers/${manufacturerId}`)
                            .then((response) => {

                                if(response.data['success']) {
                                    Swal.fire('SUCCESS',response.data['success'],'success');
                                    this.manufacturers.splice(index,1);
                                } else {
                                    Swal.fire('ERROR',response.data['error'],'error');
                                }

                            })
                    }
                });
            },

            clearFields() {
                this.manufacturer = null;
                this.type = null;
                this.color='#000000';
            }
        }
    }
</script>
