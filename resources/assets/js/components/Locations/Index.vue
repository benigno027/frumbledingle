<template>
    <div>
        <form @submit.prevent="createLocation">
            <div class="create-location-form input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Name</span>
                </div>
                <input v-model="newLocationName" type="text" class="form-control" placeholder="Location Name" />
                <div class="input-group-append">
                    <button class="btn btn-primary">Create</button>
                </div>
            </div>
        </form>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <th>ID</th>
                <th>Name</th>
                <th></th>
            </thead>
            <tbody>
                <tr v-for="row in locations" :key="row.id">
                    <td>{{ row.id }}</td>
                    <td>{{ row.name }}</td>
                    <td align="center">
                        <button class="btn btn-sm btn-warning" @click="showModalEdit(row)"><i class="fa fa-edit"></i> Edit</button>
                        <button class="btn btn-sm btn-danger" @click.prevent="deleteLocation(row.id)"><i class="fa fa-times" /> Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div id="modal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Location</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model="editLocation.name" type="text" class="form-control" placeholder="" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click.prevent="updateLocation()">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

import LocationService from '../../services/location.service.js';

export default {
    name: 'LocationsIndex',
    components: {
        
    },
    data() {
        return {
            locations: [],
            newLocationName: '',
            editLocation: {
                id: '',
                name: ''
            }
        };
    },
    mounted() {
        this.getLocations();
    },
    methods: {
        async getLocations() {
            this.locations = await LocationService.index();
        },
        async createLocation() {
            let result = await LocationService.store({name: this.newLocationName});
            if(result.status == 201) {
                this.getLocations();
                this.newLocationName = '';
            }else{
                alert('Error creating location');
            }
        },
        showModalEdit(location) {
            this.editLocation = location;
            $('#modal').modal('show');
        },
        async updateLocation() {
            let result = await LocationService.updated(this.editLocation.id, { name: this.editLocation.name });
            if(result.status == 200) {
                this.getLocations();
                $('#modal').modal('hide');
            }else{
                alert('Error updating location');
            }
        },
        async deleteLocation(id) {
            let result = await LocationService.delete(id);
            if(result.status == 200) {
                this.getLocations();
            }else{
                alert('Error deleting location');
            }
        }
    }
}
</script>

<style>
.create-location-form {
    margin-bottom: 10px;
}
</style>