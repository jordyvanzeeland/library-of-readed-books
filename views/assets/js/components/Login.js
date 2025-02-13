import { fetchAction } from "../Functions.js";

const Login = () => {
    const authenticate = async (username, password) => {
        const data = await fetchAction({ 
            action: 'auth', 
            username: username, 
            password: password, 
        });

        if(data.UserID){
            window.location.reload();
        }
    }

    const render = () => {
        const loginForm = document.querySelector('.loginform');

        if(loginForm){
            document.querySelector('.loginform').addEventListener('submit', function(event) {
                event.preventDefault();
                authenticate(event.target.loginmail.value, event.target.loginpass.value);
            });
        }
    }

    return { render }
}

export default Login;