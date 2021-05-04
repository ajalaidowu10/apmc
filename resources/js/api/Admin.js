import Token from './Token'
import AppStorage from './AppStorage'

class Admin {
    async login(data) {
        const result = axios.post('/admin-auth/login', data);
            // .then(res => this.responseAfterLogin(res))
            // .catch(error => console.log(error.response.data))
        return result;
    }

    responseAfterLogin(res) {
        const access_token = res.data.access_token;
        const username = res.data.user;
        const company = res.data.company;

        if (Token.isValidAdmin(access_token)) {
            AppStorage.store(username, access_token, company);
            window.location = '/web-admin/dashboard'
        }
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

    company() {
        if (this.loggedIn()) {
            return AppStorage.getCompany()
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