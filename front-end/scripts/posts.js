const isLogged = () => {
  return fetch("http://localhost/api/is_logged")
    .then((res) => res.json())
    .then((data) => data.isLogged)
    .catch((err) => console.error(err));
};

const logout = async () => {
  await fetch("http://localhost/api/logout");
  window.location = "Athentication.html";
};

const submitNewPost = async (e) => {
  e.preventDefault();
  const form = new FormData(e.target);
  fetch("http://localhost/api/add/post", {
    method: "POST",
    body: form,
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      document.getElementById("posts").innerHTML = "";
      printPosts(getPosts);
      window.location = "#posts";
    })
    .catch((error) => {
      console.error("Error:", error);
    });
};

const toggleTheme = () => {
  const theme = document.lastChild.getAttribute("data-theme");
  if (theme == "dark") document.lastChild.setAttribute("data-theme", "light");
  else document.lastChild.setAttribute("data-theme", "dark");
};

const getPosts = async () => {
  return await fetch("http://localhost/api/posts")
    .then((res) => res.json())
    .catch((err) => console.error(err));
};

const printPosts = async (callable) => {
  const posts = await callable();
  let postsContainer = document.getElementById("posts");
  posts.forEach((post) => {
    postsContainer.innerHTML += `
        <a href="post.html?id=${
          post.id
        }" id="post" class="w-11/12 shadow-xl lg:w-9/12 card bg-base-200">
          <figure>
            <img src="${
              post.cover || "https://api.lorem.space/image/movie?w=800&h=625"
            }"/>
          </figure>
          <div class="card-body">
          <div class="flex items-center gap-4" >
            <div class="avatar w-6">
              <div class="rounded-full">
                <img src="https://api.lorem.space/image/face?hash=92310">
              </div>
            </div>
            <p>${post.username}</p>
          </div>
            <p class="text-xs">${post.created_at}</p>
            <h2 class="card-title">${post.title}</h2>
            <p>${post.description}</p>
            <div class="justify-end card-actions">
              <div class="badge badge-outline">scince fiction</div>
            </div>
            <div class="divider"></div>
            <div class="text-xl">${post.comments[0]?.username || ""}</div>
            <p class="text-xs">${post.comments[0]?.created_at || ""}</p>
            <div>${post.comments[0]?.content || ""}</div>
          </div>
        </a>
      `;
  });
};

const init = async () => {
  const logged = await isLogged();
  if (logged) {
    document.getElementById("logout").innerText = "Logout";
    document.getElementById("add-post").classList.remove("hidden");
    document.getElementById("add-post").onsubmit = submitNewPost;
  } else document.getElementById("alert").classList.remove("hidden");
  printPosts(getPosts);
};

init();
