let showCreateAccout = () => {
  let singupForm = document.getElementById("singup");
  let loginFrom = document.getElementById("login");
  singupForm.className = singupForm.className.replace("hidden", "");
  loginFrom.className += " hidden";
};

let showLogin = () => {
  let singupForm = document.getElementById("singup");
  let loginFrom = document.getElementById("login");
  loginFrom.className = singupForm.className.replace("hidden", "");
  singupForm.className += " hidden";
};

let toggleTheme = () => {
  const theme = document.lastChild.getAttribute("data-theme");
  if (theme == "dark") document.lastChild.setAttribute("data-theme", "light");
  else document.lastChild.setAttribute("data-theme", "dark");
};

const login = async (e) => {
  e.preventDefault();
  const form = new FormData(e.target);
  const res = await fetch("http://localhost/api/login", {
    method: "POST",
    body: form,
  })
    .then((res) => res.json())
    .catch((err) => console.error(err));
  if (res?.logged) window.location = "posts.html";
  else document.getElementById("login-alert").classList.remove("hidden");
};

const singup = async (e) => {
  e.preventDefault();
  const form = new FormData(e.target);
  const res = await fetch("http://localhost/api/singup", {
    method: "POST",
    body: form,
  })
    .then((res) => res.json())
    .catch((err) => console.error(err));
  if (res?.logged) window.location.reload();
  else document.getElementById("singup-alert").classList.remove("hidden");
};

const isLogged = () => {
  return fetch("http://localhost/api/is_logged")
    .then((res) => res.json())
    .then((data) => data.isLogged)
    .catch((err) => console.error(err));
};

const init = async () => {
  const stat = await isLogged();
  if (stat) window.location = "posts.html";
  document.getElementById("login-form").onsubmit = login;
  document.getElementById("singup-form").onsubmit = singup;
};

init();
