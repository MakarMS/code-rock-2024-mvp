import axios from 'axios';

const instance = axios.create({
    baseURL: 'http://api.localhost'
});

const saveToken = (token) => {
    localStorage.setItem('jwt_token', token);
};

const getToken = () => {
    return localStorage.getItem('jwt_token');
};

let needToLogin = true;

const refreshToken = async () => {
    try {
        const response = await instance.post(`/api/user/auth/${localStorage.getItem('account_type')}/refresh`);

        if (response.data.status !== false) {
            const {jwt_token} = response.data;

            if (jwt_token) {
                needToLogin = false;
                saveToken(jwt_token);
                return jwt_token;
            }
        }

        needToLogin = true;

    } catch (error) {
        this.$router.push('/');
        needToLogin = true;
    }
};

instance.interceptors.request.use(async config => {
    const token = getToken();

    config.headers.Authorization = `Bearer ${token}`;

    return config;
});

const handleAuthenticationResponse = (response) => {
    const { jwt_token } = response.data;

    if (jwt_token) {
        saveToken(jwt_token);
    }

    return response;
};

instance.interceptors.response.use(handleAuthenticationResponse, async error => {
    if (error.response.status === 401 && error.response.config && !error.response.config.__isRetryRequest && !error.response.data.code) {
        try {
            if (!needToLogin) {
                const newToken = await refreshToken();
                error.response.config.__isRetryRequest = true;
                error.response.config.headers.Authorization = `Bearer ${newToken}`;
                return instance(error.response.config);
            }
        } catch (refreshError) {
            console.error('Error updating the token:', refreshError);
            throw refreshError;
        }
    }

    return Promise.reject(error);
});

export default instance;
