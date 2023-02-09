function handleLogout() {
    fetch('logout', {
        headers: {
            'Accept': 'application/json'
        }
    }).then(() => location.reload());
}
const logoutButton = document.querySelector('#logout');
logoutButton.addEventListener('click', handleLogout);