async function handleRegister(event) {
    event.preventDefault();
    const formData = Object.fromEntries(new FormData(registerForm));
    const response = await fetch('register', {
        method: 'post',
        body: JSON.stringify(formData),
        headers: {
            'Accept': 'application/json'
        }
    }).then(response => response.json());

    if (response.errors) {
        showErrors(response.errors, registerForm);
    }
}

async function handleLogin(event) {
    event.preventDefault();
    const formData = Object.fromEntries(new FormData(loginForm));
    const response = await fetch('login', {
        method: 'post',
        body: JSON.stringify(formData),
        headers: {
            'Accept': 'application/json'
        }
    }).then(response => response.json());
    if (response.errors) {
        showErrors(response.errors, loginForm);
    } else {
        location.reload();
    }
}

function showErrors(errors, form) {
    for (let field in errors) {
        form.querySelector(`[name=${field}] + .error-wrapper`)?.remove();
        form.querySelector(`[name=${field}]`).after(createErrorMessages(errors[field]))
    }
}

function createErrorMessages(messages) {
    const node = document.createElement('div');
    node.classList.add('error-wrapper');
    messages.forEach(message => node.append(createMessage(message)));
    return node;
}

function createMessage(message) {
    const node = document.createElement('span');
    node.textContent = message;
    return node;
}
const registerForm = document.querySelector('#register');
registerForm.addEventListener('submit', handleRegister);

const loginForm = document.querySelector('#login');
loginForm.addEventListener('submit', handleLogin);
