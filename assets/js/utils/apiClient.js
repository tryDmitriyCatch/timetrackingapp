import axios from 'axios'
import config from '~/js/config'

const instance = axios.create({
    baseURL: config.get('BASE_API_URL'),
});

instance.interceptors.response.use(
    null,
    err => {
        const { response } = err

        if (!response) {
            return Promise.reject(err)
        }

        // If response has an error message set it to Error instance
        if (typeof response.data.message !== 'undefined') {
            err.message = response.data.message
        }

        return Promise.reject(err)
    }
)

export default instance;