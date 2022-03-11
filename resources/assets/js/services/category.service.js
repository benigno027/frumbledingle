import axios from 'axios';
const API_URL = '/api/categories';

class CategoryService {

    index() {
        return axios
            .get(API_URL)
            .then(
                (response) => {
                    return response.data;
                },
                (error) => {
                    return error;
                }
            );
    }

    store(formData) {
        return axios
            .post(API_URL, formData)
            .then(
                (response) => {
                    return response;
                },
                (error) => {
                    return error;
                }
            )
            .catch((error) => {
                return error;
            });
    }

    updated(id, formData) {
        return axios
            .put(API_URL + "/" + id, formData)
            .then((response) => {

                return response;
            })
            .catch((error) => {
                return error;
            });
    }

    delete(id) {
        return axios
            .post(API_URL + "/" + id, {_method: 'DELETE'})
            .then(
                (response) => {
                    return response;
                },
                (error) => {
                    return error;
                }
            )
            .catch((error) => {
                return error;
            });
    }

}

export default new CategoryService();