<template>
    <div>

        <div class="row">
            <div class="col-6"></div>
            <div class="col-6">
                <form @submit.prevent="filterReport">
                    <div class="create-report-form input-group mb-2">
                        <input v-model="search_price" type="number" class="form-control" />
                        <div class="input-group-append">
                            <button class="btn btn-primary">Search by Price</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <th>Location</th>
                <th>Parent Category</th>
                <th>Category</th>
                <th>Count</th>
            </thead>
            <tbody>
                <tr v-for="row in reports" :key="row.id">
                    <td>{{ row.location }}</td>
                    <td>{{ row.parent_category }}</td>
                    <td>{{ row.category }}</td>
                    <td>{{ row.item_count }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            reports: [],
            search_price: '',
        };
    },
    mounted() {
        this.getReports();
    },
    methods: {
        getReports() {
            return axios.get('/api/reports')
                .then(response => {
                    this.reports = response.data;
                }).catch(console.error);
        },
        filterReport() {
            return axios.post('/api/reports/filter', { price: this.search_price })
                .then(response => {
                    this.reports = response.data;
                }).catch(console.error);
        },
    }
}
</script>