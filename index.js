// ELEMENTS
const authFormsWrap = document.querySelector('#authFormsWrap');
const loggedInWrap = document.querySelector('#loggedInWrap');
const loggedInStatus = document.querySelector('#loggedInStatus');
const loginForm = document.querySelector('#frmLogin');
const loginErrorWrap = document.querySelector('#loginErrorWrap');
const registerForm = document.querySelector('#frmRegister');
const registerErrorWrap = document.querySelector('#registerErrorWrap');
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
}

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
      email: userEmail,
    }),
  }).then((res) => {
    localStorage.removeItem('useremail');
    authFormsWrap.style.display = 'flex';
    loggedInWrap.style.display = 'none';
  });
}
// #endregion

// #region EVENTS
// on init
if (isLoggedIn()) {
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
  })
    .then((res) => {
      if (!res.ok) {
        return res.text().then((text) => {
          throw new Error(text);
        });
      } else {
        return res.json();
      }
    })
    .then((res) => {
      loginErrorWrap.innerText = '';
      logIn(res.email);
    })
    .catch((error) => {
      loginErrorWrap.innerText = error.message;
    });
});

// register form submit
registerForm.addEventListener('submit', async (e) => {
  e.preventDefault();
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
      if (!res.ok) {
        return res.text().then((text) => {
          throw new Error(text);
        });
      } else {
        return res.json();
      }
    })
    .then((res) => {
      registerErrorWrap.innerText = '';
      logIn(res.email);
    })
    .catch((error) => {
      registerErrorWrap.innerText = error.message;
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
