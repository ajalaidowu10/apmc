import Token from './Token'
import AppStorage from './AppStorage'

class User {
    async login(data) {
        const result = axios.post('/auth/login', data);
            // .then(res => this.responseAfterLogin(res))
            // .catch(error => console.log(error.response.data))
        return result;
    }

    responseAfterLogin(res) {
        const access_token = res.data.access_token
        const username = res.data.user

        if (Token.isValid(access_token)) {
            AppStorage.store(username, access_token)
            window.location = '/add-booking'
        }
    }

    hasToken() {
        const storedToken = AppStorage.getToken();
        if (storedToken) {
            return Token.isValid(storedToken) ? true : this.logout()
        }
        return false
    }

    loggedIn() {
        return this.hasToken()
    }

    logout() {
        AppStorage.clear()
        window.location = '/login'
    }

    name() {
        if (this.loggedIn()) {
            return AppStorage.getUser()
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

    admin() {
        return this.id() == 1
    }

}

export default User = new User();