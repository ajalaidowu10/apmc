import Token from './Token'
import AppStorage from './AppStorage'

class Admin {
    async login(data) {
        const result = await axios.post('/admin-auth/login', data);
        const { access_token, user } = result.data;
        if (Token.isValidAdmin(access_token)) {
            AppStorage.storeUser(user);
            AppStorage.storeToken(access_token);
        }
        const JwtToken = `Bearer ${localStorage.getItem('token')}`
        window.axios.defaults.headers.common['Authorization'] = JwtToken;
        return result;
    }

    async companyLogin(data) {
        const result = await axios.post('/admin-auth/company-login', data);
        AppStorage.storeCompany(JSON.stringify(result.data));
        window.location = '/web-admin/dashboard'
    }

    hasToken() {
        const storedToken = AppStorage.getToken();
        if (storedToken) {
            return Token.isValidAdmin(storedToken) ? true : this.logout()
        }
        return false
    }

    loggedIn() {
        return this.hasToken()
    }

    logout() {
        AppStorage.clear()
        window.location = '/web-admin/login'
    }

    name() {
        if (this.loggedIn()) {
            return AppStorage.getUser()
        }
    }

    company(data) {
        if (this.loggedIn()) {
            return AppStorage.getCompany()[data];
        }
    }

    id() {
        if (this.loggedIn()) {
            const payload = Token.payload(AppStorage.getToken())
            return payload.sub
        }
    }

    own(id) {
        return this.id() == id
    }    
}

export default Admin = new Admin();