class Token{

    isValid(token){
        const payload = this.payload(token);
        if(payload){
            return payload.iss == "http://localhost:8000/api/auth/login" || 'https://redstoneresort.in/api/auth/login' ? true : false
        }

        return false
    }

    isValidAdmin(token){
        const payload = this.payload(token);
        if(payload){
            return payload.iss == "http://localhost:8000/api/admin-auth/login" || 'https://redstoneresort.in/api/admin-auth/login' ? true : false
        }

        return false
    }

    payload(token){
        const payload = token.split('.')[1]
        return this.decode(payload)
    }

    decode(payload){
        if(this.isBase64(payload)){
            return JSON.parse(atob(payload))
        }
        return false
    }

    isBase64(str){
        try{
            return btoa(atob(str)).replace(/=/g,"") == str
        }
        catch(err){
            return false
        }
    }
}

export default Token = new Token()