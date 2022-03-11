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
                    <td align="center">
                        <button class="btn btn-sm btn-warning" @click="showModalEdit(row)"><i class="fa fa-edit"></i> Edit</button>
                        <button class="btn btn-danger btn-sm" @click.prevent="deleteItem(row.id)"><i class="fa fa-times" /> Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div id="modalItems" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ modal.title }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Item Name</label>
                            <input v-model="item.name" type="text" class="form-control" placeholder="" />
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input v-model="item.price" type="number" class="form-control" placeholder="" />
                        </div>
                        <div class="form-group">
                            <label>Select Location</label>
                            <select v-model="item.location_id" class="form-control" >
                                <option v-for="row in locations" :key="row.id" :value="row.id">{{ row.name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Select Category</label>
                            <select v-model="item.category_id" class="form-control">
                                <option v-for="row in categories" :key="row.id" :value="row.id">{{ row.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button v-if="item.id == null" type="button" class="btn btn-primary" @click.prevent="createItem()">Create</button>
                        <button v-else type="button" class="btn btn-primary" @click.prevent="updateItem()">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import ItemService from '../../services/item.service.js';
import CategoryService from '../../services/category.service.js';
import LocationService from '../../services/location.service.js';

export default {
    name: 'ItemsIndex',
    data() {
        return {
            items: [],
            locations: [],
            categories: [],
            item: {
                id: null,
                name: '',
                price: '',
                location_id: '',
                category_id: ''
            },
            modal:{
                title: '',
                textBtnModal: ''
            }
        };
    },
    mounted() {
        this.getitems();
    },
    methods: {
        async getitems() {
            this.items = await ItemService.index();
        },
        async createItem() {
            let result = await ItemService.store(this.item);
            if(result.status == 201) {
                this.getitems();
                this.clearInputs();
                $('#modalItems').modal('hide');
            }else{
                alert('Error creating item');
            }
        },
        showModalEdit(item) {
            this.getcategories();
            this.getLocations();
            this.item = item;
            this.modal.title = 'Edit Item';
            $('#modalItems').modal('show');
        },
        async updateItem() {
            let result = await ItemService.updated(this.item.id, {
                name: this.item.name,
                price: this.item.price,
                location_id: this.item.location_id,
                category_id: this.item.category_id
            });
            if(result.status == 200) {
                this.getitems();
                this.clearInputs();
                $('#modalItems').modal('hide');
            }else{
                alert('Error updating item');
            }
        },
        deleteItem(id) {
            return axios.post('/api/items/' + id, {_method: 'DELETE'})
                .then(this.getitems)
                .catch(console.error);
        },
        clearInputs() {
            this.item = { id: null, name: '', price: '', location_id: '', category_id: '' };
        },
        async getcategories() {
            this.categories = await CategoryService.index();
        },
        async getLocations() {
            this.locations = await LocationService.index();
        },
        showModal() {
            this.modal.title = 'Create New Item';
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