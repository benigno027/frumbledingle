<template>
    <div>
        <button type="button" class="btn btn-sm mb-2 btn-primary" v-on:click="showModal()">
            Create New Category
        </button>

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <th>ID</th>
                <th>Name</th>
                <th>Parent</th>
                <th></th>
            </thead>
            <tbody>
                <tr v-for="row in categories" :key="row.id">
                    <td>{{ row.id }}</td>
                    <td>{{ row.name }}</td>
                    <td>{{ row.parent_id }}</td>
                    <td align="center"><button class="btn btn-danger btn-sm" @click.prevent="deleteCategorie(row.id)"><i class="fa fa-times" /> Delete</button></td>
                </tr>
            </tbody>
        </table>

        <div id="modalCategories" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="create-form input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Category Name</span>
                            </div>
                            <input v-model="newCategorieName" type="text" class="form-control" placeholder="Categorie Name" />
                        </div>
                        <div class="create-form input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Parent Category</span>
                            </div>
                            <input v-model="newParentCategoryId" type="number" class="form-control" placeholder="Parent Category" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click.prevent="createCategorie()">Create</button>
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
            categories: [],
            newCategorieName: '',
            newParentCategoryId: '',
        };
    },
    mounted() {
        this.getcategories();
    },
    methods: {
        getcategories() {
            return axios.get('/api/categories')
                .then(response => {
                    this.categories = response.data;
                }).catch(console.error);
        },
        createCategorie() {
            return axios.post('/api/categories', {name: this.newCategorieName, parent_id: this.newParentCategoryId})
                .then(response => {
                    this.getcategories();
                    $('#modalCategories').modal('hide');
                }).catch(console.error);
        },
        deleteCategorie(id) {
            return axios.post('/api/categories/' + id, {_method: 'DELETE'})
                .then(response => {
                    if(response.status === 200) {
                        this.getcategories();
                    }else{
                        alert(response.message);
                    }
                })
                .catch(
                    error => {
                        alert('Cannot delete category with subcategories');
                    }
                );
        },
        clearInputs() {
            this.newCategorieName = '';
            this.newParentCategoryId = '';
        },
        showModal() {
            this.clearInputs();
            $('#modalCategories').modal('show');
        }
    }
}
</script>

<style>
.create-form {
    margin-bottom: 10px;
}
</style>