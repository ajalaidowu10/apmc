import User from './User';

class Exception{
    handle(error, role){
        if (role == 'admin') {
            this.isExipredAdmin(error.response.data.error);
        }else{
            this.isExipred(error.response.data.error);
        }
        
    }

    isExipred(error){
        if(error == 'Token is invalid' || 'Token is expired' ){
            User.logout()
        }else{
        	swal('Notification', error);
        }
    }

    isExipredAdmin(error){
        if(error == 'Token is invalid' || 'Token is expired' ){
            Admin.logout()
        }else{
            swal('Notification', error);
        }
    }
}

export default Exception = new Exception()