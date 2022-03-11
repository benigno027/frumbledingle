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
                    <td align="center">
                        <button class="btn btn-sm btn-warning" @click="showModalEdit(row)"><i class="fa fa-edit"></i> Edit</button>
                        <button class="btn btn-danger btn-sm" @click.prevent="deleteCategory(row.id)"><i class="fa fa-times" /> Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div id="modalCategories" class="modal" tabindex="-1" role="dialog">
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
                            <label>Category Name</label>
                            <input v-model="category.name" type="text" class="form-control" placeholder="" />
                        </div>
                        <div class="form-group">
                            <label>Parent Category</label>
                            <input v-model="category.parent_id" type="number" class="form-control" placeholder="" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button v-if="category.id == null" type="button" class="btn btn-primary" @click.prevent="createCategory()">Create</button>
                        <button v-else type="button" class="btn btn-primary" @click.prevent="updateCategory()">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import CategoryService from '../../services/category.service.js';

export default {
    name: 'CategoriesIndex',
    data() {
        return {
            categories: [],
            category: {
                id: null,
                name: '',
                parent_id: ''
            },
            modal:{
                title: '',
                textBtnModal: ''
            }
        };
    },
    mounted() {
        this.getcategories();
    },
    methods: {
        async getcategories() {
            this.categories = await CategoryService.index();
        },
        async createCategory() {
            let result = await CategoryService.store(this.category);
            if(result.status == 201) {
                this.getcategories();
                this.clearInputs();
                $('#modalCategories').modal('hide');
            }else{
                alert('Error creating category');
            }
        },
        showModalEdit(category) {
            this.category = category;
            this.modal.title = 'Edit Category';
            $('#modalCategories').modal('show');
        },
        async updateCategory() {
            let result = await CategoryService.updated(this.category.id, { name: this.category.name, parent_id: this.category.parent_id });
            if(result.status == 200) {
                this.getcategories();
                this.clearInputs();
                $('#modalCategories').modal('hide');
            }else{
                alert('Error updating category');
            }
        },
        async deleteCategory(id) {
            let result = await CategoryService.delete(id);
            if(result.status == 200) {
                this.getcategories();
            }else{
                alert('Error deleting category');
            }
        },
        clearInputs() {
            this.category = { name: '', parent_id: '' };
        },
        showModal() {
            this.clearInputs();
            this.modal.title = 'Create New Category';
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