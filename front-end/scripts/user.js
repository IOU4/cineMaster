let toggleTheme = () => {
  const theme = document.lastChild.getAttribute("data-theme");
  if (theme == "dark") document.lastChild.setAttribute("data-theme", "light");
  else document.lastChild.setAttribute("data-theme", "dark");
};
let getUserPosts = async (username) => {
  let posts = await fetch(`http://localhost/api/posts?author=${username}`)
    .then((res) => res.json())
    .catch((err) => console.error(err));
  return posts;
};
let printUserPosts = async (callable, username) => {
  const posts = await callable(username);
  let postsContainer = document.getElementById("posts");
  posts.forEach((post) => {
    postsContainer.innerHTML += `
    <a href="post.html?id=${
      post.id
    }" class="w-11/12 shadow-xl lg:w-9/12 card bg-base-200">
      <figure>
        <img src="https://api.lorem.space/image/movie?w=800&h=625" />
      </figure>
      <div class="card-body">
      <div class="flex gap-4 items-center">
        <div class="w-6 avatar">
          <div class="rounded-full">
            <img src="https://api.lorem.space/image/face?hash=92310">
          </div>
        </div>
        <p>${post.username}</p>
      </div>
        <p class="text-xs">${post.created_at}</p>
        <h2 class="card-title">${post.title}</h2>
        <p>
          ${post.description}
        </p>
        <div class="justify-end card-actions">
          <div class="badge badge-outline">scince fiction</div>
        </div>
        <div class="divider">last</div>
        <div class="text-xl">${post.comments[0]?.username || ""}</div>
        <p class="text-xs">${post.comments[0]?.created_at || ""}</p>
        <div>${post.comments[0]?.content || ""}</div>
      </div>
    </a>
  `;
  });
};

const getUserProfile = async (username) => {
  const user = fetch(`http://localhost/api/user?username=${username}`)
    .then((res) => res.json())
    .catch((err) => console.error(err));
  return user;
};

const printUserProfile = async (callable, username) => {
  let name = document.querySelector("input[name='username']");
  let email = document.querySelector("input[name='email']");
  const user = await callable(username);
  email.setAttribute("value", user.email);
  name.setAttribute("value", user.username);
};

const isLogged = async () => {
  const logged = await fetch("http://localhost/api/is_logged")
    .then((res) => res.json())
    .catch((err) => console.error(err));
  return logged;
};

const logout = async () => {
  await fetch("http://localhost/api/logout");
  window.location = "Athentication.html";
};

const init = async () => {
  const logged = await isLogged();
  const username =
    new URLSearchParams(window.location.search).get("user") ||
    logged.username ||
    "jawad";
  if (logged?.isLogged) document.getElementById("logout").innerText = "Logout";
  printUserProfile(getUserProfile, username);
  printUserPosts(getUserPosts, username);
};

init();
