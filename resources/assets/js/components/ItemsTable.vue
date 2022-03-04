<template>
    <div>
        <button type="button" class="btn btn-sm mb-2 btn-primary" v-on:click="showModal()">
            Create New Item
        </button>

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Location</th>
                <th></th>
            </thead>
            <tbody>
                <tr v-for="row in items" :key="row.id">
                    <td>{{ row.id }}</td>
                    <td>{{ row.name }}</td>
                    <td>{{ row.price }}</td>
                    <td>{{ row.category.name }}</td>
                    <td>{{ row.location.name }}</td>
                    <td align="center"><button class="btn btn-danger btn-sm" @click.prevent="deleteItem(row.id)"><i class="fa fa-times" /> Delete</button></td>
                </tr>
            </tbody>
        </table>

        <div id="modalItems" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Item Name</label>
                            <input v-model="newItemName" type="text" class="form-control" placeholder="" />
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input v-model="newItemPrice" type="number" class="form-control" placeholder="" />
                        </div>
                        <div class="form-group">
                            <label>Select Location</label>
                            <select v-model="newItemlocation" class="form-control" >
                                <option v-for="row in locations" :key="row.id" :value="row.id">{{ row.name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Select Category</label>
                            <select v-model="newItemCategory" class="form-control">
                                <option v-for="row in categories" :key="row.id" :value="row.id">{{ row.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click.prevent="createItem()">Create</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            items: [],
            locations: [],
            categories: [],
            newItemName: '',
            newItemPrice: '', 
            newItemlocation: '', 
            newItemCategory: '',
        };
    },
    mounted() {
        this.getitems();
    },
    methods: {
        getitems() {
            return axios.get('/api/items')
                .then(response => {
                    this.items = response.data;
                }).catch(console.error);
        },
        createItem() {
            return axios.post('/api/items', { name: this.newItemName, price: this.newItemPrice, location_id: this.newItemlocation, category_id: this.newItemCategory })
                .then(response => {
                    this.getitems();
                    $('#modalItems').modal('hide');
                })
                .catch(console.error);
        },
        deleteItem(id) {
            return axios.post('/api/items/' + id, {_method: 'DELETE'})
                .then(this.getitems)
                .catch(console.error);
        },
        clearInputs() {
            this.newItemName = '';
            this.newItemPrice = '';
            this.newItemlocation = '';
            this.newItemCategory = '';
        },
        getcategories() {
            return axios.get('/api/categories')
                .then(response => {
                    this.categories = response.data;
                }).catch(console.error);
        },
        getLocations() {
            return axios.get('/api/locations')
                .then(response => {
                    this.locations = response.data;
                }).catch(console.error);
        },
        showModal() {
            this.clearInputs();
            this.getcategories();
            this.getLocations();
            $('#modalItems').modal('show');
        }
    }
}
</script>

<style>
.create-form {
    margin-bottom: 10px;
}
</style>