// ELEMENTS
const authFormsWrap = document.querySelector('#authFormsWrap');
const loggedInStatus = document.querySelector('#loggedInStatus');
const loginForm = document.querySelector('#frmLogin');
const registerForm = document.querySelector('#frmRegister');
const btnGetResource = document.querySelector('#btnGetResource');
const btnLogout = document.querySelector('#btnLogout');
const btnUpdate = document.querySelector('#btnUpdate');

// DATA
const userEmail = localStorage.getItem('useremail');

if(isLoggedIn()){
    logIn(userEmail);
}

// FUNCTIONS

// check if logged in localstorage
function isLoggedIn() {
    if (userEmail) {
      return true;
    } else {
      return false;
    }
  };

// update isLoggedIn
function logIn(userEmail) {
  localStorage.setItem('useremail', userEmail);
  authFormsWrap.style.display = 'none';
  loggedInStatus.style.display = 'flex';
  loggedInStatus.innerText = 'Logged in as: ' + userEmail;
  btnLogout.style.display = 'block';
}

function logOut() {
  localStorage.removeItem('useremail');
  authFormsWrap.style.display = 'flex';
  loggedInStatus.style.display = 'none';
  btnLogout.style.display = 'none';
}

// EVENTS

// login
loginForm.addEventListener('submit', async (e) => {
  e.preventDefault();
  const res = await fetch('./public/login.php', {
    method: 'POST',
    headers: {
      'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8',
    },
    body: JSON.stringify({
      email: loginForm.inputEmail.value,
      password: loginForm.inputPassword.value,
    }),
  });

  if (res.status >= 200 && res.status <= 299) {
    const responsedata = await res.text();
    const responsedatajson = JSON.parse(responsedata);
    console.log(responsedatajson.notes);
    storeJWT(responsedatajson.jwt);
  } else {
    // Handle errors
    console.log(res.status, res.statusText);
  }
});

// register
registerForm.addEventListener('submit', async (e) => {
  e.preventDefault();
  fetch('/public/register.php', {
    method: 'POST',
    headers: {
      Accept: 'application/json',
    },
    body: JSON.stringify({
      email: registerForm.inputEmail.value,
      password: registerForm.inputPassword.value,
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
