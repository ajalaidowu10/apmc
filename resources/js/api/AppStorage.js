class AppStorage{
    storeToken(token){
        localStorage.setItem('token',token);
    }

    storeUser(user){
        localStorage.setItem('user',user);
    }

    storeCompany(company){
        localStorage.setItem('company',company);
    }

    store(user,token, company){
        this.storeToken(token)
        this.storeUser(user)
        this.storeCompany(company)
    }

    clear(){
        localStorage.removeItem('token')
        localStorage.removeItem('user')
        localStorage.removeItem('company')
    }

    getToken(){
        return localStorage.getItem('token')
    }

    getUser(){
        return localStorage.getItem('user')
    }

    getCompany(){
        return localStorage.getItem('company')
    }
}

export default AppStorage = new AppStorage()