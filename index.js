// ELEMENTS
const authFormsWrap = document.querySelector('#authFormsWrap');
const loggedInWrap = document.querySelector('#loggedInWrap');
const loggedInStatus = document.querySelector('#loggedInStatus');
const loginForm = document.querySelector('#frmLogin');
const registerForm = document.querySelector('#frmRegister');
const btnLogout = document.querySelector('#btnLogout');
const btnUpdate = document.querySelector('#btnUpdate');

// DATA
const userEmail = localStorage.getItem('useremail');


// #region FUNCTIONS 

// check if logged in localstorage
function isLoggedIn() {
    if (userEmail) {
      return true;
    } else {
      return false;
    }
  };

function logIn(userEmail) {
  localStorage.setItem('useremail', userEmail);
  authFormsWrap.style.display = 'none';
  loggedInWrap.style.display = 'block';
  loggedInStatus.innerText = 'Logged in as: ' + userEmail;
}

function logOut() {
  fetch('./public/logout.php', {
      method: 'POST',
      headers: {
        Accept: 'application/json',
      },
      credentials: 'include',
      body: JSON.stringify({
        email: userEmail
      }),
    }).then((res)=>{
      localStorage.removeItem('useremail');
      authFormsWrap.style.display = 'flex';
      loggedInWrap.style.display = 'none';
    })
}
// #endregion

// #region EVENTS
// on init
if(isLoggedIn()){
  logIn(userEmail);
}

// login form submit
loginForm.addEventListener('submit', async (e) => {
  e.preventDefault();
  fetch('./public/login.php', {
    method: 'POST',
    headers: {
      'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8',
    },
    body: JSON.stringify({
      email: loginForm.loginInputEmail.value,
      password: loginForm.loginInputPassword.value,
    }),
  }).then((res)=>{
        if (!res.ok) throw new Error(res.status);
        else return res.json();
  }).then((res) => {
    logIn(res.email);
});;
});

// register form submit
registerForm.addEventListener('submit', async (e) => {
  e.preventDefault();
  console.log(e)
  fetch('/public/register.php', {
    method: 'POST',
    headers: {
      Accept: 'application/json',
    },
    body: JSON.stringify({
      email: registerForm.registerInputEmail.value,
      password: registerForm.registerInputPassword.value,
    }),
  })
    .then((res) => {
      if (!res.ok) throw new Error(res.status);
      else return res.json();
    })
    .then((res) => {
        logIn(res.email);
    });
});

// Log out
btnLogout.addEventListener('click', async (e) => {
  fetch('./public/logout.php', {
    method: 'POST',
  }).then((res) => {
    logOut();
  });
});

// #endregion
